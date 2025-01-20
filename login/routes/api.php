<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


//// Registro de usuario

Route::post('register', [AuthController::class, 'register']);


Route::resource('clients', ClienteController::class) ->only([
    'index', 'store', 'show',  'update', 'destroy'
    ]

);

Route::resource('users', AuthController::class) ->only([
        'index', 'store', 'show',  'update', 'destroy'
    ]

);



// Cierre de sesión (protegido por Sanctum)
Route::middleware('auth:sanctum')->group(function () {
  Route::post('logout', [AuthController::class, 'logout']);
});
