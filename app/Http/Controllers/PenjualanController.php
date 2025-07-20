<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Inventori;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\Kostumer;
use App\Exports\PenjualanExport;
use Maatwebsite\Excel\Facades\Excel;
class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penjualan::with(['details.inventori']);

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('details.inventori', function ($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('metode') && $request->metode != '') {
            $query->where('metode_pembayaran', $request->metode);
        }

        if ($request->filled('status_pembayaran')) {
        $query->where('status_pembayaran', $request->status_pembayaran);
    }

        $query->orderBy('tanggal_penjualan', 'desc')->orderBy('created_at', 'desc');


        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_penjualan', [$request->start_date, $request->end_date]);
        }

    $penjualans = $query->paginate(perPage: 25)->appends($request->all());

// Ambil seluruh data PAID (tidak terpengaruh paginate)
// Ambil seluruh data PAID (ikut filter tanggal_penjualan)
$paidQuery = Penjualan::with('details')->where('status_pembayaran', 'PAID');
$unpaidQuery = Penjualan::with('details')->where('status_pembayaran', 'UNPAID');

if ($request->filled('start_date') && $request->filled('end_date')) {
    $paidQuery->whereBetween('tanggal_penjualan', [$request->start_date, $request->end_date]);
    $unpaidQuery->whereBetween('tanggal_penjualan', [$request->start_date, $request->end_date]);
}

$paidPenjualans = $paidQuery->get();
$unpaidPenjualans = $unpaidQuery->get();

$totalPenjualan = $paidPenjualans->sum(fn($p) => $p->details->sum('subtotal'));
$totalCash = $paidPenjualans->where('metode_pembayaran', 'CASH')->sum(fn($p) => $p->details->sum('subtotal'));
$totalQris = $paidPenjualans->where('metode_pembayaran', 'QRIS')->sum(fn($p) => $p->details->sum('subtotal'));
$totalTransfer = $paidPenjualans->where('metode_pembayaran', 'TRANSFER')->sum(fn($p) => $p->details->sum('subtotal'));

$totalUnpaid = $unpaidPenjualans->sum(fn($p) => $p->details->sum('subtotal'));


return view('penjualan.index', compact(
    'penjualans', 'totalCash', 'totalQris', 'totalTransfer', 'totalPenjualan', 'totalUnpaid'
));
    }
public function create()
{
    $inventoris = Inventori::where('amount', '>', 0)->get();
    $kostumers = Kostumer::all();

    $today = now()->format('dmY');
    
    $prefixTransaksi = 'TRS' . $today;
    $lastTransaksi = Penjualan::where('transaksi_id', 'like', $prefixTransaksi . '%')
         ->whereDate('created_at', now()->format('Y-m-d'))
        ->get()
        ->sortByDesc(fn($item) => (int) substr($item->transaksi_id, -4))
        ->first();

    $nextUrutan = $lastTransaksi
        ? (int) substr($lastTransaksi->transaksi_id, -4) + 1
        : 1;

    $nextTransactionId = $prefixTransaksi . str_pad($nextUrutan, 4, '0', STR_PAD_LEFT);

    
    $prefixIKO = 'IKO' . $today;
    $ikoCount = Penjualan::whereDate('tanggal_penjualan', now())
        ->where('nama_kostumer', 'like', $prefixIKO . '%')
        ->count();

    $nextIkoId = $prefixIKO . str_pad($ikoCount + 1, 2, '0', STR_PAD_LEFT);

    return view('penjualan.create', compact('inventoris', 'kostumers', 'nextTransactionId', 'nextIkoId'));
}
    public function store(Request $request) 
{
    $request->validate([
        'barang.*.inventori_id' => 'required|exists:inventoris,id',
        'barang.*.jumlah' => 'required|numeric|min:0.01',
        'barang.*.harga_satuan' => 'required|numeric|min:0',
        'barang.*.diskon' => 'nullable|integer|min:0|max:100',
        'tanggal_penjualan' => 'required|date',
        'metode_pembayaran' => 'required|in:CASH,QRIS,TRANSFER',
        'status_pembayaran' => 'required|in:PAID,UNPAID',
    ]);

    DB::beginTransaction();

    try {
        $tanggalObj = Carbon::parse($request->tanggal_penjualan);
        $tanggal = $tanggalObj->format('dmY');
        $prefix = 'TRS-' . $tanggal;

        $lastTransaksiHariIni = Penjualan::where('transaksi_id', 'like', $prefix . '%')
            ->get()
            ->sortByDesc(fn($item) => (int) substr($item->transaksi_id, -4))
            ->first();

        $nextUrutan = $lastTransaksiHariIni
            ? (int) substr($lastTransaksiHariIni->transaksi_id, -4) + 1
            : 1;

        $transaksiId = $prefix . str_pad($nextUrutan, 4, '0', STR_PAD_LEFT);

        $penjualan = Penjualan::create([
            'metode_pembayaran' => $request->metode_pembayaran,
            'tanggal_penjualan' => $request->tanggal_penjualan,
            'transaksi_id' => $transaksiId,
            'nama_kostumer' => '',
            'total_harga' => 0,
            'status_pembayaran' => $request->status_pembayaran
        ]);

        // Tentukan nama kostumer
        $namaKostumer = null;

        if ($request->id_only == '1') {
            $prefixIKO = 'IKO' . $tanggal;
            $lastIkoHariIni = Penjualan::whereDate('tanggal_penjualan', $tanggalObj)
    ->where('nama_kostumer', 'like', $prefixIKO . '%')
    ->count();
            $ikoUrutan = str_pad($lastIkoHariIni + 1, 2, '0', STR_PAD_LEFT);
            $namaKostumer = $prefixIKO . $ikoUrutan;

        } elseif ($request->manual_input_toggle == '1') {
            $namaKostumer = $request->nama_kostumer;
        } elseif ($request->filled('kostumer_id')) {
            $kostumer = Kostumer::findOrFail($request->kostumer_id);
            $namaKostumer = $kostumer->nama;
        }

        $penjualan->update(['nama_kostumer' => $namaKostumer]);

        $totalHarga = 0;

        foreach ($request->barang as $item) {
            $inventori = Inventori::findOrFail($item['inventori_id']);
            $jumlah = (float) $item['jumlah'];
            $hargaSatuan = (float) $item['harga_satuan'];
            $diskon = isset($item['diskon']) ? (int) $item['diskon'] : 0;

            if ($inventori->amount < $jumlah) {
                throw new \Exception("Stok tidak cukup untuk {$inventori->nama_barang}.");
            }

            $subtotal = $jumlah * $hargaSatuan;
            $subtotalSetelahDiskon = round($subtotal * (1 - $diskon / 100));

            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'inventori_id' => $inventori->id,
                'jumlah' => $jumlah,
                'harga_satuan' => $hargaSatuan,
                'subtotal' => $subtotalSetelahDiskon,
                'diskon' => $diskon > 0 ? $diskon : null,
            ]);

            $inventori->decrement('amount', $jumlah);
            $totalHarga += $subtotalSetelahDiskon;
        }

        $penjualan->update(['total_harga' => $totalHarga]);
        if ($request->status_pembayaran === 'PAID') {
        $penjualan->update([
        'paid_by_user_id' => Auth::id(),
        'tanggal_pelunasan' => now(),
    ]);
    }

        DB::commit();

        return redirect()->route('penjualan.index')
            ->with('success', 'Penjualan berhasil disimpan.')
            ->with('struk_id', $penjualan->id);

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal menyimpan penjualan: ' . $e->getMessage());
    }
}
    public function edit($id)
{
    $penjualan = Penjualan::with(['details.inventori', 'paid_by_user'])->findOrFail($id);
    return view('penjualan.edit', compact('penjualan'));
}
public function update(Request $request, $id)
{
    $penjualan = Penjualan::findOrFail($id);
    $request->validate([
        'status_pembayaran' => 'required|in:PAID,UNPAID'
    ]);

    if ($penjualan->status_pembayaran === 'UNPAID' && $request->status_pembayaran === 'PAID') {
        $penjualan->update([
            'status_pembayaran' => 'PAID',
            'paid_by_user_id' => Auth::id(), 
            'tanggal_pelunasan' => now(),
        ]);
    } else {
        $penjualan->update(['status_pembayaran' => $request->status_pembayaran]);
    }

    return redirect()->route('penjualan.index')->with('success', 'Status pembayaran berhasil diperbarui.');
}
    public function destroy($id)
    {
        $penjualan = Penjualan::with('details')->findOrFail($id);

        foreach ($penjualan->details as $detail) {
            $inventori = Inventori::find($detail->inventori_id);
            if ($inventori) {
                $inventori->amount += $detail->jumlah;
                $inventori->save();
            }
        }

        $penjualan->details()->delete();
        $penjualan->delete();

        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil dihapus dan stok dikembalikan.');
    }
    public function cetakStruk($id)
{
    $penjualan = Penjualan::with('details.inventori')->findOrFail($id);
      if ($penjualan->status_pembayaran !== 'PAID') {
        return redirect()->route('penjualan.index')->with('error', 'Struk hanya tersedia jika transaksi sudah PAID.');
    }
    $pdf = Pdf::loadView('penjualan.struk', compact('penjualan'));
    $pdf->setPaper([0, 0, 226.77, 170.08]); // 75mm x 60mm

    return $pdf->stream('struk_penjualan.pdf');
}
public function grafikPendapatanHarian(Request $request)
{
    $query = Penjualan::query()
        ->where('status_pembayaran', 'PAID');

    // Ganti: gunakan tanggal_pelunasan sebagai dasar filter tanggal
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('tanggal_pelunasan', [$request->start_date, $request->end_date]);
    }

    // Ganti: groupBy tanggal_pelunasan, bukan tanggal_penjualan
    $data = $query->get()
        ->groupBy('tanggal_pelunasan')
        ->map(function ($group) {
            return [
                'tanggal' => $group->first()->tanggal_pelunasan,
                'CASH' => $group->where('metode_pembayaran', 'CASH')->sum('total_harga'),
                'QRIS' => $group->where('metode_pembayaran', 'QRIS')->sum('total_harga'),
                'TRANSFER' => $group->where('metode_pembayaran', 'TRANSFER')->sum('total_harga'),
            ];
        })
        ->sortKeys()
        ->values();

    return response()->json($data);
}
public function exportExcel(Request $request)
{
    $start = $request->input('start_date');
    $end = $request->input('end_date');

    return Excel::download(
        new PenjualanExport($start, $end),
        'Laporan-Penjualan-' . now()->format('Ymd-His') . '.xlsx'
    );
}


}