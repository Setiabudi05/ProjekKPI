<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    /**
     * Menampilkan formulir permintaan link reset password.
     * * Rute: GET forgot-password (nama rute: password.request)
     */
    public function create()
    {
        // Pastikan view ini ada di resources/views/auth/forgot-password.blade.php
        return view('auth.forgot-password');
    }

    /**
     * Memproses permintaan link reset password melalui email.
     * * Rute: POST forgot-password (nama rute: password.email)
     */
    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Mengirim link reset password
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }
}