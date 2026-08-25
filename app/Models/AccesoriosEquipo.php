<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AccesoriosEquipo
 *
 * @property $id
 * @property $equipo_id
 * @property $tipo
 * @property $marca
 * @property $num_serie
 * @property $estado
 * @property $created_at
 * @property $updated_at
 *
 * @property Equipo $equipo
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class AccesoriosEquipo extends Model
{
    protected $table = 'accesorios_equipo';
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['equipo_id', 'tipo', 'marca', 'num_serie', 'estado','observaciones'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipo()
    {
        return $this->belongsTo(\App\Models\Equipo::class, 'equipo_id', 'id');
    }
    
}
