<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class CursoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a hacer este request.
     */
    public function authorize(): bool
    {
        // Solo admins pueden crear/editar cursos
        return $this->user() && $this->user()->role === 'admin';
    }

    /**
     * Reglas de validación para crear/editar curso
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:150'],
            'description' => ['required', 'string', 'min:10', 'max:1000'],
            'image' => ['nullable', 'url', 'max:255'], // puede ser URL de imagen
        ];
    }

    /**
     * Mensajes de error genéricos
     */
    public function messages(): array
    {
        return [
            'title.required'       => 'Datos inválidos.',
            'title.min'            => 'Datos inválidos.',
            'title.max'            => 'Datos inválidos.',
            'description.required' => 'Datos inválidos.',
            'description.min'      => 'Datos inválidos.',
            'description.max'      => 'Datos inválidos.',
            'image.url'            => 'Datos inválidos.',
            'image.max'            => 'Datos inválidos.',
        ];
    }

    /**
     * Chequeo opcional de rate limiting (ejemplo anti abuso)
     */
    public function ensureIsNotRateLimited()
    {
        $key = $this->throttleKey();

        if (! RateLimiter::tooManyAttempts($key, 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($key);

        throw ValidationException::withMessages([
            'title' => ["Demasiados intentos. Espera {$seconds} segundos antes de volver a intentar."],
        ]);
    }

    /**
     * Llave única para rate limiting por IP + endpoint
     */
    public function throttleKey(): string
    {
        return Str::lower($this->input('title', 'no-title')).'|'.$this->ip();
    }
}

