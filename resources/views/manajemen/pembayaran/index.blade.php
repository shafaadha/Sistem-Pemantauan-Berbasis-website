@extends('manajemen.layouts.main')
@section('container')
<title>Pembayaran</title>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border bottom">
    <h1 class="h2 mb-2">Activity Gate</h1>
</div>

@if(session()->has('success'))
<div class="alert alert-success" role="alert">
  {{ session('success') }}
</div>
@endif

<div class="row">
    <div class="table-responsive col-lg-11 mb-3 mt-3">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Plat Keluar</th>
                    <th scope="col">Plat Kendaraan</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Biaya Parkir</th>
                    <th scope="col">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr>
                        <td>{{ $payments->firstItem() + $loop->index }}</td>
                        @if ($payment && $payment->pembayaran && $payment->pembayaran->peristiwa)
                        <td>{{ $payment->pembayaran->peristiwa->plat_keluar }}</td>
                    @else
                        <td></td>
                    @endif
                    
                        <td>{{ $payment->pembayaran->qrcode->no_plat }}
                        <td>{{ $payment->pembayaran->qrcode->pengguna->name}}</td>
                        <td>{{ $payment->biaya}}</td>
                        <td>{{ $payment->created_at}}</td>
                     </tr>
                @endforeach         
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center">
    {{ $payments->links() }}
</div>


@endsection
