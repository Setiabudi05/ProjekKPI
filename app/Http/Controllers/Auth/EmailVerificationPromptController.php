<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Menampilkan prompt notifikasi verifikasi email.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        // Jika email sudah diverifikasi, arahkan ke dashboard yang benar
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('user.dashboard'))
                    : view('auth.verify-email'); 
    }
}