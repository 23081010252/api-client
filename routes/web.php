<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return session('api_key') ? redirect()->route('dashboard') : redirect()->route('login');
});

// Auth (guest only)
Route::middleware('guest.api')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
    // Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    // Route::post('/register',[AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected
Route::middleware('auth.api')->group(function () {
    Route::get('/dashboard',           [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/settings',            [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings',           [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/produk',              [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create',       [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk',             [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit',    [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}',         [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}',      [ProdukController::class, 'destroy'])->name('produk.destroy');
});
