<?php

use Illuminate\Http\Request;

// Define el tiempo de inicio de Laravel para medir el rendimiento.
define('LARAVEL_START', microtime(true));

// Determina si la aplicación está en modo de mantenimiento...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    // Si existe el archivo de mantenimiento, se requiere para activar el modo de mantenimiento.
    require $maintenance;
}

// Registra el autoloader de Composer...
require __DIR__.'/../vendor/autoload.php';

// Inicializa Laravel y maneja la solicitud...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());  // Captura la solicitud HTTP y la maneja
