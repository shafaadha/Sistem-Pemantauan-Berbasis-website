@extends('admin.layouts.main')
@section('container')
<title>Laporan</title>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border bottom">
    <h1 class="h2">Activity Gate</h1>
</div>

@if(session()->has('success'))
<div class="alert alert-success" role="alert">
  {{ session('success') }}
</div>
@endif


<div class="row">
    <div class="col-lg-6 col-sm-12 mt-3">
        <form action="/kejadian/cari">
            <div class="input-group">
                <input class="form-control border-end-0 border rounded-pill" name="start_date" type="date" value="{{ old('start_date', isset($start_date) ? $start_date: '') }}">
                <input class="form-control border-end-0 border rounded-pill" name="end_date" type="date" value="{{ old('end_date', isset($end_date) ? $end_date: '') }}">
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>
    </div>
    
    {{-- <div class="col-lg-3 col-sm-12 mt-3 mb-3">
        <form action="/kejadian/cari">
            <div class="input-group">
                <input class="form-control border-end-0 border rounded-pill" name="cari" type="search" id="cari" value="{{ old('cari', isset($cari) ? $cari: '') }} "/>
                <div class="input-group-btn">
                    <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5" type="submit" value="cari" >
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>   --}}
</div>

<div class="row">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Code</th>
                    <th scope="col">No plat</th>
                    <th scope="col">Plat Masuk</th>
                    <th scope="col">Plat Keluar</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Waktu Masuk</th>
                    <th scope="col">Waktu Keluar</th>
                    <th scope="col">Gambar Masuk</th>
                    <th scope="col">Gambar Keluar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($scanplat as $plats)
                <tr>
                    <td>{{ $scanplat->firstItem() + $loop->index }}</td>
                    <td>{{ $plats->peristiwa->qrcode->pengguna->name }}</td>
                    <td>{{ $plats->peristiwa->code }}</td>
                    <td>{{ $plats->no_plat }}</td>
                    <td>{{ $plats->plat_masuk }}</td>
                    <td>{{ $plats->plat_keluar }}</td>
                    <td>{{ $plats->date }}</td>
                    <td>{{ $plats->tcek_masuk }}</td>
                    <td>{{ $plats->tcek_keluar ?? ''}}</td>
                    <td><a style="text-decoration: none;" href="{{ asset('storage/' . $plats->gambar_in) }}" >Lihat</a></td>
                    <td><a style="text-decoration: none;" href="{{ asset('storage/' . $plats->gambar_out) }}" >Lihat</a></td>
                </tr>   
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center">
    {{ $scanplat->links() }}
</div>

@endsection
