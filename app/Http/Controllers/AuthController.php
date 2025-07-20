<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLoginForm()
    {
        return view('login');
    }

    // Proses login: bisa pakai email atau username
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('login');

        $credentials = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? ['email' => $login, 'password' => $request->password]
            : ['name' => $login, 'password' => $request->password];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'kasir') {
                return redirect()->route('penjualan.index');
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors(['login' => 'Role tidak dikenal.']);
            }
        }

        return back()->withErrors([
            'login' => 'Username/email atau password salah.',
        ]);
    }

    // Proses register (default untuk kasir)
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',       // huruf kecil
                'regex:/[A-Z]/',       // huruf besar
                'regex:/[0-9]/',       // angka
                'regex:/[@$!%*#?&_.-]/' // simbol
            ],
        ], [
            'password.regex' => 'Password harus terdiri dari huruf besar, huruf kecil, angka, dan simbol.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'kasir',
        ]);

        Auth::login($user);

        return $user->role === 'admin'
            ? redirect()->route('admin.dashboard')->with('success', 'Login sebagai Admin.')
            : redirect()->route('penjualan.index')->with('success', 'Login sebagai Kasir.');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
