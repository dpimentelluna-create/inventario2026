<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EspecificacionesLaptopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'procesador' => $this->aMayusculas($this->procesador),
            'ram' => $this->aMayusculas($this->ram),
            'disco_duro' => $this->aMayusculas($this->disco_duro),
            'color' => $this->aMayusculas($this->color),
            'observaciones' => $this->aMayusculas($this->observaciones),
            'estado' => $this->normalizarEstado($this->estado),
        ]);
    }

    public function rules(): array
    {
        return [
            'equipo_id' => ['required', 'exists:equipos,id'],
            'procesador' => ['nullable', 'string'],
            'ram' => ['nullable', 'string'],
            'disco_duro' => ['nullable', 'string'],
            'color' => ['nullable', 'string', 'max:50'],
            'estado' => ['required', Rule::in(['BUENO', 'REGULAR', 'MALOGRADO'])],
            'observaciones' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
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
