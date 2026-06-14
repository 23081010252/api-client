<?php

namespace App\Models;

// Mengimpor kelas pendukung untuk fitur autentikasi dan database
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User yang mewakili tabel 'users' di database.
 * Model ini digunakan untuk menangani autentikasi pengguna aplikasi.
 */
class User extends Authenticatable
{
    // Menggunakan trait HasFactory (untuk testing) dan Notifiable (untuk sistem notifikasi Laravel)
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Menentukan kolom mana saja yang boleh diisi (mass assignable).
     * Melindungi aplikasi dari pengisian massal yang tidak diinginkan (Mass Assignment Vulnerability).
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Menentukan kolom yang harus disembunyikan (hidden) dari hasil array atau JSON.
     * Biasanya digunakan agar data sensitif seperti password tidak terekspos.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Mendefinisikan konversi tipe data (casting) untuk atribut tertentu.
     * Memastikan data diproses dengan format yang benar saat diakses dari database.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Mengonversi ke objek Carbon/datetime
            'password' => 'hashed',            // Mengamankan password dengan hashing otomatis
        ];
    }
}