<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',      // huruf kecil
                'regex:/[A-Z]/',      // huruf besar
                'regex:/[0-9]/',      // angka
                'regex:/[!@#$%^&*()_+=\[\]{};:<>|~.,\-]/'  // simbol khusus
            ],
        ], [
    'password.regex' => 'Password harus terdiri dari huruf besar, huruf kecil, angka, dan simbol.',
    'password.min' => 'Password minimal 8 karakter.',
    'password.confirmed' => 'Konfirmasi password tidak cocok.',
    'password.required' => 'Password wajib diisi.'
        ]);

        User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role' => 'kasir'
        ]);

        return redirect()->route('admin.kasir.create')->with('success', 'Akun kasir berhasil dibuat!');
    }
}
