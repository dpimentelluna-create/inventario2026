<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Prestamo
 *
 * @property $id
 * @property $equipo_id
 * @property $docente_id
 * @property $ubicacion_destino_id
 * @property $fecha_entrega
 * @property $fecha_devolucion_prevista
 * @property $fecha_devolucion_real
 * @property $estado
 * @property $observacion
 * @property $created_at
 * @property $updated_at
 *
 * @property Docente $docente
 * @property Equipo $equipo
 * @property Ubicacione $ubicacione
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Prestamo extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['equipo_id', 'docente_id', 'ubicacion_destino_id', 'fecha_entrega', 'fecha_devolucion_prevista', 'fecha_devolucion_real', 'estado', 'observacion'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function docente()
    {
        return $this->belongsTo(\App\Models\Docente::class, 'docente_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ubicacione()
    {
        return $this->belongsTo(\App\Models\Ubicacione::class, 'ubicacion_destino_id', 'id');
    }
    
    //llamar una foranea de otra foranea
        public function equipo(){
        return $this->belongsTo(TiposEquipo::class, 'tipo_equipo_id');
    }
        /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

}
