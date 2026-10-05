<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <style>
        @page {
            size: A4 landscape;
            margin: 138px 12px 18px 12px;
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

        /* ---------- Bloque RESPONSABLE / CARGO ---------- */
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

        /* ---------- Subtítulo ---------- */
        .subtitulo {
            width: 100%;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            margin: 7px 0 1px 0;
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

        .fila-equipo {
            page-break-inside: avoid;
        }

        /* ---------- Columnas ---------- */
        .col-numero {
            width: 4%;
            text-align: center;
        }

        .col-tipo {
            width: 13%;
        }

        .col-serie {
            width: 13%;
        }

        .col-marca {
            width: 11%;
        }

        .col-modelo {
            width: 12%;
        }

        .col-estado {
            width: 9%;
            text-align: center;
        }

        .col-ubicacion {
            width: 13%;
        }

        .col-fecha {
            width: 8%;
            text-align: center;
        }

        .col-observacion {
            width: 17%;
        }

        .texto-centro {
            text-align: center;
        }

        .estado {
            font-weight: bold;
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
                    FORMATO PARA REGISTRO DE EQUIPOS TECNOLOGICOS
                </td>

                <td class="logo-derecho">
                    <img src="{{ public_path('logo/logo.jpg') }}" class="logo-grande" alt="Logo">
                </td>
            </tr>
        </table>

        {{-- MISMA MINI TABLA DE PRESTAMOS --}}
        <table class="cabecera-datos">
            <tr>
                <td class="cab-vacio-izq"></td>

                <td class="cabecera-label">
                    RESPONSABLE
                </td>

                <td class="cabecera-valor">
                    ING. MICHAEL CABOS OLIVARES
                </td>

                <td class="cabecera-label">
                    CARGO
                </td>

                <td class="cabecera-valor">
                    COORDINADOR DE INNOVACION Y SOPORTE TECNOLOGICO
                </td>

                <td class="cab-vacio-der"></td>
            </tr>
        </table>

        {{-- Subtítulo --}}
        <div class="subtitulo">
            DATOS DE LOS EQUIPOS TECNOLOGICOS
        </div>

        <div class="espacio-antes-tabla"></div>

    </div>


    {{-- Tabla principal --}}
    <table class="tabla-principal">

        <thead>
            <tr>
                <th class="col-numero">N°</th>
                <th class="col-tipo">TIPO</th>
                <th class="col-serie">N.º SERIE</th>
                <th class="col-marca">MARCA</th>
                <th class="col-modelo">MODELO</th>
                <th class="col-estado">ESTADO</th>
                <th class="col-ubicacion">UBICACIÓN</th>
                <th class="col-fecha">FECHA</th>
                <th class="col-observacion">OBSERVACIÓN</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($equipos as $indice => $equipo)

                @php
                    $tipoEquipo = mb_strtoupper(
                        trim($equipo->tipoEquipo->nombre ?? ''),
                        'UTF-8'
                    );

                    $serie = mb_strtoupper(
                        trim($equipo->num_serie ?? ''),
                        'UTF-8'
                    );

                    $marca = mb_strtoupper(
                        trim($equipo->marca ?? ''),
                        'UTF-8'
                    );

                    $modelo = mb_strtoupper(
                        trim($equipo->modelo ?? ''),
                        'UTF-8'
                    );

                    $estado = mb_strtoupper(
                        trim(
                            $equipo->especificacionesLaptops->estado
                            ?? $equipo->especificacionesEquipo->estado
                            ?? ''
                        ),
                        'UTF-8'
                    );

                    $ubicacion = mb_strtoupper(
                        trim($equipo->ubicacione->nombre ?? ''),
                        'UTF-8'
                    );

                    $observacion = mb_strtoupper(
                        trim(
                            $equipo->especificacionesLaptops->observaciones
                            ?? $equipo->especificacionesEquipo->observaciones
                            ?? ''
                        ),
                        'UTF-8'
                    );

                    $fechaMostrar = '-';

                    if ($equipo->fecha_registro) {
                        try {
                            $fechaMostrar = \Carbon\Carbon::parse(
                                $equipo->fecha_registro
                            )->format('d/m/Y');
                        } catch (\Exception $e) {
                            $fechaMostrar = $equipo->fecha_registro;
                        }
                    }
                @endphp

                <tr class="fila-equipo">

                    {{-- N° consecutivo, no ID de BD --}}
                    <td class="col-numero texto-centro">
                        {{ sprintf('%02d', $indice + 1) }}
                    </td>

                    <td class="col-tipo">
                        {{ $tipoEquipo ?: '-' }}
                    </td>

                    <td class="col-serie">
                        {{ $serie ?: '-' }}
                    </td>

                    <td class="col-marca">
                        {{ $marca ?: '-' }}
                    </td>

                    <td class="col-modelo">
                        {{ $modelo ?: '-' }}
                    </td>

                    <td class="col-estado texto-centro">
                        <span class="estado">
                            {{ $estado ?: '-' }}
                        </span>
                    </td>

                    <td class="col-ubicacion">
                        {{ $ubicacion ?: '-' }}
                    </td>

                    <td class="col-fecha texto-centro">
                        {{ $fechaMostrar }}
                    </td>

                    <td class="col-observacion">
                        {{ $observacion ?: '-' }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</body>

</html>