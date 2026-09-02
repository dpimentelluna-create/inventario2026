<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PrestamoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Datos generales del préstamo
            'docente_id' => [
                'required',
                'exists:docentes,id',
            ],

            'cargo' => [
                'required',
                'string',
                'max:100',
            ],

            'fecha' => [
                'required',
                'date',
            ],

            'hora_inicio' => [
                'required',
                'date_format:H:i',
            ],

            'hora_fin' => [
                'nullable',
                'date_format:H:i',
                'after_or_equal:hora_inicio',
            ],

            // Estado se determina automáticamente,
            // por lo tanto NO se recibe desde el formulario.

            // Equipos del préstamo
            'equipos' => [
                'required',
                'array',
                'min:1',
            ],

            'equipos.*.equipo_id' => [
                'required',
                'exists:equipos,id',
                'distinct',
            ],

            'equipos.*.estado' => [
                'required',
                Rule::in([
                    'REGULAR',
                    'BUENO',
                    'MALOGRADO',
                ]),
            ],

            'equipos.*.observacion' => [
                'nullable',
                'string',
            ],

            // Accesorios de cada equipo
            'equipos.*.accesorios' => [
                'nullable',
                'array',
            ],

            'equipos.*.accesorios.*.accesorio_equipo_id' => [
                'required',
                'exists:accesorios_equipo,id',
            ],

            'equipos.*.accesorios.*.estado' => [
                'required',
                Rule::in([
                    'REGULAR',
                    'BUENO',
                    'MALOGRADO',
                ]),
            ],

            'equipos.*.accesorios.*.observacion' => [
                'nullable',
                'string',
            ],
        ];
    }
}