<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:60'],

            // 🔥 Cambiado: antes era `email:rfc,dns` (muy estricto)
            // Ahora solo valida formato correcto y unicidad
            'email' => ['required', 'email', 'max:120', 'unique:users,email'],

            'password' => [
                'required',
                'string',
                'min:12',
                'regex:/[A-Z]/',     // Mayúscula
                'regex:/[a-z]/',     // Minúscula
                'regex:/[0-9]/',     // Número
                'regex:/[@$!%*#?&]/' // Símbolo
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Registro inválido.',
            'email.required'    => 'Registro inválido.',
            'email.email'       => 'Registro inválido.',
            'email.unique'      => 'Registro inválido.',
            'password.required' => 'Registro inválido.',
            'password.min'      => 'Registro inválido.',
            'password.regex'    => 'Registro inválido. Password demasiado débil.',
        ];
    }

    public function ensureIsNotRateLimited()
    {
        $key = $this->throttleKey();

        if (! RateLimiter::tooManyAttempts($key, 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($key);

        throw ValidationException::withMessages([
            'email' => ["Demasiados intentos de registro. Espera {$seconds} segundos antes de volver a intentar."],
        ]);
    }

    public function throttleKey(): string
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }
}

