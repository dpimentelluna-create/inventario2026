<tittle> Ve

@extends('layouts.app')

@section('template_title')
    Ver Préstamo
@endsection

@section('content')
@php
    $nombreSol = trim(
        ($prestamo->docente->apellidos ?? '') . ' ' .
        ($prestamo->docente->nombres ?? '')
    );

    $fechaVista = $prestamo->fecha
        ? \Carbon\Carbon::parse($prestamo->fecha)->format('d-m-Y')
        : '—';

    $hIni = $prestamo->hora_inicio
        ? \Carbon\Carbon::parse($prestamo->hora_inicio)->format('h:i A')
        : '—';

    $hFin = $prestamo->hora_fin
        ? \Carbon\Carbon::parse($prestamo->hora_fin)->format('h:i A')
        : 'ACTIVO';

    $equipos = $prestamo->prestamoEquipos;
    $totalEquipos = $equipos->count();

    $totalAccesorios = $equipos->sum(
        fn($pe) => $pe->prestamoAccesorios->count()
    );

    $malogrados = $equipos->filter(
        fn($pe) => strtoupper($pe->estado ?? '') === 'MALOGRADO'
    )->count() + $equipos->sum(
        fn($pe) => $pe->prestamoAccesorios->filter(
            fn($a) => strtoupper($a->estado ?? '') === 'MALOGRADO'
        )->count()
    );

    $borde = function ($estado) {
        $estado = strtoupper($estado ?? '');

        if ($estado === 'MALOGRADO') return 'borde-malogrado';
        if ($estado === 'REGULAR') return 'borde-regular';
        if ($estado === 'BUENO') return 'borde-bueno';

        return 'borde-neutro';
    };
@endphp

<section class="content container-fluid prestamo-show">

    <div class="row">
        <div class="col-12">

            <div class="card tarjeta-principal">

                {{-- ENCABEZADO --}}
                <div class="card-header encabezado-show">
                    <div class="encabezado-contenido">
                        <div class="icono-encabezado">
                            <i class="bi bi-clipboard2-check"></i>
                        </div>

                        <div>
                            <h4 class="titulo-show">DETALLE DEL PRÉSTAMO</h4>
                            <p class="subtitulo-show">
                                Consulta los datos del préstamo, equipos y accesorios asociados.
                            </p>
                        </div>
                    </div>

                    {{-- EXPORTAR --}}
                    <div class="dropdown no-print">
                        <button
                            class="btn btn-primary dropdown-toggle boton-exportar"
                            type="button"
                            id="btn_menu_exportar"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa fa-download me-1"></i>
                            EXPORTAR
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end menu-exportar"
                            aria-labelledby="btn_menu_exportar">

                            <li>
                                <button
                                    type="button"
                                    class="dropdown-item opcion-exportar"
                                    id="btn_acta_pdf">
                                    <i class="fa fa-file-pdf text-danger me-2"></i>
                                    Descargar PDF
                                </button>
                            </li>

                            <li>
                                <button
                                    type="button"
                                    class="dropdown-item opcion-exportar"
                                    id="btn_acta_excel">
                                    <i class="fa fa-file-excel text-success me-2"></i>
                                    Descargar Excel
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card-body cuerpo-show">

                    {{-- CUATRO CUADROS DE INFORMACIÓN: SE CONSERVAN --}}
                    <div class="row g-3 mb-4">

                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="bloque-dato">
                                <div class="etiqueta">
                                    <i class="bi bi-person me-1"></i>
                                    SOLICITANTE
                                </div>

                                <div class="valor">
                                    {{ $nombreSol ?: '—' }}
                                </div>

                                <div class="subvalor">
                                    {{ $prestamo->cargo ?: 'SIN CARGO' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="bloque-dato">
                                <div class="etiqueta">
                                    <i class="bi bi-calendar me-1"></i>
                                    FECHA
                                </div>

                                <div class="valor">
                                    {{ $fechaVista }}
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="bloque-dato">
                                <div class="etiqueta">
                                    <i class="bi bi-clock me-1"></i>
                                    HORARIO
                                </div>

                                <div class="valor">
                                    {{ $hIni }} → {{ $hFin }}
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="bloque-dato">
                                <div class="etiqueta">
                                    <i class="bi bi-activity me-1"></i>
                                    ESTADO
                                </div>

                                <div class="valor">
                                    @if ($prestamo->estado === 'ACTIVO')
                                        <span class="badge bg-success fs-6">
                                            ACTIVO
                                        </span>
                                    @else
                                        <span class="badge bg-secondary fs-6">
                                            TERMINADO
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- RESUMEN DE EQUIPOS Y ACCESORIOS --}}
                    <div class="seccion-resumen mb-4">
                        <div class="titulo-seccion">
                            <div>
                                <h5>RESUMEN DEL PRÉSTAMO</h5>
                                <p>Estado general de los recursos asociados.</p>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 resumen-chips">
                            <span class="chip">
                                <i class="bi bi-pc-display me-1"></i>
                                {{ $totalEquipos }}
                                equipo{{ $totalEquipos === 1 ? '' : 's' }}
                            </span>

                            <span class="chip">
                                <i class="bi bi-plug me-1"></i>
                                {{ $totalAccesorios }}
                                accesorio{{ $totalAccesorios === 1 ? '' : 's' }}
                            </span>

                            @if ($malogrados > 0)
                                <span class="chip chip-alerta">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    {{ $malogrados }}
                                    malogrado{{ $malogrados === 1 ? '' : 's' }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- LISTADO DE EQUIPOS --}}
                    <div class="seccion-equipos">

                        <div class="titulo-seccion titulo-equipos">
                            <div>
                                <h5>EQUIPOS DEL PRÉSTAMO</h5>
                                <p>Detalle de cada equipo y sus accesorios registrados.</p>
                            </div>

                            <span class="contador-equipos">
                                {{ $totalEquipos }}
                                {{ $totalEquipos === 1 ? 'EQUIPO' : 'EQUIPOS' }}
                            </span>
                        </div>

                        @forelse ($equipos as $indice => $prestamoEquipo)

                            @php
                                $equipo = $prestamoEquipo->equipo;
                                $estadoEq = strtoupper($prestamoEquipo->estado ?? '');
                            @endphp

                            <div class="card tarjeta-equipo {{ $borde($estadoEq) }}">

                                {{-- CABECERA DE CADA EQUIPO --}}
                                <div class="card-header cabecera-equipo">
                                    <div class="identificacion-equipo">

                                        <span class="numero-equipo">
                                            {{ str_pad($indice + 1, 2, '0', STR_PAD_LEFT) }}
                                        </span>

                                        <div class="datos-equipo">
                                            <div class="etiqueta">
                                                EQUIPO {{ $indice + 1 }}
                                            </div>

                                            <h6 class="nombre-equipo">
                                                {{ $equipo->tipoEquipo->nombre ?? 'SIN TIPO' }}
                                                @if ($equipo && $equipo->marca)
                                                    · {{ $equipo->marca }}
                                                @endif
                                                @if ($equipo && $equipo->modelo)
                                                    {{ $equipo->modelo }}
                                                @endif
                                            </h6>

                                            <div class="serie-equipo">
                                                <i class="bi bi-upc-scan me-1"></i>
                                                N.º SERIE:
                                                <span class="font-monospace">
                                                    {{ $equipo->num_serie ?? 'S/N' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <span class="badge estado-equipo
                                        {{ $estadoEq === 'MALOGRADO'
                                            ? 'bg-danger'
                                            : ($estadoEq === 'REGULAR'
                                                ? 'bg-warning text-dark'
                                                : ($estadoEq === 'BUENO'
                                                    ? 'bg-success'
                                                    : 'bg-secondary')) }}">
                                        {{ $estadoEq ?: '—' }}
                                    </span>
                                </div>

                                <div class="card-body cuerpo-equipo">

                                    {{-- OBSERVACIÓN DEL EQUIPO --}}
                                    <div class="bloque-observacion mb-3">
                                        <div class="etiqueta mb-1">
                                            <i class="bi bi-chat-left-text me-1"></i>
                                            OBSERVACIÓN DEL EQUIPO
                                        </div>

                                        <div class="{{ $prestamoEquipo->observacion
                                            ? 'texto-observacion'
                                            : 'text-muted' }}">
                                            {{ $prestamoEquipo->observacion ?: 'Sin observaciones registradas.' }}
                                        </div>
                                    </div>

                                    {{-- ACCESORIOS --}}
                                    <div class="cabecera-accesorios">
                                        <h6>
                                            <i class="bi bi-usb-plug me-1"></i>
                                            ACCESORIOS ASOCIADOS
                                        </h6>

                                        <span class="contador-accesorios">
                                            {{ $prestamoEquipo->prestamoAccesorios->count() }}
                                        </span>
                                    </div>

                                    @if ($prestamoEquipo->prestamoAccesorios->count())

                                        <div class="table-responsive tabla-accesorios">
                                            <table class="table table-hover table-sm align-middle mb-0">

                                                <thead>
                                                    <tr>
                                                        <th>TIPO</th>
                                                        <th>MARCA</th>
                                                        <th>N.º SERIE</th>
                                                        <th>ESTADO</th>
                                                        <th>OBSERVACIÓN</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($prestamoEquipo->prestamoAccesorios as $prestamoAccesorio)

                                                        @php
                                                            $acc = $prestamoAccesorio->accesorioEquipo;
                                                            $estadoAcc = strtoupper($prestamoAccesorio->estado ?? '');
                                                        @endphp

                                                        <tr>
                                                            <td>
                                                                {{ $acc->tipo ?? '—' }}
                                                            </td>

                                                            <td>
                                                                {{ $acc->marca ?? '—' }}
                                                            </td>

                                                            <td class="font-monospace">
                                                                {{ $acc->num_serie ?? '—' }}
                                                            </td>

                                                            <td>
                                                                <span class="badge
                                                                    {{ $estadoAcc === 'MALOGRADO'
                                                                        ? 'bg-danger'
                                                                        : ($estadoAcc === 'REGULAR'
                                                                            ? 'bg-warning text-dark'
                                                                            : ($estadoAcc === 'BUENO'
                                                                                ? 'bg-success'
                                                                                : 'bg-secondary')) }}">
                                                                    {{ $estadoAcc ?: '—' }}
                                                                </span>
                                                            </td>

                                                            <td class="{{ $prestamoAccesorio->observacion
                                                                ? ''
                                                                : 'text-muted' }}">
                                                                {{ $prestamoAccesorio->observacion ?: 'Sin observaciones' }}
                                                            </td>
                                                        </tr>

                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>

                                    @else

                                        <div class="sin-accesorios">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Este equipo no tiene accesorios registrados en el préstamo.
                                        </div>

                                    @endif

                                </div>
                            </div>

                        @empty

                            <div class="estado-vacio">
                                <i class="bi bi-inbox"></i>
                                <h6>No hay equipos asociados</h6>
                                <p>Este préstamo no tiene equipos registrados.</p>
                            </div>

                        @endforelse

                    </div>

                    {{-- ACCIONES INFERIORES --}}
                    <div class="acciones-inferiores no-print">
                        <div class="texto-acciones">
                            <strong>¿Necesitas realizar otra acción?</strong>
                            <span>Regresa al listado o modifica los datos del préstamo.</span>
                        </div>

                        <div class="botones-inferiores">
                            <a
                                class="btn btn-outline-secondary"
                                href="{{ route('prestamos.index') }}">
                                <i class="fa fa-arrow-left me-1"></i>
                                VOLVER
                            </a>

                            <a
                                class="btn btn-success"
                                href="{{ route('prestamos.edit', $prestamo->id) }}">
                                <i class="fa fa-edit me-1"></i>
                                EDITAR PRÉSTAMO
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- PANEL DE DESCARGA: CONSERVA LOS ID UTILIZADOS POR TU SCRIPT --}}
    <div id="acta_descarga_overlay" class="acta-descarga-overlay" hidden>
        <div class="acta-descarga-panel">

            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="spinner-border text-primary flex-shrink-0" role="status">
                    <span class="visually-hidden">Procesando...</span>
                </div>

                <div class="flex-grow-1">
                    <strong id="acta_descarga_titulo">PREPARANDO ARCHIVO</strong>

                    <div id="acta_descarga_estado" class="text-muted small">
                        Esperando respuesta del servidor...
                    </div>
                </div>
            </div>

            <div class="progress" style="height: 10px;">
                <div
                    id="acta_descarga_progreso"
                    class="progress-bar progress-bar-striped progress-bar-animated"
                    role="progressbar"
                    style="width: 0%"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    aria-valuenow="0">
                </div>
            </div>

            <div class="d-flex justify-content-between mt-2 small text-muted">
                <span id="acta_descarga_porcentaje">Procesando...</span>
                <span id="acta_descarga_tamano"></span>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button
                    type="button"
                    id="btn_cancelar_descarga"
                    class="btn btn-outline-danger btn-sm">
                    <i class="fa fa-times"></i> CANCELAR
                </button>
            </div>

        </div>
    </div>

</section>

<style>
    /* CONTENEDOR GENERAL */
    .prestamo-show {
        padding-bottom: 1.5rem;
    }

    .tarjeta-principal {
        border: 1px solid #e3e7eb;
        border-radius: 12px;
        overflow: visible;
        box-shadow: 0 3px 12px rgba(0, 0, 0, .04);
    }

    /* ENCABEZADO */
    .encabezado-show {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        background: #fff;
        border-bottom: 1px solid #e9ecef;
        border-radius: 12px 12px 0 0;
    }

    .encabezado-contenido {
        display: flex;
        align-items: center;
        gap: .9rem;
        min-width: 0;
    }

    .icono-encabezado {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        flex-shrink: 0;
        background: #eaf2ff;
        color: #0d6efd;
        border-radius: 10px;
        font-size: 1.4rem;
    }

    .titulo-show {
        margin: 0 0 .25rem;
        font-size: 1.15rem;
        font-weight: 750;
        color: #212529;
    }

    .subtitulo-show {
        margin: 0;
        color: #6c757d;
        font-size: .875rem;
    }

    .boton-exportar {
        font-weight: 600;
        padding: .6rem 1rem;
        white-space: nowrap;
    }

    .menu-exportar {
        min-width: 200px;
        padding: .4rem;
        border: 1px solid #e3e7eb;
        border-radius: 9px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, .12);
    }

    .opcion-exportar {
        padding: .65rem .75rem;
        border-radius: 6px;
        font-size: .9rem;
    }

    /* CUERPO */
    .cuerpo-show {
        padding: 1.5rem;
        background: #fff;
        border-radius: 0 0 12px 12px;
    }

    /* CUATRO CUADROS DE INFORMACIÓN */
    .etiqueta {
        font-size: .75rem;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: #6c757d;
        font-weight: 700;
    }

    .valor {
        font-weight: 700;
        font-size: 1.05rem;
        overflow-wrap: anywhere;
        margin-top: .2rem;
    }

    .subvalor {
        color: #6c757d;
        font-size: .875rem;
        margin-top: .15rem;
    }

    .bloque-dato {
        background: #f8f9fa;
        border: 1px solid #edf0f2;
        border-radius: 9px;
        padding: .85rem 1rem;
        height: 100%;
    }

    /* SECCIONES */
    .seccion-resumen {
        padding: 1.1rem 1.2rem;
        background: #fafbfc;
        border: 1px solid #e9ecef;
        border-radius: 10px;
    }

    .titulo-seccion {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: .75rem;
        margin-bottom: 1rem;
    }

    .titulo-seccion h5 {
        margin: 0;
        font-size: .95rem;
        font-weight: 750;
        color: #343a40;
    }

    .titulo-seccion p {
        margin: .25rem 0 0;
        color: #6c757d;
        font-size: .85rem;
    }

    .chip {
        display: inline-flex;
        align-items: center;
        background: #e9ecef;
        color: #343a40;
        border-radius: 7px;
        padding: .45rem .75rem;
        font-size: .85rem;
        font-weight: 600;
    }

    .chip-alerta {
        background: #f8d7da;
        color: #842029;
    }

    .titulo-equipos {
        padding-bottom: .9rem;
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 1.2rem;
    }

    .contador-equipos,
    .contador-accesorios {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eef2f6;
        color: #495057;
        border-radius: 6px;
        padding: .35rem .6rem;
        font-size: .75rem;
        font-weight: 700;
    }

    /* TARJETAS DE EQUIPOS */
    .tarjeta-equipo {
        border: 1px solid #e3e7eb;
        border-left-width: 5px;
        border-radius: 9px;
        margin-bottom: 1.25rem;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .025);
    }

    .borde-bueno {
        border-left-color: #198754;
    }

    .borde-regular {
        border-left-color: #ffc107;
    }

    .borde-malogrado {
        border-left-color: #dc3545;
    }

    .borde-neutro {
        border-left-color: #adb5bd;
    }

    .cabecera-equipo {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        padding: 1rem 1.15rem;
        background: #fafbfc;
        border-bottom: 1px solid #e9ecef;
    }

    .identificacion-equipo {
        display: flex;
        align-items: center;
        gap: .85rem;
        min-width: 0;
    }

    .numero-equipo {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        border-radius: 9px;
        background: #eaf2ff;
        color: #0d6efd;
        font-weight: 750;
        font-size: .95rem;
    }

    .datos-equipo {
        min-width: 0;
    }

    .nombre-equipo {
        margin: .2rem 0;
        font-size: .98rem;
        font-weight: 750;
        color: #343a40;
        overflow-wrap: anywhere;
    }

    .serie-equipo {
        font-size: .82rem;
        color: #6c757d;
        overflow-wrap: anywhere;
    }

    .estado-equipo {
        font-size: .76rem;
        padding: .45rem .65rem;
    }

    .cuerpo-equipo {
        padding: 1.2rem;
    }

    .bloque-observacion {
        padding: .85rem 1rem;
        background: #fafbfc;
        border: 1px solid #edf0f2;
        border-radius: 7px;
    }

    .texto-observacion {
        color: #495057;
        overflow-wrap: anywhere;
    }

    /* TABLA DE ACCESORIOS */
    .cabecera-accesorios {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        margin-bottom: .65rem;
    }

    .cabecera-accesorios h6 {
        margin: 0;
        font-size: .82rem;
        font-weight: 750;
        color: #495057;
    }

    .tabla-accesorios {
        border: 1px solid #e3e7eb;
        border-radius: 7px;
    }

    .tabla-accesorios .table {
        min-width: 600px;
    }

    .tabla-accesorios thead th {
        background: #f5f7f9;
        color: #495057;
        font-size: .74rem;
        letter-spacing: .025em;
        white-space: nowrap;
        padding: .75rem;
        border-bottom: 1px solid #dee2e6;
    }

    .tabla-accesorios tbody td {
        padding: .7rem .75rem;
        font-size: .85rem;
    }

    .sin-accesorios {
        padding: .8rem 1rem;
        background: #f8f9fa;
        border-radius: 7px;
        color: #6c757d;
        font-size: .875rem;
    }

    .estado-vacio {
        padding: 2.5rem 1rem;
        text-align: center;
        background: #fafbfc;
        border: 1px dashed #ced4da;
        border-radius: 9px;
    }

    .estado-vacio > i {
        display: block;
        font-size: 2rem;
        color: #adb5bd;
        margin-bottom: .75rem;
    }

    .estado-vacio h6 {
        font-weight: 700;
    }

    .estado-vacio p {
        margin: 0;
        color: #6c757d;
        font-size: .875rem;
    }

    /* ACCIONES INFERIORES */
    .acciones-inferiores {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.25rem;
        border-top: 1px solid #e9ecef;
    }

    .texto-acciones {
        display: flex;
        flex-direction: column;
        gap: .2rem;
    }

    .texto-acciones strong {
        color: #343a40;
        font-size: .9rem;
    }

    .texto-acciones span {
        color: #6c757d;
        font-size: .82rem;
    }

    .botones-inferiores {
        display: flex;
        flex-wrap: wrap;
        gap: .6rem;
    }

    .botones-inferiores .btn {
        font-size: .85rem;
        font-weight: 650;
        padding: .6rem .9rem;
    }

    /* PANEL DE DESCARGA */
    .acta-descarga-overlay {
        position: fixed;
        inset: 0;
        z-index: 20000;
        background: rgba(0, 0, 0, .45);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .acta-descarga-overlay[hidden] {
        display: none !important;
    }

    .acta-descarga-panel {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        width: 100%;
        max-width: 430px;
        box-shadow: 0 10px 35px rgba(0, 0, 0, .2);
    }

    .acta-descarga-panel strong {
        font-size: .95rem;
    }

    /* IMPRESIÓN */
    @media print {
        #sidebar,
        .dot-spinner-container,
        .no-print,
        .btn,
        .dropdown,
        footer,
        .acciones-inferiores {
            display: none !important;
        }

        #content-wrapper,
        main {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        body {
            background: #fff !important;
        }

        .card,
        .seccion-resumen,
        .bloque-observacion {
            box-shadow: none !important;
            break-inside: avoid;
        }

        * {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }

    /* PANTALLAS PEQUEÑAS */
    @media (max-width: 576px) {
        .encabezado-show {
            padding: 1rem;
        }

        .cuerpo-show {
            padding: 1rem;
        }

        .subtitulo-show {
            font-size: .8rem;
        }

        .encabezado-contenido {
            align-items: flex-start;
        }

        .icono-encabezado {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }

        .boton-exportar {
            width: 100%;
        }

        .encabezado-show > .dropdown {
            width: 100%;
        }

        .cabecera-equipo {
            align-items: flex-start;
        }

        .acciones-inferiores {
            align-items: stretch;
        }

        .botones-inferiores {
            width: 100%;
        }

        .botones-inferiores .btn {
            flex: 1;
        }

        .texto-acciones {
            margin-bottom: .25rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnPdf = document.getElementById('btn_acta_pdf');
        const btnExcel = document.getElementById('btn_acta_excel');

        const overlay = document.getElementById('acta_descarga_overlay');
        const titulo = document.getElementById('acta_descarga_titulo');
        const estado = document.getElementById('acta_descarga_estado');
        const barra = document.getElementById('acta_descarga_progreso');
        const porcentaje = document.getElementById('acta_descarga_porcentaje');
        const tamano = document.getElementById('acta_descarga_tamano');
        const btnCancelar = document.getElementById('btn_cancelar_descarga');

        if (!btnPdf || !btnExcel || !overlay || !btnCancelar ||
            !titulo || !estado || !barra || !porcentaje || !tamano) {
            console.error('Faltan elementos HTML necesarios para descargar las actas.');
            return;
        }

        let descargando = false;
        let controladorDescarga = null;

        function notificar(tipo, mensaje) {
            if (typeof toastr !== 'undefined' &&
                typeof toastr[tipo] === 'function') {
                toastr[tipo](mensaje);
            } else {
                console.log(mensaje);
            }
        }

        function mostrarPanel(nombre) {
            overlay.hidden = false;
            titulo.textContent = 'PREPARANDO ARCHIVO ' + nombre;
            estado.textContent = 'Esperando respuesta del servidor...';

            barra.style.width = '0%';
            barra.classList.add('progress-bar-animated');
            barra.setAttribute('aria-valuenow', '0');

            porcentaje.textContent = 'Procesando...';
            tamano.textContent = '';
        }

        function actualizarProgreso(recibido, total) {
            const mbRecibidos = (recibido / 1048576).toFixed(2);

            if (total > 0) {
                const mbTotal = (total / 1048576).toFixed(2);
                const avance = Math.min(
                    100,
                    Math.round((recibido / total) * 100)
                );

                barra.style.width = avance + '%';
                barra.setAttribute('aria-valuenow', avance);
                porcentaje.textContent = avance + '%';
                tamano.textContent = mbRecibidos + ' / ' + mbTotal + ' MB';
            } else {
                // No inventar un porcentaje si se desconoce el tamaño total.
                barra.style.width = '100%';
                barra.setAttribute('aria-valuenow', '0');
                porcentaje.textContent = 'Recibiendo...';
                tamano.textContent = mbRecibidos + ' MB';
            }

            estado.textContent = 'Recibiendo archivo del servidor...';
        }

        function obtenerNombreArchivo(respuesta, extension) {
            const disposicion =
                respuesta.headers.get('Content-Disposition') || '';

            const utf8 = disposicion.match(
                /filename\*=UTF-8''([^;]+)/i
            );

            if (utf8) {
                try {
                    return decodeURIComponent(utf8[1].trim().replace(/["']/g, ''));
                } catch (error) {
                    console.warn('No se pudo interpretar el nombre UTF-8.');
                }
            }

            const normal = disposicion.match(/filename="?([^";]+)"?/i);

            if (normal) {
                return normal[1].trim();
            }

            return 'Acta_Prestamo_{{ $prestamo->id }}.' + extension;
        }

        async function descargarActa(url, nombre, extension, mimeEsperado) {
            if (descargando) return;

            descargando = true;
            btnPdf.disabled = true;
            btnExcel.disabled = true;
            btnCancelar.disabled = false;

            controladorDescarga = new AbortController();

            const controlador = controladorDescarga;
            let objectUrl = null;

            mostrarPanel(nombre);
            notificar('info', 'PREPARANDO ARCHIVO ' + nombre + '...');

            try {
                const respuesta = await fetch(url, {
                    method: 'GET',
                    credentials: 'same-origin',
                    signal: controlador.signal,
                    headers: {
                        'Accept': mimeEsperado
                    }
                });

                if (!respuesta.ok) {
                    throw new Error(
                        'El servidor respondió con el estado HTTP ' +
                        respuesta.status + '.'
                    );
                }

                const tipoRespuesta = (
                    respuesta.headers.get('Content-Type') || ''
                ).toLowerCase();

                if (
                    tipoRespuesta.includes('text/html') ||
                    tipoRespuesta.includes('application/json')
                ) {
                    throw new Error(
                        'El servidor devolvió una página o un mensaje de error ' +
                        'en lugar del archivo. Comprueba la sesión y los registros.'
                    );
                }

                const longitud = Number(
                    respuesta.headers.get('Content-Length')
                );

                const total = Number.isFinite(longitud) && longitud > 0 ?
                    longitud :
                    0;

                let blob;

                if (respuesta.body && respuesta.body.getReader) {
                    const lector = respuesta.body.getReader();
                    const fragmentos = [];
                    let recibido = 0;

                    try {
                        while (true) {
                            const resultado = await lector.read();

                            if (resultado.done) break;

                            fragmentos.push(resultado.value);
                            recibido += resultado.value.byteLength;

                            actualizarProgreso(recibido, total);
                        }
                    } catch (error) {
                        try {
                            await lector.cancel();
                        } catch (cancelError) {
                            // La lectura puede estar cancelada por el navegador.
                        }

                        throw error;
                    }

                    blob = new Blob(fragmentos, {
                        type: tipoRespuesta || mimeEsperado
                    });
                } else {
                    blob = await respuesta.blob();
                    actualizarProgreso(blob.size, total || blob.size);
                }

                // Evitar iniciar una descarga si se canceló la operación.
                if (controlador.signal.aborted) {
                    throw new DOMException(
                        'La descarga fue cancelada.',
                        'AbortError'
                    );
                }

                if (blob.size === 0) {
                    throw new Error('El archivo recibido está vacío.');
                }

                const nombreArchivo = obtenerNombreArchivo(
                    respuesta,
                    extension
                );

                estado.textContent = 'Archivo recibido. Iniciando descarga...';
                porcentaje.textContent = '100%';
                barra.style.width = '100%';
                barra.setAttribute('aria-valuenow', '100');
                barra.classList.remove('progress-bar-animated');
                tamano.textContent = (blob.size / 1048576).toFixed(2) + ' MB';

                objectUrl = URL.createObjectURL(blob);

                const enlace = document.createElement('a');
                enlace.href = objectUrl;
                enlace.download = nombreArchivo;
                enlace.style.display = 'none';

                document.body.appendChild(enlace);
                enlace.click();
                enlace.remove();

                overlay.hidden = true;

                notificar(
                    'success',
                    'ARCHIVO RECIBIDO. SE INICIÓ LA DESCARGA. ' +
                    'SI EL NAVEGADOR LO SOLICITA, ELIGE DÓNDE GUARDARLO.'
                );

            } catch (error) {
                console.error('Error al descargar el acta:', error);

                overlay.hidden = true;

                if (error.name === 'AbortError') {
                    notificar('info', 'DESCARGA CANCELADA POR EL USUARIO.');
                } else {
                    notificar(
                        'error',
                        'NO SE PUDO DESCARGAR EL ARCHIVO. ' +
                        (error.message || 'Ocurrió un error inesperado.')
                    );
                }

            } finally {
                if (objectUrl) {
                    setTimeout(function() {
                        URL.revokeObjectURL(objectUrl);
                    }, 60000);
                }

                if (controladorDescarga === controlador) {
                    controladorDescarga = null;
                }

                btnCancelar.disabled = false;
                btnPdf.disabled = false;
                btnExcel.disabled = false;
                descargando = false;
            }
        }

        btnPdf.addEventListener('click', function() {
            descargarActa(
                @json(route('prestamos.acta.pdf', $prestamo -> id)),
                'PDF',
                'pdf',
                'application/pdf'
            );
        });

        btnExcel.addEventListener('click', function() {
            descargarActa(
                @json(route('prestamos.acta.excel', $prestamo -> id)),
                'EXCEL',
                'xlsx',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            );
        });

        btnCancelar.addEventListener('click', function() {
            if (!controladorDescarga || !descargando) return;

            btnCancelar.disabled = true;
            estado.textContent = 'Cancelando operación...';

            controladorDescarga.abort();
        });
    });
</script>
@endsection