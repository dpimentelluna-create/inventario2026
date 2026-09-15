<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccesoriosEquipoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'tipo' => $this->aMayusculas($this->tipo),
            'marca' => $this->aMayusculas($this->marca),
            'num_serie' => $this->aMayusculas($this->num_serie),
            'estado' => $this->normalizarEstado($this->estado),
            'observaciones' => $this->aMayusculas($this->observaciones),
        ]);
    }
    public function rules(): array
    {
        return [
            'equipo_id' => ['required', 'exists:equipos,id'],
            'tipo' => ['required', 'string', 'max:100'],
            'marca' => ['nullable', 'string', 'max:80'],
            'num_serie' => ['required', 'string', 'max:100'],
            'estado' => ['required', Rule::in(['BUENO', 'REGULAR', 'MALOGRADO'])],
            'observaciones' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'num_serie.required' => 'El número de serie del accesorio es obligatorio.',
            'estado.in' => 'El estado solo puede ser BUENO, REGULAR o MALOGRADO.',
        ];
    }

    private function aMayusculas($valor): ?string
    {
        if ($valor === null || trim((string) $valor) === '') {
            return null;
        }

        return mb_strtoupper(trim((string) $valor), 'UTF-8');
    }

    private function normalizarEstado($estado): string
    {
        $valor = mb_strtoupper(trim((string) $estado), 'UTF-8');

        if (str_contains($valor, 'MALO')) {
            return 'MALOGRADO';
        }

        if (str_contains($valor, 'REG')) {
            return 'REGULAR';
        }

        return 'BUENO';
    }
}
