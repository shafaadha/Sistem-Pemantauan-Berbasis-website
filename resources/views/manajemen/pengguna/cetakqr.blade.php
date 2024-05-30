<!DOCTYPE html>
<html>
<head>
 <title>Kartu Nama</title>
</head>
<body >
 <table border="0" width="200" cellpadding="2" cellspacing="2">
  <tr>
   <th scope="col">NIM: {{ $nim }}</th>
  </tr>
  <tr>
   <th scope="row"><img src="data:image/png;base64,{{ $qrcode }}"></td>
  </tr>
 </table>
</body>
</html>