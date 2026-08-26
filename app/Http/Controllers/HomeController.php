<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\TiposEquipo;
use App\Models\Ubicacione;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        // Total de equipos
        $totalEquipos = Equipo::count();

        // Equipos por estado
        $operativos = Equipo::where('estado', 'Operativo')->count();
        $regulares = Equipo::where('estado', 'Regular')->count();
        $malogrados = Equipo::where('estado', 'Malogrado')->count();
        $deBaja = Equipo::where('estado', 'De baja')->count();

        // Cantidad de equipos por tipo
        $equiposPorTipo = TiposEquipo::withCount('equipos')
            ->orderBy('nombre')
            ->get();

        // Cantidad de equipos por ubicación
        $equiposPorUbicacion = Ubicacione::withCount('equipos')
            ->orderBy('nombre')
            ->get();

        // Últimos 5 equipos registrados
        $ultimosEquipos = Equipo::with([
            'tipoEquipo',
            'ubicacione'
        ])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

        return view('home', compact(
            'totalEquipos',
            'operativos',
            'regulares',
            'malogrados',
            'deBaja',
            'equiposPorTipo',
            'equiposPorUbicacion',
            'ultimosEquipos'
        ));
    }
}