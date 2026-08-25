<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\TiposEquipo;
use App\Models\Ubicacione;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\EquipoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $buscar = trim($request->get('buscar'));
        $equipos = Equipo::with('tipoEquipo', 'ubicacione')
            ->where('marca', 'LIKE', '%'.$buscar.'%')
            ->orWhere('modelo', 'LIKE', '%'.$buscar.'%')
            ->orWhere('num_serie', 'LIKE', '%'.$buscar.'%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('equipo.index', compact('equipos', 'buscar'))
            ->with('i', (request()->input('page', 1) - 1) * $equipos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $equipo = new Equipo();
        $tiposequipo =TiposEquipo::pluck('nombre','id');
        $ubicacione =Ubicacione::pluck('nombre','id');

        return view('equipo.create', compact('equipo','tiposequipo','ubicacione'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EquipoRequest $request): RedirectResponse
    {
    Equipo::create($request->validated());

    return redirect()->route('equipos.index')
        ->with('success', 'Equipo registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $equipo = Equipo::with(
            'tipoEquipo', 
            'ubicacione', 
            'especificacionesLaptops', 
            'accesoriosEquipos'
            )->findOrFail($id);
        return view('equipo.show', compact('equipo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $equipo = Equipo::findOrFail($id);

        $tiposequipo = TiposEquipo::pluck('nombre', 'id');
        $ubicacione = Ubicacione::pluck('nombre', 'id');
        return view('equipo.edit', compact('equipo', 'tiposequipo', 'ubicacione'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EquipoRequest $request, Equipo $equipo): RedirectResponse
    {
        $equipo->update($request->all());

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo actualizado correctamente.');
    }

    public function destroy(Equipo $equipo): RedirectResponse
    {
        $equipo->delete();

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo eliminado correctamente.');
    }
}
