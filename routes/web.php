<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/

// --- AUTH CONTROLLERS ---
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

// --- ADMIN CONTROLLERS ---
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\InternController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;

// --- USER CONTROLLERS ---
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\AttendanceController as UserAttendanceController;
use App\Http\Controllers\User\ProfilController;

/*
|--------------------------------------------------------------------------
| ROOT & REDIRECT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
    return redirect()->route('login.form');
});

/*
|--------------------------------------------------------------------------
| GUEST ROUTES (BELUM LOGIN)
|--------------------------------------------------------------------------
*/
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

    // Socialite Google
    Route::get('auth/google', [SocialiteController::class, 'redirectToProvider'])->name('socialite.google.redirect');
    Route::get('auth/google/callback', [SocialiteController::class, 'handleProviderCallback'])->name('socialite.google.callback');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Email Verification & Password Confirmation
    Route::get('/email/verify', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')->name('verification.send');
    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->middleware(['role:admin'])->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Data Peserta Magang
        Route::resource('/data-magang', InternController::class)->names([
            'index'   => 'admin.interns.index',
            'create'  => 'admin.interns.create',
            'store'   => 'admin.interns.store',
            'show'    => 'admin.interns.show',
            'edit'    => 'admin.interns.edit',
            'update'  => 'admin.interns.update',
            'destroy' => 'admin.interns.destroy',
        ]);

        // Rekap Absensi
        Route::controller(AdminAttendanceController::class)->group(function () {
            Route::get('/rekap-absensi', 'index')->name('admin.attendance.index');
            Route::get('/rekap-absensi/create', 'create')->name('admin.attendance.create');
            Route::post('/rekap-absensi', 'store')->name('admin.attendance.store');
            Route::get('/rekap-absensi/{id}/edit', 'edit')->name('admin.attendance.edit');
            Route::put('/rekap-absensi/{id}', 'update')->name('admin.attendance.update');
            Route::delete('/rekap-absensi/{id}', 'destroy')->name('admin.attendance.destroy');
        });

        // Laporan
        Route::controller(ReportController::class)->group(function () {
            Route::get('/laporan-bulanan', 'index')->name('admin.laporan.index');
            Route::get('/laporan-bulanan/pdf', 'exportPdf')->name('admin.laporan.pdf');
            Route::get('/rekap-per-peserta', 'absensi')->name('admin.absensi.index');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | USER ROUTES
    |--------------------------------------------------------------------------
    */
    Route::prefix('user')->middleware(['role:user'])->group(function () {

        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

        // Update Password
        Route::put('/password', [PasswordController::class, 'update'])->name('user.password.update');

        // Absensi User
        Route::get('/absensi', [UserAttendanceController::class, 'index'])->name('user.absensi.index');
        Route::post('/absensi/check-in', [UserAttendanceController::class, 'checkIn'])->name('user.absensi.checkin');
        Route::post('/absensi/check-out', [UserAttendanceController::class, 'checkOut'])->name('user.absensi.checkout');
        Route::post('/absensi/izin', [UserAttendanceController::class, 'submitIzin'])->name('user.absensi.izin');

        // Profil
        Route::get('/profil', [ProfilController::class, 'index'])->name('user.profil');
        Route::put('/profil', [ProfilController::class, 'update'])->name('user.profil.update');
    });
});