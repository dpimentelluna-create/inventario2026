<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Equipo
 *
 * @property $id
 * @property $tipo_equipo_id
 * @property $marca
 * @property $modelo
 * @property $num_serie
 * @property $codigo_inventario
 * @property $estado
 * @property $ubicacion_id
 * @property $fecha_registro
 * @property $observacion
 * @property $created_at
 * @property $updated_at
 *
 * @property TiposEquipo $tiposEquipo
 * @property Ubicacione $ubicacione
 * @property AccesoriosEquipo[] $accesoriosEquipos
 * @property EspecificacionesLaptop[] $especificacionesLaptops
 * @property Prestamo[] $prestamos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Equipo extends Model
{
    protected $table = 'equipos';
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['tipo_equipo_id', 'marca', 'modelo', 'num_serie', 'codigo_inventario', 'estado', 'ubicacion_id', 'fecha_registro', 'observacion'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoEquipo(){
    return $this->belongsTo(
        \App\Models\TiposEquipo::class,
        'tipo_equipo_id',
        'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ubicacione()
    {
        return $this->belongsTo(
            \App\Models\Ubicacione::class, 
            'ubicacion_id', 
            'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accesoriosEquipos()
    {
        return $this->hasMany(
            \App\Models\AccesoriosEquipo::class,
            'equipo_id',
            'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function especificacionesLaptops()
    {
        return $this->hasMany(
            \App\Models\EspecificacionesLaptop::class, 
            'equipo_id', 
            'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prestamos()
    {
        return $this->hasMany(
            \App\Models\Prestamo::class, 
            'equipo_id', 
            'id');
    }
     
}
