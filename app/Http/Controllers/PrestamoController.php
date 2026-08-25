<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Equipo;
use App\Models\TiposEquipo;
use App\Models\Docente;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PrestamoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
         $prestamos = Prestamo::with([
            'equipo.tipoEquipo'
            ])->paginate();

    return view('prestamo.index', compact('prestamos'))
        ->with('i', (request()->input('page', 1) - 1) * $prestamos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $prestamo = new Prestamo();

        $tiposEquipo = TiposEquipo::pluck('nombre', 'id');
        $docente = Docente::pluck('nombres','id');

    return view('prestamo.create', compact(
        'prestamo',
        'tiposEquipo',
        'docente'
    ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PrestamoRequest $request): RedirectResponse
    {
        Prestamo::create($request->validated());

        return Redirect::route('prestamos.index')
            ->with('success', 'Prestamo created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
    $prestamo = Prestamo::with([
        'equipo.tipoEquipo'
    ])->findOrFail($id);

    return view('prestamo.show', compact('prestamo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
    $prestamo = Prestamo::with('equipo')->findOrFail($id);

    $tiposEquipo = TiposEquipo::pluck('nombre', 'id');

    return view('prestamo.edit', compact(
        'prestamo',
        'tiposEquipo'
    ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PrestamoRequest $request, Prestamo $prestamo): RedirectResponse
    {
        $prestamo->update($request->validated());

        return Redirect::route('prestamos.index')
            ->with('success', 'Prestamo updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Prestamo::find($id)->delete();

        return Redirect::route('prestamos.index')
            ->with('success', 'Prestamo deleted successfully');
    }

    public function equiposPorTipo($tipoId)
    {
    $equipos = Equipo::where('tipo_equipo_id', $tipoId)
        ->select(
            'id',
            'marca',
            'modelo',
            'num_serie',
            'codigo_inventario'
        )
        ->get();

    return response()->json($equipos);
    }

    public function buscarEquipos(Request $request)
{
    $query = Equipo::with('tipoEquipo');

    if ($request->filled('tipo_equipo_id')) {
        $query->where(
            'tipo_equipo_id',
            $request->tipo_equipo_id
        );
    }

    if ($request->filled('buscar')) {
        $buscar = $request->buscar;

        $query->where(function ($q) use ($buscar) {
            $q->where('num_serie', 'LIKE', "%{$buscar}%")
              ->orWhere('codigo_inventario', 'LIKE', "%{$buscar}%");
        });
    }

    $equipos = $query
        ->select(
            'id',
            'tipo_equipo_id',
            'marca',
            'modelo',
            'num_serie',
            'codigo_inventario'
        )
        ->get();

    return response()->json($equipos);
}
}
