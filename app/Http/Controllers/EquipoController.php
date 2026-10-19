<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\TiposEquipo;
use App\Models\Ubicacione;
use App\Models\EspecificacionesLaptop;
use App\Models\EspecificacionesEquipo;
use App\Models\AccesoriosEquipo;
use App\Models\Auditoria;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\EquipoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $equipos = Equipo::with([
            'tipoEquipo',
            'ubicacione',
            'especificacionesLaptops',
            'especificacionesEquipo',
        ])->get();

        $filtroTipos = TiposEquipo::orderBy('nombre')->pluck('nombre');
        $filtroMarcas = Equipo::whereNotNull('marca')->where('marca', '!=', '')
            ->distinct()->orderBy('marca')->pluck('marca');
        $filtroModelos = Equipo::whereNotNull('modelo')->where('modelo', '!=', '')
            ->distinct()->orderBy('modelo')->pluck('modelo');
        $filtroUbicaciones = Ubicacione::orderBy('nombre')->pluck('nombre');

        return view('equipo.index', compact(
            'equipos',
            'filtroTipos',
            'filtroMarcas',
            'filtroModelos',
            'filtroUbicaciones'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $equipo = new Equipo();

        $tiposequipo = TiposEquipo::pluck('nombre', 'id');
        $ubicacione = Ubicacione::orderBy('nombre')->pluck('nombre', 'id');

        // Obtener tipos de accesorios guardados
        $tiposAccesorios = AccesoriosEquipo::whereNotNull('tipo')
            ->where('tipo', '!=', '')
            ->select('tipo')
            ->distinct()
            ->orderBy('tipo')
            ->pluck('tipo');


        $ultimasMarcasAccesorio = [];


        $ultimosPorTipo = [];

        $equiposTipo = Equipo::with(['tipoEquipo', 'especificacionesLaptops', 'especificacionesEquipo'])
            ->orderByDesc('id')
            ->get();

        foreach ($equiposTipo as $eq) {
            $nombre = mb_strtoupper(trim($eq->tipoEquipo->nombre ?? ''), 'UTF-8');
            if ($nombre === '' || isset($ultimosPorTipo[$nombre])) {
                continue;
            }

            $lap = $eq->especificacionesLaptops;
            $gen = $eq->especificacionesEquipo;

            $ultimosPorTipo[$nombre] = [
                'marca' => $eq->marca,
                'modelo' => $eq->modelo,
                'procesador' => $lap->procesador ?? null,
                'ram' => $lap->ram ?? null,
                'disco_duro' => $lap->disco_duro ?? null,
                'color' => $lap->color ?? $gen->color ?? null,
                'descripcion' => $gen->descripcion ?? null,
            ];
        }


        $filasMarca = \App\Models\AccesoriosEquipo::query()
            ->join('equipos', 'equipos.id', '=', 'accesorios_equipo.equipo_id')
            ->join('tipos_equipo', 'tipos_equipo.id', '=', 'equipos.tipo_equipo_id')
            ->whereNotNull('accesorios_equipo.tipo')
            ->where('accesorios_equipo.tipo', '!=', '')
            ->whereNotNull('accesorios_equipo.marca')
            ->where('accesorios_equipo.marca', '!=', '')
            ->orderByDesc('accesorios_equipo.id')
            ->get([
                'tipos_equipo.nombre as tipo_equipo',
                'accesorios_equipo.tipo as tipo_accesorio',
                'accesorios_equipo.marca as marca',
            ]);

        foreach ($filasMarca as $fila) {
            $clave = mb_strtoupper(trim($fila->tipo_equipo), 'UTF-8')
                . '|'
                . mb_strtoupper(trim($fila->tipo_accesorio), 'UTF-8');

            if (!isset($ultimasMarcasAccesorio[$clave])) {
                $ultimasMarcasAccesorio[$clave] = mb_strtoupper(trim($fila->marca), 'UTF-8');
            }
        }


        return view('equipo.create', compact(
            'equipo',
            'tiposequipo',
            'ubicacione',
            'tiposAccesorios',
            'ultimasMarcasAccesorio',
            'ultimosPorTipo'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EquipoRequest $request): RedirectResponse
    {
        $tipoEquipoId = $request->tipo_equipo_id;

        if ($request->filled('nuevo_tipo_equipo')) {
            $tipo = \App\Models\TiposEquipo::firstOrCreate([
                'nombre' => mb_strtoupper(trim($request->nuevo_tipo_equipo), 'UTF-8'),
            ]);
            $tipoEquipoId = $tipo->id;
        }

        //1. CREAR EL EQUIPO
        $equipo = Equipo::create([
            'tipo_equipo_id' => $tipoEquipoId,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'num_serie' => $request->num_serie,
            'ubicacion_id' => $request->ubicacion_id,
            'fecha_registro' => $request->fecha_registro,
        ]);


        //2. OBTENER EL TIPO DE EQUIPO
        $tipoEquipo = TiposEquipo::find($tipoEquipoId);

        //3. GUARDAR ESPICCIFIACIONES
        // IF IS LAPTOP:
        if ($tipoEquipo && strtoupper($tipoEquipo->nombre) === 'LAPTOP') {
            EspecificacionesLaptop::create([
                'equipo_id' => $equipo->id,
                'procesador' => $request->procesador,
                'ram' => $request->ram,
                'disco_duro' => $request->disco_duro,
                'color' => $request->color_laptop,
                'estado' => $request->estado_laptop ?? 'REGULAR',
                'observaciones' => $request->observaciones_laptop,
            ]);

            //IF IS OTRO EQUIPO:
        } else {
            EspecificacionesEquipo::create([
                'equipo_id' => $equipo->id,
                'descripcion' => $request->descripcion,
                'color' => $request->color_equipo,
                'estado' => $request->estado_equipo ?? 'REGULAR',
                'observaciones' => $request->observaciones_equipo,
            ]);
        }

        // 4. GUARDAR ACCESORIOS
        if ($request->has('accesorios')) {

            foreach ($request->accesorios as $accesorio) {

                // Determinar el tipo real
                $tipo = $accesorio['tipo'] ?? null;

                if ($tipo === 'OTRO') {
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
                    'estado' => $accesorio['estado'] ?? 'REGULAR',
                    'observaciones' => $accesorio['observaciones'] ?? null,
                ]);
            }
        }

        // 5. REGISTRAR AUDITORÍA
        Auditoria::registrar(
            'CREAR',
            'EQUIPOS',
            'Registró el equipo '
            . ($equipo->num_serie ?: 'ID ' . $equipo->id)
            . ' - ' . $equipo->marca
            . ' ' . ($equipo->modelo ?? '')
            . '.',
            $equipo,
            [
                'tipo_equipo_id' => $equipo->tipo_equipo_id,
                'marca' => $equipo->marca,
                'modelo' => $equipo->modelo,
                'num_serie' => $equipo->num_serie,
                'ubicacion_id' => $equipo->ubicacion_id,
                'fecha_registro' => $equipo->fecha_registro,
            ]
        );

        //5. FINALIZAR
        return redirect()->route('equipos.index')
            ->with('success', 'Equipo registrado.')
            ->with('toast_tipo', 'exito')
            ->with('equipo_resaltado', $equipo->id)
            ->with('equipo_accion', 'crear');
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

        $ubicacione = Ubicacione::orderBy('nombre')->pluck('nombre', 'id');

        // Obtener todos los tipos de accesorios registrados
        $tiposAccesorios = AccesoriosEquipo::whereNotNull('tipo')
            ->where('tipo', '!=', '')
            ->select('tipo')
            ->distinct()
            ->orderBy('tipo')
            ->pluck('tipo');

        $ultimasMarcasAccesorio = [];


        $ultimosPorTipo = [];

        $equiposTipo = Equipo::with(['tipoEquipo', 'especificacionesLaptops', 'especificacionesEquipo'])
            ->orderByDesc('id')
            ->get();

        foreach ($equiposTipo as $eq) {
            $nombre = mb_strtoupper(trim($eq->tipoEquipo->nombre ?? ''), 'UTF-8');
            if ($nombre === '' || isset($ultimosPorTipo[$nombre])) {
                continue;
            }

            $lap = $eq->especificacionesLaptops;
            $gen = $eq->especificacionesEquipo;

            $ultimosPorTipo[$nombre] = [
                'marca' => $eq->marca,
                'modelo' => $eq->modelo,
                'procesador' => $lap->procesador ?? null,
                'ram' => $lap->ram ?? null,
                'disco_duro' => $lap->disco_duro ?? null,
                'color' => $lap->color ?? $gen->color ?? null,
                'descripcion' => $gen->descripcion ?? null,
            ];
        }


        $filasMarca = \App\Models\AccesoriosEquipo::query()
            ->join('equipos', 'equipos.id', '=', 'accesorios_equipo.equipo_id')
            ->join('tipos_equipo', 'tipos_equipo.id', '=', 'equipos.tipo_equipo_id')
            ->whereNotNull('accesorios_equipo.tipo')
            ->where('accesorios_equipo.tipo', '!=', '')
            ->whereNotNull('accesorios_equipo.marca')
            ->where('accesorios_equipo.marca', '!=', '')
            ->orderByDesc('accesorios_equipo.id')
            ->get([
                'tipos_equipo.nombre as tipo_equipo',
                'accesorios_equipo.tipo as tipo_accesorio',
                'accesorios_equipo.marca as marca',
            ]);

        foreach ($filasMarca as $fila) {
            $clave = mb_strtoupper(trim($fila->tipo_equipo), 'UTF-8')
                . '|'
                . mb_strtoupper(trim($fila->tipo_accesorio), 'UTF-8');

            if (!isset($ultimasMarcasAccesorio[$clave])) {
                $ultimasMarcasAccesorio[$clave] = mb_strtoupper(trim($fila->marca), 'UTF-8');
            }
        }

        return view('equipo.edit', compact(
            'equipo',
            'tiposequipo',
            'ubicacione',
            'especificacionesLaptop',
            'especificacionesEquipo',
            'tiposAccesorios',
            'ultimasMarcasAccesorio',
            'ultimosPorTipo'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EquipoRequest $request, Equipo $equipo): RedirectResponse
    {
        // Guardar los datos anteriores para la auditoría
        $datosAnteriores = [
            'tipo_equipo_id' => $equipo->tipo_equipo_id,
            'marca' => $equipo->marca,
            'modelo' => $equipo->modelo,
            'num_serie' => $equipo->num_serie,
            'ubicacion_id' => $equipo->ubicacion_id,
            'fecha_registro' => $equipo->fecha_registro,
        ];

        $tipoEquipoId = $request->tipo_equipo_id;

        if ($request->filled('nuevo_tipo_equipo')) {
            $tipo = \App\Models\TiposEquipo::firstOrCreate([
                'nombre' => mb_strtoupper(trim($request->nuevo_tipo_equipo), 'UTF-8'),
            ]);
            $tipoEquipoId = $tipo->id;
        }

        // 1. Actualizar información principal del equipo
        $equipo->update([
            'tipo_equipo_id' => $tipoEquipoId,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'num_serie' => $request->num_serie,
            'ubicacion_id' => $request->ubicacion_id,
            'fecha_registro' => $request->fecha_registro,
        ]);

        // 2. Obtener el tipo de equipo
        $tipoEquipo = TiposEquipo::find($tipoEquipoId);

        // 3. Actualizar especificaciones
        if ($tipoEquipo && strtoupper($tipoEquipo->nombre) === 'LAPTOP') {

            $equipo->especificacionesLaptops()->updateOrCreate(
                ['equipo_id' => $equipo->id],
                [
                    'procesador' => $request->procesador,
                    'ram' => $request->ram,
                    'disco_duro' => $request->disco_duro,
                    'color' => $request->color_laptop,
                    'estado' => $request->estado_laptop ?? 'REGULAR',
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
                    'estado' => $request->estado_equipo ?? 'REGULAR',
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

            if (strtoupper(trim((string) $tipo)) === 'OTRO') {
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
                        'estado' => $accesorio['estado'] ?? 'REGULAR',
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

        // Registrar auditoría de actualización

        // Registrar auditoría de actualización
        $equipo->refresh();

        $datosNuevos = [
            'tipo_equipo_id' => $equipo->tipo_equipo_id,
            'marca' => $equipo->marca,
            'modelo' => $equipo->modelo,
            'num_serie' => $equipo->num_serie,
            'ubicacion_id' => $equipo->ubicacion_id,
            'fecha_registro' => $equipo->fecha_registro,
        ];

        // Comparar los valores anteriores con los nuevos
        $cambios = [];

        foreach ($datosAnteriores as $campo => $valorAnterior) {
            $valorNuevo = $datosNuevos[$campo] ?? null;

            if ((string) ($valorAnterior ?? '') !== (string) ($valorNuevo ?? '')) {
                $cambios[$campo] = [
                    'anterior' => $valorAnterior,
                    'nuevo' => $valorNuevo,
                ];
            }
        }

        // Registrar solamente si hubo cambios en los datos principales
        if (!empty($cambios)) {
            Auditoria::registrar(
                'ACTUALIZAR',
                'EQUIPOS',
                'Actualizó el equipo '
                . ($equipo->num_serie ?: 'ID ' . $equipo->id)
                . ' - ' . $equipo->marca
                . ' ' . ($equipo->modelo ?? '')
                . '.',
                $equipo,
                $cambios
            );
        }


        return redirect()->route('equipos.index')
            ->with('success', 'Equipo actualizado.')
            ->with('toast_tipo', 'aviso')
            ->with('equipo_resaltado', $equipo->id)
            ->with('equipo_accion', 'editar');
    }


    public function destroy(Equipo $equipo): RedirectResponse
    {
        // Guardar la información del equipo antes de eliminarlo
        $idEquipo = $equipo->id;

        $descripcion = 'Eliminó el equipo '
            . ($equipo->num_serie ?: 'ID ' . $equipo->id)
            . ' - ' . $equipo->marca
            . ' ' . ($equipo->modelo ?? '')
            . '.';

        $datosEliminados = [
            'id' => $equipo->id,
            'tipo_equipo_id' => $equipo->tipo_equipo_id,
            'marca' => $equipo->marca,
            'modelo' => $equipo->modelo,
            'num_serie' => $equipo->num_serie,
            'ubicacion_id' => $equipo->ubicacion_id,
            'fecha_registro' => $equipo->fecha_registro,
        ];

        // Registrar la auditoría antes de eliminar el equipo
        // para conservar correctamente la referencia al registro.
        Auditoria::registrar(
            'ELIMINAR',
            'EQUIPOS',
            $descripcion,
            $equipo,
            [
                'eliminado' => $datosEliminados,
            ]
        );

        // Eliminar el equipo después de guardar la auditoría
        $equipo->delete();

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo eliminado.')
            ->with('toast_tipo', 'error')
            ->with('equipo_resaltado', $idEquipo)
            ->with('equipo_accion', 'eliminar');
    }


    public function verificarSerie(Request $request)
    {
        $serie = mb_strtoupper(trim((string) $request->query('num_serie', '')), 'UTF-8');
        $ignorar = $request->query('equipo_id');

        $existe = $serie !== '' && \App\Models\Equipo::query()
            ->where('num_serie', $serie)
            ->when($ignorar, fn($q) => $q->where('id', '!=', $ignorar))
            ->exists();

        return response()->json(['existe' => $existe]);
    }

    public function verificarSerieAccesorio(Request $request)
    {
        $serie = mb_strtoupper(trim((string) $request->query('num_serie', '')), 'UTF-8');
        $ignorar = $request->query('accesorio_id');

        $existe = $serie !== '' && \App\Models\AccesoriosEquipo::query()
            ->where('num_serie', $serie)
            ->when($ignorar, fn($q) => $q->where('id', '!=', $ignorar))
            ->exists();

        return response()->json(['existe' => $existe]);
    }

    public function exportPdf(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'message' => 'NO HAY EQUIPOS PARA EXPORTAR.'
            ], 422);
        }

        $equiposEncontrados = Equipo::with([
            'tipoEquipo',
            'ubicacione',
            'especificacionesLaptops',
            'especificacionesEquipo',
            'accesoriosEquipos',
        ])
            ->whereIn('id', $ids)
            ->get()
            ->keyBy('id');

        // Mantener exactamente el orden enviado desde DataTables
        $equipos = collect($ids)
            ->map(fn($id) => $equiposEncontrados->get($id))
            ->filter()
            ->values();

        $pdf = Pdf::loadView('equipo.export-pdf', compact('equipos'))
            ->setPaper('a4', 'landscape');

        $nombreArchivo = 'Equipos_' . now()->format('d-m-Y_g-ia') . '.pdf';

        // Registrar auditoría de exportación PDF
        Auditoria::registrar(
            'EXPORTAR_PDF',
            'EQUIPOS',
            'Exportó ' . $equipos->count()
            . ' equipo(s) a PDF.',
            null,

            [
                'formato' => 'PDF',
                'cantidad' => $equipos->count(),
                'archivo' => $nombreArchivo,
                'equipos' => $equipos->map(fn($equipo) => [
                    'id' => $equipo->id,
                    'num_serie' => $equipo->num_serie,
                    'marca' => $equipo->marca,
                    'modelo' => $equipo->modelo,
                ])->values()->all(),
            ]

        );

        return $pdf->download($nombreArchivo);
    }

    public function exportExcel(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'message' => 'NO HAY EQUIPOS PARA EXPORTAR.'
            ], 422);
        }

        $equiposEncontrados = Equipo::with([
            'tipoEquipo',
            'ubicacione',
            'especificacionesLaptops',
            'especificacionesEquipo',
            'accesoriosEquipos',
        ])
            ->whereIn('id', $ids)
            ->get()
            ->keyBy('id');

        $equipos = collect($ids)
            ->map(fn($id) => $equiposEncontrados->get($id))
            ->filter()
            ->values();

        $nombreArchivo = 'Equipos_' . now()->format('d-m-Y_g-ia') . '.xlsx';

        // Registrar auditoría de exportación Excel
        Auditoria::registrar(
            'EXPORTAR_EXCEL',
            'EQUIPOS',
            'Exportó ' . $equipos->count()
            . ' equipo(s) a Excel.',
            null,
            [
                'formato' => 'EXCEL',
                'cantidad' => $equipos->count(),
                'ids_equipos' => $equipos->pluck('id')->values()->all(),
                'archivo' => $nombreArchivo,
            ]
        );

        return Excel::download(
            new \App\Exports\EquiposExport($equipos),
            $nombreArchivo
        );
    }

    
public function auditarImpresion(Equipo $equipo)
{
    Auditoria::registrar(
        'IMPRIMIR_FICHA',
        'EQUIPOS',
        'Solicitó imprimir la ficha del equipo '
            . ($equipo->num_serie ?: 'ID ' . $equipo->id)
            . ' - ' . $equipo->marca
            . ' ' . ($equipo->modelo ?? '')
            . '.',
        $equipo,
        [
            'equipo_id' => $equipo->id,
            'marca' => $equipo->marca,
            'modelo' => $equipo->modelo,
            'num_serie' => $equipo->num_serie,
        ]
    );

    return response()->json([
        'message' => 'Solicitud de impresión registrada correctamente.',
    ]);
}

}