<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon; // Import Carbon untuk 'now()'
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Jalankan database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data Akun Admin
        $adminEmail = 'admin@gmail.com';
        $adminPassword = 'password123';
        
        // 1. BUAT AKUN ADMIN (Hanya jika belum ada)
        if (!User::where('email', $adminEmail)->exists()) {
            User::create([
                'name' => 'Admin Utama',
                'email' => $adminEmail,
                'password' => Hash::make($adminPassword),
                'role' => 'admin',
                'email_verified_at' => Carbon::now(), // ✅ KOREKSI: Setel terverifikasi
            ]);
        }

        // Data Akun User Biasa
        $userEmail = 'user@gmail.com';
        $userPassword = 'password123';

        // 2. BUAT AKUN USER BIASA (Hanya jika belum ada)
        if (!User::where('email', $userEmail)->exists()) {
            User::create([
                'name' => 'User Magang Biasa',
                'email' => $userEmail,
                'password' => Hash::make($userPassword),
                'role' => 'user',
                'email_verified_at' => Carbon::now(), // ✅ TAMBAHAN: Setel terverifikasi
            ]);
        }
    }
}