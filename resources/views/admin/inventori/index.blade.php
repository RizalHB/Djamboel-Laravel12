@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Pembelian</h5>
            <a href="{{ route('inventori.create') }}" class="btn btn-light text-primary">+ Tambah Inventori</a>
        </div>
        <div class="card-body p-4">
            <form method="GET" action="{{ route('inventori.index') }}" class="mb-3">
                <div class="row g-2 align-items-center">
                    <div class="col-md-3">
    <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="form-control" placeholder="Tanggal Awal">
</div>
<div class="col-md-3">
    <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="form-control" placeholder="Tanggal Akhir">
</div>
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama barang...">
                    </div>
                    <div class="col-auto">
                        <select name="sort" id="sort" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Urutkan berdasarkan --</option>
                            <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama Barang</option>
                            <option value="amount" {{ request('sort') == 'amount' ? 'selected' : '' }}>Stok Tertinggi</option>
                            <option value="harga" {{ request('sort') == 'harga' ? 'selected' : '' }}>Harga per Unit Tertinggi</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Terapkan</button>
                    </div>
                    <div class="col-auto">
    <a href="{{ route('inventori.export.excel', request()->all()) }}" class="btn btn-success">
        Download Excel
    </a>
</div>

                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
    <thead class="table-primary">
        <tr>
            <th>ID Barang</th>
            <th>Nama Barang</th>
            <th>Unit</th>
            <th>Stok</th>
            <th>Supplier</th>
            <th>Harga Beli/Unit</th>
            <th>Harga Jual</th>
            <th>Tanggal Pembelian</th>
            <th>Terakhir diupdate</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($inventoris as $item)
    <tr>
        <td>{{ $item->kode_barang }}</td>
        <td>{{ $item->nama_barang }}</td>
        <td>{{ $item->unit }}</td>
        <td>{{ $item->amount }}</td>
        <td>{{ $item->supplier->nama ?? '-' }}</td>
        <td>Rp {{ number_format($item->price_per_unit, 0, ',', '.') }}</td>
        <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
        <td>{{ \Carbon\Carbon::parse($item->tanggal_pembelian)->translatedFormat('d F Y') }}</td>
        <td>{{ \Carbon\Carbon::parse($item->updated_at)->translatedFormat('d F Y') }}</td>
        <td>
            <a href="{{ route('inventori.tambahStok', $item->id) }}" class="btn btn-sm btn-success">Tambah Stok Barang</a> <br><br>
            <a href="{{ route('inventori.ganti_hargajual', $item->id) }}" class="btn btn-sm btn-warning">Ganti Harga Jual</a>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="10" class="text-center text-muted">Belum ada data pembelian.</td>
    </tr>
    @endforelse
</tbody>

</table>
<div class="d-flex justify-content-center mt-3">
    {{ $inventoris->links() }}
</div>
            </div>
            <div class="mt-3">
                <h5>Total Sisa Barang di Inventori:
                    <strong>Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong>
                </h5>
                <h5>Total Pembelian Keseluruhan (Semua Stok Masuk): 
                    <strong>Rp {{ number_format($totalPembelianBarang, 0, ',', '.') }}</strong>
                </h5>

            </div>
        </div>
    </div>
</div>
@endsection
