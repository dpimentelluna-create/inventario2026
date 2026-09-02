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
    public function store(PrestamoRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {

            /*
             * El estado del préstamo se determina
             * automáticamente según la hora final.
             */
            $estado = $request->filled('hora_fin')
                ? 'TERMINADO'
                : 'ACTIVO';

            /*
             * Crear préstamo principal
             */
            $prestamo = Prestamo::create([
                'docente_id' => $request->docente_id,
                'cargo' => $request->cargo,
                'fecha' => $request->fecha,
                'hora_inicio' => $request->hora_inicio,
                'hora_fin' => $request->hora_fin,
                'estado' => $estado,
            ]);

            /*
             * Guardar cada equipo
             */
            foreach ($request->equipos as $equipoData) {

                $prestamoEquipo = PrestamoEquipo::create([
                    'prestamo_id' => $prestamo->id,
                    'equipo_id' => $equipoData['equipo_id'],
                    'estado' => $equipoData['estado'],
                    'observacion' => $equipoData['observacion'] ?? null,
                ]);

                /*
                 * Guardar accesorios del equipo
                 */
                if (!empty($equipoData['accesorios'])) {

                    foreach ($equipoData['accesorios'] as $accesorioData) {

                        PrestamoAccesorio::create([
                            'prestamo_equipo_id' => $prestamoEquipo->id,
                            'accesorio_equipo_id' =>
                                $accesorioData['accesorio_equipo_id'],
                            'estado' => $accesorioData['estado'],
                            'observacion' =>
                                $accesorioData['observacion'] ?? null,
                        ]);
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
             * Determinar automáticamente el estado
             */
            $estado = $request->filled('hora_fin')
                ? 'TERMINADO'
                : 'ACTIVO';

            /*
             * Actualizar datos principales
             */
            $prestamo->update([
                'docente_id' => $request->docente_id,
                'cargo' => $request->cargo,
                'fecha' => $request->fecha,
                'hora_inicio' => $request->hora_inicio,
                'hora_fin' => $request->hora_fin,
                'estado' => $estado,
            ]);

            /*
             * Eliminamos los equipos y accesorios
             * anteriores del préstamo.
             *
             * Los registros se eliminan en cascada:
             * prestamo_equipos
             *       ↓
             * prestamo_accesorios
             */
            $prestamo->prestamoEquipos()->delete();

            /*
             * Volvemos a registrar los equipos actuales
             */
            foreach ($request->equipos as $equipoData) {

                $prestamoEquipo = PrestamoEquipo::create([
                    'prestamo_id' => $prestamo->id,
                    'equipo_id' => $equipoData['equipo_id'],
                    'estado' => $equipoData['estado'],
                    'observacion' => $equipoData['observacion'] ?? null,
                ]);

                /*
                 * Registrar accesorios
                 */
                if (!empty($equipoData['accesorios'])) {

                    foreach ($equipoData['accesorios'] as $accesorioData) {

                        PrestamoAccesorio::create([
                            'prestamo_equipo_id' => $prestamoEquipo->id,
                            'accesorio_equipo_id' =>
                                $accesorioData['accesorio_equipo_id'],
                            'estado' => $accesorioData['estado'],
                            'observacion' =>
                                $accesorioData['observacion'] ?? null,
                        ]);
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
        $equipos = Equipo::with('tipoEquipo')
            ->where('tipo_equipo_id', $tipoId)
            ->select(
                'id',
                'tipo_equipo_id',
                'marca',
                'modelo',
                'num_serie',
                'estado'
            )
            ->get();

        return response()->json($equipos);
    }

    /**
     * Buscar equipos con búsqueda global.
     */
    public function buscarEquipos(Request $request)
    {
        $query = Equipo::with([
            'tipoEquipo',
            'accesoriosEquipos'
        ]);

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
            ->get();

        return response()->json($equipos);
    }
}
