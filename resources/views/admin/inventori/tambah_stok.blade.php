@extends('layouts.main')
@section('content')
<div class="container">
    <h3>Tambah Stok - {{ $inventori->nama_barang }}</h3>

    <form action="{{ route('inventori.storeStok', $inventori->id) }}" id="form-inventori" method="POST">
        @csrf
        <div class="mb-3">
            <label for="jumlah">Jumlah Tambahan</label>
            <input type="number" name="jumlah" class="form-control" step="0.01" min="0.01" required>
        </div>
        <button type="submit" class="btn btn-success">Tambah Stok</button>
        <a href="{{ route('inventori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
@push('scripts')
<script>
  document.getElementById('form-inventori').addEventListener('submit', function(e) {
    e.preventDefault();

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