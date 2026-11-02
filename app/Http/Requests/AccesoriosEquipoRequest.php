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
        $nuevoTipo = $this->aMayusculas($this->nuevo_tipo);

        $tipo = $nuevoTipo !== null
            ? $nuevoTipo
            : $this->aMayusculas($this->tipo);

        $this->merge([
            'tipo' => $tipo,
            'nuevo_tipo' => $nuevoTipo,
            'marca' => $this->aMayusculas($this->marca),
            'num_serie' => $this->aMayusculas($this->num_serie),
            'estado' => $this->normalizarEstado($this->estado),
            'observaciones' => $this->aMayusculas($this->observaciones),
        ]);
    }

    public function rules(): array
    {
        return [
            'equipo_id' => [
                'nullable',
                'integer',
                'exists:equipos,id',
            ],

            'tipo' => [
                'required',
                'string',
                'max:100',
            ],

            'nuevo_tipo' => [
                Rule::requiredIf(fn () => $this->input('tipo') === 'OTRO'),
                'nullable',
                'string',
                'max:100',
            ],

            'marca' => [
                'nullable',
                'string',
                'max:80',
            ],

            'num_serie' => [
                'required',
                'string',
                'max:100',
            ],

            'estado' => [
                'required',
                Rule::in(['BUENO', 'REGULAR', 'MALOGRADO']),
            ],

            'observaciones' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'equipo_id.exists' => 'El equipo seleccionado no existe.',

            'tipo.required' => 'Seleccione o registre el tipo de accesorio.',
            'tipo.max' => 'El tipo de accesorio no debe superar los 100 caracteres.',

            'nuevo_tipo.required' => 'Especifique el nuevo tipo de accesorio.',
            'nuevo_tipo.max' => 'El nuevo tipo no debe superar los 100 caracteres.',

            'num_serie.required' => 'El número de serie del accesorio es obligatorio.',

            'estado.required' => 'Seleccione el estado del accesorio.',
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

        return $valor;
    }
}
