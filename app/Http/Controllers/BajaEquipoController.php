<?php

namespace App\Http\Controllers;

use App\Models\BajaEquipo;
use App\Models\Equipo;
use App\Models\PrestamoEquipo;
use App\Models\Auditoria;
use App\Models\TiposEquipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BajaEquipoController extends Controller
{
    /**
     * Mostrar el historial de bajas administrativas.
     */
    public function index(): View
    {
        $bajas = BajaEquipo::with([
            'equipo.tipoEquipo',
            'equipo.ubicacione',
        ])
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->paginate(20);

        return view('bajas-equipos.index', compact('bajas'));
    }

    /**
     * Mostrar el formulario para registrar una baja.
     */
    public function create(): View
    {
        $equipos = Equipo::query()
            ->where('situacion_administrativa', 'EN_INVENTARIO')
            ->with(['tipoEquipo', 'ubicacione'])
            ->orderBy('marca')
            ->orderBy('modelo')
            ->get();

        $tiposEquipo = TiposEquipo::orderBy('nombre')->get();

        $equiposForJs = $equipos->map(function ($e) {
            return [
                'id' => $e->id,
                'tipo_id' => $e->tipo_equipo_id,
                'tipo' => $e->tipoEquipo->nombre ?? 'SIN TIPO',
                'marca' => $e->marca ?? '',
                'modelo' => $e->modelo ?? '',
                'serie' => $e->num_serie ?? '',
                'ubicacion' => $e->ubicacione->nombre ?? '',
            ];
        })->values();

        return view('bajas-equipos.create', compact('equipos', 'tiposEquipo', 'equiposForJs'));
    }

    /**
     * Registrar una baja administrativa.
     */
    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'equipo_id' => [
                'required',
                'integer',
                'exists:equipos,id',
            ],
            'fecha' => [
                'required',
                'date',
            ],
            'destino' => [
                'required',
                'string',
                'max:150',
            ],
            'quien_entrego' => [
                'required',
                'string',
                'max:150',
            ],
            'quien_recibio' => [
                'required',
                'string',
                'max:150',
            ],
            'observaciones' => [
                'nullable',
                'string',
            ],
        ]);

        $baja = DB::transaction(function () use ($datos) {
            $equipo = Equipo::query()
                ->whereKey($datos['equipo_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($equipo->situacion_administrativa !== 'EN_INVENTARIO') {
                throw ValidationException::withMessages([
                    'equipo_id' => 'El equipo seleccionado ya no está disponible en el inventario.',
                ]);
            }

            $tienePrestamoActivo = PrestamoEquipo::query()
                ->where('equipo_id', $equipo->id)
                ->whereHas('prestamo', function ($query) {
                    $query->where('estado', 'ACTIVO');
                })
                ->exists();

            if ($tienePrestamoActivo) {
                throw ValidationException::withMessages([
                    'equipo_id' => 'No se puede dar de baja este equipo porque tiene un préstamo activo.',
                ]);
            }

            $baja = BajaEquipo::create([
                'equipo_id' => $equipo->id,
                'fecha' => $datos['fecha'],
                'destino' => $datos['destino'],
                'quien_entrego' => $datos['quien_entrego'],
                'quien_recibio' => $datos['quien_recibio'],
                'observaciones' => $datos['observaciones'] ?? null,
            ]);

            $equipo->update([
                'situacion_administrativa' => 'DE_BAJA',
            ]);

            Auditoria::registrar(
                'CREAR',
                'BAJAS DE EQUIPOS',
                "Se registró la baja administrativa del equipo #{$equipo->id}.",
                $baja,
                [
                    'nuevo' => [
                        'equipo_id' => $equipo->id,
                        'fecha' => $datos['fecha'],
                        'destino' => $datos['destino'],
                        'quien_entrego' => $datos['quien_entrego'],
                        'quien_recibio' => $datos['quien_recibio'],
                        'observaciones' => $datos['observaciones'] ?? null,
                    ],
                ]
            );

            return $baja;
        });

        return redirect()
            ->route('bajas-equipos.index')
            ->with('success', 'Baja administrativa registrada correctamente.')
            ->with('toast_tipo', 'exito')
            ->with('baja_resaltada', $baja->id);
    }

    /**
     * Mostrar el detalle de una baja registrada.
     */
    public function show(BajaEquipo $bajas_equipo): View
    {
        $baja = $bajas_equipo->load([
            'equipo.tipoEquipo',
            'equipo.ubicacione',
        ]);

        return view('bajas-equipos.show', compact('baja'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(BajaEquipo $bajas_equipo): View
    {
        $baja = $bajas_equipo->load([
            'equipo.tipoEquipo',
            'equipo.ubicacione',
        ]);

        // Equipos EN_INVENTARIO + el equipo actual de esta baja
        $equipos = Equipo::query()
            ->where(function ($q) use ($baja) {
                $q->where('situacion_administrativa', 'EN_INVENTARIO')
                  ->orWhere('id', $baja->equipo_id);
            })
            ->with(['tipoEquipo', 'ubicacione'])
            ->orderBy('marca')
            ->orderBy('modelo')
            ->get();

        $tiposEquipo = TiposEquipo::orderBy('nombre')->get();

        $equiposForJs = $equipos->map(function ($e) {
            return [
                'id' => $e->id,
                'tipo_id' => $e->tipo_equipo_id,
                'tipo' => $e->tipoEquipo->nombre ?? 'SIN TIPO',
                'marca' => $e->marca ?? '',
                'modelo' => $e->modelo ?? '',
                'serie' => $e->num_serie ?? '',
                'ubicacion' => $e->ubicacione->nombre ?? '',
            ];
        })->values();

        return view('bajas-equipos.edit', compact('baja', 'equipos', 'tiposEquipo', 'equiposForJs'));
    }

    /**
     * Actualizar una baja administrativa.
     */
    public function update(Request $request, BajaEquipo $bajas_equipo): RedirectResponse
    {
        $datos = $request->validate([
            'equipo_id' => [
                'required',
                'integer',
                'exists:equipos,id',
            ],
            'fecha' => [
                'required',
                'date',
            ],
            'destino' => [
                'required',
                'string',
                'max:150',
            ],
            'quien_entrego' => [
                'required',
                'string',
                'max:150',
            ],
            'quien_recibio' => [
                'required',
                'string',
                'max:150',
            ],
            'observaciones' => [
                'nullable',
                'string',
            ],
        ]);

        $baja = DB::transaction(function () use ($datos, $bajas_equipo) {
            $baja = BajaEquipo::query()
                ->whereKey($bajas_equipo->id)
                ->lockForUpdate()
                ->firstOrFail();

            $equipoAnteriorId = $baja->equipo_id;
            $nuevoEquipoId = (int) $datos['equipo_id'];

            $equipoNuevo = Equipo::query()
                ->whereKey($nuevoEquipoId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($nuevoEquipoId !== $equipoAnteriorId) {
                if ($equipoNuevo->situacion_administrativa !== 'EN_INVENTARIO') {
                    throw ValidationException::withMessages([
                        'equipo_id' => 'El equipo seleccionado ya no está disponible en el inventario.',
                    ]);
                }

                $tienePrestamoActivo = PrestamoEquipo::query()
                    ->where('equipo_id', $equipoNuevo->id)
                    ->whereHas('prestamo', function ($query) {
                        $query->where('estado', 'ACTIVO');
                    })
                    ->exists();

                if ($tienePrestamoActivo) {
                    throw ValidationException::withMessages([
                        'equipo_id' => 'No se puede dar de baja este equipo porque tiene un préstamo activo.',
                    ]);
                }

                // Restaurar el equipo anterior
                Equipo::query()
                    ->whereKey($equipoAnteriorId)
                    ->lockForUpdate()
                    ->update(['situacion_administrativa' => 'EN_INVENTARIO']);

                // Marcar el nuevo como DE_BAJA
                $equipoNuevo->update(['situacion_administrativa' => 'DE_BAJA']);
            }

            $baja->update([
                'equipo_id' => $nuevoEquipoId,
                'fecha' => $datos['fecha'],
                'destino' => $datos['destino'],
                'quien_entrego' => $datos['quien_entrego'],
                'quien_recibio' => $datos['quien_recibio'],
                'observaciones' => $datos['observaciones'] ?? null,
            ]);

            Auditoria::registrar(
                'EDITAR',
                'BAJAS DE EQUIPOS',
                "Se actualizó la baja administrativa #{$baja->id}.",
                $baja,
                [
                    'nuevo' => [
                        'equipo_id' => $nuevoEquipoId,
                        'fecha' => $datos['fecha'],
                        'destino' => $datos['destino'],
                        'quien_entrego' => $datos['quien_entrego'],
                        'quien_recibio' => $datos['quien_recibio'],
                        'observaciones' => $datos['observaciones'] ?? null,
                    ],
                ]
            );

            return $baja;
        });

        return redirect()
            ->route('bajas-equipos.index')
            ->with('success', 'Baja administrativa actualizada correctamente.')
            ->with('toast_tipo', 'exito')
            ->with('baja_resaltada', $baja->id);
    }

    /**
     * Eliminar (anular) una baja administrativa y restaurar el equipo.
     */
    public function destroy(BajaEquipo $bajas_equipo): RedirectResponse
    {
        DB::transaction(function () use ($bajas_equipo) {
            $baja = BajaEquipo::query()
                ->whereKey($bajas_equipo->id)
                ->lockForUpdate()
                ->firstOrFail();

            $equipoId = $baja->equipo_id;

            $equipo = Equipo::query()
                ->whereKey($equipoId)
                ->lockForUpdate()
                ->first();

            if ($equipo) {
                $equipo->update([
                    'situacion_administrativa' => 'EN_INVENTARIO',
                ]);
            }

            Auditoria::registrar(
                'ELIMINAR',
                'BAJAS DE EQUIPOS',
                "Se anuló la baja administrativa #{$baja->id} del equipo #{$equipoId}. El equipo vuelve a EN_INVENTARIO.",
                $baja,
                [
                    'anterior' => [
                        'equipo_id' => $equipoId,
                        'fecha' => $baja->fecha,
                        'destino' => $baja->destino,
                    ],
                ]
            );

            $baja->delete();
        });

        return redirect()
            ->route('bajas-equipos.index')
            ->with('success', 'Baja administrativa anulada. El equipo volvió a EN_INVENTARIO.')
            ->with('toast_tipo', 'exito');
    }
}