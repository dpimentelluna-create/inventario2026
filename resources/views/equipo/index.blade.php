@extends('layouts.app')

@section('template_title')
    Equipos
@endsection

{{-- HTML --}}
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card equipo-index-card">

                {{-- ENCABEZADO --}}
                <div class="card-header equipo-index-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <span id="card_title" class="fw-bold">
                            <i class="bi bi-laptop me-2 fs-5 text-success"></i>
                            EQUIPOS
                            <small class="d-block fw-normal text-muted mt-1 ms-1">
                                Consulta y administra los equipos tecnológicos registrados en el inventario.
                            </small>
                        </span>

                        <div class="d-flex align-items-center gap-2">
                            @can('registrar')
                            <a href="{{ route('equipos.create') }}" id="btn_nuevo_equipo" class="btn btn-success btn-sm">
                                <i class="fa-solid fa-plus"></i> Registrar Nuevo Equipo
                            </a>
                            @endcan

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

                <div class="card-body equipo-index-body">

                    {{-- BARRA FILTROS --}}
                    <div class="barra-filtros-equipos mb-3">
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            <button type="button" id="btn_toggle_filtros" class="btn btn-filtros-equipos btn-sm"
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
                    <div id="panel_filtros" class="panel-filtros-equipos mb-3" style="display:none;">
                        <div class="panel-filtros-header">
                            <div class="d-flex align-items-center gap-2">
                                <div class="icono-filtros">
                                    <i class="fa-solid fa-sliders"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">FILTROS DE BÚSQUEDA</h6>
                                    <small>Utiliza los campos para encontrar los equipos registrados.</small>
                                </div>
                            </div>
                        </div>

                        <div class="panel-filtros-body">
                            <div class="row g-3">

                                {{-- TIPO --}}
                                <div class="col-12 col-md-6 col-xl-3">
                                    <label for="filtro_tipo" class="form-label">
                                        <i class="fa-solid fa-tag me-1"></i> TIPO
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_tipo" class="form-control campo-mayusculas"
                                            list="lista_filtro_tipo" placeholder="TODOS" autocomplete="off">
                                        <button type="button" class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_tipo" title="Limpiar tipo">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <datalist id="lista_filtro_tipo">
                                        @foreach ($filtroTipos ?? [] as $nombre)
                                            <option value="{{ $nombre }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>

                                {{-- MARCA --}}
                                <div class="col-12 col-md-6 col-xl-3">
                                    <label for="filtro_marca" class="form-label">
                                        <i class="fa-solid fa-industry me-1"></i> MARCA
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_marca" class="form-control campo-mayusculas"
                                            list="lista_filtro_marca" placeholder="ELIJA UN TIPO" autocomplete="off" disabled>
                                        <button type="button" class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_marca" title="Limpiar marca">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <datalist id="lista_filtro_marca"></datalist>
                                </div>

                                {{-- MODELO --}}
                                <div class="col-12 col-md-6 col-xl-3">
                                    <label for="filtro_modelo" class="form-label">
                                        <i class="fa-solid fa-cube me-1"></i> MODELO
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_modelo" class="form-control campo-mayusculas"
                                            list="lista_filtro_modelo" placeholder="ELIJA UNA MARCA" autocomplete="off" disabled>
                                        <button type="button" class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_modelo" title="Limpiar modelo">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <datalist id="lista_filtro_modelo"></datalist>
                                </div>

                                {{-- UBICACIÓN --}}
                                <div class="col-12 col-md-6 col-xl-3">
                                    <label for="filtro_ubicacion" class="form-label">
                                        <i class="fa-solid fa-location-dot me-1"></i> UBICACIÓN
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_ubicacion" class="form-control campo-mayusculas"
                                            list="lista_filtro_ubicacion" placeholder="TODAS" autocomplete="off">
                                        <button type="button" class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_ubicacion" title="Limpiar ubicación">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <datalist id="lista_filtro_ubicacion">
                                        @foreach ($filtroUbicaciones ?? [] as $nombre)
                                            <option value="{{ $nombre }}"></option>
                                        @endforeach
                                    </datalist>
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

                                {{-- SITUACIÓN ADMINISTRATIVA --}}
                                <div class="col-12 col-md-6 col-xl-3">
                                    <label for="filtro_situacion" class="form-label">
                                        <i class="fa-solid fa-box-archive me-1"></i> SITUACIÓN ADMINISTRATIVA
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <select id="filtro_situacion" class="form-select">
                                            <option value="EN_INVENTARIO" selected>EN INVENTARIO</option>
                                            <option value="DE_BAJA">DE BAJA</option>
                                            <option value="TODOS">TODOS</option>
                                        </select>
                                        <button type="button"
                                            class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_situacion"
                                            title="Restablecer situación administrativa">
                                            <i class="fa-solid fa-rotate-left"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- NÚMERO DE SERIE --}}
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

                                {{-- FECHA --}}
                                <div class="col-12 col-md-6 col-xl-3">
                                    <label for="filtro_fecha" class="form-label">
                                        <i class="fa-solid fa-calendar-days me-1"></i> FECHA
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="date" id="filtro_fecha" class="form-control">
                                        <button type="button" id="btn_filtro_hoy" class="btn btn-hoy-filtro" title="Filtrar por hoy">
                                            HOY
                                        </button>
                                        <button type="button" class="btn btn-limpiar-filtro btn-limpiar-campo"
                                            data-target="filtro_fecha" title="Limpiar fecha">
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
                        <table id="example" class="table table-bordered table-hover table-striped align-middle equipo-datatable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="text-center">Tipo</th>
                                    <th class="text-center">N.º Serie</th>
                                    <th class="text-center">Marca</th>
                                    <th class="text-center">Modelo</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Ubicación</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Observación</th>
                                    <th class="text-center columna-acciones">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($equipos as $equipo)
                                    @php
                                        $estado = strtoupper(
                                            $equipo->especificacionesLaptops->estado
                                            ?? $equipo->especificacionesEquipo->estado
                                            ?? ''
                                        );
                                        $fechaIso = $equipo->fecha_registro
                                            ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('Y-m-d')
                                            : '';
                                        $fechaVista = $fechaIso
                                            ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('d-m-Y')
                                            : '-';
                                    @endphp
                    
                                    <tr data-equipo-id="{{ $equipo->id }}"
                                        data-tipo="{{ strtoupper($equipo->tipoEquipo->nombre ?? '') }}"
                                        data-serie="{{ strtoupper($equipo->num_serie ?? '') }}"
                                        data-marca="{{ strtoupper($equipo->marca ?? '') }}"
                                        data-modelo="{{ strtoupper($equipo->modelo ?? '') }}"
                                        data-estado="{{ $estado }}"
                                        data-situacion="{{ strtoupper($equipo->situacion_administrativa ?? 'EN_INVENTARIO') }}"
                                        data-ubicacion="{{ strtoupper($equipo->ubicacione->nombre ?? '') }}"
                                        data-fecha="{{ $fechaIso }}">

                                        <td>{{ $equipo->id }}</td>
                                        <td>{{ $equipo->tipoEquipo->nombre ?? '-' }}</td>
                                        <td class="text-center">{{ $equipo->num_serie }}</td>
                                        <td>{{ $equipo->marca }}</td>
                                        <td>{{ $equipo->modelo }}</td>
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
                                        <td class="text-center">{{ $equipo->ubicacione->nombre ?? '-' }}</td>
                                        <td class="text-center" data-order="{{ $fechaIso ?: '0000-00-00' }}">
                                            {{ $fechaVista }}
                                        </td>
                                        <td>
                                            {{ $equipo->especificacionesLaptops->observaciones
                                                ?? $equipo->especificacionesEquipo->observaciones
                                                ?? '-' }}
                                        </td>
                                        <td class="text-center columna-acciones">
                                            <div class="d-flex justify-content-center align-items-center gap-1">
                                                <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST">
                                                    <a class="btn btn-info btn-accion btn-ver-equipo"
                                                        href="{{ route('equipos.show', $equipo->id) }}">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    @can('registrar')
                                                    <a class="btn btn-warning btn-accion"
                                                        href="{{ route('equipos.edit', $equipo->id) }}">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    @endcan

                                                    @can('eliminar')
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-accion"
                                                        onclick="event.preventDefault(); confirmarEliminarEquipo(this.closest('form'));">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                    @endcan
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

{{-- PANEL PERSONALIZADO DE DESCARGA DE EXPORTACIONES --}}
<div id="exportacion_overlay" class="exportacion-overlay" style="display: none;">
    <div class="exportacion-panel">

        <div class="exportacion-icono">
            <i id="exportacion_icono_archivo" class="fa-solid fa-file-export"></i>
        </div>

        <h5 id="exportacion_titulo">Preparando exportación</h5>

        <p id="exportacion_estado">
            Estamos preparando los equipos seleccionados.
        </p>

        <div class="progress exportacion-barra-contenedor">
            <div
                id="exportacion_progreso"
                class="progress-bar progress-bar-striped progress-bar-animated"
                role="progressbar"
                style="width: 0%;"
                aria-valuenow="0"
                aria-valuemin="0"
                aria-valuemax="100">
            </div>
        </div>

        <div class="exportacion-detalles">
            <span id="exportacion_porcentaje">Preparando...</span>
            <span id="exportacion_tamano">0 MB</span>
        </div>

        <div class="exportacion-acciones">
            <button
                type="button"
                id="btn_cancelar_exportacion"
                class="btn btn-outline-secondary">
                <i class="fa-solid fa-xmark me-1"></i>
                Cancelar
            </button>
        </div>

    </div>
</div>

@endsection

{{-- CSS --}}
<style>
    /* =========================================
       TARJETA PRINCIPAL
    ========================================= */
    .equipo-index-card {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .06);
        overflow: hidden;
    }

    .equipo-index-header {
        background: #e9f7e9;
        color: #212529;
        border-bottom: 1px solid #c8e6c9;
        padding: 15px 18px;
    }

    .equipo-index-header #card_title {
        font-size: 1rem;
        letter-spacing: .2px;
    }

    .equipo-index-body {
        padding: 18px;
    }

    /* =========================================
       BOTONES DEL ENCABEZADO
    ========================================= */
    #btn_nuevo_equipo {
        font-weight: 600;
    }

    .equipo-index-header .btn,
    .equipo-index-body .btn {
        border-radius: 6px;
    }

    /* =========================================
       PANEL DE FILTROS
    ========================================= */
    .panel-filtros-equipos {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
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

    .panel-filtros-equipos .form-label {
        display: block;
        margin-bottom: 6px;
        color: #495057;
        font-size: 0.73rem;
        font-weight: 700;
        letter-spacing: 0.35px;
    }

    .panel-filtros-equipos .form-label i {
        color: #198754;
        font-size: 0.76rem;
    }

    .panel-filtros-equipos .form-control,
    .panel-filtros-equipos .form-select {
        min-height: 34px;
        border-color: #d6dce1;
        border-radius: 5px;
        color: #343a40;
        font-size: 0.82rem;
        background-color: #fff;
    }

    .panel-filtros-equipos .input-group > .form-control,
    .panel-filtros-equipos .input-group > .form-select {
        min-width: 0;
    }

    .panel-filtros-equipos .form-control::placeholder {
        color: #9aa1a8;
        font-size: 0.77rem;
    }

    .panel-filtros-equipos .form-control:focus,
    .panel-filtros-equipos .form-select:focus {
        border-color: #86b7a0;
        box-shadow: 0 0 0 0.15rem rgba(25, 135, 84, 0.12);
    }

    .panel-filtros-equipos .btn-limpiar-filtro {
        min-width: 34px;
        border: 1px solid #d6dce1;
        background: #f8f9fa;
        color: #6c757d;
        transition: all 0.2s ease;
    }

    .panel-filtros-equipos .btn-limpiar-filtro:hover {
        background: #f8d7da;
        border-color: #f1b9bf;
        color: #842029;
    }

    .panel-filtros-equipos .btn-hoy-filtro {
        padding-right: 10px;
        padding-left: 10px;
        border: 1px solid #198754;
        background: #e9f7e9;
        color: #198754;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .panel-filtros-equipos .btn-hoy-filtro:hover {
        background: #198754;
        color: #fff;
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

    .panel-filtros-equipos .btn-limpiar-todos {
        padding: 7px 12px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        background: #fff;
        color: #495057;
        font-weight: 600;
        font-size: 0.76rem;
    }

    .panel-filtros-equipos .btn-limpiar-todos:hover {
        background: #f1f3f5;
        border-color: #adb5bd;
    }

    .panel-filtros-equipos .btn-aplicar-filtros {
        padding: 7px 14px;
        border: 1px solid #198754;
        border-radius: 6px;
        background: #198754;
        color: #fff;
        font-weight: 600;
        font-size: 0.76rem;
        transition: background 0.2s ease;
    }

    .panel-filtros-equipos .btn-aplicar-filtros:hover {
        background: #146c43;
        border-color: #146c43;
        color: #fff;
    }

    /* =========================================
       BOTÓN FILTROS Y MENSAJE
    ========================================= */
    .barra-filtros-equipos {
        width: 100%;
    }

    .btn-filtros-equipos {
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

    .btn-filtros-equipos:hover,
    .btn-filtros-equipos.filtros-abiertos {
        background: #198754;
        color: #fff;
        box-shadow: 0 2px 5px rgba(25, 135, 84, 0.15);
    }

    .btn-filtros-equipos:focus-visible {
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

    .btn-filtros-equipos.filtros-abiertos .flecha-filtros {
        transform: rotate(180deg);
    }

    .btn-filtros-equipos .badge-filtros-contador {
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

    .btn-filtros-equipos:hover .badge-filtros-contador,
    .btn-filtros-equipos.filtros-abiertos .badge-filtros-contador {
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
    #example tbody td:nth-child(3),
    #example tbody td:nth-child(6),
    #example tbody td:nth-child(7),
    #example tbody td:nth-child(8),
    #example tbody td:last-child {
        text-align: center;
    }

    #example tbody td:nth-child(9) {
        min-width: 180px;
        max-width: 320px;
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
        .equipo-index-body { padding: 12px; }
        .equipo-index-header { padding: 12px; }
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
    
/* ==========================================
   PANEL DE DESCARGA DE EXPORTACIONES
========================================== */

.exportacion-overlay {
    position: fixed;
    inset: 0;
    z-index: 100001;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(15, 23, 42, 0.60);
    backdrop-filter: blur(3px);
}

.exportacion-panel {
    width: 100%;
    max-width: 430px;
    padding: 30px 28px;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    background: #fff;
    color: #334155;
    text-align: center;
    box-shadow: 0 20px 60px rgba(15, 23, 42, 0.25);
}

.exportacion-icono {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 64px;
    height: 64px;
    margin: 0 auto 18px;
    border-radius: 50%;
    background: #eff6ff;
    color: #2563eb;
    font-size: 27px;
}

.exportacion-panel h5 {
    margin-bottom: 10px;
    font-size: 1.1rem;
    font-weight: 700;
}

.exportacion-panel p {
    margin-bottom: 22px;
    color: #64748b;
    font-size: 0.9rem;
}

.exportacion-barra-contenedor {
    height: 9px;
    overflow: hidden;
    border-radius: 20px;
    background: #e2e8f0;
}

.exportacion-barra-contenedor .progress-bar {
    background-color: #2563eb;
    transition: width 0.2s ease;
}

.exportacion-detalles {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    margin-top: 10px;
    color: #64748b;
    font-size: 0.82rem;
}

.exportacion-acciones {
    display: flex;
    justify-content: center;
    margin-top: 24px;
}

#btn_cancelar_exportacion {
    min-width: 125px;
    border-radius: 8px;
    font-weight: 600;
}

[data-bs-theme="dark"] .exportacion-panel {
    background: #1e293b;
    color: #e2e8f0;
    border-color: #334155;
}

[data-bs-theme="dark"] .exportacion-panel p,
[data-bs-theme="dark"] .exportacion-detalles {
    color: #cbd5e1;
}

[data-bs-theme="dark"] .exportacion-icono {
    background: #1e3a5f;
    color: #93c5fd;
}

[data-bs-theme="dark"] .exportacion-barra-contenedor {
    background: #334155;
}

@media (max-width: 480px) {
    .exportacion-panel {
        padding: 25px 20px;
    }
}

</style>

{{-- SCRIPTS --}}
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

    tabla.order([[7, 'desc']]).draw();


    
    // ===================== EXPORTAR EQUIPOS =====================

    let controladorExportacionEquipo = null;
    let exportacionEquipoEnCurso = false;

    const botonExcelEquipo = document.getElementById('btn_exportar_excel');
    const botonPdfEquipo = document.getElementById('btn_exportar_pdf');
    const botonCancelarEquipo = document.getElementById('btn_cancelar_exportacion');

    function mostrarPanelExportacionEquipo(tipo) {
        const esExcel = tipo === 'excel';

        document.getElementById('exportacion_overlay').style.display = 'flex';

        document.getElementById('exportacion_titulo').textContent =
            esExcel ? 'Preparando archivo Excel' : 'Preparando archivo PDF';

        document.getElementById('exportacion_estado').textContent =
            'Estamos generando el archivo de los equipos seleccionados.';

        document.getElementById('exportacion_icono_archivo').className =
            esExcel ? 'fa-solid fa-file-excel' : 'fa-solid fa-file-pdf';

        const barra = document.getElementById('exportacion_progreso');

        barra.style.width = '0%';
        barra.setAttribute('aria-valuenow', 0);
        barra.classList.add('progress-bar-animated');

        document.getElementById('exportacion_porcentaje').textContent = 'Preparando...';
        document.getElementById('exportacion_tamano').textContent = '0 MB';
    }

    function ocultarPanelExportacionEquipo() {
        document.getElementById('exportacion_overlay').style.display = 'none';
    }

    function formatearTamanoEquipo(bytes) {
        if (bytes < 1024 * 1024) {
            return (bytes / 1024).toFixed(1) + ' KB';
        }

        return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
    }

    function obtenerNombreArchivoEquipo(respuesta, tipo) {
        const disposicion = respuesta.headers.get('Content-Disposition') || '';

        const nombreUTF8 = disposicion.match(/filename\*=UTF-8''([^;]+)/i);
        const nombreNormal = disposicion.match(/filename="?([^";]+)"?/i);

        if (nombreUTF8) {
            try {
                return decodeURIComponent(nombreUTF8[1]);
            } catch (error) {
                // Se utilizará el nombre alternativo.
            }
        }

        if (nombreNormal) {
            return nombreNormal[1];
        }

        const ahora = new Date();

        const fecha = [
            String(ahora.getDate()).padStart(2, '0'),
            String(ahora.getMonth() + 1).padStart(2, '0'),
            ahora.getFullYear()
        ].join('-');

        const hora = ahora.toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        }).toLowerCase().replace(/\s/g, '');

        return `Equipos_${fecha}_${hora}.${tipo === 'excel' ? 'xlsx' : 'pdf'}`;
    }

    async function exportarEquipos(tipo) {
        if (exportacionEquipoEnCurso) return;

        // Recoger todos los equipos que coinciden con la búsqueda y los filtros.
        // Se mantiene el orden aplicado en DataTables.
        const ids = [];

        tabla.rows({
            search: 'applied',
            order: 'applied'
        }).every(function () {
            const fila = this.node();
            const id = fila ? fila.getAttribute('data-equipo-id') : null;

            if (id) ids.push(id);
        });

        if (ids.length === 0) {
            if (typeof toastr !== 'undefined') {
                toastr.warning('NO HAY EQUIPOS PARA EXPORTAR.');
            } else {
                alert('NO HAY EQUIPOS PARA EXPORTAR.');
            }

            return;
        }

        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

        if (!csrf) {
            toastr.error('No se encontró el token de seguridad. Recarga la página.');
            return;
        }

        const ruta = tipo === 'excel'
            ? @json(route('equipos.export.excel'))
            : @json(route('equipos.export.pdf'));

        const formulario = new FormData();

        formulario.append('_token', csrf);

        ids.forEach(function (id) {
            formulario.append('ids[]', id);
        });

        controladorExportacionEquipo = new AbortController();
        exportacionEquipoEnCurso = true;

        botonExcelEquipo.disabled = true;
        botonPdfEquipo.disabled = true;
        botonCancelarEquipo.disabled = false;

        mostrarPanelExportacionEquipo(tipo);

        const barra = document.getElementById('exportacion_progreso');
        const porcentaje = document.getElementById('exportacion_porcentaje');
        const tamano = document.getElementById('exportacion_tamano');
        const estado = document.getElementById('exportacion_estado');

        try {
            const respuesta = await fetch(ruta, {
                method: 'POST',
                headers: {
                    'Accept': tipo === 'excel'
                        ? 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        : 'application/pdf'
                },
                body: formulario,
                signal: controladorExportacionEquipo.signal
            });

            if (!respuesta.ok) {
                throw new Error(
                    'No se pudo generar el archivo. Verifica la sesión e inténtalo nuevamente.'
                );
            }

            const contentType = (
                respuesta.headers.get('Content-Type') || ''
            ).toLowerCase();

            const archivoValido = tipo === 'excel'
                ? contentType.includes(
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                )
                : contentType.includes('application/pdf');

            if (!archivoValido) {
                throw new Error(
                    'El servidor no devolvió un archivo válido. Recarga la página e inténtalo nuevamente.'
                );
            }

            const longitud = Number(
                respuesta.headers.get('Content-Length')
            ) || 0;

            let bytesRecibidos = 0;
            const fragmentos = [];

            estado.textContent = 'Recibiendo archivo...';

            if (respuesta.body && respuesta.body.getReader) {
                const lector = respuesta.body.getReader();

                while (true) {
                    const resultado = await lector.read();

                    if (resultado.done) break;

                    fragmentos.push(resultado.value);
                    bytesRecibidos += resultado.value.byteLength;

                    tamano.textContent = formatearTamanoEquipo(bytesRecibidos);

                    if (longitud > 0) {
                        const avance = Math.min(
                            100,
                            Math.round((bytesRecibidos / longitud) * 100)
                        );

                        barra.style.width = avance + '%';
                        barra.setAttribute('aria-valuenow', avance);
                        porcentaje.textContent = avance + '%';
                    } else {
                        // Sin tamaño total conocido, no inventamos el porcentaje.
                        barra.style.width = '100%';
                        porcentaje.textContent = 'Descargando...';
                    }
                }
            } else {
                const archivoTemporal = await respuesta.blob();

                fragmentos.push(archivoTemporal);
                bytesRecibidos = archivoTemporal.size;

                tamano.textContent = formatearTamanoEquipo(bytesRecibidos);
            }

            if (bytesRecibidos === 0) {
                throw new Error('El archivo recibido está vacío.');
            }

            barra.style.width = '100%';
            barra.setAttribute('aria-valuenow', 100);
            barra.classList.remove('progress-bar-animated');

            porcentaje.textContent = '100%';
            estado.textContent = 'Archivo recibido. Iniciando descarga...';

            const blob = new Blob(fragmentos, {
                type: tipo === 'excel'
                    ? 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    : 'application/pdf'
            });

            const nombreArchivo = obtenerNombreArchivoEquipo(respuesta, tipo);
            const urlTemporal = URL.createObjectURL(blob);
            const enlace = document.createElement('a');

            enlace.href = urlTemporal;
            enlace.download = nombreArchivo;
            enlace.style.display = 'none';

            document.body.appendChild(enlace);
            enlace.click();
            enlace.remove();

            setTimeout(function () {
                URL.revokeObjectURL(urlTemporal);
            }, 1000);

            ocultarPanelExportacionEquipo();

            toastr.success(
                'El archivo se recibió correctamente y se inició su descarga.',
                'Exportación completada'
            );

        } catch (error) {
            ocultarPanelExportacionEquipo();

            if (error.name === 'AbortError') {
                toastr.info('La descarga fue cancelada.');
            } else {
                console.error('Error al exportar equipos:', error);

                toastr.error(
                    error.message || 'Ocurrió un error al exportar los equipos.'
                );
            }

        } finally {
            exportacionEquipoEnCurso = false;
            controladorExportacionEquipo = null;

            botonExcelEquipo.disabled = false;
            botonPdfEquipo.disabled = false;
            botonCancelarEquipo.disabled = false;
        }
    }

    botonExcelEquipo?.addEventListener('click', function () {
        exportarEquipos('excel');
    });

    botonPdfEquipo?.addEventListener('click', function () {
        exportarEquipos('pdf');
    });

    botonCancelarEquipo?.addEventListener('click', function () {
        if (controladorExportacionEquipo) {
            controladorExportacionEquipo.abort();
        }
    });

    // ===================== FILTROS =====================
    const STORAGE_KEY = 'equipos_filtros_estado';
    const panel = document.getElementById('panel_filtros');
    const btnToggle = document.getElementById('btn_toggle_filtros');
    const badge = document.getElementById('badge_filtros');
    const msg = document.getElementById('mensaje_coincidencias');

    const campos = {
        tipo: document.getElementById('filtro_tipo'),
        marca: document.getElementById('filtro_marca'),
        modelo: document.getElementById('filtro_modelo'),
        ubicacion: document.getElementById('filtro_ubicacion'),
        estado: document.getElementById('filtro_estado'),
        situacion: document.getElementById('filtro_situacion'),
        serie: document.getElementById('filtro_serie'),
        fecha: document.getElementById('filtro_fecha')
    };

    const listas = {
        marca: document.getElementById('lista_filtro_marca'),
        modelo: document.getElementById('lista_filtro_modelo'),
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

    // ===================== FILTROS ENCADENADOS =====================
    function setBloqueo(el, bloqueado, placeholder) {
        if (!el) return;
        el.disabled = bloqueado;
        el.classList.toggle('bg-light', bloqueado);
        if (bloqueado) el.value = '';
        if (placeholder) el.placeholder = placeholder;
    }

    function actualizarEncadenados() {
        const tipo = val(campos.tipo);
        const marca = val(campos.marca);

        if (!tipo) {
            setBloqueo(campos.marca, true, 'ELIJA UN TIPO');
            setBloqueo(campos.modelo, true, 'ELIJA UNA MARCA');
            if (listas.marca) listas.marca.innerHTML = '';
            if (listas.modelo) listas.modelo.innerHTML = '';
            return;
        }

        const marcas = new Set();
        tabla.rows().every(function() {
            const tr = this.node();
            if ((tr?.getAttribute('data-tipo') || '').includes(tipo)) {
                const m = tr.getAttribute('data-marca');
                if (m) marcas.add(m);
            }
        });

        setBloqueo(campos.marca, false, 'TODAS');
        if (listas.marca) {
            listas.marca.innerHTML = '';
            [...marcas].sort().forEach(v => {
                const op = document.createElement('option');
                op.value = v;
                listas.marca.appendChild(op);
            });
        }

        if (!marca) {
            setBloqueo(campos.modelo, true, 'ELIJA UNA MARCA');
            if (listas.modelo) listas.modelo.innerHTML = '';
            return;
        }

        const modelos = new Set();
        tabla.rows().every(function() {
            const tr = this.node();
            const dt = tr?.getAttribute('data-tipo') || '';
            const dm = tr?.getAttribute('data-marca') || '';
            if (dt.includes(tipo) && dm.includes(marca)) {
                const mod = tr.getAttribute('data-modelo');
                if (mod) modelos.add(mod);
            }
        });

        setBloqueo(campos.modelo, false, 'TODOS');
        if (listas.modelo) {
            listas.modelo.innerHTML = '';
            [...modelos].sort().forEach(v => {
                const op = document.createElement('option');
                op.value = v;
                listas.modelo.appendChild(op);
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

        const tipo = val(campos.tipo);
        const marca = val(campos.marca);
        const modelo = val(campos.modelo);
        const ubic = val(campos.ubicacion);
        const est = val(campos.estado);
        const situacion = val(campos.situacion) || 'EN_INVENTARIO';
        const serie = val(campos.serie);
        const fec = campos.fecha ? campos.fecha.value : '';

        if (tipo && !(fila.getAttribute('data-tipo') || '').includes(tipo)) return false;
        if (marca && !(fila.getAttribute('data-marca') || '').includes(marca)) return false;
        if (modelo && !(fila.getAttribute('data-modelo') || '').includes(modelo)) return false;
        if (ubic && !(fila.getAttribute('data-ubicacion') || '').includes(ubic)) return false;
        if (est && (fila.getAttribute('data-estado') || '') !== est) return false;
        const situacionFila = fila.getAttribute('data-situacion') || 'EN_INVENTARIO';

        if (
            situacion !== 'TODOS' &&
            situacionFila !== situacion
        ) {
            return false;
        }
        if (serie && !(fila.getAttribute('data-serie') || '').includes(serie)) return false;
        if (fec && (fila.getAttribute('data-fecha') || '') !== fec) return false;

        return true;
    });

    function aplicarFiltros() {
        actualizarEncadenados();
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
        Object.values(campos).forEach(el => {
            if (el) el.value = '';
        });

        if (campos.situacion) {
            campos.situacion.value = 'EN_INVENTARIO';
        }

        localStorage.removeItem(STORAGE_KEY);

        actualizarEncadenados();

        if (listas.serie) {
            listas.serie.innerHTML = '';
        }

        actualizarBadge();
        tabla.draw();
        mostrarCoincidencias();
        guardarFiltros();
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

    document.getElementById('btn_filtro_hoy')?.addEventListener('click', function() {
        const d = new Date();
        campos.fecha.value = `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`;
        aplicarFiltros();
    });

    
    document.querySelectorAll('.btn-limpiar-campo').forEach(btn => {
        btn.addEventListener('click', function() {
            const el = document.getElementById(btn.getAttribute('data-target'));

            if (el) {
                if (el.id === 'filtro_situacion') {
                    el.value = 'EN_INVENTARIO';
                } else {
                    el.value = '';
                }
            }

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
    const parametrosURL = new URLSearchParams(window.location.search);
    const desdeDashboard = parametrosURL.get('desde_dashboard') === '1';
    const NUEVO_KEY = STORAGE_KEY + '_nuevo_equipo';
    const vieneDeCrear = localStorage.getItem(NUEVO_KEY) === '1' || @json(session('equipo_accion')) === 'crear';

    if (campos.situacion) {
    campos.situacion.value = 'EN_INVENTARIO';
    }

    
if (desdeDashboard) {
    localStorage.removeItem(STORAGE_KEY);

    Object.values(campos).forEach(el => {
        if (el) el.value = '';
    });

    // Valores enviados por las tarjetas del dashboard.
    if (campos.situacion) {
        const situacionURL = parametrosURL.get('situacion');

        campos.situacion.value = [
            'EN_INVENTARIO',
            'DE_BAJA',
            'TODOS'
        ].includes(situacionURL)
            ? situacionURL
            : 'EN_INVENTARIO';
    }

    if (campos.estado) {
        campos.estado.value = parametrosURL.get('estado') || '';
    }

    // Abrir el panel cuando hay filtros provenientes del dashboard.
    const hayFiltrosDashboard =
        (campos.situacion && campos.situacion.value !== 'EN_INVENTARIO') ||
        (campos.estado && campos.estado.value !== '');

    if (panel) {
        panel.style.display = hayFiltrosDashboard ? 'block' : 'none';
    }

    if (btnToggle) {
        btnToggle.classList.toggle('filtros-abiertos', hayFiltrosDashboard);
        btnToggle.setAttribute('aria-expanded', String(hayFiltrosDashboard));
    }

    aplicarFiltros();

    window.history.replaceState(
        {},
        document.title,
        window.location.pathname
    );
} else if (!vieneDeCrear) {
        restaurarFiltros();
        actualizarBadge();
        if (filtrosActivos()) aplicarFiltros();
    }

    // Resaltado de fila
    function pintarFilaEquipo() {
        const idFila = @json(session('equipo_resaltado')) || sessionStorage.getItem('equipo_resaltado');
        const accFila = @json(session('equipo_accion')) || sessionStorage.getItem('equipo_accion');
        sessionStorage.removeItem('equipo_resaltado');
        sessionStorage.removeItem('equipo_accion');
        if (!idFila || !accFila) return;

        let nodo = null;
        tabla.rows({ page: 'all' }).every(function() {
            const tr = this.node();
            if (tr && String(tr.getAttribute('data-equipo-id')) === String(idFila)) nodo = tr;
        });
        if (!nodo) return;

        const visibles = tabla.rows({ search: 'applied', order: 'applied' }).indexes().toArray();
        const posicion = visibles.indexOf(tabla.row(nodo).index());
        if (posicion === -1) return;

        const pagina = Math.floor(posicion / tabla.page.len());
        tabla.page(pagina).draw('page');

        setTimeout(function() {
            const visible = document.querySelector(`#example tbody tr[data-equipo-id="${idFila}"]`);
            if (!visible) return;
            const color = accFila === 'crear' ? '#d4edda' : accFila === 'editar' ? '#fff3cd' : '#cfe2ff';
            visible.querySelectorAll('td').forEach(td => td.style.backgroundColor = color);
            visible.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => visible.querySelectorAll('td').forEach(td => td.style.backgroundColor = ''), 4000);
        }, 50);
    }

    document.querySelectorAll('.btn-ver-equipo').forEach(a => {
        a.addEventListener('click', function() {
            const partes = a.getAttribute('href').split('/').filter(Boolean);
            sessionStorage.setItem('equipo_resaltado', partes.pop());
            sessionStorage.setItem('equipo_accion', 'ver');
        });
    });

    setTimeout(pintarFilaEquipo, 300);
    window.pintarFilaEquipo = pintarFilaEquipo;

    // Atajos
    document.addEventListener('keydown', function(e) {
        const tag = e.target?.tagName;
        if (tag && ['INPUT','SELECT','TEXTAREA'].includes(tag)) {
            if (e.key === 'Enter') { e.preventDefault(); aplicarYScroll(); }
            return;
        }
        if (e.key === '+' || e.key === '=') {
            e.preventDefault();
            document.getElementById('btn_nuevo_equipo')?.click();
        }
        if (e.key === 'f' || e.key === 'F') {
            e.preventDefault();
            btnToggle?.click();
            campos.tipo?.focus();
        }
    });
});

function confirmarEliminarEquipo(form) {
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
            title: '¿Eliminar equipo?',
            text: 'Esta acción no se puede deshacer.',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then(r => { if (r.isConfirmed) enviar(); });
    } else if (confirm('¿Eliminar equipo?')) {
        enviar();
    }
}

window.addEventListener('pageshow', function() {
    if (typeof pintarFilaEquipo === 'function') setTimeout(pintarFilaEquipo, 200);
});
</script>