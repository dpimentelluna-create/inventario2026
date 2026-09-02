<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prestamo extends Model
{
    protected $perPage = 20;

    protected $fillable = [
        'docente_id',
        'cargo',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'estado',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    /**
     * Docente que recibe el préstamo
     */
    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }

    /**
     * Equipos incluidos en el préstamo
     */
    public function prestamoEquipos(): HasMany
    {
        return $this->hasMany(PrestamoEquipo::class, 'prestamo_id');
    }
}