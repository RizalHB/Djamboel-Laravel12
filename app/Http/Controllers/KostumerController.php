<?php
namespace App\Http\Controllers;
use App\Models\Kostumer;
use Illuminate\Http\Request;
use App\Exports\KostumerExport;
use Maatwebsite\Excel\Facades\Excel;
class KostumerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kostumers = Kostumer::latest()->paginate(25);        
        return view('admin.kostumer.index', compact('kostumers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'no_telepon' => 'nullable|string|max:50',
        'alamat' => 'nullable|string|max:255',
    ]);

    Kostumer::create($validated);

    return redirect()->route('kostumer.index')->with('success', 'Kostumer berhasil ditambahkan!');
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $kostumer = Kostumer::findOrFail($id);
    return view('admin.kostumer.edit', compact('kostumer'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'no_telepon' => 'nullable|string|max:20',
        'alamat' => 'nullable|string|max:255',
    ]);

    $kostumer = Kostumer::findOrFail($id);
    $kostumer->update([
        'no_telepon' => $request->no_telepon,
        'alamat' => $request->alamat,
    ]);

    return redirect()->route('kostumer.index')->with('success', 'Data kostumer berhasil diperbarui.');
}
    public function exportExcel()
{
    return Excel::download(new KostumerExport, 'Laporan-Kostumer-'.now()->format('Ymd-His').'.xlsx');
}
}
