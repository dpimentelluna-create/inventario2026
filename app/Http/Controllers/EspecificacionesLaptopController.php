<?php

namespace App\Http\Controllers;

use App\Models\EspecificacionesLaptop;
use App\Models\Equipo;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\EspecificacionesLaptopRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EspecificacionesLaptopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $especificacionesLaptops = EspecificacionesLaptop::paginate();

        return view('especificaciones-laptop.index', compact('especificacionesLaptops'))
            ->with('i', ($request->input('page', 1) - 1) * $especificacionesLaptops->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $especificacionesLaptop = new EspecificacionesLaptop();

        return view('especificaciones-laptop.create', compact('especificacionesLaptop'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EspecificacionesLaptopRequest $request): RedirectResponse
    {
        EspecificacionesLaptop::create($request->validated());

        return Redirect::route('especificaciones-laptop.index')
            ->with('success', 'EspecificacionesLaptop created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $especificacionesLaptop = EspecificacionesLaptop::with([
            'equipo.tipoEquipo'
        ])
            ->findOrFail($id);

        return view(
            'especificaciones-laptop.show',
            compact('especificacionesLaptop')
    );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $especificacionesLaptop = EspecificacionesLaptop::with('equipo')
        ->findOrFail($id);

        return view(
        'especificaciones-laptop.edit',
        compact('especificacionesLaptop')
    );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EspecificacionesLaptopRequest $request, EspecificacionesLaptop $especificacionesLaptop): RedirectResponse
    {
        $especificacionesLaptop->update($request->validated());

        return Redirect::route('especificaciones-laptop.index')
            ->with('success', 'Especificaciones Equipo actualizadas correctamente.');
    }

    public function destroy($id): RedirectResponse
    {
        EspecificacionesLaptop::find($id)->delete();

        return Redirect::route('especificaciones-laptop.index')
            ->with('success', 'EspecificacionesLaptop deleted successfully');
    }


    //FUNCION PARA BUSCAR EQUIPOS
    public function buscarEquipos(Request $request)
    {
    $buscar = trim($request->get('buscar', ''));

    if ($buscar === '') {
        return response()->json([]);
    }

    $equipos = Equipo::with('tipoEquipo')
        ->whereNotNull('num_serie')
        ->where('num_serie', '!=', '')
        ->where('num_serie', 'LIKE', '%' . $buscar . '%')
        ->orderBy('num_serie')
        ->limit(10)
        ->get();

    return response()->json($equipos);
    }
}
