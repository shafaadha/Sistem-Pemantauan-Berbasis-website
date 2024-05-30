  <div class="b-example-divider b-example-vr"></div>
  <div class="d-flex flex-column flex-md-shrink-0 p-3 bg-body-tertiary" style="height: 100vh; height: -webkit-fill-available">
    <a href="/admin/dashboard" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
      <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
      <span class="fs-4">Smart Parking</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="/admin/dashboard" class="nav-link link-body-emphasis {{ Request::is('admin/dashboard') ? 'active' : '' }}">
          <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"/></svg>
          Dashboard
        </a>
      </li>

      <li class="nav-item">
        <a href="/admin/penggunas" class="nav-link link-body-emphasis {{ Request::is('admin/penggunas') ? 'active' : '' }}">
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
                 
      <li class="nav-item">
        <a href="/admin/pembayaran" class="nav-link link-body-emphasis {{ Request::is('admin/pembayaran') ? 'active' : '' }}">
          <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#history"/></svg>
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
        <li><a class="dropdown-item">Halo, {{ auth()->user()->role }}</a></li>
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