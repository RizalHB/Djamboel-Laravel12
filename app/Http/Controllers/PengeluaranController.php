<?php

namespace App\Http\Controllers;
use App\Exports\PengeluaranExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Pengeluaran;

class PengeluaranController extends Controller
{
    public function index(Request $request)
{
    $query = Pengeluaran::query();

    // Filter search
    if ($request->filled('search')) {
        $query->where('nama_pengeluaran', 'like', '%' . $request->search . '%');
    }

    // Filter kategori
    if ($request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }

    // Filter tanggal
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('tanggal_pengeluaran', [$request->start_date, $request->end_date]);
    }

    // Urutkan
    if ($request->filled('sort')) {
        if ($request->sort === 'nama') {
            $query->orderBy('nama_pengeluaran');
        } elseif ($request->sort === 'harga') {
            $query->orderByDesc('harga_satuan');
        } elseif ($request->sort === 'kuantitas') {
            $query->orderByDesc('kuantitas');
        }
    } else {
        // Default sort: latest by tanggal_pengeluaran
        $query->orderByDesc('tanggal_pengeluaran');
    }

    // Eksekusi pagination
    $pengeluarans = $query->paginate(25)->appends($request->all());

    // Total keseluruhan AKURAT (clone biar tidak kena pagination)
    $allPengeluaran = (clone $query)->get();
    $totalSemua = $allPengeluaran->sum(fn($p) => $p->kuantitas * $p->harga_satuan);
    $totalOverhead = $allPengeluaran->where('kategori', 'OVERHEAD COST')->sum(fn($p) => $p->kuantitas * $p->harga_satuan);
    $totalFix = $allPengeluaran->where('kategori', 'FIX COST')->sum(fn($p) => $p->kuantitas * $p->harga_satuan);

    return view('pengeluaran.index', compact('pengeluarans', 'totalSemua', 'totalOverhead', 'totalFix'));
}
    /**
     * Show the form for creating a new resource.
     */
public function create()
{
    $today = now()->format('dmY');
    $count = Pengeluaran::whereDate('created_at', today())->count() + 1;
    $idPengeluaran = 'PNG-' . $today . str_pad($count, 5, '0', STR_PAD_LEFT);

    return view('pengeluaran.create', compact('idPengeluaran'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'nama_pengeluaran' => 'required|string|max:255',
        'kuantitas' => 'required|numeric|min:0.01',
        'harga_satuan' => 'required|numeric|min:0',
        'kategori' => 'required|string',
        'tanggal_pengeluaran' => 'required|date',
        'keterangan' => 'nullable|string',
    ]);

    $idPengeluaran = 'PNG-' . now()->format('dmY') . str_pad(Pengeluaran::whereDate('created_at', today())->count() + 1, 5, '0', STR_PAD_LEFT);

    Pengeluaran::create([
        'id_pengeluaran' => $idPengeluaran,
        'nama_pengeluaran' => $request->nama_pengeluaran,
        'kuantitas' => $request->kuantitas,
        'harga_satuan' => $request->harga_satuan,
        'total_harga' => $request->kuantitas * $request->harga_satuan,
        'kategori' => $request->kategori === 'etc' && $request->filled('kategori_lainnya')
            ? $request->kategori_lainnya
            : $request->kategori,
        'tanggal_pengeluaran' => $request->tanggal_pengeluaran,
        'keterangan' => $request->keterangan,
    ]);

    return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil disimpan.');
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $pengeluaran = Pengeluaran::findOrFail($id);
    return view('pengeluaran.edit', compact('pengeluaran'));
}
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'keterangan' => 'nullable|string|max:255',
    ]);

    $pengeluaran = Pengeluaran::findOrFail($id);
    $pengeluaran->update([
        'keterangan' => $request->keterangan,
    ]);

    return redirect()->route('pengeluaran.index')->with('success', 'Keterangan berhasil diperbarui!');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil dihapus.');
    }
    
public function exportExcel(Request $request)
{
    $start = $request->input('start_date');
    $end = $request->input('end_date');

    return Excel::download(
        new PengeluaranExport($start, $end),
        'Laporan-Pengeluaran-' . now()->format('Ymd-His') . '.xlsx'
    );
}
}
