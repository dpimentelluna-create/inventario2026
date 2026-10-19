<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Auditoria extends Model
{
    protected $table = 'auditorias';
    protected $casts = [
    'cambios' => 'array',
];
    protected $fillable = [
        'usuario_id',
        'usuario_nombre',
        'accion',
        'modulo',
        'descripcion',
        'registro_tipo',
        'registro_id',
        'cambios',
        'ip',
        'user_agent',
        'resultado',
    ];


    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public static function registrar(
        string $accion,
        string $modulo,
        string $descripcion,
        ?Model $registro = null,
        ?array $cambios = null
    ): self {
        $actor = Auth::user();
        $request = app(Request::class);

        return self::create([
            'usuario_id' => $actor?->id,
            'usuario_nombre' => $actor?->name ?? 'SISTEMA',
            'accion' => strtoupper($accion),
            'modulo' => strtoupper($modulo),
            'descripcion' => $descripcion,
            'registro_tipo' => $registro
                ? class_basename($registro)
                : null,
            'registro_id' => $registro?->getKey(),
            'cambios' => $cambios,
            'ip' => $request->ip(),
            'user_agent' => substr(
                (string) $request->userAgent(),
                0,
                500
            ),
            'resultado' => 'EXITOSO',
        ]);
    }
}