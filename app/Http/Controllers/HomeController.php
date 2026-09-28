<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\Prestamo;
use App\Models\Docente;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // ELIMINAMOS O COMENTAMOS EL MIDDLEWARE 'auth' PARA QUE SEA PÚBLICO O DIRECTO
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Conteos para las tarjetas estadísticas del Inicio
        $totalEquipos = Equipo::count();
        $equiposBuenos = Equipo::where('estado', 'like', '%bueno%')
                               ->orWhere('estado', 'like', '%operativo%')
                               ->count();
        $equiposMalogrados = Equipo::where('estado', 'like', '%malogrado%')
                                  ->orWhere('estado', 'like', '%mantenimiento%')
                                  ->orWhere('estado', 'like', '%dañado%')
                                  ->count();
        
        $prestamosActivos = Prestamo::where('estado', 'activo')->count();
        $totalDocentes = Docente::count();

        return view('home', compact(
            'totalEquipos', 
            'equiposBuenos', 
            'equiposMalogrados', 
            'prestamosActivos', 
            'totalDocentes'
        ));
    }
}