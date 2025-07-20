@extends('layouts.main')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Operational Cost</h5>
            <a href="{{ route('pengeluaran.create') }}" class="btn btn-light text-primary">+ Tambah Pengeluaran</a>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="alert alert-danger">
                        <strong>Total Seluruh Operational Cost:</strong><br>
                        Rp {{ number_format($totalSemua, 0, ',', '.') }}
                    </div>
                </div>                
                <div class="col-md-4">
                </div>
            </div>

            {{-- Filter --}}
            <form method="GET" class="row g-3 mb-3">
                <div class="col-md-3">
    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
</div>
<div class="col-md-3">
    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
</div>

                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama pengeluaran..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-select">
                        <option value="">-- Urutkan --</option>
                        <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="harga" {{ request('sort') == 'harga' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="kuantitas" {{ request('sort') == 'kuantitas' ? 'selected' : '' }}>Kuantitas Tertinggi</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-success w-100">Filter</button>
                </div>
                <div class="col-md-2">
    <a href="{{ route('pengeluaran.export.excel', request()->all()) }}" class="btn btn-success w-100">
        Download Excel
    </a>
</div>

            </form>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>ID Pengeluaran</th>
                            <th>Nama Pengeluaran</th>
                            <th>Kuantitas</th>
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengeluarans as $item)
<tr>
    <td>{{ $item->id_pengeluaran }}</td>
    <td>{{ $item->nama_pengeluaran }}</td>
    <td>{{ number_format($item->kuantitas, 0,',','.') }}</td>
    <td>Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
    <td>Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
    <td>{{ $item->kategori }}</td>
    <td>{{ $item->keterangan ?? '-' }}</td>
    <td>{{ \Carbon\Carbon::parse($item->tanggal_pengeluaran)->translatedFormat('d F Y') }}</td>
    <td>
        <a href="{{ route('pengeluaran.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="9" class="text-center text-muted">Belum ada data pengeluaran.</td>
</tr>
@endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
    {{ $pengeluarans->links() }}
</div>
            </div>
        </div>
    </div>
</div>
@endsection
