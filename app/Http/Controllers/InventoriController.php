<?php
namespace App\Http\Controllers;
use App\Models\Kostumer;
use App\Models\Inventori;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\InventoriPengeluaran;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\InventoriExport;
use Maatwebsite\Excel\Facades\Excel;
class InventoriController extends Controller
{
 public function index(Request $request) 
{
    $query = Inventori::with('supplier');

    // Filter untuk data yang ditampilkan
    if ($request->filled('search')) {
        $query->where('nama_barang', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('sort')) {
        if ($request->sort === 'nama') {
            $query->orderBy('nama_barang');
        } elseif ($request->sort === 'amount') {
            $query->orderBy('amount', 'desc');
        } elseif ($request->sort === 'harga') {
            $query->orderBy('price_per_unit', 'desc');
        }
    }

    if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
        $query->whereBetween('tanggal_pembelian', [$request->tanggal_awal, $request->tanggal_akhir]);
    }

    // Ambil data untuk tampilan tabel dengan pagination
    $inventoris = $query->paginate(25)->appends($request->all());

    // Hitung total harga seluruh hasil query tanpa pagination
    $totalHargaQuery = Inventori::query();
    if ($request->filled('search')) {
        $totalHargaQuery->where('nama_barang', 'like', '%' . $request->search . '%');
    }
    if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
        $totalHargaQuery->whereBetween('tanggal_pembelian', [$request->tanggal_awal, $request->tanggal_akhir]);
    }

    $totalHarga = $totalHargaQuery->sum(DB::raw('amount * price_per_unit'));

    // Total pembelian keseluruhan (semua stok masuk, tidak terpengaruh filter tanggal)
    $totalDariCreate = DB::table('inventoris')->sum(DB::raw('initial_amount * price_per_unit'));
    $totalTambahStok = DB::table('inventori_pengeluarans')->sum(DB::raw('jumlah * harga_satuan'));
    $totalPembelianBarang = $totalDariCreate + $totalTambahStok;

    return view('admin.inventori.index', [
        'inventoris' => $inventoris,
        'totalHarga' => $totalHarga,
        'totalPembelianBarang' => $totalPembelianBarang
    ]);
}
public function formStok($id)
{
    $inventori = Inventori::findOrFail($id);
    return view('admin.inventori.tambah_stok', compact('inventori'));
}
public function storeStok(Request $request, $id)
{
    $request->validate([
        'jumlah' => 'required|numeric|min:0.01'
    ]);

    $inventori = Inventori::findOrFail($id);
    $jumlah =(float) $request->jumlah;

    // Tambah ke stok inventori
    $inventori->increment('amount', $jumlah);

    // Simpan log pembelian stok
    InventoriPengeluaran::create([
        'inventori_id' => $inventori->id,
        'jumlah' => $jumlah,
        'harga_satuan' => $inventori->price_per_unit, // wajib!
        'tanggal' => now(), // untuk laporan
    ]);

    return redirect()->route('inventori.index')->with('success', 'Stok berhasil ditambahkan.');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'nama_barang' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'unit' => 'required|string',
        'price_per_unit' => 'required|numeric|min:0',
        'harga_jual' => 'required|numeric|min:0',
        'supplier_id' => 'nullable|exists:suppliers,id',
        'tanggal_pembelian' => 'required|date'
    ]);

    // Tambahkan nilai initial_amount berdasarkan amount saat input
    $validated['initial_amount'] = $validated['amount'];
    Inventori::create($validated);
    return redirect()->route('inventori.index')->with('success', 'Inventori berhasil ditambahkan! Data yang disimpan tidak dapat diedit.');
}


public function create()
{
    $suppliers = Supplier::all();
    $kostumers = Kostumer::all();
    return view('admin.inventori.create', compact('suppliers', 'kostumers'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'nama_barang' => 'required|string|max:255',
        'unit' => 'required|in:Kg,Ekor,Pcs,Ons',
        'amount' => 'required|integer|min:1',
        'price_per_unit' => 'required|integer|min:0',
        'tanggal_pembelian' => 'required|date',
        'supplier_id' => 'nullable|exists:suppliers,id',
    ]);
    

    $inventori = Inventori::findOrFail($id);
    $inventori->update([
    'amount' => $request->amount,
    'price_per_unit' => $request->price_per_unit,
    'harga_jual' => $request->harga_jual,
    'tanggal_pembelian' => $request->tanggal_pembelian,
    'supplier_id' => $request->supplier_id,
]);
    return redirect()->route('inventori.index')->with('success', 'Inventori berhasil diperbarui!');
}
public function formGantiHarga($id)
{
    $inventori = Inventori::findOrFail($id);
    return view('admin.inventori.ganti_hargajual', compact('inventori'));
}

public function prosesGantiHarga(Request $request, $id)
{
    $request->validate([
        'harga_jual' => 'required|numeric|min:1'
    ]);

    $inventori = Inventori::findOrFail($id);
    $inventori->update(['harga_jual' => $request->harga_jual]);

    return redirect()->route('inventori.index')->with('success', 'Harga jual berhasil diperbarui.');
}

public function exportExcel(Request $request)
{
    $start = $request->input('tanggal_awal');
    $end = $request->input('tanggal_akhir');

    return Excel::download(new InventoriExport($start, $end), 'Laporan-Pembelian-' . now()->format('Ymd-His') . '.xlsx');
}
}