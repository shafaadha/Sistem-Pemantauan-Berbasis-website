<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    {{-- Bootstrap icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">


    {{-- My Style --}}

    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    
  </head>
  <body>
<div class="container mt-4">
    @yield('container')
</div>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  </body>
</html>