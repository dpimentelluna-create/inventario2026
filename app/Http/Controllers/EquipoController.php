<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\TiposEquipo;
use App\Models\Ubicacione;
use App\Models\EspecificacionesLaptop;
use App\Models\EspecificacionesEquipo;
use App\Models\AccesoriosEquipo;

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
        $equipos = Equipo::with([
            'tipoEquipo',
            'ubicacione',
            'especificacionesLaptops',
            'especificacionesEquipo',
            'accesoriosEquipos'
        ])->get();

        return view('equipo.index', compact('equipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $equipo = new Equipo();

        $tiposequipo = TiposEquipo::pluck('nombre', 'id');
        $ubicacione = Ubicacione::pluck('nombre', 'id');

        // Obtener tipos de accesorios guardados
        $tiposAccesorios = AccesoriosEquipo::whereNotNull('tipo')
            ->where('tipo', '!=', '')
            ->select('tipo')
            ->distinct()
            ->orderBy('tipo')
            ->pluck('tipo');

        return view('equipo.create', compact(
            'equipo',
            'tiposequipo',
            'ubicacione',
            'tiposAccesorios'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EquipoRequest $request): RedirectResponse
    {
        //1. CREAR EL EQUIPO
        $equipo = Equipo::create([
            'tipo_equipo_id' => $request->tipo_equipo_id,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'num_serie' => $request->num_serie,
            'ubicacion_id' => $request->ubicacion_id,
            'fecha_registro' => $request->fecha_registro,
        ]);

        //2. OBTENER EL TIPO DE EQUIPO
        $tipoEquipo = TiposEquipo::find($request->tipo_equipo_id);

        //3. GUARDAR ESPICCIFIACIONES
        // IF IS LAPTOP:
        if ($tipoEquipo && strtoupper($tipoEquipo->nombre) === 'LAPTOP') {
            EspecificacionesLaptop::create([
                'equipo_id' => $equipo->id,
                'procesador' => $request->procesador,
                'ram' => $request->ram,
                'disco_duro' => $request->disco_duro,
                'color' => $request->color_laptop,
                'estado' => $request->estado_laptop ?? 'Regular',
                'observaciones' => $request->observaciones_laptop,
            ]);

            //IF IS OTRO EQUIPO:
        } else {
            EspecificacionesEquipo::create([
                'equipo_id' => $equipo->id,
                'descripcion' => $request->descripcion,
                'color' => $request->color_equipo,
                'estado' => $request->estado_equipo ?? 'Regular',
                'observaciones' => $request->observaciones_equipo,
            ]);
        }

        // 4. GUARDAR ACCESORIOS
        if ($request->has('accesorios')) {

            foreach ($request->accesorios as $accesorio) {

                // Determinar el tipo real
                $tipo = $accesorio['tipo'] ?? null;

                if ($tipo === 'Otro') {
                    $tipo = trim($accesorio['tipo_personalizado'] ?? '');
                }

                // Evitar guardar filas completamente vacías
                if (
                    empty($tipo) &&
                    empty($accesorio['marca']) &&
                    empty($accesorio['num_serie']) &&
                    empty($accesorio['observaciones'])
                ) {
                    continue;
                }

                // Si no hay tipo, no guardar
                if (empty($tipo)) {
                    continue;
                }

                $equipo->accesoriosEquipos()->create([
                    'tipo' => $tipo,
                    'marca' => $accesorio['marca'] ?? null,
                    'num_serie' => $accesorio['num_serie'] ?? null,
                    'estado' => $accesorio['estado'] ?? 'Regular',
                    'observaciones' => $accesorio['observaciones'] ?? null,
                ]);
            }
        }

        //5. FINALIZAR
        return redirect()->route('equipos.index')
            ->with(
                'success',
                'Equipo, especificaciones y accesorios registrados correctamente.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $equipo = Equipo::with([
            'tipoEquipo',
            'ubicacione',
            'especificacionesLaptops',
            'especificacionesEquipo',
            'accesoriosEquipos'
        ])->findOrFail($id);

        return view('equipo.show', compact('equipo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $equipo = Equipo::with([
            'tipoEquipo',
            'ubicacione',
            'especificacionesLaptops',
            'especificacionesEquipo',
            'accesoriosEquipos'
        ])->findOrFail($id);

        $especificacionesLaptop = $equipo->especificacionesLaptops;
        $especificacionesEquipo = $equipo->especificacionesEquipo;

        $tiposequipo = TiposEquipo::pluck('nombre', 'id');

        $ubicacione = Ubicacione::pluck('nombre', 'id');

        // Obtener todos los tipos de accesorios registrados
        $tiposAccesorios = AccesoriosEquipo::whereNotNull('tipo')
            ->where('tipo', '!=', '')
            ->select('tipo')
            ->distinct()
            ->orderBy('tipo')
            ->pluck('tipo');

        return view('equipo.edit', compact(
            'equipo',
            'tiposequipo',
            'ubicacione',
            'especificacionesLaptop',
            'especificacionesEquipo',
            'tiposAccesorios'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EquipoRequest $request, Equipo $equipo): RedirectResponse
    {
        // 1. Actualizar información principal del equipo
        $equipo->update([
            'tipo_equipo_id' => $request->tipo_equipo_id,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'num_serie' => $request->num_serie,
            'ubicacion_id' => $request->ubicacion_id,
            'fecha_registro' => $request->fecha_registro,
        ]);

        // 2. Obtener el tipo de equipo
        $tipoEquipo = TiposEquipo::find($request->tipo_equipo_id);

        // 3. Actualizar especificaciones
        if ($tipoEquipo && strtoupper($tipoEquipo->nombre) === 'LAPTOP') {

            $equipo->especificacionesLaptops()->updateOrCreate(
                ['equipo_id' => $equipo->id],
                [
                    'procesador' => $request->procesador,
                    'ram' => $request->ram,
                    'disco_duro' => $request->disco_duro,
                    'color' => $request->color_laptop,
                    'estado' => $request->estado_laptop ?? 'Regular',
                    'observaciones' => $request->observaciones_laptop,
                ]
            );

            // Si antes tenía especificaciones de equipo genéricas,
            // las eliminamos porque ahora es Laptop.
            $equipo->especificacionesEquipo()->delete();
        } else {
            $equipo->especificacionesEquipo()->updateOrCreate(
                ['equipo_id' => $equipo->id],
                [
                    'descripcion' => $request->descripcion,
                    'color' => $request->color_equipo,
                    'estado' => $request->estado_equipo ?? 'Regular',
                    'observaciones' => $request->observaciones_equipo,
                ]
            );

            // Si antes era Laptop y ahora cambió de tipo,
            // eliminamos sus especificaciones de Laptop.
            $equipo->especificacionesLaptops()->delete();
        }

        // 4. ACTUALIZAR ACCESORIOS

        $accesoriosEnFormulario = $request->input('accesorios', []);
        $idsConservados = [];

        foreach ($accesoriosEnFormulario as $accesorio) {

            // ==========================================
            // DETERMINAR EL TIPO REAL
            // ==========================================

            $tipo = $accesorio['tipo'] ?? null;

            if ($tipo === 'Otro') {
                $tipo = trim($accesorio['tipo_personalizado'] ?? '');
            }

            // ==========================================
            // IGNORAR FILAS VACÍAS
            // ==========================================

            if (
                empty($tipo) &&
                empty($accesorio['marca']) &&
                empty($accesorio['num_serie']) &&
                empty($accesorio['observaciones'])
            ) {
                continue;
            }

            // Si no tiene tipo, no guardar
            if (empty($tipo)) {
                continue;
            }

            // ==========================================
            // ACCESORIO EXISTENTE
            // ==========================================

            if (!empty($accesorio['id'])) {

                $accesorioModelo = $equipo->accesoriosEquipos()
                    ->where('id', $accesorio['id'])
                    ->first();

                if ($accesorioModelo) {

                    $accesorioModelo->update([
                        'tipo' => $tipo,
                        'marca' => $accesorio['marca'] ?? null,
                        'num_serie' => $accesorio['num_serie'] ?? null,
                        'estado' => $accesorio['estado'] ?? 'Regular',
                        'observaciones' => $accesorio['observaciones'] ?? null,
                    ]);

                    // IMPORTANTE:
                    // conservar el ID del accesorio
                    $idsConservados[] = $accesorioModelo->id;
                }
            } else {

                // ==========================================
                // NUEVO ACCESORIO
                // ==========================================

                $nuevoAccesorio = $equipo->accesoriosEquipos()->create([
                    'tipo' => $tipo,
                    'marca' => $accesorio['marca'] ?? null,
                    'num_serie' => $accesorio['num_serie'] ?? null,
                    'estado' => $accesorio['estado'] ?? 'Regular',
                    'observaciones' => $accesorio['observaciones'] ?? null,
                ]);

                $idsConservados[] = $nuevoAccesorio->id;
            }
        }

        // ==========================================
        // ELIMINAR LOS ACCESORIOS QUITADOS
        // ==========================================

        if (!empty($idsConservados)) {

            $equipo->accesoriosEquipos()
                ->whereNotIn('id', $idsConservados)
                ->delete();
        } else {

            // No quedan accesorios
            $equipo->accesoriosEquipos()->delete();
        }

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo actualizado correctamente.');
    }

    /*public function guardarAccesorios(Request $request, Equipo $equipo): RedirectResponse
    {
        if ($request->has('accesorios')) {

            foreach ($request->accesorios as $accesorio) {

                // No guardar filas completamente vacías
                if (
                    empty($accesorio['tipo']) &&
                    empty($accesorio['marca']) &&
                    empty($accesorio['num_serie']) &&
                    empty($accesorio['observaciones'])
                ) {
                    continue;
                }

                $equipo->accesoriosEquipos()->create([
                    'tipo' => $accesorio['tipo'] ?? null,
                    'marca' => $accesorio['marca'] ?? null,
                    'num_serie' => $accesorio['num_serie'] ?? null,
                    'estado' => $accesorio['estado'] ?? 'Regular',
                    'observaciones' => $accesorio['observaciones'] ?? null,
                ]);
            }
        }

        return redirect()->route('equipos.index')
            ->with('success', 'Accesorios registrados correctamente.');
    }*/

    public function destroy(Equipo $equipo): RedirectResponse
    {
        $equipo->delete();

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo eliminado correctamente.');
    }
}
