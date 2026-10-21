<?php

namespace App\Http\Controllers;

use App\Models\BajaEquipo;
use App\Models\Equipo;
use App\Models\PrestamoEquipo;
use App\Models\Auditoria;
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
            ->with('tipoEquipo')
            ->orderBy('marca')
            ->orderBy('modelo')
            ->get();

        return view('bajas-equipos.create', compact('equipos'));
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
            // Bloquear el equipo para evitar operaciones simultáneas.
            $equipo = Equipo::query()
                ->whereKey($datos['equipo_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($equipo->situacion_administrativa !== 'EN_INVENTARIO') {
                throw ValidationException::withMessages([
                    'equipo_id' => 'El equipo seleccionado ya no está disponible en el inventario.',
                ]);
            }

            // No permitir dar de baja un equipo con préstamo activo.
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
}
