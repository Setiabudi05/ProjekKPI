<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite; 
use Illuminate\Support\Str; // Tambahkan ini
use Illuminate\Support\Facades\Log; // Tambahkan ini

class SocialiteController extends Controller
{
    // Hapus $provider dari sini
    public function redirectToProvider() 
    {
        // Tidak perlu cek $provider karena rute sudah spesifik
        return Socialite::driver('google')->redirect();
    }

    // Hapus $provider dari sini
    public function handleProviderCallback() 
    {
        try {
            $socialUser = Socialite::driver('google')->user(); 

        } catch (\Exception $e) {
            Log::error("Google Socialite Error: " . $e->getMessage()); // Logging error
            return redirect('/login')->with('error', 'Login dengan Google gagal. Coba lagi.');
        }

        $existingUser = User::where('email', $socialUser->getEmail())->first();

        if ($existingUser) {
            Auth::login($existingUser, true);
        } else {
            $newUser = User::create([
                // Gunakan Str::random untuk password yang lebih aman
                'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? explode('@', $socialUser->getEmail())[0],
                'email' => $socialUser->getEmail(),
                'password' => bcrypt(Str::random(16)), // Menggunakan Str::random()
                'role' => 'user', 
                'email_verified_at' => now(), // Verifikasi dianggap berhasil
            ]);
            Auth::login($newUser, true);
        }

        // Redirect langsung ke dashboard, ini harusnya mengatasi masalah verifikasi
        return redirect()->intended(route('user.dashboard'));
    }
}