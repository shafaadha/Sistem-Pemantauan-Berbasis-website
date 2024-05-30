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
        font-family: 'Times New Roman', Times, serif;
    }
    </style>
 <center>
 <h5 class="mt-5 mb-5">Daftar Pengguna Sistem Parkir Teknik Elektro Universitas Diponegoro</h5>
 </center>
 
 <table class='table table-bordered'>
 <thead>
     <tr>
        <th>No</th>
        <th>Nama</th>
        <th>NIM</th>
        <th>Plat Kendaraan</th>
        <th>Jurusan</th>
        
    </tr>
 </thead>
 <tbody>
 @php $i=1 @endphp
 @foreach($penggunas as $p)
 <tr>
 <td>{{ $i++ }}</td>
 <td>{{$p->name}}</td>
 <td>{{$p->nim}}</td>
 <td>{{$p->qrcode->no_plat}}</td>
 <td>{{ $p->jurusan }}</td>
 </tr>
 @endforeach
 </tbody>
 </table>
 
</body>
</html>