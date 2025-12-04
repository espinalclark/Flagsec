<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Registro seguro
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'min:2', 'max:60'],
            'email'    => ['required', 'email:rfc,dns', 'max:120', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                'min:12', // Seguridad real
                'regex:/[A-Z]/',       // Mayúscula
                'regex:/[a-z]/',       // Minúscula
                'regex:/[0-9]/',       // Número
                'regex:/[@$!%*#?&]/',  // Símbolo
            ],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Hash Argon2id (Laravel)
        ]);

        return response()->json([
            'message' => 'Usuario registrado correctamente.',
            'user'    => $user,
        ], 201);
    }

    /**
     * Login **blindado** con:
     * - Rate limiting por IP + email
     * - Bloqueo temporal
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $this->ensureIsNotRateLimited($request);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {

            RateLimiter::hit($this->throttleKey($request), 300); // bloqueo 5 min

            throw ValidationException::withMessages([
                'email' => ['Credenciales incorrectas.'],
            ]);
        }

        RateLimiter::clear($this->throttleKey($request));

        // Token seguro (Personal Access Token)
        $token = $user->createToken('auth_token', ['*'])->plainTextToken;

        return response()->json([
            'message' => 'Login correcto.',
            'token'   => $token,
        ], 200);
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente.',
        ]);
    }

    /**
     * Proteger contra ataques de fuerza bruta
     */
    protected function ensureIsNotRateLimited(Request $request)
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'email' => ["Demasiados intentos. Espera {$seconds} segundos."],
        ]);
    }

    protected function throttleKey(Request $request)
    {
        return Str::lower($request->email).'|'.$request->ip();
    }
}

