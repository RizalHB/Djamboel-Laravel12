@extends('layouts.main')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">
            Laporan Keuangan
        </div>
        <div class="card-body">
            <form action="{{ route('laporan.export') }}" method="POST" target="_blank" id="pdfForm">
    @csrf
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="tanggal_awal">Tanggal Awal</label>
            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label for="tanggal_akhir">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required>
        </div>
        <div class="col-md-2 align-self-end">
            <button type="button" id="btnTampilkan" class="btn btn-primary w-100">
                Tampilkan Laporan
            </button>
        </div>
        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-success w-100">
                Download PDF
            </button>
        </div>
        <div class="col-md-2 align-self-end">
            <button type="submit" formaction="{{ route('laporan.export.excel') }}" class="btn btn-warning w-100">
                Download Excel
            </button>
        </div>
    </div>
    <input type="hidden" name="chart_image" id="chart_image">
</form>
            <h5 class="mt-4 fw-bold">Total Penghasilan</h5>
            <div class="table-responsive">
                <table class="table table-bordered" id="pendapatanTable">
                    <thead class="table-primary">
                        <tr>
                            <th>Tanggal</th>
                            <th>Cash</th>
                            <th>QRIS</th>
                            <th>TRANSFER</th>
                            <th>Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody id="pendapatanBody"></tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end text-success">Total Penghasilan CASH:</th>
                            <th id="totalCash">Rp0</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-end text-primary">Total Penghasilan QRIS:</th>
                            <th id="totalQris">Rp0</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-end text-secondary">Total Penghasilan TRANSFER:</th>
                            <th id="totalTransfer">Rp0</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-end">Total Penghasilan:</th>
                            <th id="totalPendapatan">Rp0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            {{-- Analisis Bisnis --}}
<div class="card mt-4">
    <div class="card-header bg-success text-white text-center">
        <strong>Laporan Analisis Bisnis</strong>
    </div>
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between">
                <span>Total Penjualan (Paid)</span>
                <strong id="penjualanPaid">Rp 0</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Remaining Stock</span>
                <strong id="remainingStock">Rp 0</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Total Pembelian</span>
                <strong id="totalPembelian">Rp 0</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Total Biaya Operasional</span>
                <strong id="totalOperasional">Rp 0</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between bg-light">
                <span><strong>Gross Income</strong></span>
                <strong id="grossIncome" class="text-primary">Rp 0</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between bg-light" id="netIncomeBox">
                <span><strong>Net Income</strong></span>
                <strong id="netIncome" class="text-success">Rp 0</strong>
            </li>
        </ul>
    </div>
</div>

{{-- Grafik Analisis --}}
<div class="card mt-4">
    <div class="card-header bg-info text-white text-center">
        <strong>Grafik Analisis Bisnis</strong>
    </div>
    <div class="card-body">
        <canvas id="laporanChart" height="200"></canvas>
    </div>
</div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
let chartInstance = null;

document.getElementById('btnTampilkan').addEventListener('click', function () {
    const start = document.getElementById('tanggal_awal').value;
    const end = document.getElementById('tanggal_akhir').value;

    if (!start || !end) {
        alert('Silakan isi tanggal terlebih dahulu!');
        return;
    }

    fetch(`/laporan/data?tanggal_awal=${start}&tanggal_akhir=${end}`)
        .then(res => res.json())
        .then(data => {
            updatePendapatanTable(data.penjualan);
            updateAnalisisBisnis(data);
            renderPieChart(data);
        })
        .catch(error => {
            console.error(error);
            alert('Gagal memuat data laporan!');
        });
});
function updatePendapatanTable(penjualan) {
    const pendapatanByTanggal = {};
    penjualan.forEach(p => {
        const tgl = p.tanggal_penjualan;
        if (!pendapatanByTanggal[tgl]) {
            pendapatanByTanggal[tgl] = { cash: 0, qris: 0, transfer: 0 };
        }
        if (p.metode_pembayaran === 'CASH') pendapatanByTanggal[tgl].cash += parseInt(p.total_harga);
        if (p.metode_pembayaran === 'QRIS') pendapatanByTanggal[tgl].qris += parseInt(p.total_harga);
        if (p.metode_pembayaran === 'TRANSFER') pendapatanByTanggal[tgl].transfer += parseInt(p.total_harga);
    });

    let html = '';
    let totalCash = 0, totalQris = 0, totalTransfer = 0, totalAll = 0;

    Object.keys(pendapatanByTanggal).sort().forEach(tgl => {
        const { cash, qris, transfer } = pendapatanByTanggal[tgl];
        const total = cash + qris + transfer;
        totalCash += cash;
        totalQris += qris;
        totalTransfer += transfer;
        totalAll += total;

        const formattedDate = new Date(tgl).toLocaleDateString('id-ID', {
            day: '2-digit', month: 'long', year: 'numeric'
        });

        html += `<tr>
            <td>${formattedDate}</td>
            <td>Rp ${cash.toLocaleString('id-ID')}</td>
            <td>Rp ${qris.toLocaleString('id-ID')}</td>
            <td>Rp ${transfer.toLocaleString('id-ID')}</td>
            <td>Rp ${total.toLocaleString('id-ID')}</td>
        </tr>`;
    });

    document.getElementById('pendapatanBody').innerHTML = html || '<tr><td colspan="5">Tidak ada data</td></tr>';
    document.getElementById('totalCash').textContent = 'Rp ' + totalCash.toLocaleString('id-ID');
    document.getElementById('totalQris').textContent = 'Rp ' + totalQris.toLocaleString('id-ID');
    document.getElementById('totalTransfer').textContent = 'Rp ' + totalTransfer.toLocaleString('id-ID');
    document.getElementById('totalPendapatan').textContent = 'Rp ' + totalAll.toLocaleString('id-ID');
}
function updateAnalisisBisnis(data) {
    const gross = (data.total_penjualan || 0) + (data.remaining_stock || 0) - (data.total_pembelian || 0);
    const net = gross - (data.total_operasional || 0);
    
    document.getElementById('penjualanPaid').textContent = 'Rp ' + (data.total_penjualan || 0).toLocaleString('id-ID');
    document.getElementById('remainingStock').textContent = 'Rp ' + (data.remaining_stock || 0).toLocaleString('id-ID');
    document.getElementById('totalPembelian').textContent = 'Rp ' + (data.total_pembelian || 0).toLocaleString('id-ID');
    document.getElementById('totalOperasional').textContent = 'Rp ' + (data.total_operasional || 0).toLocaleString('id-ID');
    document.getElementById('grossIncome').textContent = 'Rp ' + gross.toLocaleString('id-ID');
    document.getElementById('netIncome').textContent = 'Rp ' + net.toLocaleString('id-ID');

    const netBox = document.getElementById('netIncomeBox');
    netBox.className = 'list-group-item d-flex justify-content-between bg-light ' + (net >= 0 ? 'alert-success' : 'alert-danger');

    renderPieChart(data);
}
function renderPieChart(data) {
    // PIE CHART
const ctx = document.getElementById('laporanChart').getContext('2d');
if (chartInstance) chartInstance.destroy();
chartInstance = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Penjualan', 'Biaya Operasional', 'Pembelian Stok'],
        datasets: [{
            data: [
                data.total_penjualan || 0,
                data.total_operasional || 0,
                data.total_pembelian || 0
            ],
            backgroundColor: ['#4CAF50', '#FFA726', '#F44336']
        }]
    },
    options: {
        plugins: {
            tooltip: {
    callbacks: {
        label: function (ctx) {
            return `${ctx.label}: Rp ${ctx.raw.toLocaleString('id-ID')}`;
            },
        afterLabel: function(ctx) {
            const data = ctx.chart.data.datasets[0].data;
            }
        }
    }
        }
    }
});
    // Simpan gambar base64 ke input hidden
    setTimeout(() => {
        html2canvas(document.getElementById('laporanChart')).then(canvas => {
            document.getElementById('chart_image').value = canvas.toDataURL("image/png");
        });
    }, 300);
}
</script>
@endsection
