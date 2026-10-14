@extends('layouts.app')

@section('template_title')
    {{ strtoupper($tiposEquipo->nombre) }} - TIPOS DE EQUIPOS
@endsection

@section('content')
    <style>
        .tipo-detalle {
            color: #263445;
        }

        .tipo-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            padding: 22px 24px;
            background: #fff;
            border: 1px solid #e5e9ef;
            border-radius: 12px;
            margin-bottom: 22px;
        }

        .tipo-header h2 {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 5px;
            color: #243247;
        }

        .tipo-subtitulo {
            color: #718096;
            font-size: 13px;
            margin: 0;
        }

        .tipo-panel {
            background: #fff;
            border: 1px solid #e5e9ef;
            border-radius: 12px;
            margin-bottom: 22px;
            overflow: hidden;
        }

        .tipo-panel-header {
            padding: 17px 22px;
            border-bottom: 1px solid #e9edf2;
        }

        .tipo-panel-header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #263445;
        }

        .tipo-panel-body {
            padding: 22px;
        }

        .tipo-card {
            height: 100%;
            padding: 20px;
            background: #fff;
            border: 1px solid #e5e9ef;
            border-radius: 12px;
            border-left: 4px solid #64748b;
        }

        .tipo-card.total {
            border-left-color: #2563eb;
        }

        .tipo-card.bueno {
            border-left-color: #16a34a;
        }

        .tipo-card.regular {
            border-left-color: #d97706;
        }

        .tipo-card.malogrado {
            border-left-color: #dc2626;
        }

        .tipo-card-etiqueta {
            color: #718096;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .tipo-card-numero {
            font-size: 30px;
            font-weight: 800;
            margin-top: 8px;
            line-height: 1.2;
            color: #263445;
        }

        .tipo-barra-fondo {
            height: 10px;
            background: #edf0f4;
            border-radius: 20px;
            overflow: hidden;
        }

        .tipo-barra {
            height: 100%;
            border-radius: 20px;
            min-width: 0;
        }

        .tipo-barra.bueno {
            background: #16a34a;
        }

        .tipo-barra.regular {
            background: #d97706;
        }

        .tipo-barra.malogrado {
            background: #dc2626;
        }

        .tipo-barra.pendiente {
            background: #64748b;
        }

        .tipo-estado-fila {
            margin-bottom: 22px;
        }

        .tipo-estado-fila:last-child {
            margin-bottom: 0;
        }

        .tipo-estado-detalle {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .tipo-tabla {
            margin: 0;
            width: 100%;
        }

        .tipo-tabla thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .4px;
            white-space: nowrap;
            border-bottom: 1px solid #e5e9ef;
            padding: 14px 16px;
        }

        .tipo-tabla tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            font-size: 13px;
            border-color: #edf0f4;
        }

        .tipo-tabla tbody tr:hover {
            background: #fafcff;
        }

        .tipo-marca {
            font-weight: 700;
            color: #263445;
        }

        .tipo-serie {
            color: #64748b;
            font-size: 12px;
        }

        .tipo-badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .tipo-badge.bueno {
            color: #166534;
            background: #dcfce7;
        }

        .tipo-badge.regular {
            color: #92400e;
            background: #fef3c7;
        }

        .tipo-badge.malogrado {
            color: #991b1b;
            background: #fee2e2;
        }

        .tipo-badge.pendiente {
            color: #475569;
            background: #e2e8f0;
        }

        .tipo-vacio {
            padding: 35px 20px;
            text-align: center;
            color: #718096;
        }

        .tipo-vacio strong {
            display: block;
            color: #334155;
            margin-bottom: 5px;
        }

        @media (max-width: 767px) {
            .tipo-panel-body {
                padding: 16px;
            }

            .tipo-header {
                padding: 18px;
            }

            .tipo-header h2 {
                font-size: 21px;
            }

            .tipo-card {
                padding: 16px;
            }
        }

        @media print {
            @page {
                size: A4 landscape;
                margin: 12mm;
            }

            body {
                background: #fff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body * {
                visibility: hidden;
            }

            #tipo-equipo-print,
            #tipo-equipo-print * {
                visibility: visible;
            }

            #tipo-equipo-print {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .tipo-acciones,
            .tipo-no-imprimir {
                display: none !important;
            }

            .tipo-panel,
            .tipo-card,
            .tipo-header {
                break-inside: avoid;
                box-shadow: none !important;
            }

            .tipo-tabla thead th,
            .tipo-barra-fondo,
            .tipo-badge {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>

    <section class="content container-fluid tipo-detalle">
        <div id="tipo-equipo-print">

            {{-- ENCABEZADO --}}
            <div class="tipo-header">
                <div>
                    <h2>{{ strtoupper($tiposEquipo->nombre) }}</h2>
                    <p class="tipo-subtitulo">
                        RESUMEN DE INVENTARIO Y ESTADO GENERAL DE LOS EQUIPOS
                    </p>
                    <p class="tipo-subtitulo" style="margin-top: 7px;">
                        Código del tipo: {{ $tiposEquipo->id }}
                        &nbsp;|&nbsp;
                        Fecha del reporte: {{ now()->format('d/m/Y') }}
                    </p>
                </div>

                <div class="tipo-acciones">
                    <button type="button" class="btn btn-secondary" onclick="window.print()">
                        <i class="fas fa-print"></i> IMPRIMIR
                    </button>
                </div>
            </div>

            {{-- TARJETAS DE RESUMEN --}}
            <div class="row mb-4">
                <div class="col-6 col-lg-3 mb-3">
                    <div class="tipo-card total">
                        <div class="tipo-card-etiqueta">Total de equipos</div>
                        <div class="tipo-card-numero">{{ $totalEquipos }}</div>
                        <div class="tipo-subtitulo">Registrados en este tipo</div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 mb-3">
                    <div class="tipo-card bueno">
                        <div class="tipo-card-etiqueta">BUENOS</div>
                        <div class="tipo-card-numero">{{ $buenos }}</div>
                        <div class="tipo-subtitulo">En buen estado</div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 mb-3">
                    <div class="tipo-card regular">
                        <div class="tipo-card-etiqueta">REGULARES</div>
                        <div class="tipo-card-numero">{{ $regulares }}</div>
                        <div class="tipo-subtitulo">Requieren seguimiento</div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 mb-3">
                    <div class="tipo-card malogrado">
                        <div class="tipo-card-etiqueta">MALOGRADOS</div>
                        <div class="tipo-card-numero">{{ $malogrados }}</div>
                        <div class="tipo-subtitulo">Requieren revisión</div>
                    </div>
                </div>
            </div>

            {{-- DISTRIBUCIÓN DE ESTADOS --}}
            <div class="tipo-panel">
                <div class="tipo-panel-header">
                    <h4>ESTADO GENERAL DE LOS EQUIPOS</h4>
                </div>

                <div class="tipo-panel-body">
                    @if ($totalEquipos === 0)
                        <div class="tipo-vacio">
                            <strong>Sin equipos registrados</strong>
                            Todavía no hay equipos asociados a este tipo.
                        </div>
                    @else
                        <div class="tipo-estado-fila">
                            <div class="tipo-estado-detalle">
                                <span><strong>BUENOS</strong></span>
                                <span>{{ $buenos }} equipos ({{ $porcentajeBueno }}%)</span>
                            </div>
                            <div class="tipo-barra-fondo">
                                <div class="tipo-barra bueno" style="width: {{ $porcentajeBueno }}%;"></div>
                            </div>
                        </div>

                        <div class="tipo-estado-fila">
                            <div class="tipo-estado-detalle">
                                <span><strong>REGULARES</strong></span>
                                <span>{{ $regulares }} equipos ({{ $porcentajeRegular }}%)</span>
                            </div>
                            <div class="tipo-barra-fondo">
                                <div class="tipo-barra regular" style="width: {{ $porcentajeRegular }}%;"></div>
                            </div>
                        </div>

                        <div class="tipo-estado-fila">
                            <div class="tipo-estado-detalle">
                                <span><strong>MALOGRADOS</strong></span>
                                <span>{{ $malogrados }} equipos ({{ $porcentajeMalogrado }}%)</span>
                            </div>
                            <div class="tipo-barra-fondo">
                                <div class="tipo-barra malogrado" style="width: {{ $porcentajeMalogrado }}%;"></div>
                            </div>
                        </div>

                        @if ($sinClasificar > 0)
                            <div class="tipo-estado-fila">
                                <div class="tipo-estado-detalle">
                                    <span><strong>SIN CLASIFICAR</strong></span>
                                    <span>{{ $sinClasificar }} equipos ({{ $porcentajeSinClasificar }}%)</span>
                                </div>
                                <div class="tipo-barra-fondo">
                                    <div class="tipo-barra pendiente" style="width: {{ $porcentajeSinClasificar }}%;"></div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            {{-- ÚLTIMOS CINCO EQUIPOS --}}
            <div class="tipo-panel">
                <div class="tipo-panel-header d-flex justify-content-between align-items-center flex-wrap"
                    style="gap: 10px;">
                    <h4>ÚLTIMOS 5 EQUIPOS REGISTRADOS</h4>
                    <span class="tipo-subtitulo">
                        Registros más recientes de {{ strtoupper($tiposEquipo->nombre) }}
                    </span>
                </div>

                @if ($ultimosEquipos->isEmpty())
                    <div class="tipo-vacio">
                        <strong>No hay equipos para mostrar</strong>
                        Cuando registres equipos de este tipo, aparecerán aquí.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table tipo-tabla">
                            <thead>
                                <tr>
                                    <th>Equipo</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>N.º de serie</th>
                                    <th>Fecha de registro</th>
                                    <th>Estado</th>
                                    <th class="tipo-no-imprimir">Ficha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ultimosEquipos as $equipo)
                                                @php
                                                    $estadoEquipo = $equipo->especificacionesLaptops?->estado
                                                        ?: $equipo->especificacionesEquipo?->estado
                                                        ?: 'SIN CLASIFICAR';

                                                    $estadoEquipo = strtoupper(trim($estadoEquipo));

                                                    $claseEstado = match ($estadoEquipo) {
                                                        'BUENO' => 'bueno',
                                                        'REGULAR' => 'regular',
                                                        'MALOGRADO' => 'malogrado',
                                                        default => 'pendiente',
                                                    };
                                                @endphp

                                                <tr>
                                                    <td>
                                                        <strong>#{{ $equipo->id }}</strong>
                                                    </td>

                                                    <td>
                                                        <span class="tipo-marca">
                                                            {{ strtoupper($equipo->marca ?? 'SIN MARCA') }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        {{ strtoupper($equipo->modelo ?? 'SIN MODELO') }}
                                                    </td>

                                                    <td>
                                                        <span class="tipo-serie">
                                                            {{ $equipo->num_serie ?: 'SIN SERIE' }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        {{ $equipo->fecha_registro
                                    ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('d/m/Y')
                                    : 'SIN FECHA' }}
                                                    </td>

                                                    <td>
                                                        <span class="tipo-badge {{ $claseEstado }}">
                                                            {{ $estadoEquipo }}
                                                        </span>
                                                    </td>

                                                    <td class="tipo-no-imprimir">
                                                        <a href="{{ route('equipos.show', $equipo->id) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            VER FICHA
                                                        </a>
                                                    </td>
                                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <p class="tipo-subtitulo text-right">
                INVENTARIO 2026 - REPORTE DE TIPOS DE EQUIPOS
            </p>

            <div class="tipo-acciones mt-3 mb-4">
                <a href="{{ route('tipos-equipo.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> VOLVER
                </a>

            </div>
        </div>
    </section>
@endsection