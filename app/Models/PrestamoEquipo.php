<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrestamoEquipo extends Model
{
    protected $fillable = [
        'prestamo_id',
        'equipo_id',
        'estado',
        'observacion',
    ];

    /**
     * Préstamo al que pertenece este equipo
     */
    public function prestamo(): BelongsTo
    {
        return $this->belongsTo(Prestamo::class, 'prestamo_id');
    }

    /**
     * Equipo real relacionado
     */
    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }

    /**
     * Accesorios incluidos junto con este equipo
     */
    public function prestamoAccesorios(): HasMany
    {
        return $this->hasMany(
            PrestamoAccesorio::class,
            'prestamo_equipo_id'
        );
    }
}