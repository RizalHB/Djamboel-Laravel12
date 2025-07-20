@extends('layouts.main')

@section('content')
<div class="container">
    <h3>Edit Penjualan</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('penjualan.update', $penjualan->id) }}" id="form-inventori" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>ID Transaksi</label>
            <input type="text" class="form-control" value="{{ $penjualan->transaksi_id }}" readonly>
        </div>

        <div class="mb-3">
            <label for="tanggal_penjualan">Tanggal Penjualan</label>
            <input type="date" class="form-control" value="{{ $penjualan->tanggal_penjualan }}" readonly>
        </div>

        <div class="mb-3">
            <label>Metode Pembayaran</label>
            <input type="text" class="form-control" value="{{ $penjualan->metode_pembayaran }}" readonly>
        </div>

        <div class="mb-3">
            <label>Nama / ID Kostumer</label>
            <input type="text" class="form-control" value="{{ $penjualan->nama_kostumer }}" readonly>
        </div>

        <div class="mb-3">
            <label>Status Pembayaran</label>
            <select name="status_pembayaran" class="form-control" {{ $penjualan->status_pembayaran == 'PAID' ? 'disabled' : '' }}>
                <option value="PAID" {{ $penjualan->status_pembayaran == 'PAID' ? 'selected' : '' }}>PAID</option>
                <option value="UNPAID" {{ $penjualan->status_pembayaran == 'UNPAID' ? 'selected' : '' }}>UNPAID</option>
            </select>
        </div>

        <h5>Rincian Barang</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Diskon</th>
                        <th>Subtotal</th>
                        <th>Unit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualan->details as $detail)
                    <tr>
                        <td><input type="text" class="form-control" value="{{ $detail->inventori->nama_barang }}" readonly></td>
                        <td><input type="text" class="form-control" value="{{ $detail->jumlah }}" readonly></td>
                        <td><input type="text" class="form-control" value="Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}" readonly></td>
                        <td><input type="text" class="form-control" value="{{ $detail->diskon ?? 0 }}%" readonly></td>
                        <td><input type="text" class="form-control" value="Rp {{ number_format($detail->subtotal, 0, ',', '.') }}" readonly></td>
                        <td><input type="text" class="form-control" value="{{ $detail->inventori->unit }}" readonly></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($penjualan->status_pembayaran === 'PAID')
    {{-- ✅ Tampilkan info pelunasan --}}
    <div class="mb-3 alert alert-info">
        <strong>Data Disimpan oleh:</strong> {{ $penjualan->paid_by_user->name ?? 'N/A' }} <br>
        <strong>Pada:</strong> {{ \Carbon\Carbon::parse($penjualan->tanggal_pelunasan)->format('d-m-Y') }}
    </div>

    <a href="{{ route('penjualan.struk', $penjualan->id) }}" class="btn btn-success">Unduh Struk</a>
@else
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <button type="button" class="btn btn-secondary" disabled>Unduh Struk (hanya jika PAID)</button>
@endif

    </form>
</div>
@endsection
@push('scripts')
<script>
  document.getElementById('form-inventori').addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Yakin ingin simpan Perubahan?',
      text: 'Pastikan anda benar-benar mendapatkan pembayaran sepenuhnya, karena anda tidak dapat kembali melakukan perubahan. ',
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