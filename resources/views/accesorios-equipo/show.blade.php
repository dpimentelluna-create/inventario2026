@extends('layouts.app')

@php
    $tipoAccesorio = strtoupper($accesoriosEquipo->tipo ?? 'ACCESORIO');
    $marcaAccesorio = strtoupper($accesoriosEquipo->marca ?? 'SIN MARCA');
    $serieAccesorio = $accesoriosEquipo->num_serie ?: 'SIN-SERIE';

    $estadoAccesorio = strtoupper($accesoriosEquipo->estado ?? '');
    $claseEstado = match ($estadoAccesorio) {
        'MALOGRADO' => 'estado-malogrado',
        'REGULAR' => 'estado-regular',
        'BUENO', 'OPERATIVO' => 'estado-bueno',
        default => 'estado-neutro',
    };

    $equipo = $accesoriosEquipo->equipo;

    $tipoEquipo = strtoupper($equipo->tipoEquipo->nombre ?? 'NO REGISTRADO');
    $estadoEquipo = strtoupper($equipo->estado ?? 'NO REGISTRADO');

    $claseEstadoEquipo = match ($estadoEquipo) {
        'MALOGRADO' => 'estado-malogrado',
        'REGULAR' => 'estado-regular',
        'BUENO', 'OPERATIVO' => 'estado-bueno',
        default => 'estado-neutro',
    };

    $fechaEquipo = $equipo && $equipo->fecha_registro
        ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('d-m-Y')
        : 'NO REGISTRADA';
@endphp

@section('template_title')
    Accesorio {{ $accesoriosEquipo->id }} - {{ $tipoAccesorio }} - {{ $serieAccesorio }}
@endsection

@section('content')
    <style>
        .accesorio-contenedor {
            max-width: 1150px;
            margin: 0 auto;
            padding-bottom: 25px;
        }

        .accesorio-encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }

        .accesorio-encabezado h2 {
            font-size: 25px;
            font-weight: 700;
            color: #212529;
            margin: 0 0 5px;
        }

        .accesorio-subtitulo {
            color: #6c757d;
            margin: 0;
            font-size: 14px;
        }

        .accesorio-panel {
            background: #fff;
            border: 1px solid #dee2e6;
            border-left: 5px solid #0d6efd;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .05);
            overflow: hidden;
        }

        .accesorio-panel-cuerpo {
            padding: 25px;
        }

        .accesorio-resumen {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 25px;
        }

        .accesorio-resumen-item {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 16px;
            min-width: 0;
        }

        .accesorio-resumen-label {
            display: block;
            color: #6c757d;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 7px;
        }

        .accesorio-resumen-valor {
            display: block;
            color: #212529;
            font-size: 16px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .accesorio-seccion {
            font-size: 17px;
            font-weight: 700;
            padding-bottom: 10px;
            margin: 26px 0 17px;
            border-bottom: 1px solid #dee2e6;
            color: #343a40;
        }

        .accesorio-seccion:first-child {
            margin-top: 0;
        }

        .accesorio-datos {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px 28px;
        }

        .accesorio-dato {
            min-width: 0;
        }

        .accesorio-dato-completo {
            grid-column: 1 / -1;
        }

        .accesorio-dato strong {
            display: block;
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .accesorio-dato p {
            margin: 0;
            color: #212529;
            font-size: 14px;
            overflow-wrap: anywhere;
            white-space: pre-line;
        }

        .estado-etiqueta {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .estado-bueno {
            background: #d1e7dd;
            color: #0f5132;
        }

        .estado-regular {
            background: #fff3cd;
            color: #664d03;
        }

        .estado-malogrado {
            background: #f8d7da;
            color: #842029;
        }

        .estado-neutro {
            background: #e2e3e5;
            color: #41464b;
        }

        .accesorio-relacionado {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
        }

        .accesorio-alerta {
            padding: 14px;
            background: #fff3cd;
            border: 1px solid #ffecb5;
            border-radius: 6px;
            color: #664d03;
        }

        .accesorio-acciones {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 22px;
        }

        @media (max-width: 768px) {
            .accesorio-resumen {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .accesorio-panel-cuerpo {
                padding: 17px;
            }
        }

        @media (max-width: 480px) {
            .accesorio-datos {
                grid-template-columns: 1fr;
            }

            .accesorio-dato-completo {
                grid-column: auto;
            }
        }

        @page {
            size: A4 portrait;
            margin: 12mm;
        }

        @media print {

            html,
            body {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #fff !important;
            }

            body * {
                visibility: hidden !important;
            }

            #accesorio-ficha-print,
            #accesorio-ficha-print * {
                visibility: visible !important;
            }

            #accesorio-ficha-print {
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                margin: 0 !important;
                border: 1px solid #adb5bd !important;
                border-left: 4px solid #0d6efd !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                overflow: visible !important;
                background: #fff !important;
            }

            #accesorio-ficha-print .no-print,
            #accesorio-ficha-print .accesorio-acciones {
                display: none !important;
            }

            #accesorio-ficha-print .accesorio-panel-cuerpo {
                padding: 15px !important;
            }

            #accesorio-ficha-print .accesorio-resumen {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 8px !important;
            }

            #accesorio-ficha-print .accesorio-resumen-item {
                padding: 10px !important;
                break-inside: avoid;
            }

            #accesorio-ficha-print .accesorio-seccion {
                margin-top: 18px !important;
                break-after: avoid;
            }

            #accesorio-ficha-print .accesorio-datos,
            #accesorio-ficha-print .accesorio-relacionado {
                break-inside: avoid;
            }

            #accesorio-ficha-print .estado-etiqueta {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            a {
                color: #212529 !important;
                text-decoration: none !important;
            }
        }
    </style>

    <section class="content container-fluid accesorio-contenedor">

        {{-- ENCABEZADO --}}
        <div class="accesorio-encabezado no-print">
            <div>
                <h2>FICHA DEL ACCESORIO</h2>
                <p class="accesorio-subtitulo">
                    Información del accesorio y del equipo al que se encuentra asociado.
                </p>
            </div>

            <button type="button" class="btn btn-primary" id="btn_imprimir_accesorio" onclick="window.print()">
                <i class="bi bi-printer"></i> IMPRIMIR FICHA
            </button>
        </div>

        {{-- FICHA --}}
        <div class="accesorio-panel" id="accesorio-ficha-print">
            <div class="accesorio-panel-cuerpo">

                <div class="mb-4">
                    <h3 style="font-size:21px;font-weight:700;margin-bottom:5px;">
                        {{ $tipoAccesorio }}
                    </h3>

                    <p style="color:#6c757d;margin:0;">
                        Registro de Accesorio - ID: {{ $accesoriosEquipo->id }}
                    </p>
                </div>

                {{-- RESUMEN --}}
                <div class="accesorio-resumen">
                    <div class="accesorio-resumen-item">
                        <span class="accesorio-resumen-label">Tipo de accesorio</span>
                        <span class="accesorio-resumen-valor">
                            {{ $tipoAccesorio }}
                        </span>
                    </div>

                    <div class="accesorio-resumen-item">
                        <span class="accesorio-resumen-label">Número de serie</span>
                        <span class="accesorio-resumen-valor">
                            {{ $accesoriosEquipo->num_serie ?: 'SIN REGISTRAR' }}
                        </span>
                    </div>

                    <div class="accesorio-resumen-item">
                        <span class="accesorio-resumen-label">Marca</span>
                        <span class="accesorio-resumen-valor">
                            {{ $marcaAccesorio }}
                        </span>
                    </div>

                    <div class="accesorio-resumen-item">
                        <span class="accesorio-resumen-label">Observaciones</span>
                        <span class="accesorio-resumen-valor">
                            {{ $accesoriosEquipo->observaciones ?: 'SIN OBSERVACIONES' }}
                        </span>
                    </div>
                </div>


                {{-- INFORMACIÓN DEL ACCESORIO
                <h4 class="accesorio-seccion">INFORMACIÓN DEL ACCESORIO</h4>

                <div class="accesorio-datos">
                    <div class="accesorio-dato">
                        <strong>ID del registro</strong>
                        <p>{{ $accesoriosEquipo->id }}</p>
                    </div>

                    <div class="accesorio-dato">
                        <strong>Tipo</strong>
                        <p>{{ $tipoAccesorio }}</p>
                    </div>

                    <div class="accesorio-dato">
                        <strong>Marca</strong>
                        <p>{{ $accesoriosEquipo->marca ?: 'NO REGISTRADA' }}</p>
                    </div>

                    <div class="accesorio-dato">
                        <strong>Número de serie</strong>
                        <p>{{ $accesoriosEquipo->num_serie ?: 'NO REGISTRADO' }}</p>
                    </div>
                </div>--}}


                {{-- EQUIPO RELACIONADO --}}
                <h4 class="accesorio-seccion">EQUIPO RELACIONADO</h4>

                @if($equipo)
                    <div class="accesorio-relacionado">
                        <div class="accesorio-datos">

                            <div class="accesorio-dato">
                                <strong>ID del equipo</strong>
                                <p>{{ $equipo->id }}</p>
                            </div>

                            <div class="accesorio-dato">
                                <strong>Tipo de equipo</strong>
                                <p>{{ $tipoEquipo }}</p>
                            </div>

                            <div class="accesorio-dato">
                                <strong>Marca</strong>
                                <p>{{ $equipo->marca ?: 'NO REGISTRADA' }}</p>
                            </div>

                            <div class="accesorio-dato">
                                <strong>Modelo</strong>
                                <p>{{ $equipo->modelo ?: 'NO REGISTRADO' }}</p>
                            </div>

                            <div class="accesorio-dato">
                                <strong>Número de serie</strong>
                                <p>{{ $equipo->num_serie ?: 'NO REGISTRADO' }}</p>
                            </div>

                            <div class="accesorio-dato">
                                <strong>Estado del equipo</strong>
                                <p>
                                    <span class="estado-etiqueta {{ $claseEstadoEquipo }}">
                                        {{ $estadoEquipo }}
                                    </span>
                                </p>
                            </div>

                            <div class="accesorio-dato">
                                <strong>Ubicación</strong>
                                <p>{{ $equipo->ubicacione->nombre ?? 'NO REGISTRADA' }}</p>
                            </div>

                            <div class="accesorio-dato">
                                <strong>Fecha de registro</strong>
                                <p>{{ $fechaEquipo }}</p>
                            </div>

                            <div class="accesorio-dato accesorio-dato-completo">
                                <strong>Observación del equipo</strong>
                                <p>{{ $equipo->observacion ?: 'SIN OBSERVACIONES' }}</p>
                            </div>

                        </div>
                    </div>
                @else
                    <div class="accesorio-alerta">
                        No se encontró información del equipo asociado a este accesorio.
                    </div>
                @endif


                {{-- ESTADO Y OBSERVACIONES: INFORMACIÓN PRIORITARIA --}}
                <h4 class="accesorio-seccion">ESTADO Y OBSERVACIONES</h4>

                <div class="accesorio-datos">
                    <div class="accesorio-dato">
                        <strong>Estado actual del accesorio</strong>
                        <p>
                            <span class="estado-etiqueta {{ $claseEstado }}">
                                {{ $estadoAccesorio ?: 'NO REGISTRADO' }}
                            </span>
                        </p>
                    </div>

                    <div class="accesorio-dato">
                        <strong>Estado del equipo relacionado</strong>
                        <p>
                            @if($equipo)
                                <span class="estado-etiqueta {{ $claseEstadoEquipo }}">
                                    {{ $estadoEquipo }}
                                </span>
                            @else
                                NO DISPONIBLE
                            @endif
                        </p>
                    </div>

                    <div class="accesorio-dato accesorio-dato-completo">
                        <strong>Observaciones del accesorio</strong>
                        <p>{{ $accesoriosEquipo->observaciones ?: 'SIN OBSERVACIONES' }}</p>
                    </div>

                    @if($equipo)
                        <div class="accesorio-dato accesorio-dato-completo">
                            <strong>Observación del equipo relacionado</strong>
                            <p>{{ $equipo->observacion ?: 'SIN OBSERVACIONES' }}</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>

        {{-- ACCIONES --}}
        <div class="accesorio-acciones no-print">
            <a href="{{ route('accesorios-equipo.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> VOLVER
            </a>

            <a href="{{ route('accesorios-equipo.edit', $accesoriosEquipo->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square"></i> EDITAR ACCESORIO
            </a>
        </div>

    </section>
@endsection