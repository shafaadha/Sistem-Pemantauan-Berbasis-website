  <div class="b-example-divider b-example-vr"></div>
  <div class="d-flex flex-column flex-md-shrink-0 p-3 bg-body-tertiary" style="height: 100vh; height: -webkit-fill-available">
    <a href="/dashboard" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
      <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
      <span class="fs-4">Smart Parking</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="/manajemen/dashboard" class="nav-link link-body-emphasis {{ Request::is('manajemen') ? 'active' : '' }}">
          <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"/></svg>
          Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a href="/manajemen/penggunas" class="nav-link link-body-emphasis {{ Request::is('manajemen/penggunas') ? 'active' : '' }}">
          <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"/></svg>
          Pengguna
        </a>
      </li>

      <li class="nav-item">
        <a href="/kejadian" class="nav-link link-body-emphasis {{ Request::is('kejadian') ? 'active' : '' }}">
          <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#history"/></svg>
          Activity
        </a>
      </li>
      
      {{-- <li class="nav-item">
        <a href="/manajemen/valid" class="nav-link link-body-emphasis {{ Request::is('manajemen/valid') ? 'active' : '' }}">
          <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#history"/></svg>
          Validasi
        </a>
      </li> --}}
      
      <li class="nav-item">
        <a href="/manajemen/harga" class="nav-link link-body-emphasis {{ Request::is('manajemen/harga') ? 'active' : '' }}">
          <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#dollar"/></svg>
          Harga
        </a>
      </li>
      <li class="nav-item">
        <a href="/manajemen/pembayaran" class="nav-link link-body-emphasis {{ Request::is('manajemen/pembayaran') ? 'active' : '' }}">
          <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#wallet"/></svg>
          Pembayaran
        </a>
      </li>
    </ul>
    <hr>
    @auth
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
      <strong>{{ auth()->user()->name }}</strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-light text-small shadow">
        <li>
          <form action="/logout" method="post">
            @csrf
            <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
          </form>                      
        </li>
      </ul>
    </div>
    @endauth
    
  </div>
  </div>