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

        //DATOS DEL EQUOPO
			'tipo_equipo_id' => 'required|exists:tipos_equipo,id',
			'marca' => 'required|string|max:80',
			'modelo' => 'nullable|string|max:100',
			'num_serie' => 'required|string|max:100',
			'ubicacion_id' => 'required|exists:ubicaciones,id',
            'fecha_registro' => 'required|date',
        
        //ESPECIFIACIONES LAPTOPS
            'procesador' => 'nullable|string', 
            'ram' => 'nullable|string',
             'disco_duro' => 'nullable|string', 
             'color_laptop' => 'nullable|string', 
             'estado_laptop' => 'nullable|in:Bueno,Regular,Malogrado', 
             'observaciones_laptop' => 'nullable|string',

        //ESPECIFICACIONES OTROS EQUIPOS
            'descripcion' => 'nullable|string', 
            'color_equipo' => 'nullable|string', 
            'estado_equipo' => 'nullable|in:Bueno,Regular,Malogrado', 
            'observaciones_equipo' => 'nullable|string',
        ];
    }
}
