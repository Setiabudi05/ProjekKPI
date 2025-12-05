<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menghancurkan sesi terotentikasi. (Logout)
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Logout pengguna dan hancurkan sesi
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Redirect ke halaman utama
        return redirect('/'); 
    }
}