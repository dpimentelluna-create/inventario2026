<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Equipo;

class EspecificacionesLaptop extends Model
{
    protected $table = 'especificaciones_laptop';

    protected $perPage = 20;

    protected $fillable = [
        'equipo_id',
        'procesador',
        'ram',
        'disco_duro',
        'sistema_operativo',
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