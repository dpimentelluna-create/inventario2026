<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: A4 landscape;
            margin: 145px 12px 20px 12px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* Encabezado institucional fijo */
        .encabezado-general {
            position: fixed;
            top: -135px;
            left: 0;
            right: 0;
            height: 130px;
        }

        .encabezado {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3px;
        }

        .encabezado td {
            border: none;
            vertical-align: middle;
            padding: 0;
        }

        .logo-izquierdo {
            width: 9%;
            text-align: center;
        }

        .logo-derecho {
            width: 18%;
            text-align: center;
        }

        .logo {
            width: 48px;
            height: 48px;
        }

        .logo-grande {
            width: 72px;
            height: 72px;
        }

        .titulo-centro {
            width: 73%;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }

        /* Responsable y cargo */
        .cabecera-datos {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .cabecera-datos td {
            border: 1px solid #000;
            padding: 3px 5px;
            vertical-align: middle;
            height: 16px;
        }

        .cabecera-label {
            width: 15%;
            background-color: #D6A84F;
            font-weight: bold;
            text-align: center;
            font-size: 9px;
        }

        .cabecera-valor {
            width: 85%;
            font-size: 9px;
        }

        .subtitulo {
            width: 100%;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            margin: 0 0 8px 0;
            padding: 0;
            position: relative;
        }

        /* Tabla principal */
        .tabla-principal {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .tabla-principal thead {
            display: table-header-group;
        }

        .tabla-principal th,
        .tabla-principal td {
            border: 1px solid #000;
            vertical-align: top;
        }

        .tabla-principal th {
            background-color: #90EE90;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
            padding: 4px 2px;
        }

        .tabla-principal td {
            font-size: 8px;
            padding: 4px 3px;
            word-wrap: break-word;
        }

        .fila-baja {
            page-break-inside: avoid;
        }

        .centro {
            text-align: center;
        }

        .estado {
            font-weight: bold;
            text-align: center;
        }

        .equipo,
        .persona,
        .accesorio,
        .anulacion {
            margin-bottom: 3px;
            line-height: 1.25;
        }

        .persona:last-child,
        .accesorio:last-child {
            margin-bottom: 0;
        }

        .separador {
            border-bottom: 1px solid #999;
            margin: 3px 0;
        }

        .observaciones {
            line-height: 1.3;
        }

        /* Anchos de columnas */
        .col-numero {
            width: 3%;
        }

        .col-id {
            width: 4%;
        }

        .col-fecha {
            width: 7%;
        }

        .col-equipo {
            width: 17%;
        }

        .col-destino {
            width: 11%;
        }

        .col-entrega {
            width: 12%;
        }

        .col-recepcion {
            width: 12%;
        }

        .col-accesorios {
            width: 13%;
        }

        .col-estado {
            width: 7%;
        }

        .col-observaciones {
            width: 8%;
        }

        .col-anulacion {
            width: 6%;
        }
    </style>
</head>

<body>

    {{-- Encabezado institucional --}}
    <div class="encabezado-general">

        <table class="encabezado">
            <tr>
                <td class="logo-izquierdo">
                    <img src="{{ public_path('logo/jorgada.jpg') }}" class="logo" alt="Logo">
                </td>

                <td class="titulo-centro">
                    FORMATO DE BAJAS ADMINISTRATIVAS DE EQUIPOS
                </td>

                <td class="logo-derecho">
                    <img src="{{ public_path('logo/logo.jpg') }}" class="logo-grande" alt="Logo">
                </td>
            </tr>
        </table>

        <table class="cabecera-datos">
            <tr>
                <td class="cabecera-label">RESPONSABLE</td>
                <td class="cabecera-valor">ING. MICHAEL CABOS OLIVARES</td>
            </tr>
            <tr>
                <td class="cabecera-label">CARGO</td>
                <td class="cabecera-valor">
                    COORDINADOR DE INNOVACION Y SOPORTE TECNOLOGICO
                </td>
            </tr>
        </table>

    </div>

    {{-- Subtítulo del historial --}}
    <div class="subtitulo">
        HISTORIAL DE BAJAS ADMINISTRATIVAS DE EQUIPOS
    </div>

    {{-- Tabla de bajas --}}
    <table class="tabla-principal">

        <thead>
            <tr>
                <th class="col-numero">N°</th>
                <th class="col-id">ID</th>
                <th class="col-fecha">FECHA</th>
                <th class="col-equipo">EQUIPO Y SERIE</th>
                <th class="col-destino">DESTINO</th>
                <th class="col-entrega">QUIÉN ENTREGA</th>
                <th class="col-recepcion">QUIÉN RECIBE</th>
                <th class="col-accesorios">ACCESORIOS</th>
                <th class="col-estado">ESTADO</th>
                <th class="col-observaciones">OBSERVACIONES</th>
                <th class="col-anulacion">ANULACIÓN</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($bajas as $indice => $baja)

                @php
                    $equipo = $baja->equipo;

                    $tipo = mb_strtoupper($equipo->tipoEquipo->nombre ?? 'SIN TIPO', 'UTF-8');
                    $marca = mb_strtoupper($equipo->marca ?? '', 'UTF-8');
                    $modelo = mb_strtoupper($equipo->modelo ?? '', 'UTF-8');
                    $serie = mb_strtoupper($equipo->num_serie ?? '', 'UTF-8');
                    $ubicacion = mb_strtoupper($equipo->ubicacione->nombre ?? '', 'UTF-8');

                    $fechaMostrar = $baja->fecha
                        ? $baja->fecha->format('d/m/Y')
                        : '-';

                    $entregantes = is_array($baja->entregantes)
                        ? $baja->entregantes
                        : [];

                    $receptores = is_array($baja->receptores)
                        ? $baja->receptores
                        : [];

                    $anulacionFecha = $baja->anulada_at
                        ? $baja->anulada_at->format('d/m/Y h:i A')
                        : '-';

                    $anulacionUsuario = $baja->anuladaPor->name
                        ?? 'USUARIO NO DISPONIBLE';
                @endphp

                <tr class="fila-baja">

                    <td class="centro">
                        {{ sprintf('%02d', $indice + 1) }}
                    </td>

                    <td class="centro">
                        {{ $baja->id }}
                    </td>

                    <td class="centro">
                        {{ $fechaMostrar }}
                    </td>

                    <td>
                        <div class="equipo">
                            <strong>TIPO:</strong> {{ $tipo }}
                        </div>

                        <div class="equipo">
                            <strong>MARCA:</strong> {{ $marca ?: '-' }}
                        </div>

                        <div class="equipo">
                            <strong>MODELO:</strong> {{ $modelo ?: '-' }}
                        </div>

                        <div class="equipo">
                            <strong>N/S:</strong> {{ $serie ?: '-' }}
                        </div>

                        <div class="equipo">
                            <strong>UBICACIÓN:</strong> {{ $ubicacion ?: '-' }}
                        </div>
                    </td>

                    <td>
                        {{ mb_strtoupper($baja->destino ?? '-', 'UTF-8') }}
                    </td>

                    <td>
                        @forelse ($entregantes as $persona)
                            <div class="persona">
                                <strong>{{ mb_strtoupper($persona['nombre'] ?? '', 'UTF-8') }}</strong>
                                <br>
                                CARGO: {{ mb_strtoupper($persona['cargo'] ?? '', 'UTF-8') }}
                            </div>
                        @empty
                            -
                        @endforelse
                    </td>

                    <td>
                        @forelse ($receptores as $persona)
                            <div class="persona">
                                <strong>{{ mb_strtoupper($persona['nombre'] ?? '', 'UTF-8') }}</strong>
                                <br>
                                CARGO: {{ mb_strtoupper($persona['cargo'] ?? '', 'UTF-8') }}
                            </div>
                        @empty
                            -
                        @endforelse
                    </td>

                    <td>
                        @forelse ($baja->accesoriosIncluidos as $accesorio)
                            <div class="accesorio">
                                <strong>{{ mb_strtoupper($accesorio->tipo ?? 'ACCESORIO', 'UTF-8') }}</strong>

                                @if ($accesorio->marca)
                                    <br>MARCA: {{ mb_strtoupper($accesorio->marca, 'UTF-8') }}
                                @endif

                                @if ($accesorio->modelo)
                                    <br>MODELO: {{ mb_strtoupper($accesorio->modelo, 'UTF-8') }}
                                @endif

                                @if ($accesorio->num_serie)
                                    <br>N/S: {{ mb_strtoupper($accesorio->num_serie, 'UTF-8') }}
                                @endif
                            </div>

                            @if (!$loop->last)
                                <div class="separador"></div>
                            @endif
                        @empty
                            -
                        @endforelse
                    </td>

                    <td class="estado">
                        {{ mb_strtoupper($baja->estado ?? '-', 'UTF-8') }}
                    </td>

                    <td class="observaciones">
                        {{ mb_strtoupper($baja->observaciones ?? '-', 'UTF-8') }}
                    </td>

                    <td>
                        @if ($baja->estado === 'ANULADA')
                            <div class="anulacion">
                                <strong>FECHA:</strong>
                                {{ $anulacionFecha }}
                            </div>

                            <div class="anulacion">
                                <strong>USUARIO:</strong>
                                {{ mb_strtoupper($anulacionUsuario, 'UTF-8') }}
                            </div>
                        @else
                            -
                        @endif
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</body>
</html>