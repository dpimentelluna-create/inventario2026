<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Carbon\Carbon;

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
            if (!is_array($equipo)) {
                continue;
            }

            $equipos[$i]['estado'] = $this->normalizarEstado(
                $equipo['estado'] ?? null
            );

            if (
                empty($equipo['accesorios'])
                || !is_array($equipo['accesorios'])
            ) {
                continue;
            }

            foreach ($equipos[$i]['accesorios'] as $j => $accesorio) {
                if (!is_array($accesorio)) {
                    continue;
                }

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
            'fecha_fin' => ['required', 'date', 'after_or_equal:fecha'],

            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fin' => ['nullable', 'date_format:H:i'],

            'equipos' => ['required', 'array', 'min:1'],
            'equipos.*.equipo_id' => [
                'required',
                'exists:equipos,id',
                'distinct',
            ],
            'equipos.*.estado' => [
                'required',
                Rule::in(['REGULAR', 'BUENO', 'MALOGRADO']),
            ],
            'equipos.*.observacion' => ['nullable', 'string'],

            'equipos.*.accesorios' => ['nullable', 'array'],
            'equipos.*.accesorios.*.accesorio_equipo_id' => [
                'required',
                'exists:accesorios_equipo,id',
            ],
            'equipos.*.accesorios.*.estado' => [
                'required',
                Rule::in(['REGULAR', 'BUENO', 'MALOGRADO']),
            ],
            'equipos.*.accesorios.*.observacion' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'docente_id.required' => 'Seleccione un solicitante.',
            'docente_id.exists' => 'El solicitante no existe.',
            'cargo.required' => 'El cargo es obligatorio.',

            'fecha.required' => 'La fecha de inicio es obligatoria.',
            'fecha.date' => 'La fecha de inicio no es válida.',
            'fecha_fin.required' => 'La fecha final es obligatoria.',
            'fecha_fin.date' => 'La fecha final no es válida.',
            'fecha_fin.after_or_equal' => 'La fecha final no puede ser anterior a la fecha de inicio.',

            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_inicio.date_format' => 'La hora de inicio no tiene un formato válido.',
            'hora_fin.date_format' => 'La hora final no tiene un formato válido.',

            'equipos.required' => 'Debe seleccionar al menos un equipo.',
            'equipos.min' => 'Debe seleccionar al menos un equipo.',
            'equipos.*.equipo_id.required' => 'Hay un equipo sin identificar.',
            'equipos.*.equipo_id.distinct' => 'No puede repetir el mismo equipo.',
            'equipos.*.estado.required' => 'El estado del equipo es obligatorio.',
            'equipos.*.accesorios.*.accesorio_equipo_id.required' => 'Hay un accesorio sin identificar.',
            'equipos.*.accesorios.*.estado.required' => 'El estado del accesorio es obligatorio.',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {

                /*
                 * VALIDACIÓN DE FECHAS Y HORAS
                 */

                if (
                    !$validator->errors()->has('fecha')
                    && !$validator->errors()->has('fecha_fin')
                    && !$validator->errors()->has('hora_inicio')
                    && !$validator->errors()->has('hora_fin')
                    && $this->filled('hora_fin')
                ) {
                    $inicio = Carbon::parse(
                        $this->input('fecha') . ' ' . $this->input('hora_inicio')
                    );

                    $fin = Carbon::parse(
                        $this->input('fecha_fin') . ' ' . $this->input('hora_fin')
                    );

                    if ($fin->lessThanOrEqualTo($inicio)) {
                        $validator->errors()->add(
                            'hora_fin',
                            'La fecha y hora final deben ser posteriores a la fecha y hora de inicio.'
                        );
                    }
                }

                /*
                 * VALIDACIÓN DE ACCESORIOS
                 *
                 * Un accesorio puede estar relacionado con otro equipo
                 * o no tener equipo relacionado.
                 *
                 * Solo se evita repetirlo dentro del mismo préstamo.
                 */

                $equipos = $this->input('equipos', []);

                if (!is_array($equipos)) {
                    return;
                }

                $idsAccesorios = [];

                foreach ($equipos as $indiceEquipo => $equipo) {
                    if (!is_array($equipo)) {
                        continue;
                    }

                    // Si el equipo no envía accesorios, se considera una lista vacía.
                    $accesorios = $equipo['accesorios'] ?? [];

                    if (!is_array($accesorios)) {
                        continue;
                    }

                    foreach ($accesorios as $indiceAccesorio => $accesorio) {
                        if (
                            !is_array($accesorio)
                            || empty($accesorio['accesorio_equipo_id'])
                        ) {
                            continue;
                        }

                        $accesorioId = (int) $accesorio['accesorio_equipo_id'];

                        if (in_array($accesorioId, $idsAccesorios, true)) {
                            $validator->errors()->add(
                                "equipos.{$indiceEquipo}.accesorios.{$indiceAccesorio}.accesorio_equipo_id",
                                'No puede repetir el mismo accesorio dentro de un préstamo.'
                            );

                            continue;
                        }

                        $idsAccesorios[] = $accesorioId;
                    }
                }
            },
        ];
    }
}