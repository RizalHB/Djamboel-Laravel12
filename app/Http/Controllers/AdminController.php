<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Inventori;
use App\Models\Kostumer;
class AdminController extends Controller
{
    public function dashboard()
{
    $suppliers = Supplier::latest()->take(5)->get();
    
    $inventoris = Inventori::where('amount', '>', 0)
    ->orderBy('created_at', 'asc')
    ->paginate(25);
    
    // Buat next ID Kostumer
    $today = now()->format('dmY');
    $last = Kostumer::whereDate('created_at', today())->count() + 1;
    $nextId = 'KOS-' . $today . str_pad($last, 5, '0', STR_PAD_LEFT);

    return view('admin.dashboard', compact('suppliers',  'inventoris', 'nextId'));
}
}
