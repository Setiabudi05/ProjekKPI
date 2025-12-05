<?php

namespace App\Http\Controllers\User; // Namespace harus menunjuk ke folder "User"

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard untuk user biasa.
     */
    public function index()
    {
        // Pastikan view ini ada di resources/views/user/welcome.blade.php
        return view('user.welcome'); 
    }
}