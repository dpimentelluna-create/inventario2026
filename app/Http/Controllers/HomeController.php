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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalEquipos = Equipo::count();

        $equiposBuenos = Equipo::whereHas('especificacionesLaptops', function ($q) {
            $q->where('estado', 'BUENO');
        })
            ->orWhereHas('especificacionesEquipo', function ($q) {
                $q->where('estado', 'BUENO');
            })
            ->count();

        $equiposMalogrados = Equipo::whereHas('especificacionesLaptops', function ($q) {
            $q->where('estado', 'MALOGRADO');
        })
            ->orWhereHas('especificacionesEquipo', function ($q) {
                $q->where('estado', 'MALOGRADO');
            })
            ->count();

        $prestamosActivos = Prestamo::where('estado', 'ACTIVO')->count();
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
