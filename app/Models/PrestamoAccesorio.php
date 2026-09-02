<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrestamoAccesorio extends Model
{
    protected $fillable = [
        'prestamo_equipo_id',
        'accesorio_equipo_id',
        'estado',
        'observacion',
    ];

    /**
     * Equipo del préstamo al que pertenece este accesorio
     */
    public function prestamoEquipo(): BelongsTo
    {
        return $this->belongsTo(
            PrestamoEquipo::class,
            'prestamo_equipo_id'
        );
    }

    /**
     * Accesorio real relacionado
     */
    public function accesorioEquipo(): BelongsTo
    {
        return $this->belongsTo(
            AccesoriosEquipo::class,
            'accesorio_equipo_id'
        );
    }
}