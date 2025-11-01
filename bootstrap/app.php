<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // DAFTARKAN ALIAS ANDA DI SINI
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            // 'auth'  => \App\Http\Middleware\Authenticate::class,
            // 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            // (Middleware lain yang mungkin sudah ada)
        ]);

        // (Mungkin ada middleware global di sini)
        // $middleware->web(append: [ ... ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        // ...
    })->create();
