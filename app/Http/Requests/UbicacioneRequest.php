<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UbicacioneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => $this->aMayusculas($this->nombre),
            'tipo' => $this->aMayusculas($this->tipo),
        ]);
    }

    public function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:100',
                'regex:/^[A-ZÁÉÍÓÚÑÜ0-9\s.\-]+$/u',
                Rule::unique('ubicaciones', 'nombre')->ignore($this->route('ubicacione')),
            ],
            'tipo' => ['nullable', 'string', 'max:100', 'regex:/^[A-ZÁÉÍÓÚÑÜ\s.]+$/u'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la ubicación es obligatorio.',
            'nombre.regex' => 'El nombre solo puede contener letras, números, espacios y guiones.',
            'nombre.unique' => 'Esta ubicación ya está registrada.',
            'tipo.regex' => 'El tipo de ubicación solo puede contener letras.',
        ];
    }

    private function aMayusculas($valor): ?string
    {
        if ($valor === null || trim((string) $valor) === '') {
            return null;
        }

        return mb_strtoupper(trim((string) $valor), 'UTF-8');
    }
}
