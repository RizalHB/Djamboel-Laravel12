@extends('layouts.main')
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('struk_id'))
            window.open("{{ route('penjualan.struk', session('struk_id')) }}", '_blank');
        @endif
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.getElementById('filter-grafik-pendapatan').addEventListener('submit', function (e) {
    e.preventDefault();

    const start = document.getElementById('pendapatan_start').value;
    const end = document.getElementById('pendapatan_end').value;
    if (!start || !end) return alert("Tanggal wajib diisi.");

    fetch(`{{ route('penjualan.grafik_pendapatan') }}?start_date=${start}&end_date=${end}`)
        .then(res => res.json())
        .then(data => {
            if (!Array.isArray(data) || data.length === 0) {
                alert("Tidak ada data.");
                return;
            }

            const labels = data.map(d => d.tanggal);
const cash = data.map(d => d.CASH);
const qris = data.map(d => d.QRIS);
const transfer = data.map(d => d.TRANSFER);
const total = data.map(d => d.CASH + d.QRIS + d.TRANSFER);

const ctx = document.getElementById('grafikPendapatanHarian').getContext('2d');
if (window.chartPendapatan) window.chartPendapatan.destroy();

window.chartPendapatan = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'CASH',
                data: cash,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.1)',
                tension: 0.3,
            },
            {
                label: 'QRIS',
                data: qris,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                tension: 0.3,
            },
            {
                label: 'TRANSFER',
                data: transfer,
                borderColor: 'rgba(255, 206, 86, 1)',
                backgroundColor: 'rgba(255, 206, 86, 0.1)',
                tension: 0.3,
            },
            {
                label: 'Total Penjualan',
                data: total,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                borderWidth: 2,
                tension: 0.4,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            duration: 1000,
            easing: 'easeOutQuart'
        },
        plugins: {
            tooltip: {
                mode: 'index',
                intersect: false
            },
            legend: {
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Total Pendapatan (Rp)'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Tanggal'
                }
            }
        }
    }
});
        });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const downloadBtn = document.getElementById('downloadExcel');
    const form = document.getElementById('filterForm');
    const originalAction = form.action;

    downloadBtn.addEventListener('click', function (e) {
        e.preventDefault();

        form.action = "{{ route('penjualan.export.excel') }}";
        form.submit();

        // Kembalikan ke action semula agar tombol filter tetap berfungsi
        setTimeout(() => {
            form.action = originalAction;
        }, 1000);
    });
});
</script>
@endpush
@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Penjualan</h5>
            <a href="{{ route('penjualan.create') }}" class="btn btn-light text-primary">+ Tambah Penjualan</a>
        </div>
        <div class="card-body p-4">
            <form method="GET" action="{{ route('penjualan.index') }}" class="row g-2 mb-4">
                <div class="col-md-3">
    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
</div>
<div class="col-md-3">
    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
</div>

                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama barang..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="metode" class="form-select">
                        <option value="">-- Semua Metode --</option>
                        <option value="CASH" {{ request('metode') == 'CASH' ? 'selected' : '' }}>CASH</option>
                        <option value="QRIS" {{ request('metode') == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                        <option value="TRANSFER" {{ request('metode') == 'TRANSFER' ? 'selected' : '' }}>TRANSFER</option>
                    </select>
                </div>
                {{--  Filter Status Pembayaran --}}
    <div class="col-md-3">
        
        <select name="status_pembayaran" id="status_pembayaran" class="form-select">
            <option value="">-- Semua --</option>
            <option value="PAID" {{ request('status_pembayaran') == 'PAID' ? 'selected' : '' }}>PAID</option>
            <option value="UNPAID" {{ request('status_pembayaran') == 'UNPAID' ? 'selected' : '' }}>UNPAID</option>
        </select>
    </div>
                <div class="col-md-2">
                    <select name="sort" class="form-select">
                        <option value="">-- Urutkan --</option>
                        <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama Barang</option>
                        <option value="jumlah" {{ request('sort') == 'jumlah' ? 'selected' : '' }}>Jumlah Terjual</option>
                        <option value="harga" {{ request('sort') == 'harga' ? 'selected' : '' }}>Harga Jual per Unit</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Filter</button>
                </div>
                <div class="col-md-2">
                    <a 
    href="{{ route('penjualan.export.excel', request()->only(['start_date', 'end_date', 'search', 'metode', 'status_pembayaran', 'sort'])) }}" 
    class="btn btn-primary"
>
    Unduh Excel
</a>
                </div>
            </form>
            


            <div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <strong>Total Penjualan (PAID):</strong>
                <div>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <strong>Total Pembayaran CASH:</strong>
                <div>Rp {{ number_format($totalCash, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-dark bg-warning">
            <div class="card-body">
                <strong>Total Pembayaran QRIS:</strong>
                <div>Rp {{ number_format($totalQris, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-secondary">
            <div class="card-body">
                <strong>Total Pembayaran TRANSFER:</strong>
                <div>Rp {{ number_format($totalTransfer, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Optional: Tampilkan unpaid jika mau --}}
@if ($totalUnpaid > 0)
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <strong>Total Transaksi UNPAID:</strong>
                <div>Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>
@endif
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
    <thead class="table-primary">
        <tr>
            <th>ID Transaksi</th>
            <th>Nama Barang</th>
            <th>Jumlah Terjual</th>
            <th>Harga Jual/Unit</th>
            <th>Total Harga</th>
            <th>Unit</th>
            <th>Metode</th>
            <th>Tanggal Transaksi</th>
            <th>Kostumer</th>
            <th>Status</th>
            <th>Tanggal Pelunasan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($penjualans as $penjualan)        
        @foreach ($penjualan->details as $detail)
        <tr>
            <td>{{ $penjualan->transaksi_id }}</td>
            <td>{{ $detail->inventori->nama_barang ?? '-' }}</td>
            <td>{{ number_format($detail->jumlah, 2) }}</td>
            <td>
                Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                @if ($detail->diskon)
                    <div class="text-muted small">Diskon: {{ $detail->diskon }}%</div>
                @endif
            </td>
            <td>
                @if ($detail->diskon)
                    <s>Rp{{ number_format($detail->harga_satuan * $detail->jumlah, 0, ',', '.') }}</s><br>
                    <span class="text-danger">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                @else
                    Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                @endif
            </td>
            <td>{{ $detail->inventori->unit ?? '-' }}</td>
            <td>{{ $penjualan->metode_pembayaran }}</td>
            <td>{{ \Carbon\Carbon::parse($penjualan->tanggal_penjualan)->translatedFormat('d F Y') }}</td>
            <td>{{ $penjualan->nama_kostumer }}</td>
            <td>
                @if ($penjualan->status_pembayaran == 'PAID')
                    <span class="badge bg-success">PAID</span>
                @else
                    <span class="badge bg-danger">UNPAID</span>
                @endif
            </td>
            <td>
                {{ $penjualan->tanggal_pelunasan 
                    ? \Carbon\Carbon::parse($penjualan->tanggal_pelunasan)->translatedFormat('d F Y') 
                    : 'Belum Lunas' }}
            </td>
            <td>
                <a href="{{ route('penjualan.edit', $penjualan->id) }}" class="btn btn-sm btn-warning">Status Pembayaran</a>
                <a href="{{ route('penjualan.struk', $penjualan->id) }}" class="btn btn-sm btn-primary">Print Struk Transaksi</a>
            </td>
        </tr>
        @endforeach

        <tr class="table-info">
            <td colspan="100%" class="text-start fw-bold">
                Total Transaksi ID {{ $penjualan->transaksi_id }}:
                Rp {{ number_format($penjualan->details->sum('subtotal'), 0, ',', '.') }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="100%" class="text-center text-muted">Belum ada data penjualan.</td>
        </tr>
    @endforelse
</tbody>
</table>
<div class="d-flex justify-content-center mt-3">
    {{ $penjualans->links() }}
</div>
            </div>
        </div>
    </div>
    {{-- Grafik Pendapatan Harian --}}
<div class="card mt-4">
    <div class="card-header bg-red">
        <strong>Grafik Total Pendapatan Harian (Paid Only)</strong>
    </div>
    <div class="card-body">
        <form id="filter-grafik-pendapatan" class="row g-3 mb-3">
            <div class="col-md-4">
                <label for="pendapatan_start">Tanggal Awal:</label>
                <input type="date" id="pendapatan_start" name="start_date" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="pendapatan_end">Tanggal Akhir:</label>
                <input type="date" id="pendapatan_end" name="end_date" class="form-control" required>
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-success w-100">Tampilkan Grafik</button>
            </div>
        </form>
        <div style="height: 400px;">
            <canvas id="grafikPendapatanHarian"></canvas>
        </div>
    </div>
</div>
</div>
@endsection

