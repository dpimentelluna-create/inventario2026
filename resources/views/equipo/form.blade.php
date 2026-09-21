<div class="row padding-1 p-1">

{{-- ===================================================== --}}
{{-- PARTE 1 — DATOS DEL EQUIPO --}}
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

                {{-- ================================================= --}}
                {{-- TIPO DE EQUIPO --}}
                {{-- ================================================= --}}

                <div class="col-12 col-lg-6 mb-3">

                    <label for="buscar_tipo_equipo" class="form-label">
                        TIPO DE EQUIPO
                        <span class="text-danger">*</span>
                    </label>

                    {{-- ID REAL --}}
                    <input
                        type="hidden"
                        name="tipo_equipo_id"
                        id="tipo_equipo_id"
                        value="{{ old('tipo_equipo_id', $equipo->tipo_equipo_id ?? '') }}"
                    >

                    {{-- BUSCADOR --}}
                    <div class="position-relative">

                        <input
                            type="text"
                            id="buscar_tipo_equipo"
                            class="form-control campo-mayusculas @error('tipo_equipo_id') is-invalid @enderror"
                            placeholder="ESCRIBA O SELECCIONE..."
                            autocomplete="off"
                            value="{{ old('buscar_tipo_equipo', $equipo->tipoEquipo->nombre ?? '') }}"
                            required
                        >

                        {{-- RESULTADOS --}}
                        <div
                            id="lista_tipos_equipo"
                            class="position-absolute w-100 bg-white border rounded shadow-sm"
                            style="
                                display: none;
                                z-index: 1050;
                                max-height: 220px;
                                overflow-y: auto;
                            "
                        ></div>

                    </div>

                    {{-- NUEVO TIPO --}}
                    <div
                        id="wrap_nuevo_tipo_equipo"
                        class="mt-2"
                        style="display: none;"
                    >

                        <label for="nuevo_tipo_equipo" class="form-label">
                            ESPECIFIQUE EL TIPO
                        </label>

                        <input
                            type="text"
                            name="nuevo_tipo_equipo"
                            id="nuevo_tipo_equipo"
                            class="form-control campo-mayusculas"
                            placeholder="EJ. PROYECTOR"
                            value="{{ old('nuevo_tipo_equipo') }}"
                            maxlength="100"
                        >

                    </div>

                    @error('tipo_equipo_id')
                        <div class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- NÚMERO DE SERIE --}}
                {{-- ================================================= --}}

                <div class="col-12 col-lg-6 mb-3">

                    <label for="num_serie" class="form-label">
                        NÚMERO DE SERIE
                    </label>

                    <input
                        type="text"
                        name="num_serie"
                        id="num_serie"
                        class="form-control campo-mayusculas @error('num_serie') is-invalid @enderror"
                        value="{{ old('num_serie', $equipo->num_serie ?? '') }}"
                        placeholder="INGRESE EL NÚMERO DE SERIE"
                    >

                    @error('num_serie')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- MARCA --}}
                {{-- ================================================= --}}

                <div class="col-12 col-lg-6 mb-3">

                    <label for="marca" class="form-label">
                        MARCA
                    </label>

                    <input
                        type="text"
                        name="marca"
                        id="marca"
                        class="form-control campo-mayusculas @error('marca') is-invalid @enderror"
                        value="{{ old('marca', $equipo->marca ?? '') }}"
                        placeholder="INGRESE LA MARCA"
                    >

                    @error('marca')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- MODELO --}}
                {{-- ================================================= --}}

                <div class="col-12 col-lg-6 mb-3">

                    <label for="modelo" class="form-label">
                        MODELO
                    </label>

                    <input
                        type="text"
                        name="modelo"
                        id="modelo"
                        class="form-control campo-mayusculas @error('modelo') is-invalid @enderror"
                        value="{{ old('modelo', $equipo->modelo ?? '') }}"
                        placeholder="INGRESE EL MODELO"
                    >

                    @error('modelo')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- UBICACIÓN --}}
                {{-- ================================================= --}}

                <div class="col-12 col-lg-6 mb-3">

                    <label for="ubicacion_id" class="form-label">
                        UBICACIÓN
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        name="ubicacion_id"
                        id="ubicacion_id"
                        class="form-select @error('ubicacion_id') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            SELECCIONE UNA UBICACIÓN
                        </option>

                        @foreach($ubicacione as $id => $nombre)

                            <option
                                value="{{ $id }}"
                                {{ old('ubicacion_id', $equipo->ubicacion_id ?? '') == $id ? 'selected' : '' }}
                            >
                                {{ strtoupper($nombre) }}
                            </option>

                        @endforeach

                    </select>

                    @error('ubicacion_id')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- FECHA DE REGISTRO --}}
                {{-- ================================================= --}}

                <div class="col-12 col-lg-6 mb-3">

                    <label for="fecha_registro" class="form-label">
                        FECHA DE REGISTRO
                        <span class="text-danger">*</span>
                    </label>

                    <div class="input-group">

                        <input
                            type="date"
                            name="fecha_registro"
                            id="fecha_registro"
                            class="form-control @error('fecha_registro') is-invalid @enderror"
                            value="{{ old(
                                'fecha_registro',
                                $equipo->fecha_registro
                                ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('Y-m-d')
                                : now()->format('Y-m-d')
                            ) }}"
                            required
                        >

                        <button
                            type="button"
                            id="btn_fecha_hoy"
                            class="btn btn-outline-success"
                        >
                            <i class="bi bi-calendar-check"></i>
                            HOY
                        </button>

                    </div>

                    @error('fecha_registro')
                        <div class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror

                </div>

            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- PARTE 2 — ESPECIFICACIONES --}}
    {{-- ===================================================== --}}

    <div class="card mb-4">

        <div class="card-header encabezado-verde">

            <h5 class="mb-0">
                <i class="bi bi-cpu"></i>
                PARTE 2 — ESPECIFICACIONES
            </h5>

        </div>

        <div class="card-body">

            {{-- AVISO: PARTE 1 INCOMPLETA --}}
            <div
                id="bloqueo-parte2"
                class="alert alert-warning py-2 px-3 small mb-3"
                style="display: none;"
            >
                <i class="bi bi-lock-fill"></i>
                COMPLETE LA UBICACIÓN Y LA FECHA DE REGISTRO EN LA PARTE 1 PARA CONTINUAR.
            </div>

            {{-- MENSAJE INICIAL --}}
            <div
                id="mensaje-especificaciones"
                class="text-muted"
            >
                <i class="bi bi-info-circle"></i>
                SELECCIONE PRIMERO EL TIPO DE EQUIPO PARA INGRESAR SUS ESPECIFICACIONES.
            </div>


            {{-- ================================================= --}}
            {{-- ESPECIFICACIONES PARA LAPTOP --}}
            {{-- ================================================= --}}

            <div
                id="especificaciones-laptop"
                style="display: none;"
            >

                <h6 class="fw-bold text-success mb-3 text-wrap">
                    <i class="bi bi-laptop"></i>
                    ESPECIFICACIONES DE LAPTOP
                </h6>

                <div class="row">

                    {{-- PROCESADOR --}}
                    <div class="col-md-6 mb-3">

                        <label for="procesador" class="form-label">
                            PROCESADOR
                        </label>

                        <input
                            type="text"
                            name="procesador"
                            id="procesador"
                            class="form-control campo-mayusculas"
                            placeholder="EJ. INTEL CORE I5"
                            value="{{ old('procesador', $equipo->especificacionesLaptops?->procesador ?? '') }}"
                        >

                    </div>


                    {{-- RAM --}}
                    <div class="col-md-6 mb-3">

                        <label for="ram" class="form-label">
                            MEMORIA RAM
                        </label>

                        <input
                            type="text"
                            name="ram"
                            id="ram"
                            class="form-control campo-mayusculas"
                            placeholder="EJ. 8GB DDR4"
                            value="{{ old('ram', $equipo->especificacionesLaptops?->ram ?? '') }}"
                        >

                    </div>


                    {{-- DISCO DURO --}}
                    <div class="col-md-6 mb-3">

                        <label for="disco_duro" class="form-label">
                            DISCO DURO
                        </label>

                        <input
                            type="text"
                            name="disco_duro"
                            id="disco_duro"
                            class="form-control campo-mayusculas"
                            placeholder="EJ. SSD 512GB"
                            value="{{ old('disco_duro', $equipo->especificacionesLaptops?->disco_duro ?? '') }}"
                        >

                    </div>


                    {{-- COLOR --}}
                    <div class="col-md-6 mb-3">

                        <label for="color_laptop" class="form-label">
                            COLOR
                        </label>

                        <input
                            type="text"
                            name="color_laptop"
                            id="color_laptop"
                            class="form-control campo-mayusculas"
                            placeholder="EJ. NEGRO"
                            value="{{ old('color_laptop', $equipo->especificacionesLaptops?->color ?? '') }}"
                        >

                    </div>


                    {{-- ESTADO --}}
                    <div class="col-md-6 mb-3">

                        <label for="estado_laptop" class="form-label">
                            ESTADO
                        </label>

                        <select
                            name="estado_laptop"
                            id="estado_laptop"
                            class="form-select"
                        >

                            <option
                                value="REGULAR"
                                {{ old('estado_laptop', $equipo->especificacionesLaptops?->estado ?? 'REGULAR') === 'REGULAR' ? 'selected' : '' }}
                            >
                                REGULAR
                            </option>

                            <option
                                value="BUENO"
                                {{ old('estado_laptop', $equipo->especificacionesLaptops?->estado ?? '') === 'BUENO' ? 'selected' : '' }}
                            >
                                BUENO
                            </option>

                            <option
                                value="MALOGRADO"
                                {{ old('estado_laptop', $equipo->especificacionesLaptops?->estado ?? '') === 'MALOGRADO' ? 'selected' : '' }}
                            >
                                MALOGRADO
                            </option>

                        </select>

                    </div>


                    {{-- OBSERVACIONES --}}
                    <div class="col-md-12 mb-3">

                        <label for="observaciones_laptop" class="form-label">
                            OBSERVACIONES
                        </label>

                        <textarea
                            name="observaciones_laptop"
                            id="observaciones_laptop"
                            class="form-control campo-mayusculas"
                            rows="3"
                            placeholder="OBSERVACIONES DE LA LAPTOP"
                        >{{ old('observaciones_laptop', $equipo->especificacionesLaptops?->observaciones ?? '') }}</textarea>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- ESPECIFICACIONES PARA OTROS EQUIPOS --}}
            {{-- ================================================= --}}

            <div
                id="especificaciones-equipo"
                style="display: none;"
            >

                <h6 class="fw-bold text-success mb-3 text-wrap">
                    <i class="bi bi-box"></i>
                    ESPECIFICACIONES DEL EQUIPO
                </h6>

                <div class="row">

                    {{-- DESCRIPCIÓN --}}
                    <div class="col-md-6 mb-3">

                        <label for="descripcion" class="form-label">
                            DESCRIPCIÓN
                        </label>

                        <input
                            type="text"
                            name="descripcion"
                            id="descripcion"
                            class="form-control campo-mayusculas"
                            placeholder="DESCRIPCIÓN DEL EQUIPO"
                            value="{{ old('descripcion', $equipo->especificacionesEquipo?->descripcion ?? '') }}"
                        >

                    </div>


                    {{-- COLOR --}}
                    <div class="col-md-6 mb-3">

                        <label for="color_equipo" class="form-label">
                            COLOR
                        </label>

                        <input
                            type="text"
                            name="color_equipo"
                            id="color_equipo"
                            class="form-control campo-mayusculas"
                            placeholder="EJ. NEGRO"
                            value="{{ old('color_equipo', $equipo->especificacionesEquipo?->color ?? '') }}"
                        >

                    </div>


                    {{-- ESTADO --}}
                    <div class="col-md-6 mb-3">

                        <label for="estado_equipo" class="form-label">
                            ESTADO
                        </label>

                        <select
                            name="estado_equipo"
                            id="estado_equipo"
                            class="form-select"
                        >

                            <option
                                value="REGULAR"
                                {{ old('estado_equipo', $equipo->especificacionesEquipo?->estado ?? 'REGULAR') === 'REGULAR' ? 'selected' : '' }}
                            >
                                REGULAR
                            </option>

                            <option
                                value="BUENO"
                                {{ old('estado_equipo', $equipo->especificacionesEquipo?->estado ?? '') === 'BUENO' ? 'selected' : '' }}
                            >
                                BUENO
                            </option>

                            <option
                                value="MALOGRADO"
                                {{ old('estado_equipo', $equipo->especificacionesEquipo?->estado ?? '') === 'MALOGRADO' ? 'selected' : '' }}
                            >
                                MALOGRADO
                            </option>

                        </select>

                    </div>


                    {{-- OBSERVACIONES --}}
                    <div class="col-md-12 mb-3">

                        <label for="observaciones_equipo" class="form-label">
                            OBSERVACIONES
                        </label>

                        <textarea
                            name="observaciones_equipo"
                            id="observaciones_equipo"
                            class="form-control campo-mayusculas"
                            rows="3"
                            placeholder="OBSERVACIONES DEL EQUIPO"
                        >{{ old('observaciones_equipo', $equipo->especificacionesEquipo?->observaciones ?? '') }}</textarea>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- PARTE 3 — ACCESORIOS --}}
    {{-- ===================================================== --}}

    <div class="card mb-4">

        <div class="card-header encabezado-verde">

            <h5 class="mb-0">
                <i class="bi bi-tools"></i>
                PARTE 3 — ACCESORIOS DEL EQUIPO
            </h5>

        </div>

        <div class="card-body">

            {{-- AVISO: PARTE 1 INCOMPLETA --}}
            <div
                id="bloqueo-parte3"
                class="alert alert-warning py-2 px-3 small mb-3"
                style="display: none;"
            >
                <i class="bi bi-lock-fill"></i>
                COMPLETE TODOS LOS CAMPOS OBLIGATORIOS DE LA PARTE 1 (TIPO, UBICACIÓN Y FECHA) PARA HABILITAR LOS ACCESORIOS.
            </div>

            {{-- MENSAJE SIN ACCESORIOS --}}
            <div
                id="sin-accesorios"
                class="text-center text-muted py-3"
            >
                <i class="bi bi-info-circle"></i>
                ESTE EQUIPO NO TIENE ACCESORIOS REGISTRADOS.
            </div>


            {{-- CONTENEDOR --}}
            <div id="accesorios-container">

                {{-- ================================================= --}}
                {{-- ACCESORIOS EXISTENTES --}}
                {{-- ================================================= --}}

                @if(isset($equipo->accesoriosEquipos))

                    @foreach($equipo->accesoriosEquipos as $indice => $accesorio)

                        <div class="accesorio-item border rounded p-3 mb-3">

                            {{-- ID --}}
                            <input
                                type="hidden"
                                name="accesorios[{{ $indice }}][id]"
                                value="{{ $accesorio->id }}"
                            >

                            <div class="row">

                                {{-- TIPO --}}
                                <div class="col-md-2 mb-3">

                                    <label class="form-label">
                                        TIPO
                                    </label>

                                    <div class="position-relative">

                                        <input
                                            type="text"
                                            name="accesorios[{{ $indice }}][tipo]"
                                            class="form-control tipo-accesorio campo-mayusculas"
                                            value="{{ $accesorio->tipo }}"
                                            placeholder="ESCRIBA O SELECCIONE..."
                                            autocomplete="off"
                                        >

                                        <div
                                            class="lista-tipos-accesorio position-absolute w-100 bg-white border rounded shadow-sm"
                                            style="
                                                display: none;
                                                z-index: 1050;
                                                max-height: 220px;
                                                overflow-y: auto;
                                            "
                                        ></div>

                                    </div>


                                    {{-- TIPO PERSONALIZADO --}}
                                    <div
                                        class="tipo-personalizado-container mt-2"
                                        style="display: none;"
                                    >

                                        <label class="form-label">
                                            ESPECIFIQUE EL TIPO
                                        </label>

                                        <input
                                            type="text"
                                            name="accesorios[{{ $indice }}][tipo_personalizado]"
                                            class="form-control tipo-personalizado campo-mayusculas"
                                            placeholder="EJ. CABLE HDMI"
                                        >

                                    </div>

                                </div>


                                {{-- MARCA --}}
                                <div class="col-md-2 mb-3">

                                    <label class="form-label">
                                        MARCA
                                    </label>

                                    <input
                                        type="text"
                                        name="accesorios[{{ $indice }}][marca]"
                                        class="form-control campo-mayusculas"
                                        value="{{ $accesorio->marca }}"
                                        placeholder="MARCA"
                                    >

                                </div>


                                {{-- NÚMERO DE SERIE --}}
                                <div class="col-md-2 mb-3">

                                    <label class="form-label">
                                        NÚMERO DE SERIE
                                    </label>

                                    <input
                                        type="text"
                                        name="accesorios[{{ $indice }}][num_serie]"
                                        class="form-control campo-mayusculas"
                                        value="{{ $accesorio->num_serie }}"
                                        placeholder="N.º SERIE"
                                    >

                                </div>


                                {{-- ESTADO --}}
                                <div class="col-md-2 mb-3">

                                    <label class="form-label">
                                        ESTADO
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


                                {{-- OBSERVACIONES --}}
                                <div class="col-md-3 mb-3">

                                    <label class="form-label">
                                        OBSERVACIONES
                                    </label>

                                    <textarea
                                        name="accesorios[{{ $indice }}][observaciones]"
                                        class="form-control campo-mayusculas"
                                        rows="1"
                                        placeholder="OBSERVACIONES"
                                    >{{ $accesorio->observaciones }}</textarea>

                                </div>


                                {{-- ELIMINAR --}}
                                <div class="col-12 col-md-1 mb-3 d-flex align-items-end justify-content-center">

                                    <button
                                        type="button"
                                        class="btn btn-danger btn-eliminar-accesorio"
                                        title="ELIMINAR ACCESORIO"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </div>

                            </div>

                        </div>

                    @endforeach

                @endif

            </div>


            {{-- BOTÓN AGREGAR --}}
            <div class="text-center mt-3">

                <button
                    type="button"
                    id="agregar-accesorio"
                    class="btn btn-success"
                >
                    <i class="bi bi-plus-circle"></i>
                    AGREGAR ACCESORIO
                </button>

            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- BOTONES --}}
    {{-- ===================================================== --}}

    <div class="col-md-12 mt-2 mb-3">

        <div class="d-flex justify-content-end gap-2">

            <a
                href="{{ route('equipos.index') }}"
                class="btn btn-secondary btn-salir-form"
            >
                <i class="bi bi-x-circle"></i>
                CANCELAR
            </a>

            <button
                type="submit"
                class="btn btn-success"
                id="btn_guardar_equipo"
            >
                <i class="bi bi-save"></i>

                {{ $equipo->exists ? 'ACTUALIZAR EQUIPO' : 'GUARDAR EQUIPO' }}

            </button>

        </div>

    </div>

</div>

</div>

{{-- ===================================================== --}}
{{-- TOAST DE NOTIFICACIONES --}}
{{-- ===================================================== --}}

<div
    class="toast-container position-fixed top-0 end-0 p-3"
    style="z-index: 1090;"
>

<div
    id="toast_equipo"
    class="toast align-items-center border-0"
    role="alert"
    aria-live="assertive"
    aria-atomic="true"
>

    <div class="d-flex">

        <div
            class="toast-body"
            id="toast_equipo_texto"
        ></div>

        <button
            type="button"
            class="btn-close btn-close-white me-2 m-auto"
            data-bs-dismiss="toast"
        ></button>

    </div>

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

    /*
     * =========================================================
     * NOTIFICACIONES Y VALIDACIÓN DE CAMPOS
     * (mismo formato usado en prestamo/form.blade.php)
     * =========================================================
     */

    function mostrarToast(mensaje, tipo) {
        const toastEl = document.getElementById('toast_equipo');
        const textoEl = document.getElementById('toast_equipo_texto');
        if (!toastEl || !textoEl) {
            return;
        }

        textoEl.textContent = mensaje;
        toastEl.classList.remove('text-bg-success', 'text-bg-danger', 'text-bg-primary');
        toastEl.classList.add(tipo === 'danger' ? 'text-bg-danger' : 'text-bg-success');

        const toast = bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 3000 });
        toast.show();
    }

    function limpiarErroresCampos() {
        document.querySelectorAll('.error-toast-campo').forEach(function (el) {
            el.remove();
        });
        document.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });
    }

    function mostrarErrorCampo(campo, mensaje) {
        if (!campo) {
            mostrarToast(mensaje, 'danger');
            return;
        }

        campo.classList.add('is-invalid');

        const contenedor = campo.closest('.mb-3') || campo.parentElement;
        if (contenedor) {
            let aviso = contenedor.querySelector('.error-toast-campo');
            if (!aviso) {
                aviso = document.createElement('div');
                aviso.className = 'error-toast-campo alert alert-danger py-1 px-2 small mt-1 mb-0';
                campo.insertAdjacentElement('afterend', aviso);
            }
            aviso.textContent = mensaje;
        }

        mostrarToast(mensaje, 'danger');
        campo.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(function () {
            campo.focus();
        }, 350);
    }

    const tiposEquipoData = [
        @foreach($tiposequipo as $id => $nombre)
            { id: {{ (int) $id }}, nombre: @json($nombre) },
        @endforeach
    ];

    const inputTipoEq = document.getElementById('buscar_tipo_equipo');
    const hiddenTipoEq = document.getElementById('tipo_equipo_id');
    let indiceTipoActivo = -1;
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
    const bloqueoParte2 = document.getElementById('bloqueo-parte2');
    const bloqueoParte3 = document.getElementById('bloqueo-parte3');
    const cardParte2 = mensajeSpecs ? mensajeSpecs.closest('.card') : null;
    const tiposAccesorios = @json($tiposAccesorios ?? []);
    const ultimasMarcasAccesorio = @json($ultimasMarcasAccesorio ?? []);
    const ultimosPorTipo = @json($ultimosPorTipo ?? []);
    const ultimasMarcasAccesorios = @json($ultimasMarcasAccesorios ?? []);
    const idsBloqueados = ['num_serie', 'marca', 'modelo', 'ubicacion_id', 'fecha_registro', 'btn_fecha_hoy'];

    function aplicarUltimoRegistro(nombreTipo) {
        const data = ultimosPorTipo[String(nombreTipo || '').toUpperCase()];
        if (!data) return;
        const mapa = {
            marca: data.marca,
            modelo: data.modelo,
            procesador: data.procesador,
            ram: data.ram,
            disco_duro: data.disco_duro,
            color_laptop: data.color,
            descripcion: data.descripcion,
            color_equipo: data.color
        };
        Object.keys(mapa).forEach(function (id) {
            const el = document.getElementById(id);
            if (!el || String(el.value || '').trim()) return;
            if (mapa[id]) el.value = mapa[id];
        });
    }

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
            mostrarEspecificaciones();
        });
    }
    if (fechaRegistro) {
        fechaRegistro.addEventListener('input', mostrarEspecificaciones);
        fechaRegistro.addEventListener('change', mostrarEspecificaciones);
    }
    const inputUbicacionEq = document.getElementById('ubicacion_id');
    if (inputUbicacionEq) {
        inputUbicacionEq.addEventListener('change', mostrarEspecificaciones);
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

    /*
     * =========================================================
     * PARTE 1 COMPLETA (TIPO + UBICACIÓN + FECHA)
     * (mismo criterio usado en prestamo/form.blade.php)
     * =========================================================
     */

    function parte1Completa() {
        if (!tipoEquipoListo()) return false;

        const ubicacion = document.getElementById('ubicacion_id');
        if (!ubicacion || ubicacion.value.trim() === '') return false;

        const fecha = document.getElementById('fecha_registro');
        if (!fecha || fecha.value.trim() === '') return false;

        return true;
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

        // ==========================================
        // PARTE 2 Y 3: SOLO SE HABILITAN
        // SI LA PARTE 1 ESTÁ COMPLETA Y VÁLIDA
        // ==========================================

        const completo = parte1Completa();

        if (botonAgregar) botonAgregar.disabled = !completo;
        if (cardParte3) {
            cardParte3.style.opacity = completo ? '1' : '0.55';
            cardParte3.style.pointerEvents = completo ? 'auto' : 'none';
        }
        if (cardParte2) {
            cardParte2.style.opacity = completo ? '1' : '0.55';
            cardParte2.style.pointerEvents = completo ? 'auto' : 'none';
        }

        // Aviso de Parte 2: solo aplica cuando YA hay tipo elegido
        // (si no hay tipo, el mensaje "mensaje-especificaciones" ya lo indica)
        if (bloqueoParte2) {
            bloqueoParte2.style.display = (listo && !completo) ? 'block' : 'none';
        }
        if (bloqueoParte3) {
            bloqueoParte3.style.display = completo ? 'none' : 'block';
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

    let ultimoTipoEquipo = '';

function setCampo(id, valor) {
    const el = document.getElementById(id);
    if (el) el.value = valor;
}

function limpiarAlCambiarTipo() {
    ['marca', 'modelo'].forEach(function (id) { setCampo(id, ''); });
    ['procesador', 'ram', 'disco_duro', 'color_laptop', 'observaciones_laptop'].forEach(function (id) {
        setCampo(id, '');
    });
    setCampo('estado_laptop', 'REGULAR');
    ['descripcion', 'color_equipo', 'observaciones_equipo'].forEach(function (id) {
        setCampo(id, '');
    });
    setCampo('estado_equipo', 'REGULAR');
    if (container) {
        container.querySelectorAll('.accesorio-item').forEach(function (item) { item.remove(); });
        if (typeof actualizarMensaje === 'function') actualizarMensaje();
    }
}

function limpiarFormularioMenosSerie() {
    limpiarAlCambiarTipo();
    setCampo('ubicacion_id', '');
    if (fechaRegistro && typeof fechaHoyISO === 'function') {
        fechaRegistro.value = fechaHoyISO();
    }
}

    function mostrarEspecificaciones() {

                // ==========================================
                // OCULTAR TODO AL INICIO
                // ==========================================

                if (laptopBox) {
                    laptopBox.style.display = 'none';
                }

                if (equipoBox) {
                    equipoBox.style.display = 'none';
                }

                if (mensajeSpecs) {
                    mensajeSpecs.style.display = 'block';
                }


                // ==========================================
                // OBTENER DATOS DEL TIPO SELECCIONADO
                // ==========================================

                const tipoId = hiddenTipoEq
                    ? String(hiddenTipoEq.value).trim()
                    : '';

                const tipoTexto = inputTipoEq
                    ? inputTipoEq.value.trim().toUpperCase()
                    : '';


                // ==========================================
                // SI ES "OTRO"
                // ==========================================

                const esOtro =
                    tipoTexto === 'OTRO' &&
                    inputNuevoTipo &&
                    inputNuevoTipo.value.trim() !== '';


                // ==========================================
                // BUSCAR EL TIPO REAL EN LA LISTA
                // ==========================================

                let tipoSeleccionado = null;

                if (tipoId !== '') {

                    tipoSeleccionado = tiposEquipoData.find(function (tipo) {

                        return String(tipo.id) === tipoId;

                    });

                }

                


                // ==========================================
                // SI TODAVÍA NO HAY TIPO SELECCIONADO
                // ==========================================

                if (!tipoSeleccionado && !esOtro) {
    if (ultimoTipoEquipo !== '') {
        limpiarFormularioMenosSerie();
        ultimoTipoEquipo = '';
    }
    actualizarBloqueoParte1();
    return;
}


                // ==========================================
                // YA EXISTE UN TIPO
                // ==========================================

                if (mensajeSpecs) {
                    mensajeSpecs.style.display = 'none';
                }


                // ==========================================
                // DETERMINAR SI ES LAPTOP
                // ==========================================

                const nombreTipo = tipoSeleccionado
                    ? String(tipoSeleccionado.nombre).trim().toUpperCase()
                    : tipoTexto;


                if (nombreTipo === 'LAPTOP') {

                    if (laptopBox) {
                        laptopBox.style.display = 'block';
                    }
                    if (equipoBox) {
                        equipoBox.style.display = 'none';
                    }

                    aplicarUltimoRegistro(nombreTipo);

                } else {

                    // Mostrar especificaciones de otros equipos
                    if (equipoBox) {
                        equipoBox.style.display = 'block';
                    }

                    // Ocultar especificaciones de Laptop
                    if (laptopBox) {
                        laptopBox.style.display = 'none';
                    }

                    aplicarUltimoRegistro(nombreTipo);

                }


                // ==========================================
                // ACTUALIZAR BLOQUEO DE PARTE 1
                // ==========================================

                actualizarBloqueoParte1();
    }
function limpiarFormularioMenosSerie() {
    ['marca', 'modelo', 'ubicacion_id'].forEach(function (id) { setCampo(id, ''); });

    ['procesador', 'ram', 'disco_duro', 'color_laptop', 'observaciones_laptop'].forEach(function (id) {
        setCampo(id, '');
    });
    setCampo('estado_laptop', 'REGULAR');

    ['descripcion', 'color_equipo', 'observaciones_equipo'].forEach(function (id) {
        setCampo(id, '');
    });
    setCampo('estado_equipo', 'REGULAR');

    if (fechaRegistro) fechaRegistro.value = fechaHoyISO();

    if (container) {
        container.querySelectorAll('.accesorio-item').forEach(function (item) { item.remove(); });
        actualizarMensaje();
    }
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
        indiceTipoActivo = -1;
    }

    function itemsListaTipo() {
        return listaTipoEq ? Array.from(listaTipoEq.querySelectorAll('div')) : [];
    }

    function pintarActivoTipo() {
        itemsListaTipo().forEach(function (el, i) {
            el.style.backgroundColor = i === indiceTipoActivo ? '#d1e7dd' : '';
        });
        const act = itemsListaTipo()[indiceTipoActivo];
        if (act) act.scrollIntoView({ block: 'nearest' });
    }

    function seleccionarItemTipo(item) {
        if (!item) return;
        const texto = item.textContent.trim().toUpperCase();
        if (texto === 'OTRO') {
            inputTipoEq.value = 'OTRO';
            hiddenTipoEq.value = '';
            mostrarCampoNuevoTipo(true);
            if (inputNuevoTipo) inputNuevoTipo.focus();
        } else {
            const tipo = tiposEquipoData.find(function (t) {
                return String(t.nombre).toUpperCase() === texto;
            });
            inputTipoEq.value = texto;
            hiddenTipoEq.value = tipo ? tipo.id : '';
            mostrarCampoNuevoTipo(false);
        }
        listaTipoEq.style.display = 'none';
        mostrarEspecificaciones();
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
        inputTipoEq.addEventListener('keydown', function (e) {
            const items = itemsListaTipo();
            const visible = listaTipoEq && listaTipoEq.style.display !== 'none' && items.length;
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (!visible) pintarListaTiposEquipo();
                const lista = itemsListaTipo();
                indiceTipoActivo = Math.min(indiceTipoActivo + 1, lista.length - 1);
                pintarActivoTipo();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                indiceTipoActivo = Math.max(indiceTipoActivo - 1, 0);
                pintarActivoTipo();
            } else if (e.key === 'Enter') {
                if (visible && indiceTipoActivo >= 0) {
                    e.preventDefault();
                    seleccionarItemTipo(itemsListaTipo()[indiceTipoActivo]);
                }
            } else if (e.key === 'Escape') {
                listaTipoEq.style.display = 'none';
            }
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

    function tipoEquipoActualNombre() {
        if (inputNuevoTipo && inputNuevoTipo.value.trim()) {
            return inputNuevoTipo.value.trim().toUpperCase();
        }
        return (inputTipoEq ? inputTipoEq.value : '').trim().toUpperCase();
    }

    function sugerirMarcaAccesorio(accesorio) {
        const inputTipo = accesorio.querySelector('.tipo-accesorio');
        const inputMarca = accesorio.querySelector('[name*="[marca]"]');
        if (!inputTipo || !inputMarca) return;
        const tipoAcc = inputTipo.value.trim().toUpperCase();
        if (!tipoAcc || tipoAcc === 'OTRO') return;
        const clave = tipoEquipoActualNombre() + '|' + tipoAcc;
        const marcaSugerida = ultimasMarcasAccesorio[clave];
        if (marcaSugerida && !String(inputMarca.value || '').trim()) {
            inputMarca.value = String(marcaSugerida).toUpperCase();
        }
    }

    function configurarCombobox(accesorio) {
        const input = accesorio.querySelector('.tipo-accesorio');
        const lista = accesorio.querySelector('.lista-tipos-accesorio');
        if (!input || !lista) return;
        let indiceAcc = -1;

        function itemsAcc() {
            return Array.from(lista.querySelectorAll('div'));
        }

        function pintarActivoAcc() {
            itemsAcc().forEach(function (el, i) {
                el.style.backgroundColor = i === indiceAcc ? '#d1e7dd' : '';
            });
            const act = itemsAcc()[indiceAcc];
            if (act) act.scrollIntoView({ block: 'nearest' });
        }

        function elegirTipoAcc(texto) {
            input.value = String(texto).toUpperCase();
            lista.style.display = 'none';
            actualizarTipoPersonalizado(accesorio);
            sugerirMarcaAccesorio(accesorio);
        }

        function mostrarLista() {
            const texto = input.value.trim().toUpperCase();
            lista.innerHTML = '';
            indiceAcc = -1;
            (tiposAccesorios || []).filter(function (tipo) {
                return String(tipo).toUpperCase().includes(texto);
            }).forEach(function (tipo) {
                const opcion = document.createElement('div');
                opcion.className = 'px-3 py-2';
                opcion.style.cursor = 'pointer';
                opcion.textContent = tipo;
                opcion.addEventListener('mousedown', function (event) {
                    event.preventDefault();
                    elegirTipoAcc(tipo);
                });
                lista.appendChild(opcion);
            });
            const opcionOtro = document.createElement('div');
            opcionOtro.className = 'px-3 py-2 fw-semibold';
            opcionOtro.style.cursor = 'pointer';
            opcionOtro.textContent = 'OTRO';
            opcionOtro.addEventListener('mousedown', function (event) {
                event.preventDefault();
                elegirTipoAcc('OTRO');
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
        input.addEventListener('keydown', function (e) {
            const items = itemsAcc();
            const visible = lista.style.display !== 'none' && items.length;
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (!visible) mostrarLista();
                indiceAcc = Math.min(indiceAcc + 1, itemsAcc().length - 1);
                pintarActivoAcc();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                indiceAcc = Math.max(indiceAcc - 1, 0);
                pintarActivoAcc();
            } else if (e.key === 'Enter' && visible && indiceAcc >= 0) {
                e.preventDefault();
                elegirTipoAcc(itemsAcc()[indiceAcc].textContent);
            } else if (e.key === 'Escape') {
                lista.style.display = 'none';
            }
        });
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
            if (!accesorio) return;

            function quitar() {
                accesorio.remove();
                actualizarMensaje();
            }

            function accesorioConDatos(item) {
                const tipo = ((item.querySelector('.tipo-accesorio') || {}).value || '').trim();
                const pers = ((item.querySelector('.tipo-personalizado') || {}).value || '').trim();
                const marca = ((item.querySelector('[name*="[marca]"]') || {}).value || '').trim();
                const serie = ((item.querySelector('[name*="[num_serie]"]') || {}).value || '').trim();
                const obs = ((item.querySelector('[name*="[observaciones]"]') || {}).value || '').trim();
                return !!(tipo || pers || marca || serie || obs);
            }

            if (!accesorioConDatos(accesorio)) {
                quitar();
                return;
            }

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: '¿Eliminar accesorio?',
                    text: 'Esta acción no se puede deshacer.',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then(function (r) {
                    if (r.isConfirmed) quitar();
                });
            } else if (confirm('¿Eliminar accesorio?')) {
                quitar();
            }
        });
    }

    document.addEventListener('click', function (event) {
        document.querySelectorAll('.lista-tipos-accesorio').forEach(function (lista) {
            const accesorio = lista.closest('.accesorio-item');
            if (accesorio && !accesorio.contains(event.target)) lista.style.display = 'none';
        });
    });

            const form = inputTipoEq ? inputTipoEq.closest('form') : null;
                localStorage.setItem(
                    'equipos_filtros_nuevo_equipo',
                    '1'
                );

                form.addEventListener('submit', function () {
                    idsBloqueados.forEach(function (id) {
                        const el = document.getElementById(id);
                        if (el) {
                            el.disabled = false;
                            el.readOnly = false;
                        }
                    });
                });

    /*
     * =========================================================
     * VALIDACIÓN AL ENVIAR EL FORMULARIO
     * (mismo formato usado en prestamo/form.blade.php)
     * =========================================================
     */

    if (form) {

        form.addEventListener('submit', function (event) {

            limpiarErroresCampos();

            const tipoIdCampo = document.getElementById('tipo_equipo_id');

            if (!inputTipoEq || inputTipoEq.value.trim() === '' || !tipoIdCampo || tipoIdCampo.value.trim() === '') {
                event.preventDefault();
                mostrarErrorCampo(inputTipoEq, 'Seleccione o registre un tipo de equipo.');
                return;
            }

            const camposReq = [
                ['num_serie', 'El número de serie es obligatorio.'],
                ['marca', 'La marca es obligatoria.'],
                ['ubicacion_id', 'Seleccione una ubicación.'],
                ['fecha_registro', 'La fecha de registro es obligatoria.']
            ];
            for (const par of camposReq) {
                const c = document.getElementById(par[0]);
                if (!c || String(c.value || '').trim() === '') {
                    event.preventDefault();
                    mostrarErrorCampo(c, par[1]);
                    return;
                }
            }
            if (laptopBox && laptopBox.style.display !== 'none') {
                const lap = [
                    ['procesador', 'El procesador es obligatorio.'],
                    ['ram', 'La memoria RAM es obligatoria.'],
                    ['disco_duro', 'El disco duro es obligatorio.']
                ];
                for (const par of lap) {
                    const c = document.getElementById(par[0]);
                    if (!c || String(c.value || '').trim() === '') {
                        event.preventDefault();
                        mostrarErrorCampo(c, par[1]);
                        return;
                    }
                }
            }

            const filasAcc = this.querySelectorAll('.accesorio-item');
            for (const item of filasAcc) {
                const tipoInp = item.querySelector('.tipo-accesorio');
                const persInp = item.querySelector('.tipo-personalizado');
                const marcaInp = item.querySelector('[name*="[marca]"]');
                const serieInp = item.querySelector('[name*="[num_serie]"]');
                const estadoInp = item.querySelector('[name*="[estado]"]');
                const tipoTxt = ((tipoInp && tipoInp.value) || '').trim().toUpperCase();
                const tipoReal = tipoTxt === 'OTRO' ? ((persInp && persInp.value) || '').trim() : tipoTxt;
                const marcaTxt = ((marcaInp && marcaInp.value) || '').trim();
                const serieTxt = ((serieInp && serieInp.value) || '').trim();
                const estadoTxt = ((estadoInp && estadoInp.value) || '').trim();
                if (!tipoReal && !marcaTxt && !serieTxt) continue;
                if (!tipoReal || !marcaTxt || !serieTxt || !estadoTxt) {
                    event.preventDefault();
                    if (typeof toastr !== 'undefined') {
                        toastr.error('CADA ACCESORIO DEBE TENER TIPO, MARCA, N.º SERIE Y ESTADO.');
                    } else {
                        alert('CADA ACCESORIO DEBE TENER TIPO, MARCA, N.º SERIE Y ESTADO.');
                    }
                    (marcaInp || serieInp || tipoInp)?.focus();
                    return;
                }
            }

            const estadosValidos = ['BUENO', 'REGULAR', 'MALOGRADO'];
            const estadosAccesorios = this.querySelectorAll(
                'select[name*="accesorios"][name$="[estado]"], input[name*="accesorios"][name$="[estado]"]'
            );
            for (const campo of estadosAccesorios) {
                const valor = (campo.value || '').toUpperCase().trim();
                if (!estadosValidos.includes(valor)) {
                    event.preventDefault();
                    mostrarToast('Hay accesorios con estado inválido o vacío.', 'danger');
                    campo.focus();
                    return;
                }
            }

            if (!this.checkValidity()) {
                event.preventDefault();
                this.reportValidity();
                return;
            }
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