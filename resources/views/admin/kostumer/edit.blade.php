@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h4>Edit Data Kostumer</h4>

    <form action="{{ route('kostumer.update', $kostumer->id) }}" id="form-inventori" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>ID Kostumer</label>
            <input type="text" class="form-control" value="{{ $kostumer->kode_kostumer }}" readonly>
        </div>

        <div class="mb-3">
            <label>Nama Kostumer</label>
            <input type="text" class="form-control" value="{{ $kostumer->nama }}" readonly>
        </div>

        <div class="mb-3">
            <label>No Telepon</label>
            <input type="text" name="no_telepon" class="form-control" value="{{ $kostumer->no_telepon }}">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control">{{ $kostumer->alamat }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('kostumer.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
@push('scripts')
<script>
  document.getElementById('form-inventori').addEventListener('submit', function(e) {
    e.preventDefault(); 

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