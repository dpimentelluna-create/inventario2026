@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3 home-container-dark">

    <!-- CABECERA DEL PANEL -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark dark:text-white mb-1">
                <i class="fa-solid fa-chart-pie me-2 text-success"></i>PANEL DE CONTROL
            </h2>
            <p class="text-muted mb-0">Resumen general del estado de los equipos y del inventario institucional.</p>
        </div>
        <div>
            <!-- Botón de Modo Oscuro / Claro directo que llama a tu función global -->
            <button onclick="toggleThemeDirecto()" class="btn btn-outline-secondary d-flex align-items-center px-3 py-2 shadow-sm" id="themeToggleBtn">
                <i id="themeIcon" class="fas fa-moon me-2"></i>
                <span id="themeText">Modo Oscuro</span>
            </button>
        </div>
    </div>

    <!-- TARJETAS SUPERIORES -->
    <div class="row g-3 mb-4">
        <!-- TOTAL EQUIPOS -->
        <div class="col-md-4 col-lg">
            <div class="card border-0 shadow-sm h-100 dark-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small fw-bold text-uppercase">TOTAL EQUIPOS</span>
                        <i class="bi bi-laptop text-primary fs-5"></i>
                    </div>
                    <h3 class="fw-bold mb-2">0</h3>
                    <a href="{{ route('equipos.index') }}" class="small text-decoration-none fw-semibold text-primary">Ver todos los equipos <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- EN BUEN ESTADO -->
        <div class="col-md-4 col-lg">
            <div class="card border-0 shadow-sm h-100 dark-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small fw-bold text-uppercase">EN BUEN ESTADO</span>
                        <i class="bi bi-check-circle text-success fs-5"></i>
                    </div>
                    <h3 class="fw-bold mb-2">0</h3>
                    <a href="{{ route('equipos.index') }}" class="small text-decoration-none fw-semibold text-success">Ver equipos BUENOS <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- ESTADO REGULAR -->
        <div class="col-md-4 col-lg">
            <div class="card border-0 shadow-sm h-100 dark-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small fw-bold text-uppercase">ESTADO REGULAR</span>
                        <i class="bi bi-exclamation-triangle text-warning fs-5"></i>
                    </div>
                    <h3 class="fw-bold mb-2">0</h3>
                    <a href="{{ route('equipos.index') }}" class="small text-decoration-none fw-semibold text-warning">Ver equipos REGULARES <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- EQUIPOS MALOGRADOS -->
        <div class="col-md-4 col-lg">
            <div class="card border-0 shadow-sm h-100 dark-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small fw-bold text-uppercase">EQUIPOS MALOGRADOS</span>
                        <i class="bi bi-x-circle text-danger fs-5"></i>
                    </div>
                    <h3 class="fw-bold mb-2">0</h3>
                    <a href="{{ route('equipos.index') }}" class="small text-decoration-none fw-semibold text-danger">Ver equipos MALOGRADOS <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- PRÉSTAMOS ACTIVOS -->
        <div class="col-md-4 col-lg">
            <div class="card border-0 shadow-sm h-100 dark-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small fw-bold text-uppercase">PRÉSTAMOS ACTIVOS</span>
                        <i class="bi bi-journal-check text-info fs-5"></i>
                    </div>
                    <h3 class="fw-bold mb-2">0</h3>
                    <a href="{{ route('prestamos.index') }}" class="small text-decoration-none fw-semibold text-info">Ver préstamos ACTIVOS <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- SEGUNDA FILA: EQUIPOS SIN CLASIFICAR Y UBICACIONES -->
    <div class="row g-3 mb-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100 dark-card">
                <div class="card-body">
                    <span class="text-muted small fw-bold text-uppercase d-block mb-2">EQUIPOS SIN CLASIFICAR</span>
                    <h3 class="fw-bold mb-2">0</h3>
                    <p class="text-muted small mb-0">Equipos sin un estado reconocido en las especificaciones.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100 dark-card">
                <div class="card-body">
                    <span class="text-muted small fw-bold text-uppercase d-block mb-2">UBICACIONES REGISTRADAS</span>
                    <h3 class="fw-bold mb-2">0</h3>
                    <a href="{{ route('ubicaciones.index') }}" class="small text-decoration-none fw-semibold text-success">Consultar ubicaciones <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- TERCERA FILA: TABLAS INFERIORES -->
    <div class="row g-3">
        <!-- EQUIPOS POR TIPO -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm dark-card">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">
                    <span class="fw-bold"><i class="bi bi-laptop me-2"></i> EQUIPOS POR TIPO</span>
                    <a href="{{ route('tipos-equipo.index') }}" class="btn btn-sm btn-outline-success">VER TIPOS</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle dark-table">
                            <thead>
                                <tr>
                                    <th>TIPO</th>
                                    <th>TOTAL</th>
                                    <th>BUENOS</th>
                                    <th>REGULARES</th>
                                    <th>MALOGRADOS</th>
                                    <th>DETALLE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No hay tipos de equipos registrados.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- EQUIPOS POR UBICACIÓN -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm dark-card">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">
                    <span class="fw-bold"><i class="bi bi-geo-alt me-2"></i> EQUIPOS POR UBICACIÓN</span>
                    <a href="{{ route('ubicaciones.index') }}" class="btn btn-sm btn-outline-success">VER UBICACIONES</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle dark-table">
                            <thead>
                                <tr>
                                    <th>UBICACIÓN</th>
                                    <th>TIPO</th>
                                    <th>TOTAL</th>
                                    <th>BUENOS</th>
                                    <th>MALOGRADOS</th>
                                    <th>DETALLE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No hay ubicaciones registradas.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- ESTILOS CSS LOCALES PARA FORZAR EL MODO NEGRO PURO EN ESTA VISTA -->
<style>
    [data-bs-theme="dark"] .home-container-dark {
        background-color: #000000 !important;
        color: #ffffff !important;
    }

    [data-bs-theme="dark"] .dark-card {
        background-color: #000000 !important;
        border: 1px solid #1f2937 !important;
        color: #ffffff !important;
    }

    [data-bs-theme="dark"] .dark-card h2,
    [data-bs-theme="dark"] .dark-card h3,
    [data-bs-theme="dark"] .dark-card h4,
    [data-bs-theme="dark"] .dark-card h5,
    [data-bs-theme="dark"] .dark-card span:not(.badge),
    [data-bs-theme="dark"] .dark-card p {
        color: #ffffff !important;
    }

    [data-bs-theme="dark"] .dark-table {
        background-color: #000000 !important;
        color: #ffffff !important;
        border-color: #1f2937 !important;
    }

    [data-bs-theme="dark"] .dark-table th,
    [data-bs-theme="dark"] .dark-table td {
        background-color: #000000 !important;
        color: #ffffff !important;
        border-color: #1f2937 !important;
    }
</style>
@endsection