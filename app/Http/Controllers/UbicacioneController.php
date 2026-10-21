<?php

namespace App\Http\Controllers;

use App\Models\Ubicacione;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UbicacioneRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class UbicacioneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ubicaciones = Ubicacione::orderBy('nombre')->get();

        return view('ubicacione.index', compact('ubicaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $ubicacione = new Ubicacione();

        return view('ubicacione.create', compact('ubicacione'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UbicacioneRequest $request): RedirectResponse
    {
        $ubicacion = Ubicacione::create($request->validated());

        return Redirect::route('ubicaciones.index')
            ->with('success', 'Ubicación registrada.')
            ->with('toast_tipo', 'exito')
            ->with('ubicacion_resaltado', $ubicacion->id)
            ->with('ubicacion_accion', 'crear');
    }

    /**
     * Display the specified resource.
     */

    public function show($id): View
    {
        // Buscar la ubicación o mostrar error 404 si no existe.
        $ubicacione = Ubicacione::findOrFail($id);

        // Obtener el estado desde las especificaciones del equipo.
        // Si no tiene estado en la primera tabla, revisar la segunda.
        $estadoSQL = "UPPER(TRIM(COALESCE(
        NULLIF(TRIM(el.estado), ''),
        NULLIF(TRIM(ee.estado), ''),
        ''
    )))";

        
        // Resumen de equipos que siguen en inventario.
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
            ->where('e.ubicacion_id', $ubicacione->id)
            ->where('e.situacion_administrativa', 'EN_INVENTARIO')
            ->selectRaw("
                COUNT(DISTINCT e.id) AS total,
                COUNT(DISTINCT CASE WHEN {$estadoSQL} = 'BUENO' THEN e.id END) AS buenos,
                COUNT(DISTINCT CASE WHEN {$estadoSQL} = 'REGULAR' THEN e.id END) AS regulares,
                COUNT(DISTINCT CASE WHEN {$estadoSQL} = 'MALOGRADO' THEN e.id END) AS malogrados
            ")
            ->first();

        $totalEquipos = (int) $resumen->total;
        $buenos = (int) $resumen->buenos;
        $regulares = (int) $resumen->regulares;
        $malogrados = (int) $resumen->malogrados;

        // Contar los equipos dados de baja en esta ubicación.
        $equiposDadosBaja = \App\Models\Equipo::where(
            'ubicacion_id',
            $ubicacione->id
        )
            ->where('situacion_administrativa', 'DE_BAJA')
            ->count();


        // Equipos sin estado reconocido o sin especificaciones.
        $sinClasificar = max(
            0,
            $totalEquipos - $buenos - $regulares - $malogrados
        );

        // Calcular porcentajes sin dividir entre cero.
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

        
        // Obtener los equipos vigentes de la ubicación.
        $equipos = \App\Models\Equipo::with([
            'tipoEquipo',
            'especificacionesLaptops',
            'especificacionesEquipo'
        ])
            ->where('ubicacion_id', $ubicacione->id)
            ->where('situacion_administrativa', 'EN_INVENTARIO')
            ->orderByDesc('fecha_registro')
            ->orderByDesc('id')
            ->get();


        return view('ubicacione.show', compact(
            'ubicacione',
            'totalEquipos',
            'buenos',
            'regulares',
            'malogrados',
            'equiposDadosBaja',
            'sinClasificar',
            'porcentajeBueno',
            'porcentajeRegular',
            'porcentajeMalogrado',
            'porcentajeSinClasificar',
            'equipos'
        ));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $ubicacione = Ubicacione::find($id);

        return view('ubicacione.edit', compact('ubicacione'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UbicacioneRequest $request, Ubicacione $ubicacione): RedirectResponse
    {
        $ubicacione->update($request->validated());

        return Redirect::route('ubicaciones.index')
            ->with('success', 'Ubicación actualizada.')
            ->with('toast_tipo', 'exito')
            ->with('ubicacion_resaltado', $ubicacione->id)
            ->with('ubicacion_accion', 'editar');
    }

    public function destroy($id): RedirectResponse
    {
        Ubicacione::find($id)->delete();

        return Redirect::route('ubicaciones.index')
            ->with('success', 'Ubicación eliminada.')->with('toast_tipo', 'error');
    }
}
