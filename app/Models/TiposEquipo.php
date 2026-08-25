<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TiposEquipo
 *
 * @property $id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property Equipo[] $equipos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class TiposEquipo extends Model
{
    protected $table = 'tipos_equipo';
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipos()
    {
        return $this->hasMany(\App\Models\Equipo::class, 'id', 'tipo_equipo_id');
    }
    
}
