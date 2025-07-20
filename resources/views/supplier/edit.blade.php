@extends('layouts.main')

@section('content')
<div class="container">
    <h4 class="mb-3">Edit Supplier</h4>

    <form action="{{ route('supplier.update', $supplier->id) }}" id="form-inventori" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>ID Supplier</label>
            <input type="text" class="form-control" value="{{ $supplier->id_supplier }}" readonly>
        </div>

        <div class="mb-3">
            <label>Nama Supplier</label>
            <input type="text" class="form-control" value="{{ $supplier->nama }}" readonly>
        </div>

        <div class="mb-3">
    <label>Alamat</label>
    <input type="text" name="alamat" class="form-control" value="{{ $supplier->alamat }}" required>
</div>
        
        <div class="mb-3">
            <label>No Rekening / E-Wallet</label>
            <input type="text" name="no_rekening" class="form-control" value="{{ $supplier->no_rekening }}">
        </div>

        <div class="mb-3">
            <label>No Telepon</label>
            <input type="text" name="no_telepon" class="form-control" value="{{ $supplier->no_telepon }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $supplier->email }}">
        </div>

        <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
    </form>
</div>
@endsection
@push('scripts')
<script>
  document.getElementById('form-inventori').addEventListener('submit', function(e) {
    e.preventDefault(); // cegah submit langsung

    Swal.fire({
      title: 'Yakin ingin simpan Perubahan?',
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