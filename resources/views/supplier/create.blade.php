@extends('layouts.main')

@section('content')
<div class="container">
    <h4 class="mb-3">Tambah Supplier</h4>

    <form action="{{ route('supplier.store') }}" id="form-inventori" method="POST">
        @csrf

        <div class="mb-3">
            <label>ID Supplier</label>
            <input type="text" name="id_supplier" class="form-control" value="{{ $generatedId }}" readonly>
        </div>

        <div class="mb-3">
            <label>Nama Supplier</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>No Rekening / E-Wallet <small class="text-muted">(Opsional)</small></label>
            <input type="text" name="no_rekening" class="form-control">
        </div>

        <div class="mb-3">
            <label>No Telepon <small class="text-muted">(Opsional)</small></label>
            <input type="text" name="no_telepon" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email <small class="text-muted">(Opsional)</small></label>
            <input type="email" name="email" class="form-control">
        </div>

        <button type="submit" class="btn btn-danger">Simpan</button>
    </form>
</div>
@endsection
@push('scripts')
<script>
  document.getElementById('form-inventori').addEventListener('submit', function(e) {
    e.preventDefault();
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