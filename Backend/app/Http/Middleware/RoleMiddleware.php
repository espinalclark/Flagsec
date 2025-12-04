<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Maneja la solicitud entrante
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles  // Roles permitidos
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json([
                'error' => 'No autenticado.',
            ], 401);
        }

        // Si el usuario no tiene ninguno de los roles permitidos
        if (! in_array($user->role, $roles)) {
            return response()->json([
                'error' => 'No autorizado para esta acción.',
                'required_roles' => $roles,
                'your_role' => $user->role,
            ], 403);
        }

        // Seguridad extra: marca el request como autorizado
        $request->headers->set('X-Role-Verified', 'true');

        return $next($request);
    }
}

