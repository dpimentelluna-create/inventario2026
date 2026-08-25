<?php

namespace App\Http\Controllers;

use App\Models\AccesoriosEquipo;
use App\Models\Equipo;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AccesoriosEquipoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AccesoriosEquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $accesoriosEquipos = AccesoriosEquipo::paginate();

        return view('accesorios-equipo.index', compact('accesoriosEquipos'))
            ->with('i', ($request->input('page', 1) - 1) * $accesoriosEquipos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $accesoriosEquipo = new AccesoriosEquipo();

        return view('accesorios-equipo.create', compact('accesoriosEquipo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccesoriosEquipoRequest $request): RedirectResponse
    {
        AccesoriosEquipo::create($request->validated());

        return Redirect::route('accesorios-equipo.index')
            ->with('success', 'AccesoriosEquipo created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $accesoriosEquipo = AccesoriosEquipo::with([
            'equipo.tipoEquipo',
            'equipo.ubicacione'
        ])->findOrFail($id);

        return view('accesorios-equipo.show', compact('accesoriosEquipo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
         $accesoriosEquipo = AccesoriosEquipo::with([
        'equipo.tipoEquipo',
        'equipo.ubicacione'
        ])->findOrFail($id);

        return view('accesorios-equipo.edit', compact('accesoriosEquipo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccesoriosEquipoRequest $request, AccesoriosEquipo $accesoriosEquipo): RedirectResponse
    {
        $accesoriosEquipo->update($request->validated());

        return Redirect::route('accesorios-equipo.index')
            ->with('success', 'AccesoriosEquipo updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        AccesoriosEquipo::find($id)->delete();

        return Redirect::route('accesorios-equipo.index')
            ->with('success', 'AccesoriosEquipo deleted successfully');
    }

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
