<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page { size: A4 portrait; margin: 28px 36px 24px 36px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #000; }
        h1, h2 { text-align: center; margin: 0; }
        h1 { font-size: 15px; }
        h2 { font-size: 14px; margin: 4px 0 12px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        th, td { border: 1px solid #000; padding: 5px 6px; }
        .seccion {
            background: #1F4E79;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }
        .label { width: 18%; font-weight: bold; background: #f3f3f3; }
        .cabecera {
            background: #D6A84F;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }
        .medio {
            text-align: center;
            vertical-align: middle;
        }
        .legal { font-size: 12px; text-align: justify; }
        .firmas { table-layout: fixed; width: 100%; }
        .firmas th, .firmas td { width: 33.33%; text-align: center; vertical-align: top; }
        .espacio-firma { height: 58px; }
        .linea-firma {
            margin-top: 34px;
            border-top: 1px solid #000;
            padding-top: 3px;
            font-size: 9px;
        }
        .detalle-acc {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
    @php
        $docente = $prestamo->docente;
        $fecha = $prestamo->fecha ? $prestamo->fecha->format('d/m/Y') : '';
        $nombreSolicitante = mb_strtoupper(trim(($docente->nombres ?? '') . ' ' . ($docente->apellidos ?? '')));
    @endphp

    <table style="width: 100%; margin-bottom: 8px; border-collapse: collapse;">
        <tr>
            <td style="width: 20%; border: none; text-align: left; vertical-align: middle;">
                <img src="{{ public_path('logo/logo.jpg') }}" width="85" height="85">
            </td>
            <td style="width: 60%; border: none; text-align: center; vertical-align: middle;">
                <h1>INSTITUCION EDUCATIVA 88021 "ALFONSO UGARTE"</h1>
                <h2>ACTA DE ENTREGA DE EQUIPOS DE COMPUTO</h2>
            </td>
            <td style="width: 20%; border: none; text-align: right; vertical-align: middle;">
                <img src="{{ public_path('logo/jorgada.jpg') }}" width="75" height="75">
            </td>
        </tr>
    </table>

    <table>
        <tr><td class="seccion" colspan="2">DATOS PERSONALES BENEFICIARIO</td></tr>
        <tr><td class="label">NOMBRES</td><td>{{ mb_strtoupper($docente->nombres ?? '') }}</td></tr>
        <tr><td class="label">APELLIDOS</td><td>{{ mb_strtoupper($docente->apellidos ?? '') }}</td></tr>
        <tr><td class="label">DNI</td><td>{{ $docente->dni ?? '' }}</td></tr>
        <tr><td class="label">CORREO</td><td>{{ mb_strtoupper($docente->correo ?? '') }}</td></tr>
        <tr><td class="label">CELULAR</td><td>{{ $docente->celular ?? '' }}</td></tr>
    </table>

    <table>
        <tr><td class="seccion" colspan="7">DATOS DEL EQUIPO</td></tr>
        <tr>
            <th class="cabecera" rowspan="2">EQUIPO</th>
            <th class="cabecera" rowspan="2">MARCA</th>
            <th class="cabecera" rowspan="2">MODELO</th>
            <th class="cabecera" rowspan="2">SERIE</th>
            <th class="cabecera" colspan="3">ACCESORIOS</th>
        </tr>
        <tr>
            <th class="cabecera">TIPO</th>
            <th class="cabecera">MARCA</th>
            <th class="cabecera">SERIE</th>
        </tr>
        @forelse ($prestamo->prestamoEquipos as $prestamoEquipo)
            @php
                $equipo = $prestamoEquipo->equipo;
                $accesorios = $prestamoEquipo->prestamoAccesorios;
                $filas = max($accesorios->count(), 1);
            @endphp
            @for ($i = 0; $i < $filas; $i++)
                @php $filaAcc = $accesorios[$i] ?? null; @endphp
                <tr>
                    @if ($i === 0)
                        <td class="medio" rowspan="{{ $filas }}">{{ mb_strtoupper($equipo->tipoEquipo->nombre ?? '-') }}</td>
                        <td class="medio" rowspan="{{ $filas }}">{{ mb_strtoupper($equipo->marca ?? '-') }}</td>
                        <td class="medio" rowspan="{{ $filas }}">{{ mb_strtoupper($equipo->modelo ?? '-') }}</td>
                        <td class="medio" rowspan="{{ $filas }}">{{ mb_strtoupper($equipo->num_serie ?? '-') }}</td>
                    @endif
                    <td class="medio">{{ mb_strtoupper($filaAcc->accesorioEquipo->tipo ?? '-') }}</td>
                    <td class="medio">{{ mb_strtoupper($filaAcc->accesorioEquipo->marca ?? '-') }}</td>
                    <td class="medio">{{ mb_strtoupper($filaAcc->accesorioEquipo->num_serie ?? '-') }}</td>
                </tr>
            @endfor
        @empty
            <tr>
                <td class="medio" colspan="7">SIN EQUIPOS REGISTRADOS</td>
            </tr>
        @endforelse
    </table>

    <table>
        <tr><td class="seccion" colspan="2">ESPECIFICACIONES GENERALES</td></tr>
        @foreach ($prestamo->prestamoEquipos as $prestamoEquipo)
            @php
                $equipo = $prestamoEquipo->equipo;
                $laptop = $equipo->especificacionesLaptops;
                $otro = $equipo->especificacionesEquipo;
                $specs = mb_strtoupper(implode(' | ', array_filter([
                    $laptop->procesador ?? null,
                    $laptop->ram ?? null,
                    $laptop->disco_duro ?? null,
                    $otro->descripcion ?? null,
                ]))) ?: '-';
                $estadoEquipo = mb_strtoupper($prestamoEquipo->estado ?? $laptop->estado ?? $otro->estado ?? '-');
                $obsEquipo = mb_strtoupper($prestamoEquipo->observacion ?? '-');
            @endphp
            <tr>
                <td style="width: 62%;"><strong>{{ mb_strtoupper($equipo->tipoEquipo->nombre ?? 'EQUIPO') }}:</strong> {{ $specs }}</td>
                <td style="width: 38%;"><strong>COLOR:</strong> {{ mb_strtoupper($laptop->color ?? $otro->color ?? '-') }}</td>
            </tr>
            <tr>
                <td style="width: 32%;"><strong>ESTADO:</strong> {{ $estadoEquipo }}</td>
                <td style="width: 68%;"><strong>OBSERVACIONES:</strong> {{ $obsEquipo }}</td>
            </tr>
        @endforeach
    </table>

    <table class="detalle-acc">
        <colgroup>
            <col width="120">
            <col width="90">
            <col width="330">
        </colgroup>
        <tr>
            <td style="width: 120px; height: 0; padding: 0; border: none; font-size: 0;"></td>
            <td style="width: 90px; height: 0; padding: 0; border: none; font-size: 0;"></td>
            <td style="width: 330px; height: 0; padding: 0; border: none; font-size: 0;"></td>
        </tr>
        <tr>
            <td class="seccion" colspan="3">DETALLE ACCESORIOS</td>
        </tr>
        <tr>
            <th class="cabecera">TIPO</th>
            <th class="cabecera">ESTADO</th>
            <th class="cabecera">OBSERVACIONES</th>
        </tr>
        @php $hayAccesorios = false; @endphp
        @foreach ($prestamo->prestamoEquipos as $prestamoEquipo)
            @foreach ($prestamoEquipo->prestamoAccesorios as $filaAcc)
                @php $hayAccesorios = true; @endphp
                <tr>
                    <td class="medio">{{ mb_strtoupper($filaAcc->accesorioEquipo->tipo ?? '-') }}</td>
                    <td class="medio">{{ mb_strtoupper($filaAcc->estado ?? $filaAcc->accesorioEquipo->estado ?? '-') }}</td>
                    <td>{{ mb_strtoupper($filaAcc->observacion ?? $filaAcc->accesorioEquipo->observaciones ?? '-') }}</td>
                </tr>
            @endforeach
        @endforeach
        @if (!$hayAccesorios)
            <tr>
                <td class="medio" colspan="3">SIN ACCESORIOS</td>
            </tr>
        @endif
    </table>

    <table>
        <tr><td class="seccion">OBSERVACIONES</td></tr>
        <tr>
            <td class="legal">
                Certifico que los elementos detallados en el presente documento, me han sido entregados para mi cuidado y custodia con el próposito de cumplir con las tareas y asignaciones propias a mi cargo, siendo estos de mi única y exclusiva responsabilidad. Me comprometo a usar correctamente los equipos y solo para uso de los fines establecidos, a no instalar ni permitir la instalacion de software por personas ajenas al grupo interno de trabajo de soporte técnico.
            </td>
        </tr>
    </table>

    <table class="firmas">
        <tr><td class="seccion" colspan="3">ENTREGA DEL EQUIPO</td></tr>
        <tr>
            <th class="cabecera">RECIBE</th>
            <th class="cabecera">ENTREGA</th>
            <th class="cabecera">DEVOLUCION</th>
        </tr>
        <tr>
            <td>NOMBRES:<br>{{ $nombreSolicitante }}</td>
            <td>NOMBRES:<br>MICHAEL RAUL CABOS OLIVARES</td>
            <td>NOMBRES:</td>
        </tr>
        <tr>
            <td class="espacio-firma">
                <div class="linea-firma">FIRMA</div>
            </td>
            <td class="espacio-firma">
                <div class="linea-firma">FIRMA</div>
            </td>
            <td class="espacio-firma">
                <div class="linea-firma">FIRMA</div>
            </td>
        </tr>
        <tr>
            <td>FECHA: {{ $fecha }}</td>
            <td>FECHA: {{ $fecha }}</td>
            <td>FECHA:</td>
        </tr>
    </table>
</body>
</html>