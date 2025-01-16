<?php


namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
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

        // Middleware para manejar la validación del POST size
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        // Middleware para convertir las respuestas a objetos HTTP
        \App\Http\Middleware\TrimStrings::class,

        // Middleware para convertir cadenas vacías en nulos
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
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
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
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

        // Middleware para limitar la tasa de solicitudes
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

        // Middleware para verificar contraseñas
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,

        // Middleware para manejar la cacheo de respuestas
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,

        // Middleware para verificar si una solicitud ha expirado
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // Middleware para verificar si un usuario está autenticado
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
