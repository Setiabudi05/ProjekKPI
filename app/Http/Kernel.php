<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // Bagian ini adalah tempat Anda Mendaftarkan alias middleware baru:
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            // Jika Anda menggunakan Spatie Laravel-Permission, 
            // ganti baris di atas dengan:
            // 'role' => \Spatie\Permission\Middleware\RoleMiddleware::class, 
        ]);

        // Middleware global lainnya biasanya ada di sini
        // Contoh:
        // $middleware->web(append: [
        //     \App\Http\Middleware\HandleInertiaRequests::class,
        // ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Penanganan exception (jika ada)
    })
    ->create();