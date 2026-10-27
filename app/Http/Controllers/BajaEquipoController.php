<?php

namespace App\Http\Controllers;

use App\Models\BajaEquipo;
use App\Models\Equipo;
use App\Models\PrestamoEquipo;
use App\Models\Auditoria;
use App\Models\TiposEquipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BajaEquipoController extends Controller
{
    /**
     * Mostrar el historial de bajas administrativas.
     */
    public function index(): View
    {
        $bajas = BajaEquipo::with([
            'equipo.tipoEquipo',
            'equipo.ubicacione',
        ])
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->paginate(20);

        return view('bajas-equipos.index', compact('bajas'));
    }

    /**
     * Mostrar el formulario para registrar una baja.
     */
    public function create(): View
    {
        $equipos = Equipo::query()
            ->where('situacion_administrativa', 'EN_INVENTARIO')
            ->with(['tipoEquipo', 'ubicacione'])
            ->orderBy('id', 'asc')
            ->get();

        $tiposEquipo = TiposEquipo::whereIn(
            'id',
            $equipos->pluck('tipo_equipo_id')->unique()
        )
            ->orderBy('nombre')
            ->get();

        $equiposForJs = $equipos->map(function ($e) {
            return [
                'id' => $e->id,
                'tipo_id' => $e->tipo_equipo_id,
                'tipo' => $e->tipoEquipo->nombre ?? 'SIN TIPO',
                'marca' => $e->marca ?? '',
                'modelo' => $e->modelo ?? '',
                'serie' => $e->num_serie ?? '',
                'ubicacion' => $e->ubicacione->nombre ?? '',
            ];
        })->values();

        return view('bajas-equipos.create', compact('equipos', 'tiposEquipo', 'equiposForJs'));
    }


    public function store(Request $request): RedirectResponse
    {
        // 1. Validar los datos recibidos del formulario.
        $datos = $request->validate([
            'equipo_id' => ['required', 'integer', 'exists:equipos,id'],
            'fecha' => ['required', 'date'],
            'destino' => ['required', 'string', 'max:150'],

            'entregantes' => ['required', 'array', 'min:1'],
            'entregantes.*.nombre' => ['required', 'string', 'max:150'],
            'entregantes.*.cargo' => ['required', 'string', 'max:150'],

            'receptores' => ['required', 'array', 'min:1'],
            'receptores.*.nombre' => ['required', 'string', 'max:150'],
            'receptores.*.cargo' => ['required', 'string', 'max:150'],

            'observaciones' => ['nullable', 'string', 'max:5000'],
        ], [
            'equipo_id.required' => 'Debes seleccionar un equipo.',
            'equipo_id.exists' => 'El equipo seleccionado no existe.',
            'entregantes.required' => 'Registra al menos una persona que entrega.',
            'entregantes.min' => 'Debe registrarse al menos una persona que entrega.',
            'entregantes.*.nombre.required' => 'Ingresa el nombre de cada integrante que entrega.',
            'entregantes.*.cargo.required' => 'Ingresa el cargo de cada integrante que entrega.',
            'receptores.required' => 'Registra al menos una persona que recibe.',
            'receptores.min' => 'Debe registrarse al menos una persona que recibe.',
            'receptores.*.nombre.required' => 'Ingresa el nombre de cada integrante que recibe.',
            'receptores.*.cargo.required' => 'Ingresa el cargo de cada integrante que recibe.',
        ]);

        // 2. Mantener los campos antiguos obligatorios de la base de datos.
        $primerEntregante = $datos['entregantes'][0];
        $primerReceptor = $datos['receptores'][0];

        $quienEntregoAnterior = mb_substr(
            trim($primerEntregante['nombre'] . ' - ' . $primerEntregante['cargo']),
            0,
            150
        );

        $quienRecibioAnterior = mb_substr(
            trim($primerReceptor['nombre'] . ' - ' . $primerReceptor['cargo']),
            0,
            150
        );

        // 3. Registrar la baja dentro de una transacción.
        $baja = DB::transaction(function () use ($datos, $quienEntregoAnterior, $quienRecibioAnterior) {
            // Bloquear el equipo mientras se comprueba su disponibilidad.
            $equipo = Equipo::whereKey($datos['equipo_id'])
                ->lockForUpdate()
                ->firstOrFail();

            // No permitir dar de baja un equipo que ya salió de inventario.
            if ($equipo->situacion_administrativa !== 'EN_INVENTARIO') {
                throw ValidationException::withMessages([
                    'equipo_id' => 'El equipo seleccionado ya no se encuentra en inventario.',
                ]);
            }

            // No permitir la baja si el equipo tiene un préstamo activo.
            $tienePrestamoActivo = PrestamoEquipo::where('equipo_id', $equipo->id)
                ->whereHas('prestamo', function ($consulta) {
                    $consulta->where('estado', 'ACTIVO');
                })
                ->exists();

            if ($tienePrestamoActivo) {
                throw ValidationException::withMessages([
                    'equipo_id' => 'No se puede dar de baja un equipo que tiene un préstamo activo.',
                ]);
            }

            // Crear el registro de baja con los integrantes completos.
            $baja = BajaEquipo::create([
                'equipo_id' => $equipo->id,
                'fecha' => $datos['fecha'],
                'destino' => trim($datos['destino']),

                // Compatibilidad con las columnas antiguas.
                'quien_entrego' => $quienEntregoAnterior,
                'quien_recibio' => $quienRecibioAnterior,

                // Listas completas de integrantes.
                'entregantes' => $datos['entregantes'],
                'receptores' => $datos['receptores'],

                'observaciones' => $datos['observaciones'] ?? null,
            ]);

            // Cambiar la situación administrativa del equipo.
            $equipo->situacion_administrativa = 'DE_BAJA';
            $equipo->save();

            // Registrar la operación en la auditoría.
            Auditoria::registrar(
                'CREAR',
                'BAJAS DE EQUIPOS',
                'Se registró la baja administrativa del equipo ID ' . $equipo->id . '.',
                $baja,
                [
                    'nuevo' => [
                        'equipo_id' => $equipo->id,
                        'fecha' => $datos['fecha'],
                        'destino' => trim($datos['destino']),
                        'entregantes' => $datos['entregantes'],
                        'receptores' => $datos['receptores'],
                        'observaciones' => $datos['observaciones'] ?? null,
                        'situacion_administrativa' => 'DE_BAJA',
                    ],
                ]
            );

            return $baja;
        });

        // 4. Redirigir al detalle de la baja registrada.
        return redirect()
            ->route('bajas-equipos.show', $baja->id)
            ->with('success', 'La baja administrativa se registró correctamente.');
    }


    /**
     * Mostrar el detalle de una baja registrada.
     */
    public function show(BajaEquipo $bajas_equipo): View
    {
        $baja = $bajas_equipo->load([
            'equipo.tipoEquipo',
            'equipo.ubicacione',
        ]);

        return view('bajas-equipos.show', compact('baja'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(BajaEquipo $bajas_equipo): View
    {
        $baja = $bajas_equipo->load([
            'equipo.tipoEquipo',
            'equipo.ubicacione',
        ]);

        // Equipos EN_INVENTARIO + el equipo actual de esta baja
        $equipos = Equipo::query()
            ->where(function ($q) use ($baja) {
                $q->where('situacion_administrativa', 'EN_INVENTARIO')
                    ->orWhere('id', $baja->equipo_id);
            })
            ->with(['tipoEquipo', 'ubicacione'])
            ->orderBy('id')
            ->get();

        $tiposEquipo = TiposEquipo::orderBy('nombre')->get();

        $equiposForJs = $equipos->map(function ($e) {
            return [
                'id' => $e->id,
                'tipo_id' => $e->tipo_equipo_id,
                'tipo' => $e->tipoEquipo->nombre ?? 'SIN TIPO',
                'marca' => $e->marca ?? '',
                'modelo' => $e->modelo ?? '',
                'serie' => $e->num_serie ?? '',
                'ubicacion' => $e->ubicacione->nombre ?? '',
            ];
        })->values();

        return view('bajas-equipos.edit', compact('baja', 'equipos', 'tiposEquipo', 'equiposForJs'));
    }



    public function update(Request $request, BajaEquipo $bajas_equipo): RedirectResponse
    {
        // 1. Validar los datos que se desean corregir.
        $datos = $request->validate([
            'fecha' => ['required', 'date'],
            'destino' => ['required', 'string', 'max:150'],

            'entregantes' => ['required', 'array', 'min:1'],
            'entregantes.*.nombre' => ['required', 'string', 'max:150'],
            'entregantes.*.cargo' => ['required', 'string', 'max:150'],

            'receptores' => ['required', 'array', 'min:1'],
            'receptores.*.nombre' => ['required', 'string', 'max:150'],
            'receptores.*.cargo' => ['required', 'string', 'max:150'],

            'observaciones' => ['nullable', 'string', 'max:5000'],
        ], [
            'entregantes.required' => 'Registra al menos una persona que entrega.',
            'entregantes.min' => 'Debe registrarse al menos una persona que entrega.',
            'entregantes.*.nombre.required' => 'Ingresa el nombre de cada integrante que entrega.',
            'entregantes.*.cargo.required' => 'Ingresa el cargo de cada integrante que entrega.',
            'receptores.required' => 'Registra al menos una persona que recibe.',
            'receptores.min' => 'Debe registrarse al menos una persona que recibe.',
            'receptores.*.nombre.required' => 'Ingresa el nombre de cada integrante que recibe.',
            'receptores.*.cargo.required' => 'Ingresa el cargo de cada integrante que recibe.',
        ]);

        // 2. Preparar los valores para las columnas antiguas.
        $primerEntregante = $datos['entregantes'][0];
        $primerReceptor = $datos['receptores'][0];

        $quienEntregoAnterior = mb_substr(
            trim($primerEntregante['nombre'] . ' - ' . $primerEntregante['cargo']),
            0,
            150
        );

        $quienRecibioAnterior = mb_substr(
            trim($primerReceptor['nombre'] . ' - ' . $primerReceptor['cargo']),
            0,
            150
        );

        // 3. Conservar una copia de los datos anteriores para la auditoría.
        $datosAnteriores = [
            'equipo_id' => $bajas_equipo->equipo_id,
            'fecha' => $bajas_equipo->fecha?->format('Y-m-d'),
            'destino' => $bajas_equipo->destino,
            'entregantes' => $bajas_equipo->entregantes,
            'receptores' => $bajas_equipo->receptores,
            'observaciones' => $bajas_equipo->observaciones,
        ];

        // 4. Actualizar únicamente los datos de la ficha.
        DB::transaction(function () use ($bajas_equipo, $datos, $quienEntregoAnterior, $quienRecibioAnterior, $datosAnteriores) {
            // Bloquear el registro de baja durante la actualización.
            $baja = BajaEquipo::whereKey($bajas_equipo->id)
                ->lockForUpdate()
                ->firstOrFail();

            $baja->update([
                'fecha' => $datos['fecha'],
                'destino' => trim($datos['destino']),

                // Mantener sincronizados los campos antiguos.
                'quien_entrego' => $quienEntregoAnterior,
                'quien_recibio' => $quienRecibioAnterior,

                // Guardar las listas completas.
                'entregantes' => $datos['entregantes'],
                'receptores' => $datos['receptores'],

                'observaciones' => $datos['observaciones'] ?? null,
            ]);

            // Registrar los cambios sin alterar la situación del equipo.
            Auditoria::registrar(
                'ACTUALIZAR',
                'BAJAS DE EQUIPOS',
                'Se corrigieron los datos de la baja administrativa ID ' . $baja->id . '.',
                $baja,
                [
                    'anterior' => $datosAnteriores,
                    'nuevo' => [
                        'equipo_id' => $baja->equipo_id,
                        'fecha' => $datos['fecha'],
                        'destino' => trim($datos['destino']),
                        'entregantes' => $datos['entregantes'],
                        'receptores' => $datos['receptores'],
                        'observaciones' => $datos['observaciones'] ?? null,
                    ],
                ]
            );
        });

        // 5. Regresar al detalle de la baja corregida.
        return redirect()
            ->route('bajas-equipos.show', $bajas_equipo->id)
            ->with('success', 'Los datos de la baja administrativa se actualizaron correctamente.');
    }


    /**
     * Eliminar (anular) una baja administrativa y restaurar el equipo.
     */
    public function destroy(BajaEquipo $bajas_equipo): RedirectResponse
    {
        DB::transaction(function () use ($bajas_equipo) {
            $baja = BajaEquipo::query()
                ->whereKey($bajas_equipo->id)
                ->lockForUpdate()
                ->firstOrFail();

            $equipoId = $baja->equipo_id;

            $equipo = Equipo::query()
                ->whereKey($equipoId)
                ->lockForUpdate()
                ->first();

            if ($equipo) {
                $equipo->update([
                    'situacion_administrativa' => 'EN_INVENTARIO',
                ]);
            }

            Auditoria::registrar(
                'ELIMINAR',
                'BAJAS DE EQUIPOS',
                "Se anuló la baja administrativa #{$baja->id} del equipo #{$equipoId}. El equipo vuelve a EN_INVENTARIO.",
                $baja,
                [
                    'anterior' => [
                        'equipo_id' => $equipoId,
                        'fecha' => $baja->fecha,
                        'destino' => $baja->destino,
                    ],
                ]
            );

            $baja->delete();
        });

        return redirect()
            ->route('bajas-equipos.index')
            ->with('success', 'Baja administrativa anulada. El equipo volvió a EN_INVENTARIO.')
            ->with('toast_tipo', 'exito');
    }
}