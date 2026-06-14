<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * File migrasi untuk membuat tabel 'sessions' di database.
 * Tabel ini digunakan untuk menyimpan data sesi pengguna (jika SESSION_DRIVER=database).
 */
return new class extends Migration
{
    /**
     * Menjalankan migrasi untuk membuat struktur tabel sesi.
     */
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();               // ID sesi unik (session identifier)
            $table->foreignId('user_id')->nullable()->index(); // ID user yang login (jika ada)
            $table->string('ip_address', 45)->nullable();   // Alamat IP perangkat pengguna
            $table->text('user_agent')->nullable();        // Informasi browser/perangkat pengguna
            $table->longText('payload');                   // Data sesi yang diserialisasi (isi utama sesi)
            $table->integer('last_activity')->index();     // Stempel waktu aktivitas terakhir pengguna
        });
    }

    /**
     * Membatalkan migrasi (menghapus tabel jika terjadi rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};