@extends('manajemen.layouts.main')
@section('container')
<title>Edit Data Pengguna</title>

<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border bottom">
        <h1 class="h2">Edit Data Pengguna</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <form method="post" action="/manajemen/penggunas/{{ $pengguna->nim }}">
            @method('PUT')
            @csrf

            <div class="col-lg-6"> <!-- Kolom pertama -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name', $pengguna->name) }}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nim" class="form-label">NIM Mahasiswa</label>
                    <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" required value="{{ old('nim', $pengguna->nim) }}">
                    @error('nim')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">Nomor Phone</label>
                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $pengguna->phone_number) }}">
                    @error('phone_number')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select name="kategori" id="kategori" class="form-select">
                        <option value="">Pilih kategori</option>
                        <option value="pengguna" {{ old('kategori') == 'pengguna' ? 'selected' : '' }}>Pengguna</option>
                        <option value="tamu" {{ old('kategori') == 'tamu' ? 'selected' : '' }}>Tamu</option>
                    </select>
                    @error('kategori')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6"> <!-- Kolom kedua -->
                <div class="mb-3">
                    <label for="jurusan" class="form-label">Nomor mahasiswa</label>
                    <input type="text" class="form-control @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan" required value="{{ old('jurusan', $pengguna->jurusan) }}">
                    @error('jurusan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="no_plat" class="form-label">No Plat Kendaraan</label>
                    <input type="text" class="form-control @error('no_plat') is-invalid @enderror" id="no_plat" name="no_plat" required value="{{ old('no_plat', $pengguna->qrcode->no_plat) }}">
                    @error('no_plat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat', $pengguna->alamat) }}">
                    @error('alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="orang_tua" class="form-label">Orang Tua</label>
                    <input type="text" class="form-control @error('orang_tua') is-invalid @enderror" id="orang_tua" name="orang_tua" value="{{ old('orang_tua', $pengguna->orang_tua) }}">
                    @error('orang_tua')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-12"> <!-- Button submit -->
                <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah anda yakin mengubah data?')">Ubah</button>
            </div>
        </form>
    </div>
</div>
@endsection
