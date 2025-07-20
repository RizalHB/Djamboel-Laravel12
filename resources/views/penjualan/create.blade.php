@extends('layouts.main')

@section('content')
<div class="container">
    <h2 class="mb-4">Tambah Penjualan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('penjualan.store') }}" method="POST" id="form-inventori">
        @csrf

        {{-- BARANG --}}
        <div id="barang-container">
            <div class="barang-item row g-2 mb-3 align-items-end">
                <div class="col-md-3">
                    <label>Barang</label>
                    <select name="barang[0][inventori_id]" class="form-control barang-select" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach ($inventoris as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->kode_barang }} - {{ $item->nama_barang }} ({{ number_format($item->amount, 2) }} {{ $item->unit }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Jumlah</label>
                    <input type="number" step="0.01" name="barang[0][jumlah]" min="0.01" class="form-control jumlah-input" required>
                </div>

                <div class="col-md-2">
                    <label>Harga Jual</label>
                    <input type="hidden" name="barang[0][harga_satuan]" class="form-control harga-jual">
                    <input type="text" class="form-control harga-jual-view" placeholder="Harga Otomatis" readonly>
                </div>

                <div class="col-md-3">
                    <label>Total Barang</label>
                    <p class="form-control-plaintext subtotal-text">Rp0</p>
                </div>

                <div class="col-md-1">
                    <label>
                        <input type="checkbox" class="form-check-input apply-discount"> Diskon
                        <input type="hidden" name="barang[0][diskon]" value="0" class="diskon-hidden">
                    </label>
                    <div class="discount-label text-muted mt-1">Diskon: <span class="discount-value">0%</span></div>
                    <input type="range" class="form-range discount-range" min="1" max="100" value="0" hidden>
                </div>

                <div class="col-md-1">
                    <button type="button" class="btn btn-danger remove-barang">Hapus</button>
                </div>
            </div>
        </div>

        <button type="button" id="tambah-barang" class="btn btn-primary my-3">+ Tambah Barang</button>
        {{-- Tanggal Penjualan --}}
        <div class="mb-3">
            <label for="tanggal_penjualan">Tanggal Penjualan</label>
            <input type="date" name="tanggal_penjualan" class="form-control" required value="{{ now()->toDateString() }}" readonly>
        </div>

        {{-- Kostumer --}}
        <div class="mb-3">
            <label for="kostumer_id">Kostumer</label>
            <select name="kostumer_id" id="kostumer_id" class="form-select">
                <option value="">-- Pilih Kostumer Terdaftar --</option>
                @foreach ($kostumers as $kostumer)
                    <option value="{{ $kostumer->id }}">{{ $kostumer->nama }}</option>
                @endforeach
            </select>
        </div>

        {{-- Toggle Kostumer Manual --}}
        <div class="form-check mb-2">
            <input type="checkbox" class="form-check-input" id="manual_input_toggle">
            <label class="form-check-label" for="manual_input_toggle">Kostumer Non-Vendor</label>
        </div>

        {{-- Toggle ID Only --}}
        <div class="form-check mb-2">
            <input type="checkbox" class="form-check-input" id="idOnly">
            <label class="form-check-label" for="idOnly">Masukan ID Otomatis saja untuk nama pembeli yang tidak diketahui</label>
        </div>

        {{-- Nama Kostumer Manual --}}
        <div class="mb-3">
            <label for="nama_kostumer">Nama Kostumer Manual</label>
            <input type="text" name="nama_kostumer" id="nama_kostumer" class="form-control" readonly>
        </div>
        <input type="hidden" name="manual_input_toggle" id="manual_input_toggle_hidden" value="0">
        <input type="hidden" name="id_only" id="id_only_hidden" value="0">
        {{-- Metode Pembayaran --}}
        <div class="mb-3">
            <label for="metode_pembayaran">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control" required>
                <option value="">-- Pilih Metode --</option>
                <option value="CASH">CASH</option>
                <option value="QRIS">QRIS</option>
                <option value="TRANSFER">TRANSFER</option>
            </select>
        </div>

        {{-- Status Pembayaran --}}
        <div class="mb-3">
            <label for="status_pembayaran">Status Pembayaran</label>
            <select name="status_pembayaran" class="form-control" required>
                <option value="PAID">PAID</option>
                <option value="UNPAID">UNPAID</option>
            </select>
        </div>

        {{-- Total --}}
        <div class="mb-4">
            <h5>Total Biaya Dibayarkan: <span id="total-semua">Rp0</span></h5>
        </div>
        {{-- Submit --}}
        <div class="d-grid">
            <button type="submit" class="btn btn-success">Simpan Penjualan</button>
        </div>
    </form>
</div>
@endsection
{{-- SCRIPT --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const manualToggle = document.getElementById('manual_input_toggle');
    const idOnlyToggle = document.getElementById('idOnly');
    const namaInput = document.getElementById('nama_kostumer');
    const kostumerDropdown = document.getElementById('kostumer_id');
    const idOnlyHidden = document.getElementById('id_only_hidden');
    const manualHidden = document.getElementById('manual_input_toggle_hidden');
    const nextIkoId = @json($nextIkoId); // ✅ Dikirim dari controller

    // Reset semua agar hanya 1 mode aktif
    function resetAllKostumerOptions() {
        manualToggle.checked = false;
        idOnlyToggle.checked = false;
        manualHidden.value = 0;
        idOnlyHidden.value = 0;
        namaInput.value = '';
        namaInput.setAttribute('readonly', 'readonly');
        kostumerDropdown.removeAttribute('disabled');
    }

    manualToggle.addEventListener('change', function () {
        if (this.checked) {
            idOnlyToggle.checked = false;
            idOnlyHidden.value = 0;
            manualHidden.value = 1;
            namaInput.value = '';
            namaInput.removeAttribute('readonly');
            kostumerDropdown.setAttribute('disabled', 'disabled');
        } else {
            manualHidden.value = 0;
            namaInput.value = '';
            namaInput.setAttribute('readonly', 'readonly');
            kostumerDropdown.removeAttribute('disabled');
        }
    });

    idOnlyToggle.addEventListener('change', function () {
        if (this.checked) {
            manualToggle.checked = false;
            manualHidden.value = 0;
            idOnlyHidden.value = 1;
            namaInput.value = nextIkoId;
            namaInput.setAttribute('readonly', 'readonly');
            kostumerDropdown.setAttribute('disabled', 'disabled');
        } else {
            idOnlyHidden.value = 0;
            namaInput.value = '';
            kostumerDropdown.removeAttribute('disabled');
        }
    });
});
// Harga dan stok dari server
let hargaJualMap = {!! json_encode($inventoris->pluck('harga_jual', 'id')) !!};
let stokMap = {!! json_encode($inventoris->pluck('amount', 'id')) !!};
let index = 1;

function formatRupiah(num) {
    return 'Rp' + (parseFloat(num) || 0).toLocaleString('id-ID');
}

function updateSelectOptions() {
    const selectedValues = $('.barang-select').map(function () {
        return $(this).val();
    }).get();

    $('.barang-select').each(function () {
        const current = $(this).val();
        $(this).find('option').each(function () {
            const val = $(this).val();
            if (!val) return;
            $(this).toggle(val === current || !selectedValues.includes(val));
        });
    });
}

function updateTotals() {
    let total = 0;

    $('.barang-item').each(function () {
        const row = $(this);
        const jumlah = parseFloat(row.find('.jumlah-input').val()) || 0;
        const harga = parseFloat(row.find('.harga-jual').val()) || 0;
        const discount = row.find('.discount-range').is(':visible') ? parseInt(row.find('.discount-range').val()) || 0 : 0;
        const subtotal = jumlah * harga;
        const afterDiscount = Math.round(subtotal * (1 - discount / 100));

        row.find('.diskon-hidden').val(discount);
        const label = row.find('.subtotal-text');
        const color = afterDiscount < subtotal ? 'red' : 'green';

        if (discount > 0) {
            label.html(`<s>${formatRupiah(subtotal)}</s> <span style="color:${color}">${formatRupiah(afterDiscount)}</span>`);
        } else {
            label.text(formatRupiah(subtotal));
        }

        row.find('.discount-value').text(discount + '%');
        total += afterDiscount;
    });

    $('#total-semua').text(formatRupiah(total));
}

$('#barang-container').on('input change','.barang-select, .jumlah-input, .discount-range', function () {
    const row = $(this).closest('.barang-item');
    const selectedId = row.find('.barang-select').val();
    const jumlah = parseFloat(row.find('.jumlah-input').val()) || 0;
    const harga = hargaJualMap[selectedId] || 0;
    const stok = stokMap[selectedId] || 0;

    row.find('.harga-jual').val(harga);
    row.find('.harga-jual-view').val(formatRupiah(harga));

    if (jumlah > stok) {
        alert(`Stok hanya tersedia ${stok}`);
        row.find('.jumlah-input').val(stok);
    }

    updateTotals();
    updateSelectOptions();
});

$('#barang-container').on('change', '.apply-discount', function () {
    const row = $(this).closest('.barang-item');
    const range = row.find('.discount-range');
    if (this.checked) {
        range.prop('hidden', false).val(5);
    } else {
        range.prop('hidden', true).val(0);
    }
    updateTotals();
});

$('#tambah-barang').on('click', function () {
    const row = $('.barang-item').first().clone();
    row.find('select, input').each(function () {
        const name = $(this).attr('name');
        if (name) {
            const match = name.match(/\[\d+\]\[(\w+)\]/);
            if (match) {
                $(this).attr('name', `barang[${index}][${match[1]}]`);
            }
        }
        if (!$(this).is('[readonly]')) {
            $(this).val('');
        }
    });

    row.find('.harga-jual-view').val('');
    row.find('.harga-jual').val('');
    row.find('.diskon-hidden').val(0);
    row.find('.discount-value').text('0%');
    row.find('.subtotal-text').text('Rp0');
    row.find('.discount-range').prop('hidden', true).val(0);
    row.find('.apply-discount').prop('checked', false);

    $('#barang-container').append(row);
    index++;
    updateSelectOptions();
});

$('#barang-container').on('click', '.remove-barang', function () {
    if ($('.barang-item').length > 1) {
        $(this).closest('.barang-item').remove();
        updateTotals();
        updateSelectOptions();
    }
});

$(document).ready(function () {
    updateSelectOptions();
    updateTotals();
});
</script>
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
<script>
document.addEventListener('DOMContentLoaded', function () {
  const toggle = document.getElementById('manual_input_toggle');
  const namaInput = document.getElementById('nama_kostumer');
  const form = document.getElementById('form-inventori');

  // Ubah readonly jika toggle dicentang
  toggle.addEventListener('change', function () {
    if (toggle.checked) {
      namaInput.removeAttribute('readonly');
    } else {
      namaInput.value = '';
      namaInput.setAttribute('readonly', true);
    }
  });

  // Validasi sebelum submit
  form.addEventListener('submit', function (e) {
    if (toggle.checked && namaInput.value.trim() === '') {
      e.preventDefault();
      alert('Anda belum mengisi nama kostumer, harap Input kembali');
    }
  });
});
</script>
@endpush