@extends('manajemen.layouts.main')
@section('container')
<title>Form</title>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3 border bottom">
    <h1 class="h2">Buat Pengguna Baru</h1>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="col-lg-6 form">
    <form action="{{ url('/process-form') }}" method="post">
        @csrf

        <div class="col1">
            <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" @error('name') is-invalid @enderror name="name" required>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        
        <div class="col2">
            <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" @error('nim') is-invalid @enderror name="nim" required>
            @error('nim')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        

        <div class="col1">
            <label for="kategori" class="form-label">Kategori<span class="text-danger">*</span></label>
            <select name="kategori" id="kategori" class="form-control">
                <option value="pengguna">Pengguna</option>
                <option value="tamu">Tamu</option>
            </select>
        </div>

        <div class="col2">
            <label for="phone_number" class="form-label">Nomor mahasiswa<span class="text-danger">*</span></label>
            <input type="phone_number" class="form-control" id="phone_number" @error('phone_number') is-invalid @enderror name="phone_number" required value="{{ old('phone_number') }}">
            @error('phone_number')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col2">
            <label for="jurusan" class="form-label">Jurusan<span class="text-danger">*</span></label>
            <input type="jurusan" class="form-control" id="jurusan" @error('jurusan') is-invalid @enderror name="jurusan" required value="{{ old('jurusan') }}">
            @error('jurusan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>


        <div class="col2">
            <label for="no_plat" class="form-label">Nomor Plat<span class="text-danger">*</span></label>
            <input type="no_plat" class="form-control" id="no_plat" @error('no_plat') is-invalid @enderror name="no_plat" required value="{{ old('no_plat') }}">
            @error('no_plat')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col2">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="alamat" class="form-control" id="alamat" @error('alamat') is-invalid @enderror name="alamat" value="{{ old('alamat') }}">
            @error('alamat')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col2">
            <label for="orang_tua" class="form-label">Orang Tua</label>
            <input type="orang_tua" class="form-control" id="orang_tua" @error('orang_tua') is-invalid @enderror name="orang_tua" value="{{ old('orang_tua') }}">
            @error('orang_tua')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>



        <div class="col2" style="display: none">
            <label for="code" class="form-label">Code</label>
            <input type="text" class="form-control" id="code" @error('code') is-invalid @enderror name="code" required value="{{ old('code') }}">
            @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mb-5">Tambah</button>
    </form>
</div>

<script>
    function randomString(len) {
        var str = "";
        for (var i = 0; i < len; i++) {
            var rand = Math.floor(Math.random() * 62);
            var charCode = rand += rand > 9 ? (rand < 36 ? 55 : 61) : 48;
            str += String.fromCharCode(charCode);
        }
        return str;
    }
    document.getElementById("code").value = randomString(10);
</script>

@endsection
