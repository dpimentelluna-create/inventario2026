<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordSegura implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $valor = (string) $value;

        if (mb_strlen($valor) < 10) {
            $fail('La contraseña debe tener al menos 10 caracteres.');
            return;
        }

        if (mb_strlen($valor) > 64) {
            $fail('La contraseña no puede superar los 64 caracteres.');
            return;
        }

        if (! preg_match('/\p{Ll}/u', $valor) || ! preg_match('/\p{Lu}/u', $valor)) {
            $fail('La contraseña debe incluir mayúsculas y minúsculas.');
            return;
        }

        if (! preg_match('/\d/', $valor)) {
            $fail('La contraseña debe incluir al menos un número.');
        }
    }
}