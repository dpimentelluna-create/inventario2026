<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 4px; }
        th { background: #5fe65f; }
    </style>
</head>
<body>
    <h2>REPORTE DE PRÉSTAMOS</h2>
    <table>
        <thead>
            <tr>
                <th>Solicitante</th><th>Cargo</th><th>Equipos</th>
                <th>Fecha</th><th>Inicio</th><th>Fin</th><th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prestamos as $p)
                <tr>
                    <td>{{ strtoupper(($p->docente->apellidos ?? '').' '.($p->docente->nombres ?? '')) }}</td>
                    <td>{{ $p->cargo }}</td>
                    <td>
                        @foreach ($p->prestamoEquipos as $pe)
                            {{ $pe->equipo->tipoEquipo->nombre ?? '' }}
                            {{ $pe->equipo->num_serie ?? '' }}<br>
                        @endforeach
                    </td>
                    <td>{{ optional($p->fecha)->format('d-m-Y') }}</td>
                    <td>{{ $p->hora_inicio ? substr($p->hora_inicio,0,5) : '' }}</td>
                    <td>{{ $p->hora_fin ? substr($p->hora_fin,0,5) : '' }}</td>
                    <td>{{ $p->estado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>