<!DOCTYPE html>
<html>
<head>
 <title>Laporan Sistem Parkir Teknik Elektro</title>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <style type="text/css">
    table tr td,
    table tr th{
        font-size: 9pt;
    }
    </style>
 <center>
 <h5>Laporan Sistem Parkir Teknik Elektro Universitas Diponegoro</h5>
 </center>
 
 <table class='table table-bordered'>
 <thead>
 <tr>
 <th>No</th>
 <th>Nama</th>
 <th>Plat Kendaraan</th>
 <th>Plat Masuk</th>
 <th>Plat Keluar</th>
 <th>Tanggal</th>
 <th>Waktu Masuk</th>
 <th>Waktu Keluat</th>
 </tr>
 </thead>
 <tbody>
 @php $i=1 @endphp
 @foreach($laporan as $l)
 <tr>
 <td>{{ $i++ }}</td>
 <td>{{$l->peristiwa->qrcode->pengguna->name}}</td>
 <td>{{$l->no_plat}}</td>
 <td>{{$l->plat_masuk}}</td>
 <td>{{$l->plat_keluar}}</td>
 <td>{{$l->date}}</td>
 <td>{{$l->tcek_masuk}}</td>
 <td>{{$l->tcek_keluar}}</td>
 </tr>
 @endforeach
 </tbody>
 </table>
 
</body>
</html>