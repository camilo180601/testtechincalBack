<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Middleware\HandleCors;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Global middleware: CORS al frente
        $middleware->prepend(HandleCors::class);

        // Alias para usar en rutas
        $middleware->alias([
            'auth.api' => \App\Http\Middleware\AuthenticateApi::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // Prioridad (opcional), si ciertos middlewares deben correr antes que otros
        $middleware->priority([
            HandleCors::class,
            \App\Http\Middleware\AuthenticateApi::class,
            \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
