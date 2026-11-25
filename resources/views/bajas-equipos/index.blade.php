@extends('layouts.app')

@section('template_title')
    Bajas administrativas
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="baja-index-card">
                <div class="baja-index-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h5 class="mb-1 fw-bold">
                                <i class="bi bi-archive me-2 text-success"></i>
                                BAJAS ADMINISTRATIVAS
                            </h5>
                            <small class="text-muted">
                                Historial de equipos retirados del inventario institucional.
                            </small>
                        </div>

                        <div class="d-flex align-items-center flex-wrap gap-2">

                        {{-- MENÚ DE EXPORTACIÓN --}}
                        <div class="btn-group">
                            <button type="button"
                                    class="btn btn-outline-success dropdown-toggle"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <i class="bi bi-download me-1"></i>
                                EXPORTAR
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">

                                <li>
                                    <button type="button"
                                            class="dropdown-item"
                                            id="btn_exportar_excel">
                                        <i class="bi bi-file-earmark-excel text-success me-2"></i>
                                        EXCEL
                                    </button>
                                </li>

                                <li>
                                    <button type="button"
                                            class="dropdown-item"
                                            id="btn_exportar_pdf">
                                        <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                        PDF
                                    </button>
                                </li>

                            </ul>
                        </div>

                        {{-- REGISTRAR BAJA --}}
                        <a href="{{ route('bajas-equipos.create') }}"
                        class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i>
                            REGISTRAR BAJA
                        </a>

                    </div>
                    </div>
                </div>

                <div class="baja-index-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show"
                             role="alert">
                            {{ session('success') }}
                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="Cerrar"></button>
                        </div>
                    @endif

                    @if ($bajas->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-inbox display-4 text-muted"></i>
                            <h6 class="mt-3 fw-bold">NO HAY BAJAS REGISTRADAS</h6>
                            <p class="text-muted mb-0">
                                Cuando registres una baja administrativa, aparecerá aquí.
                            </p>
                        </div>
                    @else

                    {{-- BARRA FILTROS --}}
                    <div class="barra-filtros-equipos mb-3">
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            <button type="button"
                                    id="btn_toggle_filtros"
                                    class="btn btn-filtros-equipos btn-sm"
                                    aria-controls="panel_filtros"
                                    aria-expanded="false">
                                <i class="fa-solid fa-sliders me-2 icono-boton-filtros"></i>
                                <span>FILTROS</span>
                                <span id="badge_filtros"
                                    class="badge badge-filtros-contador d-none">0</span>
                                <i class="fa-solid fa-chevron-down ms-3 flecha-filtros"></i>
                            </button>

                            <div id="mensaje_coincidencias"
                                class="mensaje-coincidencias"
                                style="display:none;"
                                aria-live="polite"></div>
                        </div>
                    </div>

                        {{-- PANEL FILTROS --}}
                        <div id="panel_filtros" class="panel-filtros-equipos mb-3" style="display:none;">

                            <div class="panel-filtros-header">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="icono-filtros">
                                        <i class="fa-solid fa-sliders"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">FILTROS DE BÚSQUEDA</h6>
                                        <small>Utiliza los campos para localizar las bajas administrativas registradas.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-filtros-body">
                                <div class="row g-3">

                                    {{-- ID DE BAJA --}}
                                    <div class="col-12 col-md-6 col-xl-3">
                                        <label for="filtro_id_baja" class="form-label">
                                            <i class="fa-solid fa-hashtag me-1"></i> ID DE BAJA
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <input type="number"
                                                id="filtro_id_baja"
                                                class="form-control"
                                                min="1"
                                                placeholder="ESCRIBA EL ID">
                                            <button type="button"
                                                    class="btn btn-limpiar-filtro btn-limpiar-campo"
                                                    data-target="filtro_id_baja"
                                                    title="Limpiar ID">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- FECHA --}}
                                    <div class="col-12 col-md-6 col-xl-3">
                                        <label for="filtro_fecha" class="form-label">
                                            <i class="fa-solid fa-calendar-days me-1"></i> FECHA
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <input type="date"
                                                id="filtro_fecha"
                                                class="form-control">
                                            <button type="button"
                                                    id="btn_filtro_hoy"
                                                    class="btn btn-hoy-filtro"
                                                    title="Filtrar por hoy">
                                                HOY
                                            </button>
                                            <button type="button"
                                                    class="btn btn-limpiar-filtro btn-limpiar-campo"
                                                    data-target="filtro_fecha"
                                                    title="Limpiar fecha">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- EQUIPO --}}
                                    <div class="col-12 col-md-6 col-xl-3">
                                        <label for="filtro_equipo" class="form-label">
                                            <i class="fa-solid fa-laptop me-1"></i> EQUIPO
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <input type="text"
                                                id="filtro_equipo"
                                                class="form-control campo-mayusculas"
                                                placeholder="TIPO, MARCA O MODELO"
                                                autocomplete="off">
                                            <button type="button"
                                                    class="btn btn-limpiar-filtro btn-limpiar-campo"
                                                    data-target="filtro_equipo"
                                                    title="Limpiar equipo">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- NÚMERO DE SERIE --}}
                                    <div class="col-12 col-md-6 col-xl-3">
                                        <label for="filtro_serie" class="form-label">
                                            <i class="fa-solid fa-barcode me-1"></i> N.º SERIE
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <input type="text"
                                                id="filtro_serie"
                                                class="form-control campo-mayusculas"
                                                placeholder="NÚMERO DE SERIE"
                                                autocomplete="off">
                                            <button type="button"
                                                    class="btn btn-limpiar-filtro btn-limpiar-campo"
                                                    data-target="filtro_serie"
                                                    title="Limpiar serie">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- DESTINO --}}
                                    <div class="col-12 col-md-6 col-xl-3">
                                        <label for="filtro_destino" class="form-label">
                                            <i class="fa-solid fa-location-dot me-1"></i> DESTINO
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <input type="text"
                                                id="filtro_destino"
                                                class="form-control campo-mayusculas"
                                                placeholder="INSTITUCIÓN O DESTINO"
                                                autocomplete="off">
                                            <button type="button"
                                                    class="btn btn-limpiar-filtro btn-limpiar-campo"
                                                    data-target="filtro_destino"
                                                    title="Limpiar destino">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- ESTADO --}}
                                    <div class="col-12 col-md-6 col-xl-3">
                                        <label for="filtro_estado" class="form-label">
                                            <i class="fa-solid fa-circle-check me-1"></i> ESTADO
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <select id="filtro_estado" class="form-select">
                                                <option value="">TODOS</option>
                                                <option value="VIGENTE">VIGENTE</option>
                                                <option value="ANULADA">ANULADA</option>
                                            </select>
                                            <button type="button"
                                                    class="btn btn-limpiar-filtro btn-limpiar-campo"
                                                    data-target="filtro_estado"
                                                    title="Limpiar estado">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>

                                {{-- ACCIONES --}}
                                <div class="panel-filtros-acciones">
                                    <div class="texto-ayuda-filtros">
                                        <i class="fa-solid fa-circle-info me-1"></i>
                                        Puedes combinar varios filtros para precisar la búsqueda.
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="button"
                                                id="btn_limpiar_filtros"
                                                class="btn btn-limpiar-todos btn-sm">
                                            <i class="fa-solid fa-rotate-left me-1"></i>
                                            LIMPIAR FILTROS
                                        </button>

                                        <button type="button"
                                                id="btn_aplicar_filtros"
                                                class="btn btn-aplicar-filtros btn-sm">
                                            <i class="fa-solid fa-magnifying-glass me-1"></i>
                                            APLICAR FILTROS
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table id="example" class="table table-hover table-bordered align-middle w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>FECHA</th>
                                        <th>EQUIPO</th>
                                        <th>DESTINO</th>
                                        <th>QUIÉN ENTREGA</th>
                                        <th>QUIÉN RECIBE</th>
                                        <th>ESTADO</th>
                                        <th class="text-center">ACCIONES</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($bajas as $baja)
                                    <tr
                                        data-baja-id="{{ $baja->id }}"
                                        data-fecha="{{ $baja->fecha ? \Illuminate\Support\Carbon::parse($baja->fecha)->format('Y-m-d') : '' }}"
                                        data-destino="{{ mb_strtoupper($baja->destino ?? '') }}"
                                        data-estado="{{ mb_strtoupper($baja->estado ?? '') }}"
                                        data-equipo="{{ mb_strtoupper(
                                            ($baja->equipo->tipoEquipo->nombre ?? '') . ' ' .
                                            ($baja->equipo->marca ?? '') . ' ' .
                                            ($baja->equipo->modelo ?? '')
                                        ) }}"
                                        data-serie="{{ mb_strtoupper($baja->equipo->num_serie ?? '') }}"
                                    >

                                        <td>{{ $baja->id }}</td>
                                            <td>
                                                {{ $baja->fecha ? \Illuminate\Support\Carbon::parse($baja->fecha)->format('d/m/Y') : '—' }}
                                            </td>
                                            <td>
                                                <div class="fw-semibold">
                                                    {{ $baja->equipo->tipoEquipo->nombre ?? 'SIN TIPO' }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ $baja->equipo->marca ?? '' }}
                                                    {{ $baja->equipo->modelo ?? '' }}
                                                    · ID {{ $baja->equipo_id }}
                                                </small>
                                                @if ($baja->equipo?->num_serie)
                                                    <small class="d-block text-muted">
                                                        Serie: {{ $baja->equipo->num_serie }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td>{{ $baja->destino }}</td>
                                            <td>{{ $baja->quien_entrego }}</td>
                                            <td>{{ $baja->quien_recibio }}</td>
                                            <td class="text-center">
                                                @if ($baja->estado === 'VIGENTE')
                                                    <span class="badge bg-success">VIGENTE</span>
                                                @else
                                                    <span class="badge bg-secondary">ANULADA</span>
                                                @endif
                                            </td>

                                            <td class="text-center columna-acciones">

                                                <div class="d-flex justify-content-center gap-1 flex-wrap">
                                                    <a href="{{ route('bajas-equipos.show', $baja->id) }}"
                                                       class="btn btn-info btn-accion"
                                                       title="Ver detalle">
                                                        <i class="bi bi-eye"></i>
                                                    </a>

                                                    @if ($baja->estado === 'VIGENTE')
                                                    <a href="{{ route('bajas-equipos.edit', $baja->id) }}"
                                                       class="btn btn-warning btn-accion"
                                                       title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('bajas-equipos.destroy', $baja->id) }}"
                                                          method="POST"
                                                          class="d-inline"
                                                          onsubmit="return false;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                                class="btn btn-danger btn-accion"
                                                                title="Anular baja"
                                                                onclick="confirmarAnularBaja(this.closest('form'))">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- VENTANA DE PROGRESO DE EXPORTACIÓN --}}
<div id="exportacion_overlay"
     class="exportacion-overlay"
     style="display: none;">

    <div class="exportacion-panel">

        <div class="exportacion-icono">
            <i id="exportacion_icono_archivo"
               class="fa-solid fa-file-export"></i>
        </div>

        <h5 id="exportacion_titulo">
            PREPARANDO EXPORTACIÓN
        </h5>

        <p id="exportacion_estado">
            Estamos preparando los registros seleccionados.
        </p>

        <div class="progress exportacion-barra-contenedor">
            <div id="exportacion_progreso"
                 class="progress-bar progress-bar-striped progress-bar-animated"
                 role="progressbar"
                 style="width: 0%;"
                 aria-valuenow="0"
                 aria-valuemin="0"
                 aria-valuemax="100">
            </div>
        </div>

        <div class="exportacion-detalles">
            <span id="exportacion_porcentaje">PREPARANDO...</span>
            <span id="exportacion_tamano">0 MB</span>
        </div>

        <div class="exportacion-acciones">
            <button type="button"
                    id="btn_cancelar_exportacion"
                    class="btn btn-outline-secondary">
                <i class="fa-solid fa-xmark me-1"></i>
                CANCELAR
            </button>
        </div>

    </div>
</div>

<script>
function confirmarAnularBaja(form) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'warning',
            title: '¿Anular esta baja?',
            text: 'El equipo volverá a EN_INVENTARIO. Esta acción no se puede deshacer.',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, anular',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then(r => { if (r.isConfirmed) form.submit(); });
    } else if (confirm('¿Anular esta baja? El equipo volverá a EN_INVENTARIO.')) {
        form.submit();
    }
}


// ===================== DATATABLES Y FILTROS =====================

window.addEventListener('load', function () {

    if (
        typeof $ === 'undefined' ||
        !$.fn.DataTable ||
        !document.getElementById('example')
    ) {
        return;
    }

    // Inicializar DataTables.
    const tabla = $.fn.DataTable.isDataTable('#example')
        ? $('#example').DataTable()
        : $('#example').DataTable({
            dom: '<"d-flex justify-content-between align-items-center mb-2"lf>rt<"d-flex justify-content-between align-items-center mt-2"ip>',
            pageLength: 10,
            lengthMenu: [5, 10, 25, 100],
            order: [[0, 'desc']],
            language: {
                lengthMenu: "Mostrar _MENU_ registros por página",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros.",
                search: "Buscar:",
                zeroRecords: "No se encontraron registros",
                emptyTable: "No hay bajas administrativas registradas",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(filtrado de _MAX_ registros en total)",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            }
        });

    // ===================== CONTROL DE EXPORTACIÓN =====================
    let controladorExportacion = null;
    let exportacionEnCurso = false;


    // Obtener los ID de las bajas visibles según los filtros y el orden de DataTables.
    function obtenerIdsParaExportar() {

        const ids = [];

        tabla.rows({
            search: 'applied',
            order: 'applied'
        }).every(function () {

            const fila = this.node();

            const id = fila
                ? fila.getAttribute('data-baja-id')
                : null;

            if (id) {
                ids.push(id);
            }
        });

        return ids;
    }


    // ===================== ELEMENTOS DE EXPORTACIÓN =====================
    const exportacionOverlay = document.getElementById('exportacion_overlay');
    const exportacionIcono = document.getElementById('exportacion_icono_archivo');
    const exportacionTitulo = document.getElementById('exportacion_titulo');
    const exportacionEstado = document.getElementById('exportacion_estado');
    const exportacionProgreso = document.getElementById('exportacion_progreso');
    const exportacionPorcentaje = document.getElementById('exportacion_porcentaje');
    const exportacionTamano = document.getElementById('exportacion_tamano');

    const btnExportarExcel = document.getElementById('btn_exportar_excel');
    const btnExportarPdf = document.getElementById('btn_exportar_pdf');
    const btnCancelarExportacion = document.getElementById('btn_cancelar_exportacion');

    // ===================== FUNCIONES DE LA VENTANA =====================

    // Mostrar la ventana de exportación.
    function mostrarVentanaExportacion(tipo) {

        exportacionOverlay.style.display = 'flex';

        exportacionIcono.className = tipo === 'excel'
            ? 'fa-solid fa-file-excel'
            : 'fa-solid fa-file-pdf';

        exportacionTitulo.textContent = tipo === 'excel'
            ? 'PREPARANDO ARCHIVO EXCEL'
            : 'PREPARANDO ARCHIVO PDF';

        exportacionEstado.textContent =
            'Estamos preparando los registros seleccionados.';

        exportacionProgreso.style.width = '0%';
        exportacionProgreso.setAttribute('aria-valuenow', '0');

        exportacionPorcentaje.textContent = 'PREPARANDO...';
        exportacionTamano.textContent = '0 MB';
    }


    // Actualizar el avance de la descarga.
    function actualizarProgresoExportacion(porcentaje, descargado, total) {

        const progreso = Math.min(100, Math.max(0, porcentaje));

        exportacionProgreso.style.width = `${progreso}%`;
        exportacionProgreso.setAttribute('aria-valuenow', progreso);

        exportacionPorcentaje.textContent = `${Math.round(progreso)}%`;

        exportacionTamano.textContent =
            `${(descargado / (1024 * 1024)).toFixed(2)} MB / ${(total / (1024 * 1024)).toFixed(2)} MB`;

        exportacionEstado.textContent =
            progreso >= 100
                ? 'Archivo recibido. Finalizando descarga...'
                : 'Descargando archivo, por favor espera...';
    }


    // Cerrar la ventana de exportación.
    function cerrarVentanaExportacion() {

        exportacionOverlay.style.display = 'none';

        exportacionProgreso.style.width = '0%';
        exportacionProgreso.setAttribute('aria-valuenow', '0');

        exportacionPorcentaje.textContent = 'PREPARANDO...';
        exportacionTamano.textContent = '0 MB';
    }


    // ===================== DESCARGA DE ARCHIVOS =====================

    async function ejecutarExportacion(tipo) {

        if (exportacionEnCurso) {
            return;
        }

        // Obtener los registros filtrados y ordenados.
        const ids = obtenerIdsParaExportar();

        if (ids.length === 0) {

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'info',
                    title: 'SIN REGISTROS',
                    text: 'No hay bajas administrativas que coincidan con los filtros seleccionados.'
                });
            } else {
                alert('No hay bajas administrativas para exportar.');
            }

            return;
        }

        // Configurar la exportación.
        const esExcel = tipo === 'excel';

        const url = esExcel
            ? "{{ route('bajas-equipos.export.excel') }}"
            : "{{ route('bajas-equipos.export.pdf') }}";

        const nombrePredeterminado = esExcel
            ? 'Bajas_Administrativas.xlsx'
            : 'Bajas_Administrativas.pdf';

        const tipoMime = esExcel
            ? 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            : 'application/pdf';

        const formData = new FormData();

        formData.append('_token', "{{ csrf_token() }}");

        ids.forEach(id => {
            formData.append('ids[]', id);
        });

        controladorExportacion = new AbortController();
        exportacionEnCurso = true;

        mostrarVentanaExportacion(tipo);

        try {

            // Enviar solicitud al controlador Laravel.
            const respuesta = await fetch(url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body: formData,
                signal: controladorExportacion.signal
            });

            if (!respuesta.ok) {

                let mensajeError = 'No se pudo generar el archivo.';

                try {
                    const datosError = await respuesta.json();

                    if (datosError.message) {
                        mensajeError = datosError.message;
                    } else if (datosError.errors) {
                        mensajeError = Object.values(datosError.errors)
                            .flat()
                            .join('\n');
                    }

                } catch (error) {
                    // Mantener el mensaje general si la respuesta no es JSON.
                }

                throw new Error(mensajeError);
            }

            // Verificar que el servidor haya devuelto el formato esperado.
            const contenido = respuesta.headers.get('Content-Type') || '';

            if (!contenido.toLowerCase().includes(tipoMime)) {
                throw new Error('El servidor devolvió un archivo con formato inesperado.');
            }


        // Leer el tamaño total del archivo informado por Laravel.
        const total = Number(respuesta.headers.get('Content-Length')) || 0;

        // Obtener el nombre del archivo enviado por Laravel.
        const disposicion = respuesta.headers.get('Content-Disposition') || '';

        const coincidencia = disposicion.match(/filename="?([^"]+)"?/i);

        const nombreArchivo = coincidencia
            ? coincidencia[1]
            : nombrePredeterminado;

        // Preparar la lectura del archivo.
        const lector = respuesta.body.getReader();

        const fragmentos = [];

        let descargado = 0;

        while (true) {

            const { done, value } = await lector.read();

            if (done) {
                break;
            }

            fragmentos.push(value);

            descargado += value.length;

            // Actualizar el progreso cuando se conoce el tamaño total.
            if (total > 0) {

                const porcentaje = (descargado / total) * 100;

                actualizarProgresoExportacion(
                    porcentaje,
                    descargado,
                    total
                );

            } else {

                exportacionEstado.textContent =
                    `Recibiendo archivo... ${(descargado / (1024 * 1024)).toFixed(2)} MB`;

                exportacionTamano.textContent =
                    `${(descargado / (1024 * 1024)).toFixed(2)} MB`;
            }
        }

        // Crear el archivo descargable.
        const archivo = new Blob(fragmentos, {
            type: tipoMime
        });

        // Crear una dirección temporal para descargarlo.
        const enlace = document.createElement('a');

        const urlArchivo = URL.createObjectURL(archivo);

        enlace.href = urlArchivo;
        enlace.download = nombreArchivo;

        document.body.appendChild(enlace);

        enlace.click();

        enlace.remove();

        // Liberar la dirección temporal.
        setTimeout(() => {
            URL.revokeObjectURL(urlArchivo);
        }, 1000);

        // Mostrar finalización.
        exportacionProgreso.style.width = '100%';
        exportacionProgreso.setAttribute('aria-valuenow', '100');

        exportacionPorcentaje.textContent = '100%';

        exportacionTamano.textContent =
            `${(archivo.size / (1024 * 1024)).toFixed(2)} MB`;

        exportacionTitulo.textContent = 'EXPORTACIÓN COMPLETADA';

        exportacionEstado.textContent =
            'El archivo se ha descargado correctamente.';

        // Cerrar la ventana después de un breve momento.
        setTimeout(() => {
            cerrarVentanaExportacion();
        }, 1500);

        } catch (error) {

    if (error.name === 'AbortError') {

        exportacionTitulo.textContent = 'EXPORTACIÓN CANCELADA';
        exportacionEstado.textContent = 'La descarga fue cancelada por el usuario.';

        exportacionPorcentaje.textContent = 'CANCELADA';
        exportacionTamano.textContent = '0 MB';

        exportacionProgreso.classList.remove('progress-bar-animated');

        await new Promise(resolve => setTimeout(resolve, 1200));

        cerrarVentanaExportacion();

        exportacionProgreso.classList.add('progress-bar-animated');

    } else {

        console.error('Error en la exportación:', error);

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'ERROR DE EXPORTACIÓN',
                text: error.message
            });
        } else {
            alert(error.message);
        }

        cerrarVentanaExportacion();
    }
        } finally {

            controladorExportacion = null;
            exportacionEnCurso = false;
        }
    }



    // Elementos del panel.
    const STORAGE_KEY = 'bajas_filtros_estado';
    const FILTRO_BAJAS_ID = 'filtroPersonalizadoBajas';

    const panel = document.getElementById('panel_filtros');
    const btnToggle = document.getElementById('btn_toggle_filtros');
    const badge = document.getElementById('badge_filtros');
    const mensaje = document.getElementById('mensaje_coincidencias');

    const campos = {
        id: document.getElementById('filtro_id_baja'),
        fecha: document.getElementById('filtro_fecha'),
        equipo: document.getElementById('filtro_equipo'),
        serie: document.getElementById('filtro_serie'),
        destino: document.getElementById('filtro_destino'),
        estado: document.getElementById('filtro_estado')
    };

    // Verificar que todos los elementos de filtros existan.
    if (
        !panel ||
        !btnToggle ||
        !badge ||
        !mensaje ||
        !Object.values(campos).every(campo => campo)
    ) {
        console.error('No se encontraron todos los elementos del panel de filtros.');
        return;
    }

    // Normalizar texto para evitar diferencias entre mayúsculas
    // y minúsculas, así como entre letras con y sin tilde.
    function normalizar(valor) {
        return String(valor ?? '')
            .trim()
            .toLocaleUpperCase('es')
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '');
    }

    // Obtener los filtros actuales.
    function obtenerFiltros() {
        return {
            id: campos.id.value.trim(),
            fecha: campos.fecha.value,
            equipo: normalizar(campos.equipo.value),
            serie: normalizar(campos.serie.value),
            destino: normalizar(campos.destino.value),
            estado: campos.estado.value
        };
    }

    // Contar filtros activos.
    function contarFiltros(filtros) {
        return Object.values(filtros)
            .filter(valor => valor !== '')
            .length;
    }


    // Guardar filtros y visibilidad del panel.
    function guardarEstado() {
        const estado = {
            filtros: obtenerFiltros(),
            panelVisible: panel.style.display !== 'none'
        };

        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(estado));
        } catch (error) {
            console.warn('No se pudieron guardar los filtros de bajas:', error);
        }
    }


    // Actualizar contador.
    function actualizarBadge() {
        const cantidad = contarFiltros(obtenerFiltros());

        badge.textContent = cantidad;
        badge.classList.toggle('d-none', cantidad === 0);
    }

    // Mostrar cantidad de coincidencias.
    function actualizarCoincidencias() {
        const cantidadFiltros = contarFiltros(obtenerFiltros());

        if (cantidadFiltros === 0) {
            mensaje.style.display = 'none';
            return;
        }

        const cantidad = tabla.rows({
            search: 'applied'
        }).count();

        mensaje.textContent = cantidad === 1
            ? 'Se encontró 1 coincidencia.'
            : `Se encontraron ${cantidad} coincidencias.`;

        mensaje.style.display = 'block';
    }

    // Filtro personalizado de DataTables.
    if (!$.fn.dataTable.ext.search.some(
        filtro => filtro._id === FILTRO_BAJAS_ID
    )) {

        const filtroBajas = function (settings, data, dataIndex) {

            // Aplicar únicamente a nuestra tabla.
            if (settings.nTable.id !== 'example') {
                return true;
            }

            const filtros = obtenerFiltros();

            // Obtener directamente la fila que DataTables está evaluando.
            const fila = settings.aoData[dataIndex]?.nTr;

            if (!fila) {
                return true;
            }

            const id = fila.dataset.bajaId || '';
            const fecha = fila.dataset.fecha || '';
            const equipo = normalizar(fila.dataset.equipo);
            const serie = normalizar(fila.dataset.serie);
            const destino = normalizar(fila.dataset.destino);
            const estado = fila.dataset.estado || '';

            if (filtros.id && id !== filtros.id) return false;
            if (filtros.fecha && fecha !== filtros.fecha) return false;
            if (filtros.equipo && !equipo.includes(filtros.equipo)) return false;
            if (filtros.serie && !serie.includes(filtros.serie)) return false;
            if (filtros.destino && !destino.includes(filtros.destino)) return false;
            if (filtros.estado && estado !== filtros.estado) return false;

            return true;
        };

        filtroBajas._id = FILTRO_BAJAS_ID;

        $.fn.dataTable.ext.search.push(filtroBajas);
    }


    // Aplicar filtros inmediatamente.
    function aplicarFiltros() {
        tabla.draw();
        actualizarBadge();
        guardarEstado();
    }

    // Controlar las búsquedas mientras se escribe.
    let temporizadorFiltros = null;

    function aplicarFiltrosEnVivo() {
        clearTimeout(temporizadorFiltros);

        temporizadorFiltros = setTimeout(() => {
            aplicarFiltros();
        }, 300);
    }


    // Mostrar u ocultar el panel.
    btnToggle.addEventListener('click', function () {

        const visible = panel.style.display === 'none';

        panel.style.display = visible ? 'block' : 'none';

        btnToggle.setAttribute('aria-expanded', visible);

        guardarEstado();
    });

    // Botón aplicar filtros.
    document.getElementById('btn_aplicar_filtros')
        .addEventListener('click', aplicarFiltros);

    // Botón limpiar todos los filtros.
    document.getElementById('btn_limpiar_filtros')
        .addEventListener('click', function () {

            Object.values(campos).forEach(campo => {
                campo.value = '';
            });

            aplicarFiltros();
        });

    // Limpiar campos individuales.
    document.querySelectorAll('.btn-limpiar-campo').forEach(boton => {

        boton.addEventListener('click', function () {

            const campo = document.getElementById(
                this.dataset.target
            );

            if (campo) {
                campo.value = '';
                aplicarFiltros();
            }
        });
    });

    // Filtrar por la fecha actual.
    document.getElementById('btn_filtro_hoy')
        .addEventListener('click', function () {

            const hoy = new Date();

            const anio = hoy.getFullYear();
            const mes = String(hoy.getMonth() + 1).padStart(2, '0');
            const dia = String(hoy.getDate()).padStart(2, '0');

            campos.fecha.value = `${anio}-${mes}-${dia}`;

            aplicarFiltros();
        });

    // Aplicar filtros en vivo mientras se completan los campos.
    Object.values(campos).forEach(campo => {

        campo.addEventListener('input', aplicarFiltrosEnVivo);
        campo.addEventListener('change', aplicarFiltros);

    });


    // Restaurar filtros guardados.
    function restaurarFiltros() {

        try {

            const guardado = localStorage.getItem(STORAGE_KEY);

            if (!guardado) {
                return;
            }

            const estado = JSON.parse(guardado);

            // Verificar que los datos guardados sean válidos.
            if (!estado || typeof estado !== 'object') {
                throw new Error('Formato de filtros inválido.');
            }

            // Restaurar los valores de los filtros.
            if (
                estado.filtros &&
                typeof estado.filtros === 'object' &&
                !Array.isArray(estado.filtros)
            ) {
                Object.keys(campos).forEach(clave => {

                    const valor = estado.filtros[clave];

                    campos[clave].value =
                        typeof valor === 'string' || typeof valor === 'number'
                            ? String(valor)
                            : '';
                });
            }

            // Restaurar la visibilidad del panel.
            if (estado.panelVisible === true) {
                panel.style.display = 'block';
                btnToggle.setAttribute('aria-expanded', 'true');
            }

        } catch (error) {

            // Intentar eliminar los datos dañados.
            try {
                localStorage.removeItem(STORAGE_KEY);
            } catch (errorAlmacenamiento) {
                console.warn('No se pudieron eliminar los filtros guardados.');
            }

            console.warn('No se pudieron restaurar los filtros de bajas:', error);
        }
    }


    // Actualizar coincidencias después de cada redibujado.
    tabla.on('draw.dt', actualizarCoincidencias);


    // ===================== EVENTOS DE EXPORTACIÓN =====================

    if (btnExportarExcel) {
        btnExportarExcel.addEventListener('click', () => {
            ejecutarExportacion('excel');
        });
    }

    if (btnExportarPdf) {
        btnExportarPdf.addEventListener('click', () => {
            ejecutarExportacion('pdf');
        });
    }

    if (btnCancelarExportacion) {
        btnCancelarExportacion.addEventListener('click', () => {
            if (controladorExportacion) {
                controladorExportacion.abort();
            }
        });
    }


    // Recuperar estado anterior y aplicar filtros.
    restaurarFiltros();
    aplicarFiltros();

});
</script>


<style>
    /* =========================================
       PANEL DE FILTROS - BAJAS
    ========================================= */

    .panel-filtros-equipos {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }

    .panel-filtros-header {
        padding: 14px 18px;
        background: #e9f7e9;
        border-bottom: 1px solid #d4e8d5;
    }

    .panel-filtros-header h6 {
        color: #245c38;
        font-size: 0.88rem;
        letter-spacing: 0.3px;
    }

    .panel-filtros-header small {
        color: #6c757d;
        font-size: 0.78rem;
    }

    .icono-filtros {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        flex-shrink: 0;
        background: #d3ebd5;
        color: #198754;
        border-radius: 8px;
        font-size: 1rem;
    }

    .panel-filtros-body {
        padding: 18px;
    }

    .panel-filtros-equipos .form-label {
        display: block;
        margin-bottom: 6px;
        color: #495057;
        font-size: 0.73rem;
        font-weight: 700;
        letter-spacing: 0.35px;
    }

    .panel-filtros-equipos .form-label i {
        color: #198754;
        font-size: 0.76rem;
    }

    .panel-filtros-equipos .form-control,
    .panel-filtros-equipos .form-select {
        min-height: 34px;
        border-color: #d6dce1;
        border-radius: 5px;
        color: #343a40;
        font-size: 0.82rem;
        background-color: #fff;
    }

    .panel-filtros-equipos .form-control:focus,
    .panel-filtros-equipos .form-select:focus {
        border-color: #86b7a0;
        box-shadow: 0 0 0 0.15rem rgba(25, 135, 84, 0.12);
    }

    .panel-filtros-equipos .btn-limpiar-filtro {
        min-width: 34px;
        border: 1px solid #d6dce1;
        background: #f8f9fa;
        color: #6c757d;
        transition: all 0.2s ease;
    }

    .panel-filtros-equipos .btn-limpiar-filtro:hover {
        background: #f8d7da;
        border-color: #f1b9bf;
        color: #842029;
    }

    .panel-filtros-equipos .btn-hoy-filtro {
        padding-right: 10px;
        padding-left: 10px;
        border: 1px solid #198754;
        background: #e9f7e9;
        color: #198754;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .panel-filtros-equipos .btn-hoy-filtro:hover {
        background: #198754;
        color: #fff;
    }

    .panel-filtros-acciones {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid #e9ecef;
    }

    .texto-ayuda-filtros {
        color: #7a838b;
        font-size: 0.78rem;
    }

    .panel-filtros-equipos .btn-limpiar-todos {
        padding: 7px 12px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        background: #fff;
        color: #495057;
        font-weight: 600;
        font-size: 0.76rem;
    }

    .panel-filtros-equipos .btn-limpiar-todos:hover {
        background: #f1f3f5;
        border-color: #adb5bd;
    }

    .panel-filtros-equipos .btn-aplicar-filtros {
        padding: 7px 14px;
        border: 1px solid #198754;
        border-radius: 6px;
        background: #198754;
        color: #fff;
        font-weight: 600;
        font-size: 0.76rem;
    }

    .panel-filtros-equipos .btn-aplicar-filtros:hover {
        background: #146c43;
        border-color: #146c43;
        color: #fff;
    }


    /* =========================================
       BARRA DE FILTROS Y MENSAJE
    ========================================= */

    .barra-filtros-equipos {
        width: 100%;
    }

    .btn-filtros-equipos {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 36px;
        padding: 7px 13px;
        border: 1px solid #198754;
        border-radius: 7px;
        background: #fff;
        color: #198754;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.25px;
        transition: background-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-filtros-equipos:hover,
    .btn-filtros-equipos.filtros-abiertos {
        background: #198754;
        color: #fff;
        box-shadow: 0 2px 5px rgba(25, 135, 84, 0.15);
    }

    .btn-filtros-equipos:focus-visible {
        outline: none;
        box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.18);
    }

    .icono-boton-filtros {
        font-size: 0.85rem;
    }

    .flecha-filtros {
        font-size: 0.68rem;
        transition: transform 0.2s ease;
    }

    .btn-filtros-equipos.filtros-abiertos .flecha-filtros {
        transform: rotate(180deg);
    }

    .btn-filtros-equipos .badge-filtros-contador {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 22px;
        height: 22px;
        margin-left: 9px !important;
        padding: 0 6px;
        border: 1px solid #c5e7d3;
        border-radius: 6px;
        background: #d1e7dd;
        color: #146c43;
        font-size: 0.72rem;
        font-weight: 800;
    }

    .btn-filtros-equipos:hover .badge-filtros-contador,
    .btn-filtros-equipos.filtros-abiertos .badge-filtros-contador {
        border-color: rgba(255, 255, 255, 0.45);
        background: #fff;
        color: #198754;
    }

    .mensaje-coincidencias {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        min-height: 36px;
        padding: 5px 11px;
        border: 1px solid #cde5d5;
        border-radius: 7px;
        background: #f0f8f2;
        color: #245c38;
        font-size: 0.78rem;
        line-height: 1.3;
        animation: aparecerMensajeFiltros 0.2s ease;
    }

    .mensaje-coincidencias .icono-mensaje {
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    .mensaje-coincidencias .texto-mensaje {
        font-weight: 600;
    }

    .mensaje-coincidencias .numero-coincidencias {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 27px;
        min-height: 25px;
        padding: 3px 7px;
        border-radius: 5px;
        background: #d1e7dd;
        color: #146c43;
        font-size: 0.85rem;
        font-weight: 800;
        font-variant-numeric: tabular-nums;
    }

    .mensaje-coincidencias.sin-resultados {
        border-color: #e5d8bd;
        background: #fffaf0;
        color: #795b20;
    }

    .mensaje-coincidencias.sin-resultados .numero-coincidencias {
        background: #f5e8c9;
        color: #795b20;
    }

    @keyframes aparecerMensajeFiltros {
        from {
            opacity: 0;
            transform: translateY(-3px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }


    /* =========================================
       DATATABLE - BAJAS ADMINISTRATIVAS
    ========================================= */

    #example_wrapper {
        width: 100%;
        color: #343a40;
        font-size: .88rem;
    }

    #example_wrapper .dataTables_length,
    #example_wrapper .dataTables_filter {
        margin-bottom: 12px;
    }

    #example_wrapper .dataTables_length label,
    #example_wrapper .dataTables_filter label {
        color: #495057;
        font-weight: 500;
    }

    #example_wrapper .dataTables_length select,
    #example_wrapper .dataTables_filter input {
        border: 1px solid #ced4da;
        border-radius: 6px;
        padding: 5px 9px;
        background: #fff;
        color: #212529;
    }

    #example_wrapper .dataTables_filter input {
        margin-left: 6px;
        max-width: 220px;
    }

    #example_wrapper .dataTables_length select:focus,
    #example_wrapper .dataTables_filter input:focus {
        outline: none;
        border-color: #86b7a0;
        box-shadow: 0 0 0 .15rem rgba(25, 135, 84, .12);
    }

    #example {
        width: 100% !important;
        margin-bottom: 0 !important;
        border-color: #dee2e6;
    }

    #example thead th {
        background-color: #e9f7e9 !important;
        color: #212529 !important;
        text-align: center;
        vertical-align: middle;
        font-size: .78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .2px;
        white-space: nowrap;
        padding: 12px 10px;
        border-color: #d5e5d7;
    }

    #example tbody td {
        vertical-align: middle !important;
        padding: 10px;
        border-color: #e5e7eb;
        color: #343a40;
    }

    #example tbody tr:nth-child(even) td {
        background-color: #f8faf9;
    }

    #example tbody tr:hover td {
        background-color: #eef7f0;
    }

    #example tbody td:first-child,
    #example tbody td:nth-child(2),
    #example tbody td:nth-child(7),
    #example tbody td:last-child {
        text-align: center;
    }

    #example tbody td:nth-child(4),
    #example tbody td:nth-child(5),
    #example tbody td:nth-child(6) {
        min-width: 130px;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    #example .badge {
        font-size: .72rem;
        font-weight: 700;
        padding: 6px 9px;
        border-radius: 5px;
        letter-spacing: .2px;
    }

    #example .columna-acciones {
        min-width: 125px;
        white-space: nowrap;
    }

    #example .btn-accion {
        width: 31px;
        height: 30px;
        padding: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 5px;
        font-size: .8rem;
        transition: opacity .2s, transform .2s;
    }

    #example .btn-accion:hover {
        opacity: .85;
        transform: translateY(-1px);
    }

    #example .btn-info.btn-accion {
        background-color: #e7f1ff;
        color: #0d6efd;
    }

    #example .btn-warning.btn-accion {
        background-color: #fff3cd;
        color: #856404;
    }

    #example .btn-danger.btn-accion {
        background-color: #f8d7da;
        color: #842029;
    }

    #example_wrapper .dataTables_info {
        padding-top: 10px;
        color: #6c757d;
        font-size: .82rem;
    }

    #example_wrapper .dataTables_paginate {
        padding-top: 8px;
    }

    #example_wrapper .page-link {
        color: #198754;
        border-color: #dee2e6;
    }

    #example_wrapper .page-item.active .page-link {
        background-color: #198754;
        border-color: #198754;
        color: #fff;
    }

    #example_wrapper .page-link:focus {
        box-shadow: 0 0 0 .15rem rgba(25, 135, 84, .15);
    }


    /* =========================================
       TARJETA PRINCIPAL - BAJAS
    ========================================= */

    .baja-index-card {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .06);
        overflow: hidden;
    }

    .baja-index-header {
        background: #e9f7e9;
        color: #212529;
        border-bottom: 1px solid #c8e6c9;
        padding: 15px 18px;
    }

    .baja-index-header #card_title {
        font-size: 1rem;
        letter-spacing: .2px;
    }

    .baja-index-body {
        padding: 18px;
    }

    .baja-index-header .btn,
    .baja-index-body .btn {
        border-radius: 6px;
    }

    /* =========================================
       ADAPTACIÓN DE ESPACIOS EN PANTALLAS PEQUEÑAS
    ========================================= */

    @media (max-width: 768px) {
        .baja-index-body {
            padding: 12px;
        }

        .baja-index-header {
            padding: 12px;
        }

        .panel-filtros-header,
        .panel-filtros-body {
            padding: 12px;
        }

        .panel-filtros-acciones {
            align-items: stretch;
            flex-direction: column;
        }

        .panel-filtros-acciones > .d-flex {
            width: 100%;
        }

        .panel-filtros-acciones > .d-flex .btn {
            flex: 1;
        }
    }

    /* ==========================================
    VENTANA DE PROGRESO DE EXPORTACIÓN
    ========================================== */

    .exportacion-overlay {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(3px);
    }

    .exportacion-panel {
        width: 100%;
        max-width: 440px;
        padding: 30px;
        text-align: center;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.20);
    }

    .exportacion-icono {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 65px;
        height: 65px;
        margin: 0 auto 18px;
        color: #198754;
        font-size: 30px;
        background: #e8f5ed;
        border-radius: 50%;
    }

    .exportacion-panel h5 {
        margin-bottom: 10px;
        font-size: 17px;
        font-weight: 800;
        color: #212529;
    }

    .exportacion-panel p {
        margin-bottom: 22px;
        font-size: 13px;
        color: #6c757d;
    }

    .exportacion-barra-contenedor {
        height: 12px;
        overflow: hidden;
        background: #e9ecef;
        border-radius: 20px;
    }

    .exportacion-barra-contenedor .progress-bar {
        background: #198754;
        transition: width 0.25s ease;
    }

    .exportacion-detalles {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        font-size: 11px;
        font-weight: 700;
        color: #6c757d;
    }

    .exportacion-acciones {
        margin-top: 22px;
    }

    .exportacion-acciones button {
        min-width: 120px;
        font-size: 12px;
        font-weight: 700;
    }

    @media (max-width: 576px) {
        .exportacion-panel {
            padding: 24px 18px;
        }
    }

</style>

@endsection
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