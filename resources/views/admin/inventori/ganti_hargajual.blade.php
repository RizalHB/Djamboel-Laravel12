@extends('layouts.main')

@section('content')
<div class="container">
    <h3>Ganti Harga Jual</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('inventori.proses_ganti_hargajual', $inventori->id) }}" id="form-inventori" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" class="form-control" value="{{ $inventori->nama_barang }}" readonly>
        </div>
        <div class="mb-3">
            <label>Harga Jual Baru</label>
            <input type="number" name="harga_jual" value="{{ old('harga_jual', $inventori->harga_jual) }}" class="form-control" min="1" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('inventori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
@push('scripts')
<script>
  document.getElementById('form-inventori').addEventListener('submit', function(e) {
    e.preventDefault(); 

    Swal.fire({
      title: 'Yakin ingin simpan Perubahan?',
      text: 'Anda bisa mengatur kembali harga jual kapan saja.',
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