<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
{
    $users = User::orderBy('created_at', 'desc')->paginate(25);
    return view('admin.users.index', compact('users'));
}
public function create()
{
    $today = now()->format('dmY');
    $countToday = User::whereDate('created_at', now())->count() + 1;
    $kodeUser = 'USR-' . $today . str_pad($countToday, 4, '0', STR_PAD_LEFT);

    return view('admin.users.create', compact('kodeUser'));
}
public function store(Request $request)
{
    $request->validate([
    'kode_user' => 'required|unique:users,kode_user',
    'name' => 'required|string|max:255|unique:users,name',
    'nama_lengkap' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email',
    'password' => [
        'required',
        'confirmed',
        'min:8',
        'regex:/[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]/'
    ],
], [
    'kode_user.required' => 'ID User wajib diisi.',
    'kode_user.unique' => 'ID User sudah digunakan.',
    'name.required' => 'Username wajib diisi.',
    'name.unique' => 'Username sudah digunakan.',
    'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
    'email.required' => 'Email wajib diisi.',
    'email.email' => 'Format email tidak valid.',
    'email.unique' => 'Email sudah digunakan.',
    'password.required' => 'Password wajib diisi.',
    'password.confirmed' => 'Konfirmasi password tidak cocok.',
    'password.min' => 'Password minimal 8 karakter.',
    'password.regex' => 'Password harus mengandung minimal satu karakter khusus seperti !@#$%^&*()_ dan sejenisnya.',
]);
    User::create([
        'kode_user' => $request->kode_user,
        'name' => $request->name,
        'nama_lengkap' => $request->nama_lengkap,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => 'kasir',
    ]);

    return redirect()->route('user.index')->with('success', 'Akun kasir berhasil dibuat.');
}
public function destroy($id) {
    $user = User::findOrFail($id);
    if ($user->role === 'admin') {
        return back()->with('error', 'Tidak dapat menghapus akun admin.');
    }
    $user->delete();
    return back()->with('success', 'Akun berhasil dihapus.');
}    
}
