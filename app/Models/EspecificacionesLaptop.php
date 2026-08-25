<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Equipo; // NECESARIO
/**
 * Class EspecificacionesLaptop
 *
 * @property $id
 * @property $equipo_id
 * @property $procesador
 * @property $ram
 * @property $disco_duro
 * @property $created_at
 * @property $updated_at
 *
 * @property Equipo $equipo
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class EspecificacionesLaptop extends Model
{
    protected $table = 'especificaciones_laptop';
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['equipo_id', 'procesador', 'ram', 'disco_duro','color','estado','observaciones'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id', 'id');
    }
    
}
