<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SupplierExport;
class SupplierController extends Controller
{
    public function index(Request $request)
{
    $query = Supplier::query();

    if ($request->has('search') && $request->search != '') {
        $query->where('nama', 'like', '%' . $request->search . '%')
              ->orWhere('alamat', 'like', '%' . $request->search . '%');
    }

    $suppliers = $query->paginate(25)->appends($request->all());

    return view('supplier.index', compact('suppliers'));
}
    public function create()
{
    $today = now()->format('dmY');
    $countToday = Supplier::whereDate('created_at', now())->count() + 1;
    $generatedId = 'SPL-' . $today . str_pad($countToday, 5, '0', STR_PAD_LEFT);

    return view('supplier.create', compact('generatedId'));
}


    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'alamat' => 'required|string',
        'no_rekening' => 'nullable|string|max:50',
        'no_telepon' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'id_supplier' => 'required|string|unique:suppliers,id_supplier'
    ]);

    Supplier::create($request->all());

    return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
}
    public function edit($id)
{
    $supplier = Supplier::findOrFail($id);
    return view('supplier.edit', compact('supplier'));
}
public function update(Request $request, $id)
{
    $supplier = Supplier::findOrFail($id);

    $request->validate([
        'alamat' => 'required|string',
        'no_rekening' => 'nullable|string|max:50',
        'no_telepon' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
    ]);

    $supplier->update([
        'alamat' => $request->alamat,
        'no_rekening' => $request->no_rekening,
        'no_telepon' => $request->no_telepon,
        'email' => $request->email,
    ]);

    return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diperbarui.');
}

public function exportExcel()
{
    return Excel::download(new SupplierExport, 'Laporan-Supplier-' . now()->format('Ymd-His') . '.xlsx');
}
}
