<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class LoginRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a hacer este request.
     */
    public function authorize(): bool
    {
        // Cualquier usuario puede intentar loguearse
        return true;
    }

    /**
     * Reglas de validación del login
     */
    public function rules(): array
    {
        return [
            'email'    => ['required', 'email:rfc,dns', 'max:120'],
            'password' => ['required', 'string', 'min:12'],
        ];
    }

    /**
     * Mensajes de error personalizados (genéricos)
     */
    public function messages(): array
    {
        return [
            'email.required'    => 'Credenciales inválidas.',
            'email.email'       => 'Credenciales inválidas.',
            'password.required' => 'Credenciales inválidas.',
            'password.min'      => 'Credenciales inválidas.',
        ];
    }

    /**
     * Chequeo de rate limiting para evitar fuerza bruta
     */
    public function ensureIsNotRateLimited()
    {
        $key = $this->throttleKey();

        if (! RateLimiter::tooManyAttempts($key, 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($key);

        throw ValidationException::withMessages([
            'email' => ["Demasiados intentos. Espera {$seconds} segundos antes de volver a intentar."],
        ]);
    }

    /**
     * Llave única para rate limiting por email + IP
     */
    public function throttleKey(): string
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }
}

