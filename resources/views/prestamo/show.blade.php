<title>Ver Préstamo</title>

@extends('layouts.app')

@section('template_title')
{{ __('Ver Préstamo') }}
@endsection

@section('content')
@php
$nombreSol = trim(($prestamo->docente->apellidos ?? '') . ' ' . ($prestamo->docente->nombres ?? ''));
$fechaVista = $prestamo->fecha
? \Carbon\Carbon::parse($prestamo->fecha)->format('d-m-Y')
: '—';
$hIni = $prestamo->hora_inicio
? \Carbon\Carbon::parse($prestamo->hora_inicio)->format('h:i A')
: '—';
$hFin = $prestamo->hora_fin
? \Carbon\Carbon::parse($prestamo->hora_fin)->format('h:i A')
: 'ACTIVO';

$equipos = $prestamo->prestamoEquipos;
$totalEquipos = $equipos->count();
$totalAccesorios = $equipos->sum(fn($pe) => $pe->prestamoAccesorios->count());
$malogrados = $equipos->filter(fn($pe) => strtoupper($pe->estado ?? '') === 'MALOGRADO')->count()
+ $equipos->sum(fn($pe) => $pe->prestamoAccesorios->filter(fn($a) => strtoupper($a->estado ?? '') === 'MALOGRADO')->count());

$borde = function ($estado) {
$estado = strtoupper($estado ?? '');
if ($estado === 'MALOGRADO')
return 'borde-malogrado';
if ($estado === 'REGULAR')
return 'borde-regular';
if ($estado === 'BUENO')
return 'borde-bueno';
return 'borde-neutro';
};
@endphp

<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span class="card-title fw-bold">DETALLE DEL PRÉSTAMO</span>
                    <div class="d-flex gap-2 no-print">
                        <a class="btn btn-primary btn-sm" href="{{ route('prestamos.index') }}">
                            <i class="fa fa-arrow-left"></i> Volver
                        </a>
                        <a class="btn btn-success btn-sm" href="{{ route('prestamos.edit', $prestamo->id) }}">
                            <i class="fa fa-edit"></i> Editar
                        </a>
                        {{--
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="window.print()">
                                        <i class="fa fa-print"></i> Imprimir
                                    </button>--}}
                        <button type="button" class="btn btn-danger btn-sm" id="btn_acta_pdf">
                            <i class="fa fa-file-pdf"></i> PDF
                        </button>
                        <button type="button" class="btn btn-success btn-sm" id="btn_acta_excel">
                            <i class="fa fa-file-excel"></i> Excel
                        </button>
                    </div>
                </div>

                <div class="card-body bg-white">
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <div class="bloque-dato">
                                <div class="etiqueta"><i class="bi bi-person"></i> SOLICITANTE</div>
                                <div class="valor">{{ $nombreSol ?: '—' }}</div>
                                <div class="subvalor">{{ $prestamo->cargo ?: 'SIN CARGO' }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bloque-dato">
                                <div class="etiqueta"><i class="bi bi-calendar"></i> FECHA</div>
                                <div class="valor">{{ $fechaVista }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bloque-dato">
                                <div class="etiqueta"><i class="bi bi-clock"></i> HORARIO</div>
                                <div class="valor">{{ $hIni }} → {{ $hFin }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bloque-dato text-md-end">
                                <div class="etiqueta">ESTADO</div>
                                @if ($prestamo->estado === 'ACTIVO')
                                <span class="badge bg-success fs-6">ACTIVO</span>
                                @else
                                <span class="badge bg-secondary fs-6">TERMINADO</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="chip">{{ $totalEquipos }} equipo{{ $totalEquipos === 1 ? '' : 's' }}</span>
                        <span class="chip">{{ $totalAccesorios }}
                            accesorio{{ $totalAccesorios === 1 ? '' : 's' }}</span>
                        @if ($malogrados > 0)
                        <span class="chip chip-alerta">{{ $malogrados }}
                            malogrado{{ $malogrados === 1 ? '' : 's' }}</span>
                        @endif
                    </div>

                    <h5 class="mb-3">EQUIPOS DEL PRÉSTAMO</h5>

                    @forelse ($equipos as $indice => $prestamoEquipo)
                    @php
                    $equipo = $prestamoEquipo->equipo;
                    $estadoEq = strtoupper($prestamoEquipo->estado ?? '');
                    @endphp
                    <div class="card mb-3 tarjeta-equipo {{ $borde($estadoEq) }}">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <div class="etiqueta">EQUIPO {{ $indice + 1 }}</div>
                                <strong>
                                    {{ $equipo->tipoEquipo->nombre ?? 'SIN TIPO' }}
                                    · {{ $equipo->marca ?? '' }}
                                    {{ $equipo->modelo ?? '' }}
                                </strong>
                                <span class="font-monospace ms-2">{{ $equipo->num_serie ?? 'S/N' }}</span>
                            </div>
                            <span
                                class="badge {{ $estadoEq === 'MALOGRADO' ? 'bg-danger' : ($estadoEq === 'REGULAR' ? 'bg-warning text-dark' : 'bg-success') }}">
                                {{ $estadoEq ?: '—' }}
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="etiqueta">OBSERVACIÓN</div>
                                <div class="{{ $prestamoEquipo->observacion ? 'fst-italic' : 'text-muted' }}">
                                    {{ $prestamoEquipo->observacion ?: 'Sin observaciones' }}
                                </div>
                            </div>

                            @if ($prestamoEquipo->prestamoAccesorios->count())
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Marca</th>
                                            <th>N.º serie</th>
                                            <th>Estado</th>
                                            <th>Observación</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($prestamoEquipo->prestamoAccesorios as $prestamoAccesorio)
                                        @php
                                        $acc = $prestamoAccesorio->accesorioEquipo;
                                        $estadoAcc = strtoupper($prestamoAccesorio->estado ?? '');
                                        @endphp
                                        <tr>
                                            <td>{{ $acc->tipo ?? '—' }}</td>
                                            <td>{{ $acc->marca ?? '—' }}</td>
                                            <td class="font-monospace">{{ $acc->num_serie ?? '—' }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $estadoAcc === 'MALOGRADO' ? 'bg-danger' : ($estadoAcc === 'REGULAR' ? 'bg-warning text-dark' : 'bg-success') }}">
                                                    {{ $estadoAcc ?: '—' }}
                                                </span>
                                            </td>
                                            <td class="{{ $prestamoAccesorio->observacion ? '' : 'text-muted' }}">
                                                {{ $prestamoAccesorio->observacion ?: 'Sin observaciones' }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-muted">Este equipo no tiene accesorios registrados en el préstamo.</div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="alert alert-warning">No hay equipos asociados a este préstamo.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>



    <div id="acta_descarga_overlay" class="acta-descarga-overlay" hidden>
        <div class="acta-descarga-panel">

            <!-- Spinner y mensajes -->
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="spinner-border text-primary flex-shrink-0" role="status">
                    <span class="visually-hidden">Procesando...</span>
                </div>

                <div class="flex-grow-1">
                    <strong id="acta_descarga_titulo">
                        PREPARANDO ARCHIVO
                    </strong>

                    <div id="acta_descarga_estado" class="text-muted small">
                        Esperando respuesta del servidor...
                    </div>
                </div>
            </div>

            <!-- Barra de progreso -->
            <div class="progress" style="height: 10px;">
                <div
                    id="acta_descarga_progreso"
                    class="progress-bar progress-bar-striped progress-bar-animated"
                    role="progressbar"
                    style="width: 0%"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    aria-valuenow="0">
                </div>
            </div>

            <!-- Porcentaje y tamaño -->
            <div class="d-flex justify-content-between mt-2 small text-muted">
                <span id="acta_descarga_porcentaje">Procesando...</span>
                <span id="acta_descarga_tamano"></span>
            </div>

            <!-- Botón cancelar, separado de los mensajes -->
            <div class="d-flex justify-content-end mt-3">
                <button
                    type="button"
                    id="btn_cancelar_descarga"
                    class="btn btn-outline-danger btn-sm">
                    <i class="fa fa-times"></i> CANCELAR
                </button>
            </div>

        </div>
    </div>


</section>

<style>
    .etiqueta {
        font-size: .75rem;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: #6c757d;
        font-weight: 600;
    }

    .valor {
        font-weight: 700;
        font-size: 1.05rem;
    }

    .subvalor {
        color: #6c757d;
    }

    .bloque-dato {
        background: #f8f9fa;
        border-radius: .5rem;
        padding: .75rem 1rem;
        height: 100%;
    }

    .chip {
        background: #e9ecef;
        border-radius: 999px;
        padding: .25rem .75rem;
        font-size: .85rem;
    }

    .chip-alerta {
        background: #f8d7da;
        color: #842029;
    }

    .tarjeta-equipo {
        border-left-width: 6px;
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

    @media print {

        #sidebar,
        .dot-spinner-container,
        .no-print,
        .btn,
        .dropdown,
        footer {
            display: none !important;
        }

        #content-wrapper,
        main {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        body {
            background: white !important;
        }

        .card {
            border: 1px solid #000 !important;
            box-shadow: none !important;
        }

        * {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }


    .acta-descarga-overlay {
        position: fixed;
        inset: 0;
        z-index: 20000;
        background: rgba(0, 0, 0, .45);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .acta-descarga-overlay[hidden] {
        display: none !important;
    }

    .acta-descarga-panel {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        width: 100%;
        max-width: 430px;
        box-shadow: 0 10px 35px rgba(0, 0, 0, .2);
    }

    .acta-descarga-panel strong {
        font-size: .95rem;
    }
</style>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnPdf = document.getElementById('btn_acta_pdf');
        const btnExcel = document.getElementById('btn_acta_excel');

        const overlay = document.getElementById('acta_descarga_overlay');
        const titulo = document.getElementById('acta_descarga_titulo');
        const estado = document.getElementById('acta_descarga_estado');
        const barra = document.getElementById('acta_descarga_progreso');
        const porcentaje = document.getElementById('acta_descarga_porcentaje');
        const tamano = document.getElementById('acta_descarga_tamano');
        const btnCancelar = document.getElementById('btn_cancelar_descarga');

        if (!btnPdf || !btnExcel || !overlay || !btnCancelar ||
            !titulo || !estado || !barra || !porcentaje || !tamano) {
            console.error('Faltan elementos HTML necesarios para descargar las actas.');
            return;
        }

        let descargando = false;
        let controladorDescarga = null;

        function notificar(tipo, mensaje) {
            if (typeof toastr !== 'undefined' &&
                typeof toastr[tipo] === 'function') {
                toastr[tipo](mensaje);
            } else {
                console.log(mensaje);
            }
        }

        function mostrarPanel(nombre) {
            overlay.hidden = false;
            titulo.textContent = 'PREPARANDO ARCHIVO ' + nombre;
            estado.textContent = 'Esperando respuesta del servidor...';

            barra.style.width = '0%';
            barra.classList.add('progress-bar-animated');
            barra.setAttribute('aria-valuenow', '0');

            porcentaje.textContent = 'Procesando...';
            tamano.textContent = '';
        }

        function actualizarProgreso(recibido, total) {
            const mbRecibidos = (recibido / 1048576).toFixed(2);

            if (total > 0) {
                const mbTotal = (total / 1048576).toFixed(2);
                const avance = Math.min(
                    100,
                    Math.round((recibido / total) * 100)
                );

                barra.style.width = avance + '%';
                barra.setAttribute('aria-valuenow', avance);
                porcentaje.textContent = avance + '%';
                tamano.textContent = mbRecibidos + ' / ' + mbTotal + ' MB';
            } else {
                // No inventar un porcentaje si se desconoce el tamaño total.
                barra.style.width = '100%';
                barra.setAttribute('aria-valuenow', '0');
                porcentaje.textContent = 'Recibiendo...';
                tamano.textContent = mbRecibidos + ' MB';
            }

            estado.textContent = 'Recibiendo archivo del servidor...';
        }

        function obtenerNombreArchivo(respuesta, extension) {
            const disposicion =
                respuesta.headers.get('Content-Disposition') || '';

            const utf8 = disposicion.match(
                /filename\*=UTF-8''([^;]+)/i
            );

            if (utf8) {
                try {
                    return decodeURIComponent(utf8[1].trim().replace(/["']/g, ''));
                } catch (error) {
                    console.warn('No se pudo interpretar el nombre UTF-8.');
                }
            }

            const normal = disposicion.match(/filename="?([^";]+)"?/i);

            if (normal) {
                return normal[1].trim();
            }

            return 'Acta_Prestamo_{{ $prestamo->id }}.' + extension;
        }

        async function descargarActa(url, nombre, extension, mimeEsperado) {
            if (descargando) return;

            descargando = true;
            btnPdf.disabled = true;
            btnExcel.disabled = true;
            btnCancelar.disabled = false;

            controladorDescarga = new AbortController();

            const controlador = controladorDescarga;
            let objectUrl = null;

            mostrarPanel(nombre);
            notificar('info', 'PREPARANDO ARCHIVO ' + nombre + '...');

            try {
                const respuesta = await fetch(url, {
                    method: 'GET',
                    credentials: 'same-origin',
                    signal: controlador.signal,
                    headers: {
                        'Accept': mimeEsperado
                    }
                });

                if (!respuesta.ok) {
                    throw new Error(
                        'El servidor respondió con el estado HTTP ' +
                        respuesta.status + '.'
                    );
                }

                const tipoRespuesta = (
                    respuesta.headers.get('Content-Type') || ''
                ).toLowerCase();

                if (
                    tipoRespuesta.includes('text/html') ||
                    tipoRespuesta.includes('application/json')
                ) {
                    throw new Error(
                        'El servidor devolvió una página o un mensaje de error ' +
                        'en lugar del archivo. Comprueba la sesión y los registros.'
                    );
                }

                const longitud = Number(
                    respuesta.headers.get('Content-Length')
                );

                const total = Number.isFinite(longitud) && longitud > 0 ?
                    longitud :
                    0;

                let blob;

                if (respuesta.body && respuesta.body.getReader) {
                    const lector = respuesta.body.getReader();
                    const fragmentos = [];
                    let recibido = 0;

                    try {
                        while (true) {
                            const resultado = await lector.read();

                            if (resultado.done) break;

                            fragmentos.push(resultado.value);
                            recibido += resultado.value.byteLength;

                            actualizarProgreso(recibido, total);
                        }
                    } catch (error) {
                        try {
                            await lector.cancel();
                        } catch (cancelError) {
                            // La lectura puede estar cancelada por el navegador.
                        }

                        throw error;
                    }

                    blob = new Blob(fragmentos, {
                        type: tipoRespuesta || mimeEsperado
                    });
                } else {
                    blob = await respuesta.blob();
                    actualizarProgreso(blob.size, total || blob.size);
                }

                // Evitar iniciar una descarga si se canceló la operación.
                if (controlador.signal.aborted) {
                    throw new DOMException(
                        'La descarga fue cancelada.',
                        'AbortError'
                    );
                }

                if (blob.size === 0) {
                    throw new Error('El archivo recibido está vacío.');
                }

                const nombreArchivo = obtenerNombreArchivo(
                    respuesta,
                    extension
                );

                estado.textContent = 'Archivo recibido. Iniciando descarga...';
                porcentaje.textContent = '100%';
                barra.style.width = '100%';
                barra.setAttribute('aria-valuenow', '100');
                barra.classList.remove('progress-bar-animated');
                tamano.textContent = (blob.size / 1048576).toFixed(2) + ' MB';

                objectUrl = URL.createObjectURL(blob);

                const enlace = document.createElement('a');
                enlace.href = objectUrl;
                enlace.download = nombreArchivo;
                enlace.style.display = 'none';

                document.body.appendChild(enlace);
                enlace.click();
                enlace.remove();

                overlay.hidden = true;

                notificar(
                    'success',
                    'ARCHIVO RECIBIDO. SE INICIÓ LA DESCARGA. ' +
                    'SI EL NAVEGADOR LO SOLICITA, ELIGE DÓNDE GUARDARLO.'
                );

            } catch (error) {
                console.error('Error al descargar el acta:', error);

                overlay.hidden = true;

                if (error.name === 'AbortError') {
                    notificar('info', 'DESCARGA CANCELADA POR EL USUARIO.');
                } else {
                    notificar(
                        'error',
                        'NO SE PUDO DESCARGAR EL ARCHIVO. ' +
                        (error.message || 'Ocurrió un error inesperado.')
                    );
                }

            } finally {
                if (objectUrl) {
                    setTimeout(function() {
                        URL.revokeObjectURL(objectUrl);
                    }, 60000);
                }

                if (controladorDescarga === controlador) {
                    controladorDescarga = null;
                }

                btnCancelar.disabled = false;
                btnPdf.disabled = false;
                btnExcel.disabled = false;
                descargando = false;
            }
        }

        btnPdf.addEventListener('click', function() {
            descargarActa(
                @json(route('prestamos.acta.pdf', $prestamo - > id)),
                'PDF',
                'pdf',
                'application/pdf'
            );
        });

        btnExcel.addEventListener('click', function() {
            descargarActa(
                @json(route('prestamos.acta.excel', $prestamo - > id)),
                'EXCEL',
                'xlsx',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            );
        });

        btnCancelar.addEventListener('click', function() {
            if (!controladorDescarga || !descargando) return;

            btnCancelar.disabled = true;
            estado.textContent = 'Cancelando operación...';

            controladorDescarga.abort();
        });
    });
</script>
@endsection