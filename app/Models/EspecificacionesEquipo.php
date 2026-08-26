<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Equipo;

class EspecificacionesEquipo extends Model
{
    protected $table = 'especificaciones_equipo';

    protected $perPage = 20;

    protected $fillable = [
        'equipo_id',
        'descripcion',
        'color',
        'estado',
        'observaciones'
    ];

    public function equipo()
    {
        return $this->belongsTo(
            Equipo::class,
            'equipo_id',
            'id'
        );
    }
}