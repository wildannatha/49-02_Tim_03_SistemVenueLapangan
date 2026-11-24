<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Akun contoh. Password default: 'password'
     * -> WAJIB diganti kalau dipakai di luar development.
     */
    public function run(): void
    {
        $akun = [
            ['admin@example.com', 'Admin', User::ROLE_ADMIN],
            ['user@example.com', 'User Biasa', User::ROLE_USER],
        ];

        // 'role' tidak ada di $fillable, jadi pakai unguarded.
        User::unguarded(function () use ($akun) {
            foreach ($akun as [$email, $name, $role]) {
                User::updateOrCreate(
                    ['email' => $email],
                    ['name' => $name, 'password' => 'password', 'role' => $role],
                );
            }
        });
    }
}
