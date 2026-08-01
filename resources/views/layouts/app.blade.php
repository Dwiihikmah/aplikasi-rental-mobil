<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Rental Mobil</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-body-tertiary">

@auth
<div class="d-flex" style="min-height: 100vh;">
  
  <aside class="offcanvas-lg offcanvas-start bg-dark text-white d-lg-flex flex-column flex-shrink-0 p-3 shadow-sm" style="width: 260px;" id="sidebarNav">
    <div class="d-flex justify-content-between align-items-center mb-3 px-2 pt-2">
      <a href="{{ route('cars.index') }}" class="d-flex align-items-center text-white text-decoration-none fw-bold fs-5">
        <span class="bg-primary text-white rounded-3 p-1 me-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
            <i class="bi bi-car-front-fill fs-6"></i>
        </span>
        <span>Sewa<span class="text-primary">Mobil</span></span>
      </a>
      <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#sidebarNav"></button>
    </div>

    <hr class="border-secondary opacity-25 my-2">
    <p class="text-uppercase text-secondary fw-bold px-2 my-2" style="font-size: 0.7rem; letter-spacing: 0.05em;">Menu Utama</p>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="{{ route('cars.index') }}" class="nav-link text-white {{ request()->routeIs('cars.*') ? 'active bg-primary fw-semibold' : 'opacity-75' }}">
          <i class="bi bi-car-front me-2"></i> Data Mobil
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('rentals.create') }}" class="nav-link text-white {{ request()->routeIs('rentals.create') ? 'active bg-primary fw-semibold' : 'opacity-75' }}">
          <i class="bi bi-key me-2"></i> Sewa Mobil
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('rentals.index') }}" class="nav-link text-white {{ request()->routeIs('rentals.index') ? 'active bg-primary fw-semibold' : 'opacity-75' }}">
          <i class="bi bi-clock-history me-2"></i> Riwayat Sewa
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('rentals.return') }}" class="nav-link text-white {{ request()->routeIs('rentals.return') ? 'active bg-primary fw-semibold' : 'opacity-75' }}">
          <i class="bi bi-arrow-return-left me-2"></i> Pengembalian
        </a>
      </li>
    </ul>

    <hr class="border-secondary opacity-25 my-2">
    <div class="dropdown px-1">
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle p-2 rounded-3" data-bs-toggle="dropdown">
        <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 36px; height: 36px;">
          {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div class="lh-sm me-auto">
          <span class="d-block fw-semibold text-truncate" style="max-width: 130px;">{{ Auth::user()->name }}</span>
          <small class="text-secondary" style="font-size: 0.72rem;">SIM: {{ Auth::user()->nomor_sim }}</small>
        </div>
      </a>
      <ul class="dropdown-menu shadow">
        <li>
          <a class="dropdown-item" href="{{ route('profile.edit') }}">
            <i class="bi bi-person me-2"></i> Lihat Profil
          </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="dropdown-item text-danger">
              <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
          </form>
        </li>
      </ul>
    </div>
  </aside>

  <div class="flex-grow-1 d-flex flex-column">
    <main class="p-3 p-md-4 flex-grow-1">
      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
          <div class="d-flex align-items-center">
              <i class="bi bi-check-circle-fill fs-5 me-2"></i>
              <div>{{ session('success') }}</div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      @endif

      @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
          <div class="d-flex align-items-start">
              <i class="bi bi-exclamation-triangle-fill fs-5 me-2 mt-1"></i>
              <div>
                  <strong class="d-block mb-1">Periksa Kembali Inputan Anda:</strong>
                  <ul class="mb-0 ps-3">
                      @foreach($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      @endif

      @yield('content')
    </main>
  </div>
</div>

@else
<div class="min-vh-100 d-flex flex-column justify-content-center align-items-center bg-body-tertiary p-3">
    <div class="mb-4 text-center">
        <div class="bg-primary text-white p-3 rounded-4 shadow d-inline-block mb-2">
            <i class="bi bi-car-front-fill fs-2"></i>
        </div>
        <h3 class="fw-bold text-dark">Sewa<span class="text-primary">Mobil</span></h3>
    </div>
    <div class="w-100" style="max-width: 420px;">
        @yield('content')
    </div>
</div>
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>