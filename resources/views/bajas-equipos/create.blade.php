@extends('layouts.app')

@section('template_title')
    Registrar baja administrativa
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-xl-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-1 fw-bold">
                        <i class="bi bi-box-arrow-up-right me-2 text-success"></i>
                        REGISTRAR BAJA ADMINISTRATIVA
                    </h5>
                    <small class="text-muted">
                        Registra la salida de un equipo de la institución.
                    </small>
                </div>

                <div class="card-body">
                    <div class="alert alert-warning" role="alert">
                        <strong>Importante:</strong>
                        esta acción cambiará la situación administrativa del equipo a
                        <strong>DE_BAJA</strong>. El equipo no se eliminará del inventario
                        ni se modificará su estado físico.
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>No se pudo registrar la baja.</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($equipos->isEmpty())
                        <div class="alert alert-info">
                            No hay equipos disponibles para registrar una baja administrativa.
                        </div>

                        <a href="{{ route('bajas-equipos.index') }}"
                           class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>
                            VOLVER AL HISTORIAL
                        </a>
                    @else
                        <form action="{{ route('bajas-equipos.store') }}"
                              method="POST"
                              id="form-baja-equipo">
                            @csrf

                            <div class="row g-3">
                                {{-- FILTRO POR TIPO --}}
                                <div class="col-12 col-md-4">
                                    <label for="filtro_tipo" class="form-label fw-semibold">
                                        Tipo de equipo
                                    </label>
                                    <select id="filtro_tipo" class="form-select">
                                        <option value="">TODOS</option>
                                        @foreach ($tiposEquipo as $tipo)
                                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
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

                                        <input type="hidden" name="equipo_id" id="equipo_id" value="{{ old('equipo_id') }}">

                                        <div id="lista_equipos"
                                             class="lista-equipos position-absolute w-100 bg-white border rounded shadow-sm"
                                             style="display:none; z-index:9999; max-height:240px; overflow-y:auto;">
                                        </div>
                                    </div>

                                    @error('equipo_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <div class="form-text">
                                        Solo se muestran equipos que actualmente figuran
                                        EN_INVENTARIO. La disponibilidad se volverá a validar al guardar.
                                    </div>

                                    <div id="equipo_seleccionado" class="mt-2 small text-success fw-semibold" style="display:none;"></div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="fecha" class="form-label fw-semibold">
                                        Fecha de salida <span class="text-danger">*</span>
                                    </label>

                                    <input type="date"
                                           name="fecha"
                                           id="fecha"
                                           class="form-control @error('fecha') is-invalid @enderror"
                                           value="{{ old('fecha', now()->format('Y-m-d')) }}"
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
                                           value="{{ old('destino') }}"
                                           placeholder="Institución, UGEL, almacén, etc."
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
                                           value="{{ old('quien_entrego') }}"
                                           placeholder="Nombre de quien entrega"
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
                                           value="{{ old('quien_recibio') }}"
                                           placeholder="Nombre de quien recibe"
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
                                              rows="4"
                                              placeholder="Motivo de la salida, reparación, transferencia u otros detalles">{{ old('observaciones') }}</textarea>

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

                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check2-circle me-1"></i>
                                    REGISTRAR BAJA
                                </button>
                            </div>
                        </form>
                    @endif
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
        // Si el usuario escribe, limpia la selección previa
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
        inputId.value = '';
        inputBuscar.value = '';
        seleccion.style.display = 'none';
        mostrarLista();
    });

    document.addEventListener('click', function (e) {
        if (!inputBuscar.contains(e.target) && !lista.contains(e.target)) {
            lista.style.display = 'none';
        }
    });

    // Restaurar selección si hay old()
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