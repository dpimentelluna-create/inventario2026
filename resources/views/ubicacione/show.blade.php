
@extends('layouts.app')

@section('template_title')
    {{ strtoupper($ubicacione->nombre) }} - UBICACIONES
@endsection

@section('content')
<style>
    .ubicacion-detalle {
        color: #263445;
    }

    .ubicacion-header {
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

    .ubicacion-header h2 {
        font-size: 24px;
        font-weight: 700;
        margin: 0 0 6px;
        color: #243247;
    }

    .ubicacion-subtitulo {
        color: #718096;
        font-size: 13px;
        margin: 0;
    }

    .ubicacion-panel {
        background: #fff;
        border: 1px solid #e5e9ef;
        border-radius: 12px;
        margin-bottom: 22px;
        overflow: hidden;
    }

    .ubicacion-panel-header {
        padding: 17px 22px;
        border-bottom: 1px solid #e9edf2;
    }

    .ubicacion-panel-header h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #263445;
    }

    .ubicacion-panel-body {
        padding: 22px;
    }

    .ubicacion-card {
        height: 100%;
        padding: 20px;
        background: #fff;
        border: 1px solid #e5e9ef;
        border-radius: 12px;
        border-left: 4px solid #64748b;
    }

    .ubicacion-card.total {
        border-left-color: #2563eb;
    }

    .ubicacion-card.bueno {
        border-left-color: #16a34a;
    }

    .ubicacion-card.regular {
        border-left-color: #d97706;
    }

    .ubicacion-card.malogrado {
        border-left-color: #dc2626;
    }

    .ubicacion-card-etiqueta {
        color: #718096;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .4px;
    }

    .ubicacion-card-numero {
        font-size: 30px;
        font-weight: 800;
        margin-top: 8px;
        line-height: 1.2;
        color: #263445;
    }

    .ubicacion-barra-fondo {
        height: 10px;
        background: #edf0f4;
        border-radius: 20px;
        overflow: hidden;
    }

    .ubicacion-barra {
        height: 100%;
        border-radius: 20px;
    }

    .ubicacion-barra.bueno {
        background: #16a34a;
    }

    .ubicacion-barra.regular {
        background: #d97706;
    }

    .ubicacion-barra.malogrado {
        background: #dc2626;
    }

    .ubicacion-barra.pendiente {
        background: #64748b;
    }

    .ubicacion-estado-fila {
        margin-bottom: 22px;
    }

    .ubicacion-estado-fila:last-child {
        margin-bottom: 0;
    }

    .ubicacion-estado-detalle {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
        font-size: 13px;
    }

    .ubicacion-tabla {
        margin: 0;
        width: 100%;
    }

    .ubicacion-tabla thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .4px;
        white-space: nowrap;
        border-bottom: 1px solid #e5e9ef;
        padding: 14px 16px;
    }

    .ubicacion-tabla tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        font-size: 13px;
        border-color: #edf0f4;
    }

    .ubicacion-tabla tbody tr:hover {
        background: #fafcff;
    }

    .ubicacion-badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .ubicacion-badge.bueno {
        color: #166534;
        background: #dcfce7;
    }

    .ubicacion-badge.regular {
        color: #92400e;
        background: #fef3c7;
    }

    .ubicacion-badge.malogrado {
        color: #991b1b;
        background: #fee2e2;
    }

    .ubicacion-badge.pendiente {
        color: #475569;
        background: #e2e8f0;
    }

    .ubicacion-vacio {
        padding: 35px 20px;
        text-align: center;
        color: #718096;
    }

    .ubicacion-vacio strong {
        display: block;
        color: #334155;
        margin-bottom: 5px;
    }

    @media (max-width: 767px) {
        .ubicacion-header {
            padding: 18px;
        }

        .ubicacion-header h2 {
            font-size: 21px;
        }

        .ubicacion-panel-body {
            padding: 16px;
        }

        .ubicacion-card {
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

        #ubicacion-ficha-print,
        #ubicacion-ficha-print * {
            visibility: visible;
        }

        #ubicacion-ficha-print {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        .ubicacion-no-imprimir {
            display: none !important;
        }

        .ubicacion-panel,
        .ubicacion-card,
        .ubicacion-header {
            break-inside: avoid;
            box-shadow: none !important;
        }

        .ubicacion-tabla thead th,
        .ubicacion-barra-fondo,
        .ubicacion-badge {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
</style>

<section class="content container-fluid ubicacion-detalle">

    {{-- CONTENIDO QUE SE IMPRIME --}}
    <div id="ubicacion-ficha-print">

        {{-- ENCABEZADO --}}
        <div class="ubicacion-header">
            <div>
                <h2>{{ strtoupper($ubicacione->nombre) }}</h2>

                <p class="ubicacion-subtitulo">
                    DETALLE DE UBICACIÓN Y ESTADO DE LOS EQUIPOS
                </p>

                <p class="ubicacion-subtitulo" style="margin-top: 7px;">
                    Tipo: {{ strtoupper($ubicacione->tipo ?? 'SIN TIPO') }}
                    &nbsp;|&nbsp;
                    Código: {{ $ubicacione->id }}
                    &nbsp;|&nbsp;
                    Fecha del reporte: {{ now()->format('d/m/Y') }}
                </p>
            </div>

            <div class="ubicacion-no-imprimir">
                <button type="button"
                        class="btn btn-secondary"
                        onclick="window.print()">
                    <i class="fas fa-print"></i> IMPRIMIR
                </button>
            </div>
        </div>

        {{-- TARJETAS DE RESUMEN --}}
        <div class="row mb-4">
            <div class="col-6 col-lg-3 mb-3">
                <div class="ubicacion-card total">
                    <div class="ubicacion-card-etiqueta">TOTAL DE EQUIPOS</div>
                    <div class="ubicacion-card-numero">{{ $totalEquipos }}</div>
                    <div class="ubicacion-subtitulo">Asignados a esta ubicación</div>
                </div>
            </div>

            <div class="col-6 col-lg-3 mb-3">
                <div class="ubicacion-card bueno">
                    <div class="ubicacion-card-etiqueta">BUENOS</div>
                    <div class="ubicacion-card-numero">{{ $buenos }}</div>
                    <div class="ubicacion-subtitulo">En buen estado</div>
                </div>
            </div>

            <div class="col-6 col-lg-3 mb-3">
                <div class="ubicacion-card regular">
                    <div class="ubicacion-card-etiqueta">REGULARES</div>
                    <div class="ubicacion-card-numero">{{ $regulares }}</div>
                    <div class="ubicacion-subtitulo">Requieren seguimiento</div>
                </div>
            </div>

            <div class="col-6 col-lg-3 mb-3">
                <div class="ubicacion-card malogrado">
                    <div class="ubicacion-card-etiqueta">MALOGRADOS</div>
                    <div class="ubicacion-card-numero">{{ $malogrados }}</div>
                    <div class="ubicacion-subtitulo">Requieren revisión</div>
                </div>
            </div>
        </div>

        {{-- DISTRIBUCIÓN POR ESTADO --}}
        <div class="ubicacion-panel">
            <div class="ubicacion-panel-header">
                <h4>ESTADO GENERAL DE LOS EQUIPOS</h4>
            </div>

            <div class="ubicacion-panel-body">
                @if ($totalEquipos === 0)
                    <div class="ubicacion-vacio">
                        <strong>Esta ubicación no tiene equipos</strong>
                        Los equipos que se asignen a esta ubicación aparecerán aquí.
                    </div>
                @else
                    <div class="ubicacion-estado-fila">
                        <div class="ubicacion-estado-detalle">
                            <strong>BUENOS</strong>
                            <span>{{ $buenos }} equipos ({{ $porcentajeBueno }}%)</span>
                        </div>
                        <div class="ubicacion-barra-fondo">
                            <div class="ubicacion-barra bueno"
                                 style="width: {{ $porcentajeBueno }}%;"></div>
                        </div>
                    </div>

                    <div class="ubicacion-estado-fila">
                        <div class="ubicacion-estado-detalle">
                            <strong>REGULARES</strong>
                            <span>{{ $regulares }} equipos ({{ $porcentajeRegular }}%)</span>
                        </div>
                        <div class="ubicacion-barra-fondo">
                            <div class="ubicacion-barra regular"
                                 style="width: {{ $porcentajeRegular }}%;"></div>
                        </div>
                    </div>

                    <div class="ubicacion-estado-fila">
                        <div class="ubicacion-estado-detalle">
                            <strong>MALOGRADOS</strong>
                            <span>{{ $malogrados }} equipos ({{ $porcentajeMalogrado }}%)</span>
                        </div>
                        <div class="ubicacion-barra-fondo">
                            <div class="ubicacion-barra malogrado"
                                 style="width: {{ $porcentajeMalogrado }}%;"></div>
                        </div>
                    </div>

                    @if ($sinClasificar > 0)
                        <div class="ubicacion-estado-fila">
                            <div class="ubicacion-estado-detalle">
                                <strong>SIN CLASIFICAR</strong>
                                <span>{{ $sinClasificar }} equipos ({{ $porcentajeSinClasificar }}%)</span>
                            </div>
                            <div class="ubicacion-barra-fondo">
                                <div class="ubicacion-barra pendiente"
                                     style="width: {{ $porcentajeSinClasificar }}%;"></div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        {{-- TABLA DE EQUIPOS --}}
        <div class="ubicacion-panel">
            <div class="ubicacion-panel-header d-flex justify-content-between align-items-center flex-wrap"
                 style="gap: 10px;">
                <h4>EQUIPOS ASIGNADOS A ESTA UBICACIÓN</h4>

                <span class="ubicacion-subtitulo">
                    Total de registros: {{ $totalEquipos }}
                </span>
            </div>

            @if ($equipos->isEmpty())
                <div class="ubicacion-vacio">
                    <strong>No hay equipos para mostrar</strong>
                    Cuando se asignen equipos a esta ubicación, aparecerán aquí.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table ubicacion-tabla">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tipo de equipo</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>N.º de serie</th>
                                <th>Fecha de registro</th>
                                <th>Estado</th>
                                <th class="ubicacion-no-imprimir">Ficha</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($equipos as $equipo)
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
                                    <td><strong>#{{ $equipo->id }}</strong></td>

                                    <td>
                                        {{ strtoupper($equipo->tipoEquipo->nombre ?? 'SIN TIPO') }}
                                    </td>

                                    <td>
                                        {{ strtoupper($equipo->marca ?? 'SIN MARCA') }}
                                    </td>

                                    <td>
                                        {{ strtoupper($equipo->modelo ?? 'SIN MODELO') }}
                                    </td>

                                    <td>
                                        {{ $equipo->num_serie ?: 'SIN SERIE' }}
                                    </td>

                                    <td>
                                        {{ $equipo->fecha_registro
                                            ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('d/m/Y')
                                            : 'SIN FECHA' }}
                                    </td>

                                    <td>
                                        <span class="ubicacion-badge {{ $claseEstado }}">
                                            {{ $estadoEquipo }}
                                        </span>
                                    </td>

                                    <td class="ubicacion-no-imprimir">
                                        <a href="{{ route('equipos.show', $equipo->id) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> VER
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <p class="ubicacion-subtitulo text-right">
            INVENTARIO 2026 - REPORTE DE UBICACIÓN
        </p>
    </div>

    {{-- VOLVER ABAJO A LA IZQUIERDA --}}
    <div class="ubicacion-no-imprimir mt-3 mb-4">
        <a href="{{ route('ubicaciones.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> VOLVER
        </a>
    </div>

</section>
@endsection