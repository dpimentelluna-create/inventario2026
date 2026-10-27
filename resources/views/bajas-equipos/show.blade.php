@extends('layouts.app')

@section('template_title')
    Baja Administrativa #{{ $baja->id }} - INVENTARIO
@endsection

@section('content')
    @php
        $equipo = $baja->equipo;

        $tipo = strtoupper($equipo->tipoEquipo->nombre ?? 'SIN TIPO');
        $marcaModelo = trim(($equipo->marca ?? '') . ' ' . ($equipo->modelo ?? ''));

        $fechaBaja = $baja->fecha
            ? \Carbon\Carbon::parse($baja->fecha)->format('d/m/Y')
            : '—';

        $fechaRegistroBaja = $baja->created_at
            ? \Carbon\Carbon::parse($baja->created_at)->format('d/m/Y')
            : $fechaBaja;

        $estadoFisico = strtoupper(
            $equipo->especificacionesLaptops->estado
            ?? $equipo->especificacionesEquipo->estado
            ?? ''
        );

        $badgeEstado = match ($estadoFisico) {
            'BUENO', 'OPERATIVO' => 'bg-success',
            'REGULAR' => 'bg-warning text-dark',
            'MALOGRADO' => 'bg-danger',
            default => 'bg-secondary',
        };

        $fechaRegistro = $equipo?->fecha_registro
            ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('d/m/Y')
            : '—';

        $entregantes = $baja->entregantes ?? [];
        $receptores = $baja->receptores ?? [];

        if (is_string($entregantes)) {
            $entregantes = json_decode($entregantes, true) ?? [];
        }

        if (is_string($receptores)) {
            $receptores = json_decode($receptores, true) ?? [];
        }

        if (empty($entregantes) && $baja->quien_entrego) {
            $entregantes = [[
                'nombre' => $baja->quien_entrego,
                'cargo' => '',
            ]];
        }

        if (empty($receptores) && $baja->quien_recibio) {
            $receptores = [[
                'nombre' => $baja->quien_recibio,
                'cargo' => '',
            ]];
        }

        $entregantes = collect($entregantes);
        $receptores = collect($receptores);
    @endphp

    <section class="content container-fluid baja-show">
        <div class="row">
            <div class="col-12">
                <div id="baja-ficha-print" class="card tarjeta-principal borde-baja">

                    {{-- ENCABEZADO --}}
                    <div class="card-header encabezado-show">
                        <div class="encabezado-contenido">
                            <div class="icono-encabezado">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </div>
                            <div>
                                <h4 class="titulo-show">BAJA ADMINISTRATIVA</h4>
                                <p class="subtitulo-show">
                                    Registro #{{ $baja->id }} · Equipo #{{ $equipo->id ?? '—' }} · Fecha: {{ $fechaRegistroBaja }}
                                </p>
                            </div>
                        </div>

                        <div class="no-print">
                            <button type="button"
                                    class="btn btn-primary boton-imprimir"
                                    id="btn_imprimir_baja">
                                <i class="fa fa-print me-1"></i>
                                IMPRIMIR FICHA
                            </button>
                        </div>
                    </div>

                    <div class="card-body cuerpo-show">

                        {{-- TARJETAS PRINCIPALES --}}
                        <div class="row g-3 mb-4">
                            {{-- REGISTRO DE BAJA --}}
                            <div class="col-12 col-md-4">
                                <div class="bloque-dato h-100">
                                    <div class="etiqueta">
                                        <i class="bi bi-clipboard-check me-1"></i>
                                        REGISTRO DE BAJA
                                    </div>
                                    <div class="valor">
                                        BAJA-{{ str_pad($baja->id, 5, '0', STR_PAD_LEFT) }}
                                    </div>
                                    <div class="subvalor mt-2">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        Fecha de registro: {{ $fechaRegistroBaja }}
                                    </div>
                                </div>
                            </div>

                            {{-- EQUIPO --}}
                            <div class="col-12 col-md-4">
                                <div class="bloque-dato h-100">
                                    <div class="etiqueta">
                                        <i class="bi bi-pc-display me-1"></i>
                                        EQUIPO
                                    </div>
                                    <div class="valor">
                                        ID: #{{ $equipo->id }} · {{ $tipo }}
                                    </div>
                                    <div class="subvalor mt-2">
                                        <strong>N.º de serie:</strong> {{ $equipo->num_serie ?: '—' }}
                                    </div>
                                    <div class="subvalor">
                                        <strong>Marca:</strong> {{ $equipo->marca ?: '—' }}
                                    </div>
                                    <div class="subvalor">
                                        <strong>Modelo:</strong> {{ $equipo->modelo ?: '—' }}
                                    </div>
                                </div>
                            </div>

                            {{-- ESTADO Y UBICACIÓN --}}
                            <div class="col-12 col-md-4">
                                <div class="bloque-dato h-100">
                                    <div class="etiqueta">
                                        <i class="bi bi-geo-alt me-1"></i>
                                        ESTADO Y UBICACIÓN
                                    </div>
                                    <div class="subvalor">ESTADO FÍSICO</div>
                                    <div class="valor mb-3">
                                        <span class="badge {{ $badgeEstado }}">
                                            {{ $estadoFisico ?: 'SIN ESTADO' }}
                                        </span>
                                    </div>
                                    <div class="subvalor">UBICACIÓN ANTERIOR</div>
                                    <div class="valor">
                                        {{ $equipo->ubicacione->nombre ?? 'SIN UBICACIÓN' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- DATOS DE LA BAJA (único bloque) --}}
                        <div class="seccion-contenido mb-4">
                            <div class="titulo-seccion">
                                <div>
                                    <h5>
                                        <i class="bi bi-clipboard-data me-1"></i>
                                        DATOS DE LA BAJA
                                    </h5>
                                    <p>Información sobre el destino y la situación del equipo.</p>
                                </div>
                            </div>
                            <div class="bloque-especificaciones">
                                <div class="row g-3">
                                    <div class="col-12 col-md-8">
                                        <div class="etiqueta">DESTINO</div>
                                        <div class="valor">{{ $baja->destino ?: '—' }}</div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="etiqueta">SITUACIÓN ADMINISTRATIVA</div>
                                        <div class="valor">
                                            <span class="badge bg-secondary">
                                                {{ strtoupper($equipo->situacion_administrativa ?? 'DE_BAJA') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- RESPONSABLES --}}
                        <div class="seccion-contenido mb-4">
                            <div class="titulo-seccion">
                                <div>
                                    <h5>
                                        <i class="bi bi-people me-1"></i>
                                        RESPONSABLES
                                    </h5>
                                    <p>Personas que participan en la entrega y recepción del equipo.</p>
                                </div>
                            </div>
                            <div class="tabla-responsables">
                                <table class="tabla-responsables-moderna">
                                    <thead>
                                        <tr>
                                            <th>NOMBRE</th>
                                            <th>CARGO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="fila-grupo">
                                            <td colspan="2">
                                                <i class="bi bi-box-arrow-up-right me-1"></i>
                                                QUIÉN ENTREGA
                                            </td>
                                        </tr>
                                        @forelse ($entregantes as $persona)
                                            <tr>
                                                <td>{{ data_get($persona, 'nombre') ?: '—' }}</td>
                                                <td>{{ data_get($persona, 'cargo') ?: '—' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="texto-vacio">
                                                    Sin responsables de entrega registrados.
                                                </td>
                                            </tr>
                                        @endforelse

                                        <tr class="fila-grupo">
                                            <td colspan="2">
                                                <i class="bi bi-box-arrow-in-down me-1"></i>
                                                QUIÉN RECIBE
                                            </td>
                                        </tr>
                                        @forelse ($receptores as $persona)
                                            <tr>
                                                <td>{{ data_get($persona, 'nombre') ?: '—' }}</td>
                                                <td>{{ data_get($persona, 'cargo') ?: '—' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="texto-vacio">
                                                    Sin responsables de recepción registrados.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- OBSERVACIONES --}}
                        <div class="seccion-contenido mb-4">
                            <div class="titulo-seccion">
                                <div>
                                    <h5>
                                        <i class="bi bi-chat-left-text me-1"></i>
                                        OBSERVACIONES
                                    </h5>
                                    <p>Información adicional registrada en la baja.</p>
                                </div>
                            </div>
                            <div class="bloque-especificaciones texto-observacion">
                                {{ $baja->observaciones ?: 'Sin observaciones registradas.' }}
                            </div>
                        </div>

                        {{-- ACCIONES --}}
                        <div class="acciones-inferiores no-print">
                            <div class="texto-acciones">
                                <strong>¿Necesitas realizar otra acción?</strong>
                                <span>Regresa al listado o administra el registro de esta baja.</span>
                            </div>
                            <div class="botones-inferiores">
                                <a href="{{ route('bajas-equipos.index') }}"
                                   class="btn btn-outline-secondary">
                                    <i class="fa fa-arrow-left me-1"></i>
                                    VOLVER
                                </a>
                                <a href="{{ route('bajas-equipos.edit', $baja->id) }}"
                                   class="btn btn-success">
                                    <i class="fa fa-edit me-1"></i>
                                    EDITAR BAJA
                                </a>
                                <button type="button"
                                        class="btn btn-danger"
                                        id="btn_anular_baja">
                                    <i class="fa fa-undo me-1"></i>
                                    ANULAR BAJA
                                </button>
                            </div>
                        </div>

                        <form id="form_anular_baja"
                              action="{{ route('bajas-equipos.destroy', $baja->id) }}"
                              method="POST"
                              class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .baja-show { padding-bottom: 1.5rem; }

        .tarjeta-principal {
            border: 1px solid #e3e7eb;
            border-left: 5px solid #6c757d;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .04);
        }

        .encabezado-show {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            padding: 1.25rem 1.5rem;
            background: #fff;
            border-bottom: 1px solid #e9ecef;
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
            background: #eef2f6;
            color: #495057;
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

        .boton-imprimir {
            padding: .6rem 1rem;
            font-weight: 650;
            white-space: nowrap;
        }

        .cuerpo-show {
            padding: 1.5rem;
            background: #fff;
        }

        .etiqueta {
            font-size: .75rem;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: #6c757d;
            font-weight: 700;
            margin-bottom: .25rem;
        }

        .valor {
            font-size: 1rem;
            font-weight: 700;
            color: #343a40;
            overflow-wrap: anywhere;
        }

        .subvalor {
            margin-top: .2rem;
            font-size: .82rem;
            color: #6c757d;
            overflow-wrap: anywhere;
        }

        .bloque-dato {
            height: 100%;
            padding: .85rem 1rem;
            background: #f8f9fa;
            border: 1px solid #edf0f2;
            border-radius: 9px;
        }

        .titulo-seccion {
            display: flex;
            align-items: center;
            justify-content: space-between;
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
            font-size: .85rem;
            color: #6c757d;
        }

        .bloque-especificaciones {
            padding: 1.1rem;
            background: #fff;
            border: 1px solid #e3e7eb;
            border-radius: 9px;
        }

        .texto-observacion {
            color: #495057;
            overflow-wrap: anywhere;
            white-space: pre-line;
            min-height: 48px;
            text-align: left;
            vertical-align: top;
            margin: 0;
            padding: 0.75rem 1rem;
            display: block;
        }

        /* TABLA RESPONSABLES */
        .tabla-responsables {
            width: 100%;
            overflow-x: auto;
        }

        .tabla-responsables-moderna {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            color: #343a40;
        }

        .tabla-responsables-moderna th {
            padding: .7rem .9rem;
            background: #f8f9fa;
            color: #6c757d;
            font-size: .74rem;
            font-weight: 750;
            letter-spacing: .04em;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .tabla-responsables-moderna th:first-child,
        .tabla-responsables-moderna td:first-child {
            width: 65%;
            border-right: 1px solid #edf0f2;
        }

        .tabla-responsables-moderna td {
            padding: .65rem .9rem;
            font-size: .875rem;
            overflow-wrap: anywhere;
            border-bottom: 1px solid #edf0f2;
        }

        .tabla-responsables-moderna .fila-grupo td {
            padding: .55rem .9rem;
            background: #f8f9fa;
            color: #495057;
            font-size: .76rem;
            font-weight: 750;
            letter-spacing: .025em;
            border-top: 1px solid #dee2e6;
            border-bottom: 1px solid #e9ecef;
        }

        .tabla-responsables-moderna .texto-vacio {
            color: #6c757d;
            font-size: .82rem;
            font-style: italic;
        }

        .acciones-inferiores {
            display: flex;
            align-items: center;
            justify-content: space-between;
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

        .texto-acciones strong { color: #343a40; font-size: .9rem; }
        .texto-acciones span { color: #6c757d; font-size: .82rem; }

        .botones-inferiores {
            display: flex;
            flex-wrap: wrap;
            gap: .6rem;
        }

        .botones-inferiores .btn {
            padding: .6rem .9rem;
            font-size: .82rem;
            font-weight: 650;
        }

        /* ===== IMPRESIÓN: conservar diseño de pantalla ===== */
        @page {
            size: A4 portrait;
            margin: 8mm 10mm;
        }

        @media print {
            html, body {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #fff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Ocultar UI del layout */
            #sidebar, .sidebar, .main-sidebar, .main-header, .navbar, nav,
            .dot-spinner-container, footer, .main-footer, .content-header,
            .breadcrumb, .control-sidebar {
                display: none !important;
            }

            #content-wrapper, .content-wrapper, main, .container-fluid, .content,
            .baja-show, .row, .col-12 {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                float: none !important;
                position: static !important;
                overflow: visible !important;
            }

            /* Mantener el card tal cual, solo sin sombras ni acciones */
            #baja-ficha-print {
                position: static !important;
                width: 100% !important;
                margin: 0 !important;
                border: 1px solid #adb5bd !important;
                border-left-width: 4px !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                overflow: visible !important;
                page-break-inside: auto;
            }

            #baja-ficha-print .no-print,
            #baja-ficha-print .acciones-inferiores {
                display: none !important;
            }

            #baja-ficha-print .card-header,
            #baja-ficha-print .card-body,
            #baja-ficha-print .bloque-dato,
            #baja-ficha-print .bloque-especificaciones {
                background: #fff !important;
                box-shadow: none !important;
            }

            #baja-ficha-print .card-header { padding: 10px 12px !important; }
            #baja-ficha-print .card-body { padding: 12px !important; }

            #baja-ficha-print .bloque-dato,
            #baja-ficha-print .bloque-especificaciones {
                padding: 8px !important;
                break-inside: avoid;
            }

            #baja-ficha-print .tabla-responsables {
                overflow: visible !important;
            }

            #baja-ficha-print .tabla-responsables-moderna {
                width: 100% !important;
            }

            #baja-ficha-print .tabla-responsables-moderna th,
            #baja-ficha-print .tabla-responsables-moderna td {
                padding: 5px 7px !important;
                font-size: 9pt !important;
                background: #fff !important;
            }

            #baja-ficha-print .tabla-responsables-moderna .fila-grupo td {
                background: #f8f9fa !important;
                color: #343a40 !important;
            }

            #baja-ficha-print .valor { font-size: 10pt !important; }
            #baja-ficha-print .etiqueta,
            #baja-ficha-print .subvalor,
            #baja-ficha-print .titulo-seccion p { font-size: 8.5pt !important; }

            #baja-ficha-print .titulo-show { font-size: 13pt !important; }
            #baja-ficha-print .subtitulo-show { font-size: 8.5pt !important; }
            #baja-ficha-print .titulo-seccion h5 { font-size: 10pt !important; }

            #baja-ficha-print .badge {
                border: 1px solid #adb5bd !important;
                color: #212529 !important;
                background: #fff !important;
            }

            #baja-ficha-print .icono-encabezado {
                color: #212529 !important;
                background: #fff !important;
                border: 1px solid #adb5bd !important;
            }

            #baja-ficha-print .mb-4 { margin-bottom: .6rem !important; }
        }

        @media (max-width: 576px) {
            .encabezado-show, .cuerpo-show { padding: 1rem; }
            .encabezado-contenido { align-items: flex-start; }
            .icono-encabezado { width: 40px; height: 40px; font-size: 1.2rem; }
            .subtitulo-show { font-size: .8rem; }
            .encabezado-show > .no-print, .boton-imprimir { width: 100%; }
            .acciones-inferiores { align-items: stretch; }
            .botones-inferiores { width: 100%; }
            .botones-inferiores .btn { flex: 1; }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const botonImprimir = document.getElementById('btn_imprimir_baja');
            const botonAnular = document.getElementById('btn_anular_baja');
            const formularioAnular = document.getElementById('form_anular_baja');

            if (botonImprimir) {
                botonImprimir.addEventListener('click', function () {
                    window.print();
                });
            }

            if (botonAnular && formularioAnular) {
                botonAnular.addEventListener('click', function () {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: '¿Anular esta baja?',
                            text: 'El equipo volverá a EN_INVENTARIO. Esta acción debe realizarse solo si corresponde.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Sí, anular baja',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#dc3545',
                            cancelButtonColor: '#6c757d',
                            reverseButtons: true
                        }).then(function (resultado) {
                            if (resultado.isConfirmed) {
                                formularioAnular.submit();
                            }
                        });
                    } else if (confirm('¿Estás seguro de anular esta baja? El equipo volverá a EN_INVENTARIO.')) {
                        formularioAnular.submit();
                    }
                });
            }
        });
    </script>
@endsection