<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

/**
 * Class Kernel
 *
 * Clase que gestiona el middleware HTTP de la aplicación.
 * Define los middleware globales, grupos de middleware y middleware de ruta.
 *
 * @package App\Http
 */
class Kernel extends HttpKernel
{
    /**
     * El stack global de middleware HTTP de la aplicación.
     *
     * Estos middleware se ejecutan durante cada solicitud a la aplicación.
     *
     * @var array
     */
    protected $middleware = [
        // Middleware para manejar la confianza de proxies
        \App\Http\Middleware\TrustProxies::class,

        // Middleware para manejar la normalización de cabeceras
        \Illuminate\Http\Middleware\HandleCors::class,

        // Middleware para validar la longitud del contenido enviado por el cliente
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,

        // Middleware para manejar la validación del tamaño del POST
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        // Middleware para convertir las respuestas a objetos HTTP
        \App\Http\Middleware\TrimStrings::class,

        // Middleware para convertir cadenas vacías en nulos
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * Los grupos de middleware de rutas de la aplicación.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * El middleware de ruta de la aplicación.
     *
     * Estos middleware pueden ser asignados a grupos o utilizados individualmente.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // Middleware de autenticación
        'auth' => \App\Http\Middleware\Authenticate::class,

        // Middleware para autenticación básica HTTP
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,

        // Middleware para manejar autorizaciones
        'can' => \Illuminate\Auth\Middleware\Authorize::class,

        // Middleware para redirigir si el usuario está autenticado
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

        // Middleware para verificar contraseñas
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,

        // Middleware para manejar la validación de firmas en URLs
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,

        // Middleware para limitar la tasa de solicitudes
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // Middleware para verificar si un usuario está autenticado y su email está verificado
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
