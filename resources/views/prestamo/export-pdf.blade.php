<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <style>
        @page {
            size: A4 landscape;
            margin: 10px 12px 12px 12px;
        }
    
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #000;
            margin: 0;
            padding: 0;
        }
    
        /* =========================================================
               ENCABEZADO GENERAL
            ========================================================= */
    
        .encabezado {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }
    
        .encabezado td {
            border: none;
            vertical-align: middle;
        }
    
        .logo {
            width: 45px;
            height: 45px;
            object-fit: contain;
        }
    
        .logo-izquierdo,
        .logo-derecho {
            width: 13%;
            height: 45px;
            text-align: center;
        }
    
        .espacio-logo {
            width: 100%;
            height: 40px;
            text-align: center;
            vertical-align: middle;
            font-size: 7px;
            color: #777;
        }
    
        .titulo-centro {
            width: 74%;
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            vertical-align: middle;
        }
    
        /* =========================================================
               RESPONSABLE / CARGO
            ========================================================= */
    
        .cabecera-datos {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 7px;
        }
    
        .cabecera-datos td {
            border: 1px solid #000;
            padding: 4px;
            height: 20px;
            vertical-align: middle;
        }
    
        .cabecera-label {
            width: 10%;
            background-color: #D6A84F;
            font-weight: bold;
            text-align: center;
        }
    
        .cabecera-valor {
            width: 40%;
        }
    
        /* =========================================================
               TABLA PRINCIPAL
            ========================================================= */
    
        .tabla-principal {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
    
        .tabla-principal th,
        .tabla-principal td {
            border: 1px solid #000;
            vertical-align: middle;
        }
    
        .tabla-principal th {
            background-color: #90EE90;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
            padding: 3px;
            height: 27px;
        }
    
        .tabla-principal td {
            font-size: 8.5px;
            padding: 3px;
            height: 23px;
        }
    
        /* =========================================================
               ANCHOS DE COLUMNAS
            ========================================================= */
    
        .col-numero {
            width: 3%;
            text-align: center;
        }
    
        .col-nombre {
            width: 17%;
        }
    
        .col-cargo {
            width: 14%;
        }
    
        .col-equipo {
            width: 34%;
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
            width: 11%;
        }
    
        /* =========================================================
               CONTENIDO
            ========================================================= */
    
        .texto-centro {
            text-align: center;
        }
    
        .equipo {
            margin-bottom: 2px;
        }
    
        .equipo:last-child {
            margin-bottom: 0;
        }
    
        .accesorio {
            margin-left: 7px;
            font-size: 8px;
        }
    
        .observacion {
            margin-top: 2px;
            font-size: 8px;
        }
    
        .fila-vacia td {
            height: 23px;
        }
    </style>
</head>

<body>

    {{-- =========================================================
         ENCABEZADO CON ESPACIO PARA LOGOS
    ========================================================== --}}

    <table class="encabezado">
        <tr>

            {{-- LOGO IZQUIERDO --}}
            <td class="logo-izquierdo">
                <img src="{{ public_path('logo/logo.jpg') }}" class="logo" alt="Logo del colegio">
            </td>

            {{-- TÍTULO --}}
            <td class="titulo-centro">
                FORMATO PARA PRESTAMO DE EQUIPOS TECNOLOGICOS
            </td>

            {{-- LOGO DERECHO --}}
            <td class="logo-derecho">
                <img src="{{ public_path('logo/logo.jpg') }}" class="logo" alt="Logo del colegio">
            </td>

        </tr>
    </table>


    {{-- =========================================================
         RESPONSABLE Y CARGO
    ========================================================== --}}

    <table class="cabecera-datos">
        <tr>

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

        </tr>
    </table>


    {{-- =========================================================
         TABLA PRINCIPAL
    ========================================================== --}}

    <table class="tabla-principal">

        <thead>
            <tr>

                <th class="col-numero">
                    N°
                </th>

                <th class="col-nombre">
                    APELLIDOS Y NOMBRES
                </th>

                <th class="col-cargo">
                    CARGO
                </th>

                <th class="col-equipo">
                    EQUIPO TECNOLOGICO
                </th>

                <th class="col-fecha">
                    FECHA
                </th>

                <th class="col-hora">
                    HORA<br>DESDE
                </th>

                <th class="col-hora">
                    HORA<br>HASTA
                </th>

                <th class="col-estado">
                    ESTADO U<br>OBSERVACION
                </th>

            </tr>
        </thead>


        <tbody>

            {{-- =================================================
                 REGISTROS
            ================================================== --}}

            @foreach ($prestamos as $indice => $p)

                @php

    /*
    |--------------------------------------------------------------------------
    | SOLICITANTE
    |--------------------------------------------------------------------------
    */

    $nombreSolicitante = trim(
        ($p->docente->apellidos ?? '') . ' ' .
        ($p->docente->nombres ?? '')
    );

    $nombreSolicitante = mb_strtoupper(
        $nombreSolicitante,
        'UTF-8'
    );


    /*
    |--------------------------------------------------------------------------
    | CARGO
    |--------------------------------------------------------------------------
    */

    $cargoSolicitante = mb_strtoupper(
        $p->cargo ?? '',
        'UTF-8'
    );


    /*
    |--------------------------------------------------------------------------
    | FECHA
    |--------------------------------------------------------------------------
    */

    $fechaMostrar = '';

    if ($p->fecha) {
        try {
            $fechaMostrar = \Carbon\Carbon::parse(
                $p->fecha
            )->format('d/m/Y');
        } catch (\Exception $e) {
            $fechaMostrar = $p->fecha;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | HORA DESDE
    |--------------------------------------------------------------------------
    */

    $horaInicioMostrar = '';

    if ($p->hora_inicio) {
        try {

            $horaInicio = substr(
                $p->hora_inicio,
                0,
                5
            );

            $horaInicioMostrar =
                \Carbon\Carbon::createFromFormat(
                    'H:i',
                    $horaInicio
                )->format('h:i A');

        } catch (\Exception $e) {

            $horaInicioMostrar = substr(
                $p->hora_inicio,
                0,
                5
            );

        }
    }


    /*
    |--------------------------------------------------------------------------
    | HORA HASTA
    |--------------------------------------------------------------------------
    */

    $horaFinMostrar = '';

    if ($p->hora_fin) {
        try {

            $horaFin = substr(
                $p->hora_fin,
                0,
                5
            );

            $horaFinMostrar =
                \Carbon\Carbon::createFromFormat(
                    'H:i',
                    $horaFin
                )->format('h:i A');

        } catch (\Exception $e) {

            $horaFinMostrar = substr(
                $p->hora_fin,
                0,
                5
            );

        }
    }

                @endphp


                <tr>

                    {{-- N° --}}
                    <td class="col-numero texto-centro">
                        {{ sprintf('%02d', $indice + 1) }}
                    </td>


                    {{-- APELLIDOS Y NOMBRES --}}
                    <td class="col-nombre">
                        {{ $nombreSolicitante }}
                    </td>


                    {{-- CARGO DEL SOLICITANTE --}}
                    <td class="col-cargo">
                        {{ $cargoSolicitante ?: '-' }}
                    </td>


                    {{-- EQUIPOS --}}
                    <td class="col-equipo">

                        @forelse ($p->prestamoEquipos as $prestamoEquipo)

                            @php

        $equipo = $prestamoEquipo->equipo;

        $tipoEquipo = mb_strtoupper(
            $equipo->tipoEquipo->nombre ?? '',
            'UTF-8'
        );

        $marca = mb_strtoupper(
            $equipo->marca ?? '',
            'UTF-8'
        );

        $modelo = mb_strtoupper(
            $equipo->modelo ?? '',
            'UTF-8'
        );

        $serie = mb_strtoupper(
            $equipo->num_serie ?? '',
            'UTF-8'
        );

                            @endphp


                            <div class="equipo">

                                <strong>EQUIPO:</strong>
                                {{ $tipoEquipo }}

                                @if ($marca)
                                    + {{ $marca }}
                                @endif

                                @if ($modelo)
                                    + {{ $modelo }}
                                @endif

                                @if ($serie)
                                    + N/S {{ $serie }}
                                @endif


                                {{-- ACCESORIOS --}}
                                @if ($prestamoEquipo->prestamoAccesorios->count())

                                    @foreach (
                $prestamoEquipo->prestamoAccesorios
                as $prestamoAccesorio
            )

                                        @php

                $accesorio =
                    $prestamoAccesorio->accesorioEquipo;

                $tipoAccesorio =
                    mb_strtoupper(
                        $accesorio->tipo ?? '',
                        'UTF-8'
                    );

                $marcaAccesorio =
                    mb_strtoupper(
                        $accesorio->marca ?? '',
                        'UTF-8'
                    );

                $serieAccesorio =
                    mb_strtoupper(
                        $accesorio->num_serie ?? '',
                        'UTF-8'
                    );

                                        @endphp


                                        <div class="accesorio">

                                            <strong>ACCESORIO:</strong>
                                            {{ $tipoAccesorio }}

                                            @if ($marcaAccesorio)
                                                + {{ $marcaAccesorio }}
                                            @endif

                                            @if ($serieAccesorio)
                                                + N/S {{ $serieAccesorio }}
                                            @endif

                                        </div>

                                    @endforeach

                                @endif

                            </div>

                        @empty

                            -

                        @endforelse

                    </td>


                    {{-- FECHA --}}
                    <td class="col-fecha texto-centro">
                        {{ $fechaMostrar ?: '-' }}
                    </td>


                    {{-- HORA DESDE --}}
                    <td class="col-hora texto-centro">
                        {{ $horaInicioMostrar ?: '-' }}
                    </td>


                    {{-- HORA HASTA --}}
                    <td class="col-hora texto-centro">
                        {{ $horaFinMostrar ?: '-' }}
                    </td>


                    {{-- ESTADO / OBSERVACIÓN --}}
                    <td class="col-estado">

                        @php

    $estado = mb_strtoupper(
        $p->estado ?? '',
        'UTF-8'
    );

    $observacion = mb_strtoupper(
        $p->observacion ?? '',
        'UTF-8'
    );

                        @endphp


                        @if ($estado)
                            <strong>{{ $estado }}</strong>
                        @endif


                        @if ($observacion)

                            <div class="observacion">
                                OBS: {{ $observacion }}
                            </div>

                        @endif


                        @if (!$estado && !$observacion)
                            -
                        @endif

                    </td>

                </tr>

            @endforeach


            {{-- =================================================
                 FILAS VACÍAS HASTA COMPLETAR 20
            ================================================== --}}

            @for ($i = $prestamos->count(); $i < 20; $i++)

                <tr class="fila-vacia">

                    <td class="texto-centro">
                        {{ sprintf('%02d', $i + 1) }}
                    </td>

                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>

                </tr>

            @endfor

        </tbody>

    </table>

</body>
</html>