<?php

namespace App\Http\Controllers\WEB;

use App\Events\GateNotification;
use App\Models\QR;
use Carbon\Carbon;
use App\Models\Biaya;
use App\Models\Scanplat;
use App\Models\AccessLog;
use App\Events\GateOpened;
use App\Models\ConfigHarga;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Auth;

class ValidasiController extends Controller
{
    
    public function processIn(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required',
            'plat_masuk' => 'nullable',
            'gambar_in' => 'image|nullable|file|max:1024',
        ]);


        //mencek apakah kode terdaftar
        $cekcode = QR::where('code', $validatedData['code'])->first();

        $cekplat = QR::where('no_plat', $validatedData['plat_masuk'])->first();
 
        $kategori = $cekcode->kategori;
        
        if($cekcode)
        {
            $date = Carbon::now();
            //cek apakah code punya mahasiswa atau tamu

            if($kategori === 'pengguna')
            {
                $validatedData['gambar_in'] = $request->file('gambar_in')->store('plat-images');
                $validasiqr = AccessLog::create([
                    'q_r_id' => $cekcode->id,
                    'code' => $validatedData['code'],
                    'no_plat'=>$cekcode->no_plat,
                    'date' => $date->toDateString(),
                    'time_masuk' => $date->toTimeString(),
                    'status_in' => 'Valid QR Code'
                ]);

                if($cekplat)
                {
                    //code dan plat dipunyai oleh orang yang sama
                    if ($cekcode->no_plat == $validatedData['plat_masuk'])
                    {
                        $validatedData['gambar_in'] = $request->file('gambar_in')->store('plat-images');
                        
                        $scanplat = Scanplat::create([
                            'log_id' => $validasiqr->id,
                            'no_plat' => $validasiqr->no_plat,
                            'plat_masuk' => $validatedData['plat_masuk'],
                            'similarity_masuk'=> self::checkStringSimilarity($validatedData['plat_masuk'], $validasiqr->no_plat),
                            'gambar_in' => $validatedData['gambar_in'],
                            'date'=> $validasiqr->date,
                            'tcek_masuk' => $validasiqr->time_masuk,
                            'status_in' => 'Valid QR dan Plat',

                        ]);
            
                        return response()->json(['status' => 'success', 'message' => 'Valid QR dan Plat']); 

                    }
                    //jika plat dan code ada namun berbeda pengguna
                    elseif ($cekcode->no_plat !== $validatedData['plat_masuk']) 
                    {
                        $validatedData['gambar_in'] = $request->file('gambar_in')->store('plat-images');
                        $scanplat = Scanplat::create([
                            'log_id' => $validasiqr->id,
                            'no_plat' => $validasiqr->no_plat,
                            'plat_masuk'=>$validatedData['plat_masuk'],
                            'similarity_masuk'=> self::checkStringSimilarity($validatedData['plat_masuk'], $validasiqr->no_plat),
                            'gambar_in' => $validatedData['gambar_in'],
                            'date'=> $validasiqr->date,
                            'tcek_masuk' => $validasiqr->time_masuk,
                            'status_in' => 'Valid QR dan Plat',

                        ]);
                        $checkStringSimilarity = $scanplat->similarity_masuk;

                        return response()->json(['status' => 'success', 'message' => $checkStringSimilarity]); 
                        
                        // return redirect('/dashboard/valid')->with('success','QR code dan Plat tidak cocok');
                        
                    }

                }
                //jika plat yang di scan tidak ada di database
                elseif ($cekplat === null) {
                    $masuk = Scanplat::create([
                        'log_id' => $validasiqr->id,
                        'no_plat' => $validasiqr->no_plat,
                        'plat_masuk'=>$validatedData['plat_masuk'],
                        'similarity_masuk'=> self::checkStringSimilarity($validatedData['plat_masuk'], $validasiqr->no_plat),
                        'gambar_in' => $validatedData['gambar_in'],
                        'date'=> $validasiqr->date,
                        'tcek_masuk' => $validasiqr->time_masuk,
                        'status_in' => 'Plat tidak ditemukan di database',
                    ]);

                    $checkStringSimilarity = $masuk->similarity_masuk;
                    return response()->json(['status' => 'success', 'message' => $checkStringSimilarity, 'Note' => 'Plat Tidak Valid']); 
                }

            }elseif ($kategori === 'tamu') {
                $masuk = AccessLog::create([
                    'q_r_id' => $cekcode->id,
                    'plat_id' => 'XXXXXX', 
                    'code' => $validatedData['code'],
                    'date' => $date->toDateString(),
                    'time_masuk' => $date->toTimeString(),
                    'status_in' => 'Valid'
                ]);
                return response()->json(['status' => 'success', 'message' => 'Plat Valid']); 
            }
        }

        else
        {
            return redirect('/dashboard/valid')->with('success', 'Silahkan daftar terlebih dahulu');
        }
    }

    // public function processOut(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'code' => 'required',
    //         'plat_keluar' => 'nullable',
    //         'gambar_out' => 'image|nullable|file|max:1024',
    //     ]); 

        
    //     $cekplat = Scanplat::where('plat_masuk', $validatedData['plat_keluar'])->first();

    //     $ceklog = AccessLog::where('date', Carbon::today())
    //                         ->where('code', $validatedData['code'])
    //                         ->latest('time_masuk')
    //                         ->first();

    //     $accessLogId = $ceklog->id;

    //     $cekscanplat = Scanplat::where('date', Carbon::today())
    //                             ->where('plat_masuk', $validatedData['plat_keluar'])
    //                             ->latest('tcek_masuk')
    //                             ->first();

    //     $kategori = $ceklog->qrcode->kategori;


    //     $date = Carbon::now();     
    //     if ($accessLogId === null ){
    //         return response()->json(['status'=>'Fail']);
    //     } 

    //     //cek log apakah code ada didatabase
    //     if ($ceklog) {
    //         $ceklog->time_keluar = Carbon::now()->toTimeString();
    //         $time_masuk = Carbon::parse($ceklog->time_masuk);
    //         $ceklog->status_out = 'Valid QR';
    //         $ceklog->waktu = $time_masuk->diffInMinutes($ceklog->time_keluar);
    //         $ceklog->save();
    //         $biaya = self::processPayment($accessLogId);

            
    //         //jika pengguna
    //         if ($kategori === 'pengguna') 
    //         {
    //             if ($cekplat) {
    //                 //jika plat keluar ada didatabase scan plat dan data di scanplat sama dengan plat yang dikirim
    //                 if ($cekscanplat && $cekscanplat->peristiwa->exists() && $cekscanplat->peristiwa->id == $ceklog->id)
    //                     {
    //                         $gambarout = $validatedData['gambar_out'] = $request->file('gambar_out')->store('plat-images');
    //                         $checkStringSimilarity = self::checkStringSimilarity($validatedData['plat_keluar'], $cekscanplat->plat_masuk);
    //                         $cekscanplat->tcek_keluar = Carbon::now()->toTimeString();
    //                         $cekscanplat->similarity_keluar = $checkStringSimilarity;
    //                         $cekscanplat->plat_keluar = $validatedData['plat_keluar'];
    //                         $cekscanplat->gambar_out = $gambarout;
    //                         $cekscanplat->status_out = 'Plat yang masuk dan keluar sama';
    //                         $cekscanplat->save();   
    //                         $datasend = [
    //                             'no_plat' =>$cekscanplat->plat_keluar,
    //                             'time'=>$cekscanplat->tcek_keluar,
    //                             'message' => $cekscanplat->peristiwa->qrcode->pengguna->name, 'baru saja mas'
    //                         ];
    //                         event(new GateNotification($datasend));                    
    //                         return response()->json(['status' => 'success', 'message' => 'QR dan Plat yang masuk dan keluar sama']); 
    //                         return redirect('/dashboard/valid')->with('success', 'Valid Plat dan QR');
    //                     }                
    
    //                 //jika plat yang masuk dan code ada namun berbeda pengguna
    //                 elseif ($cekscanplat && $cekscanplat->peristiwa->exists() && $cekscanplat->peristiwa->id != $cekplat->id) 
    //                 {
    //                     $accessLogId = $ceklog->id;
    //                     $scanplatToUpdate = Scanplat::where('log_id', $accessLogId)->latest('time_masuk')->first();
    //                     if ($scanplatToUpdate){
    //                         $gambarout = $validatedData['gambar_out'] = $request->file('gambar_out')->store('plat-images');
    //                         $checkStringSimilarity = self::checkStringSimilarity($validatedData['plat_keluar'], $scanplatToUpdate->plat_masuk);
    //                         $scanplatToUpdate->tcek_keluar  = Carbon::now()->toTimeString();
    //                         $scanplatToUpdate->plat_keluar = $validatedData['plat_keluar'];
    //                         $scanplatToUpdate->gambar_out = $gambarout;
    //                         $scanplatToUpdate->status_out = 'Plat yang masuk dan keluar berbeda';
    //                         $scanplatToUpdate->similarity_keluar = $checkStringSimilarity;
    //                         $scanplatToUpdate->save();
    //                         $datasend = [
    //                             'no_plat' =>$cekscanplat->plat_keluar,
    //                             'time'=>$cekscanplat->tcek_keluar,
    //                             'message' => $cekscanplat->peristiwa->qrcode->pengguna->name, 'baru saja masuk'
    //                         ];
    //                         event(new GateNotification($datasend));
    //                         return response()->json(['status' => 'success', 'message' => 'QR valid tapi berbeda kendaraan']); 

    //                         return redirect('/dashboard/valid')->with('success', 'Valid QR tapi berbeda kendaraan ');
    //                     }
    //                 }
    //             }

    //             elseif ($cekplat == null){
    //                 $accessLogId = $ceklog->id;                   
    //                 $scanplatToUpdate = Scanplat::where('log_id', $accessLogId)->latest('tcek_masuk')->first();;

    //                 if ($scanplatToUpdate) {
    //                     $gambarout = $validatedData['gambar_out'] = $request->file('gambar_out')->store('plat-images');
    //                     $scanplatToUpdate->tcek_keluar  = Carbon::now()->toTimeString();
    //                     $scanplatToUpdate->plat_keluar = $validatedData['plat_keluar'];
    //                     $scanplatToUpdate->gambar_out = $gambarout;
    //                     $checkStringSimilarity = self::checkStringSimilarity($validatedData['plat_keluar'], $scanplatToUpdate->plat_masuk);      
    //                     $scanplatToUpdate->status_out = 'Plat yang masuk dan keluar berbeda';
    //                     $scanplatToUpdate->similarity_keluar = $checkStringSimilarity;
    //                     $scanplatToUpdate->save();
    //                     $datasend = [
    //                         'no_plat' =>$scanplatToUpdate->plat_keluar,
    //                         'time'=>$scanplatToUpdate->tcek_keluar,
    //                         'message' => $scanplatToUpdate->peristiwa->qrcode->pengguna->name, 'baru saja mas'
    //                     ];
    //                     event(new GateNotification($datasend));  
    //                     return response()->json(['status' => 'success', 'message' => 'Plat berbeda masuk dan keluar']);
    //                 }
    //             }
    //         }

    //         elseif ($kategori === 'tamu') {

    //             $ceklog->time_keluar  = Carbon::now()->toTimeString();
    //             $time_masuk = Carbon::parse($ceklog->time_masuk);
    //             $ceklog->waktu = $time_masuk->diffInMinutes($ceklog->time_keluar);
    //             $ceklog->plat_masuk = 'XXXXX';
    //             $ceklog->save();

    //             return response()->json(['status' => 'success', 'message' => 'Harap mengembalikan QR']); 
    //             return redirect('/dashboard/riwayat')->with('success', 'Harap mengembalikan QR');

    //         }
    //     }
    //      //jika tidak ada qr yang terdaftar
    //     elseif($ceklog == null){
    //         return response()->json(['status' => 'fail', 'message' => 'Tidak bisa keluar']); 
    //         return redirect('/dashboard/valid')->with('success', 'tidak bisa keluar karena akses sebelumnya belum keluar');
    //     }
    // }

    public function processOut(Request $request){
        $validatedData = $request->validate([
            'code' => 'required',
            'plat_keluar' => 'nullable',
            'gambar_out' => 'image|null|file|max: 1024'
        ]);
        $date =Carbon::now();
        
        $ceklog = AccessLog::where('date', Carbon::today())
                            ->where('code', $validatedData['code'])
                            ->latest('time_masuk')
                            ->first();

        if (!$ceklog) {
            return response()->json(['status' => 'fail', 'message'=> 'QR tidak ditemukan']);

        }

        $cekplat = Scanplat::where('plat_masuk', $validatedData['plat_keluar'])->first();
        $cekscanplat = Scanplat::where('date', Carbon::today())
                                ->where('plat_masuk', $validatedData['plat_keluar'])
                                ->latest('tcek_masuk')
                                ->first();

        $kategori = $ceklog->qrcode->kategori;
        $ceklog->time_keluar = Carbon::now()->toTimeString();
        $ceklog->status_out = 'Valid QR';
        $ceklog->waktu = Carbon::parse($ceklog->time_masuk)->diffInMinutes($ceklog->time_keluar);
        $ceklog->save();

        $biaya = self::processPayment($ceklog->id);
        
        if($kategori == 'pengguna'){
            $gambarout = $validatedData['gambar_out'] ? $request->file('gambar_out')->store('plat-images') : null;

            if ($cekplat) {
                if ($cekscanplat && $cekscanplat->peristiwa->exists() && $cekscanplat->peristiwa->id == $ceklog->id) {
                    $this->updateScanPlat($cekscanplat, $validatedData['plat_keluar'], $gambarout, 'Plat yang masuk dan keluar sama');
                    return $this->sendResponse($cekscanplat, 'QR dan Plat yang masuk dan keluar sama', 'Valid Plat dan QR');
                } elseif ($cekscanplat && $cekscanplat->peristiwa->exists() && $cekscanplat->peristiwa->id != $ceklog->id) {
                    $this->updateScanPlat($cekscanplat, $validatedData['plat_keluar'], $gambarout, 'Plat yang masuk dan keluar berbeda');
                    return $this->sendResponse($cekscanplat, 'QR valid tapi berbeda kendaraan', 'Valid QR tapi berbeda kendaraan');
                }
            } else {
                $this->updateScanPlat($cekscanplat, $validatedData['plat_keluar'], $gambarout, 'Plat yang masuk dan keluar berbeda');
                return $this->sendResponse($cekscanplat, 'Plat berbeda masuk dan keluar', 'Plat berbeda masuk dan keluar');
            }
        } elseif ($kategori === 'tamu') {
            $ceklog->plat_masuk = 'XXXXX';
            $ceklog->save();
            return response()->json(['status' => 'success', 'message' => 'Harap mengembalikan QR']);
        }
  
    }

    private function updateScanPlat($scanplat, $plat_keluar, $gambarout, $status_out){

        $checkStringSimilarity = self::checkStringSimilarity($plat_keluar, $scanplat->plat_masuk);
        $scanplat->tcek_keluar = Carbon::now()->toTimeString();
        $scanplat->similarity_keluar = $checkStringSimilarity;
        $scanplat->plat_keluar = $plat_keluar;
        $scanplat->gambar_out = $gambarout;
        $scanplat->status_out = $status_out;
        $scanplat->save();
        
    }

    private function sendResponse($scanplat, $jsonMessage, $redirectMessage){
        $datasend = [
            'no_plat' => $scanplat->plat_keluar,
            'time' => $scanplat->tcek_keluar,
            'message' => $scanplat->peristiwa->qrcode->pengguna->name . ' baru saja mas'
        ];
        event(new GateNotification($datasend));
        return response()->json(['status' => 'success', 'message' => $jsonMessage])
               ->header('Location', url('/dashboard/valid'))
               ->with('success', $redirectMessage); 
    }



    public function showForm()
    {
        $prefix = Auth::user()->role === 'admin' ? 'admin.' : 'manajemen.';
        return view($prefix. 'inout.valid');
    }

    public function laporan()
    {
        $prefix = Auth::user()->role === 'admin' ? 'admin.' : 'manajemen.';
        $scanplat = Scanplat::orderBy('date', 'desc')->orderBy('tcek_masuk', 'desc')->paginate(12);

        return view($prefix. 'inout.laporan', compact('scanplat'));
    }

    public function cari(Request $request)
    {
        // $cari = $request->input('cari');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $slotTersedia = self::slotCount();
    
        // Query dasar untuk pencarian
        $riwayat = Scanplat::query();
    
        // Filter berdasarkan kolom yang diberikan
        // if ($cari) {
        //     $riwayat->where(function ($query) use ($cari) {
        //         $query->where('no_plat', 'like', '%' . $cari . '%')
        //             ->orWhere('plat_masuk', 'like', '%' . $cari . '%')
        //             ->orWhere('plat_keluar', 'like', '%' . $cari . '%');
        //     })->orWhereHas('peristiwa', function ($query) use ($cari) {
        //         $query->where('code', 'like', '%' . $cari . '%')
        //             ->orWhereHas('qrcode', function ($query) use ($cari){
        //                 $query->where('code', 'like', '%' . $cari . '%')
        //                 ->orWhereHas('pengguna', function ($query) use ($cari) {
        //                     $query->where('name', 'like', '%' . $cari . '%');

        //             });
        //         });
        //     });
        // }
    
        // Filter berdasarkan rentang tanggal jika tersedia
        if ($startDate && $endDate) {
            $riwayat->whereBetween('date', [$startDate, $endDate]);
        }
    
        // Ambil data yang cocok dengan kueri
        $scanplat = $riwayat->paginate(11);
    
        // Kembalikan data ke tampilan
        $prefix = Auth::user()->role === 'admin' ? 'admin.' : 'manajemen.';
        return view($prefix. 'inout.laporan', compact('scanplat','startDate', 'endDate'));
    }

    public static function slotCount() {
        $slot = "200";
        $countIn = AccessLog::whereNotNull('time_masuk')->count();
        $countOut = AccessLog::whereNotNull('time_keluar')->count();
        $slotTersedia = $slot - ($countIn - $countOut);
        return $slotTersedia;
    }

    public static function checkStringSimilarity($a, $x){
        //fungsi similarity
        $len = strlen($x);
        $similarityCount = 0;
        
        for ($i = 0; $i < $len; $i++) {
            if (isset($x[$i]) && $a[$i] === $x[$i]) {
                $similarityCount++;
            } else {
                break; 
            }
        }

        $similarityPercentage = ($similarityCount / $len) * 100 ;
        $similarityStringPercentage = strval($similarityPercentage);
        
        return $similarityStringPercentage;
    }

    public static function processPayment($accessLogId)
    {
        // Ambil data access log dari database
        $parkirConfig = ConfigHarga::find(1);
        $accessLog = AccessLog::find($accessLogId);
    
        if ($accessLog !== null) {
            // Konversi waktu masuk dan waktu keluar ke objek Carbon
            $time_masuk = new Carbon($accessLog->time_masuk);
            $time_keluar = new Carbon($accessLog->time_keluar);
            
            // Hitung durasi dalam jam
            $duration = $time_masuk->diffInHours($time_keluar);
    
            // Jika durasi adalah 0, atur durasi menjadi 1
            if ($duration == 0) {
                $duration = 1;
            }
            
            // Inisialisasi harga awal
            $price = $parkirConfig->harga_jam_pertama;
            
            // Jika durasi melebihi 1 jam, tambahkan harga untuk jam-jam tambah
            if ($duration > 1) {
                $price += ($duration - 1) * $parkirConfig->harga_per_jam;
            }
    
            $existingPayment = Biaya::where('log_id', $accessLogId)->first();
            if ($existingPayment !== null) {
                if ($accessLog->time_keluar !== null) {
                    $existingPayment->biaya = $price;
                    $existingPayment->save();
                }
            } else {
                $payment = Biaya::create([
                    'log_id' => $accessLogId,
                    'biaya' => $price,
                ]);
            }
        }
    }
    

    public function cetakpdf(){
        $laporan = Scanplat::all();
    
        $pdf = FacadePdf::loadView('manajemen.inout.laporan_pdf', ['laporan' => $laporan])->setPaper('a4', 'landscape');
    
        return $pdf->stream('laporan-pdf');
    }

    public function cariFilterPdf(Request $request)
    {
        $cari = $request->input('cari');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $slotTersedia = self::slotCount();
    
        // Query dasar untuk pencarian
        $riwayat = Scanplat::query();
    
        // Filter berdasarkan rentang tanggal jika tersedia
        if ($startDate && $endDate) {
            $riwayat->whereBetween('date', [$startDate, $endDate]);
        }
    
        // Ambil data yang cocok dengan kueri
        $laporan = $riwayat->get();

        $pdf = FacadePdf::loadView('manajemen.inout.laporan_pdf', ['laporan' => $laporan])->setPaper('a4', 'landscape');
    
        return $pdf->stream('laporan-pdf');
    }

    

  
    
    
}
