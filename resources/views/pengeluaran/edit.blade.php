@extends('layouts.main')

@section('content')
<div class="container">
    <h3>Edit Operational Cost</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pengeluaran.update', $pengeluaran->id) }}" method="POST" id="form-inventori">
        @csrf
        @method('PUT')
        <div class="mb-3">
    <label>ID Pengeluaran</label>
    <input type="text" class="form-control" value="{{ $pengeluaran->id_pengeluaran }}" readonly>
        </div>
        <div class="mb-3">
            <label for="nama_pengeluaran" class="form-label">Nama Pengeluaran</label>
            <input type="text" name="nama_pengeluaran" class="form-control" 
                value="{{ $pengeluaran->nama_pengeluaran }}" readonly>
        </div>

        <div class="mb-3">
            <label for="kuantitas" class="form-label">Kuantitas</label>
            <input type="number" name="kuantitas" class="form-control" 
                value="{{ $pengeluaran->kuantitas }}" readonly>
        </div>

        <div class="mb-3">
            <label for="harga_satuan" class="form-label">Harga Satuan (Rp)</label>
            <input type="number" name="harga_satuan" class="form-control" 
                value="{{ $pengeluaran->harga_satuan }}" readonly>
        </div>

        <div class="mb-3">
            <label for="total_harga" class="form-label">Total Harga</label>
            <input type="text" class="form-control" 
                value="Rp {{ number_format($pengeluaran->total_harga, 0, ',', '.') }}" readonly>
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <input type="text" class="form-control" value="{{ $pengeluaran->kategori }}" readonly>
        </div>

        <div class="mb-3">
            <label for="tanggal_pengeluaran" class="form-label">Tanggal Pengeluaran</label>
            <input type="date" class="form-control" 
                value="{{ $pengeluaran->tanggal_pengeluaran }}" readonly>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3">{{ $pengeluaran->keterangan }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
@push('scripts')
<script>
  document.getElementById('form-inventori').addEventListener('submit', function(e) {
    e.preventDefault(); // cegah submit langsung

    Swal.fire({
      title: 'Yakin ingin simpan Perubahan?',
      text: 'Anda hanya dapat merubah Keterangan saja.',
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
