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
        $middleware->statefulApi(); // <-- Penting untuk Sanctum
        
        // Tambahkan middleware custom untuk auth
        $middleware->alias([
            'auth' => \App\Http\Middleware\RedirectIfNotAuthenticated::class,
            //'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
