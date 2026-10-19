<?php

namespace App\Http\Controllers;

use App\Models\TiposEquipo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TiposEquipoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Equipo;
use Illuminate\Support\Facades\DB;

class TiposEquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tiposEquipos = TiposEquipo::orderBy('nombre')->get();

        return view('tipos-equipo.index', compact('tiposEquipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $tiposEquipo = new TiposEquipo();

        return view('tipos-equipo.create', compact('tiposEquipo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TiposEquipoRequest $request): RedirectResponse
    {
        $tipo = TiposEquipo::create($request->validated());

        return Redirect::route('tipos-equipo.index')
            ->with('success', 'Tipo de equipo registrado.')
            ->with('toast_tipo', 'exito')
            ->with('tipo_resaltado', $tipo->id)
            ->with('tipo_accion', 'crear');
    }

    /**
     * Display the specified resource.
     */

    public function show($id): View
    {
        // Buscar el tipo de equipo.
        $tiposEquipo = TiposEquipo::findOrFail($id);

        // Consultar el estado desde cualquiera de las dos tablas
        // de especificaciones.
        $estadoSQL = "UPPER(TRIM(COALESCE(
        NULLIF(TRIM(el.estado), ''),
        NULLIF(TRIM(ee.estado), ''),
        ''
    )))";

        // Obtener los totales sin cargar todos los equipos en memoria.
        $resumen = DB::table('equipos as e')
            ->leftJoin(
                'especificaciones_laptop as el',
                'el.equipo_id',
                '=',
                'e.id'
            )
            ->leftJoin(
                'especificaciones_equipo as ee',
                'ee.equipo_id',
                '=',
                'e.id'
            )
            ->where('e.tipo_equipo_id', $tiposEquipo->id)
            ->selectRaw("
            COUNT(DISTINCT e.id) AS total,
            SUM(CASE WHEN {$estadoSQL} = 'BUENO' THEN 1 ELSE 0 END) AS buenos,
            SUM(CASE WHEN {$estadoSQL} = 'REGULAR' THEN 1 ELSE 0 END) AS regulares,
            SUM(CASE WHEN {$estadoSQL} = 'MALOGRADO' THEN 1 ELSE 0 END) AS malogrados
        ")
            ->first();

        $totalEquipos = (int) $resumen->total;
        $buenos = (int) $resumen->buenos;
        $regulares = (int) $resumen->regulares;
        $malogrados = (int) $resumen->malogrados;

        // Equipos sin estado reconocido o sin especificaciones.
        $sinClasificar = max(
            0,
            $totalEquipos - $buenos - $regulares - $malogrados
        );

        // Calcular porcentajes evitando divisiones entre cero.
        $porcentajeBueno = $totalEquipos > 0
            ? round(($buenos / $totalEquipos) * 100, 1)
            : 0;

        $porcentajeRegular = $totalEquipos > 0
            ? round(($regulares / $totalEquipos) * 100, 1)
            : 0;

        $porcentajeMalogrado = $totalEquipos > 0
            ? round(($malogrados / $totalEquipos) * 100, 1)
            : 0;

        $porcentajeSinClasificar = $totalEquipos > 0
            ? round(($sinClasificar / $totalEquipos) * 100, 1)
            : 0;

        // Obtener solamente los cinco equipos más recientes.
        $ultimosEquipos = Equipo::with([
            'especificacionesLaptops',
            'especificacionesEquipo'
        ])
            ->where('tipo_equipo_id', $tiposEquipo->id)
            ->orderByDesc('fecha_registro')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        return view('tipos-equipo.show', compact(
            'tiposEquipo',
            'totalEquipos',
            'buenos',
            'regulares',
            'malogrados',
            'sinClasificar',
            'porcentajeBueno',
            'porcentajeRegular',
            'porcentajeMalogrado',
            'porcentajeSinClasificar',
            'ultimosEquipos'
        ));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $tiposEquipo = TiposEquipo::find($id);

        return view('tipos-equipo.edit', compact('tiposEquipo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TiposEquipoRequest $request, TiposEquipo $tiposEquipo): RedirectResponse
    {
        $tiposEquipo->update($request->validated());

        return Redirect::route('tipos-equipo.index')
            ->with('success', 'Tipo de equipo actualizado.')
            ->with('toast_tipo', 'exito')
            ->with('tipo_resaltado', $tiposEquipo->id)
            ->with('tipo_accion', 'editar');
    }

    public function destroy($id): RedirectResponse
    {
        TiposEquipo::find($id)->delete();

        return Redirect::route('tipos-equipo.index')
            ->with('success', 'Tipo de Equipo eliminado.')->with('toast_tipo', 'error');
    }
}
