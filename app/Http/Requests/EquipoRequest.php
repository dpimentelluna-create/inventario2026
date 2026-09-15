<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EquipoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'marca' => $this->aMayusculas($this->marca),
            'modelo' => $this->aMayusculas($this->modelo),
            'num_serie' => $this->aMayusculas($this->num_serie),
            'procesador' => $this->aMayusculas($this->procesador),
            'ram' => $this->aMayusculas($this->ram),
            'disco_duro' => $this->aMayusculas($this->disco_duro),
            'color_laptop' => $this->aMayusculas($this->color_laptop),
            'color_equipo' => $this->aMayusculas($this->color_equipo),
            'descripcion' => $this->aMayusculas($this->descripcion),
            'observaciones_laptop' => $this->aMayusculas($this->observaciones_laptop),
            'observaciones_equipo' => $this->aMayusculas($this->observaciones_equipo),
            'estado_laptop' => $this->normalizarEstado($this->estado_laptop),
            'estado_equipo' => $this->normalizarEstado($this->estado_equipo),
            'nuevo_tipo_equipo' => $this->aMayusculas($this->nuevo_tipo_equipo),
        ]);
    }

    public function rules(): array
    {
        return [
            'tipo_equipo_id' => ['required_without:nuevo_tipo_equipo', 'nullable', 'exists:tipos_equipo,id'],
            'nuevo_tipo_equipo' => [
                'nullable',
                'string',
                'max:100',
                'required_without:tipo_equipo_id',
                Rule::unique('tipos_equipo', 'nombre'),
            ],
            'marca' => ['required', 'string', 'max:80'],
            'modelo' => ['nullable', 'string', 'max:100'],
            'num_serie' => ['required', 'string', 'max:100'],
            'ubicacion_id' => ['required', 'exists:ubicaciones,id'],
            'fecha_registro' => ['required', 'date'],

            'procesador' => ['nullable', 'string'],
            'ram' => ['nullable', 'string'],
            'disco_duro' => ['nullable', 'string'],
            'color_laptop' => ['nullable', 'string'],
            'estado_laptop' => ['nullable', Rule::in(['BUENO', 'REGULAR', 'MALOGRADO'])],
            'observaciones_laptop' => ['nullable', 'string'],

            'descripcion' => ['nullable', 'string'],
            'color_equipo' => ['nullable', 'string'],
            'estado_equipo' => ['nullable', Rule::in(['BUENO', 'REGULAR', 'MALOGRADO'])],
            'observaciones_equipo' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'estado_laptop.in' => 'El estado solo puede ser BUENO, REGULAR o MALOGRADO.',
            'estado_equipo.in' => 'El estado solo puede ser BUENO, REGULAR o MALOGRADO.',
            'num_serie.required' => 'El número de serie es obligatorio.',
        ];
    }

    private function aMayusculas($valor): ?string
    {
        if ($valor === null || trim((string) $valor) === '') {
            return null;
        }

        return mb_strtoupper(trim((string) $valor), 'UTF-8');
    }

    private function normalizarEstado($estado): ?string
    {
        if ($estado === null || trim((string) $estado) === '') {
            return null;
        }

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
