@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Tambah Inventori Baru</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" id="form-inventori" action="{{ route('inventori.store') }}">
        @csrf
        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Unit</label>
            <select name="unit" class="form-control" required>
                <option value="" selected disabled>-- Pilih Unit --</option>
                <option value="Kg">Kg</option>
                <option value="Pcs">PCS</option>
                <option value="Ekor">Ekor</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="amount">Jumlah</label>
            <input type="number" name="amount" step="0.01" min="0.01" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="price_per_unit">Harga Satuan</label>
            <input type="number" name="price_per_unit" step="1" min="1" class="form-control" required>
        </div>

        <div class="mb-3">
    <label class="form-label">Supplier</label>
    <select name="supplier_id" class="form-control">
        <option value="">-- Pilih Supplier --</option>
        @foreach ($suppliers as $s)
            <option value="{{ $s->id }}" {{ (old('supplier_id', $inventori->supplier_id ?? '') == $s->id) ? 'selected' : '' }}>
                {{ $s->nama }}
            </option>
        @endforeach
    </select>
</div>
        <div class="mb-3">
            <label>Harga Jual Perunit</label>
            <input type="number" name="harga_jual" class="form-control" min="1" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Pembelian</label>
            <input type="date" name="tanggal_pembelian" class="form-control" required value="{{ now()->toDateString() }}" readonly>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('inventori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
@push('scripts')
<script>
  document.getElementById('form-inventori').addEventListener('submit', function(e) {
    e.preventDefault(); // cegah submit langsung

    Swal.fire({
      title: 'Yakin ingin simpan?',
      text: 'Anda tidak dapat melakukan perubahan kepada data yang tersimpan!',
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
