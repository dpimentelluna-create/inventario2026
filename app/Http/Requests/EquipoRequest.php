<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'tipo_equipo_id' => 'required',
			'marca' => 'required|string',
			'modelo' => 'nullable|string',
			'num_serie' => 'required|string',
			'codigo_inventario' => 'nullable|string',
			'estado' => 'required|in:Nuevo,Operativo,Regular,Malogrado,De baja',
			'ubicacion_id' => 'required|exists:ubicaciones,id',
            'fecha_registro' => 'required|date',
			'observacion' => 'nullable|string',
        ];
    }
}
