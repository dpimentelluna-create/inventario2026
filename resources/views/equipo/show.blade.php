@section('template_title')
    Equipo {{ $equipo->id }} - {{ strtoupper($equipo->tipoEquipo->nombre ?? 'EQUIPO') }} - {{ $equipo->num_serie ?: ($equipo->codigo_inventario ?? 'SIN-SERIE') }}
@endsection

@extends('layouts.app')

@section('content')
    @php
    $tipo = strtoupper($equipo->tipoEquipo->nombre ?? '');
    $esLaptop = $tipo === 'LAPTOP';

    $specLap = $equipo->especificacionesLaptops;
    $specEq = $equipo->especificacionesEquipo;

    $estado = strtoupper(
        $esLaptop
        ? ($specLap->estado ?? '')
        : ($specEq->estado ?? '')
    );

    $borde = match ($estado) {
        'MALOGRADO' => 'borde-malogrado',
        'REGULAR' => 'borde-regular',
        'BUENO' => 'borde-bueno',
        default => 'borde-neutro',
    };

    $badge = match ($estado) {
        'MALOGRADO' => 'bg-danger',
        'REGULAR' => 'bg-warning text-dark',
        'BUENO' => 'bg-success',
        default => 'bg-secondary',
    };

    $fechaVista = $equipo->fecha_registro
        ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('d-m-Y')
        : '—';

    $accesorios = $equipo->accesoriosEquipos;

    $malogrados = $accesorios->filter(
        fn($a) => strtoupper($a->estado ?? '') === 'MALOGRADO'
    )->count();

    if ($estado === 'MALOGRADO') {
        $malogrados++;
    }

    $marcaModelo = trim(
        ($equipo->marca ?? '') . ' ' . ($equipo->modelo ?? '')
    );
    @endphp

    <section class="content container-fluid equipo-show">

        <div class="row">
            <div class="col-12">

                {{-- FICHA PRINCIPAL: ESTA ES LA ZONA QUE SE IMPRIME --}}
                <div id="equipo-ficha-print"
                     class="card tarjeta-principal {{ $borde }}">

                    {{-- ENCABEZADO --}}
                    <div class="card-header encabezado-show">

                        <div class="encabezado-contenido">
                            <div class="icono-encabezado">
                                <i class="bi bi-pc-display"></i>
                            </div>

                            <div>
                                <h4 class="titulo-show">FICHA DEL EQUIPO</h4>
                                <p class="subtitulo-show">
                                    Información técnica, estado y accesorios registrados.
                                </p>
                            </div>
                        </div>

                        <div class="no-print">
                            <button type="button" class="btn btn-primary boton-imprimir" id="btn_imprimir_equipo">
                                <i class="fa fa-print me-1"></i>
                                IMPRIMIR FICHA
                            </button>
                        </div>

                    </div>

                    <div class="card-body cuerpo-show">

                        {{-- INFORMACIÓN PRINCIPAL --}}
                        <div class="row g-3 mb-4">

                            <div class="col-12 col-sm-6 col-xl-3">
                                <div class="bloque-dato">
                                    <div class="etiqueta">
                                        <i class="bi bi-pc-display me-1"></i>
                                        EQUIPO
                                    </div>

                                    <div class="valor">
                                        {{ $tipo ?: 'SIN TIPO' }}
                                    </div>

                                    <div class="subvalor">
                                        {{ $marcaModelo ?: 'SIN MARCA O MODELO' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-xl-3">
                                <div class="bloque-dato">
                                    <div class="etiqueta">
                                        <i class="bi bi-upc-scan me-1"></i>
                                        N.º DE SERIE
                                    </div>

                                    <div class="valor font-monospace">
                                        {{ $equipo->num_serie ?: '—' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-xl-3">
                                <div class="bloque-dato">
                                    <div class="etiqueta">
                                        <i class="bi bi-geo-alt me-1"></i>
                                        UBICACIÓN
                                    </div>

                                    <div class="valor">
                                        {{ $equipo->ubicacione->nombre ?? '—' }}
                                    </div>

                                    <div class="subvalor">
                                        Registro: {{ $fechaVista }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-xl-3">
                                <div class="bloque-dato">
                                    <div class="etiqueta">
                                        <i class="bi bi-activity me-1"></i>
                                        ESTADO
                                    </div>

                                    <div class="valor">
                                        <span class="badge {{ $badge }} fs-6">
                                            {{ $estado ?: 'SIN ESTADO' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- RESUMEN --}}
                        <div class="seccion-resumen mb-4">

                            <div class="titulo-seccion">
                                <div>
                                    <h5>RESUMEN DEL EQUIPO</h5>
                                    <p>Clasificación y estado de los recursos asociados.</p>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <span class="chip">
                                    <i class="bi bi-pc-display me-1"></i>
                                    {{ $esLaptop ? 'LAPTOP' : 'EQUIPO' }}
                                </span>

                                <span class="chip">
                                    <i class="bi bi-usb-plug me-1"></i>
                                    {{ $accesorios->count() }}
                                    accesorio{{ $accesorios->count() === 1 ? '' : 's' }}
                                </span>

                                @if ($malogrados > 0)
                                    <span class="chip chip-alerta">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        {{ $malogrados }}
                                        malogrado{{ $malogrados === 1 ? '' : 's' }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- ESPECIFICACIONES --}}
                        <div class="seccion-contenido mb-4">

                            <div class="titulo-seccion">
                                <div>
                                    <h5>
                                        <i class="bi bi-cpu me-1"></i>
                                        ESPECIFICACIONES
                                    </h5>
                                    <p>Características técnicas y observaciones del equipo.</p>
                                </div>
                            </div>

                            <div class="bloque-especificaciones">

                                @if ($esLaptop && $specLap)

                                    <div class="row g-4">

                                        <div class="col-12 col-md-6">
                                            <div class="etiqueta">PROCESADOR</div>
                                            <div class="valor">
                                                {{ $specLap->procesador ?: '—' }}
                                            </div>
                                        </div>

                                        <div class="col-6 col-md-3">
                                            <div class="etiqueta">MEMORIA RAM</div>
                                            <div class="valor">
                                                {{ $specLap->ram ?: '—' }}
                                            </div>
                                        </div>

                                        <div class="col-6 col-md-3">
                                            <div class="etiqueta">DISCO</div>
                                            <div class="valor">
                                                {{ $specLap->disco_duro ?: '—' }}
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
    <div class="etiqueta">SISTEMA OPERATIVO</div>
    <div class="valor">
        {{ $specLap->sistema_operativo ?: '—' }}
    </div>
</div>

                                        <div class="col-12 col-md-4">
                                            <div class="etiqueta">COLOR</div>
                                            <div class="valor">
                                                {{ $specLap->color ?: '—' }}
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-8">
                                            <div class="etiqueta">OBSERVACIONES</div>
                                            <div class="{{ $specLap->observaciones ? 'texto-observacion' : 'text-muted' }}">
                                                {{ $specLap->observaciones ?: 'Sin observaciones registradas.' }}
                                            </div>
                                        </div>

                                    </div>

                                @elseif ($specEq)

                                    <div class="row g-4">

                                        <div class="col-12 col-md-8">
                                            <div class="etiqueta">DESCRIPCIÓN</div>
                                            <div class="valor">
                                                {{ $specEq->descripcion ?: '—' }}
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <div class="etiqueta">COLOR</div>
                                            <div class="valor">
                                                {{ $specEq->color ?: '—' }}
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="etiqueta">OBSERVACIONES</div>
                                            <div class="{{ $specEq->observaciones ? 'texto-observacion' : 'text-muted' }}">
                                                {{ $specEq->observaciones ?: 'Sin observaciones registradas.' }}
                                            </div>
                                        </div>

                                    </div>

                                @else

                                    <div class="estado-vacio">
                                        <i class="bi bi-info-circle"></i>
                                        <h6>Sin especificaciones registradas</h6>
                                        <p>Este equipo todavía no tiene características técnicas registradas.</p>
                                    </div>

                                @endif

                            </div>
                        </div>

                        {{-- ACCESORIOS --}}
                        <div class="seccion-contenido">

                            <div class="titulo-seccion">
                                <div>
                                    <h5>
                                        <i class="bi bi-usb-plug me-1"></i>
                                        ACCESORIOS DEL EQUIPO
                                    </h5>
                                    <p>Detalle de los accesorios vinculados a este recurso.</p>
                                </div>

                                <span class="contador-equipos">
                                    {{ $accesorios->count() }}
                                    {{ $accesorios->count() === 1 ? 'ACCESORIO' : 'ACCESORIOS' }}
                                </span>
                            </div>

                            @if ($accesorios->count())

                                <div class="table-responsive tabla-accesorios">
                                    <table class="table table-hover table-sm align-middle mb-0">

                                        <thead>
                                            <tr>
                                                <th>TIPO</th>
                                                <th>MARCA</th>
                                                <th>N.º DE SERIE</th>
                                                <th>ESTADO</th>
                                                <th>OBSERVACIÓN</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($accesorios as $acc)

                                                @php
            $estA = strtoupper($acc->estado ?? 'REGULAR');

            $badgeAcc = match ($estA) {
                'MALOGRADO' => 'bg-danger',
                'REGULAR' => 'bg-warning text-dark',
                'BUENO', 'OPERATIVO' => 'bg-success',
                default => 'bg-secondary',
            };
                                                @endphp

                                                <tr>
                                                    <td>{{ $acc->tipo ?? '—' }}</td>

                                                    <td>{{ $acc->marca ?? '—' }}</td>

                                                    <td class="font-monospace">
                                                        {{ $acc->num_serie ?? '—' }}
                                                    </td>

                                                    <td>
                                                        <span class="badge {{ $badgeAcc }}">
                                                            {{ $estA }}
                                                        </span>
                                                    </td>

                                                    <td class="{{ $acc->observaciones ? '' : 'text-muted' }}">
                                                        {{ $acc->observaciones ?: 'Sin observaciones' }}
                                                    </td>
                                                </tr>

                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>

                            @else

                                <div class="sin-accesorios">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Este equipo no tiene accesorios registrados.
                                </div>

                            @endif

                        </div>

                        {{-- ACCIONES INFERIORES --}}
                        <div class="acciones-inferiores no-print">

                            <div class="texto-acciones">
                                <strong>¿Necesitas realizar otra acción?</strong>
                                <span>Regresa al inventario o modifica los datos de este equipo.</span>
                            </div>

                            <div class="botones-inferiores">

                                <a
                                    href="{{ route('equipos.index') }}"
                                    class="btn btn-outline-secondary">
                                    <i class="fa fa-arrow-left me-1"></i>
                                    VOLVER
                                </a>

                                <a
                                    href="{{ route('equipos.edit', $equipo->id) }}"
                                    class="btn btn-success">
                                    <i class="fa fa-edit me-1"></i>
                                    EDITAR EQUIPO
                                </a>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </section>

    <style>
        /* CONTENEDOR */
        .equipo-show {
            padding-bottom: 1.5rem;
        }

        .tarjeta-principal {
            border: 1px solid #e3e7eb;
            border-left-width: 5px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .04);
        }

        .borde-bueno {
            border-left-color: #198754;
        }

        .borde-regular {
            border-left-color: #ffc107;
        }

        .borde-malogrado {
            border-left-color: #dc3545;
        }

        .borde-neutro {
            border-left-color: #adb5bd;
        }

        /* ENCABEZADO */
        .encabezado-show {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            padding: 1.25rem 1.5rem;
            background: #d1fae5;
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
            background: #eaf2ff;
            color: #0d6efd;
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

        /* CUERPO */
        .cuerpo-show {
            padding: 1.5rem;
            background: #d1fae5;
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
            font-size: 1.02rem;
            font-weight: 700;
            color: #343a40;
            overflow-wrap: anywhere;
        }

        .subvalor {
            margin-top: .2rem;
            font-size: .85rem;
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

        /* RESUMEN Y SECCIONES */
        .seccion-resumen {
            padding: 1.1rem 1.2rem;
            background: #fafbfc;
            border: 1px solid #e9ecef;
            border-radius: 10px;
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

        .chip {
            display: inline-flex;
            align-items: center;
            padding: .45rem .75rem;
            background: #e9ecef;
            color: #343a40;
            border-radius: 7px;
            font-size: .85rem;
            font-weight: 600;
        }

        .chip-alerta {
            background: #f8d7da;
            color: #842029;
        }

        .bloque-especificaciones {
            padding: 1.2rem;
            background: #d1fae5;
            border: 1px solid #e3e7eb;
            border-radius: 9px;
        }

        .texto-observacion {
            color: #495057;
            overflow-wrap: anywhere;
            white-space: pre-line;
        }

        /* TABLA DE ACCESORIOS */
        .contador-equipos {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: .35rem .6rem;
            background: #eef2f6;
            color: #495057;
            border-radius: 6px;
            font-size: .75rem;
            font-weight: 700;
        }

        .tabla-accesorios {
            border: 1px solid #e3e7eb;
            border-radius: 7px;
        }

        .tabla-accesorios .table {
            min-width: 600px;
        }

        .tabla-accesorios thead th {
            padding: .75rem;
            background: #f5f7f9;
            color: #495057;
            font-size: .74rem;
            letter-spacing: .025em;
            white-space: nowrap;
            border-bottom: 1px solid #dee2e6;
        }

        .tabla-accesorios tbody td {
            padding: .7rem .75rem;
            font-size: .85rem;
            overflow-wrap: anywhere;
        }

        .sin-accesorios {
            padding: .8rem 1rem;
            background: #f8f9fa;
            border-radius: 7px;
            color: #6c757d;
            font-size: .875rem;
        }

        .estado-vacio {
            padding: 1.5rem 1rem;
            text-align: center;
            background: #fafbfc;
            border: 1px dashed #ced4da;
            border-radius: 8px;
        }

        .estado-vacio > i {
            display: block;
            margin-bottom: .5rem;
            color: #adb5bd;
            font-size: 1.6rem;
        }

        .estado-vacio h6 {
            font-weight: 700;
        }

        .estado-vacio p {
            margin: 0;
            color: #6c757d;
            font-size: .85rem;
        }

        /* ACCIONES INFERIORES */
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

        .texto-acciones strong {
            color: #343a40;
            font-size: .9rem;
        }

        .texto-acciones span {
            color: #6c757d;
            font-size: .82rem;
        }

        .botones-inferiores {
            display: flex;
            flex-wrap: wrap;
            gap: .6rem;
        }

        .botones-inferiores .btn {
            padding: .6rem .9rem;
            font-size: .85rem;
            font-weight: 650;
        }

        /* IMPRESIÓN: IMPRIMIR SOLO LA FICHA */
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
                background: #d1fae5 !important;
            }

            body * {
                visibility: hidden !important;
            }

            #equipo-ficha-print,
            #equipo-ficha-print * {
                visibility: visible !important;
            }

            #equipo-ficha-print {
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                margin: 0 !important;
                border: 1px solid #adb5bd !important;
                border-left-width: 4px !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                overflow: visible !important;
            }

            #equipo-ficha-print .no-print,
            #equipo-ficha-print .acciones-inferiores {
                display: none !important;
            }

            #equipo-ficha-print .card-header,
            #equipo-ficha-print .card-body {
                background: #d1fae5 !important;
            }

            #equipo-ficha-print .card-header {
                padding: 12px 14px !important;
            }

            #equipo-ficha-print .card-body {
                padding: 14px !important;
            }

            #equipo-ficha-print .bloque-dato,
            #equipo-ficha-print .seccion-resumen,
            #equipo-ficha-print .bloque-especificaciones,
            #equipo-ficha-print .sin-accesorios {
                background: #d1fae5 !important;
                box-shadow: none !important;
                break-inside: avoid;
            }

            #equipo-ficha-print .titulo-seccion,
            #equipo-ficha-print .bloque-dato,
            #equipo-ficha-print .bloque-especificaciones,
            #equipo-ficha-print .bloque-especificaciones .row > div {
                break-inside: avoid;
            }

            #equipo-ficha-print .tabla-accesorios {
                overflow: visible !important;
            }

            #equipo-ficha-print .tabla-accesorios .table {
                min-width: 0 !important;
                width: 100% !important;
                table-layout: auto;
            }

            #equipo-ficha-print .tabla-accesorios th,
            #equipo-ficha-print .tabla-accesorios td {
                padding: 5px !important;
                font-size: 9pt !important;
                white-space: normal !important;
                overflow-wrap: anywhere;
            }

            #equipo-ficha-print .badge,
            #equipo-ficha-print .chip {
                border: 1px solid #adb5bd !important;
                color: #212529 !important;
                background: #d1fae5 !important;
            }

            #equipo-ficha-print .icono-encabezado,
            #equipo-ficha-print .numero-equipo {
                color: #212529 !important;
                background: #d1fae5 !important;
                border: 1px solid #adb5bd !important;
            }

            #equipo-ficha-print .seccion-resumen,
            #equipo-ficha-print .bloque-especificaciones {
                margin-bottom: 12px !important;
            }

            #equipo-ficha-print .tarjeta-principal,
            #equipo-ficha-print .card {
                box-shadow: none !important;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

        /* MÓVILES */
        @media (max-width: 576px) {
            .encabezado-show,
            .cuerpo-show {
                padding: 1rem;
            }

            .encabezado-contenido {
                align-items: flex-start;
            }

            .icono-encabezado {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }

            .subtitulo-show {
                font-size: .8rem;
            }

            .encabezado-show > .no-print,
            .boton-imprimir {
                width: 100%;
            }

            .acciones-inferiores {
                align-items: stretch;
            }

            .botones-inferiores {
                width: 100%;
            }

            .botones-inferiores .btn {
                flex: 1;
            }
        }
    </style>

    
<script>
document.addEventListener('DOMContentLoaded', function () {
    const boton = document.getElementById('btn_imprimir_equipo');

    if (!boton) {
        return;
    }

    boton.addEventListener('click', async function () {
        if (boton.disabled) {
            return;
        }

        const textoOriginal = boton.innerHTML;

        boton.disabled = true;
        boton.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> REGISTRANDO...';

        try {
            const respuesta = await fetch(
                @json(route('equipos.auditar-impresion', $equipo->id)),
                {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': @json(csrf_token()),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                }
            );

            if (!respuesta.ok) {
                throw new Error('No se pudo registrar la impresión.');
            }

            // Abrir el diálogo de impresión después de registrar la acción.
            window.print();

        } catch (error) {
            console.error('Error al registrar la impresión:', error);

            alert(
                'No se pudo registrar la solicitud de impresión. ' +
                'Verifica tu conexión e inténtalo nuevamente.'
            );
        } finally {
            boton.disabled = false;
            boton.innerHTML = textoOriginal;
        }
    });
});
</script>@endsection
<style id="fix-all-tables-dark">
  html.home-dark table.dataTable thead th,
  html.home-dark table thead th,
  body.dark-mode table.dataTable thead th,
  body.dark table.dataTable thead th,
  [data-bs-theme="dark"] table.dataTable thead th,
  [data-theme="dark"] table.dataTable thead th {
    background-color: #1e293b !important;
    color: #f8fafc !important;
    border-color: #334155 !important;
  }

  html.home-dark .dataTables_wrapper .dataTables_length select,
  html.home-dark .dataTables_wrapper .dataTables_filter input,
  body.dark-mode .dataTables_wrapper .dataTables_length select,
  body.dark-mode .dataTables_wrapper .dataTables_filter input,
  [data-bs-theme="dark"] .dataTables_wrapper .dataTables_length select,
  [data-bs-theme="dark"] .dataTables_wrapper .dataTables_filter input {
    background-color: #0f172a !important;
    color: #f8fafc !important;
    border: 1px solid #334155 !important;
  }
</style>
<!-- FIX_EQUIPOS_SHOW_DARK_START -->
<style id="equipos-show-dark-style">
  /* SOLO MODO OSCURO en /equipos/{id} */
  html.dark .card,
  html.dark .card-body,
  html.dark .card-header,
  html.dark .bg-success-subtle,
  html.dark .bg-light,
  html.dark [class*="bg-success-subtle"],
  html.dark [class*="bg-light"],
  html[data-bs-theme="dark"] .card,
  html[data-bs-theme="dark"] .card-body,
  html[data-bs-theme="dark"] .card-header,
  html[data-bs-theme="dark"] .bg-success-subtle,
  html[data-bs-theme="dark"] .bg-light,
  html[data-bs-theme="dark"] [class*="bg-success-subtle"],
  html[data-bs-theme="dark"] [class*="bg-light"],
  body.dark .card,
  body.dark .card-body,
  body.dark .card-header,
  body.dark .bg-success-subtle,
  body.dark .bg-light,
  body.dark [class*="bg-success-subtle"],
  body.dark [class*="bg-light"],
  body.dark-mode .card,
  body.dark-mode .card-body,
  body.dark-mode .card-header,
  body.dark-mode .bg-success-subtle,
  body.dark-mode .bg-light,
  body.dark-mode [class*="bg-success-subtle"],
  body.dark-mode [class*="bg-light"],
  body.tema-oscuro-activo .card,
  body.tema-oscuro-activo .card-body,
  body.tema-oscuro-activo .card-header,
  body.tema-oscuro-activo .bg-success-subtle,
  body.tema-oscuro-activo .bg-light,
  body.tema-oscuro-activo [class*="bg-success-subtle"],
  body.tema-oscuro-activo [class*="bg-light"] {
    background-color: #111827 !important;
    border-color: #1f2937 !important;
    color: #f8fafc !important;
  }

  html.dark .text-muted,
  html.dark small,
  html[data-bs-theme="dark"] .text-muted,
  html[data-bs-theme="dark"] small,
  body.dark .text-muted,
  body.dark small,
  body.dark-mode .text-muted,
  body.dark-mode small,
  body.tema-oscuro-activo .text-muted,
  body.tema-oscuro-activo small {
    color: #cbd5e1 !important;
    -webkit-text-fill-color: #cbd5e1 !important;
    opacity: 1 !important;
  }
</style>
<script id="equipos-show-dark-script">
(function () {
  function esOscuroEqShow() {
    var h = document.documentElement;
    var b = document.body;
    if (!b) return false;
    var txt = b.innerText || "";
    if (
      h.classList.contains("dark") ||
      h.getAttribute("data-bs-theme") === "dark" ||
      b.classList.contains("dark") ||
      b.classList.contains("dark-mode") ||
      b.classList.contains("tema-oscuro-activo") ||
      b.getAttribute("data-bs-theme") === "dark"
    ) {
      return true;
    }
    return txt.indexOf("Modo Claro") !== -1;
  }

  function fijarEqShowDark() {
    var oscuro = esOscuroEqShow();
    var body = document.body;
    if (!body) return;

    body.querySelectorAll("div, section, article, button, a, span, p, small, label, h1, h2, h3, h4, h5, h6, strong, b, i, svg").forEach(function (el) {
      if (el.closest("table, nav, aside, .sidebar")) return;
      if (el === body || el.tagName === "HTML") return;
      if (el.closest(".badge.bg-success, .badge.bg-warning")) return;

      var cs = window.getComputedStyle(el);
      var bg = cs.backgroundColor || "";
      var m = bg.match(/\d+/g);
      var esFondoClaro = false;
      if (m && m.length >= 3) {
        var r = parseInt(m[0], 10), g = parseInt(m[1], 10), bl = parseInt(m[2], 10);
        var a = m.length >= 4 ? parseFloat(m[3]) : 1;
        var lum = (r + g + bl) / 3;
        if (a > 0.1 && lum > 150) {
          esFondoClaro = true;
        }
      }

      if (oscuro && esFondoClaro) {
        el.dataset.eqShowBg = "1";
        var isPill = el.tagName === "BUTTON" || el.classList.contains("btn") || el.classList.contains("badge") || el.closest("button, .btn");
        el.style.setProperty("background-color", isPill ? "#1e293b" : "#111827", "important");
        el.style.setProperty("border-color", "#334155", "important");
        el.style.setProperty("color", "#f8fafc", "important");
        el.style.setProperty("-webkit-text-fill-color", "#f8fafc", "important");
      } else if (!oscuro && el.dataset.eqShowBg === "1") {
        delete el.dataset.eqShowBg;
        el.style.removeProperty("background-color");
        el.style.removeProperty("border-color");
        el.style.removeProperty("color");
        el.style.removeProperty("-webkit-text-fill-color");
      }

      if (el.querySelector("div, p, h1, h2, h3, h4, h5, h6, table")) return;
      var t = (el.textContent || "").trim();
      if (!t && el.tagName !== "I" && el.tagName !== "SVG") return;

      if (oscuro) {
        el.dataset.eqShowFg = "1";
        var esSubtitulo =
          t.indexOf("Clasificación y estado") !== -1 ||
          t.indexOf("Clasificacion y estado") !== -1 ||
          t.indexOf("Características técnicas") !== -1 ||
          t.indexOf("Caracteristicas tecnicas") !== -1 ||
          el.classList.contains("text-muted");
        var fg = esSubtitulo ? "#cbd5e1" : "#f8fafc";
        el.style.setProperty("color", fg, "important");
        el.style.setProperty("-webkit-text-fill-color", fg, "important");
        el.style.setProperty("fill", fg, "important");
        el.style.setProperty("opacity", "1", "important");
        el.style.setProperty("visibility", "visible", "important");
      } else if (el.dataset.eqShowFg === "1") {
        delete el.dataset.eqShowFg;
        el.style.removeProperty("color");
        el.style.removeProperty("-webkit-text-fill-color");
        el.style.removeProperty("fill");
        el.style.removeProperty("opacity");
        el.style.removeProperty("visibility");
      }
    });
  }

  fijarEqShowDark();
  document.addEventListener("DOMContentLoaded", function () {
    fijarEqShowDark();
    setTimeout(fijarEqShowDark, 150);
    setTimeout(fijarEqShowDark, 500);
    setTimeout(fijarEqShowDark, 1000);
  });
  window.addEventListener("load", function () {
    fijarEqShowDark();
    setTimeout(fijarEqShowDark, 300);
  });
  document.addEventListener("click", function () {
    setTimeout(fijarEqShowDark, 60);
    setTimeout(fijarEqShowDark, 250);
  });
})();
</script>
<!-- FIX_EQUIPOS_SHOW_DARK_END -->
