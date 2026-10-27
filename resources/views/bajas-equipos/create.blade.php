@extends('layouts.app')

@section('template_title')
    Registrar Baja Administrativa
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
                    <div class="alert alert-warning">
                        <strong>Importante:</strong>
                        el equipo cambiará a <strong>DE_BAJA</strong>.
                        No se eliminará del inventario ni se modificará su estado físico.
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
                           class="btn btn-outline-secondary"
                           onclick="return confirm('¿Deseas salir? Los datos no guardados se perderán.');">
                            CANCELAR
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
                                            <option value="{{ $tipo->id }}">
                                                {{ $tipo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">
                                        Solo aparecen los tipos incluidos en la lista del controlador.
                                    </div>
                                </div>

                                {{-- COMBOBOX HÍBRIDO --}}
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

                                        <input type="hidden"
                                               name="equipo_id"
                                               id="equipo_id"
                                               value="{{ old('equipo_id') }}">

                                        <div id="lista_equipos"
                                             class="position-absolute w-100 bg-white border rounded shadow-sm"
                                             style="display:none; z-index:9999; max-height:260px; overflow-y:auto;">
                                        </div>
                                    </div>

                                    @error('equipo_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <div class="form-text">
                                        Busca un equipo y selecciónalo de los resultados.
                                        Solo se permiten equipos disponibles en inventario.
                                    </div>

                                    <div id="equipo_seleccionado"
                                         class="mt-2 small text-success fw-semibold"
                                         style="display:none;"></div>
                                </div>

                                {{-- FECHA --}}
                                <div class="col-12 col-md-6">
                                    <label for="fecha" class="form-label fw-semibold">
                                        Fecha de salida *
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

                                {{-- DESTINO --}}
                                <div class="col-12 col-md-6">
                                    <label for="destino" class="form-label fw-semibold">
                                        Destino *
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

                                {{-- QUIÉN ENTREGA --}}
                                @php
                                    $entregantesOld = old('entregantes', [
                                        ['nombre' => '', 'cargo' => ''],
                                    ]);
                                    if (empty($entregantesOld)) {
                                        $entregantesOld = [['nombre' => '', 'cargo' => '']];
                                    }
                                @endphp

                                <div class="col-12">
                                    <div class="border rounded p-3">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                            <div>
                                                <h6 class="fw-bold mb-1">QUIÉN ENTREGA</h6>
                                                <small class="text-muted">
                                                    Registra al menos una persona responsable de la entrega.
                                                </small>
                                            </div>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-success"
                                                    data-agregar-integrante="entregantes">
                                                <i class="bi bi-plus-circle me-1"></i>
                                                AGREGAR PERSONA
                                            </button>
                                        </div>

                                        <div id="lista-entregantes">
                                            @foreach ($entregantesOld as $i => $persona)
                                                <div class="row g-2 mb-3 integrante-row">
                                                    <div class="col-12 col-md-5">
                                                        <label class="form-label">Nombre *</label>
                                                        <input type="text"
                                                               name="entregantes[{{ $i }}][nombre]"
                                                               class="form-control campo-mayusculas"
                                                               maxlength="150"
                                                               value="{{ $persona['nombre'] ?? '' }}"
                                                               required>
                                                    </div>
                                                    <div class="col-12 col-md-5">
                                                        <label class="form-label">Cargo *</label>
                                                        <input type="text"
                                                               name="entregantes[{{ $i }}][cargo]"
                                                               class="form-control campo-mayusculas"
                                                               maxlength="150"
                                                               value="{{ $persona['cargo'] ?? '' }}"
                                                               required>
                                                    </div>
                                                    <div class="col-12 col-md-2 d-flex align-items-end">
                                                        <button type="button"
                                                                class="btn btn-outline-danger w-100"
                                                                data-quitar-integrante
                                                                @disabled(count($entregantesOld) === 1)>
                                                            <i class="bi bi-trash"></i> QUITAR
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- QUIÉN RECIBE --}}
                                @php
                                    $receptoresOld = old('receptores', [
                                        ['nombre' => '', 'cargo' => ''],
                                    ]);
                                    if (empty($receptoresOld)) {
                                        $receptoresOld = [['nombre' => '', 'cargo' => '']];
                                    }
                                @endphp

                                <div class="col-12">
                                    <div class="border rounded p-3">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                            <div>
                                                <h6 class="fw-bold mb-1">QUIÉN RECIBE</h6>
                                                <small class="text-muted">
                                                    Registra al menos una persona responsable de recibir el equipo.
                                                </small>
                                            </div>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-success"
                                                    data-agregar-integrante="receptores">
                                                <i class="bi bi-plus-circle me-1"></i>
                                                AGREGAR PERSONA
                                            </button>
                                        </div>

                                        <div id="lista-receptores">
                                            @foreach ($receptoresOld as $i => $persona)
                                                <div class="row g-2 mb-3 integrante-row">
                                                    <div class="col-12 col-md-5">
                                                        <label class="form-label">Nombre *</label>
                                                        <input type="text"
                                                               name="receptores[{{ $i }}][nombre]"
                                                               class="form-control campo-mayusculas"
                                                               maxlength="150"
                                                               value="{{ $persona['nombre'] ?? '' }}"
                                                               required>
                                                    </div>
                                                    <div class="col-12 col-md-5">
                                                        <label class="form-label">Cargo *</label>
                                                        <input type="text"
                                                               name="receptores[{{ $i }}][cargo]"
                                                               class="form-control campo-mayusculas"
                                                               maxlength="150"
                                                               value="{{ $persona['cargo'] ?? '' }}"
                                                               required>
                                                    </div>
                                                    <div class="col-12 col-md-2 d-flex align-items-end">
                                                        <button type="button"
                                                                class="btn btn-outline-danger w-100"
                                                                data-quitar-integrante
                                                                @disabled(count($receptoresOld) === 1)>
                                                            <i class="bi bi-trash"></i> QUITAR
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- OBSERVACIONES --}}
                                <div class="col-12">
                                    <label for="observaciones" class="form-label fw-semibold">
                                        Observaciones
                                    </label>
                                    <textarea name="observaciones"
                                              id="observaciones"
                                              class="form-control campo-mayusculas @error('observaciones') is-invalid @enderror"
                                              rows="4"
                                              placeholder="Motivo de la salida, transferencia u otros detalles">{{ old('observaciones') }}</textarea>
                                    @error('observaciones')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('bajas-equipos.index') }}"
                                   class="btn btn-outline-secondary"
                                   onclick="return confirm('¿Deseas cancelar el registro? Los datos no guardados se perderán.');">
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
    // DATOS DEL COMBOBOX HÍBRIDO: el controlador debe enviar esta variable.
    const equipos = @json($equiposForJs ?? []);
    const filtroTipo = document.getElementById('filtro_tipo');
    const inputBuscar = document.getElementById('buscar_equipo');
    const inputEquipoId = document.getElementById('equipo_id');
    const listaEquipos = document.getElementById('lista_equipos');
    const equipoSeleccionado = document.getElementById('equipo_seleccionado');

    if (filtroTipo && inputBuscar && inputEquipoId && listaEquipos) {
        function filtrarEquipos() {
            const texto = inputBuscar.value.trim().toUpperCase();
            const tipoId = filtroTipo.value;

            return equipos.filter(function (eq) {
                if (tipoId && String(eq.tipo_id) !== String(tipoId)) {
                    return false;
                }

                if (!texto) return true;

                const campos = [
                    eq.id, eq.tipo, eq.marca, eq.modelo, eq.serie, eq.ubicacion
                ].map(function (campo) {
                    return String(campo ?? '').toUpperCase();
                });

                return campos.some(function (campo) {
                    return campo.includes(texto);
                });
            }).sort(function (a, b) {
                return Number(a.id) - Number(b.id);
            });
        }

        function mostrarEquipos() {
            listaEquipos.innerHTML = '';

            const resultados = filtrarEquipos().slice(0, 50);

            if (resultados.length === 0) {
                const vacio = document.createElement('div');
                vacio.className = 'p-3 text-muted small';
                vacio.textContent = equipos.length
                    ? 'No se encontraron equipos con esos criterios.'
                    : 'No llegaron equipos desde el controlador.';
                listaEquipos.appendChild(vacio);
                listaEquipos.style.display = 'block';
                return;
            }

            resultados.forEach(function (eq) {
                const opcion = document.createElement('button');
                opcion.type = 'button';
                opcion.className = 'w-100 text-start border-0 border-bottom bg-white p-3';
                opcion.style.cursor = 'pointer';

                const descripcion = [
                    '#' + eq.id,
                    eq.tipo,
                    eq.marca,
                    eq.modelo,
                    eq.serie ? 'Serie: ' + eq.serie : '',
                    eq.ubicacion ? 'Ubicación: ' + eq.ubicacion : ''
                ].filter(Boolean).join(' | ');

                opcion.textContent = descripcion;

                opcion.addEventListener('click', function () {
                    inputEquipoId.value = eq.id;
                    inputBuscar.value = descripcion;
                    equipoSeleccionado.textContent = 'Equipo seleccionado: ' + descripcion;
                    equipoSeleccionado.style.display = 'block';
                    listaEquipos.style.display = 'none';
                });

                listaEquipos.appendChild(opcion);
            });

            listaEquipos.style.display = 'block';
        }

        inputBuscar.addEventListener('input', function () {
            // Si cambia la búsqueda, debe volver a seleccionar un resultado.
            inputEquipoId.value = '';
            equipoSeleccionado.style.display = 'none';
            mostrarEquipos();
        });

        inputBuscar.addEventListener('focus', mostrarEquipos);
        filtroTipo.addEventListener('change', function () {
            inputEquipoId.value = '';
            equipoSeleccionado.style.display = 'none';
            mostrarEquipos();
        });

        document.addEventListener('click', function (evento) {
            if (!evento.target.closest('#lista_equipos') &&
                !evento.target.closest('#buscar_equipo')) {
                listaEquipos.style.display = 'none';
            }
        });

        // Recuperar el equipo seleccionado si hubo un error de validación.
        const equipoAnterior = equipos.find(function (eq) {
            return String(eq.id) === String(inputEquipoId.value);
        });

        if (equipoAnterior) {
            const descripcion = [
                '#' + equipoAnterior.id,
                equipoAnterior.tipo,
                equipoAnterior.marca,
                equipoAnterior.modelo,
                equipoAnterior.serie ? 'Serie: ' + equipoAnterior.serie : '',
                equipoAnterior.ubicacion ? 'Ubicación: ' + equipoAnterior.ubicacion : ''
            ].filter(Boolean).join(' | ');

            inputBuscar.value = descripcion;
            equipoSeleccionado.textContent = 'Equipo seleccionado: ' + descripcion;
            equipoSeleccionado.style.display = 'block';
        }
    }

    // AGREGAR Y QUITAR PERSONAS: un solo controlador para ambos bloques.
    ['entregantes', 'receptores'].forEach(function (grupo) {
        const lista = document.getElementById('lista-' + grupo);
        const botonAgregar = document.querySelector(
            '[data-agregar-integrante="' + grupo + '"]'
        );

        if (!lista) return;

        let siguienteIndice = 0;

        lista.querySelectorAll('.integrante-row input[name]').forEach(function (input) {
            const coincidencia = input.name.match(
                new RegExp('^' + grupo + '\\[(\\d+)\\]')
            );

            if (coincidencia) {
                siguienteIndice = Math.max(
                    siguienteIndice,
                    Number(coincidencia[1]) + 1
                );
            }
        });

        function actualizarBotones() {
            const filas = lista.querySelectorAll('.integrante-row');

            filas.forEach(function (fila) {
                const botonQuitar = fila.querySelector('[data-quitar-integrante]');
                if (botonQuitar) botonQuitar.disabled = filas.length === 1;
            });
        }

        if (botonAgregar) {
            botonAgregar.addEventListener('click', function () {
                const indice = siguienteIndice++;
                const fila = document.createElement('div');
                fila.className = 'row g-2 mb-3 integrante-row';

                fila.innerHTML = `
                    <div class="col-12 col-md-5">
                        <label class="form-label">Nombre *</label>
                        <input type="text"
                               name="${grupo}[${indice}][nombre]"
                               class="form-control campo-mayusculas"
                               maxlength="150" required>
                    </div>
                    <div class="col-12 col-md-5">
                        <label class="form-label">Cargo *</label>
                        <input type="text"
                               name="${grupo}[${indice}][cargo]"
                               class="form-control campo-mayusculas"
                               maxlength="150" required>
                    </div>
                    <div class="col-12 col-md-2 d-flex align-items-end">
                        <button type="button"
                                class="btn btn-outline-danger w-100"
                                data-quitar-integrante>
                            <i class="bi bi-trash"></i> QUITAR
                        </button>
                    </div>
                `;

                lista.appendChild(fila);
                actualizarBotones();
                fila.querySelector('input').focus();
            });
        }

        lista.addEventListener('click', function (evento) {
            const boton = evento.target.closest('[data-quitar-integrante]');

            if (!boton || lista.querySelectorAll('.integrante-row').length <= 1) {
                return;
            }

            boton.closest('.integrante-row').remove();
            actualizarBotones();
        });

        actualizarBotones();
    });
});
</script>
@endsection
