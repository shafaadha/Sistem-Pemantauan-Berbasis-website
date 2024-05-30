@extends('manajemen.layouts.main')
@section('container')
<title>Pengguna</title>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border bottom">
    <h1 class="h3 mb-2">Daftar Pengguna</h1>
</div>

@if(session()->has('success'))
<div class="alert alert-success" role="alert">
  {{ session('success') }}
</div>
@endif

<form action="/pengguna/cari" method="GET">
    <div class="row">
        <div class="col-md-5 max-auto mb-4">
            <div class="input-group">
                <input class="form-control border-end-0 border rounded-pill" type="search" name='cari' id="cari" placeholder="Cari Mahasiswa ...." value="{{ old('start_date', isset($cari) ? $cari: '') }}">
                <span class="input-group-append">
                <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5" type="submit" value="cari" >
                <i class="bi bi-search"></i>
                        </button>
                    </span>
            </div>
        </div>
        <div class="col-md-5">
            <a class="btn" href='/manajemen/form'><i class="bi bi-person-add"></i></a>
            <a class="btn" href='/penggunas/cetak_pdf'><i class="bi bi-printer"></i> Cetak</a>
        </div>
    </div>
</form>



<div class="table-responsive-md col-lg-12 mb-2">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">NIM</th>
                <th scope="col">Jurusan</th>
                <th scope="col">Phone</th>
                <th scope="col">Plat</th>
                <th scope="col">Code</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penggunas as $pengguna)
            <tr>
                <td>{{ $penggunas->firstItem() + $loop->index }}</td>
                <td>{{ $pengguna->name ?? 'N/A'}}</td>
                <td>{{ $pengguna->nim }}</td>
                <td>{{ $pengguna->jurusan }}</td>
                <td>{{ $pengguna->phone_number }}</td>
                <td>{{ $pengguna->qrcode->no_plat }}</td>
                <td>{{ $pengguna->qrcode->code }}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="Action Buttons">
                        <div class="btn-group" style="margin-right: 5px">
                            <form method="POST" action="{{ url('/manajemen/penggunas/' . $pengguna->nim) }}" class="pull-right">
                                @method('delete')
                                @csrf
                                <button type="submit" class="badge bg-danger border-0" onclick="return confirm('Apakah anda yakin?')"><i class="bi bi-trash3"></i></button>
                            </form>
                        </div>
                        
                        {{-- Edit --}}                
                        <div class="btn-group" role="group" aria-label="Edit Buttons" style="margin-right: 5px">
                            <a href="{{ URL::to('/manajemen/penggunas/' . $pengguna->nim . '/edit') }}" class="badge bg-warning text-decoration-none"><i class="bi bi-pencil-square"></i></a>
                        </div>
                        
                        {{-- Lihat --}}
                        <div class="btn-group" role="group" aria-label="View Buttons" style="margin-right: 5px">
                            <a href="{{ URL::to('/manajemen/penggunas/' . $pengguna->nim) }}" class="badge bg-info text-decoration-none"><i class="bi bi-eye"></i></a>
                        </div>
                    </div>
                </td>
                
            </tr>  
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $penggunas->appends(request()->query())->links() }}
</div>

@endsection
