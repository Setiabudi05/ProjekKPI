<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- A. CONTROLLERS AUTHENTICATION ---
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\VerifyEmailController; 
use App\Http\Controllers\Auth\SocialiteController; 

// --- B. CONTROLLERS ADMIN ---
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController; 
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\InternController;

// --- C. CONTROLLERS USER ---
use App\Http\Controllers\User\DashboardController as UserDashboardController; 


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. ROUTE AUTHENTICATION (GUEST)
// =========================================================================

Route::middleware('guest')->group(function () {
    // LOGIN & REGISTER
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    
    // RUTE RESET PASSWORD
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request'); 
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset'); 
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');

    // RUTE SOCIALITE (HANYA GOOGLE)
    // Mengarahkan ke Google
    Route::get('auth/google', [SocialiteController::class, 'redirectToProvider'])
        ->name('socialite.google.redirect');
    // Callback dari Google
    Route::get('auth/google/callback', [SocialiteController::class, 'handleProviderCallback'])
        ->name('socialite.google.callback');
});


// =========================================================================
// 2. ROUTE PROTECTED (AUTH)
// =========================================================================

// LOGOUT
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->middleware('auth');

// Route Default / (Pengalihan setelah Auth berhasil)
Route::get('/', function () {
    if (Auth::check()) { 
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login.form'); 
});

// RUTE UMUM YANG MEMBUTUHKAN LOGIN
Route::middleware(['auth'])->group(function () {
    
    // VERIFIKASI EMAIL (Tetap di sini untuk pengguna yang daftar biasa)
    Route::get('/email/verify', EmailVerificationPromptController::class)->name('verification.notice');
    
    // Memproses verifikasi (menggunakan VerifyEmailController::__invoke)
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware('signed')->name('verification.verify');
                
    // Mengirim ulang notifikasi
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    // KONFIRMASI PASSWORD
    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);
});


// =========================================================================
// 3. GRUP ROUTE ADMIN (Proteksi: auth, role:admin) 
// =========================================================================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () { // 'verified' DIHAPUS
    
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/laporan', [ReportController::class, 'index'])->name('admin.laporan.index');
    Route::resource('/data-magang', InternController::class)->names([
        'index' => 'admin.interns.index',
        'create' => 'admin.interns.create',
        'store' => 'admin.interns.store',
        'show' => 'admin.interns.show', 
        'edit' => 'admin.interns.edit',
        'update' => 'admin.interns.update',
        'destroy' => 'admin.interns.destroy',
    ]);
    Route::get('/absensi', [ReportController::class, 'absensi'])->name('admin.absensi.index'); 
});


// =========================================================================
// 4. GRUP ROUTE USER BIASA (Proteksi: auth, role:user) 
// =========================================================================
Route::prefix('user')->middleware(['auth', 'role:user'])->group(function () { // 'verified' DIHAPUS
    
    // DASHBOARD USER BIASA (URL: /user/dashboard)
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    
    // RUTE UPDATE PASSWORD SETELAH LOGIN
    Route::put('/password', [PasswordController::class, 'update'])->name('user.password.update');
});