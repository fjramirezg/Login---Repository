<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 *
 * Proveedor de servicios de la aplicación.
 * Se utiliza para registrar y configurar servicios de la aplicación.
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Registrar cualquier servicio de la aplicación.
     *
     * Este método se utiliza para enlazar servicios en el contenedor de servicios.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Inicializar cualquier servicio de la aplicación.
     *
     * Este método se ejecuta después de que todos los servicios han sido registrados.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
