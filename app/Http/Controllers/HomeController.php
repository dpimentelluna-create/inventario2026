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
        // Obtener el estado físico desde la tabla de especificaciones.
        $estadoSQL = "UPPER(TRIM(COALESCE(
        NULLIF(TRIM(el.estado), ''),
        NULLIF(TRIM(ee.estado), ''),
        ''
    )))";

        // Resumen general: separar inventario activo y equipos dados de baja.
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
            COUNT(DISTINCT CASE
                WHEN e.situacion_administrativa = 'EN_INVENTARIO'
                THEN e.id
            END) AS total,
            COUNT(DISTINCT CASE
                WHEN e.situacion_administrativa = 'DE_BAJA'
                THEN e.id
            END) AS dados_baja,
            COUNT(DISTINCT CASE
                WHEN e.situacion_administrativa = 'EN_INVENTARIO'
                    AND {$estadoSQL} = 'BUENO'
                THEN e.id
            END) AS buenos,
            COUNT(DISTINCT CASE
                WHEN e.situacion_administrativa = 'EN_INVENTARIO'
                    AND {$estadoSQL} = 'REGULAR'
                THEN e.id
            END) AS regulares,
            COUNT(DISTINCT CASE
                WHEN e.situacion_administrativa = 'EN_INVENTARIO'
                    AND {$estadoSQL} = 'MALOGRADO'
                THEN e.id
            END) AS malogrados
        ")
            ->first();

        $totalEquipos = (int) $resumenGeneral->total;
        $totalEquiposDadosBaja = (int) $resumenGeneral->dados_baja;
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

        // Totales de los demás módulos.
        $totalPrestamos = Prestamo::count();
        $totalAccesorios = AccesoriosEquipo::count();
        $totalTiposEquipo = TiposEquipo::count();
        $totalDocentes = Docente::count();
        $totalUbicaciones = Ubicacione::count();

        // Equipos por tipo: contar solamente los que siguen en inventario.
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
            ->select('t.id', 't.nombre')
            ->selectRaw("
            COUNT(DISTINCT CASE
                WHEN e.situacion_administrativa = 'EN_INVENTARIO'
                THEN e.id
            END) AS total,
            COUNT(DISTINCT CASE
                WHEN e.situacion_administrativa = 'EN_INVENTARIO'
                    AND {$estadoSQL} = 'BUENO'
                THEN e.id
            END) AS buenos,
            COUNT(DISTINCT CASE
                WHEN e.situacion_administrativa = 'EN_INVENTARIO'
                    AND {$estadoSQL} = 'REGULAR'
                THEN e.id
            END) AS regulares,
            COUNT(DISTINCT CASE
                WHEN e.situacion_administrativa = 'EN_INVENTARIO'
                    AND {$estadoSQL} = 'MALOGRADO'
                THEN e.id
            END) AS malogrados
        ")
            ->groupBy('t.id', 't.nombre')
            ->orderBy('t.nombre')
            ->get();

        // Equipos por ubicación: excluir las bajas de los totales activos.
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
            ->select('u.id', 'u.nombre', 'u.tipo')
            ->selectRaw("
            COUNT(DISTINCT CASE
                WHEN e.situacion_administrativa = 'EN_INVENTARIO'
                THEN e.id
            END) AS total,
            COUNT(DISTINCT CASE
                WHEN e.situacion_administrativa = 'EN_INVENTARIO'
                    AND {$estadoSQL} = 'BUENO'
                THEN e.id
            END) AS buenos,
            COUNT(DISTINCT CASE
                WHEN e.situacion_administrativa = 'EN_INVENTARIO'
                    AND {$estadoSQL} = 'REGULAR'
                THEN e.id
            END) AS regulares,
            COUNT(DISTINCT CASE
                WHEN e.situacion_administrativa = 'EN_INVENTARIO'
                    AND {$estadoSQL} = 'MALOGRADO'
                THEN e.id
            END) AS malogrados
        ")
            ->groupBy('u.id', 'u.nombre', 'u.tipo')
            ->orderBy('u.nombre')
            ->get();

        return view('home', compact(
            'totalEquipos',
            'totalEquiposDadosBaja',
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
            'totalTiposEquipo'
        ));
    }
}