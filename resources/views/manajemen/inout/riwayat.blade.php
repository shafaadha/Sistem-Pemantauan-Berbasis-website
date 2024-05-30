@extends('manajemen.layouts.main')
@section('container')
<title>Laporan</title>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border bottom">
    <h1 class="h2 mb-2">Activity Gate</h1>
</div>

@if(session()->has('success'))
<div class="alert alert-success" role="alert">
  {{ session('success') }}
</div>
@endif

<div class="row">
    <div class="col-lg-6 col-sm-12 mt-3">
        <form action="/riwayat/cari">
            <div class="input-group">
                <input class="form-control border-end-0 border rounded-pill" name="start_date" type="date" value="{{ old('start_date', isset($start_date) ? $start_date: '') }}">
                <input class="form-control border-end-0 border rounded-pill" name="end_date" type="date" value="{{ old('start_date', isset($end_date) ? $end_date: '') }}">
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-light">Search</button>
                </div>
            </div>
        </form>
    </div>
    
    
    <div class="col-lg-6 col-sm-12 mt-3 ">
        <form action="/riwayat/cari">
            <div class="input-group">
                <input class="form-control border-end-0 border rounded-pill" name="cari" type="text" id="cari" value="{{ old('cari') }}"/>
                <div class="input-group-btn">
                    <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5" type="submit" value="cari" >
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Code</th>
                        <th scope="col">No plat</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Waktu Masuk</th>
                        <th scope="col">Waktu Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accesslog as $logs)
                    <tr>
                        <td>{{ $accesslog->firstItem() + $loop->index }}</td>
                        <td>{{ $logs->qrcode->pengguna->name }}</td>
                        <td>{{ $logs->code }}</td>
                        <td>{{ $logs->no_plat }}</td>
                        <td>{{ $logs->date }}</td>
                        <td>{{ $logs->time_masuk }}</td>
                        <td>{{ $logs->time_keluar ?? ''}}</td>
                    </tr>   
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    {{ $accesslog->appends(request()->query())->links() }}
</div>


@endsection
