<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Registro de usuario
Route::post('register', [AuthController::class, 'register']);

// Inicio de sesión
Route::post('login', [AuthController::class, 'login']);

// Cierre de sesión (protegido por Sanctum)
Route::middleware('auth:sanctum')->group(function () {
  Route::post('logout', [AuthController::class, 'logout']);
});
