<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    // ->withMiddleware(function (Middleware $middleware) {
    //     //
    // })
    ->withMiddleware(function (Middleware $middleware) {
        // Ide regisztráld a SetLocale middleware-t
        $middleware->web([\App\Http\Middleware\SetLocale::class]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        // Admin middleware
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
