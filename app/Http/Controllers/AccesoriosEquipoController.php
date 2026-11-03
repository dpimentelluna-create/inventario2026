<?php

namespace App\Http\Controllers;

use App\Models\AccesoriosEquipo;
use App\Models\Equipo;
use App\Models\Ubicacione;
use App\Http\Requests\AccesoriosEquipoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        if ($tipoActual && !$tipos->contains($tipoActual)) {
            $tipos->push($tipoActual);
        }

        return $tipos->values();
    }

    /**
     * Obtener la última marca registrada por combinación
     * tipo_equipo|tipo_accesorio.
     * Los accesorios sin equipo usan la clave "SIN_EQUIPO".
     */
    private function obtenerUltimasMarcasAccesorio(): array
    {
        $registros = AccesoriosEquipo::query()
            ->leftJoin('equipos', 'accesorios_equipo.equipo_id', '=', 'equipos.id')
            ->leftJoin('tipos_equipo', 'equipos.tipo_equipo_id', '=', 'tipos_equipo.id')
            ->whereNotNull('accesorios_equipo.marca')
            ->where('accesorios_equipo.marca', '!=', '')
            ->orderByDesc('accesorios_equipo.id')
            ->select([
                'accesorios_equipo.tipo as tipo_accesorio',
                'accesorios_equipo.marca',
                'tipos_equipo.nombre as tipo_equipo',
            ])
            ->get();

        $marcas = [];

        foreach ($registros as $registro) {
            $tipoEquipo = $registro->tipo_equipo
                ? mb_strtoupper(trim($registro->tipo_equipo), 'UTF-8')
                : 'SIN_EQUIPO';

            $tipoAccesorio = mb_strtoupper(trim($registro->tipo_accesorio), 'UTF-8');

            $clave = $tipoEquipo . '|' . $tipoAccesorio;

            // Al estar ordenado por ID desc, el primero es la marca más reciente
            if (!isset($marcas[$clave])) {
                $marcas[$clave] = mb_strtoupper(trim($registro->marca), 'UTF-8');
            }
        }

        return $marcas;
    }

    public function index()
    {
        $accesoriosEquipos = AccesoriosEquipo::with(['equipo.ubicacione'])
            ->latest()
            ->get();

        $ubicaciones = Ubicacione::orderBy('nombre')->get();

        return view('accesorios-equipo.index', compact('accesoriosEquipos', 'ubicaciones'));
    }

    public function create(): View
    {
        $accesoriosEquipo = new AccesoriosEquipo();
        $tiposAccesorios = $this->obtenerTiposAccesorios();
        $ultimasMarcasAccesorio = $this->obtenerUltimasMarcasAccesorio();

        $tiposEquipoConRegistros = \App\Models\TiposEquipo::query()
        ->whereHas('equipos')
        ->orderBy('nombre')
        ->get(['id', 'nombre']);
        
        return view('accesorios-equipo.create', compact(
            'accesoriosEquipo',
            'tiposAccesorios',
            'ultimasMarcasAccesorio',
            'tiposEquipoConRegistros'
        ));
    }

    public function store(AccesoriosEquipoRequest $request): RedirectResponse
    {
        $datos = $request->validated();
        unset($datos['nuevo_tipo']);

        $accesorio = AccesoriosEquipo::create($datos);

        return Redirect::route('accesorios-equipo.index')
            ->with('success', 'Accesorio registrado.')
            ->with('toast_tipo', 'exito')
            ->with('accesorio_resaltado', $accesorio->id)
            ->with('accesorio_accion', 'crear');
    }

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

    public function edit($id): View
    {
        $accesoriosEquipo = AccesoriosEquipo::with([
            'equipo.tipoEquipo',
            'equipo.ubicacione'
        ])->findOrFail($id);

        $tiposAccesorios = $this->obtenerTiposAccesorios($accesoriosEquipo->tipo);
        $ultimasMarcasAccesorio = $this->obtenerUltimasMarcasAccesorio();

        $tiposEquipoConRegistros = \App\Models\TiposEquipo::query()
        ->whereHas('equipos')
        ->orderBy('nombre')
        ->get(['id', 'nombre']);

        return view('accesorios-equipo.edit', compact(
            'accesoriosEquipo',
            'tiposAccesorios',
            'ultimasMarcasAccesorio',
            'tiposEquipoConRegistros'
        ));
    }

    public function update(AccesoriosEquipoRequest $request, AccesoriosEquipo $accesoriosEquipo): RedirectResponse
    {
        $datos = $request->validated();
        unset($datos['nuevo_tipo']);

        $accesoriosEquipo->update($datos);

        return Redirect::route('accesorios-equipo.index')
            ->with('success', 'Accesorio actualizado.')
            ->with('toast_tipo', 'exito')
            ->with('accesorio_resaltado', $accesoriosEquipo->id)
            ->with('accesorio_accion', 'editar');
    }

    public function destroy($id): RedirectResponse
    {
        $accesorio = AccesoriosEquipo::findOrFail($id);
        $accesorio->delete();

        return Redirect::route('accesorios-equipo.index')
            ->with('success', 'Accesorio eliminado.')
            ->with('toast_tipo', 'exito');
    }

    /**
     * Buscar equipos por serie, marca, modelo o tipo.
     */
    public function buscarEquipos(Request $request)
    {
        $buscar = mb_strtoupper(trim($request->get('buscar', '')), 'UTF-8');
        $tipoEquipoId = $request->get('tipo_equipo_id');

        if (mb_strlen($buscar) < 2 && !$tipoEquipoId) {
            return response()->json([]);
        }

        $coincidencia = '%' . $buscar . '%';

        $query = Equipo::query()
            ->with('tipoEquipo:id,nombre')
            ->when($tipoEquipoId, fn($q) => $q->where('tipo_equipo_id', $tipoEquipoId))
            ->when($buscar, function ($q) use ($coincidencia) {
                $q->where(function ($sub) use ($coincidencia) {
                    $sub->where('num_serie', 'LIKE', $coincidencia)
                        ->orWhere('marca', 'LIKE', $coincidencia)
                        ->orWhere('modelo', 'LIKE', $coincidencia)
                        ->orWhereHas('tipoEquipo', fn($t) => $t->where('nombre', 'LIKE', $coincidencia));
                });
            });

        $equipos = $query
            ->orderBy('num_serie')
            ->limit(15)
            ->get(['id', 'tipo_equipo_id', 'num_serie', 'marca', 'modelo'])
            ->map(function ($equipo) {
                return [
                    'id'          => $equipo->id,
                    'num_serie'   => $equipo->num_serie,
                    'marca'       => $equipo->marca,
                    'modelo'      => $equipo->modelo,
                    'tipo_equipo' => $equipo->tipoEquipo->nombre ?? '',
                ];
            });

        return response()->json($equipos);
    }
}