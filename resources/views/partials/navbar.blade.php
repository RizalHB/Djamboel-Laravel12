<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Ayam - Admin Panel</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Navbar brand (Dashboard Admin) */
        .navbar-brand {
            color: #fff; /* Teks putih pada brand */
            transition: color 0.3s ease, background-color 0.3s ease;
        }

        /* Efek hover khusus pada "Dashboard Admin" */
        .navbar-brand.dashboard-link:hover {
            color: #000; /* Teks menjadi hitam saat hover */
            background-color: #fff; /* Latar belakang putih saat hover */
            padding: 5px 10px; /* Berikan padding agar latar belakang lebih jelas */
            border-radius: 5px; /* Tambahkan border-radius untuk sudut yang lebih halus */
        }

        /* Navbar Links */
        .navbar-nav .nav-link {
            color: #fff; /* Teks putih di navbar */
            transition: color 0.3s ease, background-color 0.3s ease;
        }

        /* Hover effect for navbar links */
        .navbar-nav .nav-link:hover {
            color: #000; /* Ubah teks menjadi hitam saat hover */
            background-color: #fff; /* Latar belakang putih saat hover */
            border-radius: 5px; /* Tambahkan border-radius untuk tampilan yang lebih halus */
        }

        /* Navbar brand (logo) */
        .navbar-brand {
            color: #fff; /* Teks putih pada brand */
        }

        /* Navbar brand hover effect */
        .navbar-brand:hover {
            color: #A8E6CF; /* Ubah warna teks pada brand saat hover */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand dashboard-link" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('inventori.index') }}">Inventori</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('penjualan.index') }}">Penjualan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pengeluaran.index') }}">Pengeluaran</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('laporan.index') }}">Laporan</a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-danger ms-3" type="submit">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
