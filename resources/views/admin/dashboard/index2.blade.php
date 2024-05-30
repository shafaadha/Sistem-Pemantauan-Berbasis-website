@extends('admin.layouts.main')
@section('container')
<title>Dashboard</title>

<div class="container">
    <div class="row">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
        </div>
    </div>

    <div class="row" style="center">
        <div class="col-lg-6 col-md-7">
            <div class="card mb-3" style="width: 100%; margin: auto;">
                <canvas style="position: center;" id="chartJumlahMasuk"></canvas>
            </div>
        </div>
        <div class="col-lg-6 col-md-7">
            <div class="card mb-3" style="width: 100%; margin: auto;">
                <canvas style="position: center;" id="chartPayments"></canvas>
            </div>
        </div>
    </div>
    
    <div class="row" style="position: center">
        <div class="col-lg-3 col-md-6">
            <div class="card border-dark mb-3" style="width: 100%;">
                <div class="card-body">
                    <h5 class="card-title">Jam Saat Ini</h5>
                    <p class="card-text" id="realtime-clock"></p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4">
            <div class="card border-dark mb-3" style="width: 100%;">
                <div class="card-body">
                    <h4 class="card-title">Pengguna</h4>
                    <h5 class="card-text">{{ $pengguna_count }}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            <div class="card border-dark mb-3" style="width: 100%;">
                <div class="card-body">
                    <p class="card-title" id="slot"></p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-dark mb-3" style="width: 100%;">
                <div class="card-body">
                    <p id="totalPendapatan"></p>
                    <p id="jumlahTransaksi"></p>
                    <a href="{{ route('admin.pembayaran.now') }}" class="btn btn-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
        
    </div>
    
    <div class="row">


    </div>

    <div id="notification-container" class="notification-container"></div>
</div>
    

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="js/script.js"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
 
@endsection
