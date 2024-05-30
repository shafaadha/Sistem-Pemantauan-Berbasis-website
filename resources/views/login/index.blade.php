@extends('layout.login')
@section('container')

<div class="wrapper">
  @if (session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>          
  @endif
  
  @if (session()->has('loginError'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('loginError') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif
  
  <div class="form-box login">
    <h2>Login</h2>
    <form form action="/login" method="post">
      @csrf
      <div class="input-box">
        <span class="icon">
          <i class="bi bi-envelope-fill"></i></span>
        <input type="email" name="email" id="email" required>
        <label>Email</label>
        @error('email')
        <div>
          {{ $message }}
        </div>
        @enderror
      </div>

      <div class="input-box">
        <span class="icon">
          <i class="bi bi-lock-fill"></i></span>
        <input type="password" name="password" id="password" required>
        <label>Password</label>
      </div>
      <button type="submit" class="btn">Login</button>
    </form>      
  </div>
</div>




@endsection