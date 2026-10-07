<title>Ver Préstamo</title>

@extends('layouts.app')

@section('template_title')
    {{ __('Ver Préstamo') }}
@endsection

@section('content')
        @php
    $nombreSol = trim(($prestamo->docente->apellidos ?? '') . ' ' . ($prestamo->docente->nombres ?? ''));
    $fechaVista = $prestamo->fecha
        ? \Carbon\Carbon::parse($prestamo->fecha)->format('d-m-Y')
        : '—';
    $hIni = $prestamo->hora_inicio
        ? \Carbon\Carbon::parse($prestamo->hora_inicio)->format('h:i A')
        : '—';
    $hFin = $prestamo->hora_fin
        ? \Carbon\Carbon::parse($prestamo->hora_fin)->format('h:i A')
        : 'ACTIVO';

    $equipos = $prestamo->prestamoEquipos;
    $totalEquipos = $equipos->count();
    $totalAccesorios = $equipos->sum(fn($pe) => $pe->prestamoAccesorios->count());
    $malogrados = $equipos->filter(fn($pe) => strtoupper($pe->estado ?? '') === 'MALOGRADO')->count()
        + $equipos->sum(fn($pe) => $pe->prestamoAccesorios->filter(fn($a) => strtoupper($a->estado ?? '') === 'MALOGRADO')->count());

    $borde = function ($estado) {
        $estado = strtoupper($estado ?? '');
        if ($estado === 'MALOGRADO')
            return 'borde-malogrado';
        if ($estado === 'REGULAR')
            return 'borde-regular';
        if ($estado === 'BUENO')
            return 'borde-bueno';
        return 'borde-neutro';
    };
        @endphp

        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span class="card-title fw-bold">DETALLE DEL PRÉSTAMO</span>
                            <div class="d-flex gap-2 no-print">
                                <a class="btn btn-primary btn-sm" href="{{ route('prestamos.index') }}">
                                    <i class="fa fa-arrow-left"></i> Volver
                                </a>
                                <a class="btn btn-success btn-sm" href="{{ route('prestamos.edit', $prestamo->id) }}">
                                    <i class="fa fa-edit"></i> Editar
                                </a>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="window.print()">
                                    <i class="fa fa-print"></i> Imprimir
                                </button>
                            </div>
                        </div>

                        <div class="card-body bg-white">
                            <div class="row g-3 mb-3">
                                <div class="col-md-3">
                                    <div class="bloque-dato">
                                        <div class="etiqueta"><i class="bi bi-person"></i> SOLICITANTE</div>
                                        <div class="valor">{{ $nombreSol ?: '—' }}</div>
                                        <div class="subvalor">{{ $prestamo->cargo ?: 'SIN CARGO' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="bloque-dato">
                                        <div class="etiqueta"><i class="bi bi-calendar"></i> FECHA</div>
                                        <div class="valor">{{ $fechaVista }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="bloque-dato">
                                        <div class="etiqueta"><i class="bi bi-clock"></i> HORARIO</div>
                                        <div class="valor">{{ $hIni }} → {{ $hFin }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="bloque-dato text-md-end">
                                        <div class="etiqueta">ESTADO</div>
                                        @if ($prestamo->estado === 'ACTIVO')
                                            <span class="badge bg-success fs-6">ACTIVO</span>
                                        @else
                                            <span class="badge bg-secondary fs-6">TERMINADO</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mb-4">
                                <span class="chip">{{ $totalEquipos }} equipo{{ $totalEquipos === 1 ? '' : 's' }}</span>
                                <span class="chip">{{ $totalAccesorios }} accesorio{{ $totalAccesorios === 1 ? '' : 's' }}</span>
                                @if ($malogrados > 0)
                                    <span class="chip chip-alerta">{{ $malogrados }} malogrado{{ $malogrados === 1 ? '' : 's' }}</span>
                                @endif
                            </div>

                            <h5 class="mb-3">EQUIPOS DEL PRÉSTAMO</h5>

                            @forelse ($equipos as $indice => $prestamoEquipo)
                                @php
        $equipo = $prestamoEquipo->equipo;
        $estadoEq = strtoupper($prestamoEquipo->estado ?? '');
                                @endphp
                                <div class="card mb-3 tarjeta-equipo {{ $borde($estadoEq) }}">
                                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <div>
                                            <div class="etiqueta">EQUIPO {{ $indice + 1 }}</div>
                                            <strong>
                                                {{ $equipo->tipoEquipo->nombre ?? 'SIN TIPO' }}
                                                · {{ $equipo->marca ?? '' }}
                                                {{ $equipo->modelo ?? '' }}
                                            </strong>
                                            <span class="font-monospace ms-2">{{ $equipo->num_serie ?? 'S/N' }}</span>
                                        </div>
                                        <span class="badge {{ $estadoEq === 'MALOGRADO' ? 'bg-danger' : ($estadoEq === 'REGULAR' ? 'bg-warning text-dark' : 'bg-success') }}">
                                            {{ $estadoEq ?: '—' }}
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="etiqueta">OBSERVACIÓN</div>
                                            <div class="{{ $prestamoEquipo->observacion ? 'fst-italic' : 'text-muted' }}">
                                                {{ $prestamoEquipo->observacion ?: 'Sin observaciones' }}
                                            </div>
                                        </div>

                                        @if ($prestamoEquipo->prestamoAccesorios->count())
                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Tipo</th>
                                                            <th>Marca</th>
                                                            <th>N.º serie</th>
                                                            <th>Estado</th>
                                                            <th>Observación</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($prestamoEquipo->prestamoAccesorios as $prestamoAccesorio)
                                                            @php
                $acc = $prestamoAccesorio->accesorioEquipo;
                $estadoAcc = strtoupper($prestamoAccesorio->estado ?? '');
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $acc->tipo ?? '—' }}</td>
                                                                <td>{{ $acc->marca ?? '—' }}</td>
                                                                <td class="font-monospace">{{ $acc->num_serie ?? '—' }}</td>
                                                                <td>
                                                                    <span class="badge {{ $estadoAcc === 'MALOGRADO' ? 'bg-danger' : ($estadoAcc === 'REGULAR' ? 'bg-warning text-dark' : 'bg-success') }}">
                                                                        {{ $estadoAcc ?: '—' }}
                                                                    </span>
                                                                </td>
                                                                <td class="{{ $prestamoAccesorio->observacion ? '' : 'text-muted' }}">
                                                                    {{ $prestamoAccesorio->observacion ?: 'Sin observaciones' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="text-muted">Este equipo no tiene accesorios registrados en el préstamo.</div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-warning">No hay equipos asociados a este préstamo.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <style>
            .etiqueta {
                font-size: .75rem;
                letter-spacing: .04em;
                text-transform: uppercase;
                color: #6c757d;
                font-weight: 600;
            }

            .valor {
                font-weight: 700;
                font-size: 1.05rem;
            }

            .subvalor {
                color: #6c757d;
            }

            .bloque-dato {
                background: #f8f9fa;
                border-radius: .5rem;
                padding: .75rem 1rem;
                height: 100%;
            }

            .chip {
                background: #e9ecef;
                border-radius: 999px;
                padding: .25rem .75rem;
                font-size: .85rem;
            }

            .chip-alerta {
                background: #f8d7da;
                color: #842029;
            }

            .tarjeta-equipo {
                border-left-width: 6px;
            }

            .borde-bueno {
                border-left-color: #198754;
            }

            .borde-regular {
                border-left-color: #ffc107;
            }

            .borde-malogrado {
                border-left-color: #dc3545;
            }

            .borde-neutro {
                border-left-color: #adb5bd;
            }

            @media print {

                #sidebar,
                .dot-spinner-container,
                .no-print,
                .btn,
                .dropdown,
                footer {
                    display: none !important;
                }

                #content-wrapper,
                main {
                    margin: 0 !important;
                    padding: 0 !important;
                    width: 100% !important;
                }

                body {
                    background: white !important;
                }

                .card {
                    border: 1px solid #000 !important;
                    box-shadow: none !important;
                }

                * {
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }
            }
        </style>
@endsection