<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - D'jamboel Ayam</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            height: 100vh;
        }

        .login-container {
            max-width: 400px;
            margin: auto;
            margin-top: 8%;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .login-title {
            font-weight: 600;
            margin-bottom: 1rem;
            color: #ff0000;
            text-align: center;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #000;
        }

        .btn-primary {
            width: 100%;
        }

        .error-text {
            font-size: 0.875rem;
            color: red;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h3 class="login-title">Login Admin</h3>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="mb-3">
    <label for="login" class="form-label">Email atau Username</label>
    <input type="text" name="login" id="login" class="form-control" placeholder="Masukkan email atau username" required>
    @error('login')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="password" class="form-label">Kata Sandi</label>
    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
    @error('password')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>
            
            <div class="text-center mt-3">
  <button type="submit" class="btn btn-danger w-100" style="max-width: 600px; margin: 0 auto;">
    Masuk
  </button>
</div>

</div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
