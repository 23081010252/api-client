<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Factory untuk membuat data dummy (palsu) dari model User.
 * Biasanya digunakan untuk keperluan testing atau seeding database.
 * * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Menyimpan referensi password agar tidak perlu melakukan hashing berulang kali.
     */
    protected static ?string $password;

    /**
     * Mendefinisikan status bawaan (default state) untuk model User.
     * Menggunakan library 'fake()' untuk menghasilkan data acak yang realistis.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(), // Menandakan email sudah terverifikasi saat dibuat
            'password'          => static::$password ??= Hash::make('password'), // Password default: 'password'
            'remember_token'    => Str::random(10), // Membuat token acak untuk fitur "remember me"
        ];
    }

    /**
     * State tambahan untuk mensimulasikan kondisi user yang emailnya belum diverifikasi.
     * Dapat dipanggil dengan: User::factory()->unverified()->create();
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}