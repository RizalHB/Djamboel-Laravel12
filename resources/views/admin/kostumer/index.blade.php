@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Kostumer</h5>
            <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light text-primary">← Kembali ke Dashboard</a>
            <a href="{{ route('kostumer.export.excel') }}" class="btn btn-success">
            Download Excel
            </a>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-primary">
    <tr>
        <th>ID Kostumer</th>
        <th>Nama Kostumer</th>
        <th>No Telepon</th>
        <th>Alamat</th>
        <th>Tanggal Ditambahkan</th>
        <th>Aksi</th> {{-- Kolom baru --}}
    </tr>
</thead>
<tbody>
    @forelse ($kostumers as $kostumer)
    <tr>
        <td>{{ $kostumer->kode_kostumer }}</td>
        <td>{{ $kostumer->nama }}</td>
        <td>{{ $kostumer->no_telepon ?? '-' }}</td>
        <td>{{ $kostumer->alamat ?? '-' }}</td>
        <td>{{ \Carbon\Carbon::parse($kostumer->created_at)->translatedFormat('d F Y') }}</td>
        <td>
            <a href="{{ route('kostumer.edit', $kostumer->id) }}" class="btn btn-sm btn-warning">Edit</a>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="6" class="text-center">Belum ada data kostumer.</td>
    </tr>
    @endforelse
</tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
    {{ $kostumers->links() }}
</div>

            </div>
        </div>
    </div>
</div>
@endsection
