<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Tentukan arah redirect berdasarkan role
     */
    protected function redirectTo()
    {
        if (Auth::user()->role === 'admin') {
            return route('admin.dashboard');
        }
        return route('user.dashboard');
    }

    /**
     * Method ini dijalankan SETELAH user berhasil login.
     * Digunakan untuk mengirim pesan sukses.
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended($this->redirectTo())
            ->with('login_success', 'Selamat Datang Kembali, ' . $user->name . '!');
    }
}