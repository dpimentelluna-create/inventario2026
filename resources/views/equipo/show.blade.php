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
    $badge = $estado === 'BUENO' ? 'success' : ($estado === 'MALOGRADO' ? 'danger' : 'warning');
@endphp

<section class="content container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <div class="text-muted small">FICHA DEL EQUIPO</div>
                    <h3 class="mb-0 fw-bold">{{ $tipo ?: 'SIN TIPO' }} · {{ $equipo->num_serie ?? 'S/N' }}</h3>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('equipos.edit', $equipo->id) }}" class="btn btn-warning btn-sm">
                        <i class="fa-solid fa-pen-to-square"></i> EDITAR
                    </a>
                    <a href="{{ route('equipos.index') }}" class="btn btn-secondary btn-sm">ATRÁS</a>
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-header encabezado-verde">
                    <strong><i class="bi bi-pc-display"></i> IDENTIFICACIÓN</strong>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <div class="dato-label">MARCA</div>
                            <div class="dato-valor">{{ $equipo->marca ?? '—' }}</div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="dato-label">MODELO</div>
                            <div class="dato-valor">{{ $equipo->modelo ?? '—' }}</div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="dato-label">N.º SERIE</div>
                            <div class="dato-valor">{{ $equipo->num_serie ?? '—' }}</div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="dato-label">UBICACIÓN</div>
                            <div class="dato-valor">{{ $equipo->ubicacione->nombre ?? '—' }}</div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="dato-label">FECHA REGISTRO</div>
                            <div class="dato-valor">
                                {{ $equipo->fecha_registro ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('d-m-Y') : '—' }}
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="dato-label">ESTADO</div>
                            <div>
                                @if ($estado)
                                    <span class="badge bg-{{ $badge }}">{{ $estado }}</span>
                                @else
                                    —
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-header encabezado-verde">
                    <strong><i class="bi bi-cpu"></i> ESPECIFICACIONES</strong>
                </div>
                <div class="card-body">
                    @if ($esLaptop && $specLap)
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="dato-label">PROCESADOR</div>
                                <div class="dato-valor">{{ $specLap->procesador ?? '—' }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="dato-label">RAM</div>
                                <div class="dato-valor">{{ $specLap->ram ?? '—' }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="dato-label">DISCO</div>
                                <div class="dato-valor">{{ $specLap->disco_duro ?? '—' }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="dato-label">COLOR</div>
                                <div class="dato-valor">{{ $specLap->color ?? '—' }}</div>
                            </div>
                            <div class="col-md-8">
                                <div class="dato-label">OBSERVACIONES</div>
                                <div class="dato-valor">{{ $specLap->observaciones ?: '—' }}</div>
                            </div>
                        </div>
                    @elseif ($specEq)
                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="dato-label">DESCRIPCIÓN</div>
                                <div class="dato-valor">{{ $specEq->descripcion ?? '—' }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="dato-label">COLOR</div>
                                <div class="dato-valor">{{ $specEq->color ?? '—' }}</div>
                            </div>
                            <div class="col-md-12">
                                <div class="dato-label">OBSERVACIONES</div>
                                <div class="dato-valor">{{ $specEq->observaciones ?: '—' }}</div>
                            </div>
                        </div>
                    @else
                        <p class="text-muted mb-0">Sin especificaciones registradas.</p>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-header encabezado-verde d-flex justify-content-between">
                    <strong><i class="bi bi-tools"></i> ACCESORIOS</strong>
                    <span class="badge bg-dark">{{ $equipo->accesoriosEquipos->count() }}</span>
                </div>
                <div class="card-body">
                    @forelse ($equipo->accesoriosEquipos as $acc)
                        @php $estA = strtoupper($acc->estado ?? 'REGULAR'); @endphp
                        <div class="d-flex justify-content-between align-items-start border rounded p-2 mb-2">
                            <div>
                                <strong>{{ $acc->tipo }}</strong>
                                <div class="small text-muted">
                                    {{ $acc->marca ?? '' }}
                                    @if ($acc->num_serie) · N/S {{ $acc->num_serie }} @endif
                                </div>
                                @if ($acc->observaciones)
                                    <div class="small">{{ $acc->observaciones }}</div>
                                @endif
                            </div>
                            <span class="badge bg-{{ $estA === 'BUENO' ? 'success' : ($estA === 'MALOGRADO' ? 'danger' : 'warning') }}">
                                {{ $estA }}
                            </span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Este equipo no tiene accesorios.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

<style>
    .encabezado-verde {
        background-color: #90EE90 !important;
        color: #000;
        border-bottom: 1px solid #000;
    }
    .dato-label {
        font-size: 11px;
        letter-spacing: .04em;
        color: #198754;
        font-weight: 700;
    }
    .dato-valor {
        font-size: 1rem;
        font-weight: 600;
    }
    .card { border: 1px solid #000; border-radius: 6px; overflow: hidden; }
</style>
