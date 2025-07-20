@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">
            Profil Saya
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name">Username</label>
                    <input type="text" id="name" class="form-control" value="{{ $user->name }}" readonly>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                        value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                    @error('nama_lengkap') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="foto_profil">Foto Profil</label>
                    <input type="file" name="foto_profil" id="foto_profil" class="form-control">
                    @error('foto_profil') <div class="text-danger">{{ $message }}</div> @enderror

                    @if ($user->foto_profil)
                        <div class="mt-2">
                            <img src="{{ asset($user->foto_profil) }}" alt="Foto Profil" width="80" height="80" class="rounded-circle">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="hapus_foto" id="hapus_foto">
                                <label class="form-check-label" for="hapus_foto">Hapus Foto Profil</label>
                            </div>
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <a href="{{ route('password.edit') }}" class="btn btn-secondary">Ganti Password</a>
            </form>
        </div>
    </div>
</div>
@endsection
