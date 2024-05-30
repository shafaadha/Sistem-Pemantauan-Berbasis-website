<?php

namespace App\Http\Controllers\WEB;

use App\Models\QR;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QRController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $qrcodes = QR::all();
        $penggunas = Pengguna::all();
        return view('dashboard.qr.index', compact('qrcodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.qr.create',[
            'penggunas'=> Pengguna::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required',
            'pengguna_id' => 'required',
        ]);
        QR::create($validatedData);
        return redirect('/qrs')->with('success', 'QR Code telah berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(QR $qR)
    {
        return view('qrcode',[
            'qrcode'=>$qR
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QR $qR)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QR $qR)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QR $qR)
    {
        //
    }
}
