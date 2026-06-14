<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * File migrasi untuk membuat tabel yang dibutuhkan oleh driver 'database' 
 * dalam sistem cache Laravel.
 */
return new class extends Migration
{
    /**
     * Menjalankan migrasi untuk membuat tabel 'cache' dan 'cache_locks'.
     */
    public function up(): void
    {
        // Membuat tabel 'cache' untuk menyimpan data yang di-cache
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();     // Kunci unik untuk item cache
            $table->mediumText('value');          // Isi data cache
            $table->integer('expiration')->index(); // Waktu kadaluwarsa data untuk pembersihan otomatis
        });

        // Membuat tabel 'cache_locks' untuk manajemen 'atomic locks' 
        // (mencegah kondisi race condition saat banyak proses mengakses cache yang sama)
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();     // Kunci unik untuk kunci (lock)
            $table->string('owner');              // Identitas proses yang memiliki kunci
            $table->integer('expiration')->index(); // Waktu kadaluwarsa kunci
        });
    }

    /**
     * Membatalkan migrasi (menghapus tabel jika terjadi rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};