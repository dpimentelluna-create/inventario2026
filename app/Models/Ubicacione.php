<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ubicacione
 *
 * @property $id
 * @property $nombre
 * @property $tipo
 * @property $created_at
 * @property $updated_at
 *
 * @property Equipo[] $equipos
 * @property Prestamo[] $prestamos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Ubicacione extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'tipo'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipos()
    {
        return $this->hasMany(\App\Models\Equipo::class, 'id', 'ubicacion_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prestamos()
    {
        return $this->hasMany(\App\Models\Prestamo::class, 'id', 'ubicacion_destino_id');
    }
    
}
