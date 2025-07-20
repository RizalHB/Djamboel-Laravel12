@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Supplier</h5>
            <div>
                <a href="{{ route('supplier.create') }}" class="btn btn-light text-primary">+ Tambah Supplier</a>
                <a href="{{ route('supplier.export.excel') }}" class="btn btn-success">Download Excel</a>
            </div>
        </div>
        <div class="card-body p-4">
            <form method="GET" action="{{ route('supplier.index') }}" class="row g-2 mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama/alamat supplier..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Filter</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-primary">
    <tr>
        <th>ID Supplier</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>No Telp</th>
        <th>No Rekening</th>
        <th>Email</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
    @forelse ($suppliers as $supplier)
    <tr>
        <td>{{ $supplier->id_supplier }}</td>
        <td>{{ $supplier->nama }}</td>
        <td>{{ $supplier->alamat }}</td>
        <td>{{ $supplier->no_telepon ?? '-' }}</td>
        <td>{{ $supplier->no_rekening ?? '-' }}</td>
        <td>{{ $supplier->email ?? '-' }}</td>
        <td>
            <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-sm btn-warning">Edit</a>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="7" class="text-muted text-center">Belum ada data supplier.</td>
    </tr>
    @endforelse
</tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
    {{ $suppliers->links() }}
</div>
            </div>
        </div>
    </div>
</div>
@endsection