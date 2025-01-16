<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

/**
 * Class RouteServiceProvider
 *
 * Proveedor de servicios para la configuración de rutas de la aplicación.
 * Se encarga de registrar las rutas y aplicar middleware según sea necesario.
 *
 * @package App\Providers
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * El namespace predeterminado para las rutas del controlador.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Realiza el registro de las rutas para la aplicación.
     *
     * Este método se encarga de cargar las rutas definidas en los archivos correspondientes.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // Cargar las rutas para el grupo 'web'
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            // Cargar las rutas para el grupo 'api' con prefijo 'api'
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
        });
    }

    /**
     * Configura las limitaciones de tasa para las rutas de la aplicación.
     *
     * Este método define la cantidad máxima de solicitudes permitidas por minuto para las rutas API.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        // Configuración de la limitación de tasa si es necesario
        \Illuminate\Support\Facades\RateLimiter::for('api', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(60);
        });
    }
}
