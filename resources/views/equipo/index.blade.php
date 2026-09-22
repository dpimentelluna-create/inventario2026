@extends('layouts.app')

@section('template_title')
    Equipos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span id="card_title">EQUIPOS</span>
                            <a href="{{ route('equipos.create') }}" class="btn btn-primary btn-sm">Registrar Nuevo</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <span id="mensaje_coincidencias" class="text-success fw-bold" style="display:none;">
                                    SE ENCONTRARON: 0 COINCIDENCIAS
                                </span>
                            </div>

                            <button type="button" id="btn_toggle_filtros" class="btn btn-outline-success btn-sm">
                                FILTROS <span id="badge_filtros" class="badge bg-success ms-1 d-none">0</span>
                            </button>
                        </div>

                        <div id="panel_filtros" class="border rounded p-3 mb-3 bg-light" style="display:none;">
                            <div class="row g-2">
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">TIPO</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_tipo" class="form-control form-control-sm"
                                            list="lista_filtro_tipo" placeholder="TODOS" autocomplete="off">
                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo"
                                            data-target="filtro_tipo" tabindex="-1" title="Limpiar">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <datalist id="lista_filtro_tipo">
                                        @foreach ($filtroTipos as $nombre)
                                            <option value="{{ $nombre }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">MARCA</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_marca" class="form-control form-control-sm"
                                            list="lista_filtro_marca" placeholder="ELIJA UN TIPO" autocomplete="off"
                                            disabled>
                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo"
                                            data-target="filtro_marca" tabindex="-1" title="Limpiar">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <datalist id="lista_filtro_marca"></datalist>
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">MODELO</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_modelo" class="form-control form-control-sm"
                                            list="lista_filtro_modelo" placeholder="ELIJA UNA MARCA" autocomplete="off"
                                            disabled>
                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo"
                                            data-target="filtro_modelo" tabindex="-1" title="Limpiar">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <datalist id="lista_filtro_modelo"></datalist>
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">UBICACIÓN</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_ubicacion" class="form-control form-control-sm"
                                            list="lista_filtro_ubicacion" placeholder="TODAS" autocomplete="off">
                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo"
                                            data-target="filtro_ubicacion" tabindex="-1" title="Limpiar">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <datalist id="lista_filtro_ubicacion">
                                        @foreach ($filtroUbicaciones as $nombre)
                                            <option value="{{ $nombre }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">ESTADO</label>
                                    <div class="input-group input-group-sm">
                                        <select id="filtro_estado" class="form-select form-select-sm">
                                            <option value="">TODOS</option>
                                            <option value="BUENO">BUENO</option>
                                            <option value="REGULAR">REGULAR</option>
                                            <option value="MALOGRADO">MALOGRADO</option>
                                        </select>
                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo"
                                            data-target="filtro_estado" tabindex="-1" title="Limpiar">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">N.º SERIE</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_serie"
                                            class="form-control form-control-sm campo-mayusculas"
                                            list="lista_filtro_serie" placeholder="ESCRIBA 3 CARACTERES"
                                            autocomplete="off">
                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo"
                                            data-target="filtro_serie" tabindex="-1" title="Limpiar">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <datalist id="lista_filtro_serie"></datalist>
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">FECHA</label>
                                    <div class="input-group input-group-sm">
                                        <input type="date" id="filtro_fecha" class="form-control form-control-sm">
                                        <button type="button" id="btn_filtro_hoy"
                                            class="btn btn-outline-success btn-sm">HOY</button>
                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo"
                                            data-target="filtro_fecha" tabindex="-1" title="Limpiar">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end align-items-end gap-2 mt-2">
                                    <button type="button" id="btn_aplicar_filtros" class="btn btn-success btn-sm">
                                        APLICAR
                                    </button>

                                    <button type="button" id="btn_limpiar_filtros" class="btn btn-outline-secondary btn-sm">
                                        LIMPIAR
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-hover" style="width:100%">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th class="text-center">Tipo</th>
                                        <th class="text-center">N.º Serie</th>
                                        <th class="text-center">Marca</th>
                                        <th class="text-center">Modelo</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Ubicación</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Observación</th>
                                        <th class="text-center columna-acciones">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($equipos as $i => $equipo)
                                                                @php
    $estado = strtoupper(
        $equipo->especificacionesLaptops->estado
        ?? $equipo->especificacionesEquipo->estado
        ?? ''
    );
    $fechaIso = $equipo->fecha_registro
        ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('Y-m-d')
        : '';
    $fechaVista = $fechaIso
        ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('d-m-Y')
        : '-';
                                                                @endphp
                                                                <tr data-equipo-id="{{ $equipo->id }}">
                                                                    <td>{{ $i + 1 }}</td>
                                                                    <td>{{ $equipo->tipoEquipo->nombre ?? '-' }}</td>
                                                                    <td class="text-center">{{ $equipo->num_serie }}</td>
                                                                    <td>{{ $equipo->marca }}</td>
                                                                    <td>{{ $equipo->modelo }}</td>
                                                                    <td class="text-center">{{ $estado ?: '-' }}</td>
                                                                    <td class="text-center">{{ $equipo->ubicacione->nombre ?? '-' }}</td>
                                                                    <td class="text-center" data-fecha="{{ $fechaIso }}">{{ $fechaVista }}</td>
                                                                    <td>
                                                                        {{ $equipo->especificacionesLaptops->observaciones
        ?? $equipo->especificacionesEquipo->observaciones
        ?? '-' }}
                                                                    </td>
                                                                    <td class="text-center columna-acciones">
                                                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                                                            <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST">
                                                                                <a class="btn btn-info btn-accion btn-ver-equipo" 
                                                                                    href="{{ route('equipos.show', $equipo->id) }}">
                                                                                    <i class="fa-solid fa-eye"></i>
                                                                                </a>
                                                                                <a class="btn btn-warning btn-accion"
                                                                                    href="{{ route('equipos.edit', $equipo->id) }}">
                                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                                </a>
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-danger btn-accion"
                                                                                    onclick="event.preventDefault(); confirmarEliminarFila(this.closest('form'));">
                                                                                    <i class="fa-solid fa-trash"></i>
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    #example thead th {
        background-color: #5fe65f !important;
        color: #000 !important;
        text-align: center;
        vertical-align: middle;
        font-weight: bold;
    }

    @keyframes filaCrear {
        0%, 70% { background-color: #d4edda !important; }
        100% { background-color: transparent; }
    }
    @keyframes filaEditar {
        0%, 70% { background-color: #fff3cd !important; }
        100% { background-color: transparent; }
    }
    @keyframes filaVer {
        0%, 70% { background-color: #cfe2ff !important; }
        100% { background-color: transparent; }
    }
    #example tbody tr.fila-crear td { animation: filaCrear 3s ease forwards; }
    #example tbody tr.fila-editar td { animation: filaEditar 3s ease forwards; }
    #example tbody tr.fila-ver td { animation: filaVer 3s ease forwards; }
    #example tbody tr.fila-borrar td { background-color: #f8d7da !important; }
    #example tbody tr.fila-borrar { transition: opacity .6s ease; }
    #example tbody tr.fila-borrar.saliendo { opacity: 0; }
</style>

<script>
window.addEventListener('load', function () {

    if (typeof $ === 'undefined' || !$.fn.DataTable) return;

    const tabla = $('#example').DataTable();

    const STORAGE_KEY = 'equipos_filtros_estado';

    /*
     * =========================================================
     * ELEMENTOS PRINCIPALES
     * =========================================================
     */

    const panel = document.getElementById('panel_filtros');
    const btnToggle = document.getElementById('btn_toggle_filtros');
    const badge = document.getElementById('badge_filtros');
    const mensajeCoincidencias =
        document.getElementById('mensaje_coincidencias');

    const inputTipo = document.getElementById('filtro_tipo');
    const inputMarca = document.getElementById('filtro_marca');
    const inputModelo = document.getElementById('filtro_modelo');
    const inputUbicacion = document.getElementById('filtro_ubicacion');
    const inputSerie = document.getElementById('filtro_serie');
    const inputFecha = document.getElementById('filtro_fecha');
    const inputEstado = document.getElementById('filtro_estado');

    const listaTipo = document.getElementById('lista_filtro_tipo');
    const listaMarca = document.getElementById('lista_filtro_marca');
    const listaModelo = document.getElementById('lista_filtro_modelo');
    const listaUbicacion = document.getElementById('lista_filtro_ubicacion');
    const listaSerie = document.getElementById('lista_filtro_serie');


    /*
     * =========================================================
     * DATOS DE LOS EQUIPOS
     * =========================================================
     */

    const filas = [];

    tabla.rows().every(function () {

        const d = this.data();

        filas.push({
            tipo: String(d[1] || '').toUpperCase(),
            serie: String(d[2] || '').toUpperCase(),
            marca: String(d[3] || '').toUpperCase(),
            modelo: String(d[4] || '').toUpperCase()
        });

    });


    /*
     * =========================================================
     * FUNCIONES GENERALES
     * =========================================================
     */

    function val(id) {

        const el = document.getElementById(id);

        return el
            ? el.value.trim().toUpperCase()
            : '';

    }


    function fechaFiltro() {

        return inputFecha
            ? inputFecha.value
            : '';

    }


    function llenarLista(datalist, valores) {

        if (!datalist) return;

        datalist.innerHTML = '';

        Array.from(valores)
            .sort()
            .forEach(function (v) {

                if (!v || v === '-') return;

                const op = document.createElement('option');

                op.value = v;

                datalist.appendChild(op);

            });

    }


    function setBloqueo(el, bloqueado, placeholder) {

        if (!el) return;

        el.disabled = bloqueado;

        el.classList.toggle(
            'bg-light',
            bloqueado
        );

        if (bloqueado) {

            el.value = '';

        }

        if (placeholder) {

            el.placeholder = placeholder;

        }

    }


    /*
     * =========================================================
     * FILTROS ENCADENADOS
     * =========================================================
     */

    function actualizarEncadenados() {

        const tipo = val('filtro_tipo');
        const marca = val('filtro_marca');

        /*
         * SI NO HAY TIPO
         */

        if (!tipo) {

            setBloqueo(
                inputMarca,
                true,
                'ELIJA UN TIPO'
            );

            setBloqueo(
                inputModelo,
                true,
                'ELIJA UNA MARCA'
            );

            llenarLista(listaMarca, []);
            llenarLista(listaModelo, []);

            return;

        }


        /*
         * OBTENER MARCAS SEGÚN TIPO
         */

        const marcas = new Set();

        filas.forEach(function (f) {

            if (
                f.tipo.indexOf(tipo) !== -1 &&
                f.marca
            ) {

                marcas.add(f.marca);

            }

        });


        setBloqueo(
            inputMarca,
            false,
            'TODAS'
        );

        llenarLista(
            listaMarca,
            marcas
        );


        /*
         * SI NO HAY MARCA
         */

        if (!marca) {

            setBloqueo(
                inputModelo,
                true,
                'ELIJA UNA MARCA'
            );

            llenarLista(
                listaModelo,
                []
            );

            return;

        }


        /*
         * OBTENER MODELOS SEGÚN TIPO + MARCA
         */

        const modelos = new Set();

        filas.forEach(function (f) {

            if (
                f.tipo.indexOf(tipo) !== -1 &&
                f.marca.indexOf(marca) !== -1 &&
                f.modelo
            ) {

                modelos.add(f.modelo);

            }

        });


        setBloqueo(
            inputModelo,
            false,
            'TODOS'
        );

        llenarLista(
            listaModelo,
            modelos
        );

    }


    /*
     * =========================================================
     * FILTRO DE NÚMERO DE SERIE
     * =========================================================
     */

    function actualizarSeries() {

        if (!inputSerie || !listaSerie) return;

        const q =
            inputSerie.value
                .trim()
                .toUpperCase();

        listaSerie.innerHTML = '';

        if (q.length < 3) return;

        const vistos = new Set();

        filas.forEach(function (f) {

            if (
                f.serie.indexOf(q) !== -1 &&
                !vistos.has(f.serie)
            ) {

                vistos.add(f.serie);

                const op =
                    document.createElement('option');

                op.value = f.serie;

                listaSerie.appendChild(op);

            }

        });

    }


    /*
     * =========================================================
     * CONTADOR DE FILTROS
     * =========================================================
     */

    function contarFiltros() {

        let n = 0;

        [
            'filtro_tipo',
            'filtro_marca',
            'filtro_modelo',
            'filtro_ubicacion',
            'filtro_estado',
            'filtro_serie'
        ].forEach(function (id) {

            if (val(id)) {

                n++;

            }

        });

        if (fechaFiltro()) {

            n++;

        }

        return n;

    }


    function actualizarBadge() {

        if (!badge) return;

        const cantidad =
            contarFiltros();

        badge.textContent = cantidad;

        badge.classList.toggle(
            'd-none',
            cantidad === 0
        );

    }


    /*
     * =========================================================
     * LOCALSTORAGE
     * =========================================================
     */

    function guardarEstadoFiltros() {

        const estado = {

            tipo: inputTipo
                ? inputTipo.value
                : '',

            marca: inputMarca
                ? inputMarca.value
                : '',

            modelo: inputModelo
                ? inputModelo.value
                : '',

            ubicacion: inputUbicacion
                ? inputUbicacion.value
                : '',

            estado: inputEstado
                ? inputEstado.value
                : '',

            serie: inputSerie
                ? inputSerie.value
                : '',

            fecha: inputFecha
                ? inputFecha.value
                : '',

            panelAbierto:
                panel
                    ? panel.style.display !== 'none'
                    : false

        };

        localStorage.setItem(
            STORAGE_KEY,
            JSON.stringify(estado)
        );

    }

/*
 * =========================================================
 * MANTENER LA PAGINACIÓN ACTIVA
 * =========================================================
 *
 * GUARDA Y RECUPERA LA PÁGINA ACTUAL DEL DATATABLE.
 *
 * FUNCIONA PARA:
 * - REGISTRAR NUEVO
 * - VER
 * - EDITAR
 * - ELIMINAR
 *
 * TAMBIÉN FUNCIONA AL VOLVER CON EL BOTÓN ATRÁS.
 *
 */

const STORAGE_PAGE_KEY = STORAGE_KEY + '_pagina';
const STORAGE_NUEVO_EQUIPO = STORAGE_KEY + '_nuevo_equipo';

function guardarPaginaActual() {
    const paginaActual = tabla.page();
    localStorage.setItem(STORAGE_PAGE_KEY, String(paginaActual));
}

function cargarPaginaActual() {

    // Si acabamos de registrar un equipo nuevo,
    // ir directamente a la última página.
    const nuevoEquipo = localStorage.getItem(STORAGE_NUEVO_EQUIPO);

    if (nuevoEquipo === '1') {
    localStorage.removeItem(STORAGE_NUEVO_EQUIPO);
    setTimeout(function () {
        const cantidadPaginas = tabla.page.info().pages;
        if (cantidadPaginas > 0) {
            const ultimaPagina = cantidadPaginas - 1;
            tabla.page(ultimaPagina).draw('page');
            localStorage.setItem(STORAGE_PAGE_KEY, String(ultimaPagina));
        }
    }, 100);
    return;
}

    // Comportamiento normal:
    // recuperar la página donde estaba anteriormente.
    const paginaGuardada = localStorage.getItem(STORAGE_PAGE_KEY);

    if (paginaGuardada === null) {
        return;
    }

    const pagina = parseInt(paginaGuardada, 10);

    if (isNaN(pagina) || pagina < 0) {
        return;
    }

    const paginasDisponibles = tabla.page.info().pages;

    if (paginasDisponibles === 0) {
        return;
    }

    // Evita intentar ir a una página que ya no existe.
    const paginaFinal =
        Math.min(pagina, paginasDisponibles - 1);

    tabla.page(paginaFinal).draw('page');
}


/*
 * =========================================================
 * CUANDO CAMBIA LA PAGINACIÓN
 * =========================================================
 */

tabla.on(
    'page.dt',
    function () {

        guardarPaginaActual();

    }
);


/*
 * =========================================================
 * ANTES DE SALIR DEL INDEX
 * =========================================================
 *
 * GUARDA LA PÁGINA ACTUAL SIN IMPORTAR
 * QUÉ BOTÓN SE UTILICE.
 *
 */

window.addEventListener(
    'beforeunload',
    function () {

        guardarPaginaActual();

    }
);


/*
 * =========================================================
 * AL VOLVER CON EL BOTÓN ATRÁS
 * =========================================================
 *
 * Esto es importante porque el navegador puede utilizar
 * el historial/bfcache y en ese caso "load" puede no
 * ejecutarse nuevamente.
 *
 */

window.addEventListener(
    'pageshow',
    function () {

        setTimeout(function () {

            cargarPaginaActual();

        }, 100);

    }
);
/*--------------------------------------------------------*/

    function cargarEstadoFiltros() {

        const datos =
            localStorage.getItem(STORAGE_KEY);

        if (!datos) return false;

        try {

            const estado =
                JSON.parse(datos);

            if (inputTipo) {
                inputTipo.value =
                    estado.tipo || '';
            }

            if (inputMarca) {
                inputMarca.value =
                    estado.marca || '';
            }

            if (inputModelo) {
                inputModelo.value =
                    estado.modelo || '';
            }

            if (inputUbicacion) {
                inputUbicacion.value =
                    estado.ubicacion || '';
            }

            if (inputEstado) {
                inputEstado.value =
                    estado.estado || '';
            }

            if (inputSerie) {
                inputSerie.value =
                    estado.serie || '';
            }

            if (inputFecha) {
                inputFecha.value =
                    estado.fecha || '';
            }


            /*
             * RESTAURAR PANEL
             */

            if (
                panel &&
                estado.panelAbierto
            ) {

                panel.style.display = 'block';

            }


            return true;

        } catch (error) {

            console.error(
                'Error al recuperar los filtros:',
                error
            );

            localStorage.removeItem(
                STORAGE_KEY
            );

            return false;

        }

    }


    /*
     * =========================================================
     * MENSAJE DE COINCIDENCIAS
     * =========================================================
     */

    function mostrarCoincidencias() {

        if (!mensajeCoincidencias) return;

        const cantidadFiltros =
            contarFiltros();


        /*
         * SIN FILTROS:
         * OCULTAR MENSAJE
         */

        if (cantidadFiltros === 0) {

            mensajeCoincidencias.style.display =
                'none';

            return;

        }


        /*
         * CON FILTROS:
         * MOSTRAR COINCIDENCIAS
         */

        const coincidencias =
            tabla.rows({
                search: 'applied'
            }).count();


        mensajeCoincidencias.textContent =
            'SE ENCONTRARON: ' +
            coincidencias +
            ' COINCIDENCIAS';


        mensajeCoincidencias.style.display =
            'inline';

    }


    /*
     * =========================================================
     * FILTRO PERSONALIZADO DATATABLE
     * =========================================================
     */

    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {

            if (
                settings.nTable.id !== 'example'
            ) {

                return true;

            }


            const tipo = val('filtro_tipo');
            const marca = val('filtro_marca');
            const modelo = val('filtro_modelo');
            const ubicacion = val('filtro_ubicacion');
            const estado = val('filtro_estado');
            const serie = val('filtro_serie');
            const fecha = fechaFiltro();


            /*
             * TIPO
             */

            if (
                tipo &&
                String(data[1])
                    .toUpperCase()
                    .indexOf(tipo) === -1
            ) {

                return false;

            }


            /*
             * SERIE
             */

            if (
                serie &&
                String(data[2])
                    .toUpperCase()
                    .indexOf(serie) === -1
            ) {

                return false;

            }


            /*
             * MARCA
             */

            if (
                marca &&
                String(data[3])
                    .toUpperCase()
                    .indexOf(marca) === -1
            ) {

                return false;

            }


            /*
             * MODELO
             */

            if (
                modelo &&
                String(data[4])
                    .toUpperCase()
                    .indexOf(modelo) === -1
            ) {

                return false;

            }


            /*
             * ESTADO
             */

            if (
                estado &&
                String(data[5])
                    .toUpperCase() !== estado
            ) {

                return false;

            }


            /*
             * UBICACIÓN
             */

            if (
                ubicacion &&
                String(data[6])
                    .toUpperCase()
                    .indexOf(ubicacion) === -1
            ) {

                return false;

            }


            /*
             * FECHA
             */

            if (fecha) {

                const nodo =
                    tabla.row(dataIndex).node();

                const elementoFecha =
                    nodo
                        ? nodo.querySelector(
                            '[data-fecha]'
                        )
                        : null;

                const iso =
                    elementoFecha
                        ? elementoFecha.getAttribute(
                            'data-fecha'
                        )
                        : '';

                if (iso !== fecha) {

                    return false;

                }

            }


            return true;

        }
    );


    /*
     * =========================================================
     * ACTUALIZAR RESULTADOS
     * =========================================================
     *
     * FILTRA SIN MOVER LA PANTALLA.
     *
     */

    function actualizarResultados() {

        actualizarEncadenados();

        actualizarSeries();

        actualizarBadge();

        guardarEstadoFiltros();

        tabla.draw();

        mostrarCoincidencias();

    }


    /*
     * =========================================================
     * APLICAR FILTROS + SCROLL
     * =========================================================
     *
     * ESTA FUNCIÓN SE USA SOLAMENTE PARA:
     *
     * 1. ENTER GLOBAL
     * 2. BOTÓN FILTRAR
     *
     */

    function aplicarFiltros() {

        actualizarResultados();

        setTimeout(function () {

            const tablaElement =
                document.getElementById('example');

            if (!tablaElement) return;

            tablaElement.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        }, 100);

    }


    /*
     * =========================================================
     * MOSTRAR / OCULTAR FILTROS
     * =========================================================
     */

    if (btnToggle && panel) {

        btnToggle.addEventListener(
            'click',
            function () {

                const estaOculto =
                    panel.style.display === 'none';

                panel.style.display =
                    estaOculto
                        ? 'block'
                        : 'none';

                guardarEstadoFiltros();

            }
        );

    }


    /*
     * =========================================================
     * LIMPIAR UN SOLO CAMPO - BOTÓN X
     * =========================================================
     *
     * LIMPIA EL CAMPO + ACTUALIZA RESULTADOS.
     *
     * NO HACE SCROLL.
     *
     */

    function limpiarCampo(id) {

        const el =
            document.getElementById(id);

        if (!el) return;


        /*
         * LIMPIAR CAMPO
         */

        el.value = '';


        /*
         * SI ES TIPO O MARCA,
         * ACTUALIZAR CAMPOS ENCADENADOS
         */

        if (
            id === 'filtro_tipo' ||
            id === 'filtro_marca'
        ) {

            actualizarEncadenados();

        }


        /*
         * LIMPIAR SUGERENCIAS DE SERIE
         */

        if (
            id === 'filtro_serie' &&
            listaSerie
        ) {

            listaSerie.innerHTML = '';

        }


        /*
         * ACTUALIZAR TODO
         */

        actualizarResultados();

    }


    document
        .querySelectorAll('.btn-limpiar-campo')
        .forEach(function (btn) {

            btn.addEventListener(
                'click',
                function () {

                    limpiarCampo(
                        btn.getAttribute(
                            'data-target'
                        )
                    );

                }
            );

        });


    /*
     * =========================================================
     * EVENTOS DE LOS CAMPOS
     * =========================================================
     *
     * AL ESCRIBIR O SELECCIONAR:
     *
     * FILTRA AUTOMÁTICAMENTE.
     *
     * NO HACE SCROLL.
     *
     */

    if (inputTipo) {

        inputTipo.addEventListener(
            'input',
            function () {

                this.value =
                    this.value.toUpperCase();

                actualizarResultados();

            }
        );

    }


    if (inputMarca) {

        inputMarca.addEventListener(
            'input',
            function () {

                this.value =
                    this.value.toUpperCase();

                actualizarResultados();

            }
        );

    }


    if (inputModelo) {

        inputModelo.addEventListener(
            'input',
            function () {

                this.value =
                    this.value.toUpperCase();

                actualizarResultados();

            }
        );

    }


    if (inputUbicacion) {

        inputUbicacion.addEventListener(
            'input',
            function () {

                this.value =
                    this.value.toUpperCase();

                actualizarResultados();

            }
        );

    }


    if (inputSerie) {

        inputSerie.addEventListener(
            'input',
            function () {

                this.value =
                    this.value.toUpperCase();

                actualizarResultados();

            }
        );

    }


    if (inputEstado) {

        inputEstado.addEventListener(
            'change',
            function () {

                actualizarResultados();

            }
        );

    }


    if (inputFecha) {

        inputFecha.addEventListener(
            'change',
            function () {

                actualizarResultados();

            }
        );

    }


    /*
     * =========================================================
     * BOTÓN HOY
     * =========================================================
     *
     * SELECCIONA HOY Y FILTRA AUTOMÁTICAMENTE.
     *
     * NO HACE SCROLL.
     *
     */

    document
        .getElementById('btn_filtro_hoy')
        ?.addEventListener(
            'click',
            function () {

                if (!inputFecha) return;

                const d = new Date();

                inputFecha.value =
                    d.getFullYear() +
                    '-' +
                    String(
                        d.getMonth() + 1
                    ).padStart(2, '0') +
                    '-' +
                    String(
                        d.getDate()
                    ).padStart(2, '0');


                actualizarResultados();

            }
        );


    /*
     * =========================================================
     * BOTÓN FILTRAR
     * =========================================================
     *
     * FILTRA + HACE SCROLL.
     *
     */

    document
        .getElementById('btn_aplicar_filtros')
        ?.addEventListener(
            'click',
            function () {

                aplicarFiltros();

            }
        );


    /*
     * =========================================================
     * BOTÓN LIMPIAR TODOS
     * =========================================================
     *
     * LIMPIA TODO.
     * OCULTA MENSAJE.
     * NO HACE SCROLL.
     *
     */

    document
        .getElementById('btn_limpiar_filtros')
        ?.addEventListener(
            'click',
            function () {


                [
                    'filtro_tipo',
                    'filtro_marca',
                    'filtro_modelo',
                    'filtro_ubicacion',
                    'filtro_serie',
                    'filtro_fecha'
                ].forEach(function (id) {

                    const el =
                        document.getElementById(id);

                    if (el) {

                        el.value = '';

                    }

                });


                if (inputEstado) {

                    inputEstado.value = '';

                }


                actualizarEncadenados();


                if (listaSerie) {

                    listaSerie.innerHTML = '';

                }


                /*
                 * ELIMINAR ESTADO GUARDADO
                 */

                localStorage.removeItem(
                    STORAGE_KEY
                );


                /*
                 * ACTUALIZAR TABLA
                 */

                actualizarBadge();

                tabla.draw();


                /*
                 * OCULTAR MENSAJE
                 */

                if (mensajeCoincidencias) {

                    mensajeCoincidencias.style.display =
                        'none';

                }

            }
        );


    /*
     * =========================================================
     * RECUPERAR FILTROS GUARDADOS
     * =========================================================
     *
     * AL CARGAR:
     *
     * - RECUPERA FILTROS
     * - ACTUALIZA TABLA
     * - MUESTRA MENSAJE
     * - NO HACE SCROLL
     *
     */

         /*
     * =========================================================
     * RECUPERAR ESTADO AL REGRESAR AL INDEX
     * =========================================================
     */

    const filtrosRecuperados =
        cargarEstadoFiltros();


    if (filtrosRecuperados) {
        actualizarEncadenados();
        actualizarSeries();
        actualizarBadge();
        tabla.draw();
        mostrarCoincidencias();
    }


    /*
     * RESTAURAR LA PÁGINA ANTERIOR
     *
     * NO HACER SCROLL.
     */

    setTimeout(function () {

    cargarPaginaActual();

    function pintarFilaEquipo() {
    const idFila = @json(session('equipo_resaltado')) || sessionStorage.getItem('equipo_resaltado');
    const accFila = @json(session('equipo_accion')) || sessionStorage.getItem('equipo_accion');
    sessionStorage.removeItem('equipo_resaltado');
    sessionStorage.removeItem('equipo_accion');
    if (!idFila || !accFila) return;

    const cls = accFila === 'crear' ? 'fila-crear'
        : accFila === 'editar' ? 'fila-editar'
        : 'fila-ver';

    let nodo = null;
    tabla.rows({ page: 'all' }).every(function () {
        const tr = this.node();
        if (tr && String(tr.getAttribute('data-equipo-id')) === String(idFila)) {
            nodo = tr;
        }
    });
    if (!nodo) return;

    const indice = tabla.row(nodo).index();
const porPagina = tabla.page.len();
const pagina = Math.floor(indice / porPagina);
tabla.page(pagina).draw('page');

setTimeout(function () {
    const visible = document.querySelector('#example tbody tr[data-equipo-id="' + idFila + '"]');
    if (!visible) return;
    visible.classList.add(cls);
    const color = accFila === 'crear' ? '#d4edda'
        : accFila === 'editar' ? '#fff3cd'
        : '#cfe2ff';
    visible.querySelectorAll('td').forEach(function (td) {
        td.style.backgroundColor = color;
    });
    visible.scrollIntoView({
    behavior: 'smooth',
    block: 'center',
    inline: 'nearest'
});
    setTimeout(function () {
        visible.querySelectorAll('td').forEach(function (td) {
            td.style.backgroundColor = '';
        });
    }, 3000);
}, 50);

    nodo.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
}

document.querySelectorAll('.btn-ver-equipo').forEach(function (a) {
    a.addEventListener('click', function () {
        const partes = a.getAttribute('href').split('/').filter(Boolean);
        sessionStorage.setItem('equipo_resaltado', partes[partes.length - 1]);
        sessionStorage.setItem('equipo_accion', 'ver');
    });
});

setTimeout(function () {
    cargarPaginaActual();
    setTimeout(pintarFilaEquipo, 400);
}, 200);

    document.querySelectorAll('.btn-ver-equipo').forEach(function (a) {
    a.addEventListener('click', function () {
        const partes = a.getAttribute('href').split('/').filter(Boolean);
        sessionStorage.setItem('equipo_resaltado', partes.pop());
        sessionStorage.setItem('equipo_accion', 'ver');
    });
});

}, 200);


    /*
     * =========================================================
     * ENTER GLOBAL DEL INDEX
     * =========================================================
     *
     * IMPORTANTE:
     * NO EXISTEN EVENTOS ENTER INDIVIDUALES.
     *
     * ESTE ÚNICO EVENTO CONTROLA ENTER
     * EN TODO EL INDEX.
     *
     */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key !== 'Enter') return;

            event.preventDefault();
            aplicarFiltros();

        }
    );

        /*
     * =========================================================
     * ATAJO DE TECLADO - REGISTRAR NUEVO
     * =========================================================
     *
     * TECLA:
     * +
     *
     * ABRE EL FORMULARIO "REGISTRAR NUEVO".
     *
     */

    document.addEventListener(
        'keydown',
        function (event) {

            /*
             * DETECTAR LA TECLA "+"
             */

            if (event.key !== '+') {
                return;
            }


            /*
             * NO EJECUTAR EL ATAJO SI EL USUARIO
             * ESTÁ ESCRIBIENDO EN UN CAMPO.
             */

            const elemento =
                event.target;

            const tipoElemento =
                elemento.tagName
                    ? elemento.tagName.toLowerCase()
                    : '';


            if (
                tipoElemento === 'input' ||
                tipoElemento === 'textarea' ||
                tipoElemento === 'select'
            ) {
                return;
            }


            /*
             * EVITAR EL COMPORTAMIENTO NORMAL
             * DE LA TECLA.
             */

            event.preventDefault();


            /*
             * BUSCAR EL ENLACE DE REGISTRAR NUEVO.
             */

            const botonRegistrar =
                document.querySelector(
                    'a[href*="/equipos/create"]'
                );


            /*
             * ABRIR REGISTRAR NUEVO.
             */

            if (botonRegistrar) {
                botonRegistrar.click();
            }
        }
    );
    console.log('RESALTAR', {
    flashId: @json(session('equipo_resaltado')),
    flashAcc: @json(session('equipo_accion')),
    filas: document.querySelectorAll('#example tbody tr[data-equipo-id]').length
});
}); /* FIN DEL LOAD */

window.pintarFilaEquipo = pintarFilaEquipo;


function confirmarEliminarFila(form) {
    const fila = form.closest('tr');
    Swal.fire({
        icon: 'warning',
        title: '¿Eliminar equipo?',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, eliminar',
        reverseButtons: true
    }).then(function (r) {
        if (!r.isConfirmed) return;
        if (!fila) { form.submit(); return; }
        fila.classList.add('fila-borrar');
        setTimeout(function () {
            fila.classList.add('saliendo');
            setTimeout(function () { form.submit(); }, 500);
        }, 700);
    });
}

window.addEventListener('pageshow', function () {
    if (typeof pintarFilaEquipo === 'function') {
        setTimeout(pintarFilaEquipo, 200);
    }
});
</script>