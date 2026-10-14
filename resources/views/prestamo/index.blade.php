<title>Préstamos</title>

@extends('layouts.app')

{{-- @section('template_title')
Préstamos
@endsection--}}
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card prestamo-index-card">

                    <div class="card-header prestamo-index-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span id="card_title" class="fw-bold">
                                <i class="bi bi-journal-check me-2 fs-5 text-success"></i>
                                PRÉSTAMOS
                                <small class="d-block fw-normal text-muted mt-1 ms-1">
                                    Consulta y administra los préstamos de equipos y accesorios.
                                </small>
                            </span>

                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('prestamos.create') }}" id="btn_nuevo_prestamo"
                                    class="btn btn-success btn-sm">
                                    <i class="fa-solid fa-plus"></i> Registrar Nuevo
                                </a>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-download"></i> Exportar
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <button type="button" class="dropdown-item" id="btn_exportar_excel">
                                                <i class="fa-solid fa-file-excel text-success"></i> Excel
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item" id="btn_exportar_pdf">
                                                <i class="fa-solid fa-file-pdf text-danger"></i> PDF
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body prestamo-index-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" id="btn_toggle_filtros" class="btn btn-outline-success btn-sm">
                                    <i class="fa-solid fa-filter"></i> FILTROS
                                    <span id="badge_filtros" class="badge bg-success ms-1 d-none">0</span>
                                </button>
                                <span id="mensaje_coincidencias" class="text-success fw-bold"
                                    style="visibility:hidden;">&nbsp;</span>
                            </div>
                        </div>


                    <div id="panel_filtros" class="panel-filtros-prestamos mb-3" style="display:none;">

                        {{-- ENCABEZADO --}}
                        <div class="panel-filtros-header">
                            <div class="d-flex align-items-center gap-2">
                                <div class="icono-filtros">
                                    <i class="fa-solid fa-sliders"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">FILTROS DE BÚSQUEDA</h6>
                                    <small>Utiliza los campos para encontrar los préstamos registrados.</small>
                                </div>
                            </div>
                        </div>

                        {{-- CAMPOS --}}
                        <div class="panel-filtros-body">
                            <div class="row g-3">

                                {{-- SOLICITANTE --}}
                                <div class="col-12 col-md-6 col-xl-3">
                                    <label for="filtro_solicitante" class="form-label">
                                        <i class="fa-solid fa-user me-1"></i> SOLICITANTE
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_solicitante"
                                            class="form-control campo-mayusculas"
                                            list="lista_filtro_solicitante"
                                            placeholder="TODOS"
                                            autocomplete="off">
                                        <button type="button"
                                            class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_solicitante"
                                            title="Limpiar solicitante"
                                            aria-label="Limpiar solicitante">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <datalist id="lista_filtro_solicitante">
                                        @foreach ($filtroSolicitantes ?? [] as $nombre)
                                            <option value="{{ $nombre }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>

                                {{-- CARGO --}}
                                <div class="col-12 col-md-6 col-xl-3">
                                    <label for="filtro_cargo" class="form-label">
                                        <i class="fa-solid fa-id-badge me-1"></i> CARGO
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_cargo"
                                            class="form-control campo-mayusculas"
                                            list="lista_filtro_cargo"
                                            placeholder="TODOS"
                                            autocomplete="off">
                                        <button type="button"
                                            class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_cargo"
                                            title="Limpiar cargo"
                                            aria-label="Limpiar cargo">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <datalist id="lista_filtro_cargo">
                                        @foreach ($filtroCargos ?? [] as $cargo)
                                            <option value="{{ $cargo }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>

                                {{-- EQUIPO --}}
                                <div class="col-12 col-md-12 col-xl-6">
                                    <label for="filtro_equipo" class="form-label">
                                        <i class="fa-solid fa-laptop me-1"></i> EQUIPO
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_equipo"
                                            class="form-control campo-mayusculas"
                                            list="lista_filtro_equipo"
                                            placeholder="NOMBRE O N.º SERIE (3 CAR.)"
                                            autocomplete="off">
                                        <button type="button"
                                            class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_equipo"
                                            title="Limpiar equipo"
                                            aria-label="Limpiar equipo">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <datalist id="lista_filtro_equipo"></datalist>
                                </div>

                                {{-- ESTADO --}}
                                <div class="col-12 col-md-6 col-xl-3">
                                    <label for="filtro_estado" class="form-label">
                                        <i class="fa-solid fa-circle-check me-1"></i> ESTADO
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <select id="filtro_estado" class="form-select">
                                            <option value="">TODOS</option>
                                            <option value="ACTIVO">ACTIVO</option>
                                            <option value="TERMINADO">TERMINADO</option>
                                        </select>
                                        <button type="button"
                                            class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_estado"
                                            title="Limpiar estado"
                                            aria-label="Limpiar estado">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- FECHA --}}
                                <div class="col-12 col-md-6 col-xl-3">
                                    <label for="filtro_fecha" class="form-label">
                                        <i class="fa-solid fa-calendar-days me-1"></i> FECHA
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="date" id="filtro_fecha" class="form-control">
                                        <button type="button" id="btn_filtro_hoy"
                                            class="btn btn-hoy-filtro"
                                            title="Filtrar préstamos de hoy">
                                            HOY
                                        </button>
                                        <button type="button"
                                            class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_fecha"
                                            title="Limpiar fecha"
                                            aria-label="Limpiar fecha">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- HORARIO DESDE --}}
                                <div class="col-12 col-md-6 col-xl-3">
                                    <label for="filtro_hora_inicio" class="form-label">
                                        <i class="fa-regular fa-clock me-1"></i> HORARIO DESDE
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="time" id="filtro_hora_inicio"
                                            class="form-control" min="06:00" max="16:00">
                                        <button type="button"
                                            class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_hora_inicio"
                                            title="Limpiar hora de inicio"
                                            aria-label="Limpiar hora de inicio">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- HORARIO HASTA --}}
                                <div class="col-12 col-md-6 col-xl-3">
                                    <label for="filtro_hora_fin" class="form-label">
                                        <i class="fa-regular fa-clock me-1"></i> HORARIO HASTA
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="time" id="filtro_hora_fin"
                                            class="form-control" min="06:00" max="16:00">
                                        <button type="button"
                                            class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_hora_fin"
                                            title="Limpiar hora final"
                                            aria-label="Limpiar hora final">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>

                            {{-- ACCIONES --}}
                            <div class="panel-filtros-acciones">
                                <div class="texto-ayuda-filtros">
                                    <i class="fa-solid fa-circle-info me-1"></i>
                                    Puedes combinar varios filtros.
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" id="btn_limpiar_filtros"
                                        class="btn btn-limpiar-todos btn-sm">
                                        <i class="fa-solid fa-rotate-left me-1"></i>
                                        LIMPIAR FILTROS
                                    </button>

                                    <button type="button" id="btn_aplicar_filtros"
                                        class="btn btn-aplicar-filtros btn-sm">
                                        <i class="fa-solid fa-magnifying-glass me-1"></i>
                                        APLICAR FILTROS
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                        <div class="table-responsive">
                            <table id="example"
                                class="table table-bordered table-hover table-striped align-middle prestamo-datatable"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="text-center">Solicitante</th>
                                        <th class="text-center">Cargo</th>
                                        <th class="text-center">Equipos</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Hora inicio</th>
                                        <th class="text-center">Hora final</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center columna-acciones">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prestamos as $i => $prestamo)
                                        @php
    $nombreSol = trim(($prestamo->docente->apellidos ?? '') . ' ' . ($prestamo->docente->nombres ?? ''));
    $fechaIso = $prestamo->fecha ? \Carbon\Carbon::parse($prestamo->fecha)->format('Y-m-d') : '';

    $hIni = $prestamo->hora_inicio ? substr($prestamo->hora_inicio, 0, 5) : '';
    $hFin = $prestamo->hora_fin ? substr($prestamo->hora_fin, 0, 5) : '';

    $hIniMostrar = $hIni
        ? \Carbon\Carbon::createFromFormat('H:i', $hIni)->format('h:i A')
        : '';

    $hFinMostrar = $hFin
        ? \Carbon\Carbon::createFromFormat('H:i', $hFin)->format('h:i A')
        : '';

    $textoEquipos = collect($prestamo->prestamoEquipos)->map(function ($pe) {
        $eq = $pe->equipo;
        return trim(($eq->tipoEquipo->nombre ?? '') . ' ' . ($eq->marca ?? '') . ' ' . ($eq->num_serie ?? ''));
    })->implode(' | ');
                                        @endphp
                                        <tr data-prestamo-id="{{ $prestamo->id }}"
                                            data-solicitante="{{ strtoupper($nombreSol) }}"
                                            data-cargo="{{ strtoupper($prestamo->cargo ?? '') }}"
                                            data-equipos="{{ strtoupper($textoEquipos) }}" data-fecha="{{ $fechaIso }}"
                                            data-hora-inicio="{{ $hIni }}" data-hora-fin="{{ $hFin }}"
                                            data-estado="{{ strtoupper($prestamo->estado ?? '') }}">
                                            <td>{{ $prestamo->id }}</td>
                                            <td>{{ strtoupper($nombreSol) ?: '-' }}</td>
                                            <td>{{ strtoupper($prestamo->cargo ?? '-') }}</td>
                                            <td>
                                                @forelse ($prestamo->prestamoEquipos as $prestamoEquipo)
                                                    <div class="mb-1">
                                                        {{ $prestamoEquipo->equipo->tipoEquipo->nombre ?? '' }}
                                                        {{ $prestamoEquipo->equipo->marca ?? '' }}
                                                        <small class="text-muted">N/S:
                                                            {{ $prestamoEquipo->equipo->num_serie ?? '-' }}</small>
                                                    </div>
                                                @empty
                                                    —
                                                @endforelse
                                            </td>
                                            <td class="text-center">
                                                {{ $fechaIso ? \Carbon\Carbon::parse($fechaIso)->format('d-m-Y') : '-' }}
                                            </td>
                                            <td class="text-center" data-order="{{ $hIni }}">
                                                {{ $hIniMostrar ?: '-' }}
                                            </td>

                                            <td class="text-center" data-order="{{ $hFin }}">
                                                {{ $hFinMostrar ?: '—' }}
                                            </td>
                                            <td class="text-center">
                                                @if (($prestamo->estado ?? '') === 'ACTIVO')
                                                    <span class="badge bg-success">ACTIVO</span>
                                                @else
                                                    <span class="badge bg-secondary">TERMINADO</span>
                                                @endif
                                            </td>
                                            <td class="text-center columna-acciones">
                                                <div class="d-flex justify-content-center align-items-center gap-1">
                                                    <form action="{{ route('prestamos.destroy', $prestamo->id) }}"
                                                        method="POST">
                                                        <a class="btn btn-info btn-accion btn-ver-prestamo"
                                                            href="{{ route('prestamos.show', $prestamo->id) }}">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        <a class="btn btn-warning btn-accion"
                                                            href="{{ route('prestamos.edit', $prestamo->id) }}"><i
                                                                class="fa-solid fa-pen-to-square"></i></a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-accion"
                                                            onclick="event.preventDefault(); confirmarEliminarPrestamo(this.closest('form'));">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    /* =========================================
       TARJETA PRINCIPAL
    ========================================= */
    .prestamo-index-card {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .06);
        overflow: hidden;
    }

    .prestamo-index-header {
        background: #e9f7e9;
        color: #212529;
        border-bottom: 1px solid #c8e6c9;
        padding: 15px 18px;
    }

    .prestamo-index-header #card_title {
        font-size: 1rem;
        letter-spacing: .2px;
    }

    .prestamo-index-body {
        padding: 18px;
    }

    /* =========================================
       BOTONES DEL ENCABEZADO
    ========================================= */
    #btn_nuevo_prestamo {
        font-weight: 600;
    }

    .prestamo-index-header .btn,
    .prestamo-index-body .btn {
        border-radius: 6px;
    }

    /* =========================================
       PANEL DE FILTROS
    ========================================= */
    #panel_filtros {
        background: #f8f9fa !important;
        border-color: #dee2e6 !important;
        border-radius: 8px;
    }

    #panel_filtros .form-label {
        font-size: .76rem;
        margin-bottom: 5px;
        letter-spacing: .2px;
    }

    #panel_filtros .form-control,
    #panel_filtros .form-select,
    #panel_filtros .btn {
        min-height: 32px;
    }

    #panel_filtros .form-control:focus,
    #panel_filtros .form-select:focus {
        border-color: #86b7a0;
        box-shadow: 0 0 0 .15rem rgba(25, 135, 84, .12);
    }

    /* =========================================
       CONTROLES DEL DATATABLE
    ========================================= */
    #example_wrapper {
        width: 100%;
        color: #343a40;
        font-size: .88rem;
    }

    #example_wrapper .dataTables_length,
    #example_wrapper .dataTables_filter {
        margin-bottom: 12px;
    }

    #example_wrapper .dataTables_length label,
    #example_wrapper .dataTables_filter label {
        color: #495057;
        font-weight: 500;
    }

    #example_wrapper .dataTables_length select,
    #example_wrapper .dataTables_filter input {
        border: 1px solid #ced4da;
        border-radius: 6px;
        padding: 5px 9px;
        background: #fff;
        color: #212529;
    }

    #example_wrapper .dataTables_filter input {
        margin-left: 6px;
        max-width: 220px;
    }

    #example_wrapper .dataTables_length select:focus,
    #example_wrapper .dataTables_filter input:focus {
        outline: none;
        border-color: #86b7a0;
        box-shadow: 0 0 0 .15rem rgba(25, 135, 84, .12);
    }

    /* =========================================
       TABLA
    ========================================= */
    #example {
        width: 100% !important;
        margin-bottom: 0 !important;
        border-color: #dee2e6;
    }

    #example thead th {
        background-color: #e9f7e9 !important;
        color: #212529 !important;
        text-align: center;
        vertical-align: middle;
        font-size: .78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .2px;
        white-space: nowrap;
        padding: 12px 10px;
        border-color: #d5e5d7;
    }

    #example tbody td {
        vertical-align: middle !important;
        padding: 10px;
        border-color: #e5e7eb;
        color: #343a40;
    }

    #example tbody tr:nth-child(even) td {
        background-color: #f8faf9;
    }

    #example tbody tr:hover td {
        background-color: #eef7f0;
    }

    #example tbody td:nth-child(1),
    #example tbody td:nth-child(5),
    #example tbody td:nth-child(6),
    #example tbody td:nth-child(7),
    #example tbody td:nth-child(8),
    #example tbody td:last-child {
        text-align: center;
    }

    /* Columna de equipos: permitir leer varios equipos sin
       que la tabla se vuelva excesivamente ancha. */
    #example tbody td:nth-child(4) {
        min-width: 200px;
        max-width: 340px;
        line-height: 1.5;
    }

    #example tbody td:nth-child(4) .mb-1 {
        padding: 3px 0;
        border-bottom: 1px solid #edf0ed;
    }

    #example tbody td:nth-child(4) .mb-1:last-child {
        border-bottom: 0;
    }

    /* =========================================
       ESTADOS
    ========================================= */
    #example .badge {
        font-size: .72rem;
        font-weight: 700;
        padding: 6px 9px;
        border-radius: 5px;
        letter-spacing: .2px;
    }

    /* =========================================
       BOTONES DE ACCIONES
    ========================================= */
    #example .columna-acciones {
        min-width: 125px;
        white-space: nowrap;
    }

    #example .btn-accion {
        width: 31px;
        height: 30px;
        padding: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 5px;
        font-size: .8rem;
        transition: opacity .2s, transform .2s;
    }

    #example .btn-accion:hover {
        opacity: .85;
        transform: translateY(-1px);
    }

    #example .btn-info.btn-accion {
        background-color: #e7f1ff;
        color: #0d6efd;
    }

    #example .btn-warning.btn-accion {
        background-color: #fff3cd;
        color: #856404;
    }

    #example .btn-danger.btn-accion {
        background-color: #f8d7da;
        color: #842029;
    }

    /* =========================================
       PAGINACIÓN
    ========================================= */
    #example_wrapper .dataTables_info {
        padding-top: 10px;
        color: #6c757d;
        font-size: .82rem;
    }

    #example_wrapper .dataTables_paginate {
        padding-top: 8px;
    }

    #example_wrapper .page-link {
        color: #198754;
        border-color: #dee2e6;
    }

    #example_wrapper .page-item.active .page-link {
        background-color: #198754;
        border-color: #198754;
        color: #fff;
    }

    #example_wrapper .page-link:focus {
        box-shadow: 0 0 0 .15rem rgba(25, 135, 84, .15);
    }

    /* =========================================
       FILAS RESALTADAS DESPUÉS DE UNA ACCIÓN
       Se conservan los colores de tu lógica actual.
    ========================================= */
    .fila-crear td {
        background-color: #d4edda !important;
    }

    .fila-editar td {
        background-color: #fff3cd !important;
    }

    .fila-ver td {
        background-color: #cfe2ff !important;
    }

    /* =========================================
       RESPONSIVE
    ========================================= */
    @media (max-width: 768px) {
        .prestamo-index-body {
            padding: 12px;
        }

        .prestamo-index-header {
            padding: 12px;
        }

        #example_wrapper .dataTables_length,
        #example_wrapper .dataTables_filter {
            float: none;
            width: 100%;
            text-align: left;
        }

        #example_wrapper .dataTables_filter input {
            width: 100%;
            max-width: none;
            margin: 5px 0 0;
        }

        #example_wrapper .dataTables_paginate {
            overflow-x: auto;
            white-space: nowrap;
        }
    }

/* =========================================
   PANEL DE FILTROS - PRESTAMOS
========================================= */

.panel-filtros-prestamos {
    background: #ffffff;
    border: 1px solid #dce5dd;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
}

/* Encabezado verde claro */
.panel-filtros-header {
    padding: 14px 18px;
    background: #e9f7e9;
    border-bottom: 1px solid #d4e8d5;
}

.panel-filtros-header h6 {
    color: #245c38;
    font-size: 0.88rem;
    letter-spacing: 0.3px;
}

.panel-filtros-header small {
    color: #6c757d;
    font-size: 0.78rem;
}

.icono-filtros {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    flex-shrink: 0;
    background: #d3ebd5;
    color: #198754;
    border-radius: 8px;
    font-size: 1rem;
}

/* Contenido del panel */
.panel-filtros-body {
    padding: 18px;
}

.panel-filtros-prestamos .form-label {
    display: block;
    margin-bottom: 6px;
    color: #495057;
    font-size: 0.73rem;
    font-weight: 700;
    letter-spacing: 0.35px;
}

.panel-filtros-prestamos .form-label i {
    color: #198754;
    font-size: 0.76rem;
}

.panel-filtros-prestamos .form-control,
.panel-filtros-prestamos .form-select {
    min-height: 34px;
    border-color: #d6dce1;
    border-radius: 5px;
    color: #343a40;
    font-size: 0.82rem;
    background-color: #fff;
}

.panel-filtros-prestamos .input-group > .form-control,
.panel-filtros-prestamos .input-group > .form-select {
    min-width: 0;
}

.panel-filtros-prestamos .form-control::placeholder {
    color: #9aa1a8;
    font-size: 0.77rem;
}

.panel-filtros-prestamos .form-control:focus,
.panel-filtros-prestamos .form-select:focus {
    border-color: #86b7a0;
    box-shadow: 0 0 0 0.15rem rgba(25, 135, 84, 0.12);
}

/* Botones para limpiar cada campo */
.panel-filtros-prestamos .btn-limpiar-filtro {
    min-width: 34px;
    border: 1px solid #d6dce1;
    background: #f8f9fa;
    color: #6c757d;
    transition: all 0.2s ease;
}

.panel-filtros-prestamos .btn-limpiar-filtro:hover {
    background: #f8d7da;
    border-color: #f1b9bf;
    color: #842029;
}

/* Botón HOY */
.panel-filtros-prestamos .btn-hoy-filtro {
    padding-right: 10px;
    padding-left: 10px;
    border: 1px solid #198754;
    background: #e9f7e9;
    color: #198754;
    font-size: 0.75rem;
    font-weight: 700;
}

.panel-filtros-prestamos .btn-hoy-filtro:hover {
    background: #198754;
    color: #fff;
}

/* Separación de la zona de acciones */
.panel-filtros-acciones {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #e9ecef;
}

.texto-ayuda-filtros {
    color: #7a838b;
    font-size: 0.78rem;
}

.texto-ayuda-filtros i {
    color: #198754;
}

/* Botón para limpiar todos los filtros */
.panel-filtros-prestamos .btn-limpiar-todos {
    padding: 7px 12px;
    border: 1px solid #ced4da;
    border-radius: 6px;
    background: #fff;
    color: #495057;
    font-weight: 600;
    font-size: 0.76rem;
}

.panel-filtros-prestamos .btn-limpiar-todos:hover {
    background: #f1f3f5;
    border-color: #adb5bd;
}

/* Botón principal */
.panel-filtros-prestamos .btn-aplicar-filtros {
    padding: 7px 14px;
    border: 1px solid #198754;
    border-radius: 6px;
    background: #198754;
    color: #fff;
    font-weight: 600;
    font-size: 0.76rem;
    transition: background 0.2s ease;
}

.panel-filtros-prestamos .btn-aplicar-filtros:hover {
    background: #146c43;
    border-color: #146c43;
    color: #fff;
}

/* Adaptación para pantallas pequeñas */
@media (max-width: 768px) {
    .panel-filtros-header {
        padding: 12px;
    }

    .panel-filtros-body {
        padding: 12px;
    }

    .panel-filtros-acciones {
        align-items: stretch;
        flex-direction: column;
    }

    .panel-filtros-acciones > .d-flex {
        width: 100%;
    }

    .panel-filtros-acciones > .d-flex .btn {
        flex: 1;
    }

    .texto-ayuda-filtros {
        font-size: 0.75rem;
    }
}

</style>

{{-- INICIO SCRIPT --}}
<script>
    window.addEventListener('load', function () {
        if (typeof $ === 'undefined' || !$.fn.DataTable) return;

        const tabla = $.fn.DataTable.isDataTable('#example')
            ? $('#example').DataTable()
            : $('#example').DataTable({
                dom: '<"d-flex justify-content-between align-items-center mb-2"lf>rt<"d-flex justify-content-between align-items-center mt-2"ip>',
                pageLength: 10,
                lengthMenu: [5, 10, 25, 100],
                language: {
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros.",
                    search: "Buscar:",
                    zeroRecords: "No se encontraron registros",
                    infoEmpty: "No hay registros disponibles",
                    infoFiltered: "(filtrado de _MAX_ registros en total)",
                }
            });
        tabla.order([[4, 'desc'], [5, 'desc']]).draw();

        //EXPORTAR EXCEL
        document.getElementById('btn_exportar_excel').addEventListener('click', function () {

            /*
            |--------------------------------------------------------------------------
            | OBTENER REGISTROS SEGÚN EL DATATABLE
            |--------------------------------------------------------------------------
            */

            const ids = [];

            tabla.rows({
                search: 'applied',
                order: 'applied'
            }).every(function () {

                const tr = this.node();

                if (!tr) return;

                const id = tr.getAttribute('data-prestamo-id');

                if (id) {
                    ids.push(id);
                }

            });


            /*
            |--------------------------------------------------------------------------
            | VALIDAR
            |--------------------------------------------------------------------------
            */

            if (ids.length === 0) {

                if (typeof toastr !== 'undefined') {

                    toastr.warning(
                        'NO HAY PRÉSTAMOS PARA EXPORTAR.'
                    );

                } else {

                    alert(
                        'NO HAY PRÉSTAMOS PARA EXPORTAR.'
                    );

                }

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | CREAR FORMULARIO TEMPORAL
            |--------------------------------------------------------------------------
            */

            const form = document.createElement('form');

            form.method = 'POST';

            form.action = '{{ route('prestamos.export.excel') }}';

            form.target = '_blank';


            /*
            |--------------------------------------------------------------------------
            | TOKEN CSRF
            |--------------------------------------------------------------------------
            */

            const csrf = document.createElement('input');

            csrf.type = 'hidden';

            csrf.name = '_token';

            csrf.value = '{{ csrf_token() }}';

            form.appendChild(csrf);


            /*
            |--------------------------------------------------------------------------
            | ENVIAR IDS EN EL ORDEN DEL DATATABLE
            |--------------------------------------------------------------------------
            */

            ids.forEach(function (id) {

                const input = document.createElement('input');

                input.type = 'hidden';

                input.name = 'ids[]';

                input.value = id;

                form.appendChild(input);

            });


            /*
            |--------------------------------------------------------------------------
            | ENVIAR
            |--------------------------------------------------------------------------
            */

            document.body.appendChild(form);

            form.submit();

            form.remove();

        });

        //EXPORTAR PDF
        document.getElementById('btn_exportar_pdf').addEventListener('click', function () {

            /*
            |--------------------------------------------------------------------------
            | OBTENER FILAS SEGÚN EL ESTADO ACTUAL DE DATATABLE
            |--------------------------------------------------------------------------
            */

            const ids = [];

            tabla.rows({
                search: 'applied',
                order: 'applied'
            }).every(function () {

                const tr = this.node();

                if (!tr) return;

                const id = tr.getAttribute('data-prestamo-id');

                if (id) {
                    ids.push(id);
                }
            });


            /*
            |--------------------------------------------------------------------------
            | VALIDAR
            |--------------------------------------------------------------------------
            */

            if (ids.length === 0) {

                if (typeof toastr !== 'undefined') {
                    toastr.warning('NO HAY PRÉSTAMOS PARA EXPORTAR.');
                } else {
                    alert('NO HAY PRÉSTAMOS PARA EXPORTAR.');
                }

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | CREAR FORMULARIO TEMPORAL
            |--------------------------------------------------------------------------
            */

            const form = document.createElement('form');

            form.method = 'POST';
            form.action = '{{ route('prestamos.export.pdf') }}';
            form.target = '_blank';


            /*
            |--------------------------------------------------------------------------
            | TOKEN CSRF
            |--------------------------------------------------------------------------
            */

            const csrf = document.createElement('input');

            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';

            form.appendChild(csrf);


            /*
            |--------------------------------------------------------------------------
            | ENVIAR IDS EN EL ORDEN DEL DATATABLE
            |--------------------------------------------------------------------------
            */

            ids.forEach(function (id) {

                const input = document.createElement('input');

                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;

                form.appendChild(input);

            });


            /*
            |--------------------------------------------------------------------------
            | ENVIAR
            |--------------------------------------------------------------------------
            */

            document.body.appendChild(form);

            form.submit();

            form.remove();

        });



        const STORAGE_KEY = 'prestamos_filtros_estado';
        const panel = document.getElementById('panel_filtros');
        const btnToggle = document.getElementById('btn_toggle_filtros');
        const badge = document.getElementById('badge_filtros');
        const msg = document.getElementById('mensaje_coincidencias');
        const listaEquipo = document.getElementById('lista_filtro_equipo');
        const campos = {
            solicitante: document.getElementById('filtro_solicitante'),
            cargo: document.getElementById('filtro_cargo'),
            equipo: document.getElementById('filtro_equipo'),
            estado: document.getElementById('filtro_estado'),
            fecha: document.getElementById('filtro_fecha'),
            horaInicio: document.getElementById('filtro_hora_inicio'),
            horaFin: document.getElementById('filtro_hora_fin')
        };
        function val(el) { return el ? String(el.value || '').trim().toUpperCase() : ''; }
        function hora(el) { return (el && el.value) ? el.value : ''; }
        function filtrosActivos() {
            let n = 0;
            Object.keys(campos).forEach(function (k) {
                if (!campos[k]) return;
                if (campos[k].value && String(campos[k].value).trim() !== '') n++;
            });
            return n;
        }
        function actualizarBadge() {
            if (!badge) return;
            const n = filtrosActivos();
            badge.textContent = n;
            badge.classList.toggle('d-none', n === 0);
        }
        function mostrarCoincidencias() {
            if (!msg) return;
            if (filtrosActivos() === 0) { msg.style.visibility = 'hidden'; msg.textContent = '\xa0'; return; }
            const n = tabla.page.info().recordsDisplay;
            msg.style.visibility = 'visible';
            msg.textContent = 'SE ENCONTRARON: ' + n + ' COINCIDENCIA' + (n === 1 ? '' : 'S');
        }
        function guardarFiltros() {
            const estado = { panel: panel && panel.style.display !== 'none' };
            Object.keys(campos).forEach(function (k) { estado[k] = campos[k] ? campos[k].value : ''; });
            localStorage.setItem(STORAGE_KEY, JSON.stringify(estado));
        }
        function restaurarFiltros() {
            const raw = localStorage.getItem(STORAGE_KEY);
            if (!raw) return;
            try {
                const estado = JSON.parse(raw);
                Object.keys(campos).forEach(function (k) {
                    if (campos[k] && estado[k] != null) campos[k].value = estado[k];
                });
                if (panel && estado.panel) panel.style.display = 'block';
            } catch (e) { }
        }
        function actualizarSugerenciasEquipo() {
            if (!listaEquipo || !campos.equipo) return;
            const q = val(campos.equipo);
            listaEquipo.innerHTML = '';
            if (q.length < 3) return;
            const vistos = {};
            tabla.rows({ page: 'all' }).every(function () {
                const tr = this.node();
                const txt = (tr && tr.getAttribute('data-equipos')) || '';
                if (txt.includes(q) && !vistos[txt]) {
                    vistos[txt] = true;
                    const op = document.createElement('option');
                    op.value = txt;
                    listaEquipo.appendChild(op);
                }
            });
        }
        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            if (!settings.nTable || settings.nTable.id !== 'example') return true;
            const fila = tabla.row(dataIndex).node();
            if (!fila) return true;
            const sol = val(campos.solicitante);
            const car = val(campos.cargo);
            const eq = val(campos.equipo);
            const est = val(campos.estado);
            const fec = campos.fecha ? campos.fecha.value : '';
            const hi = hora(campos.horaInicio);
            const hf = hora(campos.horaFin);
            if (sol && !(fila.getAttribute('data-solicitante') || '').includes(sol)) return false;
            if (car && !(fila.getAttribute('data-cargo') || '').includes(car)) return false;
            if (eq && !(fila.getAttribute('data-equipos') || '').includes(eq)) return false;
            if (est && (fila.getAttribute('data-estado') || '') !== est) return false;
            if (fec && (fila.getAttribute('data-fecha') || '') !== fec) return false;

            const filaHi = fila.getAttribute('data-hora-inicio') || '';
            const filaHf = fila.getAttribute('data-hora-fin') || '';

            // Si se establece un rango completo,
            // solamente se muestran préstamos TERMINADOS.
            if (hf && !filaHf) return false;

            // Filtrar por hora de inicio
            if (hi && filaHi && filaHi < hi) return false;

            // Filtrar por hora final
            if (hf && filaHf && filaHf > hf) return false;

            return true;
        });

        //Funcion aplicar filtros con validacion de hora
        function aplicarFiltros() {
            const hi = hora(campos.horaInicio);
            const hf = hora(campos.horaFin);

            const HORA_MINIMA = '06:00';
            const HORA_MAXIMA = '16:00';

            // Validar hora desde
            if (hi && (hi < HORA_MINIMA || hi > HORA_MAXIMA)) {
                if (typeof toastr !== 'undefined') {
                    toastr.error('LA HORA DESDE DEBE ESTAR ENTRE LAS 06:00 AM Y 04:00 PM.');
                }
                return;
            }

            // Validar hora hasta
            if (hf && (hf < HORA_MINIMA || hf > HORA_MAXIMA)) {
                if (typeof toastr !== 'undefined') {
                    toastr.error('LA HORA HASTA DEBE ESTAR ENTRE LAS 06:00 AM Y 04:00 PM.');
                }
                return;
            }

            // Validar que hasta no sea menor que desde
            if (hi && hf && hf < hi) {
                if (typeof toastr !== 'undefined') {
                    toastr.error('LA HORA HASTA NO PUEDE SER MENOR QUE LA HORA DESDE.');
                }
                return;
            }

            guardarFiltros();
            actualizarBadge();
            tabla.draw();
            mostrarCoincidencias();
        }

        function aplicarYScroll() {
            aplicarFiltros();
            const tablaEl = document.getElementById('example');
            if (tablaEl) tablaEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        function limpiarFiltros() {
            Object.keys(campos).forEach(function (k) { if (campos[k]) campos[k].value = ''; });
            localStorage.removeItem(STORAGE_KEY);
            actualizarBadge();
            tabla.draw();
            mostrarCoincidencias();
        }
        if (btnToggle) btnToggle.addEventListener('click', function () {
            panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
        });
        document.getElementById('btn_aplicar_filtros').addEventListener('click', aplicarYScroll);
        document.getElementById('btn_limpiar_filtros').addEventListener('click', limpiarFiltros);
        document.getElementById('btn_filtro_hoy').addEventListener('click', function () {
            const d = new Date();
            campos.fecha.value = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
            aplicarFiltros();
        });
        document.querySelectorAll('.btn-limpiar-campo').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const el = document.getElementById(btn.getAttribute('data-target'));
                if (el) el.value = '';
                aplicarFiltros();
            });
        });
        if (campos.equipo) campos.equipo.addEventListener('input', function () {
            this.value = this.value.toUpperCase();
            actualizarSugerenciasEquipo();
        });
        document.querySelectorAll('.campo-mayusculas').forEach(function (el) {
            el.addEventListener('input', function () { this.value = this.value.toUpperCase(); });
        });
        document.addEventListener('keydown', function (e) {
            const tag = e.target && e.target.tagName;
            if (tag && ['INPUT', 'SELECT', 'TEXTAREA'].includes(tag)) {
                if (e.key === 'Enter') { e.preventDefault(); aplicarYScroll(); }
                return;
            }
            if (e.key === '+' || e.key === '=') {
                e.preventDefault();
                document.getElementById('btn_nuevo_prestamo').click();
            }
            if (e.key === 'f' || e.key === 'F') {
                e.preventDefault();
                btnToggle.click();
                campos.solicitante.focus();
            }
        });

        Object.keys(campos).forEach(function (k) {
            if (!campos[k]) return;
            campos[k].addEventListener('input', aplicarFiltros);
            campos[k].addEventListener('change', aplicarFiltros);
        });

        // Inicialización de filtros: priorizar los accesos desde el dashboard.
const parametrosURL = new URLSearchParams(window.location.search);
const desdeDashboard = parametrosURL.get('desde_dashboard') === '1';

// Se conserva la excepción que ya existía para la creación de préstamos.
const NUEVO_KEY = 'prestamos_filtros_estado_nuevo_prestamo';
const vieneDeCrear = localStorage.getItem(NUEVO_KEY) === '1'
    || @json(session('prestamo_accion')) === 'crear';

if (desdeDashboard) {
    // Eliminar los filtros anteriores guardados.
    localStorage.removeItem(STORAGE_KEY);

    // Limpiar los filtros para aplicar únicamente el estado solicitado.
    Object.keys(campos).forEach(function (k) {
        if (campos[k]) campos[k].value = '';
    });

    if (campos.estado) {
        campos.estado.value = parametrosURL.get('estado') || '';
    }

    // Mostrar el panel si se solicita un estado.
    if (panel) {
        panel.style.display = campos.estado && campos.estado.value
            ? 'block'
            : 'none';
    }

    // Aplicar y guardar el filtro seleccionado.
    aplicarFiltros();

    // Quitar los parámetros para que no se reapliquen al actualizar.
    window.history.replaceState({}, document.title, window.location.pathname);

} else if (!vieneDeCrear) {
    // Mantener el comportamiento normal del módulo.
    restaurarFiltros();
    actualizarBadge();

    if (filtrosActivos()) {
        aplicarFiltros();
    }
}

        const PAG_KEY = 'prestamos_pagina';

        tabla.on('page.dt', function () {
            localStorage.setItem(PAG_KEY, tabla.page());
        });

        function pintarFilaPrestamo() {
            const idFila = @json(session('prestamo_resaltado')) || sessionStorage.getItem('prestamo_resaltado');
            const accFila = @json(session('prestamo_accion')) || sessionStorage.getItem('prestamo_accion');
            sessionStorage.removeItem('prestamo_resaltado');
            sessionStorage.removeItem('prestamo_accion');
            if (!idFila || !accFila) return;

            let nodo = null;
            tabla.rows({ page: 'all' }).every(function () {
                const tr = this.node();
                if (tr && String(tr.getAttribute('data-prestamo-id')) === String(idFila)) nodo = tr;
            });
            if (!nodo) return;

            const indiceInterno = tabla.row(nodo).index();
            const visibles = tabla.rows({ search: 'applied', order: 'applied' }).indexes().toArray();
            const posicion = visibles.indexOf(indiceInterno);
            if (posicion === -1) return;

            const pagina = Math.floor(posicion / tabla.page.len());
            tabla.page(pagina).draw('page');
            localStorage.setItem(PAG_KEY, String(pagina));

            setTimeout(function () {
                const visible = document.querySelector('#example tbody tr[data-prestamo-id="' + idFila + '"]');
                if (!visible) return;
                const color = accFila === 'crear' ? '#d4edda'
                    : accFila === 'editar' ? '#fff3cd' : '#cfe2ff';
                visible.querySelectorAll('td').forEach(function (td) { td.style.backgroundColor = color; });
                visible.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(function () {
                    visible.querySelectorAll('td').forEach(function (td) { td.style.backgroundColor = ''; });
                }, 4000);
            }, 50);
        }

        document.querySelectorAll('.btn-ver-prestamo').forEach(function (a) {
            a.addEventListener('click', function () {
                const partes = a.getAttribute('href').split('/').filter(Boolean);
                sessionStorage.setItem('prestamo_resaltado', partes.pop());
                sessionStorage.setItem('prestamo_accion', 'ver');
            });
        });

        setTimeout(pintarFilaPrestamo, 300);
        window.pintarFilaPrestamo = pintarFilaPrestamo;

    });

    function confirmarEliminarPrestamo(form) {
        if (!form) return;
        const fila = form.closest('tr');

        function enviar() {
            if (fila) {
                fila.querySelectorAll('td').forEach(function (td) {
                    td.style.backgroundColor = '#f8d7da';
                });
                fila.style.transition = 'opacity 0.4s';
                setTimeout(function () { fila.style.opacity = '0'; }, 200);
                setTimeout(function () { form.submit(); }, 700);
            } else {
                form.submit();
            }
        }

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: '¿Eliminar préstamo?',
                text: 'Esta acción no se puede deshacer.',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then(function (r) {
                if (r.isConfirmed) enviar();
            });
        } else if (confirm('¿Eliminar préstamo?')) {
            enviar();
        }
    }

    window.addEventListener('pageshow', function () {
        if (typeof pintarFilaPrestamo === 'function') setTimeout(pintarFilaPrestamo, 200);
    });

</script>