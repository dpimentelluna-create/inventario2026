@extends('layouts.app')

@section('template_title')
    Accesorios Equipos
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card accesorio-index-card">

                {{-- ENCABEZADO --}}
                <div class="card-header accesorio-index-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <span id="card_title" class="fw-bold">
                            <i class="bi bi-plug me-2 fs-5 text-success"></i>
                            ACCESORIOS EQUIPOS
                            <small class="d-block fw-normal text-muted mt-1 ms-1">
                                Consulta y administra los accesorios asociados a los equipos.
                            </small>
                        </span>

                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('accesorios-equipo.create') }}" id="btn_nuevo_accesorio" class="btn btn-success btn-sm">
                                <i class="fa-solid fa-plus"></i> Registrar Accesorio
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body accesorio-index-body">

                    {{-- BARRA FILTROS --}}
                    <div class="barra-filtros-accesorios mb-3">
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            <button type="button" id="btn_toggle_filtros" class="btn btn-filtros-accesorios btn-sm"
                                aria-controls="panel_filtros" aria-expanded="false">
                                <i class="fa-solid fa-sliders me-2 icono-boton-filtros"></i>
                                <span>FILTROS</span>
                                <span id="badge_filtros" class="badge badge-filtros-contador d-none">0</span>
                                <i class="fa-solid fa-chevron-down ms-3 flecha-filtros"></i>
                            </button>

                            <div id="mensaje_coincidencias" class="mensaje-coincidencias" style="display:none;" aria-live="polite"></div>
                        </div>
                    </div>

                    {{-- PANEL FILTROS --}}
                    <div id="panel_filtros" class="panel-filtros-accesorios mb-3" style="display:none;">
                        <div class="panel-filtros-header">
                            <div class="d-flex align-items-center gap-2">
                                <div class="icono-filtros">
                                    <i class="fa-solid fa-sliders"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">FILTROS DE BÚSQUEDA</h6>
                                    <small>Utiliza los campos para encontrar los accesorios registrados.</small>
                                </div>
                            </div>
                        </div>

                        <div class="panel-filtros-body">
                            <div class="row g-3">

                                {{-- EQUIPO RELACIONADO --}}
                                <div class="col-12 col-md-6 col-xl-3">
                                    <label for="filtro_equipo" class="form-label">
                                        <i class="fa-solid fa-laptop me-1"></i> EQUIPO (N.º SERIE)
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_equipo" class="form-control campo-mayusculas"
                                            list="lista_filtro_equipo" placeholder="TODOS" autocomplete="off">
                                        <button type="button" class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_equipo" title="Limpiar equipo">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <datalist id="lista_filtro_equipo"></datalist>
                                </div>

                                {{-- TIPO --}}
                                <div class="col-12 col-md-6 col-xl-3">
                                    <label for="filtro_tipo" class="form-label">
                                        <i class="fa-solid fa-tag me-1"></i> TIPO
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <select id="filtro_tipo" class="form-select">
                                            <option value="">TODOS</option>
                                            <option value="BATERÍA">BATERÍA</option>
                                            <option value="CARGADOR">CARGADOR</option>
                                        </select>
                                        <button type="button" class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_tipo" title="Limpiar tipo">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- MARCA --}}
                                <div class="col-12 col-md-6 col-xl-3">
                                    <label for="filtro_marca" class="form-label">
                                        <i class="fa-solid fa-industry me-1"></i> MARCA
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_marca" class="form-control campo-mayusculas"
                                            list="lista_filtro_marca" placeholder="TODAS" autocomplete="off">
                                        <button type="button" class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_marca" title="Limpiar marca">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <datalist id="lista_filtro_marca"></datalist>
                                </div>

                                {{-- N.º SERIE --}}
                                <div class="col-12 col-md-6 col-xl-3">
                                    <label for="filtro_serie" class="form-label">
                                        <i class="fa-solid fa-barcode me-1"></i> N.º SERIE
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_serie" class="form-control campo-mayusculas"
                                            list="lista_filtro_serie" placeholder="ESCRIBA 3 CARACTERES" autocomplete="off">
                                        <button type="button" class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_serie" title="Limpiar serie">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <datalist id="lista_filtro_serie"></datalist>
                                </div>

                                {{-- ESTADO --}}
                                <div class="col-12 col-md-6 col-xl-3">
                                    <label for="filtro_estado" class="form-label">
                                        <i class="fa-solid fa-circle-check me-1"></i> ESTADO
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <select id="filtro_estado" class="form-select">
                                            <option value="">TODOS</option>
                                            <option value="BUENO">BUENO</option>
                                            <option value="REGULAR">REGULAR</option>
                                            <option value="MALOGRADO">MALOGRADO</option>
                                        </select>
                                        <button type="button" class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_estado" title="Limpiar estado">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- OBSERVACIONES --}}
                                <div class="col-12 col-md-6 col-xl-6">
                                    <label for="filtro_observaciones" class="form-label">
                                        <i class="fa-solid fa-comment me-1"></i> OBSERVACIONES
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_observaciones" class="form-control campo-mayusculas"
                                            placeholder="BUSCAR EN OBSERVACIONES" autocomplete="off">
                                        <button type="button" class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_observaciones" title="Limpiar observaciones">
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
                                    <button type="button" id="btn_limpiar_filtros" class="btn btn-limpiar-todos btn-sm">
                                        <i class="fa-solid fa-rotate-left me-1"></i> LIMPIAR FILTROS
                                    </button>
                                    <button type="button" id="btn_aplicar_filtros" class="btn btn-aplicar-filtros btn-sm">
                                        <i class="fa-solid fa-magnifying-glass me-1"></i> APLICAR FILTROS
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TABLA --}}
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered table-hover table-striped align-middle accesorio-datatable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="text-center">Equipo Relacionado</th>
                                    <th class="text-center">Tipo</th>
                                    <th class="text-center">Marca</th>
                                    <th class="text-center">N.º Serie</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Observaciones</th>
                                    <th class="text-center columna-acciones">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accesoriosEquipos as $accesorio)
                                    @php
                                        $equipoSerie = strtoupper($accesorio->equipo->num_serie ?? '');
                                        $tipo = strtoupper($accesorio->tipo ?? '');
                                        $marca = strtoupper($accesorio->marca ?? '');
                                        $serie = strtoupper($accesorio->num_serie ?? '');
                                        $estado = strtoupper($accesorio->estado ?? '');
                                        $obs = strtoupper($accesorio->observaciones ?? '');
                                    @endphp
                                    <tr data-accesorio-id="{{ $accesorio->id }}"
                                        data-equipo="{{ $equipoSerie }}"
                                        data-tipo="{{ $tipo }}"
                                        data-marca="{{ $marca }}"
                                        data-serie="{{ $serie }}"
                                        data-estado="{{ $estado }}"
                                        data-observaciones="{{ $obs }}">
                                        <td>{{ $accesorio->id }}</td>
                                        <td class="text-center">{{ $accesorio->equipo->num_serie ?? '-' }}</td>
                                        <td class="text-center">{{ $accesorio->tipo ?? '-' }}</td>
                                        <td>{{ $accesorio->marca ?? '-' }}</td>
                                        <td class="text-center">{{ $accesorio->num_serie }}</td>
                                        <td class="text-center">
                                            @if($estado === 'BUENO')
                                                <span class="badge bg-success">{{ $estado }}</span>
                                            @elseif($estado === 'REGULAR')
                                                <span class="badge bg-warning text-dark">{{ $estado }}</span>
                                            @elseif($estado === 'MALOGRADO')
                                                <span class="badge bg-danger">{{ $estado }}</span>
                                            @else
                                                {{ $estado ?: '-' }}
                                            @endif
                                        </td>
                                        <td>{{ $accesorio->observaciones ?? '-' }}</td>
                                        <td class="text-center columna-acciones">
                                            <div class="d-flex justify-content-center align-items-center gap-1">
                                                <form action="{{ route('accesorios-equipo.destroy', $accesorio->id) }}" method="POST">
                                                    <a class="btn btn-info btn-accion btn-ver-accesorio"
                                                        href="{{ route('accesorios-equipo.show', $accesorio->id) }}">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-warning btn-accion"
                                                        href="{{ route('accesorios-equipo.edit', $accesorio->id) }}">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-accion"
                                                        onclick="event.preventDefault(); confirmarEliminarAccesorio(this.closest('form'));">
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
    .accesorio-index-card {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .06);
        overflow: hidden;
    }

    .accesorio-index-header {
        background: #e9f7e9;
        color: #212529;
        border-bottom: 1px solid #c8e6c9;
        padding: 15px 18px;
    }

    .accesorio-index-header #card_title {
        font-size: 1rem;
        letter-spacing: .2px;
    }

    .accesorio-index-body {
        padding: 18px;
    }

    #btn_nuevo_accesorio {
        font-weight: 600;
    }

    .accesorio-index-header .btn,
    .accesorio-index-body .btn {
        border-radius: 6px;
    }

    /* =========================================
       PANEL DE FILTROS
    ========================================= */
    .panel-filtros-accesorios {
        background: #ffffff;
        border: 1px solid #dce5dd;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }

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

    .panel-filtros-body {
        padding: 18px;
    }

    .panel-filtros-accesorios .form-label {
        display: block;
        margin-bottom: 6px;
        color: #495057;
        font-size: 0.73rem;
        font-weight: 700;
        letter-spacing: 0.35px;
    }

    .panel-filtros-accesorios .form-label i {
        color: #198754;
        font-size: 0.76rem;
    }

    .panel-filtros-accesorios .form-control,
    .panel-filtros-accesorios .form-select {
        min-height: 34px;
        border-color: #d6dce1;
        border-radius: 5px;
        color: #343a40;
        font-size: 0.82rem;
        background-color: #fff;
    }

    .panel-filtros-accesorios .input-group > .form-control,
    .panel-filtros-accesorios .input-group > .form-select {
        min-width: 0;
    }

    .panel-filtros-accesorios .form-control::placeholder {
        color: #9aa1a8;
        font-size: 0.77rem;
    }

    .panel-filtros-accesorios .form-control:focus,
    .panel-filtros-accesorios .form-select:focus {
        border-color: #86b7a0;
        box-shadow: 0 0 0 0.15rem rgba(25, 135, 84, 0.12);
    }

    .panel-filtros-accesorios .btn-limpiar-filtro {
        min-width: 34px;
        border: 1px solid #d6dce1;
        background: #f8f9fa;
        color: #6c757d;
        transition: all 0.2s ease;
    }

    .panel-filtros-accesorios .btn-limpiar-filtro:hover {
        background: #f8d7da;
        border-color: #f1b9bf;
        color: #842029;
    }

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

    .panel-filtros-accesorios .btn-limpiar-todos {
        padding: 7px 12px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        background: #fff;
        color: #495057;
        font-weight: 600;
        font-size: 0.76rem;
    }

    .panel-filtros-accesorios .btn-limpiar-todos:hover {
        background: #f1f3f5;
        border-color: #adb5bd;
    }

    .panel-filtros-accesorios .btn-aplicar-filtros {
        padding: 7px 14px;
        border: 1px solid #198754;
        border-radius: 6px;
        background: #198754;
        color: #fff;
        font-weight: 600;
        font-size: 0.76rem;
        transition: background 0.2s ease;
    }

    .panel-filtros-accesorios .btn-aplicar-filtros:hover {
        background: #146c43;
        border-color: #146c43;
        color: #fff;
    }

    /* =========================================
       BOTÓN FILTROS Y MENSAJE
    ========================================= */
    .barra-filtros-accesorios {
        width: 100%;
    }

    .btn-filtros-accesorios {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 36px;
        padding: 7px 13px;
        border: 1px solid #198754;
        border-radius: 7px;
        background: #fff;
        color: #198754;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.25px;
        transition: background-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-filtros-accesorios:hover,
    .btn-filtros-accesorios.filtros-abiertos {
        background: #198754;
        color: #fff;
        box-shadow: 0 2px 5px rgba(25, 135, 84, 0.15);
    }

    .btn-filtros-accesorios:focus-visible {
        outline: none;
        box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.18);
    }

    .icono-boton-filtros {
        font-size: 0.85rem;
    }

    .flecha-filtros {
        font-size: 0.68rem;
        transition: transform 0.2s ease;
    }

    .btn-filtros-accesorios.filtros-abiertos .flecha-filtros {
        transform: rotate(180deg);
    }

    .btn-filtros-accesorios .badge-filtros-contador {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 22px;
        height: 22px;
        margin-left: 9px !important;
        padding: 0 6px;
        border: 1px solid #c5e7d3;
        border-radius: 6px;
        background: #d1e7dd;
        color: #146c43;
        font-size: 0.72rem;
        font-weight: 800;
    }

    .btn-filtros-accesorios:hover .badge-filtros-contador,
    .btn-filtros-accesorios.filtros-abiertos .badge-filtros-contador {
        border-color: rgba(255, 255, 255, 0.45);
        background: #fff;
        color: #198754;
    }

    .mensaje-coincidencias {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        min-height: 36px;
        padding: 5px 11px;
        border: 1px solid #cde5d5;
        border-radius: 7px;
        background: #f0f8f2;
        color: #245c38;
        font-size: 0.78rem;
        line-height: 1.3;
        animation: aparecerMensajeFiltros 0.2s ease;
    }

    .mensaje-coincidencias .icono-mensaje {
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    .mensaje-coincidencias .texto-mensaje {
        font-weight: 600;
    }

    .mensaje-coincidencias .numero-coincidencias {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 27px;
        min-height: 25px;
        padding: 3px 7px;
        border-radius: 5px;
        background: #d1e7dd;
        color: #146c43;
        font-size: 0.85rem;
        font-weight: 800;
        font-variant-numeric: tabular-nums;
    }

    .mensaje-coincidencias.sin-resultados {
        border-color: #e5d8bd;
        background: #fffaf0;
        color: #795b20;
    }

    .mensaje-coincidencias.sin-resultados .numero-coincidencias {
        background: #f5e8c9;
        color: #795b20;
    }

    @keyframes aparecerMensajeFiltros {
        from { opacity: 0; transform: translateY(-3px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* =========================================
       DATATABLE
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
    #example tbody td:nth-child(2),
    #example tbody td:nth-child(3),
    #example tbody td:nth-child(5),
    #example tbody td:nth-child(6),
    #example tbody td:last-child {
        text-align: center;
    }

    #example tbody td:nth-child(7) {
        min-width: 180px;
        max-width: 340px;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    #example .badge {
        font-size: .72rem;
        font-weight: 700;
        padding: 6px 9px;
        border-radius: 5px;
        letter-spacing: .2px;
    }

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

    /* Filas resaltadas */
    .fila-crear td  { background-color: #d4edda !important; }
    .fila-editar td { background-color: #fff3cd !important; }
    .fila-ver td    { background-color: #cfe2ff !important; }

    /* =========================================
       RESPONSIVE
    ========================================= */
    @media (max-width: 768px) {
        .accesorio-index-body { padding: 12px; }
        .accesorio-index-header { padding: 12px; }
        .panel-filtros-header { padding: 12px; }
        .panel-filtros-body { padding: 12px; }

        .panel-filtros-acciones {
            align-items: stretch;
            flex-direction: column;
        }
        .panel-filtros-acciones > .d-flex { width: 100%; }
        .panel-filtros-acciones > .d-flex .btn { flex: 1; }

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
</style>

<script>
window.addEventListener('load', function() {
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
                infoFiltered: "(filtrado de _MAX_ registros en total)"
            }
        });

    tabla.order([[0, 'desc']]).draw();

    // ===================== FILTROS =====================
    const STORAGE_KEY = 'accesorios_filtros_estado';
    const panel = document.getElementById('panel_filtros');
    const btnToggle = document.getElementById('btn_toggle_filtros');
    const badge = document.getElementById('badge_filtros');
    const msg = document.getElementById('mensaje_coincidencias');

    const campos = {
        equipo: document.getElementById('filtro_equipo'),
        tipo: document.getElementById('filtro_tipo'),
        marca: document.getElementById('filtro_marca'),
        serie: document.getElementById('filtro_serie'),
        estado: document.getElementById('filtro_estado'),
        observaciones: document.getElementById('filtro_observaciones')
    };

    const listas = {
        equipo: document.getElementById('lista_filtro_equipo'),
        marca: document.getElementById('lista_filtro_marca'),
        serie: document.getElementById('lista_filtro_serie')
    };

    function val(el) {
        return el ? String(el.value || '').trim().toUpperCase() : '';
    }

    function filtrosActivos() {
        return Object.values(campos).filter(el => el && String(el.value || '').trim() !== '').length;
    }

    function actualizarBadge() {
        if (!badge) return;
        const n = filtrosActivos();
        badge.textContent = n;
        badge.classList.toggle('d-none', n === 0);
    }

    function mostrarCoincidencias() {
        if (!msg) return;
        if (filtrosActivos() === 0) {
            msg.style.display = 'none';
            msg.innerHTML = '';
            msg.classList.remove('sin-resultados');
            return;
        }

        const n = tabla.page.info().recordsDisplay || 0;
        const sin = n === 0;
        msg.classList.toggle('sin-resultados', sin);

        msg.innerHTML = sin
            ? `<i class="fa-solid fa-magnifying-glass icono-mensaje"></i><span class="texto-mensaje">NO SE ENCONTRARON COINCIDENCIAS</span><span class="numero-coincidencias">0</span>`
            : `<i class="fa-solid fa-circle-check icono-mensaje"></i><span class="texto-mensaje">SE ENCONTRARON ${n} ${n === 1 ? 'COINCIDENCIA' : 'COINCIDENCIAS'}</span><span class="numero-coincidencias">${n}</span>`;

        msg.style.display = 'inline-flex';
    }

    function guardarFiltros() {
        const estado = { panel: panel && panel.style.display !== 'none' };
        Object.keys(campos).forEach(k => { estado[k] = campos[k] ? campos[k].value : ''; });
        localStorage.setItem(STORAGE_KEY, JSON.stringify(estado));
    }

    function restaurarFiltros() {
        const raw = localStorage.getItem(STORAGE_KEY);
        if (!raw) return;
        try {
            const estado = JSON.parse(raw);
            Object.keys(campos).forEach(k => {
                if (campos[k] && estado[k] != null) campos[k].value = estado[k];
            });
            if (panel && estado.panel) panel.style.display = 'block';
            if (btnToggle) btnToggle.classList.toggle('filtros-abiertos', !!estado.panel);
        } catch (e) {}
    }

    function llenarListas() {
        const equipos = new Set();
        const marcas = new Set();
        const series = new Set();

        tabla.rows().every(function() {
            const tr = this.node();
            if (!tr) return;
            const eq = tr.getAttribute('data-equipo');
            const ma = tr.getAttribute('data-marca');
            const se = tr.getAttribute('data-serie');
            if (eq) equipos.add(eq);
            if (ma) marcas.add(ma);
            if (se) series.add(se);
        });

        if (listas.equipo) {
            listas.equipo.innerHTML = '';
            [...equipos].sort().forEach(v => {
                const op = document.createElement('option');
                op.value = v;
                listas.equipo.appendChild(op);
            });
        }
        if (listas.marca) {
            listas.marca.innerHTML = '';
            [...marcas].sort().forEach(v => {
                const op = document.createElement('option');
                op.value = v;
                listas.marca.appendChild(op);
            });
        }
    }

    function actualizarSeries() {
        if (!campos.serie || !listas.serie) return;
        const q = val(campos.serie);
        listas.serie.innerHTML = '';
        if (q.length < 3) return;

        const vistos = new Set();
        tabla.rows().every(function() {
            const serie = this.node()?.getAttribute('data-serie') || '';
            if (serie.includes(q) && !vistos.has(serie)) {
                vistos.add(serie);
                const op = document.createElement('option');
                op.value = serie;
                listas.serie.appendChild(op);
            }
        });
    }

    // Filtro custom
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        if (!settings.nTable || settings.nTable.id !== 'example') return true;
        const fila = tabla.row(dataIndex).node();
        if (!fila) return true;

        const equipo = val(campos.equipo);
        const tipo = val(campos.tipo);
        const marca = val(campos.marca);
        const serie = val(campos.serie);
        const estado = val(campos.estado);
        const obs = val(campos.observaciones);

        if (equipo && !(fila.getAttribute('data-equipo') || '').includes(equipo)) return false;
        if (tipo && (fila.getAttribute('data-tipo') || '') !== tipo) return false;
        if (marca && !(fila.getAttribute('data-marca') || '').includes(marca)) return false;
        if (serie && !(fila.getAttribute('data-serie') || '').includes(serie)) return false;
        if (estado && (fila.getAttribute('data-estado') || '') !== estado) return false;
        if (obs && !(fila.getAttribute('data-observaciones') || '').includes(obs)) return false;

        return true;
    });

    function aplicarFiltros() {
        actualizarSeries();
        guardarFiltros();
        actualizarBadge();
        tabla.draw();
        mostrarCoincidencias();
    }

    function aplicarYScroll() {
        aplicarFiltros();
        document.getElementById('example')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function limpiarFiltros() {
        Object.values(campos).forEach(el => { if (el) el.value = ''; });
        localStorage.removeItem(STORAGE_KEY);
        if (listas.serie) listas.serie.innerHTML = '';
        actualizarBadge();
        tabla.draw();
        mostrarCoincidencias();
    }

    // Eventos
    if (btnToggle) {
        btnToggle.addEventListener('click', function() {
            const abierto = panel.style.display !== 'none';
            panel.style.display = abierto ? 'none' : 'block';
            btnToggle.classList.toggle('filtros-abiertos', !abierto);
            btnToggle.setAttribute('aria-expanded', String(!abierto));
            guardarFiltros();
        });
    }

    document.getElementById('btn_aplicar_filtros')?.addEventListener('click', aplicarYScroll);
    document.getElementById('btn_limpiar_filtros')?.addEventListener('click', limpiarFiltros);

    document.querySelectorAll('.btn-limpiar-campo').forEach(btn => {
        btn.addEventListener('click', function() {
            const el = document.getElementById(btn.getAttribute('data-target'));
            if (el) el.value = '';
            aplicarFiltros();
        });
    });

    Object.values(campos).forEach(el => {
        if (!el) return;
        el.addEventListener('input', function() {
            if (this.classList.contains('campo-mayusculas')) this.value = this.value.toUpperCase();
            aplicarFiltros();
        });
        el.addEventListener('change', aplicarFiltros);
    });

    // Inicialización
    llenarListas();
    restaurarFiltros();
    actualizarBadge();
    if (filtrosActivos()) aplicarFiltros();

    // Resaltado de fila
    function pintarFilaAccesorio() {
        const idFila = @json(session('accesorio_resaltado')) || sessionStorage.getItem('accesorio_resaltado');
        const accFila = @json(session('accesorio_accion')) || sessionStorage.getItem('accesorio_accion');
        sessionStorage.removeItem('accesorio_resaltado');
        sessionStorage.removeItem('accesorio_accion');
        if (!idFila || !accFila) return;

        let nodo = null;
        tabla.rows({ page: 'all' }).every(function() {
            const tr = this.node();
            if (tr && String(tr.getAttribute('data-accesorio-id')) === String(idFila)) nodo = tr;
        });
        if (!nodo) return;

        const visibles = tabla.rows({ search: 'applied', order: 'applied' }).indexes().toArray();
        const posicion = visibles.indexOf(tabla.row(nodo).index());
        if (posicion === -1) return;

        const pagina = Math.floor(posicion / tabla.page.len());
        tabla.page(pagina).draw('page');

        setTimeout(function() {
            const visible = document.querySelector(`#example tbody tr[data-accesorio-id="${idFila}"]`);
            if (!visible) return;
            const color = accFila === 'crear' ? '#d4edda' : accFila === 'editar' ? '#fff3cd' : '#cfe2ff';
            visible.querySelectorAll('td').forEach(td => td.style.backgroundColor = color);
            visible.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => visible.querySelectorAll('td').forEach(td => td.style.backgroundColor = ''), 4000);
        }, 50);
    }

    document.querySelectorAll('.btn-ver-accesorio').forEach(a => {
        a.addEventListener('click', function() {
            const partes = a.getAttribute('href').split('/').filter(Boolean);
            sessionStorage.setItem('accesorio_resaltado', partes.pop());
            sessionStorage.setItem('accesorio_accion', 'ver');
        });
    });

    setTimeout(pintarFilaAccesorio, 300);
    window.pintarFilaAccesorio = pintarFilaAccesorio;

    // Atajos
    document.addEventListener('keydown', function(e) {
        const tag = e.target?.tagName;
        if (tag && ['INPUT','SELECT','TEXTAREA'].includes(tag)) {
            if (e.key === 'Enter') { e.preventDefault(); aplicarYScroll(); }
            return;
        }
        if (e.key === '+' || e.key === '=') {
            e.preventDefault();
            document.getElementById('btn_nuevo_accesorio')?.click();
        }
        if (e.key === 'f' || e.key === 'F') {
            e.preventDefault();
            btnToggle?.click();
            campos.equipo?.focus();
        }
    });
});

function confirmarEliminarAccesorio(form) {
    if (!form) return;
    const fila = form.closest('tr');

    function enviar() {
        if (fila) {
            fila.querySelectorAll('td').forEach(td => td.style.backgroundColor = '#f8d7da');
            fila.style.transition = 'opacity 0.4s';
            setTimeout(() => fila.style.opacity = '0', 200);
            setTimeout(() => form.submit(), 700);
        } else {
            form.submit();
        }
    }

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'warning',
            title: '¿Eliminar accesorio?',
            text: 'Esta acción no se puede deshacer.',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then(r => { if (r.isConfirmed) enviar(); });
    } else if (confirm('¿Eliminar accesorio?')) {
        enviar();
    }
}

window.addEventListener('pageshow', function() {
    if (typeof pintarFilaAccesorio === 'function') setTimeout(pintarFilaAccesorio, 200);
});
</script>