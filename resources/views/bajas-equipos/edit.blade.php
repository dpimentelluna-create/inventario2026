@extends('layouts.app')

@section('template_title')
    Editar baja administrativa
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-xl-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-1 fw-bold">
                        <i class="bi bi-pencil-square me-2 text-primary"></i>
                        EDITAR BAJA ADMINISTRATIVA
                    </h5>
                    <small class="text-muted">
                        Registro #{{ $baja->id }} — Corrige datos o cambia el equipo si fue un error.
                    </small>
                </div>

                <div class="card-body">
                    <div class="alert alert-info" role="alert">
                        Si cambias el equipo, el anterior volverá automáticamente a <strong>EN_INVENTARIO</strong>
                        y el nuevo pasará a <strong>DE_BAJA</strong>.
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>No se pudo actualizar la baja.</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('bajas-equipos.update', $baja->id) }}"
                          method="POST"
                          id="form-baja-equipo">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            {{-- FILTRO POR TIPO --}}
                            <div class="col-12 col-md-4">
                                <label for="filtro_tipo" class="form-label fw-semibold">
                                    Tipo de equipo
                                </label>
                                <select id="filtro_tipo" class="form-select">
                                    <option value="">TODOS</option>
                                    @foreach ($tiposEquipo as $tipo)
                                        <option value="{{ $tipo->id }}"
                                            @selected(old('tipo_filtro', $baja->equipo->tipo_equipo_id) == $tipo->id)>
                                            {{ $tipo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Filtra la lista de equipos.</div>
                            </div>

                            {{-- COMBOBOX HÍBRIDO DE EQUIPO --}}
                            <div class="col-12 col-md-8">
                                <label for="buscar_equipo" class="form-label fw-semibold">
                                    Equipo <span class="text-danger">*</span>
                                </label>

                                <div class="position-relative">
                                    <input type="text"
                                           id="buscar_equipo"
                                           class="form-control campo-mayusculas @error('equipo_id') is-invalid @enderror"
                                           placeholder="Buscar por ID, tipo, serie, marca, modelo o ubicación..."
                                           autocomplete="off">

                                    <input type="hidden" name="equipo_id" id="equipo_id"
                                           value="{{ old('equipo_id', $baja->equipo_id) }}">

                                    <div id="lista_equipos"
                                         class="lista-equipos position-absolute w-100 bg-white border rounded shadow-sm"
                                         style="display:none; z-index:9999; max-height:240px; overflow-y:auto;">
                                    </div>
                                </div>

                                @error('equipo_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <div class="form-text">
                                    Puedes mantener el equipo actual o elegir otro que esté EN_INVENTARIO.
                                </div>

                                <div id="equipo_seleccionado" class="mt-2 small text-success fw-semibold"></div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="fecha" class="form-label fw-semibold">
                                    Fecha de salida <span class="text-danger">*</span>
                                </label>

                                <input type="date"
                                       name="fecha"
                                       id="fecha"
                                       class="form-control @error('fecha') is-invalid @enderror"
                                       value="{{ old('fecha', $baja->fecha ? \Illuminate\Support\Carbon::parse($baja->fecha)->format('Y-m-d') : '') }}"
                                       required>

                                @error('fecha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="destino" class="form-label fw-semibold">
                                    Destino <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       name="destino"
                                       id="destino"
                                       class="form-control campo-mayusculas @error('destino') is-invalid @enderror"
                                       maxlength="150"
                                       value="{{ old('destino', $baja->destino) }}"
                                       required>

                                @error('destino')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="quien_entrego" class="form-label fw-semibold">
                                    Quién entrega <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       name="quien_entrego"
                                       id="quien_entrego"
                                       class="form-control campo-mayusculas @error('quien_entrego') is-invalid @enderror"
                                       maxlength="150"
                                       value="{{ old('quien_entrego', $baja->quien_entrego) }}"
                                       required>

                                @error('quien_entrego')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="quien_recibio" class="form-label fw-semibold">
                                    Quién recibe <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       name="quien_recibio"
                                       id="quien_recibio"
                                       class="form-control campo-mayusculas @error('quien_recibio') is-invalid @enderror"
                                       maxlength="150"
                                       value="{{ old('quien_recibio', $baja->quien_recibio) }}"
                                       required>

                                @error('quien_recibio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="observaciones" class="form-label fw-semibold">
                                    Observaciones
                                </label>

                                <textarea name="observaciones"
                                          id="observaciones"
                                          class="form-control campo-mayusculas @error('observaciones') is-invalid @enderror"
                                          rows="4">{{ old('observaciones', $baja->observaciones) }}</textarea>

                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('bajas-equipos.index') }}"
                               class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i>
                                CANCELAR
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check2-circle me-1"></i>
                                GUARDAR CAMBIOS
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const equipos = @json($equiposForJs);

    const inputBuscar = document.getElementById('buscar_equipo');
    const inputId = document.getElementById('equipo_id');
    const lista = document.getElementById('lista_equipos');
    const filtroTipo = document.getElementById('filtro_tipo');
    const seleccion = document.getElementById('equipo_seleccionado');

    let indiceActivo = -1;

    function etiquetaEquipo(eq) {
        let txt = `ID ${eq.id} — ${eq.tipo} — ${eq.marca} ${eq.modelo}`;
        if (eq.serie) txt += ` — Serie: ${eq.serie}`;
        if (eq.ubicacion) txt += ` — ${eq.ubicacion}`;
        return txt.trim();
    }

    function filtrar() {
        const texto = (inputBuscar.value || '').trim().toUpperCase();
        const tipoId = filtroTipo.value;

        return equipos.filter(function (eq) {
            if (tipoId && String(eq.tipo_id) !== String(tipoId)) return false;
            if (!texto) return true;

            const campos = [
                String(eq.id),
                eq.tipo,
                eq.marca,
                eq.modelo,
                eq.serie,
                eq.ubicacion
            ].map(c => String(c || '').toUpperCase());

            return campos.some(c => c.includes(texto));
        });
    }

    function mostrarLista() {
        const resultados = filtrar();
        lista.innerHTML = '';
        indiceActivo = -1;

        if (resultados.length === 0) {
            lista.innerHTML = '<div class="px-3 py-2 text-muted">No se encontraron equipos</div>';
            lista.style.display = 'block';
            return;
        }

        resultados.slice(0, 50).forEach(function (eq) {
            const op = document.createElement('div');
            op.className = 'px-3 py-2 opcion-equipo';
            op.style.cursor = 'pointer';
            op.textContent = etiquetaEquipo(eq);
            op.dataset.id = eq.id;
            op.addEventListener('mousedown', function (e) {
                e.preventDefault();
                elegir(eq);
            });
            lista.appendChild(op);
        });

        lista.style.display = 'block';
    }

    function elegir(eq) {
        inputId.value = eq.id;
        inputBuscar.value = etiquetaEquipo(eq);
        seleccion.textContent = 'Seleccionado: ' + etiquetaEquipo(eq);
        seleccion.style.display = 'block';
        lista.style.display = 'none';
        inputBuscar.classList.remove('is-invalid');
    }

    function itemsLista() {
        return Array.from(lista.querySelectorAll('.opcion-equipo'));
    }

    function pintarActivo() {
        const items = itemsLista();
        items.forEach(function (el, i) {
            el.style.backgroundColor = i === indiceActivo ? '#d1e7dd' : '';
        });
        const act = items[indiceActivo];
        if (act) act.scrollIntoView({ block: 'nearest' });
    }

    inputBuscar.addEventListener('focus', mostrarLista);
    inputBuscar.addEventListener('input', function () {
        if (inputId.value) {
            const actual = equipos.find(e => String(e.id) === String(inputId.value));
            if (actual && inputBuscar.value !== etiquetaEquipo(actual)) {
                inputId.value = '';
                seleccion.style.display = 'none';
            }
        }
        mostrarLista();
    });
    inputBuscar.addEventListener('click', mostrarLista);

    inputBuscar.addEventListener('keydown', function (e) {
        const items = itemsLista();
        const visible = lista.style.display !== 'none' && items.length;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (!visible) mostrarLista();
            indiceActivo = Math.min(indiceActivo + 1, itemsLista().length - 1);
            pintarActivo();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            indiceActivo = Math.max(indiceActivo - 1, 0);
            pintarActivo();
        } else if (e.key === 'Enter' && visible && indiceActivo >= 0) {
            e.preventDefault();
            const id = itemsLista()[indiceActivo].dataset.id;
            const eq = equipos.find(x => String(x.id) === String(id));
            if (eq) elegir(eq);
        } else if (e.key === 'Escape') {
            lista.style.display = 'none';
        }
    });

    filtroTipo.addEventListener('change', function () {
        // No limpiar si el equipo actual coincide con el tipo
        const actual = equipos.find(e => String(e.id) === String(inputId.value));
        if (!actual || String(actual.tipo_id) !== String(filtroTipo.value) && filtroTipo.value) {
            inputId.value = '';
            inputBuscar.value = '';
            seleccion.style.display = 'none';
        }
        mostrarLista();
    });

    document.addEventListener('click', function (e) {
        if (!inputBuscar.contains(e.target) && !lista.contains(e.target)) {
            lista.style.display = 'none';
        }
    });

    // Restaurar selección inicial
    if (inputId.value) {
        const eq = equipos.find(e => String(e.id) === String(inputId.value));
        if (eq) {
            inputBuscar.value = etiquetaEquipo(eq);
            seleccion.textContent = 'Seleccionado: ' + etiquetaEquipo(eq);
            seleccion.style.display = 'block';
        }
    }
});
</script>

@endsection