@extends('manajemen.layouts.main')

@section('container')
    <title>Data Pengguna</title>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border bottom">
        <h1 class="h2 mb-2">Data Pengguna</h1>
    </div>

    <div class="row">
        <div class="col-md-5 col-sm-6 mb-3 p-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">{{ $pengguna->name }}</h2>
                    <p class="card-text">
                        <strong>NIM:</strong> {{ $pengguna->nim }}<br>
                        <strong>Nomor Telephone:</strong> {{ $pengguna->phone_number }}<br>
                        <strong>Plat Kendaraan:</strong> {{ $pengguna->qrcode->no_plat }}<br>
                        <strong>Alamat:</strong> {{ $pengguna->alamat }}<br>
                        <strong>Orang Tua:</strong> {{ $pengguna->orang_tua }}<br>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-7 col-sm-12 center-block p-4" style="display: flex; flex-direction: column; align-items: center;">
            <div class="card">
                <div class="card-body">
                    <div style="margin-bottom: 20px;">
                        {!! QrCode::size(200)->generate($pengguna->qrcode->code) !!}
                    </div>
                    <div style="text-align: center;">
                        <a class="btn btn-primary" href="{{ route('cetakqr', ['pengguna' => $pengguna->nim]) }}" target="_blank"><i class="fa fa-print"></i> Cetak PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
