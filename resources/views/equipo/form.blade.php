<div class="row padding-1 p-1">

    {{-- ===================================================== --}}
    {{-- PARTE 1 - DATOS DEL EQUIPO --}}
    {{-- ===================================================== --}}

    <div class="col-12">

        <div class="card mb-4">

            <div class="card-header encabezado-verde">
                <h5 class="mb-0">
                    <i class="bi bi-pc-display"></i>
                    PARTE 1 — DATOS DEL EQUIPO
                </h5>
            </div>

            <div class="card-body">

                <div class="row">

                    {{-- TIPO DE EQUIPO --}}
                    <div class="col-12 col-lg-6 mb-3">

                        <label for="buscar_tipo_equipo" class="form-label">
                            TIPO DE EQUIPO
                            <span class="text-danger">*</span>
                        </label>

                        <input type="hidden"
                            name="tipo_equipo_id"
                            id="tipo_equipo_id"
                            value="{{ old('tipo_equipo_id', $equipo->tipo_equipo_id ?? '') }}">

                        <div class="position-relative">
                            <input
                                type="text"
                                id="buscar_tipo_equipo"
                                class="form-control campo-mayusculas @error('tipo_equipo_id') is-invalid @enderror"
                                placeholder="Escriba o seleccione..."
                                autocomplete="off"
                                value="{{ old('buscar_tipo_equipo', $equipo->tipoEquipo->nombre ?? '') }}"
                            >

                            <div
                                id="lista_tipos_equipo"
                                class="position-absolute w-100 bg-white border rounded shadow-sm"
                                style="display: none; z-index: 1000; max-height: 220px; overflow-y: auto;"
                            ></div>
                        </div>

                        <div id="wrap_nuevo_tipo_equipo" class="mt-2" style="display: none;">
                            <label for="nuevo_tipo_equipo" class="form-label">
                                ESPECIFIQUE EL TIPO
                            </label>
                            <input
                                type="text"
                                name="nuevo_tipo_equipo"
                                id="nuevo_tipo_equipo"
                                class="form-control campo-mayusculas"
                                placeholder="Ej. PROYECTOR"
                                value="{{ old('nuevo_tipo_equipo') }}"
                            >
                        </div>

                        @error('tipo_equipo_id')
                            <div class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>


                    {{-- NÚMERO DE SERIE --}}
                    <div class="col-12 col-lg-6 mb-3">

                        <label for="num_serie" class="form-label">
                            NUMERO DE SERIE
                        </label>

                        <input type="text" name="num_serie"
                            class="form-control campo-mayusculas @error('num_serie') is-invalid @enderror"
                            value="{{ old('num_serie', $equipo?->num_serie) }}" id="num_serie"
                            placeholder="Ingrese el número de serie">

                        @error('num_serie')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror

                    </div>


                    {{-- MARCA --}}
                    <div class="col-12 col-lg-6 mb-3">

                        <label for="marca" class="form-label">
                            MARCA
                        </label>

                        <input type="text" name="marca" class="form-control campo-mayusculas  @error('marca') is-invalid @enderror"
                            value="{{ old('marca', $equipo?->marca) }}" id="marca" placeholder="Ingrese la marca">

                        @error('marca')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror

                    </div>


                    {{-- MODELO --}}
                    <div class="col-12 col-lg-6 mb-3">

                        <label for="modelo" class="form-label">
                            MOELO
                        </label>

                        <input type="text" name="modelo" class="form-control campo-mayusculas @error('modelo') is-invalid @enderror"
                            value="{{ old('modelo', $equipo?->modelo) }}" id="modelo" placeholder="Ingrese el modelo">

                        @error('modelo')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror

                    </div>


                    {{-- UBICACIÓN --}}
                    <div class="col-12 col-lg-6 mb-3">

                        <label for="ubicacion_id" class="form-label">
                            UBICACION
                        </label>

                        <select name="ubicacion_id" class="form-select @error('ubicacion_id') is-invalid @enderror"
                            id="ubicacion_id">

                            <option value="">
                                Seleccione una Ubicación
                            </option>

                            @foreach($ubicacione as $id => $nombre)

                                <option value="{{ $id }}" {{ old('ubicacion_id', $equipo->ubicacion_id ?? '') == $id ? 'selected' : '' }}>
                                    {{ $nombre }}
                                </option>

                            @endforeach

                        </select>

                        @error('ubicacion_id')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror

                    </div>


                        {{-- FECHA DE REGISTRO --}}
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                            <div class="d-flex gap-2">
                                <input type="date" name="fecha_registro" id="fecha_registro" class="form-control"
                                    value="{{ old('fecha_registro', $equipo->fecha_registro ?? now()->format('Y-m-d')) }}">
                                <button type="button" id="btn_fecha_hoy" class="btn btn-outline-success">HOY</button>
                            </div>
                        </div>
                        </div> {{-- row --}}
                </div> {{-- card-body --}}
            </div> {{-- card parte 1 --}}

        {{-- ===================================================== --}}
        {{-- PARTE 2 - ESPECIFICACIONES --}}
        {{-- ===================================================== --}}

        <div class="card mb-4">

            <div class="card-header encabezado-verde">
                <h5 class="mb-0">
                    <i class="bi bi-cpu"></i>
                    PARTE 2 — ESPECIFICACIONES
                </h5>
            </div>

            <div class="card-body">

                {{-- MENSAJE INICIAL --}}
                <div id="mensaje-especificaciones" class="text-muted">
                    <i class="bi bi-info-circle"></i>
                    Seleccione primero el tipo de equipo para ingresar sus especificaciones.
                </div>

                {{-- ================================================= --}}
                {{-- ESPECIFICACIONES PARA LAPTOP --}}
                {{-- ================================================= --}}

                <div id="especificaciones-laptop" style="display: none;">

                    <h6 class="fw-bold text-success mb-3 text-wrap">
                        <i class="bi bi-laptop"></i>
                        Especificaciones de Laptop
                    </h6>

                    <div class="row">

                        {{-- PROCESADOR --}}
                        <div class="col-md-6 mb-3">

                            <label for="procesador" class="form-label">
                                Procesador
                            </label>

                            <input type="text" name="procesador" id="procesador" class="form-control"
                                placeholder="Ej. Intel Core i5"
                                value="{{ old('procesador', $equipo->especificacionesLaptops?->procesador) }}">

                        </div>


                        {{-- RAM --}}
                        <div class="col-md-6 mb-3">

                            <label for="ram" class="form-label">
                                Memoria RAM
                            </label>

                            <input type="text" name="ram" id="ram" class="form-control campo-mayusculas" placeholder="Ej. 8GB DDR4"
                                value="{{ old('ram', $equipo->especificacionesLaptops?->ram) }}">

                        </div>


                        {{-- DISCO DURO --}}
                        <div class="col-md-6 mb-3">

                            <label for="disco_duro" class="form-label">
                                Disco Duro
                            </label>

                            <input type="text" name="disco_duro" id="disco_duro" class="form-control campo-mayusculas"
                                placeholder="Ej. SSD 512GB"
                                value="{{ old('disco_duro', $equipo->especificacionesLaptops?->disco_duro) }}">

                        </div>


                        {{-- COLOR --}}
                        <div class="col-md-6 mb-3">

                            <label for="color_laptop" class="form-label">
                                Color
                            </label>

                            <input type="text" name="color_laptop" id="color_laptop" class="form-control campo-mayusculas"
                                placeholder="Ej. Negro"
                                value="{{ old('color_laptop', $equipo->especificacionesLaptops?->color) }}">

                        </div>


                        {{-- ESTADO --}}
                        <div class="col-md-6 mb-3">

                            <label for="estado_laptop" class="form-label">
                                Estado
                            </label>

                            <select name="estado_laptop" id="estado_laptop" class="form-select">
                                <option value="Regular" {{ old('estado_laptop', $especificacionesLaptop?->estado ?? 'Regular') == 'Regular' ? 'selected' : '' }}>
                                    REGULAR
                                </option>

                                <option value="Bueno" {{ old('estado_laptop', $especificacionesLaptop?->estado ?? 'Regular') == 'Bueno' ? 'selected' : '' }}>
                                    BUENO
                                </option>

                                <option value="Malogrado" {{ old('estado_laptop', $especificacionesLaptop?->estado ?? 'Regular') == 'Malogrado' ? 'selected' : '' }}>
                                    MALOGRADO
                                </option>
                            </select>

                        </div>


                        {{-- OBSERVACIONES --}}
                        <div class="col-md-12 mb-3">

                            <label for="observaciones_laptop" class="form-label">
                                Observaciones
                            </label>

                            <textarea name="observaciones_laptop" id="observaciones_laptop" class="form-control campo-mayusculas"
                                rows="3"
                                placeholder="Observaciones de la laptop">{{ old('observaciones_laptop', $equipo->especificacionesLaptops?->observaciones) }}</textarea>

                        </div>
                    </div>
                </div>


                {{-- ================================================= --}}
                {{-- ESPECIFICACIONES PARA OTROS EQUIPOS --}}
                {{-- ================================================= --}}

                <div id="especificaciones-equipo" style="display: none;">

                    <h6 class="fw-bold text-success mb-3 text-wrap">
                        <i class="bi bi-box"></i>
                        Especificaciones del Equipo
                    </h6>

                    <div class="row">

                        {{-- DESCRIPCIÓN --}}
                        <div class="col-md-6 mb-3">

                            <label for="descripcion" class="form-label">
                                Descripción
                            </label>

                            <input type="text" name="descripcion" id="descripcion" class="form-control campo-mayusculas"
                                placeholder="Descripción del equipo"
                                value="{{ old('descripcion', $equipo->especificacionesEquipo?->descripcion) }}">

                        </div>


                        {{-- COLOR --}}
                        <div class="col-md-6 mb-3">

                            <label for="color_equipo" class="form-label">
                                Color
                            </label>

                            <input type="text" name="color_equipo" id="color_equipo" class="form-control campo-mayusculas"
                                placeholder="Ej. Negro"
                                value="{{ old('color_equipo', $equipo->especificacionesEquipo?->color) }}">

                        </div>


                        {{-- ESTADO --}}
                        <div class="col-md-6 mb-3">

                            <label for="estado_equipo" class="form-label">
                                Estado
                            </label>

                            <select name="estado_equipo" id="estado_equipo" class="form-select">
                                <option value="Regular" {{ old('estado_equipo', $especificacionesEquipo?->estado ?? 'Regular') == 'Regular' ? 'selected' : '' }}>
                                    REGULAR
                                </option>

                                <option value="Bueno" {{ old('estado_equipo', $especificacionesEquipo?->estado ?? 'Regular') == 'Bueno' ? 'selected' : '' }}>
                                    BUENO
                                </option>

                                <option value="Malogrado" {{ old('estado_equipo', $especificacionesEquipo?->estado ?? 'Regular') == 'Malogrado' ? 'selected' : '' }}>
                                    MALOGRADO
                                </option>
                            </select>

                        </div>


                        {{-- OBSERVACIONES --}}
                        <div class="col-md-12 mb-3">

                            <label for="observaciones_equipo" class="form-label">
                                Observaciones
                            </label>

                            <textarea name="observaciones_equipo" id="observaciones_equipo" class="form-control campo-mayusculas"
                                rows="3"
                                placeholder="Observaciones del equipo">{{ old('observaciones_equipo', $equipo->especificacionesEquipo?->observaciones) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- ===================================================== --}}
{{-- PARTE 3 - ACCESORIOS --}}
{{-- ===================================================== --}}

<div class="col-md-12 mt-4">

    <div class="card border-body">

        <div class="card-header encabezado-verde">
            <h5 class="mb-0">
                <i class="bi bi-tools"></i>
                PARTE 3 - ACCESORIOS DEL EQUIPO
            </h5>
        </div>

        <div class="card-body">

            {{-- MENSAJE CUANDO NO HAY ACCESORIOS --}}
            <div id="sin-accesorios" class="text-center text-muted py-3">
                <i class="bi bi-info-circle"></i>
                Este equipo no tiene accesorios registrados.
            </div>


            {{-- CONTENEDOR DE ACCESORIOS --}}
            <div id="accesorios-container">

                {{-- ===================================================== --}}
                {{-- ACCESORIOS EXISTENTES --}}
                {{-- ===================================================== --}}

                @if(isset($equipo->accesoriosEquipos))

                    @foreach($equipo->accesoriosEquipos as $indice => $accesorio)

                        <div class="accesorio-item border rounded p-3 mb-3">

                            {{-- ID DEL ACCESORIO EXISTENTE --}}
                            <input
                                type="hidden"
                                name="accesorios[{{ $indice }}][id]"
                                value="{{ $accesorio->id }}"
                            >

                            <div class="row">

                                {{-- ================================================= --}}
                                {{-- TIPO --}}
                                {{-- ================================================= --}}

                                <div class="col-md-2 mb-3">

                                    <label class="form-label">
                                        Tipo
                                    </label>

                                    <div class="position-relative">

                                        <input
                                            type="text"
                                            name="accesorios[{{ $indice }}][tipo]"
                                            class="form-control tipo-accesorio campo-mayusculas"
                                            value="{{ $accesorio->tipo }}"
                                            placeholder="Escriba o seleccione..."
                                            autocomplete="off"
                                        >

                                        {{-- LISTA DE RESULTADOS --}}
                                        <div
                                            class="lista-tipos-accesorio position-absolute w-100 bg-white border rounded shadow-sm"
                                            style="display: none; z-index: 1000;"
                                        >
                                        </div>

                                    </div>


                                    {{-- ================================================= --}}
                                    {{-- TIPO PERSONALIZADO --}}
                                    {{-- ================================================= --}}

                                    <div
                                        class="tipo-personalizado-container mt-2"
                                        style="display: none;"
                                    >

                                        <label class="form-label">
                                            Especifique el tipo
                                        </label>

                                        <input
                                            type="text"
                                            name="accesorios[{{ $indice }}][tipo_personalizado]"
                                            class="form-control tipo-personalizado campo-mayusculas"
                                            placeholder="Ej. Cable HDMI"
                                        >

                                    </div>

                                </div>


                                {{-- ================================================= --}}
                                {{-- MARCA --}}
                                {{-- ================================================= --}}

                                <div class="col-md-2 mb-3">

                                    <label class="form-label">
                                        Marca
                                    </label>

                                    <input
                                        type="text"
                                        name="accesorios[{{ $indice }}][marca]"
                                        class="form-control campo-mayusculas"
                                        value="{{ $accesorio->marca }}"
                                        placeholder="Marca"
                                    >

                                </div>


                                {{-- ================================================= --}}
                                {{-- NÚMERO DE SERIE --}}
                                {{-- ================================================= --}}

                                <div class="col-md-2 mb-3">

                                    <label class="form-label">
                                        N.º de Serie
                                    </label>

                                    <input
                                        type="text"
                                        name="accesorios[{{ $indice }}][num_serie]"
                                        class="form-control campo-mayusculas"
                                        value="{{ $accesorio->num_serie }}"
                                        placeholder="N.º Serie"
                                    >

                                </div>


                                {{-- ================================================= --}}
                                {{-- ESTADO --}}
                                {{-- ================================================= --}}

                                <div class="col-md-2 mb-3">

                                    <label class="form-label">
                                        Estado
                                    </label>

                                    <select
                                        name="accesorios[{{ $indice }}][estado]"
                                        class="form-select"
                                    >

                                        <option
                                            value="Regular"
                                            {{ $accesorio->estado == 'Regular' ? 'selected' : '' }}
                                        >
                                            REGULAR
                                        </option>

                                        <option
                                            value="Bueno"
                                            {{ $accesorio->estado == 'Bueno' ? 'selected' : '' }}
                                        >
                                            BUENO
                                        </option>

                                        <option
                                            value="Malogrado"
                                            {{ $accesorio->estado == 'Malogrado' ? 'selected' : '' }}
                                        >
                                            MALOGRADO
                                        </option>

                                    </select>

                                </div>


                                {{-- ================================================= --}}
                                {{-- OBSERVACIONES --}}
                                {{-- ================================================= --}}

                                <div class="col-md-3 mb-3">

                                    <label class="form-label">
                                        Observaciones
                                    </label>

                                    <textarea
                                        name="accesorios[{{ $indice }}][observaciones]"
                                        class="form-control"
                                        rows="1"
                                        placeholder="Observaciones campo-mayusculas"
                                    >{{ $accesorio->observaciones }}</textarea>

                                </div>


                                {{-- ================================================= --}}
                                {{-- ELIMINAR --}}
                                {{-- ================================================= --}}

                                <div class="col-12 col-md-1 mb-3 d-flex align-items-end justify-content-center">

                                    <button type="button" class="btn btn-danger btn-eliminar-accesorio" title="Eliminar accesorio">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </div>

                            </div>

                        </div>

                    @endforeach

                @endif

            </div>


            {{-- ===================================================== --}}
            {{-- BOTÓN AGREGAR --}}
            {{-- ===================================================== --}}

            <div class="text-center mt-3">

                <button
                    type="button"
                    id="agregar-accesorio"
                    class="btn btn-success"
                >
                    <i class="bi bi-plus-circle"></i>
                    Agregar accesorio
                </button>

            </div>

        </div>

    </div>

</div>

        {{-- ===================================================== --}}
        {{-- BOTONES --}}
        {{-- ===================================================== --}}

        <div class="col-md-12 mt-2 mb-3">

            <button type="submit" class="btn btn-success">

                <i class="bi bi-check-circle"></i>
                Guardar
            </button>


            <a href="{{ route('equipos.index') }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>
                Volver
            </a>

        </div>


    </div>


    <script>
        
        document.addEventListener('DOMContentLoaded', function () {

    function aMayusculas(campo) {
        if (!campo) return;
        const start = campo.selectionStart;
        const end = campo.selectionEnd;
        campo.value = campo.value.toUpperCase();
        if (typeof start === 'number') campo.setSelectionRange(start, end);
    }

    document.querySelectorAll('.campo-mayusculas').forEach(function (campo) {
        campo.addEventListener('input', function () { aMayusculas(this); });
    });

    const tiposEquipoData = [
        @foreach($tiposequipo as $id => $nombre)
            { id: {{ (int) $id }}, nombre: @json($nombre) },
        @endforeach
    ];

    const inputTipoEq = document.getElementById('buscar_tipo_equipo');
    const hiddenTipoEq = document.getElementById('tipo_equipo_id');
    const listaTipoEq = document.getElementById('lista_tipos_equipo');
    const wrapNuevoTipo = document.getElementById('wrap_nuevo_tipo_equipo');
    const inputNuevoTipo = document.getElementById('nuevo_tipo_equipo');
    const laptopBox = document.getElementById('especificaciones-laptop');
    const equipoBox = document.getElementById('especificaciones-equipo');
    const mensajeSpecs = document.getElementById('mensaje-especificaciones');
    const fechaRegistro = document.getElementById('fecha_registro');
    const btnHoy = document.getElementById('btn_fecha_hoy');
    const container = document.getElementById('accesorios-container');
    const botonAgregar = document.getElementById('agregar-accesorio');
    const mensajeVacio = document.getElementById('sin-accesorios');
    const cardParte3 = botonAgregar ? botonAgregar.closest('.card') : null;
    const tiposAccesorios = @json($tiposAccesorios ?? []);
    const idsBloqueados = ['num_serie', 'marca', 'modelo', 'ubicacion_id', 'fecha_registro', 'btn_fecha_hoy'];

    function fechaHoyISO() {
        const d = new Date();
        return d.getFullYear() + '-' +
            String(d.getMonth() + 1).padStart(2, '0') + '-' +
            String(d.getDate()).padStart(2, '0');
    }

    if (fechaRegistro && !fechaRegistro.value) {
        fechaRegistro.value = fechaHoyISO();
    }
    if (btnHoy && fechaRegistro) {
        btnHoy.addEventListener('click', function () {
            fechaRegistro.value = fechaHoyISO();
        });
    }

    function tipoEquipoListo() {
        if (hiddenTipoEq && String(hiddenTipoEq.value).trim() !== '') return true;
        return !!(
            inputTipoEq &&
            inputTipoEq.value.trim().toUpperCase() === 'OTRO' &&
            inputNuevoTipo &&
            inputNuevoTipo.value.trim() !== ''
        );
    }

    function actualizarBloqueoParte1() {
        const listo = tipoEquipoListo();

        idsBloqueados.forEach(function (id) {
            const el = document.getElementById(id);
            if (!el) return;
            if (el.tagName === 'SELECT' || el.type === 'button') {
                el.disabled = !listo;
            } else {
                el.readOnly = !listo;
            }
            el.classList.toggle('bg-light', !listo);
        });

        if (botonAgregar) botonAgregar.disabled = !listo;
        if (cardParte3) {
            cardParte3.style.opacity = listo ? '1' : '0.55';
            cardParte3.style.pointerEvents = listo ? 'auto' : 'none';
        }
    }

    function textoTipoEquipo() {
        if (inputNuevoTipo && inputNuevoTipo.value.trim() !== '') {
            return inputNuevoTipo.value.trim().toUpperCase();
        }
        return (inputTipoEq ? inputTipoEq.value : '').trim().toUpperCase();
    }

    function mostrarCampoNuevoTipo(mostrar) {
        if (!wrapNuevoTipo || !inputNuevoTipo) return;
        wrapNuevoTipo.style.display = mostrar ? 'block' : 'none';
        inputNuevoTipo.required = !!mostrar;
        if (!mostrar) inputNuevoTipo.value = '';
    }

    function tipoYaExiste(nombre) {
        const n = (nombre || '').trim().toUpperCase();
        if (!n) return null;
        return tiposEquipoData.find(function (t) {
            return String(t.nombre).toUpperCase() === n;
        }) || null;
    }


    function mostrarEspecificaciones() {

                // Ocultar inicialmente ambos bloques
                if (laptopBox) {
                    laptopBox.style.display = 'none';
                }

                if (equipoBox) {
                    equipoBox.style.display = 'none';
                }

                if (mensajeSpecs) {
                    mensajeSpecs.style.display = 'block';
                }


                // Obtener el tipo seleccionado
                const tipoTexto =
                    inputTipoEq
                        ? inputTipoEq.value.trim().toUpperCase()
                        : '';

                const tipoSeleccionado =
                    tipoTexto !== '' &&
                    (
                        (hiddenTipoEq && String(hiddenTipoEq.value).trim() !== '') ||
                        tipoTexto === 'OTRO'
                    );


                // Si todavía no se ha seleccionado un tipo
                if (!tipoSeleccionado) {
                    actualizarBloqueoParte1();
                    return;
                }


                // Ya existe un tipo seleccionado
                if (mensajeSpecs) {
                    mensajeSpecs.style.display = 'none';
                }


                // =========================================================
                // LAPTOP
                // =========================================================

                if (tipoTexto === 'LAPTOP') {

                    if (laptopBox) {
                        laptopBox.style.display = 'block';
                    }

                }


                // =========================================================
                // OTROS EQUIPOS
                // =========================================================

                else if (equipoBox) {

                    equipoBox.style.display = 'block';

                }


                // Actualizar bloqueo de los demás campos
                actualizarBloqueoParte1();
    }


    function pintarListaTiposEquipo() {
        if (!inputTipoEq || !listaTipoEq) return;
        const texto = inputTipoEq.value.trim().toUpperCase();
        listaTipoEq.innerHTML = '';

        tiposEquipoData.filter(function (tipo) {
            return String(tipo.nombre).toUpperCase().includes(texto);
        }).forEach(function (tipo) {
            const item = document.createElement('div');
            item.className = 'px-3 py-2';
            item.style.cursor = 'pointer';
            item.textContent = tipo.nombre;
            item.addEventListener('mousedown', function (e) {
                e.preventDefault();
                inputTipoEq.value = String(tipo.nombre).toUpperCase();
                hiddenTipoEq.value = tipo.id;
                mostrarCampoNuevoTipo(false);
                listaTipoEq.style.display = 'none';
                mostrarEspecificaciones();
            });
            listaTipoEq.appendChild(item);
        });

        const otro = document.createElement('div');
        otro.className = 'px-3 py-2 fw-semibold';
        otro.style.cursor = 'pointer';
        otro.textContent = 'OTRO';
        otro.addEventListener('mousedown', function (e) {
            e.preventDefault();
            inputTipoEq.value = 'OTRO';
            hiddenTipoEq.value = '';
            mostrarCampoNuevoTipo(true);
            listaTipoEq.style.display = 'none';
            if (inputNuevoTipo) inputNuevoTipo.focus();
            mostrarEspecificaciones();
        });
        listaTipoEq.appendChild(otro);
        listaTipoEq.style.display = 'block';
    }

    if (inputTipoEq) {
        inputTipoEq.addEventListener('focus', pintarListaTiposEquipo);
        inputTipoEq.addEventListener('click', pintarListaTiposEquipo);
        inputTipoEq.addEventListener('input', function () {
            this.value = this.value.toUpperCase();
            hiddenTipoEq.value = '';
            mostrarCampoNuevoTipo(this.value.trim() === 'OTRO');
            pintarListaTiposEquipo();
            mostrarEspecificaciones();
        });
    }

    if (inputNuevoTipo) {
        inputNuevoTipo.addEventListener('input', function () {
            this.value = this.value.toUpperCase();
            mostrarEspecificaciones();
        });
        inputNuevoTipo.addEventListener('blur', function () {
            const existe = tipoYaExiste(this.value);
            if (!existe) return;
            inputTipoEq.value = existe.nombre;
            hiddenTipoEq.value = existe.id;
            mostrarCampoNuevoTipo(false);
            mostrarEspecificaciones();
            if (typeof toastr !== 'undefined') {
                toastr.warning('ESE TIPO YA ESTÁ REGISTRADO. SE SELECCIONÓ DE LA LISTA.');
            }
        });
    }

    document.addEventListener('click', function (event) {
        if (listaTipoEq && inputTipoEq && !inputTipoEq.contains(event.target) && !listaTipoEq.contains(event.target)) {
            listaTipoEq.style.display = 'none';
        }
    });

    let contador = container ? container.querySelectorAll('.accesorio-item').length : 0;

    function actualizarMensaje() {
        if (!mensajeVacio || !container) return;
        mensajeVacio.style.display = container.querySelector('.accesorio-item') ? 'none' : 'block';
    }

    function actualizarTipoPersonalizado(accesorio) {
        const inputTipo = accesorio.querySelector('.tipo-accesorio');
        const wrap = accesorio.querySelector('.tipo-personalizado-container');
        const inputPers = accesorio.querySelector('.tipo-personalizado');
        if (!inputTipo || !wrap || !inputPers) return;
        const esOtro = inputTipo.value.trim().toUpperCase() === 'OTRO';
        wrap.style.display = esOtro ? 'block' : 'none';
        inputPers.required = esOtro;
    }

    function configurarCombobox(accesorio) {
        const input = accesorio.querySelector('.tipo-accesorio');
        const lista = accesorio.querySelector('.lista-tipos-accesorio');
        if (!input || !lista) return;

        function mostrarLista() {
            const texto = input.value.trim().toUpperCase();
            lista.innerHTML = '';
            (tiposAccesorios || []).filter(function (tipo) {
                return String(tipo).toUpperCase().includes(texto);
            }).forEach(function (tipo) {
                const opcion = document.createElement('div');
                opcion.className = 'px-3 py-2';
                opcion.style.cursor = 'pointer';
                opcion.textContent = tipo;
                opcion.addEventListener('mousedown', function (event) {
                    event.preventDefault();
                    input.value = String(tipo).toUpperCase();
                    lista.style.display = 'none';
                    actualizarTipoPersonalizado(accesorio);
                });
                lista.appendChild(opcion);
            });
            const opcionOtro = document.createElement('div');
            opcionOtro.className = 'px-3 py-2 fw-semibold';
            opcionOtro.style.cursor = 'pointer';
            opcionOtro.textContent = 'OTRO';
            opcionOtro.addEventListener('mousedown', function (event) {
                event.preventDefault();
                input.value = 'OTRO';
                lista.style.display = 'none';
                actualizarTipoPersonalizado(accesorio);
            });
            lista.appendChild(opcionOtro);
            lista.style.display = 'block';
        }

        input.addEventListener('input', function () {
            mostrarLista();
            actualizarTipoPersonalizado(accesorio);
        });
        input.addEventListener('focus', mostrarLista);
        input.addEventListener('click', mostrarLista);
    }

    if (container) {
        container.querySelectorAll('.accesorio-item').forEach(function (accesorio) {
            configurarCombobox(accesorio);
            actualizarTipoPersonalizado(accesorio);
        });
        actualizarMensaje();

        if (botonAgregar) {
            botonAgregar.addEventListener('click', function () {
                if (!tipoEquipoListo()) return;
                const accesorio = document.createElement('div');
                accesorio.className = 'accesorio-item border rounded p-3 mb-3';
                accesorio.innerHTML = `
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Tipo</label>
                            <div class="position-relative">
                                <input type="text" name="accesorios[${contador}][tipo]" class="form-control tipo-accesorio campo-mayusculas" autocomplete="off">
                                <div class="lista-tipos-accesorio" style="display:none;"></div>
                            </div>
                            <div class="tipo-personalizado-container mt-2" style="display:none;">
                                <label class="form-label">Especifique el tipo</label>
                                <input type="text" name="accesorios[${contador}][tipo_personalizado]" class="form-control tipo-personalizado campo-mayusculas">
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Marca</label>
                            <input type="text" name="accesorios[${contador}][marca]" class="form-control campo-mayusculas">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">N.º de Serie</label>
                            <input type="text" name="accesorios[${contador}][num_serie]" class="form-control campo-mayusculas">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Estado</label>
                            <select name="accesorios[${contador}][estado]" class="form-select">
                                <option value="REGULAR" selected>REGULAR</option>
                                <option value="BUENO">BUENO</option>
                                <option value="MALOGRADO">MALOGRADO</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Observaciones</label>
                            <textarea name="accesorios[${contador}][observaciones]" class="form-control campo-mayusculas" rows="1"></textarea>
                        </div>
                        <div class="col-12 col-md-1 mb-3 d-flex align-items-end justify-content-center">
                            <button type="button" class="btn btn-danger btn-eliminar-accesorio"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>`;
                container.appendChild(accesorio);
                accesorio.querySelectorAll('.campo-mayusculas').forEach(function (campo) {
                    campo.addEventListener('input', function () { aMayusculas(this); });
                });
                configurarCombobox(accesorio);
                contador++;
                actualizarMensaje();
            });
        }

        container.addEventListener('click', function (event) {
            const botonEliminar = event.target.closest('.btn-eliminar-accesorio');
            if (!botonEliminar) return;
            const accesorio = botonEliminar.closest('.accesorio-item');
            if (accesorio) accesorio.remove();
            actualizarMensaje();
        });
    }

    document.addEventListener('click', function (event) {
        document.querySelectorAll('.lista-tipos-accesorio').forEach(function (lista) {
            const accesorio = lista.closest('.accesorio-item');
            if (accesorio && !accesorio.contains(event.target)) lista.style.display = 'none';
        });
    });

    const form = inputTipoEq ? inputTipoEq.closest('form') : null;
    if (form) {
        form.addEventListener('submit', function () {
            idsBloqueados.forEach(function (id) {
                const el = document.getElementById(id);
                if (el) {
                    el.disabled = false;
                    el.readOnly = false;
                }
            });
        });
    }

    mostrarEspecificaciones();
});
</script>

<style>
    /* =====================================================
       COMBOBOX DE TIPOS DE ACCESORIOS
       ===================================================== */

    .contenedor-tipo-accesorio {
        position: relative;
        z-index: 1000;
    }

    /*
     * Permitir que el dropdown salga de la fila
     * sin ser recortado.
     */
    .accesorio-item {
        overflow: visible !important;
    }

    .accesorio-item .row {
        overflow: visible !important;
    }

    #accesorios-container {
        overflow: visible !important;
    }

    /*
     * LISTA DEL COMBOBOX
     *
     * Aproximadamente 6 opciones visibles.
     * Si existen más, aparece scrollbar.
     */
    .lista-tipos-accesorio {
        position: absolute !important;
        top: 100%;
        left: 0;
        width: 100%;

        max-height: 240px;
        overflow-y: auto;
        overflow-x: hidden;

        background: white;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.15);

        z-index: 99999 !important;
    }

    /*
     * Cada opción del combobox
     */
    .opcion-tipo-accesorio {
        padding: 8px 12px;
        cursor: pointer;
        white-space: nowrap;
    }

    .opcion-tipo-accesorio:hover {
        background-color: #f0f0f0;
    }

    .card,
.card-body,
#accesorios-container,
.accesorio-item,
.accesorio-item .row {
    overflow: visible !important;
}
.btn-eliminar-accesorio {
    width: 36px !important;
    height: 36px !important;
    min-width: 36px !important;
    max-width: 36px !important;
    min-height: 36px !important;
    max-height: 36px !important;

    padding: 0 !important;
    margin: 0 !important;

    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;

    flex: 0 0 40px !important;
}
</style>