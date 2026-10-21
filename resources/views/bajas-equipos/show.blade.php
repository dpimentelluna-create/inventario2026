@extends('layouts.app')

@section('template_title')
    Detalle de baja administrativa
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-xl-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h5 class="mb-1 fw-bold">
                                <i class="bi bi-archive me-2 text-success"></i>
                                DETALLE DE BAJA ADMINISTRATIVA
                            </h5>
                            <small class="text-muted">
                                Registro #{{ $baja->id }}
                            </small>
                        </div>

                        <span class="badge bg-danger fs-6">DE_BAJA</span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="alert alert-warning">
                        Este registro documenta la salida administrativa del equipo.
                        El equipo permanece guardado en el inventario histórico.
                    </div>

                    <h6 class="fw-bold mb-3">INFORMACIÓN DEL EQUIPO</h6>

                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <small class="text-muted d-block">Identificador</small>
                            <strong>ID {{ $baja->equipo_id }}</strong>
                        </div>

                        <div class="col-12 col-md-6">
                            <small class="text-muted d-block">Tipo de equipo</small>
                            <strong>{{ $baja->equipo->tipoEquipo->nombre ?? 'SIN TIPO' }}</strong>
                        </div>

                        <div class="col-12 col-md-6">
                            <small class="text-muted d-block">Marca y modelo</small>
                            <strong>
                                {{ $baja->equipo->marca ?? '—' }}
                                {{ $baja->equipo->modelo ?? '' }}
                            </strong>
                        </div>

                        <div class="col-12 col-md-6">
                            <small class="text-muted d-block">Número de serie</small>
                            <strong>{{ $baja->equipo->num_serie ?: 'NO REGISTRADO' }}</strong>
                        </div>

                        <div class="col-12 col-md-6">
                            <small class="text-muted d-block">Ubicación registrada</small>
                            <strong>
                                {{ $baja->equipo->ubicacione->nombre ?? 'NO REGISTRADA' }}
                            </strong>
                        </div>

                        <div class="col-12 col-md-6">
                            <small class="text-muted d-block">Situación administrativa</small>
                            <strong>{{ $baja->equipo->situacion_administrativa }}</strong>
                        </div>
                    </div>

                    <hr>

                    <h6 class="fw-bold mb-3">DATOS DE LA SALIDA</h6>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <small class="text-muted d-block">Fecha</small>
                            <strong>{{ $baja->fecha?->format('d/m/Y') }}</strong>
                        </div>

                        <div class="col-12 col-md-6">
                            <small class="text-muted d-block">Destino</small>
                            <strong>{{ $baja->destino }}</strong>
                        </div>

                        <div class="col-12 col-md-6">
                            <small class="text-muted d-block">Quién entrega</small>
                            <strong>{{ $baja->quien_entrego }}</strong>
                        </div>

                        <div class="col-12 col-md-6">
                            <small class="text-muted d-block">Quién recibe</small>
                            <strong>{{ $baja->quien_recibio }}</strong>
                        </div>

                        <div class="col-12">
                            <small class="text-muted d-block">Observaciones</small>
                            <div class="border rounded p-3 bg-light">
                                {{ $baja->observaciones ?: 'Sin observaciones.' }}
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('bajas-equipos.index') }}"
                           class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>
                            VOLVER AL HISTORIAL
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection