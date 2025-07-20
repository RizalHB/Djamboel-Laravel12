<?php
namespace App\Http\Controllers;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Inventori;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\InventoriPengeluaran;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
class LaporanController extends Controller
{
    public function index()
{
    return view('laporan.index');
}
public function data(Request $request)
{
    $start = $request->tanggal_awal;
    $end = $request->tanggal_akhir;

    if (!$start || !$end) {
        return response()->json(['error' => 'Tanggal tidak lengkap'], 422);
    }

    // Penjualan paid
    $penjualan = Penjualan::where('status_pembayaran', 'PAID')
        ->whereBetween('tanggal_penjualan', [$start, $end])
        ->get();

    // Total metode
    $totalPenjualan = $penjualan->sum('total_harga');

    // Biaya Operasional
    $pengeluaran = Pengeluaran::whereBetween('tanggal_pengeluaran', [$start, $end])->get();
    $totalOperational = $pengeluaran->sum(function ($item) {
        return $item->kuantitas * $item->harga_satuan;
    });

    // Stok tersisa
    $inventori = Inventori::all();
    $remainingStock = $inventori->sum(function ($inv) {
        return $inv->amount * $inv->price_per_unit;
    });

    // TOTAL PEMBELIAN dari tabel inventori_pengeluarans
    $created = Inventori::whereBetween('created_at', [$start, $end])->get();
    $tambahStok = InventoriPengeluaran::whereBetween('tanggal', [$start, $end])->get();
    $totalAwal = Inventori::whereBetween('tanggal_pembelian', [$start, $end])
    ->sum(DB::raw('initial_amount * price_per_unit'));
    $totalTambah = $tambahStok->sum(fn($i) => $i->jumlah * $i->harga_satuan);
    $totalPembelian = $totalAwal + $totalTambah;
    return response()->json([
        'penjualan' => $penjualan->map(function ($p) {
            return [
                'tanggal_penjualan' => $p->tanggal_penjualan,
                'metode_pembayaran' => $p->metode_pembayaran,
                'total_harga' => $p->total_harga,
            ];
        }),
        'inventori_pengeluaran' => $tambahStok->map(function ($i) {
            return [
                'nama_barang' => $i->inventori->nama_barang ?? '-',
                'amount' => $i->jumlah,
                'unit' => $i->inventori->unit ?? '-',
                'price_per_unit' => $i->harga_satuan,
            ];
        }),
        'total_penjualan' => $totalPenjualan,
        'total_operasional' => $totalOperational,
        'total_pembelian' => $totalPembelian,
        'remaining_stock' => $remainingStock,
    ]);
}
    public function export(Request $request)
{
    $awal = $request->tanggal_awal;
    $akhir = $request->tanggal_akhir;

    $penjualan = Penjualan::where('status_pembayaran', 'paid')
        ->whereBetween('tanggal_penjualan', [$awal, $akhir])
        ->get();

    $totalPenjualan = $penjualan->sum('total_harga');

    $remainingStock = Inventori::sum(DB::raw('amount * price_per_unit'));

    $totalAwal = Inventori::whereBetween('created_at', [$awal, $akhir])
    ->sum(DB::raw('initial_amount * price_per_unit'));

$totalTambah = DB::table('inventori_pengeluarans')
    ->whereBetween('tanggal', [$awal, $akhir])
    ->sum(DB::raw('jumlah * harga_satuan'));

$totalPembelian = $totalAwal + $totalTambah;
$operationalCost = Pengeluaran::whereBetween('tanggal_pengeluaran', [$awal, $akhir])
        ->sum(DB::raw('kuantitas * harga_satuan'));
$grossIncome = $totalPenjualan + $remainingStock - $totalPembelian;
$netIncome = $grossIncome - $operationalCost;
$pdf = Pdf::loadView('laporan.pdf', compact(
        'totalPenjualan',
        'remainingStock',
        'totalPembelian',
        'operationalCost',
        'grossIncome',
        'netIncome',
        'awal',
        'akhir'
    ))->setPaper('A4', 'portrait');
    return $pdf->stream('Laporan_Analisis_Bisnis_' . $awal . '_sd_' . $akhir . '.pdf');
}
public function exportExcel(Request $request)
{
    $start = $request->input('tanggal_awal');
    $end = $request->input('tanggal_akhir');

    return Excel::download(new LaporanExport($start, $end), 'Laporan-Penghasilan-' . now()->format('Ymd-His') . '.xlsx');
}
}
