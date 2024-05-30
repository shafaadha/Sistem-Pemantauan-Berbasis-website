@extends('admin.layouts.main')
@section('container')
<title>Harga</title>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border bottom">
    <h1 class="h2 mb-2">Activity Gate</h1>
</div>

@if(session()->has('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
  </div> 
@endif

@if (session()->has('info'))
<div class="alert alert-danger" role="alert">
    {{ session('info') }}
  </div> 
@endif


<div class="container">
    <div class="row">
        <div class="col-md-4">
            <form method="post" action="{{ url('/update/harga') }}">
                @csrf
                <div class="mb-3">
                    <label for="harga_jam_pertama" class="form-label">Harga jam pertama:</label>
                    <input type="number" name="harga_jam_pertama" class="form-control" value="{{ old('harga_jam_pertama') }}">
                </div>
                
                <div class="mb-3">
                    <label for="harga_per_jam" class="form-label">Harga per jam:</label>
                    <input type="number" name="harga_per_jam" class="form-control" value="{{ old('harga_per_jam') }}">
                </div>
                <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah anda yakin mengubah data?')">Simpan</button>
            </form>
        </div>
        <div class="col-md-4">
            <table>
                <thead>
                    <tr>
                        <th>Harga Jam Pertama</th>
                        <th>Harga per jam</th>            
                    </tr>
                </thead>
                <tbody>
                    @foreach ($harga as $tarif)
                    <tr>
                        <td>{{ $tarif->harga_jam_pertama }}</td>
                        <td>{{ $tarif->harga_per_jam }}</td>
                    </tr>
                </tbody>
                @endforeach
            </table>
        </div>
    </div>
</div>

@endsection
