<title>Ver Equipo</title>
@extends('layouts.app')

@section('template_title')
    Equipo {{ $equipo->num_serie }}
@endsection

@section('content')
@php
    $tipo = strtoupper($equipo->tipoEquipo->nombre ?? '');
    $esLaptop = $tipo === 'LAPTOP';
    $specLap = $equipo->especificacionesLaptops;
    $specEq = $equipo->especificacionesEquipo;
    $estado = strtoupper($esLaptop ? ($specLap->estado ?? '') : ($specEq->estado ?? ''));
    $borde = $estado === 'MALOGRADO' ? 'borde-malogrado' : ($estado === 'REGULAR' ? 'borde-regular' : ($estado === 'BUENO' ? 'borde-bueno' : 'borde-neutro'));
    $badge = $estado === 'MALOGRADO' ? 'bg-danger' : ($estado === 'REGULAR' ? 'bg-warning text-dark' : 'bg-success');
    $fechaVista = $equipo->fecha_registro
        ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('d-m-Y')
        : '—';
    $accesorios = $equipo->accesoriosEquipos;
    $malogrados = $accesorios->filter(fn ($a) => strtoupper($a->estado ?? '') === 'MALOGRADO')->count();
    if ($estado === 'MALOGRADO') $malogrados++;
@endphp

<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card tarjeta-equipo {{ $borde }}">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span class="card-title fw-bold">FICHA DEL EQUIPO</span>
                    <div class="d-flex gap-2 no-print">
                        <a href="{{ route('equipos.index') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-arrow-left"></i> Volver
                        </a>
                        <a href="{{ route('equipos.edit', $equipo->id) }}" class="btn btn-success btn-sm">
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
                                <div class="etiqueta"><i class="bi bi-pc-display"></i> EQUIPO</div>
                                <div class="valor">{{ $tipo ?: 'SIN TIPO' }}</div>
                                <div class="subvalor">{{ $equipo->marca ?? '—' }} {{ $equipo->modelo ?? '' }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bloque-dato">
                                <div class="etiqueta"><i class="bi bi-upc"></i> N.º SERIE</div>
                                <div class="valor font-monospace">{{ $equipo->num_serie ?? '—' }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bloque-dato">
                                <div class="etiqueta"><i class="bi bi-geo-alt"></i> UBICACIÓN</div>
                                <div class="valor">{{ $equipo->ubicacione->nombre ?? '—' }}</div>
                                <div class="subvalor">{{ $fechaVista }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bloque-dato text-md-end">
                                <div class="etiqueta">ESTADO</div>
                                @if ($estado)
                                    <span class="badge {{ $badge }} fs-6">{{ $estado }}</span>
                                @else
                                    <span class="valor">—</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="chip">{{ $esLaptop ? 'Laptop' : 'Equipo' }}</span>
                        <span class="chip">{{ $accesorios->count() }} accesorio{{ $accesorios->count() === 1 ? '' : 's' }}</span>
                        @if ($malogrados > 0)
                            <span class="chip chip-alerta">{{ $malogrados }} malogrado{{ $malogrados === 1 ? '' : 's' }}</span>
                        @endif
                    </div>

                    <div class="card mb-3">
                        <div class="card-header"><strong>ESPECIFICACIONES</strong></div>
                        <div class="card-body">
                            @if ($esLaptop && $specLap)
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="etiqueta">PROCESADOR</div>
                                        <div class="valor">{{ $specLap->procesador ?? '—' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="etiqueta">RAM</div>
                                        <div class="valor">{{ $specLap->ram ?? '—' }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="etiqueta">DISCO</div>
                                        <div class="valor">{{ $specLap->disco_duro ?? '—' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="etiqueta">COLOR</div>
                                        <div class="valor">{{ $specLap->color ?? '—' }}</div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="etiqueta">OBSERVACIONES</div>
                                        <div class="{{ $specLap->observaciones ? 'fst-italic' : 'text-muted' }}">
                                            {{ $specLap->observaciones ?: 'Sin observaciones' }}
                                        </div>
                                    </div>
                                </div>
                            @elseif ($specEq)
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <div class="etiqueta">DESCRIPCIÓN</div>
                                        <div class="valor">{{ $specEq->descripcion ?? '—' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="etiqueta">COLOR</div>
                                        <div class="valor">{{ $specEq->color ?? '—' }}</div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="etiqueta">OBSERVACIONES</div>
                                        <div class="{{ $specEq->observaciones ? 'fst-italic' : 'text-muted' }}">
                                            {{ $specEq->observaciones ?: 'Sin observaciones' }}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted mb-0">Sin especificaciones registradas.</p>
                            @endif
                        </div>
                    </div>

                    <h5 class="mb-3">ACCESORIOS</h5>
                    @if ($accesorios->count())
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
                                    @foreach ($accesorios as $acc)
                                        @php $estA = strtoupper($acc->estado ?? 'REGULAR'); @endphp
                                        <tr>
                                            <td>{{ $acc->tipo ?? '—' }}</td>
                                            <td>{{ $acc->marca ?? '—' }}</td>
                                            <td class="font-monospace">{{ $acc->num_serie ?? '—' }}</td>
                                            <td>
                                                <span class="badge {{ $estA === 'MALOGRADO' ? 'bg-danger' : ($estA === 'REGULAR' ? 'bg-warning text-dark' : 'bg-success') }}">
                                                    {{ $estA }}
                                                </span>
                                            </td>
                                            <td class="{{ $acc->observaciones ? '' : 'text-muted' }}">
                                                {{ $acc->observaciones ?: 'Sin observaciones' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">Este equipo no tiene accesorios.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .etiqueta { font-size: .75rem; letter-spacing: .04em; text-transform: uppercase; color: #6c757d; font-weight: 600; }
    .valor { font-weight: 700; font-size: 1.05rem; }
    .subvalor { color: #6c757d; }
    .bloque-dato { background: #f8f9fa; border-radius: .5rem; padding: .75rem 1rem; height: 100%; }
    .chip { background: #e9ecef; border-radius: 999px; padding: .25rem .75rem; font-size: .85rem; }
    .chip-alerta { background: #f8d7da; color: #842029; }
    .tarjeta-equipo { border-left-width: 6px; }
    .borde-bueno { border-left-color: #198754; }
    .borde-regular { border-left-color: #ffc107; }
    .borde-malogrado { border-left-color: #dc3545; }
    .borde-neutro { border-left-color: #adb5bd; }
    @media print {
        #sidebar, .dot-spinner-container, .no-print, .btn, .dropdown, footer { display: none !important; }
        #content-wrapper, main { margin: 0 !important; padding: 0 !important; width: 100% !important; }
        body { background: white !important; }
        .card { border: 1px solid #000 !important; box-shadow: none !important; }
        * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }
</style>
@endsection