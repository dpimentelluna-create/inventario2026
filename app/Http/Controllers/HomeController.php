<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Prestamo;
use App\Models\Docente;
use App\Models\TiposEquipo;
use App\Models\Ubicacione;
use Illuminate\Support\Facades\DB;
use App\Models\AccesoriosEquipo;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Expresión para obtener el estado desde la tabla correspondiente.
        $estadoSQL = "UPPER(TRIM(COALESCE(
            NULLIF(TRIM(el.estado), ''),
            NULLIF(TRIM(ee.estado), ''),
            ''
        )))";

        // Resumen general de todos los equipos.
        $resumenGeneral = DB::table('equipos as e')
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
            ->selectRaw("
                COUNT(DISTINCT e.id) AS total,
                COUNT(DISTINCT CASE
                    WHEN {$estadoSQL} = 'BUENO' THEN e.id
                END) AS buenos,
                COUNT(DISTINCT CASE
                    WHEN {$estadoSQL} = 'REGULAR' THEN e.id
                END) AS regulares,
                COUNT(DISTINCT CASE
                    WHEN {$estadoSQL} = 'MALOGRADO' THEN e.id
                END) AS malogrados
            ")
            ->first();

        $totalEquipos = (int) $resumenGeneral->total;
        $equiposBuenos = (int) $resumenGeneral->buenos;
        $equiposRegulares = (int) $resumenGeneral->regulares;
        $equiposMalogrados = (int) $resumenGeneral->malogrados;

        $equiposSinClasificar = max(
            0,
            $totalEquipos
                - $equiposBuenos
                - $equiposRegulares
                - $equiposMalogrados
        );

        // Total de préstamos activos.
        $prestamosActivos = Prestamo::where('estado', 'ACTIVO')->count();

        // Resumen de todos los módulos.
        $totalPrestamos = Prestamo::count();
        $totalAccesorios = AccesoriosEquipo::count();
        $totalTiposEquipo = TiposEquipo::count();

        // Total de docentes y ubicaciones.
        $totalDocentes = Docente::count();
        $totalUbicaciones = Ubicacione::count();

        // Resumen de equipos agrupados por tipo.
        $tiposEquipoResumen = DB::table('tipos_equipo as t')
            ->leftJoin('equipos as e', 'e.tipo_equipo_id', '=', 't.id')
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
            ->select(
                't.id',
                't.nombre'
            )
            ->selectRaw("
                COUNT(DISTINCT e.id) AS total,
                COUNT(DISTINCT CASE
                    WHEN {$estadoSQL} = 'BUENO' THEN e.id
                END) AS buenos,
                COUNT(DISTINCT CASE
                    WHEN {$estadoSQL} = 'REGULAR' THEN e.id
                END) AS regulares,
                COUNT(DISTINCT CASE
                    WHEN {$estadoSQL} = 'MALOGRADO' THEN e.id
                END) AS malogrados
            ")
            ->groupBy('t.id', 't.nombre')
            ->orderBy('t.nombre')
            ->get();

        // Resumen de equipos agrupados por ubicación.
        $ubicacionesResumen = DB::table('ubicaciones as u')
            ->leftJoin('equipos as e', 'e.ubicacion_id', '=', 'u.id')
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
            ->select(
                'u.id',
                'u.nombre',
                'u.tipo'
            )
            ->selectRaw("
                COUNT(DISTINCT e.id) AS total,
                COUNT(DISTINCT CASE
                    WHEN {$estadoSQL} = 'BUENO' THEN e.id
                END) AS buenos,
                COUNT(DISTINCT CASE
                    WHEN {$estadoSQL} = 'REGULAR' THEN e.id
                END) AS regulares,
                COUNT(DISTINCT CASE
                    WHEN {$estadoSQL} = 'MALOGRADO' THEN e.id
                END) AS malogrados
            ")
            ->groupBy('u.id', 'u.nombre', 'u.tipo')
            ->orderBy('u.nombre')
            ->get();

        return view('home', compact(
            'totalEquipos',
            'equiposBuenos',
            'equiposRegulares',
            'equiposMalogrados',
            'equiposSinClasificar',
            'prestamosActivos',
            'totalDocentes',
            'totalUbicaciones',
            'tiposEquipoResumen',
            'ubicacionesResumen',
            'totalPrestamos',
            'totalAccesorios',
            'totalTiposEquipo',
        ));
    }
}