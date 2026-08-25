<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Docente
 *
 * @property $id
 * @property $nombres
 * @property $apellidos
 * @property $cargo
 * @property $dni
 * @property $correo
 * @property $celular
 * @property $created_at
 * @property $updated_at
 *
 * @property Prestamo[] $prestamos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Docente extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombres', 'apellidos', 'cargo', 'dni', 'correo', 'celular'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prestamos()
    {
        return $this->hasMany(\App\Models\Prestamo::class, 'id', 'docente_id');
    }
    
}
