<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: A4 landscape;
            margin: 138px 12px 18px 12px;
            /* margen superior */
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* ---------- Header fijo ---------- */
        .encabezado-general {
            position: fixed;
            top: -128px;
            left: 0;
            right: 0;
            height: 125px;
        }

        .encabezado {
            width: 100%;
            border-collapse: collapse;
            margin: 0 0 2px 0;
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

        /* Bloque RESPONSABLE / CARGO */
        .cabecera-datos {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            table-layout: fixed;
        }

        .cabecera-datos td {
            border: 1px solid #000;
            padding: 2px 4px;
            vertical-align: middle;
            height: 15px;
        }

        .cab-vacio-izq {
            width: 3%;
            border: none !important;
            padding: 0 !important;
        }

        .cabecera-label {
            width: 11%;
            background-color: #D6A84F;
            font-weight: bold;
            text-align: center;
            font-size: 8.5px;
        }

        .cabecera-valor {
            width: 28.5%;
            font-size: 9px;
        }

        .cab-vacio-der {
            width: 18%;
            border: none !important;
            padding: 0 !important;
        }

        /* Subtítulo */
        .subtitulo {
    width: 100%;
    text-align: left;
    font-size: 11px;
    font-weight: bold;
    margin: 7px 0 1px 0;   /* ← más espacio arriba + poco espacio abajo */
    padding: 0;
}

        .espacio-antes-tabla {
            height: 0;
        }

        /* ---------- Tabla principal ---------- */
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
            vertical-align: middle;
        }

        .tabla-principal th {
            background-color: #90EE90;
            font-size: 9.5px;
            font-weight: bold;
            text-align: center;
            padding: 3px 2px;
        }

        .tabla-principal td {
            font-size: 9.5px;
            padding: 3px 2px;
        }

        .fila-prestamo {
            page-break-inside: avoid;
        }

        .col-numero {
            width: 3%;
            text-align: center;
        }

        .col-nombre {
            width: 16%;
        }

        .col-cargo {
            width: 11%;
        }

        .col-equipo {
            width: 30%;
        }

        .col-fecha {
            width: 7%;
            text-align: center;
        }

        .col-hora {
            width: 7%;
            text-align: center;
        }

        .col-estado {
            width: 8%;
            text-align: center;
        }

        .col-observacion {
            width: 14%;
        }

        .texto-centro {
            text-align: center;
        }

        .estado {
            font-weight: bold;
        }

        .equipo {
            margin-bottom: 3px;
            line-height: 1.2;
        }

        .equipo:last-child {
            margin-bottom: 0;
        }

        .accesorio {
            margin-left: 6px;
            font-size: 9.5px;
            line-height: 1.15;
        }

        .observacion-equipo {
            margin-bottom: 3px;
            line-height: 1.2;
        }

        .observacion-accesorio {
            margin-left: 6px;
            font-size: 9.5px;
            line-height: 1.15;
        }

        .separador {
            border-bottom: 1px solid #999;
            margin: 2px 0;
        }
    </style>
</head>

<body>

    {{-- Header fijo --}}
    <div class="encabezado-general">
        <table class="encabezado">
            <tr>
                <td class="logo-izquierdo">
                    <img src="{{ public_path('logo/jorgada.jpg') }}" class="logo" alt="Logo">
                </td>
                <td class="titulo-centro">
                    FORMATO PARA PRESTAMO DE EQUIPOS TECNOLOGICOS
                </td>
                <td class="logo-derecho">
                    <img src="{{ public_path('logo/logo.jpg') }}" class="logo-grande" alt="Logo">
                </td>
            </tr>
        </table>

        <table class="cabecera-datos">
            <tr>
                <td class="cab-vacio-izq"></td>
                <td class="cabecera-label">RESPONSABLE</td>
                <td class="cabecera-valor">ING. MICHAEL CABOS OLIVARES</td>
                <td class="cabecera-label">CARGO</td>
                <td class="cabecera-valor">COORDINADOR DE INNOVACION Y SOPORTE TECNOLOGICO</td>
                <td class="cab-vacio-der"></td>
            </tr>
        </table>

        {{-- Subtítulo --}}
        <div class="subtitulo">
            DATOS DEL SOLICITANTE Y EQUIPO TECNOLOGICO
        </div>

        <div class="espacio-antes-tabla"></div>

    </div>


    <table class="tabla-principal">
        <thead>
            <tr>
                <th class="col-numero">N°</th>
                <th class="col-nombre">APELLIDOS Y NOMBRES</th>
                <th class="col-cargo">CARGO</th>
                <th class="col-equipo">EQUIPO TECNOLOGICO</th>
                <th class="col-fecha">FECHA</th>
                <th class="col-hora">HORA<br>DESDE</th>
                <th class="col-hora">HORA<br>HASTA</th>
                <th class="col-estado">ESTADO</th>
                <th class="col-observacion">OBSERVACION</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prestamos as $indice => $p)
                @php
                    $nombreSolicitante = mb_strtoupper(trim(($p->docente->apellidos ?? '') . ' ' . ($p->docente->nombres ?? '')), 'UTF-8');
                    $cargoSolicitante = mb_strtoupper($p->cargo ?? '', 'UTF-8');
                    $estado = mb_strtoupper($p->estado ?? '', 'UTF-8');

                    $fechaMostrar = '-';
                    if ($p->fecha) {
                        try {
                            $fechaMostrar = \Carbon\Carbon::parse($p->fecha)->format('d/m/Y');
                        } catch (\Exception $e) {
                            $fechaMostrar = $p->fecha;
                        }
                    }

                    $horaInicioMostrar = '-';
                    if ($p->hora_inicio) {
                        try {
                            $horaInicioMostrar = \Carbon\Carbon::createFromFormat('H:i', substr($p->hora_inicio, 0, 5))->format('h:i A');
                        } catch (\Exception $e) {
                            $horaInicioMostrar = substr($p->hora_inicio, 0, 5);
                        }
                    }

                    $horaFinMostrar = '-';
                    if ($p->hora_fin) {
                        try {
                            $horaFinMostrar = \Carbon\Carbon::createFromFormat('H:i', substr($p->hora_fin, 0, 5))->format('h:i A');
                        } catch (\Exception $e) {
                            $horaFinMostrar = substr($p->hora_fin, 0, 5);
                        }
                    }
                @endphp

                <tr class="fila-prestamo">
                    <td class="col-numero texto-centro">{{ sprintf('%02d', $indice + 1) }}</td>
                    <td class="col-nombre">{{ $nombreSolicitante ?: '-' }}</td>
                    <td class="col-cargo">{{ $cargoSolicitante ?: '-' }}</td>

                    <td class="col-equipo">
                        @forelse ($p->prestamoEquipos as $prestamoEquipo)
                            @php
                                $equipo = $prestamoEquipo->equipo;
                                $tipoEquipo = mb_strtoupper($equipo->tipoEquipo->nombre ?? '', 'UTF-8');
                                $marca = mb_strtoupper($equipo->marca ?? '', 'UTF-8');
                                $modelo = mb_strtoupper($equipo->modelo ?? '', 'UTF-8');
                                $serie = mb_strtoupper($equipo->num_serie ?? '', 'UTF-8');
                            @endphp

                            <div class="equipo">
                                <strong>EQUIPO:</strong>
                                {{ $tipoEquipo ?: '-' }}
                                @if ($marca) | {{ $marca }} @endif
                                @if ($modelo) | {{ $modelo }} @endif
                                @if ($serie) | N/S {{ $serie }} @endif
                            </div>

                            @foreach ($prestamoEquipo->prestamoAccesorios as $prestamoAccesorio)
                                @php
                                    $accesorio = $prestamoAccesorio->accesorioEquipo;
                                    $tipoAcc = mb_strtoupper($accesorio->tipo ?? '', 'UTF-8');
                                    $marcaAcc = mb_strtoupper($accesorio->marca ?? '', 'UTF-8');
                                    $serieAcc = mb_strtoupper($accesorio->num_serie ?? '', 'UTF-8');
                                @endphp
                                <div class="accesorio">
                                    <strong>ACCESORIO:</strong>
                                    {{ $tipoAcc ?: '-' }}
                                    @if ($marcaAcc) | {{ $marcaAcc }} @endif
                                    @if ($serieAcc) | N/S {{ $serieAcc }} @endif
                                </div>
                            @endforeach

                            @if (!$loop->last)
                                <div class="separador"></div>
                            @endif
                        @empty
                            -
                        @endforelse
                    </td>

                    <td class="col-fecha texto-centro">{{ $fechaMostrar }}</td>
                    <td class="col-hora texto-centro">{{ $horaInicioMostrar }}</td>
                    <td class="col-hora texto-centro">{{ $horaFinMostrar }}</td>
                    <td class="col-estado"><span class="estado">{{ $estado ?: '-' }}</span></td>

                    <td class="col-observacion">
                        @php $tieneObs = false; @endphp
                        @foreach ($p->prestamoEquipos as $prestamoEquipo)
                            @php
                                $obsEq = mb_strtoupper(trim($prestamoEquipo->observacion ?? ''), 'UTF-8');
                                $tipoEq = mb_strtoupper($prestamoEquipo->equipo->tipoEquipo->nombre ?? '', 'UTF-8');
                            @endphp
                            @if ($obsEq)
                                @php $tieneObs = true; @endphp
                                <div class="observacion-equipo">
                                    <strong>EQUIPO:</strong> {{ $tipoEq }} | {{ $obsEq }}
                                </div>
                            @endif

                            @foreach ($prestamoEquipo->prestamoAccesorios as $pa)
                                @php
                                    $obsAcc = mb_strtoupper(trim($pa->observacion ?? ''), 'UTF-8');
                                    $tipoAcc = mb_strtoupper($pa->accesorioEquipo->tipo ?? '', 'UTF-8');
                                @endphp
                                @if ($obsAcc)
                                    @php $tieneObs = true; @endphp
                                    <div class="observacion-accesorio">
                                        <strong>ACCESORIO:</strong> {{ $tipoAcc }} | {{ $obsAcc }}
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                        @if (!$tieneObs)
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>