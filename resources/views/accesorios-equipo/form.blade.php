@php
    $estadoSeleccionado = old(
        'estado',
        $accesoriosEquipo->exists
            ? ($accesoriosEquipo->estado ?? '')
            : 'REGULAR'
    );
@endphp

<div class="container-fluid px-0">
    <div class="row g-3">

        {{-- ================================================= --}}
        {{-- 1. EQUIPO RELACIONADO --}}
        {{-- ================================================= --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">

                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-2 bg-primary bg-opacity-10 p-2 me-3">
                            <i class="fas fa-desktop text-primary"></i>
                        </div>

                        <div>
                            <h6 class="mb-0 fw-bold">EQUIPO RELACIONADO</h6>
                            <small class="text-muted">
                                Seleccione el equipo al que pertenece este accesorio.
                            </small>
                        </div>

                        <span class="badge bg-secondary bg-opacity-10 text-secondary ms-auto">
                            OPCIONAL
                        </span>
                    </div>
                </div>

                <div class="card-body p-3 p-md-4">

                    <div class="row g-3">

                        {{-- FILTRO POR TIPO --}}
                        <div class="col-md-4">
                            <label for="filtro_tipo_equipo" class="form-label fw-semibold">
                                TIPO DE EQUIPO
                            </label>

                            <select id="filtro_tipo_equipo" class="form-select">
                                <option value="">TODOS LOS TIPOS</option>

                                @foreach($tiposEquipoConRegistros ?? [] as $tipo)
                                    <option value="{{ $tipo->id }}"
                                        {{ old('filtro_tipo_equipo') == $tipo->id ? 'selected' : '' }}>
                                        {{ $tipo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- BUSCADOR --}}
                        <div class="col-md-8">
                            <label for="buscar_equipo" class="form-label fw-semibold">
                                BUSCAR EQUIPO
                            </label>

                            <div class="position-relative">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>

                                    <input type="text"
                                        id="buscar_equipo"
                                        class="form-control campo-mayusculas"
                                        placeholder="SERIE, MARCA O MODELO..."
                                        autocomplete="off"
                                        value="{{ old('buscar_equipo', $accesoriosEquipo->equipo->num_serie ?? '') }}">
                                </div>

                                <input type="hidden"
                                    name="equipo_id"
                                    id="equipo_id"
                                    value="{{ old('equipo_id', $accesoriosEquipo->equipo_id ?? '') }}">

                                <div id="resultados_equipos"
                                    class="list-group position-absolute w-100 shadow-sm"
                                    style="z-index: 1000; display: none; max-height: 220px; overflow-y: auto; background: #fff;">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-3 p-2 rounded-2 bg-light">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Si el accesorio no pertenece a un equipo registrado, deje este campo vacío.
                            Se guardará como <strong>SIN EQUIPO</strong>.
                        </small>
                    </div>

                    @error('equipo_id')
                        <div class="text-danger small mt-2">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror

                </div>
            </div>
        </div>


        {{-- ================================================= --}}
        {{-- 2. DATOS DEL ACCESORIO --}}
        {{-- ================================================= --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">

                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-2 bg-success bg-opacity-10 p-2 me-3">
                            <i class="fas fa-plug text-success"></i>
                        </div>

                        <div>
                            <h6 class="mb-0 fw-bold">DATOS DEL ACCESORIO</h6>
                            <small class="text-muted">
                                Información de identificación del accesorio.
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-3 p-md-4">
                    <div class="row g-3">

                        {{-- TIPO DE ACCESORIO --}}
                        <div class="col-md-6">
                            <label for="buscar_tipo_accesorio" class="form-label fw-semibold">
                                TIPO DE ACCESORIO
                                <span class="text-danger">*</span>
                            </label>

                            <input type="hidden"
                                name="tipo"
                                id="tipo"
                                value="{{ old('tipo', $accesoriosEquipo->tipo ?? '') }}">

                            <div class="position-relative">
                                <input type="text"
                                    id="buscar_tipo_accesorio"
                                    class="form-control campo-mayusculas @error('tipo') is-invalid @enderror"
                                    placeholder="ESCRIBA O SELECCIONE..."
                                    autocomplete="off"
                                    value="{{ old('nuevo_tipo', old('tipo') === 'OTRO' ? '' : old('tipo', $accesoriosEquipo->tipo ?? '')) }}"
                                    required>

                                <div id="lista_tipos_accesorio"
                                    class="position-absolute w-100 bg-white border rounded shadow-sm"
                                    style="display: none; z-index: 1050; max-height: 220px; overflow-y: auto;">
                                </div>
                            </div>

                            {{-- NUEVO TIPO --}}
                            <div id="wrap_nuevo_tipo_accesorio"
                                class="mt-2"
                                style="display: {{ old('tipo') === 'OTRO' || old('nuevo_tipo') ? 'block' : 'none' }};">

                                <label for="nuevo_tipo" class="form-label fw-semibold small">
                                    ESPECIFIQUE EL NUEVO TIPO
                                </label>

                                <input type="text"
                                    name="nuevo_tipo"
                                    id="nuevo_tipo"
                                    class="form-control campo-mayusculas @error('nuevo_tipo') is-invalid @enderror"
                                    placeholder="EJ. ADAPTADOR HDMI"
                                    value="{{ old('nuevo_tipo') }}"
                                    maxlength="100">

                                @error('nuevo_tipo')
                                    <div class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            @error('tipo')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>


                        {{-- MARCA --}}
                        <div class="col-md-6">
                            <label for="marca" class="form-label fw-semibold">
                                MARCA
                            </label>

                            <input type="text"
                                name="marca"
                                id="marca"
                                class="form-control campo-mayusculas @error('marca') is-invalid @enderror"
                                value="{{ old('marca', $accesoriosEquipo->marca ?? '') }}"
                                placeholder="INGRESE LA MARCA">

                            <small class="text-muted">
                                Puede utilizar la marca sugerida o ingresar otra.
                            </small>

                            @error('marca')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>


                        {{-- NÚMERO DE SERIE --}}
                        <div class="col-md-6">
                            <label for="num_serie" class="form-label fw-semibold">
                                NÚMERO DE SERIE
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                name="num_serie"
                                id="num_serie"
                                class="form-control campo-mayusculas @error('num_serie') is-invalid @enderror"
                                value="{{ old('num_serie', $accesoriosEquipo->num_serie ?? '') }}"
                                placeholder="INGRESE EL NÚMERO DE SERIE"
                                required>

                            @error('num_serie')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>
        </div>


        {{-- ================================================= --}}
        {{-- 3. ESTADO Y OBSERVACIONES --}}
        {{-- ================================================= --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">

                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-2 bg-warning bg-opacity-10 p-2 me-3">
                            <i class="fas fa-clipboard-check text-warning"></i>
                        </div>

                        <div>
                            <h6 class="mb-0 fw-bold">ESTADO Y OBSERVACIONES</h6>
                            <small class="text-muted">
                                Registre la condición actual del accesorio.
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-3 p-md-4">
                    <div class="row g-3">

                        {{-- ESTADO --}}
                        <div class="col-md-4">
                            <label for="estado" class="form-label fw-semibold">
                                ESTADO
                                <span class="text-danger">*</span>
                            </label>

                            <select name="estado"
                                id="estado"
                                class="form-select @error('estado') is-invalid @enderror"
                                required>

                                <option value="">SELECCIONE UN ESTADO</option>

                                <option value="BUENO"
                                    {{ $estadoSeleccionado === 'BUENO' ? 'selected' : '' }}>
                                    BUENO
                                </option>

                                <option value="REGULAR"
                                    {{ $estadoSeleccionado === 'REGULAR' ? 'selected' : '' }}>
                                    REGULAR
                                </option>

                                <option value="MALOGRADO"
                                    {{ $estadoSeleccionado === 'MALOGRADO' ? 'selected' : '' }}>
                                    MALOGRADO
                                </option>
                            </select>

                            @error('estado')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>


                        {{-- OBSERVACIONES --}}
                        <div class="col-md-8">
                            <label for="observaciones" class="form-label fw-semibold">
                                OBSERVACIONES
                            </label>

                            <textarea name="observaciones"
                                id="observaciones"
                                class="form-control campo-mayusculas @error('observaciones') is-invalid @enderror"
                                placeholder="DESCRIBA ALGUNA CARACTERÍSTICA O DETALLE IMPORTANTE..."
                                rows="3">{{ old('observaciones', $accesoriosEquipo->observaciones ?? $accesoriosEquipo->observacion ?? '') }}</textarea>

                            @error('observaciones')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>
        </div>


        {{-- ================================================= --}}
        {{-- 4. BOTONES DE ACCIÓN --}}
        {{-- ================================================= --}}
        <div class="col-12">
            <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 pt-2">

                <a href="{{ route('accesorios-equipo.index') }}"
                    class="btn btn-light border px-4">
                    <i class="fas fa-arrow-left me-1"></i>
                    VOLVER
                </a>

                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-1"></i>
                    GUARDAR
                </button>

            </div>
        </div>

    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===================== HELPERS =====================
    function limpiarError(campo) {
        if (!campo) return;
        campo.classList.remove('is-invalid');
        const box = campo.parentElement?.querySelector('.js-error-campo');
        if (box) box.remove();
    }

    // Versión suave: NO fuerza el foco
    function mostrarError(campo, mensaje, forzarFoco = false) {
        if (!campo) return false;
        limpiarError(campo);
        campo.classList.add('is-invalid');
        const aviso = document.createElement('div');
        aviso.className = 'js-error-campo invalid-feedback d-block';
        const texto = document.createElement('strong');
        texto.textContent = mensaje;
        aviso.appendChild(texto);
        campo.insertAdjacentElement('afterend', aviso);

        if (forzarFoco) {
            campo.scrollIntoView({ behavior: 'smooth', block: 'center' });
            campo.focus();
        }
        return false;
    }

    function validarCampo(campo, mensaje) {
        if (!campo) return true;
        const valor = campo.value.trim();
        if (valor === '') {
            mostrarError(campo, mensaje, false); // no fuerza foco
            return false;
        }
        limpiarError(campo);
        return true;
    }

    // ===================== MAYÚSCULAS =====================
    document.querySelectorAll('.campo-mayusculas').forEach(function (campo) {
        campo.addEventListener('input', function () {
            const inicio = this.selectionStart;
            this.value = this.value.toUpperCase();
            this.setSelectionRange(inicio, inicio);
            limpiarError(this);
        });
        // Limpiar error al entrar al campo
        campo.addEventListener('focus', function () {
            limpiarError(this);
        });
    });

    // ===================== DECLARACIONES =====================
    const filtroTipoEquipo = document.getElementById('filtro_tipo_equipo');
    const buscador        = document.getElementById('buscar_equipo');
    const resultados      = document.getElementById('resultados_equipos');
    const equipoId        = document.getElementById('equipo_id');

    const campoTipo       = document.getElementById('tipo');
    const buscadorTipo    = document.getElementById('buscar_tipo_accesorio');
    const listaTipos      = document.getElementById('lista_tipos_accesorio');
    const wrapNuevoTipo   = document.getElementById('wrap_nuevo_tipo_accesorio');
    const nuevoTipo       = document.getElementById('nuevo_tipo');

    const campoMarca      = document.getElementById('marca');
    const campoSerie      = document.getElementById('num_serie');
    const campoEstado     = document.getElementById('estado');

    const formulario      = buscador ? buscador.closest('form') : null;

    const tiposAccesoriosData   = @json($tiposAccesorios ?? []);
    const ultimasMarcasAccesorio = @json($ultimasMarcasAccesorio ?? []);

    let tipoEquipoSeleccionado = @json($accesoriosEquipo->equipo->tipoEquipo->nombre ?? '');
    tipoEquipoSeleccionado = (tipoEquipoSeleccionado || '').toUpperCase();

    let ultimaMarcaSugerida = '';
    let marcaEditadaManualmente = campoMarca && campoMarca.value.trim() !== '';

    if (campoMarca) {
        campoMarca.addEventListener('input', function () {
            const valor = this.value.trim();
            marcaEditadaManualmente = valor !== ultimaMarcaSugerida;
            limpiarError(this);
        });
        campoMarca.addEventListener('focus', () => limpiarError(campoMarca));
    }

    // ===================== SUGERIR MARCA =====================
    function sugerirMarcaAccesorio() {
        if (!campoMarca || marcaEditadaManualmente) return;

        const tipoAccesorio = (
            campoTipo.value === 'OTRO'
                ? (nuevoTipo ? nuevoTipo.value : '')
                : campoTipo.value
        ).trim().toUpperCase();

        if (!tipoAccesorio) return;

        let tipoEquipo = 'SIN_EQUIPO';

        if (equipoId.value.trim() !== '' && tipoEquipoSeleccionado) {
            tipoEquipo = tipoEquipoSeleccionado;
        } else if (buscador && buscador.value.trim() !== '' && equipoId.value.trim() === '') {
            return;
        }

        const clave = tipoEquipo + '|' + tipoAccesorio;
        const marcaSugerida = ultimasMarcasAccesorio[clave] || '';

        const valorActual = campoMarca.value.trim();
        if (valorActual === '' || valorActual === ultimaMarcaSugerida) {
            campoMarca.value = marcaSugerida;
            ultimaMarcaSugerida = marcaSugerida;
        }
    }

    // ===================== BÚSQUEDA DE EQUIPOS =====================
    let temporizadorBusqueda = null;
    let controladorBusqueda = null;

    function buscarEquipos() {
        if (!buscador || !resultados) return;

        const buscar = buscador.value.trim();
        const tipoId = filtroTipoEquipo ? filtroTipoEquipo.value : '';

        resultados.innerHTML = '';
        resultados.style.display = 'none';

        if (buscar.length < 2 && !tipoId) return;

        clearTimeout(temporizadorBusqueda);
        if (controladorBusqueda) controladorBusqueda.abort();

        temporizadorBusqueda = setTimeout(() => {
            controladorBusqueda = new AbortController();

            let url = '{{ route("accesorios-equipo.buscarEquipos") }}?buscar=' + encodeURIComponent(buscar);
            if (tipoId) url += '&tipo_equipo_id=' + encodeURIComponent(tipoId);

            fetch(url, { signal: controladorBusqueda.signal })
                .then(r => r.ok ? r.json() : Promise.reject())
                .then(equipos => {
                    if (buscador.value.trim() !== buscar) return;

                    resultados.innerHTML = '';

                    if (!equipos.length) {
                        const aviso = document.createElement('div');
                        aviso.className = 'list-group-item text-muted';
                        aviso.textContent = 'NO SE ENCONTRARON EQUIPOS.';
                        resultados.appendChild(aviso);
                    } else {
                        equipos.forEach(equipo => {
                            const item = document.createElement('button');
                            item.type = 'button';
                            item.className = 'list-group-item list-group-item-action';

                            const titulo = document.createElement('strong');
                            titulo.textContent = (equipo.tipo_equipo || 'SIN TIPO') + ' - ' + (equipo.num_serie || 'SIN SERIE');

                            const detalle = document.createElement('small');
                            detalle.className = 'd-block text-muted';
                            detalle.textContent = (equipo.marca || 'SIN MARCA') + (equipo.modelo ? ' - ' + equipo.modelo : '');

                            item.appendChild(titulo);
                            item.appendChild(detalle);

                            item.addEventListener('click', function () {
                                equipoId.value = equipo.id;
                                tipoEquipoSeleccionado = (equipo.tipo_equipo || '').toUpperCase();
                                buscador.value = (equipo.num_serie || '') + ' - ' + (equipo.tipo_equipo || '') + ' - ' + (equipo.marca || '') + (equipo.modelo ? ' ' + equipo.modelo : '');
                                resultados.style.display = 'none';
                                limpiarError(buscador);
                                sugerirMarcaAccesorio();
                                setTimeout(() => buscadorTipo?.focus(), 100);
                            });

                            resultados.appendChild(item);
                        });
                    }

                    resultados.style.display = 'block';
                })
                .catch(err => {
                    if (err.name !== 'AbortError') console.error(err);
                });
        }, 300);
    }

    if (buscador) {
        buscador.addEventListener('input', function () {
            equipoId.value = '';
            tipoEquipoSeleccionado = '';
            limpiarError(buscador);
            buscarEquipos();
            if (this.value.trim() === '') sugerirMarcaAccesorio();
        });
        buscador.addEventListener('focus', function () {
            limpiarError(buscador);
            buscarEquipos();
        });
        buscador.addEventListener('blur', function () {
            setTimeout(() => {
                if (buscador.value.trim() !== '' && equipoId.value.trim() === '') {
                    mostrarError(buscador, 'SELECCIONE UN EQUIPO DE LA LISTA O DEJE EL CAMPO VACÍO.', false);
                }
            }, 200);
        });
    }

    if (filtroTipoEquipo) {
        filtroTipoEquipo.addEventListener('change', function () {
            equipoId.value = '';
            tipoEquipoSeleccionado = '';
            buscarEquipos();
        });
    }

    document.addEventListener('click', function (e) {
        if (buscador && resultados && !buscador.contains(e.target) && !resultados.contains(e.target)) {
            resultados.style.display = 'none';
        }
    });

    // ===================== COMBOBOX TIPOS DE ACCESORIO =====================
    function pintarListaTiposAccesorio(buscar = '') {
        if (!listaTipos) return;
        listaTipos.innerHTML = '';
        const texto = buscar.trim().toUpperCase();

        const coincidencias = tiposAccesoriosData.filter(tipo =>
            tipo.toUpperCase().includes(texto)
        );

        coincidencias.forEach(tipo => {
            const opcion = document.createElement('button');
            opcion.type = 'button';
            opcion.className = 'list-group-item list-group-item-action';
            opcion.textContent = tipo;
            opcion.addEventListener('click', function () {
                campoTipo.value = tipo;
                buscadorTipo.value = tipo;
                nuevoTipo.value = '';
                wrapNuevoTipo.style.display = 'none';
                listaTipos.style.display = 'none';
                limpiarError(campoTipo);
                limpiarError(buscadorTipo);
                sugerirMarcaAccesorio();
                setTimeout(() => campoMarca?.focus(), 100);
            });
            listaTipos.appendChild(opcion);
        });

        const opcionOtro = document.createElement('button');
        opcionOtro.type = 'button';
        opcionOtro.className = 'list-group-item list-group-item-action fw-bold text-primary';
        opcionOtro.textContent = '+ OTRO (REGISTRAR NUEVO TIPO)';
        opcionOtro.addEventListener('click', function () {
            campoTipo.value = 'OTRO';
            buscadorTipo.value = 'OTRO';
            wrapNuevoTipo.style.display = 'block';
            nuevoTipo.value = '';
            listaTipos.style.display = 'none';
            limpiarError(campoTipo);
            limpiarError(buscadorTipo);
            nuevoTipo.focus();
        });
        listaTipos.appendChild(opcionOtro);
        listaTipos.style.display = 'block';
    }

    if (buscadorTipo) {
        buscadorTipo.addEventListener('input', function () {
            const texto = this.value.trim().toUpperCase();
            campoTipo.value = '';
            nuevoTipo.value = '';
            wrapNuevoTipo.style.display = 'none';
            limpiarError(campoTipo);
            limpiarError(buscadorTipo);

            if (texto === '') {
                listaTipos.style.display = 'none';
                return;
            }

            const existente = tiposAccesoriosData.find(tipo => tipo.toUpperCase() === texto);
            if (existente) {
                campoTipo.value = existente;
                buscadorTipo.value = existente;
                listaTipos.style.display = 'none';
                sugerirMarcaAccesorio();
                setTimeout(() => campoMarca?.focus(), 100);
                return;
            }

            pintarListaTiposAccesorio(texto);
        });

        buscadorTipo.addEventListener('focus', function () {
            limpiarError(buscadorTipo);
            pintarListaTiposAccesorio(this.value);
        });

        buscadorTipo.addEventListener('blur', function () {
            setTimeout(() => {
                if (campoTipo.value.trim() === '') {
                    mostrarError(buscadorTipo, 'SELECCIONE O REGISTRE EL TIPO DE ACCESORIO.', false);
                }
            }, 200);
        });
    }

    if (nuevoTipo) {
        nuevoTipo.addEventListener('input', function () {
            sugerirMarcaAccesorio();
            limpiarError(nuevoTipo);
        });
        nuevoTipo.addEventListener('focus', () => limpiarError(nuevoTipo));
        nuevoTipo.addEventListener('blur', function () {
            if (campoTipo.value === 'OTRO' && this.value.trim() === '') {
                mostrarError(this, 'ESPECIFIQUE EL NUEVO TIPO DE ACCESORIO.', false);
            } else {
                limpiarError(this);
                if (this.value.trim() !== '') {
                    setTimeout(() => campoMarca?.focus(), 100);
                }
            }
        });
    }

    document.addEventListener('click', function (event) {
        if (buscadorTipo && listaTipos &&
            !buscadorTipo.contains(event.target) &&
            !listaTipos.contains(event.target)) {
            listaTipos.style.display = 'none';
        }
    });

    // Validaciones en vivo suaves
    if (campoSerie) {
        campoSerie.addEventListener('focus', () => limpiarError(campoSerie));
        campoSerie.addEventListener('blur', function () {
            validarCampo(this, 'EL NÚMERO DE SERIE ES OBLIGATORIO.');
        });
    }

    if (campoEstado) {
        campoEstado.addEventListener('focus', () => limpiarError(campoEstado));
        campoEstado.addEventListener('blur', function () {
            const estados = ['BUENO', 'REGULAR', 'MALOGRADO'];
            if (!estados.includes(this.value)) {
                mostrarError(this, 'EL ESTADO DEBE SER BUENO, REGULAR O MALOGRADO.', false);
            } else {
                limpiarError(this);
            }
        });
    }

    // Sugerencia inicial
    sugerirMarcaAccesorio();

    // ===================== VALIDACIÓN AL ENVIAR (fuerte) =====================
    if (formulario) {
        formulario.addEventListener('submit', function (event) {
            [buscador, buscadorTipo, campoTipo, nuevoTipo, campoSerie, campoEstado]
                .filter(Boolean)
                .forEach(limpiarError);

            if (buscador && buscador.value.trim() !== '' && equipoId.value.trim() === '') {
                event.preventDefault();
                return mostrarError(buscador, 'SELECCIONE UN EQUIPO DE LA LISTA O DEJE EL CAMPO VACÍO.', true);
            }

            if (campoTipo.value.trim() === '') {
                event.preventDefault();
                return mostrarError(buscadorTipo, 'SELECCIONE O REGISTRE EL TIPO DE ACCESORIO.', true);
            }

            if (campoTipo.value === 'OTRO' && nuevoTipo.value.trim() === '') {
                event.preventDefault();
                return mostrarError(nuevoTipo, 'ESPECIFIQUE EL NUEVO TIPO DE ACCESORIO.', true);
            }

            if (!campoSerie || campoSerie.value.trim() === '') {
                event.preventDefault();
                return mostrarError(campoSerie, 'EL NÚMERO DE SERIE ES OBLIGATORIO.', true);
            }

            const estados = ['BUENO', 'REGULAR', 'MALOGRADO'];
            if (!campoEstado || !estados.includes(campoEstado.value)) {
                event.preventDefault();
                return mostrarError(campoEstado, 'EL ESTADO DEBE SER BUENO, REGULAR O MALOGRADO.', true);
            }
        });
    }

});
</script>