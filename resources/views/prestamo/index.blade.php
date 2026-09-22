@extends('layouts.app')

@section('template_title')
    Préstamos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"> <div class="d-flex justify-content-between align-items-center flex-wrap gap-2"> <span id="card_title">PRÉSTAMOS</span>
    <div class="d-flex align-items-center gap-2 ms-auto">
        <a href="{{ route('prestamos.create') }}"
           id="btn_nuevo_prestamo"
           class="btn btn-primary btn-sm">
            Registrar Nuevo
        </a>

        <a href="{{ route('prestamos.export.excel') }}"
           class="btn btn-success btn-sm">
            <i class="fa-solid fa-file-excel"></i> EXCEL
        </a>

        <a href="{{ route('prestamos.export.pdf') }}"
           class="btn btn-danger btn-sm"
           target="_blank">
            <i class="fa-solid fa-file-pdf"></i> PDF
        </a>
    </div>
</div>

</div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <span id="mensaje_coincidencias" class="text-success fw-bold me-auto" style="visibility:hidden;">&nbsp;</span>
                            <button type="button" id="btn_toggle_filtros" class="btn btn-outline-success btn-sm ms-auto">
                                FILTROS <span id="badge_filtros" class="badge bg-success ms-1 d-none">0</span>
                            </button>
                        </div>
                        <div id="panel_filtros" class="border rounded p-3 mb-3 bg-light" style="display:none;">
                            <div class="row g-2">
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">SOLICITANTE</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_solicitante" class="form-control form-control-sm campo-mayusculas" list="lista_filtro_solicitante" placeholder="TODOS" autocomplete="off">
                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo" data-target="filtro_solicitante"><i class="fa-solid fa-xmark"></i></button>
                                    </div>
                                    <datalist id="lista_filtro_solicitante">
                                        @foreach ($filtroSolicitantes ?? [] as $nombre)
                                            <option value="{{ $nombre }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">CARGO</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_cargo" class="form-control form-control-sm campo-mayusculas" list="lista_filtro_cargo" placeholder="TODOS" autocomplete="off">
                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo" data-target="filtro_cargo"><i class="fa-solid fa-xmark"></i></button>
                                    </div>
                                    <datalist id="lista_filtro_cargo">
                                        @foreach ($filtroCargos ?? [] as $cargo)
                                            <option value="{{ $cargo }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">EQUIPO</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="filtro_equipo" class="form-control form-control-sm campo-mayusculas" list="lista_filtro_equipo" placeholder="NOMBRE O N.º SERIE (3 CAR.)" autocomplete="off">
                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo" data-target="filtro_equipo"><i class="fa-solid fa-xmark"></i></button>
                                    </div>
                                    <datalist id="lista_filtro_equipo"></datalist>
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">ESTADO</label>
                                    <div class="input-group input-group-sm">
                                        <select id="filtro_estado" class="form-select form-select-sm">
                                            <option value="">TODOS</option>
                                            <option value="ACTIVO">ACTIVO</option>
                                            <option value="TERMINADO">TERMINADO</option>
                                        </select>
                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo" data-target="filtro_estado"><i class="fa-solid fa-xmark"></i></button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">FECHA</label>
                                    <div class="input-group input-group-sm">
                                        <input type="date" id="filtro_fecha" class="form-control form-control-sm">
                                        <button type="button" id="btn_filtro_hoy" class="btn btn-outline-success btn-sm">HOY</button>
                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo" data-target="filtro_fecha"><i class="fa-solid fa-xmark"></i></button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">HORA INICIO</label>
                                    <input type="time" id="filtro_hora_inicio" class="form-control form-control-sm">
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-bold text-success">HORA FINAL</label>
                                    <input type="time" id="filtro_hora_fin" class="form-control form-control-sm">
                                </div>
                                <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                                    <button type="button" id="btn_aplicar_filtros" class="btn btn-success btn-sm">APLICAR</button>
                                    <button type="button" id="btn_limpiar_filtros" class="btn btn-outline-secondary btn-sm">LIMPIAR</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="text-center">Solicitante</th>
                                        <th class="text-center">Cargo</th>
                                        <th class="text-center">Equipos</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Hora inicio</th>
                                        <th class="text-center">Hora final</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center columna-acciones">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prestamos as $i => $prestamo)
                                        @php
    $nombreSol = trim(($prestamo->docente->apellidos ?? '') . ' ' . ($prestamo->docente->nombres ?? ''));
    $fechaIso = $prestamo->fecha ? \Carbon\Carbon::parse($prestamo->fecha)->format('Y-m-d') : '';
    $hIni = $prestamo->hora_inicio ? substr($prestamo->hora_inicio, 0, 5) : '';
    $hFin = $prestamo->hora_fin ? substr($prestamo->hora_fin, 0, 5) : '';
    $textoEquipos = collect($prestamo->prestamoEquipos)->map(function ($pe) {
        $eq = $pe->equipo;
        return trim(($eq->tipoEquipo->nombre ?? '') . ' ' . ($eq->marca ?? '') . ' ' . ($eq->num_serie ?? ''));
    })->implode(' | ');
                                        @endphp
                                        <tr data-prestamo-id="{{ $prestamo->id }}"
                                            data-solicitante="{{ strtoupper($nombreSol) }}"
                                            data-cargo="{{ strtoupper($prestamo->cargo ?? '') }}"
                                            data-equipos="{{ strtoupper($textoEquipos) }}"
                                            data-fecha="{{ $fechaIso }}"
                                            data-hora-inicio="{{ $hIni }}"
                                            data-hora-fin="{{ $hFin }}"
                                            data-estado="{{ strtoupper($prestamo->estado ?? '') }}">
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ strtoupper($nombreSol) ?: '-' }}</td>
                                            <td>{{ strtoupper($prestamo->cargo ?? '-') }}</td>
                                            <td>
                                                @forelse ($prestamo->prestamoEquipos as $prestamoEquipo)
                                                    <div class="mb-1">
                                                        {{ $prestamoEquipo->equipo->tipoEquipo->nombre ?? '' }}
                                                        {{ $prestamoEquipo->equipo->marca ?? '' }}
                                                        <small class="text-muted">N/S: {{ $prestamoEquipo->equipo->num_serie ?? '-' }}</small>
                                                    </div>
                                                @empty
                                                    —
                                                @endforelse
                                            </td>
                                            <td class="text-center">{{ $fechaIso ? \Carbon\Carbon::parse($fechaIso)->format('d-m-Y') : '-' }}</td>
                                            <td class="text-center">{{ $hIni ?: '-' }}</td>
                                            <td class="text-center">{{ $hFin ?: '—' }}</td>
                                            <td class="text-center">
                                                @if (($prestamo->estado ?? '') === 'ACTIVO')
                                                    <span class="badge bg-success">ACTIVO</span>
                                                @else
                                                    <span class="badge bg-secondary">TERMINADO</span>
                                                @endif
                                            </td>
                                            <td class="text-center columna-acciones">
                                                <div class="d-flex justify-content-center align-items-center gap-1">
                                                    <form action="{{ route('prestamos.destroy', $prestamo->id) }}" method="POST">
                                                        <a class="btn btn-info btn-accion btn-ver-prestamo" href="{{ route('prestamos.show', $prestamo->id) }}">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        <a class="btn btn-warning btn-accion" href="{{ route('prestamos.edit', $prestamo->id) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-accion" onclick="event.preventDefault(); confirmarEliminarPrestamo(this.closest('form'));">
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

    #example tbody td {
        vertical-align: middle !important;
    }

    .fila-crear td {
        background-color: #d4edda !important;
    }

    .fila-editar td {
        background-color: #fff3cd !important;
    }

    .fila-ver td {
        background-color: #cfe2ff !important;
    }
</style>

<script>
window.addEventListener('load', function () {
    if (typeof $ === 'undefined' || !$.fn.DataTable) return;
    const tabla = $('#example').DataTable();
    const STORAGE_KEY = 'prestamos_filtros_estado';
    const panel = document.getElementById('panel_filtros');
    const btnToggle = document.getElementById('btn_toggle_filtros');
    const badge = document.getElementById('badge_filtros');
    const msg = document.getElementById('mensaje_coincidencias');
    const listaEquipo = document.getElementById('lista_filtro_equipo');
    const campos = {
        solicitante: document.getElementById('filtro_solicitante'),
        cargo: document.getElementById('filtro_cargo'),
        equipo: document.getElementById('filtro_equipo'),
        estado: document.getElementById('filtro_estado'),
        fecha: document.getElementById('filtro_fecha'),
        horaInicio: document.getElementById('filtro_hora_inicio'),
        horaFin: document.getElementById('filtro_hora_fin')
    };
    function val(el) { return el ? String(el.value || '').trim().toUpperCase() : ''; }
    function hora(el) { return (el && el.value) ? el.value : ''; }
    function filtrosActivos() {
        let n = 0;
        Object.keys(campos).forEach(function (k) {
            if (!campos[k]) return;
            if (campos[k].value && String(campos[k].value).trim() !== '') n++;
        });
        return n;
    }
    function actualizarBadge() {
        if (!badge) return;
        const n = filtrosActivos();
        badge.textContent = n;
        badge.classList.toggle('d-none', n === 0);
    }
    function mostrarCoincidencias() {
        if (!msg) return;
        if (filtrosActivos() === 0) { msg.style.visibility = 'hidden'; msg.textContent = '\xa0'; return; }
        const n = tabla.page.info().recordsDisplay;
        msg.style.visibility = 'visible';
        msg.textContent = 'SE ENCONTRARON: ' + n + ' COINCIDENCIA' + (n === 1 ? '' : 'S');
    }
    function guardarFiltros() {
        const estado = { panel: panel && panel.style.display !== 'none' };
        Object.keys(campos).forEach(function (k) { estado[k] = campos[k] ? campos[k].value : ''; });
        localStorage.setItem(STORAGE_KEY, JSON.stringify(estado));
    }
    function restaurarFiltros() {
        const raw = localStorage.getItem(STORAGE_KEY);
        if (!raw) return;
        try {
            const estado = JSON.parse(raw);
            Object.keys(campos).forEach(function (k) {
                if (campos[k] && estado[k] != null) campos[k].value = estado[k];
            });
            if (panel && estado.panel) panel.style.display = 'block';
        } catch (e) {}
    }
    function actualizarSugerenciasEquipo() {
        if (!listaEquipo || !campos.equipo) return;
        const q = val(campos.equipo);
        listaEquipo.innerHTML = '';
        if (q.length < 3) return;
        const vistos = {};
        tabla.rows({ page: 'all' }).every(function () {
            const tr = this.node();
            const txt = (tr && tr.getAttribute('data-equipos')) || '';
            if (txt.includes(q) && !vistos[txt]) {
                vistos[txt] = true;
                const op = document.createElement('option');
                op.value = txt;
                listaEquipo.appendChild(op);
            }
        });
    }
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        if (!settings.nTable || settings.nTable.id !== 'example') return true;
        const fila = tabla.row(dataIndex).node();
        if (!fila) return true;
        const sol = val(campos.solicitante);
        const car = val(campos.cargo);
        const eq = val(campos.equipo);
        const est = val(campos.estado);
        const fec = campos.fecha ? campos.fecha.value : '';
        const hi = hora(campos.horaInicio);
        const hf = hora(campos.horaFin);
        if (sol && !(fila.getAttribute('data-solicitante') || '').includes(sol)) return false;
        if (car && !(fila.getAttribute('data-cargo') || '').includes(car)) return false;
        if (eq && !(fila.getAttribute('data-equipos') || '').includes(eq)) return false;
        if (est && (fila.getAttribute('data-estado') || '') !== est) return false;
        if (fec && (fila.getAttribute('data-fecha') || '') !== fec) return false;
        const filaHi = fila.getAttribute('data-hora-inicio') || '';
        const filaHf = fila.getAttribute('data-hora-fin') || '';
        const ref = filaHi || filaHf;
        if (hi && ref && ref < hi) return false;
        if (hf && ref && ref > hf) return false;
        return true;
    });
    function aplicarFiltros() {
        const hi = hora(campos.horaInicio);
        const hf = hora(campos.horaFin);
        if (hi && hf && hf < hi) {
            if (typeof toastr !== 'undefined') toastr.error('LA HORA FINAL NO PUEDE SER MENOR QUE LA HORA INICIO.');
            return;
        }
        guardarFiltros();
        actualizarBadge();
        tabla.draw();
        mostrarCoincidencias();
    }

    function aplicarYScroll() {
        aplicarFiltros();
        const tablaEl = document.getElementById('example');
        if (tablaEl) tablaEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    function limpiarFiltros() {
        Object.keys(campos).forEach(function (k) { if (campos[k]) campos[k].value = ''; });
        localStorage.removeItem(STORAGE_KEY);
        actualizarBadge();
        tabla.draw();
        mostrarCoincidencias();
    }
    if (btnToggle) btnToggle.addEventListener('click', function () {
        panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
    });
    document.getElementById('btn_aplicar_filtros').addEventListener('click', aplicarYScroll);
    document.getElementById('btn_limpiar_filtros').addEventListener('click', limpiarFiltros);
    document.getElementById('btn_filtro_hoy').addEventListener('click', function () {
        const d = new Date();
        campos.fecha.value = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
        aplicarFiltros();
    });
    document.querySelectorAll('.btn-limpiar-campo').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const el = document.getElementById(btn.getAttribute('data-target'));
            if (el) el.value = '';
            aplicarFiltros();
        });
    });
    if (campos.equipo) campos.equipo.addEventListener('input', function () {
        this.value = this.value.toUpperCase();
        actualizarSugerenciasEquipo();
    });
    document.querySelectorAll('.campo-mayusculas').forEach(function (el) {
        el.addEventListener('input', function () { this.value = this.value.toUpperCase(); });
    });
    document.addEventListener('keydown', function (e) {
        const tag = e.target && e.target.tagName;
        if (tag && ['INPUT', 'SELECT', 'TEXTAREA'].includes(tag)) {
            if (e.key === 'Enter') { e.preventDefault(); aplicarYScroll(); }
            return;
        }
        if (e.key === '+' || e.key === '=') {
            e.preventDefault();
            document.getElementById('btn_nuevo_prestamo').click();
        }
        if (e.key === 'f' || e.key === 'F') {
            e.preventDefault();
            btnToggle.click();
            campos.solicitante.focus();
        }
    });

    Object.keys(campos).forEach(function (k) {
        if (!campos[k]) return;
        campos[k].addEventListener('input', aplicarFiltros);
        campos[k].addEventListener('change', aplicarFiltros);
    });

    restaurarFiltros();
    actualizarBadge();
    if (filtrosActivos()) aplicarFiltros();

        const PAG_KEY = 'prestamos_pagina';

    tabla.on('page.dt', function () {
        localStorage.setItem(PAG_KEY, tabla.page());
    });

    const pagGuardada = parseInt(localStorage.getItem(PAG_KEY) || '0', 10);
    if (!isNaN(pagGuardada)) {
        tabla.page(pagGuardada).draw('page');
    }

    function pintarFilaPrestamo() {
        const idFila = @json(session('prestamo_resaltado')) || sessionStorage.getItem('prestamo_resaltado');
        const accFila = @json(session('prestamo_accion')) || sessionStorage.getItem('prestamo_accion');
        sessionStorage.removeItem('prestamo_resaltado');
        sessionStorage.removeItem('prestamo_accion');
        if (!idFila || !accFila) return;

        let nodo = null;
        tabla.rows({ page: 'all' }).every(function () {
            const tr = this.node();
            if (tr && String(tr.getAttribute('data-prestamo-id')) === String(idFila)) nodo = tr;
        });
        if (!nodo) return;

        const pagina = Math.floor(tabla.row(nodo).index() / tabla.page.len());
        tabla.page(pagina).draw('page');
        localStorage.setItem(PAG_KEY, pagina);

        setTimeout(function () {
            const visible = document.querySelector('#example tbody tr[data-prestamo-id="' + idFila + '"]');
            if (!visible) return;
            const color = accFila === 'crear' ? '#d4edda'
                : accFila === 'editar' ? '#fff3cd' : '#cfe2ff';
            visible.querySelectorAll('td').forEach(function (td) { td.style.backgroundColor = color; });
            visible.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(function () {
                visible.querySelectorAll('td').forEach(function (td) { td.style.backgroundColor = ''; });
            }, 4000);
        }, 50);
    }

    document.querySelectorAll('.btn-ver-prestamo').forEach(function (a) {
        a.addEventListener('click', function () {
            const partes = a.getAttribute('href').split('/').filter(Boolean);
            sessionStorage.setItem('prestamo_resaltado', partes.pop());
            sessionStorage.setItem('prestamo_accion', 'ver');
        });
    });

    setTimeout(pintarFilaPrestamo, 300);
    window.pintarFilaPrestamo = pintarFilaPrestamo;

});

function confirmarEliminarPrestamo(form) {
    if (!form) return;
    const fila = form.closest('tr');

    function enviar() {
        if (fila) {
            fila.querySelectorAll('td').forEach(function (td) {
                td.style.backgroundColor = '#f8d7da';
            });
            fila.style.transition = 'opacity 0.4s';
            setTimeout(function () { fila.style.opacity = '0'; }, 200);
            setTimeout(function () { form.submit(); }, 700);
        } else {
            form.submit();
        }
    }

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'warning',
            title: '¿Eliminar préstamo?',
            text: 'Esta acción no se puede deshacer.',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then(function (r) {
            if (r.isConfirmed) enviar();
        });
    } else if (confirm('¿Eliminar préstamo?')) {
        enviar();
    }
}

window.addEventListener('pageshow', function () {
    if (typeof pintarFilaPrestamo === 'function') setTimeout(pintarFilaPrestamo, 200);
});

</script>
