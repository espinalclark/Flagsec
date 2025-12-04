<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    /**
     * Maneja la solicitud entrante
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        // Verifica que el usuario esté autenticado
        if (! Auth::guard($guard)->check()) {
            return response()->json([
                'error' => 'No autenticado o token inválido.',
            ], 401);
        }

        $user = Auth::guard($guard)->user();

        // Verifica si el token aún es válido (opcional: expiración personalizada)
        if ($request->user()->currentAccessToken() && $request->user()->currentAccessToken()->cant('use')) {
            return response()->json([
                'error' => 'Token expirado o revocado.',
            ], 401);
        }

        // Anti-tampering headers opcionales
        $request->headers->set('X-Auth-Verified', 'true');

        return $next($request);
    }
}

