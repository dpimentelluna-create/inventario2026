<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Equipo::query();

        // Filtro por N.° de Serie
        if ($request->filled('num_serie')) {
            $query->where('num_serie', 'LIKE', '%' . $request->num_serie . '%');
        }

        // Filtro por Estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // IMPORTANTE: Debe usar paginate() para que funcione withQueryString() y los links()
        $equipos = $query->paginate(10)->withQueryString();

        return view('equipo.index', compact('equipos'))
            ->with('i', ($request->input('page', 1) - 1) * $equipos->perPage());
    }

    // Mantén el resto de métodos de tu controlador de equipos tal y como los tienes...
}