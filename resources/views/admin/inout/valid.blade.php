@extends('admin.layouts.main')
@section('container')
<title>Testing</title>
@if(session()->has('success'))
<div class="alert alert-success" role="alert">
  {{ session('success') }}
</div>
@endif

<div class="d-flex justify-content-between fle x-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border bottom">
    <h1 class="h2">Test Masuk dan Keluar</h1>
</div>
<a class="btn btn-light mb-3" href='/kejadian'>Lihat scan plat</a>
<div class="row mx-md-n5">
    <div class="col-lg-4 px-md-5 center-block">
        <form method="post" action="{{ url('/valid-In') }}" class="mt-4" enctype="multipart/form-data">
            <h5 class="h5 mb-3">Masuk</h5>
            @csrf
            <div class="mb-3">
              <label for="code" class="form-label">QR Code</label>
              <input type="code" class="form-control" id="code" @error('code') is-invalid @enderror name="code" required value="{{ old('code') }}">
              @error('code')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="plat_masuk" class="form-label">No Plat</label>
              <input type="plat_masuk" class="form-control" @error('plat_masuk') is-invalid @enderror id="plat_masuk" name="plat_masuk" required value="{{ old('plat_masuk') }}">
              @error('plat_masuk')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
              @enderror
            </div>

            <div class="mb-3">
                <label for="gambar_in" class="form-label">Scan Plat Masuk</label>
                <input class="form-control @error('gambar_in') is-invalid @enderror" type="file" id="gambar_in" name="gambar_in">
                @error('gambar_in')
                <div class="invalid-feedback">
                    {{ $message }}  
                </div>                  
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>
    
    <div class="col-lg-4 px-md-5 center-block">
        <form method="post" action="{{ url('/valid-Out') }}" class="mt-4" enctype="multipart/form-data">
            <h5 class="h5 mb-3">Keluar</h5>
            @csrf
            <div class="mb-3">
               <label for="code" class="form-label">QR Code</label>
               <input type="code" class="form-control" id="code" @error('code') is-invalid @enderror name="code" required value="{{ old('code') }}">
               @error('code')
               <div class="invalid-feedback">
                   {{ $message }}
               </div>
               @enderror
            </div>
    
            <div class="mb-3">
                <label for="plat_keluar" class="form-label">No Plat</label>
                <input type="plat_keluar" class="form-control" @error('plat_keluar') is-invalid @enderror id="plat_keluar" name="plat_keluar" required value="{{ old('plat_keluar') }}">
                @error('plat_keluar')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="gambar_out" class="form-label">Scan Plat Keluar</label>
                <input class="form-control @error('gambar_out') is-invalid @enderror" type="file" id="gambar_out" name="gambar_out">
                @error('gambar_out')
                <div class="invalid-feedback">
                    {{ $message }}  
                </div>                  
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>
</div>

@endsection