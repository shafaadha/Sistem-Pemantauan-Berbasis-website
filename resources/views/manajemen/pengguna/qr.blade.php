@extends('manajemen.layouts.main')
@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border bottom">
    <h1 class="h2 mb-2">Daftar Pengguna</h1>
</div>

@if(session()->has('success'))
<div class="alert alert-success" role="alert">
  {{ session('success') }}
</div>
@endif

<div class="table-responsive col-lg-11 mb-5">
    <a class="btn btn-primary mb-3" href="/penggunas/create">Tambah Pengguna Baru</a>
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">NIM</th>
                <th scope="col">Phone</th>
                <th scope="col">Code</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penggunas as $pengguna)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pengguna->name ?? 'N/A'}}</td>
                <td>{{ $pengguna->nim }}</td>
                <td>{{ $pengguna->phone_number }}</td>
                <td>{{ $pengguna->qrcode->code }}</td>

            </tr>   
            @endforeach
        </tbody>
    </table>
</div>

@endsection