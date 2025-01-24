<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

//Ruta Login - Register
Route::prefix('auth')->group(function () {
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

//Ruta Logout
Route::middleware('auth:sanctum')->group(function () {
Route::post('logout', [AuthController::class, 'logout']);
});
});

// Ruta  'clients'
Route::group(['prefix' => 'clients'], function () {
    // Rutas accesibles para admin y user
    Route::get('/', [ClienteController::class, 'index']);
    Route::post('/', [ClienteController::class, 'store']);
    Route::get('/{client}', [ClienteController::class, 'show']);

    // Rutas admin
    Route::middleware('role:admin')->group(function () {
        Route::put('/{client}', [ClienteController::class, 'update']);
        Route::delete('/{client}', [ClienteController::class, 'destroy']);
    });
});


// Ruta 'users'
Route::resource('users', UserController::class)->only([
'index', 'store', 'show', 'update', 'destroy'
]);
