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
        'entregantes',
        'receptores',
        'observaciones',
        'estado',
        'anulada_at',
        'anulada_por',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'entregantes' => 'array',
            'receptores' => 'array',
            'anulada_at' => 'datetime',
        ];
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id', 'id');
    }

    public function anuladaPor()
    {
        return $this->belongsTo(User::class, 'anulada_por');
    }
}
