<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\PrestamoEquipo;
use App\Models\PrestamoAccesorio;
use App\Models\Equipo;
use App\Models\TiposEquipo;
use App\Models\Docente;
use App\Models\Auditoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PrestamoRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Exports\PrestamosExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;


class PrestamoController extends Controller
{
    /**
     * Mostrar todos los préstamos
     */
    public function index(Request $request): View
    {
        $prestamos = Prestamo::with([
            'docente',
            'prestamoEquipos.equipo.tipoEquipo',
            'prestamoEquipos.prestamoAccesorios.accesorioEquipo',
        ])->latest('fecha')->get();

        $filtroSolicitantes = Docente::orderBy('apellidos')
            ->orderBy('nombres')
            ->get()
            ->map(function ($d) {
                return mb_strtoupper(trim($d->apellidos . ' ' . $d->nombres), 'UTF-8');
            })
            ->filter()
            ->unique()
            ->values();

        $filtroCargos = Prestamo::whereNotNull('cargo')
            ->where('cargo', '!=', '')
            ->distinct()
            ->orderBy('cargo')
            ->pluck('cargo');

        return view('prestamo.index', compact(
            'prestamos',
            'filtroSolicitantes',
            'filtroCargos'
        ));
    }


    /**
     * Mostrar formulario para crear préstamo
     */
    public function create(): View
{
    $prestamo = new Prestamo();

    $tiposEquipo = TiposEquipo::whereHas('equipos', function ($query) {
        $query->whereDoesntHave('prestamoEquipos', function ($detalle) {
            $detalle->whereHas('prestamo', function ($prestamoQuery) {
                $prestamoQuery->where('estado', 'ACTIVO');
            });
        });
    })
    ->orderBy('nombre')
    ->get();

    $docentes = Docente::orderBy('apellidos')
        ->orderBy('nombres')
        ->get();

    return view('prestamo.create', compact(
        'prestamo',
        'tiposEquipo',
        'docentes'
    ));
}

    /**
     * Bloquear los equipos en un orden estable y rechazar los que ya tengan
     * un préstamo ACTIVO. El bloqueo de las filas de equipos serializa las
     * altas/ediciones concurrentes que utilizan esta misma regla.
     */
    private function bloquearYValidarDisponibilidad(
        array $equipoIds,
        ?int $prestamoId = null,
        ?array $idsParaValidar = null
    ): void {
        $ids = collect($equipoIds)
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->sort()
            ->values();

        $idsValidar = collect($idsParaValidar ?? $equipoIds)
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->sort()
            ->values();

        if ($ids->isEmpty() || $idsValidar->isEmpty()) {
            throw ValidationException::withMessages([
                'equipos' => 'Debe seleccionar al menos un equipo.',
            ]);
        }

        // Todos los procesos de préstamo deben bloquear primero estas filas.
        $equipos = Equipo::query()
            ->whereIn('id', $ids)
            ->orderBy('id')
            ->lockForUpdate()
            ->get([
                'id',
                'marca',
                'modelo',
                'num_serie',
                'situacion_administrativa',
            ]);

        if ($equipos->count() !== $ids->count()) {
            throw ValidationException::withMessages([
                'equipos' => 'Uno o más equipos seleccionados ya no existen. Actualice el formulario e inténtelo nuevamente.',
            ]);
        }

        // No permitir prestar equipos dados de baja administrativamente.
        $equiposDeBaja = $equipos
            ->whereIn('id', $idsValidar)
            ->where('situacion_administrativa', 'DE_BAJA');

        if ($equiposDeBaja->isNotEmpty()) {
            $nombres = $equiposDeBaja
                ->map(function ($equipo) {
                    $identificador = $equipo->num_serie
                        ?: trim(($equipo->marca ?? '') . ' ' . ($equipo->modelo ?? ''));

                    return 'ID ' . $equipo->id
                        . ($identificador !== '' ? ' (' . $identificador . ')' : '');
                })
                ->implode(', ');

            throw ValidationException::withMessages([
                'equipos' => 'No se puede guardar el préstamo. Estos equipos están dados de baja administrativamente: '
                    . $nombres
                    . '.',
            ]);
        }

        $consultaOcupados = PrestamoEquipo::query()
            ->whereIn('equipo_id', $idsValidar)
            ->whereHas('prestamo', function ($query) use ($prestamoId) {
                $query->where('estado', 'ACTIVO');

                if ($prestamoId !== null) {
                    $query->where('id', '<>', $prestamoId);
                }
            });

        $idsOcupados = $consultaOcupados
            ->pluck('equipo_id')
            ->unique();

        if ($idsOcupados->isNotEmpty()) {
            $nombres = $equipos
                ->whereIn('id', $idsOcupados)
                ->map(function ($equipo) {
                    $identificador = $equipo->num_serie
                        ?: trim(($equipo->marca ?? '') . ' ' . ($equipo->modelo ?? ''));

                    return 'ID ' . $equipo->id . ($identificador !== '' ? ' (' . $identificador . ')' : '');
                })
                ->implode(', ');

            throw ValidationException::withMessages([
                'equipos' => 'No se puede guardar el préstamo. Estos equipos ya tienen un préstamo activo: ' . $nombres . '.',
            ]);
        }
    }

    /**
     * Guardar préstamo
     */
    public function store(PrestamoRequest $request): RedirectResponse
    {
        $prestamo = DB::transaction(function () use ($request) {

            $this->bloquearYValidarDisponibilidad(
                collect($request->input('equipos', []))
                    ->pluck('equipo_id')
                    ->all()
            );

            $estadoPrestamo = $request->filled('hora_fin')
                ? 'TERMINADO'
                : 'ACTIVO';

            $prestamo = Prestamo::create([
                'docente_id' => $request->docente_id,
                'cargo' => $request->cargo,
                'fecha' => $request->fecha,
                'hora_inicio' => $request->hora_inicio,
                'hora_fin' => $request->hora_fin,
                'estado' => $estadoPrestamo,
            ]);

            foreach ($request->equipos as $equipoData) {

                $equipo = Equipo::with([
                    'especificacionesLaptops',
                    'especificacionesEquipo',
                    'accesoriosEquipos',
                ])->findOrFail($equipoData['equipo_id']);

                $estadoActual = 'BUENO';

                if ($equipo->especificacionesLaptops) {
                    $estadoActual =
                        $equipo->especificacionesLaptops->estado;
                } elseif ($equipo->especificacionesEquipo) {
                    $estadoActual =
                        $equipo->especificacionesEquipo->estado;
                }

                $prestamoEquipo = PrestamoEquipo::create([
                    'prestamo_id' => $prestamo->id,
                    'equipo_id' => $equipo->id,
                    'estado' => $estadoActual,
                    'observacion' => $equipoData['observacion'] ?? null,
                ]);

                if ($estadoPrestamo === 'TERMINADO') {

                    if ($equipo->especificacionesLaptops) {
                        $equipo->especificacionesLaptops->update([
                            'estado' => $equipoData['estado'],
                        ]);
                    } elseif ($equipo->especificacionesEquipo) {
                        $equipo->especificacionesEquipo->update([
                            'estado' => $equipoData['estado'],
                        ]);
                    }

                    $prestamoEquipo->update([
                        'estado' => $equipoData['estado'],
                    ]);
                }

                if (!empty($equipoData['accesorios'])) {

                    foreach ($equipoData['accesorios'] as $accesorioData) {

                        $prestamoAccesorio = PrestamoAccesorio::create([
                            'prestamo_equipo_id' => $prestamoEquipo->id,
                            'accesorio_equipo_id' =>
                            $accesorioData['accesorio_equipo_id'],
                            'estado' => $accesorioData['estado'],
                            'observacion' =>
                            $accesorioData['observacion'] ?? null,
                        ]);

                        if ($estadoPrestamo === 'TERMINADO') {

                            $accesorio = $prestamoAccesorio->accesorioEquipo;

                            if ($accesorio) {
                                $accesorio->update([
                                    'estado' => $accesorioData['estado'],
                                ]);
                            }
                        }
                    }
                }
            }

            // Cargar los datos definitivos para la auditoría.
            $prestamo->load([
                'docente',
                'prestamoEquipos.equipo.tipoEquipo',
                'prestamoEquipos.prestamoAccesorios.accesorioEquipo',
            ]);

            Auditoria::registrar(
                'CREAR',
                'PRESTAMOS',
                "Se registró el préstamo #{$prestamo->id}.",
                $prestamo,
                [
                    'nuevo' => $this->datosAuditoriaPrestamo($prestamo),
                ]
            );

            return $prestamo;
        });

        return Redirect::route('prestamos.index')
            ->with('success', 'Préstamo registrado.')
            ->with('toast_tipo', 'exito')
            ->with('prestamo_resaltado', $prestamo->id)
            ->with('prestamo_accion', 'crear');
    }

    /**
     * Mostrar préstamo
     */
    public function show($id): View
    {
        $prestamo = Prestamo::with([
            'docente',
            'prestamoEquipos.equipo.tipoEquipo',
            'prestamoEquipos.prestamoAccesorios.accesorioEquipo'
        ])->findOrFail($id);

        return view('prestamo.show', compact('prestamo'));
    }


    /**
     * Obtener una copia de los datos del préstamo para auditoría.
     */
    private function datosAuditoriaPrestamo(Prestamo $prestamo): array
    {
        $prestamo->loadMissing([
            'docente',
            'prestamoEquipos.equipo.tipoEquipo',
            'prestamoEquipos.prestamoAccesorios.accesorioEquipo',
        ]);

        return [
            'id' => $prestamo->id,

            'solicitante' => trim(
                ($prestamo->docente?->apellidos ?? '') . ' ' .
                    ($prestamo->docente?->nombres ?? '')
            ),

            'cargo' => $prestamo->cargo,
            'fecha' => $prestamo->fecha,
            'hora_inicio' => $prestamo->hora_inicio,
            'hora_fin' => $prestamo->hora_fin,
            'estado' => $prestamo->estado,

            'equipos' => $prestamo->prestamoEquipos->map(
                function ($prestamoEquipo) {

                    $equipo = $prestamoEquipo->equipo;

                    return [
                        'id' => $equipo?->id,
                        'tipo' => $equipo?->tipoEquipo?->nombre,
                        'codigo_inventario' => $equipo?->codigo_inventario,
                        'marca' => $equipo?->marca,
                        'modelo' => $equipo?->modelo,
                        'num_serie' => $equipo?->num_serie,

                        // Estado registrado en el préstamo.
                        'estado' => $prestamoEquipo->estado,
                        'observacion' => $prestamoEquipo->observacion,

                        'accesorios' => $prestamoEquipo
                            ->prestamoAccesorios
                            ->map(function ($prestamoAccesorio) {

                                $accesorio =
                                    $prestamoAccesorio->accesorioEquipo;

                                return [
                                    'id' => $accesorio?->id,
                                    'tipo' => $accesorio?->tipo,
                                    'marca' => $accesorio?->marca,
                                    'num_serie' => $accesorio?->num_serie,
                                    'estado' => $prestamoAccesorio->estado,
                                    'observacion' =>
                                    $prestamoAccesorio->observacion,
                                ];
                            })
                            ->values()
                            ->all(),
                    ];
                }
            )->values()->all(),
        ];
    }

    public function actaPdf($id)
    {
        $prestamo = $this->prestamoParaActa($id);

        $nombreArchivo = 'Acta_Prestamo_' . $prestamo->id . '.pdf';

        $pdf = Pdf::loadView(
            'prestamo.acta-pdf',
            compact('prestamo')
        )->setPaper('a4', 'portrait');

        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('chroot', public_path());

        Auditoria::registrar(
            'EXPORTAR_PDF',
            'PRESTAMOS',
            'Solicitó exportar el acta PDF del préstamo #' . $prestamo->id . '.',
            $prestamo,
            [
                'formato' => 'PDF',
                'archivo' => $nombreArchivo,
                'prestamo' => $this->datosAuditoriaPrestamo($prestamo),
            ]
        );

        return $pdf->download($nombreArchivo);
    }



    public function actaExcel($id)
    {
        $prestamo = $this->prestamoParaActa($id);

        $nombreArchivo = 'Acta_Prestamo_' . $prestamo->id . '.xlsx';

        $respuesta = Excel::download(
            new \App\Exports\ActaPrestamoExport($prestamo),
            $nombreArchivo
        );

        Auditoria::registrar(
            'EXPORTAR_EXCEL',
            'PRESTAMOS',
            'Solicitó exportar el acta Excel del préstamo #' . $prestamo->id . '.',
            $prestamo,
            [
                'formato' => 'EXCEL',
                'archivo' => $nombreArchivo,
                'prestamo' => $this->datosAuditoriaPrestamo($prestamo),
            ]
        );

        return $respuesta;
    }

    private function prestamoParaActa($id)
    {
        return \App\Models\Prestamo::with([
            'docente',
            'prestamoEquipos.equipo.tipoEquipo',
            'prestamoEquipos.equipo.especificacionesLaptops',
            'prestamoEquipos.equipo.especificacionesEquipo',
            'prestamoEquipos.prestamoAccesorios.accesorioEquipo',
        ])->findOrFail($id);
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id): View
{
    $prestamo = Prestamo::with([
        'docente',
        'prestamoEquipos.equipo.tipoEquipo',
        'prestamoEquipos.equipo.accesoriosEquipos',
        'prestamoEquipos.prestamoAccesorios.accesorioEquipo'
    ])->findOrFail($id);

    $tiposEquipo = TiposEquipo::whereHas('equipos', function ($query) use ($prestamo) {
        $query->whereDoesntHave('prestamoEquipos', function ($detalle) use ($prestamo) {
            $detalle->whereHas('prestamo', function ($prestamoQuery) use ($prestamo) {
                $prestamoQuery->where('estado', 'ACTIVO')
                    ->where('id', '!=', $prestamo->id);
            });
        });
    })
    ->orderBy('nombre')
    ->get();

    $docentes = Docente::orderBy('apellidos')
        ->orderBy('nombres')
        ->get();

    return view('prestamo.edit', compact(
        'prestamo',
        'tiposEquipo',
        'docentes'
    ));
}

    /**
     * Actualizar préstamo
     */
    public function update(
        PrestamoRequest $request,
        Prestamo $prestamo
    ): RedirectResponse {

        DB::transaction(function () use ($request, $prestamo) {

            // Bloquear el préstamo para evitar que dos ediciones simultáneas
            // reemplacen sus detalles al mismo tiempo.
            $prestamo = Prestamo::query()
                ->whereKey($prestamo->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Bloquear tanto los equipos actuales como los nuevos, incluso
            // los que se retirarán de este préstamo durante la edición.
            $equiposActuales = $prestamo->prestamoEquipos()->pluck('equipo_id')->all();
            $equiposSolicitados = collect($request->input('equipos', []))
                ->pluck('equipo_id')
                ->all();

            $this->bloquearYValidarDisponibilidad(
                array_merge($equiposActuales, $equiposSolicitados),
                $prestamo->id,
                $equiposSolicitados
            );

            // 1. Guardar la información anterior antes de modificar.
            $prestamo->load([
                'docente',
                'prestamoEquipos.equipo.tipoEquipo',
                'prestamoEquipos.prestamoAccesorios.accesorioEquipo',
            ]);

            $datosAnteriores = $this->datosAuditoriaPrestamo($prestamo);

            $estadoPrestamo = $request->filled('hora_fin')
                ? 'TERMINADO'
                : 'ACTIVO';

            
            // 2. Guardar los detalles existentes para actualizarlos
            // sin eliminar innecesariamente sus identificadores.
            $estadoAnteriorPrestamo = $prestamo->estado;

            $detallesActuales = $prestamo->prestamoEquipos()
                ->with('prestamoAccesorios')
                ->get()
                ->keyBy('equipo_id');

            $idsEquiposSolicitados = collect($request->input('equipos', []))
                ->pluck('equipo_id')
                ->map(fn ($id) => (int) $id)
                ->all();

            // 3. Actualizar los datos principales del préstamo.
            $prestamo->update([
                'docente_id' => $request->docente_id,
                'cargo' => $request->cargo,
                'fecha' => $request->fecha,
                'hora_inicio' => $request->hora_inicio,
                'hora_fin' => $request->hora_fin,
                'estado' => $estadoPrestamo,
            ]);

            // 4. Eliminar solamente los equipos que se retiraron
            // de este préstamo. Sus accesorios se eliminan en cascada.
            $prestamo->prestamoEquipos()
                ->whereNotIn('equipo_id', $idsEquiposSolicitados)
                ->delete();

            foreach ($request->input('equipos', []) as $equipoData) {

                $equipoId = (int) $equipoData['equipo_id'];

                // Si ya existía, actualizar su detalle. Si es nuevo,
                // crear el registro correspondiente.
                $prestamoEquipo = $detallesActuales->get($equipoId);

                if ($prestamoEquipo) {
                    $prestamoEquipo->update([
                        'estado' => $equipoData['estado'],
                        'observacion' => $equipoData['observacion'] ?? null,
                    ]);
                } else {
                    $prestamoEquipo = PrestamoEquipo::create([
                        'prestamo_id' => $prestamo->id,
                        'equipo_id' => $equipoId,
                        'estado' => $equipoData['estado'],
                        'observacion' => $equipoData['observacion'] ?? null,
                    ]);
                }

                // Actualizar el inventario únicamente cuando el préstamo
                // pasa de ACTIVO a TERMINADO. Editar uno que ya estaba
                // TERMINADO no debe sobrescribir el estado actual.
                if (
                    $estadoAnteriorPrestamo === 'ACTIVO'
                    && $estadoPrestamo === 'TERMINADO'
                ) {
                    $equipo = Equipo::with([
                        'especificacionesLaptops',
                        'especificacionesEquipo',
                    ])->findOrFail($equipoId);

                    if ($equipo->especificacionesLaptops) {
                        $equipo->especificacionesLaptops->update([
                            'estado' => $equipoData['estado'],
                        ]);
                    } elseif ($equipo->especificacionesEquipo) {
                        $equipo->especificacionesEquipo->update([
                            'estado' => $equipoData['estado'],
                        ]);
                    }
                }

                // Sincronizar los accesorios del detalle sin recrear
                // los que ya existen.
                $accesoriosActuales = $prestamoEquipo
                    ->prestamoAccesorios()
                    ->get()
                    ->keyBy('accesorio_equipo_id');

                $accesoriosSolicitados = collect(
                    $equipoData['accesorios'] ?? []
                );

                $idsAccesoriosSolicitados = $accesoriosSolicitados
                    ->pluck('accesorio_equipo_id')
                    ->map(fn ($id) => (int) $id)
                    ->all();

                // Retirar únicamente los accesorios que se quitaron
                // de este equipo dentro del préstamo.
                $prestamoEquipo->prestamoAccesorios()
                    ->whereNotIn(
                        'accesorio_equipo_id',
                        $idsAccesoriosSolicitados
                    )
                    ->delete();

                foreach ($accesoriosSolicitados as $accesorioData) {

                    $accesorioId = (int) $accesorioData['accesorio_equipo_id'];

                    $prestamoAccesorio = $accesoriosActuales->get(
                        $accesorioId
                    );

                    if ($prestamoAccesorio) {
                        $prestamoAccesorio->update([
                            'estado' => $accesorioData['estado'],
                            'observacion' =>
                                $accesorioData['observacion'] ?? null,
                        ]);
                    } else {
                        $prestamoAccesorio = PrestamoAccesorio::create([
                            'prestamo_equipo_id' => $prestamoEquipo->id,
                            'accesorio_equipo_id' => $accesorioId,
                            'estado' => $accesorioData['estado'],
                            'observacion' =>
                                $accesorioData['observacion'] ?? null,
                        ]);
                    }

                    // Igual que con los equipos: actualizar el estado
                    // real del accesorio solo al terminar un préstamo
                    // que anteriormente estaba activo.
                    if (
                        $estadoAnteriorPrestamo === 'ACTIVO'
                        && $estadoPrestamo === 'TERMINADO'
                    ) {
                        $accesorio = $prestamoAccesorio->accesorioEquipo;

                        if ($accesorio) {
                            $accesorio->update([
                                'estado' => $accesorioData['estado'],
                            ]);
                        }
                    }
                }
            }

            // 4. Cargar la información nueva después de guardar todo.
            $prestamo->refresh();

            $prestamo->load([
                'docente',
                'prestamoEquipos.equipo.tipoEquipo',
                'prestamoEquipos.prestamoAccesorios.accesorioEquipo',
            ]);

            $datosNuevos = $this->datosAuditoriaPrestamo($prestamo);

            // 5. Registrar ambas versiones.
            Auditoria::registrar(
                'ACTUALIZAR',
                'PRESTAMOS',
                "Se modificó el préstamo #{$prestamo->id}.",
                $prestamo,
                [
                    'anterior' => $datosAnteriores,
                    'nuevo' => $datosNuevos,
                ]
            );
        });

        return redirect()->route('prestamos.index')
            ->with('success', 'Préstamo modificado.')
            ->with('toast_tipo', 'exito')
            ->with('prestamo_resaltado', $prestamo->id)
            ->with('prestamo_accion', 'editar');
    }

    /**
     * Eliminar préstamo
     */
    public function destroy($id): RedirectResponse
    {
        DB::transaction(function () use ($id) {

            $prestamo = Prestamo::with([
                'docente',
                'prestamoEquipos.equipo.tipoEquipo',
                'prestamoEquipos.prestamoAccesorios.accesorioEquipo',
            ])->findOrFail($id);

            // Capturar todos los datos antes de eliminar.
            $datosEliminados = $this->datosAuditoriaPrestamo($prestamo);

            Auditoria::registrar(
                'ELIMINAR',
                'PRESTAMOS',
                "Se eliminó el préstamo #{$prestamo->id}.",
                $prestamo,
                [
                    'eliminado' => $datosEliminados,
                ]
            );

            $prestamo->delete();
        });

        return Redirect::route('prestamos.index')
            ->with('success', 'Préstamo eliminado.')
            ->with('toast_tipo', 'error')
            ->with('prestamo_resaltado', $id)
            ->with('prestamo_accion', 'eliminar');
    }

    /**
     * Obtener equipos según tipo
     */
    public function equiposPorTipo(Request $request, $tipoId)
    {
        $equipos = Equipo::with([
            'tipoEquipo',
            'especificacionesLaptops',
            'especificacionesEquipo',
            'accesoriosEquipos'
        ])
            ->where('tipo_equipo_id', $tipoId)
->whereDoesntHave('prestamoEquipos', function ($detalle) use ($request) {
    $detalle->whereHas('prestamo', function ($prestamoQuery) use ($request) {
        $prestamoQuery->where('estado', 'ACTIVO');

        if ($request->filled('prestamo_id')) {
            $prestamoQuery->where(
                'id',
                '!=',
                (int) $request->input('prestamo_id')
            );
        }
    });
})
            ->select(
                'id',
                'tipo_equipo_id',
                'marca',
                'modelo',
                'num_serie'
            )
            ->get()
            ->map(function ($equipo) {

                $estadoActual =
                    $equipo->especificacionesLaptops?->estado
                    ?? $equipo->especificacionesEquipo?->estado
                    ?? 'BUENO';

                $equipo->estado_actual = $estadoActual;

                return $equipo;
            });

        return response()->json($equipos);
    }

    /**
     * Buscar equipos con búsqueda global.
     */
    public function buscarEquipos(Request $request)
    {
        $query = Equipo::with([
    'tipoEquipo',
    'especificacionesLaptops',
    'especificacionesEquipo',
    'accesoriosEquipos'
])->whereDoesntHave('prestamoEquipos', function ($detalle) use ($request) {
    $detalle->whereHas('prestamo', function ($prestamoQuery) use ($request) {
        $prestamoQuery->where('estado', 'ACTIVO');

        if ($request->filled('prestamo_id')) {
            $prestamoQuery->where(
                'id',
                '!=',
                (int) $request->input('prestamo_id')
            );
        }
    });
});

        if ($request->filled('tipo_equipo_id')) {
            $query->where(
                'tipo_equipo_id',
                $request->tipo_equipo_id
            );
        }

        if ($request->filled('buscar')) {
            $terminos = preg_split(
                '/\s+/',
                trim($request->buscar)
            );

            foreach ($terminos as $termino) {
                $query->where(function ($q) use ($termino) {
                    $q->where(
                        'marca',
                        'LIKE',
                        "%{$termino}%"
                    )
                        ->orWhere(
                            'modelo',
                            'LIKE',
                            "%{$termino}%"
                        )
                        ->orWhere(
                            'num_serie',
                            'LIKE',
                            "%{$termino}%"
                        )
                        ->orWhereHas('tipoEquipo', function ($q) use ($termino) {
                            $q->where(
                                'nombre',
                                'LIKE',
                                "%{$termino}%"
                            );
                        });
                });
            }
        }

        $equipos = $query
            ->select(
                'id',
                'tipo_equipo_id',
                'marca',
                'modelo',
                'num_serie'
            )
            ->get()
            ->map(function ($equipo) {
                $estadoActual =
                    $equipo->especificacionesLaptops?->estado
                    ?? $equipo->especificacionesEquipo?->estado
                    ?? 'BUENO';

                $equipo->estado_actual = $estadoActual;

                return $equipo;
            });

        return response()->json($equipos);
    }

    public function registrarDocente(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'cargo' => 'required|string|max:100',
        ]);

        $docente = Docente::create([
            'nombres' => mb_strtoupper(trim($request->nombres), 'UTF-8'),
            'apellidos' => mb_strtoupper(trim($request->apellidos), 'UTF-8'),
            'cargo' => mb_strtoupper(trim($request->cargo), 'UTF-8'),
            'dni' => null,
            'correo' => null,
            'celular' => null,
        ]);

        return response()->json([
            'success' => true,
            'docente' => [
                'id' => $docente->id,
                'nombres' => $docente->nombres,
                'apellidos' => $docente->apellidos,
                'cargo' => $docente->cargo,
            ],
        ]);
    }


    public function exportExcel(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return back()->with('error', 'No hay registros para exportar.');
        }

        $ids = array_map('intval', $ids);

        $prestamosEncontrados = Prestamo::with([
            'docente',
            'prestamoEquipos.equipo.tipoEquipo',
            'prestamoEquipos.prestamoAccesorios.accesorioEquipo',
        ])
            ->whereIn('id', $ids)
            ->get()
            ->keyBy('id');

        // Respetar el orden del DataTable
        $prestamos = collect($ids)
            ->map(fn($id) => $prestamosEncontrados->get($id))
            ->filter()
            ->values();

        if ($prestamos->isEmpty()) {
            return back()->with('error', 'No se encontraron préstamos válidos para exportar.');
        }

        $nombreArchivo = 'Prestamos_' . now()->format('d-m-Y_g-ia') . '.xlsx';

        // Preparar la descarga
        $respuesta = \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\PrestamosExport($prestamos),
            $nombreArchivo
        );

        // Registrar los préstamos incluidos en la exportación
        Auditoria::registrar(
            'EXPORTAR_EXCEL',
            'PRESTAMOS',
            'Exportó ' . $prestamos->count() . ' préstamo(s) a Excel.',
            null,
            [
                'formato' => 'EXCEL',
                'cantidad' => $prestamos->count(),
                'archivo' => $nombreArchivo,
                'prestamos' => $prestamos->map(function ($prestamo) {
                    return [
                        'id' => $prestamo->id,
                        'solicitante' => trim(
                            ($prestamo->docente->apellidos ?? '') . ' ' .
                                ($prestamo->docente->nombres ?? '')
                        ),
                        'cargo' => $prestamo->cargo,
                        'fecha' => $prestamo->fecha,
                        'hora_inicio' => $prestamo->hora_inicio,
                        'hora_fin' => $prestamo->hora_fin,
                        'estado' => $prestamo->estado,
                        'equipos' => $prestamo->prestamoEquipos->map(function ($prestamoEquipo) {
                            $equipo = $prestamoEquipo->equipo;

                            return [
                                'id' => $equipo?->id,
                                'tipo_equipo' => $equipo?->tipoEquipo?->nombre ?? 'SIN TIPO',
                                'marca' => $equipo?->marca ?? 'SIN MARCA',
                                'modelo' => $equipo?->modelo,
                                'num_serie' => $equipo?->num_serie ?? 'SIN SERIE',
                                'estado' => $prestamoEquipo->estado,
                                'accesorios' => $prestamoEquipo->prestamoAccesorios->map(function ($prestamoAccesorio) {
                                    $accesorio = $prestamoAccesorio->accesorioEquipo;

                                    return [
                                        'id' => $accesorio?->id,
                                        'tipo' => $accesorio?->tipo ?? 'SIN TIPO',
                                        'marca' => $accesorio?->marca ?? 'SIN MARCA',
                                        'num_serie' => $accesorio?->num_serie ?? 'SIN SERIE',
                                        'estado' => $prestamoAccesorio->estado,
                                    ];
                                })->values()->all(),
                            ];
                        })->values()->all(),
                    ];
                })->values()->all(),
            ]
        );

        return $respuesta;
    }

    public function exportPdf(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return back()->with('error', 'No hay registros para exportar.');
        }

        $ids = array_map('intval', $ids);

        $prestamosEncontrados = Prestamo::with([
            'docente',
            'prestamoEquipos.equipo.tipoEquipo',
            'prestamoEquipos.prestamoAccesorios.accesorioEquipo',
        ])
            ->whereIn('id', $ids)
            ->get()
            ->keyBy('id');

        // Respetar exactamente el orden enviado por DataTable
        $prestamos = collect($ids)
            ->map(function ($id) use ($prestamosEncontrados) {
                return $prestamosEncontrados->get($id);
            })
            ->filter()
            ->values();

        if ($prestamos->isEmpty()) {
            return back()->with('error', 'No se encontraron préstamos válidos para exportar.');
        }

        $nombreArchivo = 'Prestamos_' . now()->format('d-m-Y_g-ia') . '.pdf';

        $pdf = Pdf::loadView(
            'prestamo.export-pdf',
            compact('prestamos')
        )->setPaper('a4', 'landscape');

        // Preparar la descarga
        $respuesta = $pdf->download($nombreArchivo);

        // Registrar los préstamos incluidos en la exportación
        Auditoria::registrar(
            'EXPORTAR_PDF',
            'PRESTAMOS',
            'Exportó ' . $prestamos->count() . ' préstamo(s) a PDF.',
            null,
            [
                'formato' => 'PDF',
                'cantidad' => $prestamos->count(),
                'archivo' => $nombreArchivo,
                'prestamos' => $prestamos->map(function ($prestamo) {
                    return [
                        'id' => $prestamo->id,
                        'solicitante' => trim(
                            ($prestamo->docente->apellidos ?? '') . ' ' .
                                ($prestamo->docente->nombres ?? '')
                        ),
                        'cargo' => $prestamo->cargo,
                        'fecha' => $prestamo->fecha,
                        'hora_inicio' => $prestamo->hora_inicio,
                        'hora_fin' => $prestamo->hora_fin,
                        'estado' => $prestamo->estado,
                        'equipos' => $prestamo->prestamoEquipos->map(function ($prestamoEquipo) {
                            $equipo = $prestamoEquipo->equipo;

                            return [
                                'id' => $equipo?->id,
                                'tipo_equipo' => $equipo?->tipoEquipo?->nombre ?? 'SIN TIPO',
                                'marca' => $equipo?->marca ?? 'SIN MARCA',
                                'modelo' => $equipo?->modelo,
                                'num_serie' => $equipo?->num_serie ?? 'SIN SERIE',
                                'estado' => $prestamoEquipo->estado,
                                'accesorios' => $prestamoEquipo->prestamoAccesorios->map(function ($prestamoAccesorio) {
                                    $accesorio = $prestamoAccesorio->accesorioEquipo;

                                    return [
                                        'id' => $accesorio?->id,
                                        'tipo' => $accesorio?->tipo ?? 'SIN TIPO',
                                        'marca' => $accesorio?->marca ?? 'SIN MARCA',
                                        'num_serie' => $accesorio?->num_serie ?? 'SIN SERIE',
                                        'estado' => $prestamoAccesorio->estado,
                                    ];
                                })->values()->all(),
                            ];
                        })->values()->all(),
                    ];
                })->values()->all(),
            ]
        );

        return $respuesta;
    }


    public function auditarImpresion(Prestamo $prestamo)
    {
        Auditoria::registrar(
            'IMPRIMIR_FICHA',
            'PRESTAMOS',
            'Solicitó imprimir la ficha del préstamo #' . $prestamo->id . '.',
            $prestamo,
            [
                'prestamo' => $this->datosAuditoriaPrestamo($prestamo),
            ]
        );

        return response()->json([
            'message' => 'Solicitud de impresión registrada correctamente.',
        ]);
    }
}