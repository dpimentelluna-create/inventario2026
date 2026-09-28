@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- TÍTULO DE BIENVENIDA -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 fw-bold mb-1">
                <i class="bi bi-speedometer2 me-2 text-primary"></i> Panel de Control (Inicio)
            </h1>
            <p class="text-muted">Resumen general del estado de los equipos e inventario institucional.</p>
        </div>
    </div>

    <!-- TARJETAS ESTADÍSTICAS PRINCIPALES -->
    <div class="row g-4 mb-4">
        <!-- Total Equipos -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="text-uppercase text-muted fw-semibold mb-0 small">Total Equipos</h6>
                        <div class="p-2 bg-primary bg-opacity-15 rounded-circle text-primary fs-4 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-laptop"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-1">{{ $totalEquipos ?? 0 }}</h2>
                    <p class="text-muted small mb-0"><i class="bi bi-arrow-right text-primary me-1"></i> Registrados en el sistema</p>
                </div>
            </div>
        </div>

        <!-- Equipos Operativos -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="text-uppercase text-muted fw-semibold mb-0 small">Equipos Operativos</h6>
                        <div class="p-2 bg-success bg-opacity-15 rounded-circle text-success fs-4 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-1 text-success">{{ $equiposBuenos ?? 0 }}</h2>
                    <p class="text-muted small mb-0"><i class="bi bi-check text-success me-1"></i> En buen estado y disponibles</p>
                </div>
            </div>
        </div>

        <!-- Malogrados / Averiados -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="text-uppercase text-muted fw-semibold mb-0 small">Malogrados / Averiados</h6>
                        <div class="p-2 bg-danger bg-opacity-15 rounded-circle text-danger fs-4 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-1 text-danger">{{ $equiposMalogrados ?? 0 }}</h2>
                    <p class="text-muted small mb-0"><i class="bi bi-tools text-danger me-1"></i> Requieren atención técnica</p>
                </div>
            </div>
        </div>

        <!-- Préstamos Activos -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="text-uppercase text-muted fw-semibold mb-0 small">Préstamos Activos</h6>
                        <div class="p-2 bg-warning bg-opacity-15 rounded-circle text-warning fs-4 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-journal-arrow-up"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-1 text-warning">{{ $prestamosActivos ?? 0 }}</h2>
                    <p class="text-muted small mb-0"><i class="bi bi-clock text-warning me-1"></i> Equipos actualmente prestados</p>
                </div>
            </div>
        </div>
    </div>

    <!-- SECCIÓN DE ACCESO RÁPIDO E INFORMACIÓN -->
    <div class="row g-4">
        <!-- Acceso Rápido -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-lightning-charge text-warning me-2"></i> Acceso Rápido</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('prestamos.index') ?? '#' }}" class="card text-decoration-none border shadow-sm h-100 action-card">
                                <div class="card-body d-flex align-items-center p-3">
                                    <div class="p-3 bg-primary text-white rounded me-3 fs-4">
                                        <i class="bi bi-journal-check"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1">Préstamos</h6>
                                        <p class="text-muted small mb-0">Registrar salidas o devoluciones de equipos.</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('equipos.index') ?? '#' }}" class="card text-decoration-none border shadow-sm h-100 action-card">
                                <div class="card-body d-flex align-items-center p-3">
                                    <div class="p-3 bg-success text-white rounded me-3 fs-4">
                                        <i class="bi bi-laptop"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1">Equipos</h6>
                                        <p class="text-muted small mb-0">Ver listado de máquinas y estados.</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Información -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-info-circle text-primary me-2"></i> Información</h5>
                </div>
                <div class="card-body px-4 pb-4 d-flex flex-column justify-content-between">
                    <p class="text-muted small">
                        Bienvenido al sistema de control de inventario y préstamos. Utilice la barra lateral izquierda para navegar rápidamente entre los diferentes módulos y mantener el registro actualizado.
                    </p>
                    <div class="p-3 bg-light rounded border-0 mt-3">
                        <div class="d-flex align-items-center text-muted small">
                            <i class="bi bi-shield-check text-success me-2 fs-5"></i>
                            <span>Sesión iniciada correctamente como <strong>Usuario</strong>.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection