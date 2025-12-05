<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Tentukan di mana user harus diarahkan setelah otentikasi.
     * Konstanta ini digunakan oleh trait seperti RedirectsUsers.
     * * Karena kita menggunakan logika pengalihan role (admin/user) di route `/`,
     * kita atur nilai ini ke '/' agar kembali ke logika pengalihan utama.
     *
     * @var string
     */
    public const HOME = '/'; // Diubah agar kembali ke root (/) untuk dicek rolenya

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // Secara default, Laravel sudah menentukan namespace controller
        // untuk web.php dan api.php, jadi kita hanya perlu memastikan
        // logika rate limiting terdefinisi dan file route dimuat.
        
        $this->configureRateLimiting();

        $this->routes(function () {
            // Memuat rute API
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Memuat rute WEB (utama)
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}