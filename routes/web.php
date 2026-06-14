<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;

// 1. Root Path: Mengarahkan user berdasarkan status login (API Key)
Route::get('/', function () {
    return session('api_key') ? redirect()->route('dashboard') : redirect()->route('login');
});

// 2. Auth Routes: Grouping untuk akses tamu (belum login)
// Menggunakan middleware 'guest.api' untuk mencegah user yang sudah login mengakses halaman login
Route::middleware('guest.api')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
});

// Route logout dapat diakses oleh user yang sudah terautentikasi
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Protected Routes: Grouping fitur utama yang memerlukan API Key
// Menggunakan middleware 'auth.api' untuk memastikan API Key tersedia di session sebelum lanjut ke controller
Route::middleware('auth.api')->group(function () {
    // Halaman Dashboard
    Route::get('/dashboard',              [DashboardController::class, 'index'])->name('dashboard');
    
    // Pengaturan Koneksi API
    Route::get('/settings',               [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings',              [SettingsController::class, 'update'])->name('settings.update');
    
    // Resource Produk (CRUD ke Server API)
    Route::get('/produk',                 [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create',          [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk',                [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit',       [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}',            [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}',         [ProdukController::class, 'destroy'])->name('produk.destroy');
});