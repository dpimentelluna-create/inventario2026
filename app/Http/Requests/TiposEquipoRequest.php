<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TiposEquipoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => $this->nombre
                ? mb_strtoupper(trim((string) $this->nombre), 'UTF-8')
                : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:100', 'regex:/^[A-ZÁÉÍÓÚÑÜ\s.]+$/u'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.regex' => 'El tipo de equipo solo puede contener letras.',
        ];
    }
}
