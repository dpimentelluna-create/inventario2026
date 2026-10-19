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
            background: #fff;
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
            background: #fff;
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
            background: #fff;
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
                background: #fff !important;
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
                background: #fff !important;
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
                background: #fff !important;
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
                background: #fff !important;
            }

            #equipo-ficha-print .icono-encabezado,
            #equipo-ficha-print .numero-equipo {
                color: #212529 !important;
                background: #fff !important;
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
</script>

@endsection