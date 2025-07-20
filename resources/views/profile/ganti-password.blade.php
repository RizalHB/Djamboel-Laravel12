@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">
            Ganti Password
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
    @csrf
    <div class="mb-3">
        <label>Password Saat Ini</label>
        <input type="password" name="current_password" class="form-control" required>
        @error('current_password') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label>Password Baru</label>
        <input type="password" name="new_password" class="form-control" required>
        @error('new_password') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label>Konfirmasi Password Baru</label>
        <input type="password" name="new_password_confirmation" class="form-control" required>
        @error('new_password_confirmation') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-success">Ubah Password</button>
</form>
        </div>
    </div>
</div>
@endsection
