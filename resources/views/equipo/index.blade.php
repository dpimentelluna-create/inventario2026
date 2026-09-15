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

                        <div class="d-flex justify-content-end mb-2">
                            <button type="button" id="btn_toggle_filtros" class="btn btn-outline-success btn-sm">
                                FILTROS <span id="badge_filtros" class="badge bg-success ms-1 d-none">0</span>
                            </button>
                        </div>

                        <div id="panel_filtros" class="border rounded p-3 mb-3 bg-light" style="display:none;">
                            <div class="row g-2">
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">TIPO</label>
                                    <input type="text" id="filtro_tipo" class="form-control form-control-sm"
                                        list="lista_filtro_tipo" placeholder="TODOS" autocomplete="off">
                                    <datalist id="lista_filtro_tipo">
                                        @foreach ($filtroTipos as $nombre)
                                            <option value="{{ $nombre }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">MARCA</label>
                                    <input type="text" id="filtro_marca" class="form-control form-control-sm"
                                        list="lista_filtro_marca" placeholder="ELIJA UN TIPO" autocomplete="off" disabled>
                                    <datalist id="lista_filtro_marca"></datalist>
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">MODELO</label>
                                    <input type="text" id="filtro_modelo" class="form-control form-control-sm"
                                        list="lista_filtro_modelo" placeholder="ELIJA UNA MARCA" autocomplete="off"
                                        disabled>
                                    <datalist id="lista_filtro_modelo"></datalist>
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">UBICACIÓN</label>
                                    <input type="text" id="filtro_ubicacion" class="form-control form-control-sm"
                                        list="lista_filtro_ubicacion" placeholder="TODAS" autocomplete="off">
                                    <datalist id="lista_filtro_ubicacion">
                                        @foreach ($filtroUbicaciones as $nombre)
                                            <option value="{{ $nombre }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">ESTADO</label>
                                    <select id="filtro_estado" class="form-select form-select-sm">
                                        <option value="">TODOS</option>
                                        <option value="BUENO">BUENO</option>
                                        <option value="REGULAR">REGULAR</option>
                                        <option value="MALOGRADO">MALOGRADO</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">N.º SERIE</label>
                                    <input type="text" id="filtro_serie"
                                        class="form-control form-control-sm campo-mayusculas" list="lista_filtro_serie"
                                        placeholder="ESCRIBA 3 CARACTERES" autocomplete="off">
                                    <datalist id="lista_filtro_serie"></datalist>
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">FECHA</label>
                                    <div class="d-flex gap-1">
                                        <input type="date" id="filtro_fecha" class="form-control form-control-sm">
                                        <button type="button" id="btn_filtro_hoy"
                                            class="btn btn-outline-success btn-sm">HOY</button>
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
                                                                <tr>
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
                                                                                <a class="btn btn-info btn-accion"
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
                                                                                    onclick="event.preventDefault(); confirmarEliminar(this.closest('form'));">
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
</style>

<script>
window.addEventListener('load', function () {
    if (typeof $ === 'undefined' || !$.fn.DataTable) return;
    const tabla = $('#example').DataTable();

    const panel = document.getElementById('panel_filtros');
    const btnToggle = document.getElementById('btn_toggle_filtros');
    const badge = document.getElementById('badge_filtros');
    const inputTipo = document.getElementById('filtro_tipo');
    const inputMarca = document.getElementById('filtro_marca');
    const inputModelo = document.getElementById('filtro_modelo');
    const inputSerie = document.getElementById('filtro_serie');
    const inputFecha = document.getElementById('filtro_fecha');
    const listaMarca = document.getElementById('lista_filtro_marca');
    const listaModelo = document.getElementById('lista_filtro_modelo');
    const listaSerie = document.getElementById('lista_filtro_serie');

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

    function val(id) {
        const el = document.getElementById(id);
        return el ? el.value.trim().toUpperCase() : '';
    }
    function fechaFiltro() {
        return inputFecha ? inputFecha.value : '';
    }
    function llenarLista(datalist, valores) {
        if (!datalist) return;
        datalist.innerHTML = '';
        Array.from(valores).sort().forEach(function (v) {
            if (!v || v === '-') return;
            const op = document.createElement('option');
            op.value = v;
            datalist.appendChild(op);
        });
    }
    function setBloqueo(el, bloqueado, placeholder) {
        if (!el) return;
        el.disabled = bloqueado;
        el.classList.toggle('bg-light', bloqueado);
        if (bloqueado) el.value = '';
        if (placeholder) el.placeholder = placeholder;
    }

    function actualizarEncadenados() {
        const tipo = val('filtro_tipo');
        const marca = val('filtro_marca');

        if (!tipo) {
            setBloqueo(inputMarca, true, 'ELIJA UN TIPO');
            setBloqueo(inputModelo, true, 'ELIJA UNA MARCA');
            llenarLista(listaMarca, []);
            llenarLista(listaModelo, []);
            return;
        }

        const marcas = new Set();
        filas.forEach(function (f) {
            if (f.tipo.indexOf(tipo) !== -1) marcas.add(f.marca);
        });
        setBloqueo(inputMarca, false, 'TODAS');
        llenarLista(listaMarca, marcas);

        if (!marca) {
            setBloqueo(inputModelo, true, 'ELIJA UNA MARCA');
            llenarLista(listaModelo, []);
            return;
        }

        const modelos = new Set();
        filas.forEach(function (f) {
            if (f.tipo.indexOf(tipo) !== -1 && f.marca.indexOf(marca) !== -1) modelos.add(f.modelo);
        });
        setBloqueo(inputModelo, false, 'TODOS');
        llenarLista(listaModelo, modelos);
    }

    function actualizarSeries() {
        if (!inputSerie || !listaSerie) return;
        const q = inputSerie.value.trim().toUpperCase();
        listaSerie.innerHTML = '';
        if (q.length < 3) return;
        const vistos = new Set();
        filas.forEach(function (f) {
            if (f.serie.indexOf(q) !== -1 && !vistos.has(f.serie)) {
                vistos.add(f.serie);
                const op = document.createElement('option');
                op.value = f.serie;
                listaSerie.appendChild(op);
            }
        });
    }

    function contarFiltros() {
        let n = 0;
        ['filtro_tipo', 'filtro_marca', 'filtro_modelo', 'filtro_ubicacion', 'filtro_estado', 'filtro_serie'].forEach(function (id) {
            if (val(id)) n++;
        });
        if (fechaFiltro()) n++;
        return n;
    }
    function actualizarBadge() {
        const n = contarFiltros();
        if (!badge) return;
        badge.textContent = n;
        badge.classList.toggle('d-none', n === 0);
    }

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        if (settings.nTable.id !== 'example') return true;
        const tipo = val('filtro_tipo');
        const marca = val('filtro_marca');
        const modelo = val('filtro_modelo');
        const ubicacion = val('filtro_ubicacion');
        const estado = val('filtro_estado');
        const serie = val('filtro_serie');
        const fecha = fechaFiltro();
        if (tipo && String(data[1]).toUpperCase().indexOf(tipo) === -1) return false;
        if (serie && String(data[2]).toUpperCase().indexOf(serie) === -1) return false;
        if (marca && String(data[3]).toUpperCase().indexOf(marca) === -1) return false;
        if (modelo && String(data[4]).toUpperCase().indexOf(modelo) === -1) return false;
        if (estado && String(data[5]).toUpperCase() !== estado) return false;
        if (ubicacion && String(data[6]).toUpperCase().indexOf(ubicacion) === -1) return false;
        if (fecha) {
            const nodo = tabla.row(dataIndex).node();
            const iso = nodo && nodo.querySelector('[data-fecha]')
                ? nodo.querySelector('[data-fecha]').getAttribute('data-fecha') : '';
            if (iso !== fecha) return false;
        }
        return true;
    });

    if (btnToggle && panel) {
        btnToggle.addEventListener('click', function () {
            panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
        });
    }

    if (inputTipo) inputTipo.addEventListener('input', function () {
        this.value = this.value.toUpperCase();
        actualizarEncadenados();
    });
    if (inputMarca) inputMarca.addEventListener('input', function () {
        this.value = this.value.toUpperCase();
        actualizarEncadenados();
    });
    if (inputSerie) inputSerie.addEventListener('input', function () {
        this.value = this.value.toUpperCase();
        actualizarSeries();
    });

    /*
 * =========================================================
 * APLICAR FILTROS CON ENTER
 * =========================================================
 */

    [
        'filtro_tipo',
        'filtro_marca',
        'filtro_modelo',
        'filtro_ubicacion',
        'filtro_estado',
        'filtro_serie',
        'filtro_fecha'
    ].forEach(function (id) {

        const campo = document.getElementById(id);

        if (!campo) return;

        campo.addEventListener('keydown', function (event) {

            if (event.key === 'Enter') {

                event.preventDefault();

                aplicarFiltros();
            }

        });

    });

    document.getElementById('btn_filtro_hoy')?.addEventListener('click', function () {
        if (!inputFecha) return;
        const d = new Date();
        inputFecha.value = d.getFullYear() + '-' +
            String(d.getMonth() + 1).padStart(2, '0') + '-' +
            String(d.getDate()).padStart(2, '0');
    });

    function aplicarFiltros() {
        actualizarBadge();
        tabla.draw();

        setTimeout(function () {

            const tablaElement =
                document.getElementById('example');

            if (tablaElement) {
                tablaElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }

        }, 100);
    }

    document.getElementById('btn_aplicar_filtros')?.addEventListener(
        'click',
        aplicarFiltros
    );

    document.getElementById('btn_limpiar_filtros')?.addEventListener('click', function () {
        ['filtro_tipo', 'filtro_marca', 'filtro_modelo', 'filtro_ubicacion', 'filtro_serie', 'filtro_fecha'].forEach(function (id) {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
        const est = document.getElementById('filtro_estado');
        if (est) est.value = '';
        actualizarEncadenados();
        if (listaSerie) listaSerie.innerHTML = '';
        actualizarBadge();
        tabla.draw();
    });

    actualizarEncadenados();
});
</script>
