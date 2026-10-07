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
    public function index(Request $request): View
    {
        $query = AccesoriosEquipo::query();

        if ($request->filled('equipo')) {
            $query->whereHas('equipo', function ($q) use ($request) {
                $q->where('num_serie', 'LIKE', '%' . $request->equipo . '%');
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', 'LIKE', '%' . $request->tipo . '%');
        }

        if ($request->filled('marca')) {
            $query->where('marca', 'LIKE', '%' . $request->marca . '%');
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $accesoriosEquipos = $query->paginate(10)->withQueryString();

        return view('accesorios-equipo.index', compact('accesoriosEquipos'))
            ->with('i', ($request->input('page', 1) - 1) * $accesoriosEquipos->perPage());
    }

    public function create(): View
    {
        $accesoriosEquipo = new AccesoriosEquipo();
        return view('accesorios-equipo.create', compact('accesoriosEquipo'));
    }

    public function store(AccesoriosEquipoRequest $request): RedirectResponse
    {
        AccesoriosEquipo::create($request->validated());
        return Redirect::route('accesorios-equipo.index')
            ->with('success', 'Accesorio registrado.')->with('toast_tipo', 'exito');
    }

    public function show($id): View
    {
        $accesoriosEquipo = AccesoriosEquipo::with(['equipo.tipoEquipo', 'equipo.ubicacione'])->findOrFail($id);
        return view('accesorios-equipo.show', compact('accesoriosEquipo'));
    }

    public function edit($id): View
    {
        $accesoriosEquipo = AccesoriosEquipo::with(['equipo.tipoEquipo', 'equipo.ubicacione'])->findOrFail($id);
        return view('accesorios-equipo.edit', compact('accesoriosEquipo'));
    }

    public function update(AccesoriosEquipoRequest $request, AccesoriosEquipo $accesoriosEquipo): RedirectResponse
    {
        $accesoriosEquipo->update($request->validated());
        return Redirect::route('accesorios-equipo.index')
            ->with('success', 'Accesorio actualizado.')->with('toast_tipo', 'exito');
    }

    public function destroy($id): RedirectResponse
    {
        AccesoriosEquipo::find($id)->delete();
        return Redirect::route('accesorios-equipo.index')
            ->with('success', 'Accesorio eliminado.')->with('toast_tipo', 'exito');
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