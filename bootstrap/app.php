<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then : function () {
            Route::middleware('web' , 'auth')
                ->prefix('/')->name('')
                ->group(base_path('routes/admin/main.php'));

            Route::middleware('web' , 'auth')
                ->prefix('/management')->name('')
                ->group(base_path('routes/admin/management.php'));

        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();