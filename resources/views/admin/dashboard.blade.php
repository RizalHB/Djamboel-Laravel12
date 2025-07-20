@extends('layouts.main')
@section('content')
    <h2>Selamat Datang, {{ Auth::user()->nama_lengkap }}!</h2>
    <p>Silakan pilih menu di sidebar untuk mengelola data.</p>
    <div class="row mt-4">
    {{-- Kartu Supplier --}}
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Supplier</h5>
                <a href="{{ route('supplier.create') }}" class="btn btn-light text-primary">+ Tambah Supplier</a>
            </div>
            <div class="card-body">
                @if ($suppliers->isEmpty())
                    <p class="text-muted">Belum ada data supplier.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No Telp</th>
                                    <th>No Rekening</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $supplier)
                                    <tr>
                                        <td>{{ $supplier->nama }}</td>
                                        <td>{{ $supplier->alamat }}</td>
                                        <td>{{ $supplier->no_telepon ?? '-' }}</td>
                                        <td>{{ $supplier->no_rekening ?? '-' }}</td>
                                        <td>{{ $supplier->email ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end mt-2">
                        <a href="{{ route('supplier.index') }}" class="btn btn-primary btn-sm">Lihat Semua Supplier</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="card mt-4">
    <div class="card-header bg-primary text-white">
        Tambah Kostumer
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('kostumer.store') }}" method="POST" id="form-inventori">
            @csrf
            <div class="mb-3">
                <label>Nama Kostumer</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>No Telepon <small class="text-muted">(Opsional)</small></label>
                <input type="text" name="no_telepon" class="form-control">
            </div>
            <div class="mb-3">
                <label>Alamat <small class="text-muted">(Opsional)</small></label>
                <textarea name="alamat" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Simpan Kostumer</button>
            <a href="{{ route('kostumer.index') }}" class="btn btn-primary">Lihat Data Kostumer</a>
        </form>
    </div>
</div>
    {{-- ======= Sisa Stok Barang ======= --}}
<div class="card mt-4">
    <div class="card-header bg-primary text-white">
        <strong>Remaining Stock</strong>
    </div>
    <div class="card-body">
        @if($inventoris->count())
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>No ID</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Tersedia</th>
                            <th>Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventoris as $index => $item)
                        <tr>
                            <td>{{ ($inventoris->currentPage() - 1) * $inventoris->perPage() + $index + 1 }}</td>
                            <td>{{ $item->kode_barang }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ number_format($item->amount, 2) }}</td>
                            <td>{{ $item->unit }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $inventoris->links() }}
                </div>

            </div>
        @else
            <p class="text-muted">Belum ada data Pembelian.</p>
        @endif
    </div>
</div>
</div>
@endsection
@push('scripts')
<script>
  document.getElementById('form-inventori').addEventListener('submit', function(e) {
    e.preventDefault(); // cegah submit langsung

    Swal.fire({
      title: 'Yakin ingin simpan?',
      text: 'Anda dapat kembali merubah data yang optional.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, Simpan',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        this.submit();
      }
    });
  });
</script>
@endpush