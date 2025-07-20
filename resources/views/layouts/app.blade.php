<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .btn {
            border-radius: 6px;
        }
        .navbar-profile img {
            width: 32px;
            height: 32px;
            object-fit: cover;
            border-radius: 50%;
        }
        .sidebar {
            width: 200px;
            background-color: #111;
            color: white;
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: white;
            margin-bottom: 10px;
        }
        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background-color: white;
            color: black;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid px-4">
            <span class="navbar-brand fw-bold">Dashboard Admin</span>
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <img 
    src="{{ asset(Auth::user()->foto_profil) }}" 
    alt="Foto Profil" 
    class="me-2 navbar-profile"
    style="width: 35px; height: 35px; object-fit: cover; border-radius: 50%;"
/>

                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Lihat Profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('password.edit') }}">Ganti Password</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>

    <div class="d-flex">
        @include('partials.sidebar')

        <main class="flex-grow-1 p-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
