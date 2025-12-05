<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Memperbarui password user yang sedang terotentikasi.
     * Rute: PUT user/password (nama rute: user.password.update)
     */
    public function update(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            // Memastikan password saat ini cocok dengan yang ada di database
            'current_password' => ['required', 'current_password'], 
            // Memastikan password baru kuat dan cocok dengan konfirmasi
            'password' => ['required', Password::defaults(), 'confirmed'],
        ], [
            'current_password.current_password' => 'Password saat ini yang Anda masukkan salah.',
        ]);

        // Update password di database
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'Password berhasil diperbarui.');
    }
}