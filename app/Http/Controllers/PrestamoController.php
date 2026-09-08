<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\PrestamoEquipo;
use App\Models\PrestamoAccesorio;
use App\Models\Equipo;
use App\Models\TiposEquipo;
use App\Models\Docente;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PrestamoRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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
            'prestamoEquipos.prestamoAccesorios.accesorioEquipo'
        ])
            ->latest('fecha')
            ->paginate(20);

        return view('prestamo.index', compact('prestamos'))
            ->with(
                'i',
                ($request->input('page', 1) - 1)
                    * $prestamos->perPage()
            );
    }

    /**
     * Mostrar formulario para crear préstamo
     */
    public function create(): View
    {
        $prestamo = new Prestamo();

        $tiposEquipo = TiposEquipo::orderBy('nombre')->get();

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
     * Guardar préstamo
     */
    public function store(
        PrestamoRequest $request
    ): RedirectResponse {

        DB::transaction(function () use ($request) {

            /*
         * =====================================================
         * 1. DETERMINAR ESTADO DEL PRÉSTAMO
         * =====================================================
         *
         * Si existe hora_fin:
         *      TERMINADO
         *
         * Si no existe:
         *      ACTIVO
         */
            $estadoPrestamo = $request->filled('hora_fin')
                ? 'TERMINADO'
                : 'ACTIVO';


            /*
         * =====================================================
         * 2. CREAR PRÉSTAMO
         * =====================================================
         */
            $prestamo = Prestamo::create([
                'docente_id' => $request->docente_id,

                'cargo' => $request->cargo,

                'fecha' => $request->fecha,

                'hora_inicio' => $request->hora_inicio,

                'hora_fin' => $request->hora_fin,

                'estado' => $estadoPrestamo,
            ]);


            /*
         * =====================================================
         * 3. REGISTRAR EQUIPOS
         * =====================================================
         */
            foreach ($request->equipos as $equipoData) {

                /*
             * Buscar equipo real con sus especificaciones.
             */
                $equipo = Equipo::with([
                    'especificacionesLaptops',
                    'especificacionesEquipo',
                    'accesoriosEquipos',
                ])->findOrFail(
                    $equipoData['equipo_id']
                );


                /*
             * =================================================
             * OBTENER ESTADO REAL ACTUAL DEL EQUIPO
             * =================================================
             */
                $estadoActual = 'BUENO';

                if ($equipo->especificacionesLaptops) {

                    $estadoActual =
                        $equipo
                        ->especificacionesLaptops
                        ->estado;
                } elseif ($equipo->especificacionesEquipo) {

                    $estadoActual =
                        $equipo
                        ->especificacionesEquipo
                        ->estado;
                }


                /*
             * =================================================
             * 4. CREAR SNAPSHOT DEL EQUIPO
             * =================================================
             *
             * Al crear un préstamo, usamos el estado real
             * actual del equipo.
             */
                $prestamoEquipo = PrestamoEquipo::create([
                    'prestamo_id' => $prestamo->id,

                    'equipo_id' =>
                    $equipo->id,

                    'estado' =>
                    $estadoActual,

                    'observacion' =>
                    $equipoData['observacion'] ?? null,
                ]);


                /*
             * =================================================
             * 5. SI EL PRÉSTAMO SE CREA TERMINADO
             *    ACTUALIZAR ESTADO REAL DEL EQUIPO
             * =================================================
             *
             * En este caso sí usamos el estado enviado
             * desde el formulario.
             */
                if ($estadoPrestamo === 'TERMINADO') {

                    if ($equipo->especificacionesLaptops) {

                        $equipo
                            ->especificacionesLaptops
                            ->update([
                                'estado' =>
                                $equipoData['estado'],
                            ]);
                    } elseif ($equipo->especificacionesEquipo) {

                        $equipo
                            ->especificacionesEquipo
                            ->update([
                                'estado' =>
                                $equipoData['estado'],
                            ]);
                    }


                    /*
                 * Como el préstamo terminó inmediatamente,
                 * el snapshot debe representar el estado
                 * final registrado.
                 */
                    $prestamoEquipo->update([
                        'estado' =>
                        $equipoData['estado'],
                    ]);
                }


                /*
             * =================================================
             * 6. REGISTRAR ACCESORIOS
             * =================================================
             */
                if (!empty($equipoData['accesorios'])) {

                    foreach (
                        $equipoData['accesorios']
                        as $accesorioData
                    ) {

                        /*
                     * Crear snapshot del accesorio.
                     */
                        $prestamoAccesorio =
                            PrestamoAccesorio::create([
                                'prestamo_equipo_id' =>
                                $prestamoEquipo->id,

                                'accesorio_equipo_id' =>
                                $accesorioData['accesorio_equipo_id'],

                                'estado' =>
                                $accesorioData['estado'],

                                'observacion' =>
                                $accesorioData['observacion'] ?? null,
                            ]);


                        /*
                     * =================================================
                     * 7. SI EL PRÉSTAMO SE CREA TERMINADO
                     *    ACTUALIZAR ESTADO REAL DEL ACCESORIO
                     * =================================================
                     */
                        if ($estadoPrestamo === 'TERMINADO') {

                            $accesorio =
                                $prestamoAccesorio
                                ->accesorioEquipo;


                            if ($accesorio) {

                                $accesorio->update([
                                    'estado' =>
                                    $accesorioData['estado'],
                                ]);
                            }
                        }
                    }
                }
            }
        });


        return Redirect::route('prestamos.index')
            ->with(
                'success',
                'Préstamo registrado correctamente.'
            );
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

        $tiposEquipo = TiposEquipo::orderBy('nombre')->get();

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

            /*
         * =====================================================
         * 1. DETERMINAR ESTADO DEL PRÉSTAMO
         * =====================================================
         *
         * Si existe hora_fin:
         *      TERMINADO
         *
         * Si no existe:
         *      ACTIVO
         */
            $estadoPrestamo = $request->filled('hora_fin')
                ? 'TERMINADO'
                : 'ACTIVO';


            /*
         * =====================================================
         * 2. ACTUALIZAR DATOS PRINCIPALES
         * =====================================================
         */
            $prestamo->update([
                'docente_id' => $request->docente_id,
                'cargo' => $request->cargo,
                'fecha' => $request->fecha,
                'hora_inicio' => $request->hora_inicio,
                'hora_fin' => $request->hora_fin,
                'estado' => $estadoPrestamo,
            ]);


            /*
         * =====================================================
         * 3. ELIMINAR EQUIPOS Y ACCESORIOS ANTERIORES
         * =====================================================
         *
         * Los accesorios se eliminan automáticamente por
         * ON DELETE CASCADE.
         *
         * IMPORTANTE:
         * Esto NO elimina el equipo real ni sus accesorios.
         * Solo elimina el snapshot de este préstamo.
         */
            $prestamo->prestamoEquipos()->delete();


            /*
         * =====================================================
         * 4. REGISTRAR LOS EQUIPOS ACTUALES DEL PRÉSTAMO
         * =====================================================
         */
            foreach ($request->equipos as $equipoData) {

                /*
             * Crear snapshot del equipo.
             */
                $prestamoEquipo = PrestamoEquipo::create([
                    'prestamo_id' => $prestamo->id,

                    'equipo_id' =>
                    $equipoData['equipo_id'],

                    'estado' =>
                    $equipoData['estado'],

                    'observacion' =>
                    $equipoData['observacion'] ?? null,
                ]);


                /*
             * =================================================
             * 5. SI EL PRÉSTAMO TERMINÓ
             *    ACTUALIZAR ESTADO REAL DEL EQUIPO
             * =================================================
             */
                if ($estadoPrestamo === 'TERMINADO') {

                    $equipo = Equipo::with([
                        'especificacionesLaptops',
                        'especificacionesEquipo',
                    ])->findOrFail(
                        $equipoData['equipo_id']
                    );


                    /*
                 * Laptop
                 */
                    if ($equipo->especificacionesLaptops) {

                        $equipo
                            ->especificacionesLaptops
                            ->update([
                                'estado' =>
                                $equipoData['estado'],
                            ]);
                    }


                    /*
                 * Otro tipo de equipo
                 */ elseif ($equipo->especificacionesEquipo) {

                        $equipo
                            ->especificacionesEquipo
                            ->update([
                                'estado' =>
                                $equipoData['estado'],
                            ]);
                    }
                }


                /*
             * =================================================
             * 6. REGISTRAR ACCESORIOS DEL EQUIPO
             * =================================================
             */
                if (!empty($equipoData['accesorios'])) {

                    foreach (
                        $equipoData['accesorios']
                        as $accesorioData
                    ) {

                        /*
                     * Crear snapshot del accesorio.
                     */
                        $prestamoAccesorio =
                            PrestamoAccesorio::create([
                                'prestamo_equipo_id' =>
                                $prestamoEquipo->id,

                                'accesorio_equipo_id' =>
                                $accesorioData['accesorio_equipo_id'],

                                'estado' =>
                                $accesorioData['estado'],

                                'observacion' =>
                                $accesorioData['observacion'] ?? null,
                            ]);


                        /*
                     * =================================================
                     * 7. SI EL PRÉSTAMO TERMINÓ
                     *    ACTUALIZAR ESTADO REAL DEL ACCESORIO
                     * =================================================
                     */
                        if ($estadoPrestamo === 'TERMINADO') {

                            $accesorio =
                                $prestamoAccesorio
                                ->accesorioEquipo;


                            if ($accesorio) {

                                $accesorio->update([
                                    'estado' =>
                                    $accesorioData['estado'],
                                ]);
                            }
                        }
                    }
                }
            }
        });


        return Redirect::route('prestamos.index')
            ->with(
                'success',
                'Préstamo actualizado correctamente.'
            );
    }



    /**
     * Eliminar préstamo
     */
    public function destroy($id): RedirectResponse
    {
        $prestamo = Prestamo::findOrFail($id);

        $prestamo->delete();

        return Redirect::route('prestamos.index')
            ->with(
                'success',
                'Préstamo eliminado correctamente.'
            );
    }

    /**
     * Obtener equipos según tipo
     */
    public function equiposPorTipo($tipoId)
    {
        $equipos = Equipo::with([
            'tipoEquipo',
            'especificacionesLaptops',
            'especificacionesEquipo',
            'accesoriosEquipos'
        ])
            ->where('tipo_equipo_id', $tipoId)
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
        ]);

        /*
     * FILTRO POR TIPO DE EQUIPO
     */
        if ($request->filled('tipo_equipo_id')) {

            $query->where(
                'tipo_equipo_id',
                $request->tipo_equipo_id
            );
        }

        /*
     * BÚSQUEDA GLOBAL
     */
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

        /*
     * OBTENER EQUIPOS
     */
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

                /*
             * El estado real se obtiene desde la
             * especificación correspondiente.
             */
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
}
