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
            'nombre' => $this->aMayusculas($this->nombre),
        ]);
    }

    private function aMayusculas($valor): ?string
    {
        if ($valor === null || trim((string) $valor) === '') {
            return null;
        }

        return mb_strtoupper(trim((string) $valor), 'UTF-8');
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
