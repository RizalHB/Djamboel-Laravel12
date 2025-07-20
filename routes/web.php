<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoriController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KostumerController;
use App\Http\Controllers\AdminController;
Route::get('/penjualan/generate-id', [PenjualanController::class, 'generateId']);
// Redirect ke login jika akses root
Route::get('/', fn () => redirect('/login'));
// AUTH ROUTES
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// PROFIL dan PASSWORD (bisa diakses semua yang login)
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profil', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/ganti-password', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::post('/ganti-password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

// ADMIN
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', fn () => view('admin.dashboard'))->name('admin.dashboard');
    Route::resource('/inventori', InventoriController::class)->except(['show']);
    Route::get('/inventori/{id}/tambah-stok', [InventoriController::class, 'formStok'])->name('inventori.tambahStok');
    Route::post('/inventori/{id}/tambah-stok', [InventoriController::class, 'storeStok'])->name('inventori.storeStok');
    Route::get('/inventori/{id}/ganti-hargajual', [InventoriController::class, 'formGantiHarga'])->name('inventori.ganti_hargajual');
    Route::post('/inventori/{id}/ganti-hargajual', [InventoriController::class, 'prosesGantiHarga'])->name('inventori.proses_ganti_hargajual');
    Route::get('/inventori/export-excel', [InventoriController::class, 'exportExcel'])->name('inventori.export.excel');
    Route::resource('/pengeluaran', PengeluaranController::class)->except(['show']);
    Route::post('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/data', [LaporanController::class, 'getData'])->name('laporan.data');
    Route::post('/laporan/pdf', [LaporanController::class, 'export'])->name('laporan.export');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/laporan/data', [LaporanController::class, 'data']); 
    Route::get('/pengeluaran/export-excel', [PengeluaranController::class, 'exportExcel'])->name('pengeluaran.export.excel');
    Route::post('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');
});
// ADMIN & KASIR untuk penjualan
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
    Route::resource('/penjualan', PenjualanController::class)->except(['show']);
    Route::get('/penjualan/grafik-pendapatan', [PenjualanController::class, 'grafikPendapatanHarian'])->name('penjualan.grafik_pendapatan');
    Route::get('/penjualan/{id}/struk', [PenjualanController::class, 'cetakStruk'])->name('penjualan.struk');
    Route::get('/penjualan/export-excel', [PenjualanController::class, 'exportExcel'])->name('penjualan.export.excel');
    Route::get('/penjualan/grafik', [PenjualanController::class, 'grafikPendapatanHarian'])->name('penjualan.grafik');

});
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/kasir/create', [UserController::class, 'createKasir'])->name('admin.kasir.create');
    Route::post('/admin/kasir/store', [UserController::class, 'storeKasir'])->name('admin.kasir.store');
});
// routes/web.php
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('/user', UserController::class)->only(['index', 'create', 'store', 'destroy']);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/kasir/create', [App\Http\Controllers\AdminUserController::class, 'create'])->name('admin.kasir.create');
    Route::post('/admin/kasir/store', [App\Http\Controllers\AdminUserController::class, 'store'])->name('admin.kasir.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::get('/supplier/export-excel', [SupplierController::class, 'exportExcel'])->name('supplier.export.excel');
});
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::resource('kostumer', KostumerController::class);
    Route::get('/admin/kostumer/export-excel', [KostumerController::class, 'exportExcel'])->name('kostumer.export.excel');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('kostumer', KostumerController::class)->except(['show']);
});
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('kostumer/store', [KostumerController::class, 'store'])->name('kostumer.store');
});
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/kostumer', [KostumerController::class, 'index'])->name('kostumer.index');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
});
