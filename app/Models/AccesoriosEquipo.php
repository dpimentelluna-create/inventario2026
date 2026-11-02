<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccesoriosEquipo extends Model
{
    protected $table = 'accesorios_equipo';

    protected $perPage = 20;

    protected $fillable = [
        'equipo_id',
        'tipo',
        'marca',
        'num_serie',
        'estado',
        'observaciones',
    ];

    /**
     * Equipo al que pertenece el accesorio.
     * Puede ser null si es un accesorio independiente.
     */
    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'equipo_id', 'id');
    }
}
