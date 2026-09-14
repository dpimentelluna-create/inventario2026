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

    public function prepareForValidation(): void
    {
        $equipos = $this->input('equipos', []);

        if (!is_array($equipos)) {
            return;
        }

        foreach ($equipos as $i => $equipo) {
            $equipos[$i]['estado'] = $this->normalizarEstado($equipo['estado'] ?? null);

            if (empty($equipo['accesorios']) || !is_array($equipo['accesorios'])) {
                continue;
            }

            foreach ($equipo['accesorios'] as $j => $accesorio) {
                $equipos[$i]['accesorios'][$j]['estado'] = $this->normalizarEstado(
                    $accesorio['estado'] ?? null
                );
            }
        }

        $this->merge(['equipos' => $equipos]);
    }

    private function normalizarEstado(?string $estado): string
    {
        $valor = strtoupper(trim((string) $estado));

        if (str_contains($valor, 'MALO')) {
            return 'MALOGRADO';
        }

        if (str_contains($valor, 'REG')) {
            return 'REGULAR';
        }

        return 'BUENO';
    }

    public function rules(): array
    {
        return [
            'docente_id' => ['required', 'exists:docentes,id'],
            'cargo' => ['required', 'string', 'max:100'],
            'fecha' => ['required', 'date'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fin' => ['nullable', 'date_format:H:i', 'after:hora_inicio'],

            'equipos' => ['required', 'array', 'min:1'],
            'equipos.*.equipo_id' => ['required', 'exists:equipos,id', 'distinct'],
            'equipos.*.estado' => ['required', Rule::in(['REGULAR', 'BUENO', 'MALOGRADO'])],
            'equipos.*.observacion' => ['nullable', 'string'],

            'equipos.*.accesorios' => ['nullable', 'array'],
            'equipos.*.accesorios.*.accesorio_equipo_id' => ['required', 'exists:accesorios_equipo,id'],
            'equipos.*.accesorios.*.estado' => ['required', Rule::in(['REGULAR', 'BUENO', 'MALOGRADO'])],
            'equipos.*.accesorios.*.observacion' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'docente_id.required' => 'Seleccione un solicitante.',
            'docente_id.exists' => 'El solicitante no existe.',
            'cargo.required' => 'El cargo es obligatorio.',
            'fecha.required' => 'La fecha es obligatoria.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_inicio.date_format' => 'La hora de inicio no tiene un formato válido.',
            'hora_fin.date_format' => 'La hora final no tiene un formato válido.',
            'hora_fin.after' => 'La hora final debe ser mayor que la hora de inicio.',
            'equipos.required' => 'Debe seleccionar al menos un equipo.',
            'equipos.min' => 'Debe seleccionar al menos un equipo.',
            'equipos.*.equipo_id.required' => 'Hay un equipo sin identificar.',
            'equipos.*.equipo_id.distinct' => 'No puede repetir el mismo equipo.',
            'equipos.*.estado.required' => 'El estado del equipo es obligatorio.',
            'equipos.*.accesorios.*.accesorio_equipo_id.required' => 'Hay un accesorio sin identificar.',
            'equipos.*.accesorios.*.estado.required' => 'El estado del accesorio es obligatorio.',
        ];
    }
}
