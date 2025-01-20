<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

//// Registro de usuario

Route::prefix('auth')->group(function () {
  Route::post('login', [AuthController::class, 'login']);
  Route::post('register', [AuthController::class, 'register']);
  // Cierre de sesión (protegido por Sanctum)
  Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
  });
});


Route::resource('clients', ClienteController::class)->only(
  [
    'index',
    'store',
    'show',
    'update',
    'destroy'
  ]

);

Route::resource('users', UserController::class)->only(
  [
    'index',
    'store',
    'show',
    'update',
    'destroy'
  ]

);
