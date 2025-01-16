<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserStatus
{
    /**
     * Maneja una solicitud entrante.
     *
     * Este middleware verifica si el usuario tiene un estado activo ('active').
     * Si no, bloquea el acceso y devuelve un mensaje de error.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if ($request->user() && $request->user()->status !== 'active') {
            return response()->json([
                'message' => 'Your account is not active. Please contact support.',
            ], 403); // Código de estado HTTP 403 (Forbidden)
        }

        // Continuar con la solicitud si el usuario está activo
        return $next($request);
    }
}
