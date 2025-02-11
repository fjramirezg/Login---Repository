<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


// Rutas de autenticación (sin protección)
Route::post('login', [AuthController::class, 'login']);

// Rutas protegidas por Sanctum -- token.
Route::middleware('auth:sanctum')->group(function () {

    // Ruta de logout
    Route::post('logout', [AuthController::class, 'logout']);

    // Rutas para clientes
    Route::group(['prefix' => 'clients'], function () {

        // Rutas accesibles para admin y user
        Route::get('/', [ClienteController::class, 'index']);
        Route::post('/', [ClienteController::class, 'store']);
        Route::get('/{client}', [ClienteController::class, 'show']);

        // Rutas solo para admin
        Route::middleware('role:admin')->group(function () {
            Route::put('/{client}', [ClienteController::class, 'update']);
            Route::delete('/{client}', [ClienteController::class, 'destroy']);
        });
    });

//    Rutas para usuarios
    Route::resource('users', UserController::class)->middleware('role:admin');



});























