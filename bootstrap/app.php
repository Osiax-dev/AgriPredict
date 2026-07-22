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
    ->withMiddleware(function (Middleware $middleware) {
        // Sanctum pour les requêtes stateful
        $middleware->statefulApi();
        
        // Alias pour ton middleware admin
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'user'  => \App\Http\Middleware\UserMiddleware::class, // ✅ AJOUT
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();