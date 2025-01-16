<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/**
 * Configuración de la aplicación.
 *
 * Este archivo devuelve una instancia configurada de la aplicación,
 * definiendo rutas, middleware y manejo de excepciones.
 *
 * @return Application
 */
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
    // Ruta para las rutas web
        web: __DIR__.'/../routes/web.php',

        // Ruta para los comandos de consola
        commands: __DIR__.'/../routes/console.php',

        // Ruta para las rutas API
        api: __DIR__ . '/../routes/api.php',

        // Ruta para el endpoint de salud
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Configuración de middleware personalizada si es necesario
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Configuración del manejo de excepciones personalizada si es necesario
    })->create();
