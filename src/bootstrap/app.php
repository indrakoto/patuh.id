<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi(); // <-- Penting untuk Sanctum
        
        // Tambahkan middleware custom untuk auth
        $middleware->alias([
            'auth' => \App\Http\Middleware\RedirectIfNotAuthenticated::class,
            //'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        ]);

        $middleware->trustProxies(
            at: '*', // Atau at: ['127.0.0.1'] jika Anda ingin lebih spesifik
            headers: Request::HEADER_X_FORWARDED_FOR |
                     Request::HEADER_X_FORWARDED_HOST |
                     Request::HEADER_X_FORWARDED_PORT |
                     Request::HEADER_X_FORWARDED_PROTO
        );

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
