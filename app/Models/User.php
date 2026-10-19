<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ROL_ADMINISTRADOR = 'administrador';
    public const ROL_REGISTRADOR = 'registrador';
    public const ROL_CONSULTA = 'consulta';

    public const ROLES = [
        self::ROL_ADMINISTRADOR => 'Administrador',
        self::ROL_REGISTRADOR => 'Registrador',
        self::ROL_CONSULTA => 'Consulta',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'activo' => 'boolean',
        'debe_cambiar_password' => 'boolean',
    ];

    public function esAdministrador(): bool
    {
        return $this->rol === self::ROL_ADMINISTRADOR;
    }

    public function puedeRegistrar(): bool
    {
        return in_array($this->rol, [self::ROL_ADMINISTRADOR, self::ROL_REGISTRADOR], true);
    }

    public function puedeEliminar(): bool
    {
        //return $this->esAdministrador(); //solo administradores se les permite eliminar
        return $this->esAdministrador() || $this->rol === self::ROL_REGISTRADOR; //solo administradores y registradores se les permite eliminar
    }

    public function etiquetaRol(): string
    {
        return self::ROLES[$this->rol] ?? 'Sin rol';
    }

    public function scopeAdministradoresActivos(Builder $query): Builder
    {
        return $query->where('rol', self::ROL_ADMINISTRADOR)->where('activo', true);
    }
}