@extends('admin.layouts.main')
@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border bottom">
    <h1 class="h2 mb-2">Dashboard</h1>
</div>

<div class="row">   
    <div class="col-lg-4">
        <div class="card text-white bg-primary mb-3" style="width: 20rem;">
            <div class="card-body">
                <h4 class="card-title">Pengguna</h4>
                <h5 class="card-count">{{ $pengguna_count }}</h5>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card text-white bg-success mb-3" style="width: 20rem;">
            <div class="card-body">
                <h4 class="card-title">Masuk</h4>
                <h5 class="card-count">{{ $jumlah_masuk }}</h5>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card text-white bg-danger mb-3" style="width: 20rem;">
            <div class="card-body">
                <h4 class="card-title">Keluar</h4>
                <h5 class="card-count">{{ $jumlah_keluar }}</h5>
            </div>
        </div>
    </div>
@endsection
