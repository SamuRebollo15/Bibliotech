<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\SetIdioma; 

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Añadimos SetIdioma al grupo 'web' sin sobrescribir nada
        $middleware->appendToGroup('web', SetIdioma::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
