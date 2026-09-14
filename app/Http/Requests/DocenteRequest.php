<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocenteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombres' => $this->aMayusculas($this->nombres),
            'apellidos' => $this->aMayusculas($this->apellidos),
            'cargo' => $this->aMayusculas($this->cargo),
            'dni' => ($this->dni !== null && trim((string) $this->dni) !== '')
                ? trim((string) $this->dni)
                : null,
            'correo' => $this->correo !== null ? strtolower(trim((string) $this->correo)) : null,
            'celular' => $this->celular !== null ? trim((string) $this->celular) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nombres' => ['required', 'string', 'max:100', 'regex:/^[A-ZÁÉÍÓÚÑÜ\s.]+$/u'],
            'apellidos' => ['required', 'string', 'max:100', 'regex:/^[A-ZÁÉÍÓÚÑÜ\s.]+$/u'],
            'cargo' => ['required', 'string', 'max:100', 'regex:/^[A-ZÁÉÍÓÚÑÜ\s.]+$/u'],
            'dni' => [
                'nullable',
                'digits:8',
                Rule::unique('docentes', 'dni')->ignore($this->route('docente')),
            ],
            'correo' => ['nullable', 'email', 'max:150'],
            'celular' => ['nullable', 'digits:9'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombres.regex' => 'Los nombres solo pueden contener letras.',
            'apellidos.regex' => 'Los apellidos solo pueden contener letras.',
            'cargo.regex' => 'El cargo solo puede contener letras.',
            'dni.digits' => 'El DNI debe tener 8 dígitos.',
            'dni.unique' => 'Este DNI ya está registrado.',
            'correo.email' => 'Ingrese un correo válido.',
            'celular.digits' => 'Ingrese un numero correcto',
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
