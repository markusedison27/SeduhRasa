<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Alias middleware yang dipakai di routes
        $middleware->alias([
            // pakai middleware AUTH bawaan Laravel (BUKAN App\Http\...)
            'auth'  => \Illuminate\Auth\Middleware\Authenticate::class,

            // guest diarahkan pakai RedirectIfAuthenticated buatan kamu
            'guest' => RedirectIfAuthenticated::class,

            // role = middleware cek role buatan kamu
            'role'  => RoleMiddleware::class,
        ]);

        // CSRF: biar nggak 419 di login/logout
        $middleware->validateCsrfTokens(
            except: [
                '/login',
                '/logout',
            ],
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
