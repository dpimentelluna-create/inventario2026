<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BajaEquipo extends Model
{
    protected $table = 'bajas_equipos';

    protected $fillable = [
        'equipo_id',
        'fecha',
        'destino',
        'quien_entrego',
        'quien_recibio',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
        ];
    }

    public function equipo()
    {
        return $this->belongsTo(
            Equipo::class,
            'equipo_id',
            'id'
        );
    }
}
