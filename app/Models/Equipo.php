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
 * @property $ubicacion_id
 * @property $fecha_registro
 * @property $created_at
 * @property $updated_at
 *
 * @property TiposEquipo $tipoEquipo
 * @property Ubicacione $ubicacione
 * @property AccesoriosEquipo[] $accesoriosEquipos
 * @property EspecificacionesLaptop $especificacionesLaptops
 * @property EspecificacionesEquipo $especificacionesEquipo
 * @property Prestamo[] $prestamos
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Equipo extends Model
{
    protected $table = 'equipos';

    protected $perPage = 20;

    protected $fillable = [
        'tipo_equipo_id',
        'marca',
        'modelo',
        'num_serie',
        'ubicacion_id',
        'fecha_registro',
        'situacion_administrativa'
    ];

    /**
     * Tipo de equipo al que pertenece.
     */
    public function tipoEquipo()
    {
        return $this->belongsTo(
            \App\Models\TiposEquipo::class,
            'tipo_equipo_id',
            'id'
        );
    }

    /**
     * Ubicación del equipo.
     */
    public function ubicacione()
    {
        return $this->belongsTo(
            \App\Models\Ubicacione::class,
            'ubicacion_id',
            'id'
        );
    }

    /**
     * Accesorios relacionados con este equipo.
     */
    public function accesoriosEquipos()
    {
        return $this->hasMany(
            \App\Models\AccesoriosEquipo::class,
            'equipo_id',
            'id'
        );
    }

    /**
     * Especificaciones de laptop.
     */
    public function especificacionesLaptops()
    {
        return $this->hasOne(
            \App\Models\EspecificacionesLaptop::class,
            'equipo_id',
            'id'
        );
    }

    /**
     * Especificaciones generales.
     */
    public function especificacionesEquipo()
    {
        return $this->hasOne(
            \App\Models\EspecificacionesEquipo::class,
            'equipo_id',
            'id'
        );
    }

    /**
     * Detalles de préstamos asociados a este equipo.
     */
    public function prestamoEquipos()
    {
        return $this->hasMany(
            \App\Models\PrestamoEquipo::class,
            'equipo_id',
            'id'
        );
    }

    /**
     * Préstamos asociados al equipo.
     */
    public function prestamos()
    {
        return $this->hasMany(
            \App\Models\Prestamo::class,
            'equipo_id',
            'id'
        );
    }

    /**
     * Registro de baja administrativa del equipo.
     */
    public function bajaEquipo()
    {
        return $this->hasOne(
            \App\Models\BajaEquipo::class,
            'equipo_id',
            'id'
        );
    }
}
