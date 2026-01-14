<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- A. AUTHENTICATION CONTROLLERS ---
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

// --- B. ADMIN CONTROLLERS ---
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\InternController;
use App\Http\Controllers\Admin\AttendanceController;

// --- C. USER CONTROLLERS ---
use App\Http\Controllers\User\DashboardController as UserDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. ROOT & REDIRECT LOGIC
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
    return redirect()->route('login.form');
});

// 2. GUEST ROUTES (Belum Login)
Route::middleware('guest')->group(function () {
    // Login & Register
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');

    // Reset Password
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');

    // Socialite (Google)
    Route::get('auth/google', [SocialiteController::class, 'redirectToProvider'])->name('socialite.google.redirect');
    Route::get('auth/google/callback', [SocialiteController::class, 'handleProviderCallback'])->name('socialite.google.callback');
});

// 3. PROTECTED ROUTES (Sudah Login)
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Email Verification & Password Confirmation
    Route::get('/email/verify', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')->name('verification.send');
    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);

    // --- ADMIN GROUP ---
    Route::prefix('admin')->middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Data Peserta Magang (Resource)
        Route::resource('/data-magang', InternController::class)->names([
            'index'   => 'admin.interns.index',
            'create'  => 'admin.interns.create',
            'store'   => 'admin.interns.store',
            'show'    => 'admin.interns.show',
            'edit'    => 'admin.interns.edit',
            'update'  => 'admin.interns.update',
            'destroy' => 'admin.interns.destroy',
        ]);

        // Manajemen Rekap Absensi
        Route::controller(AttendanceController::class)->group(function () {
            Route::get('/rekap-absensi', 'index')->name('admin.attendance.index');
            Route::get('/rekap-absensi/create', 'create')->name('admin.attendance.create');
            Route::post('/rekap-absensi', 'store')->name('admin.attendance.store');
            Route::get('/rekap-absensi/{id}/edit', 'edit')->name('admin.attendance.edit');
            Route::put('/rekap-absensi/{id}', 'update')->name('admin.attendance.update');
            Route::delete('/rekap-absensi/{id}', 'destroy')->name('admin.attendance.destroy');
        });

        // Laporan & Cetak PDF
        Route::controller(ReportController::class)->group(function () {
            Route::get('/laporan-bulanan', 'index')->name('admin.laporan.index');
            Route::get('/laporan-bulanan/pdf', 'exportPdf')->name('admin.laporan.pdf');
            Route::get('/rekap-per-peserta', 'absensi')->name('admin.absensi.index');
        });
    });

    // --- USER GROUP ---
    Route::prefix('user')->middleware(['role:user'])->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
        Route::put('/password', [PasswordController::class, 'update'])->name('user.password.update');
    });
});