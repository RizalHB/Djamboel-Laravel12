@extends('layouts.main')

@section('content')
<div class="container">
    <h4 class="mb-4">Tambah Akun Kasir</h4>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('user.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="kode_user">ID User</label>
            <input type="text" name="kode_user" value="{{ $kodeUser }}" readonly class="form-control">
        </div>

        <div class="mb-3">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="form-control">
        </div>

        <div class="mb-3">
            <label for="name">Username</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="form-control">
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="form-control">
        </div>

        <div class="mb-3">
            <label for="password">Kata Sandi</label>
            <input type="password" name="password" required class="form-control">
        </div>

        <div class="mb-3">
            <label for="password_confirmation">Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" required class="form-control">
        </div>

        <div class="d-grid">
            <button class="btn btn-success" type="submit">Simpan Kasir</button>
        </div>
    </form>
</div>
@endsection
