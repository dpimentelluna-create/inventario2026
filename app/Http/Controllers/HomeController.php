<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\TiposEquipo;
use App\Models\Ubicacione;
use App\Models\EspecificacionesLaptop;
use App\Models\EspecificacionesEquipo;
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
        $regulares = EspecificacionesLaptop::where('estado', 'Regular')->count()
        + EspecificacionesEquipo::where('estado', 'Regular')->count();

        $malogrados = EspecificacionesLaptop::where('estado', 'Malogrado')->count()
        + EspecificacionesEquipo::where('estado', 'Malogrado')->count();

        $buenos = EspecificacionesLaptop::where('estado', 'Bueno')->count()
        + EspecificacionesEquipo::where('estado', 'Bueno')->count();
        
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
    'buenos',
    'regulares',
    'malogrados',
    'equiposPorTipo',
    'equiposPorUbicacion',
    'ultimosEquipos'
        ));
    }
}