<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Tampilkan form edit profil.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update data profil (nama, email, foto).
     */
    public function update(Request $request)
{
    $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Ambil user dari database berdasarkan ID login
    $user = User::findOrFail(Auth::id());
    
    $data = ['nama_lengkap' => $request->nama_lengkap];

    // ====== HANDLE UPLOAD FOTO ======
    if ($request->hasFile('foto_profil')) {
        // Hapus foto lama jika ada
        if ($user->foto_profil && file_exists(public_path($user->foto_profil))) {
            unlink(public_path($user->foto_profil));
        }
        $path = $request->file('foto_profil')->store('foto_profil', 'public');
        $data['foto_profil'] = 'storage/' . $path;
    }

    // ====== HANDLE HAPUS FOTO ======
    if ($request->has('hapus_foto')) {
        if ($user->foto_profil && file_exists(public_path($user->foto_profil))) {
            unlink(public_path($user->foto_profil));
        }
        $data['foto_profil'] = null;
    }

    // Simpan data
    $user->update($data);

    return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
}    /**
     * Tampilkan form ganti password.
     */
    public function editPassword()
    {
        return view('profile.ganti-password');
    }

    /**
     * Proses ganti password.
     */
    public function updatePassword(Request $request)
{
   $request->validate([
    'current_password' => 'required',
    'new_password' => [
        'required',
        'string',
        'min:8',
        'confirmed',
        'regex:/[a-z]/',
        'regex:/[A-Z]/',
        'regex:/[0-9]/',
        'regex:/[@$!%*#?&_.-]/',
        'different:current_password'
    ],
], [
    'new_password.regex' => 'Password harus terdiri dari huruf besar, huruf kecil, angka, dan simbol.',
    'new_password.min' => 'Password minimal 8 karakter.',
    'new_password.different' => 'Password baru tidak boleh sama dengan password lama.',
    'new_password.confirmed' => 'Password baru dan pengesahan password tidak sepadan.',
]);


    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->with('error', 'Password lama tidak sesuai.');
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return back()->with('success', 'Password berhasil diubah.');
}


    /**
     * Hapus akun user (opsional).
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Akun berhasil dihapus.');
    }
}
