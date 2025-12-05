<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Verified;

class VerifyEmailController extends Controller
{
    /**
     * Menangani permintaan untuk memverifikasi email pengguna.
     * Dipanggil oleh rute 'verification.verify'.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        // Cek apakah email sudah diverifikasi
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('user.dashboard') . '?verified=1');
        }

        // Verifikasi email pengguna
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route('user.dashboard') . '?verified=1');
    }
}