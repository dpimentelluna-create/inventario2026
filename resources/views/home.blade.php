 @extends('layouts.app')

@section('content')
<style>
    .dashboard-titulo {
        color: #212529;
        font-weight: 700;
    }

    .dashboard-subtitulo {
        color: #6c757d;
    }

    .dashboard-tarjeta {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, .06);
        height: 100%;
        color: #212529;
        text-decoration: none;
        display: block;
        transition: border-color .2s, box-shadow .2s;
    }

    .dashboard-tarjeta:hover {
        border-color: #198754;
        box-shadow: 0 4px 10px rgba(0, 0, 0, .10);
        color: #212529;
    }

    .dashboard-cabecera {
        background: #90ee90;
        color: #212529;
        font-weight: 700;
        padding: 13px 16px;
        border-bottom: 1px solid #c8e6c9;
    }

    .dashboard-numero {
        font-size: 2rem;
        line-height: 1.2;
        font-weight: 700;
        margin: 12px 0;
    }

    .dashboard-etiqueta {
        color: #495057;
        font-size: .82rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .dashboard-tabla th {
        background: #e9f7e9;
        color: #212529;
        white-space: nowrap;
        font-size: .8rem;
    }

    .dashboard-tabla td {
        vertical-align: middle;
        font-size: .9rem;
    }

    .dashboard-info-fila {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 9px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .dashboard-info-fila:last-child {
        border-bottom: 0;
    }

    .dashboard-info-fila span:first-child {
        color: #495057;
    }

    .dashboard-info-fila strong {
        color: #212529;
        white-space: nowrap;
    }

    @media (max-width: 576px) {
        .dashboard-numero {
            font-size: 1.7rem;
        }
    }
</style>

<div class="container-fluid py-4">

    {{-- ENCABEZADO --}}
    <div class="mb-4">
        <h1 class="dashboard-titulo h3 mb-1">
            <i class="fas fa-chart-pie text-success me-2"></i>
            PANEL DE CONTROL
        </h1>
        <p class="dashboard-subtitulo mb-0">
            Resumen general del estado de los equipos y del inventario institucional.
        </p>
    </div>

    {{-- TARJETAS PRINCIPALES --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl">
            <a href="{{ route('equipos.index', ['desde_dashboard' => 1]) }}"
               class="dashboard-tarjeta p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="dashboard-etiqueta">Total equipos</span>
                    <i class="fas fa-laptop text-primary"></i>
                </div>
                <div class="dashboard-numero">{{ number_format($totalEquipos) }}</div>
                <span class="small text-primary">Ver todos los equipos <i class="fas fa-arrow-right"></i></span>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <a href="{{ route('equipos.index', ['estado' => 'BUENO', 'desde_dashboard' => 1]) }}"
               class="dashboard-tarjeta p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="dashboard-etiqueta">En buen estado</span>
                    <i class="fas fa-check-circle text-success"></i>
                </div>
                <div class="dashboard-numero text-success">{{ number_format($equiposBuenos) }}</div>
                <span class="small text-success">Ver equipos BUENOS <i class="fas fa-arrow-right"></i></span>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <a href="{{ route('equipos.index', ['estado' => 'REGULAR', 'desde_dashboard' => 1]) }}"
               class="dashboard-tarjeta p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="dashboard-etiqueta">Estado regular</span>
                    <i class="fas fa-exclamation-circle text-warning"></i>
                </div>
                <div class="dashboard-numero text-warning">{{ number_format($equiposRegulares) }}</div>
                <span class="small text-warning">Ver equipos REGULARES <i class="fas fa-arrow-right"></i></span>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <a href="{{ route('equipos.index', ['estado' => 'MALOGRADO', 'desde_dashboard' => 1]) }}"
               class="dashboard-tarjeta p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="dashboard-etiqueta">Equipos malogrados</span>
                    <i class="fas fa-times-circle text-danger"></i>
                </div>
                <div class="dashboard-numero text-danger">{{ number_format($equiposMalogrados) }}</div>
                <span class="small text-danger">Ver equipos MALOGRADOS <i class="fas fa-arrow-right"></i></span>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <a href="{{ route('prestamos.index', ['estado' => 'ACTIVO', 'desde_dashboard' => 1]) }}"
               class="dashboard-tarjeta p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="dashboard-etiqueta">Préstamos activos</span>
                    <i class="fas fa-clipboard-list text-warning"></i>
                </div>
                <div class="dashboard-numero text-warning">{{ number_format($prestamosActivos) }}</div>
                <span class="small text-warning">Ver préstamos ACTIVOS <i class="fas fa-arrow-right"></i></span>
            </a>
        </div>

    </div>

    {{-- RESUMEN ADICIONAL --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6">
            <div class="dashboard-tarjeta p-3">
                <div class="dashboard-etiqueta">Equipos sin clasificar</div>
                <div class="dashboard-numero">{{ number_format($equiposSinClasificar) }}</div>
                <p class="dashboard-subtitulo small mb-0">
                    Equipos sin un estado reconocido en las especificaciones.
                </p>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <a href="{{ route('ubicaciones.index') }}" class="dashboard-tarjeta p-3">
                <div class="dashboard-etiqueta">Ubicaciones registradas</div>
                <div class="dashboard-numero">{{ number_format($totalUbicaciones) }}</div>
                <span class="small text-success">Consultar ubicaciones <i class="fas fa-arrow-right"></i></span>
            </a>
        </div>
    </div>

    {{-- TABLAS DE CONSULTA RÁPIDA --}}
    <div class="row g-4 mb-4">

        {{-- EQUIPOS POR TIPO --}}
        <div class="col-12 col-xl-6">
            <div class="dashboard-tarjeta overflow-hidden">
                <div class="dashboard-cabecera d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span><i class="fas fa-laptop me-2"></i>EQUIPOS POR TIPO</span>
                    <a href="{{ route('tipos-equipo.index') }}" class="btn btn-sm btn-outline-dark">
                        VER TIPOS
                    </a>
                </div>

                <div class="table-responsive p-2">
                    <table id = "tabla_equipos_tipo" class="table table-bordered table-hover dashboard-tabla mb-0">
                        <thead>
                            <tr>
                                <th>TIPO</th>
                                <th class="text-center">TOTAL</th>
                                <th class="text-center">BUENOS</th>
                                <th class="text-center">REGULARES</th>
                                <th class="text-center">MALOGRADOS</th>
                                <th class="text-center">DETALLE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tiposEquipoResumen as $tipo)
                                <tr class="{{ $loop->index >= 3 ? 'dashboard-fila-oculta' : '' }}"
                                        data-dashboard-extra="{{ $loop->index >= 3 ? '1' : '0' }}">
                                    <td>{{ $tipo->nombre }}</td>
                                    <td class="text-center fw-bold">{{ $tipo->total }}</td>
                                    <td class="text-center text-success fw-bold">{{ $tipo->buenos }}</td>
                                    <td class="text-center text-warning fw-bold">{{ $tipo->regulares }}</td>
                                    <td class="text-center text-danger fw-bold">{{ $tipo->malogrados }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('tipos-equipo.show', $tipo->id) }}"
                                           class="btn btn-sm btn-outline-secondary">
                                            VER
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No hay tipos de equipos registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($tiposEquipoResumen->count() > 3)
    <div class="text-center px-3 pb-3">
        <button type="button"
                class="btn btn-sm btn-outline-success"
                onclick="alternarFilasDashboard('tabla_equipos_tipo', this)"
                aria-expanded="false">
            VER MÁS <i class="fas fa-chevron-down ms-1"></i>
        </button>
    </div>
@endif
            </div>
        </div>

        {{-- EQUIPOS POR UBICACIÓN --}}
        <div class="col-12 col-xl-6">
            <div class="dashboard-tarjeta overflow-hidden">
                <div class="dashboard-cabecera d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span><i class="fas fa-map-marker-alt me-2"></i>EQUIPOS POR UBICACIÓN</span>
                    <a href="{{ route('ubicaciones.index') }}" class="btn btn-sm btn-outline-dark">
                        VER UBICACIONES
                    </a>
                </div>

                <div class="table-responsive p-2">
                    <table id = "tabla_equipos_ubicacion" class="table table-bordered table-hover dashboard-tabla mb-0">
                        <thead>
                            <tr>
                                <th>UBICACIÓN</th>
                                <th>TIPO</th>
                                <th class="text-center">TOTAL</th>
                                <th class="text-center">BUENOS</th>
                                <th class="text-center">MALOGRADOS</th>
                                <th class="text-center">DETALLE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ubicacionesResumen as $ubicacion)
                                <tr class="{{ $loop->index >= 3 ? 'dashboard-fila-oculta' : '' }}"
                                    data-dashboard-extra="{{ $loop->index >= 3 ? '1' : '0' }}">
                                    <td>{{ $ubicacion->nombre }}</td>
                                    <td>{{ $ubicacion->tipo ?: '-' }}</td>
                                    <td class="text-center fw-bold">{{ $ubicacion->total }}</td>
                                    <td class="text-center text-success fw-bold">{{ $ubicacion->buenos }}</td>
                                    <td class="text-center text-danger fw-bold">{{ $ubicacion->malogrados }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('ubicaciones.show', $ubicacion->id) }}"
                                           class="btn btn-sm btn-outline-secondary">
                                            VER
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No hay ubicaciones registradas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if ($ubicacionesResumen->count() > 3)
    <div class="text-center px-3 pb-3">
        <button type="button"
                class="btn btn-sm btn-outline-success"
                onclick="alternarFilasDashboard('tabla_equipos_ubicacion', this)"
                aria-expanded="false">
            VER MÁS <i class="fas fa-chevron-down ms-1"></i>
        </button>
    </div>
@endif
                </div>
            </div>
        </div>

    </div>

    {{-- ACCESOS RÁPIDOS E INFORMACIÓN DEL SISTEMA --}}
    <div class="row g-4 align-items-stretch">

        {{-- ACCESO RÁPIDO A LOS MÓDULOS --}}
        <div class="col-12 col-lg-8">
            <div class="dashboard-tarjeta overflow-hidden">
                <div class="dashboard-cabecera">
                    <i class="fas fa-th-large me-2"></i>
                    ACCESO RÁPIDO A LOS MÓDULOS
                </div>

                <div class="p-3">
                    <p class="dashboard-subtitulo small mb-3">
                        Selecciona un módulo para acceder a sus funciones principales.
                    </p>

                    <div class="row g-3">

                        {{-- PRÉSTAMOS --}}
                        <div class="col-12 col-sm-6">
                            <a href="{{ route('prestamos.index') }}"
                               class="dashboard-modulo">
                                <div class="dashboard-modulo-icono">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <div class="dashboard-modulo-contenido">
                                    <div class="dashboard-modulo-titulo">
                                        PRÉSTAMOS
                                    </div>
                                    <p>
                                        Registra y consulta préstamos, controla su estado
                                        y revisa las entregas y devoluciones.
                                    </p>
                                    <span>INGRESAR <i class="fas fa-arrow-right ms-1"></i></span>
                                </div>
                            </a>
                        </div>

                        {{-- EQUIPOS --}}
                        <div class="col-12 col-sm-6">
                            <a href="{{ route('equipos.index', ['desde_dashboard' => 1]) }}"
                               class="dashboard-modulo">
                                <div class="dashboard-modulo-icono">
                                    <i class="fas fa-laptop"></i>
                                </div>
                                <div class="dashboard-modulo-contenido">
                                    <div class="dashboard-modulo-titulo">
                                        EQUIPOS
                                    </div>
                                    <p>
                                        Consulta los equipos registrados, sus características,
                                        estados y ubicaciones.
                                    </p>
                                    <span>INGRESAR <i class="fas fa-arrow-right ms-1"></i></span>
                                </div>
                            </a>
                        </div>

                        {{-- ACCESORIOS --}}
                        <div class="col-12 col-sm-6">
                            @if(Route::has('accesorios-equipo.index'))
                                <a href="{{ route('accesorios-equipo.index') }}"
                                   class="dashboard-modulo">
                            @elseif(Route::has('accesorios-equipos.index'))
                                <a href="{{ route('accesorios-equipos.index') }}"
                                   class="dashboard-modulo">
                            @elseif(Route::has('accesorios_equipo.index'))
                                <a href="{{ route('accesorios_equipo.index') }}"
                                   class="dashboard-modulo">
                            @else
                                <div class="dashboard-modulo dashboard-modulo-pendiente">
                            @endif
                                    <div class="dashboard-modulo-icono">
                                        <i class="fas fa-puzzle-piece"></i>
                                    </div>
                                    <div class="dashboard-modulo-contenido">
                                        <div class="dashboard-modulo-titulo">
                                            ACCESORIOS DE EQUIPO
                                        </div>
                                        <p>
                                            Administra cargadores, baterías, números de serie,
                                            estados y observaciones.
                                        </p>
                                        @if(
                                            Route::has('accesorios-equipo.index') ||
                                            Route::has('accesorios-equipos.index') ||
                                            Route::has('accesorios_equipo.index')
                                        )
                                            <span>INGRESAR <i class="fas fa-arrow-right ms-1"></i></span>
                                        @else
                                            <span class="text-muted">REVISAR RUTA DEL MÓDULO</span>
                                        @endif
                                    </div>
                            @if(
                                Route::has('accesorios-equipo.index') ||
                                Route::has('accesorios-equipos.index') ||
                                Route::has('accesorios_equipo.index')
                            )
                                </a>
                            @else
                                </div>
                            @endif
                        </div>

                        {{-- TIPOS DE EQUIPO --}}
                        <div class="col-12 col-sm-6">
                            <a href="{{ route('tipos-equipo.index') }}"
                               class="dashboard-modulo">
                                <div class="dashboard-modulo-icono">
                                    <i class="fas fa-list"></i>
                                </div>
                                <div class="dashboard-modulo-contenido">
                                    <div class="dashboard-modulo-titulo">
                                        TIPOS DE EQUIPO
                                    </div>
                                    <p>
                                        Gestiona las categorías utilizadas para clasificar
                                        los equipos del inventario.
                                    </p>
                                    <span>INGRESAR <i class="fas fa-arrow-right ms-1"></i></span>
                                </div>
                            </a>
                        </div>

                        {{-- UBICACIONES --}}
                        <div class="col-12 col-sm-6">
                            <a href="{{ route('ubicaciones.index') }}"
                               class="dashboard-modulo">
                                <div class="dashboard-modulo-icono">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="dashboard-modulo-contenido">
                                    <div class="dashboard-modulo-titulo">
                                        UBICACIONES
                                    </div>
                                    <p>
                                        Administra los ambientes y lugares donde se encuentran
                                        los equipos registrados.
                                    </p>
                                    <span>INGRESAR <i class="fas fa-arrow-right ms-1"></i></span>
                                </div>
                            </a>
                        </div>

                        {{-- SOLICITANTES --}}
@php
    $rutaSolicitantes = collect([
        'docentes.index',
        'docente.index',
        'solicitantes.index',
    ])->first(fn ($nombreRuta) => Route::has($nombreRuta));
@endphp

<div class="col-12 col-sm-6">
    @if ($rutaSolicitantes)
        <a href="{{ route($rutaSolicitantes) }}"
           class="dashboard-modulo">
    @else
        <div class="dashboard-modulo dashboard-modulo-pendiente">
    @endif

            <div class="dashboard-modulo-icono">
                <i class="fas fa-users"></i>
            </div>

            <div class="dashboard-modulo-contenido">
                <div class="dashboard-modulo-titulo">
                    SOLICITANTES
                </div>

                <p>
                    Consulta y administra los solicitantes registrados
                    para facilitar la gestión de los préstamos.
                </p>

                @if ($rutaSolicitantes)
                    <span>
                        INGRESAR <i class="fas fa-arrow-right ms-1"></i>
                    </span>
                @else
                    <span class="text-muted">
                        REVISAR RUTA DEL MÓDULO
                    </span>
                @endif
            </div>

    @if ($rutaSolicitantes)
        </a>
    @else
        </div>
    @endif
</div>

                        {{-- USUARIOS Y ROLES --}}
                        <div class="col-12 col-sm-6">
                            <div class="dashboard-modulo dashboard-modulo-pendiente">
                                <div class="dashboard-modulo-icono">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div class="dashboard-modulo-contenido">
                                    <div class="dashboard-modulo-titulo">
                                        USUARIOS Y ROLES
                                    </div>
                                    <p>
                                        Administra las cuentas de acceso y los permisos
                                        asignados a cada usuario.
                                    </p>
                                    <span class="text-muted">
                                        <i class="fas fa-clock me-1"></i>PRÓXIMAMENTE
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- MANUAL DEL USUARIO --}}
                        <div class="col-12 col-sm-6">
                            <div class="dashboard-modulo dashboard-modulo-pendiente">
                                <div class="dashboard-modulo-icono">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <div class="dashboard-modulo-contenido">
                                    <div class="dashboard-modulo-titulo">
                                        MANUAL DEL USUARIO
                                    </div>
                                    <p>
                                        Consulta las instrucciones para utilizar los módulos
                                        y realizar las tareas frecuentes.
                                    </p>
                                    <span class="text-muted">
                                        <i class="fas fa-clock me-1"></i>PRÓXIMAMENTE
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- INFORMACIÓN DEL SISTEMA --}}
        <div class="col-12 col-lg-4">
            <div class="dashboard-tarjeta overflow-hidden h-100">
                <div class="dashboard-cabecera">
                    <i class="fas fa-info-circle me-2"></i>
                    INFORMACIÓN DEL SISTEMA
                </div>

                <div class="p-3">
                    <p class="small dashboard-subtitulo mb-2">
                        Resumen de los registros disponibles en cada módulo.
                    </p>

                    <div class="dashboard-info-fila">
                        <span>Préstamos registrados:</span>
                        <strong>{{ number_format($totalPrestamos) }}</strong>
                    </div>

                    <div class="dashboard-info-fila">
                        <span>Equipos registrados:</span>
                        <strong>{{ number_format($totalEquipos) }}</strong>
                    </div>

                    <div class="dashboard-info-fila">
                        <span>Accesorios registrados:</span>
                        <strong>{{ number_format($totalAccesorios) }}</strong>
                    </div>

                    <div class="dashboard-info-fila">
                        <span>Solicitantes registrados:</span>
                        <strong>{{ number_format($totalDocentes) }}</strong>
                    </div>

                    <div class="dashboard-info-fila">
                        <span>Tipos de equipo registrados:</span>
                        <strong>{{ number_format($totalTiposEquipo) }}</strong>
                    </div>

                    <div class="dashboard-info-fila">
                        <span>Ubicaciones registradas:</span>
                        <strong>{{ number_format($totalUbicaciones) }}</strong>
                    </div>

                    <div class="alert alert-success py-2 px-3 mt-3 mb-0 small">
                        <i class="fas fa-check-circle me-1"></i>
                        Sesión iniciada correctamente.
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ESTILOS DE LAS TARJETAS DE ACCESO --}}
    <style>
        .dashboard-modulo {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            height: 100%;
            min-height: 145px;
            padding: 15px;
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            color: #212529;
            text-decoration: none;
            transition: border-color .2s, box-shadow .2s, transform .2s;
        }

        .dashboard-modulo:hover {
            border-color: #198754;
            box-shadow: 0 3px 9px rgba(0, 0, 0, .08);
            color: #212529;
            transform: translateY(-2px);
        }

        .dashboard-modulo-icono {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 40px;
            width: 40px;
            height: 40px;
            background: #e9f7e9;
            color: #198754;
            border-radius: 8px;
            font-size: 1.1rem;
        }

        .dashboard-modulo-contenido {
            flex: 1;
            min-width: 0;
        }

        .dashboard-modulo-titulo {
            font-size: .83rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .dashboard-modulo-contenido p {
            color: #6c757d;
            font-size: .79rem;
            line-height: 1.45;
            margin-bottom: 10px;
        }

        .dashboard-modulo-contenido > span {
            display: inline-block;
            color: #198754;
            font-size: .72rem;
            font-weight: 700;
        }

        .dashboard-modulo-pendiente {
            background: #f8f9fa;
            border-style: dashed;
        }

        .dashboard-modulo-pendiente .dashboard-modulo-icono {
            background: #e9ecef;
            color: #6c757d;
        }

        @media (max-width: 576px) {
            .dashboard-modulo {
                min-height: 0;
            }
        }

        .dashboard-fila-oculta {
    display: none;
}
    </style>

    <script>
    function alternarFilasDashboard(idTabla, boton) {
        const tabla = document.getElementById(idTabla);

        if (!tabla) {
            return;
        }

        const filasOcultas = tabla.querySelectorAll(
            'tbody tr[data-dashboard-extra="1"]'
        );

        const expandir = boton.getAttribute('aria-expanded') !== 'true';

        filasOcultas.forEach(function (fila) {
            fila.style.display = expandir ? 'table-row' : '';
        });

        boton.setAttribute('aria-expanded', expandir ? 'true' : 'false');

        boton.innerHTML = expandir
            ? 'VER MENOS <i class="fas fa-chevron-up ms-1"></i>'
            : 'VER MÁS <i class="fas fa-chevron-down ms-1"></i>';
    }
</script>
@endsection