@extends('layouts.main')
@section('content')
<div class="container">
    <h3>Tambah Pengeluaran Lainnya</h3>

    <form action="{{ route('pengeluaran.store') }}" id="form-inventori" method="POST">
        @csrf
        <div class="mb-3">
        <label>ID Pengeluaran</label>
        <input type="text" class="form-control" value="{{ $idPengeluaran }}" readonly>
        </div>
        <div class="mb-3">
            <label>Nama Pengeluaran</label>
            <input type="text" name="nama_pengeluaran" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Kuantitas</label>
            <input type="number" name="kuantitas" min="1" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Harga Satuan</label>
            <input type="number" name="harga_satuan" class="form-control" min="0" required>
        </div>
        <select name="kategori" id="kategori" class="form-select" required onchange="toggleJenisLainnya()">
    <option value="">-- Pilih Kategori --</option>
    <option value="transport">Transport</option>
    <option value="listrik">Listrik</option>
    <option value="clutter">Clutter</option>
    <option value="etc">Etc (Lainnya)</option>
</select>

<div class="mt-2" id="jenis-lainnya-wrapper" style="display: none;">
    <input type="text" name="kategori_lainnya" class="form-control" placeholder="Isi kategori lainnya">
</div>
       
        <div class="mb-3">
            <label>Tanggal Pengeluaran</label>
            <input type="date" name="tanggal_pengeluaran" class="form-control" required value="{{ now()->toDateString() }}" readonly>
        </div>

        <div class="mb-3">
            <label>Keterangan (Opsional)</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
@push('scripts')
<script>
function toggleJenisLainnya() {
    const kategori = document.getElementById('kategori').value;
    const wrapper = document.getElementById('jenis-lainnya-wrapper');
    if (kategori === 'etc') {
        wrapper.style.display = 'block';
    } else {
        wrapper.style.display = 'none';
    }
}
</script>
<script>
  document.getElementById('form-inventori').addEventListener('submit', function(e) {
    e.preventDefault(); 
    Swal.fire({
      title: 'Yakin ingin simpan Data?',
      text: 'Data yang sudah disimpan tidak dapat dirubah, anda hanya bisa merubah keterangan.',
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