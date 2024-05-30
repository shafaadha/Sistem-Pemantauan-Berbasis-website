<?php

namespace App\Http\Controllers\WEB;

use App\Models\QR;
use Pusher\Pusher;
use App\Models\Plat;
use App\Models\Pengguna;
use App\Events\postCreated;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePenggunaRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Requests\UpdatePenggunaRequest;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Pagination\LengthAwarePaginator;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = Auth::user()->role === 'admin' ? 10 : 10;
        $penggunas = Pengguna::latest()->paginate($perPage);   
        $prefix = Auth::user()->role === 'admin' ? 'admin.' : 'manajemen.';
        return view($prefix. 'pengguna.index', ['penggunas' => $penggunas]);
    //     $penggunas = Pengguna::latest()->get();
    //     return view('manajemen.pengguna.index', compact('penggunas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePenggunaRequest $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Pengguna $pengguna)
    {
        return view('manajemen.pengguna.show')->with('pengguna', $pengguna);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengguna $pengguna)
    {
        $kategori = old('kategori');

        return view('manajemen.pengguna.edit')->with('pengguna', $pengguna, 'kategori');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenggunaRequest $request, Pengguna $pengguna, QR $qr)
    {
        if (!$request->filled('kategori')) {
            return redirect()->back()->withErrors('Kategori harus dipilih.')->withInput();
        }
        
           $validatedData = $request->validate([
            'name' => 'required|max:225',
            'nim' => 'required|unique:penggunas,nim,' . $pengguna->id,
            'phone_number' => 'nullable|max:225',
            'jurusan' => 'nullable',
            'alamat' => 'nullable|max:225',
            'orang_tua' => 'nullable|max:225',
            'no_plat' => 'nullable|max:225',
            'kategori' => 'nullable|max:225',
            ], [
                'nim.unique' => 'NIM sudah didaftarkan!!',
            ]);

        
            if ($request->no_plat != $pengguna->qrcode->no_plat) {
                $uniqueNoPlat = QR::where('no_plat', $request->no_plat)->where('id', '!=', $pengguna->qrcode->id)->exists();
            
                if ($uniqueNoPlat) {
                    return redirect()->back()->withErrors('Nomor plat sudah digunakan. Silahkan gunakan nomor plat lain.')->withInput();
                }
            }
        


        if ($pengguna->update($validatedData)) {
               
            if ($request->kategori != $pengguna->qrcode->kategori) {
                $pengguna->qrcode->update(['kategori' => $request->kategori]);
            }
    
            return redirect('/manajemen/penggunas')->with('success', 'Data pengguna telah diupdate');
        }

        return redirect()->back()->withErrors('Gagal memperbarui data. Silahkan coba lagi')->withInput();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengguna $pengguna)
    {
        $pengguna->delete();
        return redirect('/manajemen/penggunas')->with('success', 'Data telah terhapus');
    }

    public function cetakqr(Pengguna $pengguna){
        
        $qrcode = base64_encode(QrCode::format('svg')->size(200)->generate($pengguna->qrcode->code));
        $nim = $pengguna->nim;
        $data = [
            'qrcode'=>$qrcode,
            'nim'=>$nim

        ];
        
        //$pdf = FacadePdf::w('manajemen.pengguna.cetak', array('pengguna'=>$pengguna));
        $pdf = FacadePdf::loadView('manajemen.pengguna.cetakqr', $data);
        return $pdf->stream('Kartu-QR.pdf');
    }

    public function cari(Request $request)
    {
        $cari = $request->input('cari');
    
        $penggunas = Pengguna::where(function($query) use ($cari) {
            $query->where('name', 'like', '%' . $cari . '%')
                  ->orWhere('nim', 'like', '%' . $cari . '%')
                  ->orWhere('jurusan', 'like', '%' . $cari . '%')
                  ->orWhere('phone_number', 'like', '%' . $cari . '%');
        })
        ->orWhereHas('qrcode', function ($query) use ($cari) {
            $query->where('no_plat', 'like', '%' . $cari . '%');
        })
        ->paginate(10); 
    
    
        return view('manajemen.pengguna.index', compact('penggunas', 'cari'));
    }

    public function processForm(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:225|unique:penggunas',
            'nim' => 'required|unique:penggunas,nim',
            'phone_number' => 'required|max:225',
            'kategori' => 'required|max:225',
            'jurusan' => 'required|max:225',
            'alamat' => 'nullable|max:225',
            'orang_tua' => 'nullable|max:225',
            'jurusan' => 'required|max:225',
            'code' => 'required',
            'no_plat' => 'required|unique:q_r_s',
        ],[
            'name.unique' => 'Nama sudah didaftarkan!!',
            'nim.unique' => 'NIM sudah didaftarkan!!',
            'no_plat.unique' => 'Nomor plat sudah didaftarkan!!'
        ]);

        $pengguna = Pengguna::create([
            'name' =>$validatedData['name'],
            'nim' =>$validatedData['nim'],
            'phone_number' =>$validatedData['phone_number'],
            'jurusan' =>$validatedData['jurusan'],
            'alamat' =>$validatedData['alamat'],
            'orang_tua' =>$validatedData['orang_tua'],



        ]);
        $qrcode = new QR([
            'code' =>$validatedData['code'],
            'no_plat'=>$validatedData['no_plat'],
            'kategori' =>$validatedData['kategori'],

        ]);

        $pengguna->qrcode()->save($qrcode);

        return redirect('/manajemen/penggunas')->with('success', 'Data pengguna telah ditambahkan');

    }

    public function showForm()
    {
        return view('manajemen.pengguna.create');
    }

    public function cetakpengguna()
    {
        $penggunas = Pengguna::all();
        $pdf = FacadePdf::loadView('manajemen.pengguna.cetak', ['penggunas' => $penggunas])->setPaper('a4', 'potrait');
        return $pdf->stream('laporan-pdf');
    }
    
}
