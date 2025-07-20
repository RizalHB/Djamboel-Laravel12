<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>D'jamboel Ayam Potong</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
    }
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 230px;
      background-color: #dc3545;
      color: #fff;
      padding-top: 20px;
      z-index: 1000;
      transform: translateX(0); /* default tampil di desktop */
      transition: transform 0.3s ease-in-out;
    }
    .sidebar a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 20px;
      color: #fff;
      text-decoration: none;
    }
    .sidebar a:hover, .sidebar .active {
      background-color: #ff4c4c;
      border-radius: 4px;
    }
    .navbar-profile {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #dc3545;
    }
    .content {
      padding: 1.5rem;
      margin-left: 230px;
      transition: margin-left 0.3s ease-in-out;
    }
    .toggle-btn {
      display: none;
      background-color: #dc3545;
      color: white;
      border: none;
      padding: 6px 10px;
      font-size: 18px;
      border-radius: 4px;
    }

    /* Dropdown animation */
    .dropdown-menu {
      transition: all 0.2s ease;
      transform: scale(0.95);
      opacity: 0;
      visibility: hidden;
      display: block;
      pointer-events: none;
      position: absolute !important;
      top: 100%;
      right: 0;
      margin-top: 5px;
    }
    .dropdown-menu.show {
      transform: scale(1);
      opacity: 1;
      visibility: visible;
      pointer-events: auto;
    }

    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
      }
      .sidebar.show {
        transform: translateX(0);
      }
      .content {
        margin-left: 0;
      }
      .toggle-btn {
        display: inline-block;
      }
    }
  </style>
</head>
<body>
  
  <div class="sidebar" id="sidebar">
    <div class="text-center mb-3">
      <img src="{{ asset('logo/LogoDAP.jpg') }}" alt="Logo" height="100">
    </div>
    @if(Auth::check())
      @if(Auth::user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}">
          <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('inventori.index') }}">
          <i class="fa-solid fa-cart-shopping"></i> Pembelian
        </a>
        <a href="{{ route('penjualan.index') }}">
          <i class="fa-solid fa-money-bill-trend-up"></i> Penjualan
        </a>
        <a href="{{ route('pengeluaran.index') }}">
          <i class="fa-solid fa-money-bill-transfer"></i> Operational Cost
        </a>
        <a href="{{ route('laporan.index') }}">
          <i class="fas fa-chart-line"></i> Laporan
        </a>
      @endif
    @endif
    @if(Auth::check())
      @if(Auth::user()->role === 'kasir')
        <a href="{{ route('penjualan.index') }}">
          <i class="fa-solid fa-money-bill-trend-up"></i> Penjualan
        </a>
      @endif
    @endif
  </div>

  <div class="flex-grow-1">
    <nav class="navbar navbar-light bg-white shadow-sm px-3 py-1" style="min-height: 40px;">
      <div class="d-flex justify-content-between align-items-center w-100">
        <div class="d-flex align-items-center">
          <button class="toggle-btn me-2" onclick="toggleSidebar()" id="sidebarToggle">☰</button>
          <span class="fw-bold small">Dashboard Admin</span>
        </div>
        <div class="dropdown" style="position: relative;">
          <a href="#" class="d-flex align-items-center text-decoration-none" id="profileDropdown" data-bs-toggle="dropdown">
            <img src="{{ asset(Auth::user()->foto_profil ?? 'gambar/Profil.png') }}" alt="Profil" class="navbar-profile me-1">
            <span class="small">{{ Auth::user()->nama_lengkap ?? 'Tamu' }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
            <li><a class="dropdown-item" href="{{ route('password.edit') }}">Ganti Password</a></li>
            @if(Auth::check())
              @if(Auth::user()->role === 'admin')
            <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Kelola Akun</a></li>
              @endif
            @endif
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item text-danger">Logout</button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <main class="content" onclick="closeSidebarIfMobile()">
      @yield('content')
      @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const toggle = document.getElementById('sidebarToggle');
      sidebar.classList.toggle('show');
      toggle.innerText = sidebar.classList.contains('show') ? '✖' : '☰';
    }

    function closeSidebarIfMobile() {
      const sidebar = document.getElementById('sidebar');
      const toggle = document.getElementById('sidebarToggle');
      if (window.innerWidth <= 768 && sidebar.classList.contains('show')) {
        sidebar.classList.remove('show');
        toggle.innerText = '☰';
      }
    }
  </script>
  @yield('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @stack('scripts')
</body>
</html>
