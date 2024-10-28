@extends('admin.layouts.main')
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
                <input class="form-control border-end-0 border rounded-pill" type="search" name='cari' id="cari" placeholder="Cari Mahasiswa ...." value="{{ old('cari') }}">
                <span class="input-group-append">
                <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5" type="submit" value="cari" >
                <i class="bi bi-search"></i>
                        </button>
                    </span>
            </div>
        </div>
        <div class="col-md-5">
            <a class="btn" href='/penggunas/cetak_pdf'><i class="bi bi-printer"></i> Cetak</a>
        </div>
    </div>
</form>



<div class="table-responsive col-lg-11 mb-2">
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
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach ($penggunas as $pengguna)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pengguna->name ?? 'N/A'}}</td>
                <td>{{ $pengguna->nim }}</td>
                <td>{{ $pengguna->jurusan }}</td>
                <td>{{ $pengguna->phone_number }}</td>
                <td>{{ $pengguna->qrcode->no_plat }}</td>
                <td>{{ $pengguna->qrcode->code }}</td>
            </tr> 
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    <div class="pagination-links">
        {{ $penggunas->links() }}
    </div>
</div>

@endsection
