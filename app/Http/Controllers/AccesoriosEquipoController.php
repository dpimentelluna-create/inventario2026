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
     * Obtener los tipos de accesorios registrados.
     */
    private function obtenerTiposAccesorios($tipoActual = null)
    {
        $tipos = AccesoriosEquipo::query()
            ->whereNotNull('tipo')
            ->where('tipo', '!=', '')
            ->distinct()
            ->orderBy('tipo')
            ->pluck('tipo');

        // Conservar el tipo actual aunque no aparezca en otros registros.
        if ($tipoActual && !$tipos->contains($tipoActual)) {
            $tipos->push($tipoActual);
        }

        return $tipos->values();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accesoriosEquipos = AccesoriosEquipo::with('equipo')
            ->latest()
            ->get();

        return view('accesorios-equipo.index', compact('accesoriosEquipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $accesoriosEquipo = new AccesoriosEquipo();

        $tiposAccesorios = $this->obtenerTiposAccesorios();

        return view('accesorios-equipo.create', compact(
            'accesoriosEquipo',
            'tiposAccesorios'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccesoriosEquipoRequest $request): RedirectResponse
    {
        $datos = $request->validated();

        // El tipo nuevo se guarda directamente en la columna tipo.
        unset($datos['nuevo_tipo']);

        $accesorio = AccesoriosEquipo::create($datos);

        return Redirect::route('accesorios-equipo.index')
            ->with('success', 'Accesorio registrado.')
            ->with('toast_tipo', 'exito')
            ->with('accesorio_resaltado', $accesorio->id)
            ->with('accesorio_accion', 'crear');
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

        session([
            'accesorio_resaltado' => $accesoriosEquipo->id,
            'accesorio_accion' => 'ver'
        ]);

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

        $tiposAccesorios = $this->obtenerTiposAccesorios(
            $accesoriosEquipo->tipo
        );

        return view('accesorios-equipo.edit', compact(
            'accesoriosEquipo',
            'tiposAccesorios'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        AccesoriosEquipoRequest $request,
        AccesoriosEquipo $accesoriosEquipo
    ): RedirectResponse {
        $datos = $request->validated();

        unset($datos['nuevo_tipo']);

        $accesoriosEquipo->update($datos);

        return Redirect::route('accesorios-equipo.index')
            ->with('success', 'Accesorio actualizado.')
            ->with('toast_tipo', 'exito')
            ->with('accesorio_resaltado', $accesoriosEquipo->id)
            ->with('accesorio_accion', 'editar');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $accesorio = AccesoriosEquipo::findOrFail($id);

        $accesorio->delete();

        return Redirect::route('accesorios-equipo.index')
            ->with('success', 'Accesorio eliminado.')
            ->with('toast_tipo', 'exito');
    }

    /**
     * Buscar equipos por número de serie.
     */
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
