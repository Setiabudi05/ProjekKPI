<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth; // Pastikan ini di-import

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Dihapus: protected $redirectTo = '/home';
     * Ditambahkan: Custom method redirectTo()
     */
    
    /**
     * Dapatkan path setelah login berhasil.
     */
    protected function redirectTo()
    {
        // Pengecekan peran
        if (Auth::user()->role === 'admin') {
            return route('admin.dashboard'); // '/admin/dashboard'
        }
        
        // Default untuk user biasa
        return route('user.dashboard'); // '/user/dashboard'
    }

    // ... (Sisa kode seperti constructor)
}