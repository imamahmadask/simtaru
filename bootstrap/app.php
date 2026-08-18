<?php

use App\Http\Middleware\CekRole;
use App\Http\Middleware\EnsurePasswordNotExpired;
use App\Http\Middleware\SecurityHeaders;
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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'cekRole' => CekRole::class,
        ]);
        $middleware->trustProxies(at: '*');

        // Tambahkan Security Headers & Password Expiration Check ke seluruh request web
        $middleware->web(append: [
            SecurityHeaders::class,
            EnsurePasswordNotExpired::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
