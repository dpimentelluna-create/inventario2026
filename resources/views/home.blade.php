@extends('layouts.app')

@section('content')
<div class="container-fluid px-2">

    <!-- Encabezado con Icono y Título -->
    <div class="d-flex align-items-center mb-4">
        <div class="me-3 text-primary" style="width: 32px; height: 32px; min-width: 32px; min-height: 32px;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:32px; height:32px; min-width:32px; min-height:32px;">
                <path d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
        </div>
        <div>
            <h1 class="h3 fw-bold mb-0">Panel de Control (Inicio)</h1>
            <p class="text-secondary small mb-0">Resumen general del estado de los equipos e inventario institucional.</p>
        </div>
    </div>

    <!-- 4 Tarjetas Superiores (KPIs) -->
    <div class="row g-4 mb-4">
        
        <!-- Total Equipos -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="p-4 rounded-3 h-100 shadow-sm border">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-uppercase small fw-bold text-secondary" style="letter-spacing: 0.5px;">TOTAL EQUIPOS</span>
                    <span class="rounded-circle d-inline-block" style="width: 28px; height: 28px; background-color: #2563eb;"></span>
                </div>
                <div class="h1 fw-bold mb-2">2</div>
                <div class="small text-secondary">
                    <span class="text-primary fw-bold">&rarr;</span> Registrados en el sistema
                </div>
            </div>
        </div>

        <!-- Equipos Operativos -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="p-4 rounded-3 h-100 shadow-sm border">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-uppercase small fw-bold text-secondary" style="letter-spacing: 0.5px;">EQUIPOS OPERATIVOS</span>
                    <span class="rounded-circle d-inline-block" style="width: 28px; height: 28px; background-color: #10b981;"></span>
                </div>
                <div class="h1 fw-bold text-success mb-2">1</div>
                <div class="small text-secondary">
                    <span class="text-success fw-bold">&check;</span> En buen estado y disponibles
                </div>
            </div>
        </div>

        <!-- Malogrados / Averiados -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="p-4 rounded-3 h-100 shadow-sm border">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-uppercase small fw-bold text-secondary" style="letter-spacing: 0.5px;">MALOGRADOS / AVERIADOS</span>
                    <span class="rounded-circle d-inline-block" style="width: 28px; height: 28px; background-color: #e11d48;"></span>
                </div>
                <div class="h1 fw-bold text-danger mb-2">1</div>
                <div class="small text-secondary">
                    <span class="text-danger fw-bold">&#128295;</span> Requieren atención técnica
                </div>
            </div>
        </div>

        <!-- Préstamos Activos -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="p-4 rounded-3 h-100 shadow-sm border">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-uppercase small fw-bold text-secondary" style="letter-spacing: 0.5px;">PRÉSTAMOS ACTIVOS</span>
                    <span class="rounded-circle d-inline-block" style="width: 28px; height: 28px; background-color: #f59e0b;"></span>
                </div>
                <div class="h1 fw-bold text-warning mb-2">3</div>
                <div class="small text-secondary">
                    <span class="text-warning fw-bold">&#128336;</span> Equipos actualmente prestados
                </div>
            </div>
        </div>

    </div>

    <!-- Sección Inferior: Acceso Rápido e Información -->
    <div class="row g-4">
        
        <!-- Bloque Izquierdo: Acceso Rápido -->
        <div class="col-12 col-lg-7">
            <div class="p-4 rounded-3 h-100 shadow-sm border">
                <div class="d-flex align-items-center mb-4">
                    <span class="me-2 text-warning">⚡</span>
                    <h2 class="h5 fw-bold mb-0">Acceso Rápido</h2>
                </div>

                <div class="row g-3">
                    <!-- Tarjeta Préstamos -->
                    <div class="col-12 col-sm-6">
                        <div class="d-flex align-items-center p-3 rounded-3 h-100 border shadow-sm">
                            <div class="rounded-3 d-flex align-items-center justify-content-center me-3 flex-shrink-0 text-white" style="width: 48px; height: 48px; min-width: 48px; min-height: 48px; background-color: #2563eb;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:24px; height:24px; min-width:24px; min-height:24px;">
                                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="fw-bold small">Préstamos</div>
                                <div class="text-secondary mt-1" style="font-size: 0.75rem;">Registrar salidas o devoluciones de equipos.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta Equipos -->
                    <div class="col-12 col-sm-6">
                        <div class="d-flex align-items-center p-3 rounded-3 h-100 border shadow-sm">
                            <div class="rounded-3 d-flex align-items-center justify-content-center me-3 flex-shrink-0 text-white" style="width: 48px; height: 48px; min-width: 48px; min-height: 48px; background-color: #059669;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:24px; height:24px; min-width:24px; min-height:24px;">
                                    <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="fw-bold small">Equipos</div>
                                <div class="text-secondary mt-1" style="font-size: 0.75rem;">Ver listado de máquinas y estados.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bloque Derecho: Información -->
        <div class="col-12 col-lg-5">
            <div class="p-4 rounded-3 h-100 d-flex flex-column justify-content-between shadow-sm border">
                <div>
                    <div class="d-flex align-items-center mb-3">
                        <span class="me-2 text-primary">ⓘ</span>
                        <h2 class="h5 fw-bold mb-0">Información</h2>
                    </div>
                    <p class="text-secondary small leading-relaxed mb-4">
                        Bienvenido al sistema de control de inventario y préstamos. Utilice la barra lateral izquierda para navegar rápidamente entre los diferentes módulos y mantener el registro actualizado.
                    </p>
                </div>

                <!-- Cuadro de sesión -->
                <div class="p-3 rounded-3 d-flex align-items-center shadow-sm border">
                    <div class="me-3 flex-shrink-0 text-success" style="width: 20px; height: 20px; min-width: 20px; min-height: 20px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:20px; height:20px; min-width:20px; min-height:20px;">
                            <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <span class="text-secondary small">
                        Sesión iniciada correctamente como <strong class="fw-bold">Usuario</strong>.
                    </span>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection