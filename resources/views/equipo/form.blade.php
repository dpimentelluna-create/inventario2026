<div class="row padding-1 p-1">

    {{-- ===================================================== --}}
    {{-- PARTE 1 - DATOS DEL EQUIPO --}}
    {{-- ===================================================== --}}

    <div class="col-md-12">

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
                    <div class="col-md-6 mb-3">

                        <label for="tipo_equipo_id" class="form-label">
                            Tipo de Equipo
                        </label>

                        <select name="tipo_equipo_id" class="form-select @error('tipo_equipo_id') is-invalid @enderror"
                            id="tipo_equipo_id">

                            <option value="">
                                Seleccione un Tipo de Equipo
                            </option>

                            @foreach($tiposequipo as $id => $nombre)

                                <option value="{{ $id }}" {{ old('tipo_equipo_id', $equipo->tipo_equipo_id ?? '') == $id ? 'selected' : '' }}>
                                    {{ $nombre }}
                                </option>

                            @endforeach

                        </select>

                        @error('tipo_equipo_id')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror

                    </div>


                    {{-- NÚMERO DE SERIE --}}
                    <div class="col-md-6 mb-3">

                        <label for="num_serie" class="form-label">
                            Número de Serie
                        </label>

                        <input type="text" name="num_serie"
                            class="form-control @error('num_serie') is-invalid @enderror"
                            value="{{ old('num_serie', $equipo?->num_serie) }}" id="num_serie"
                            placeholder="Ingrese el número de serie">

                        @error('num_serie')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror

                    </div>


                    {{-- MARCA --}}
                    <div class="col-md-6 mb-3">

                        <label for="marca" class="form-label">
                            Marca
                        </label>

                        <input type="text" name="marca" class="form-control @error('marca') is-invalid @enderror"
                            value="{{ old('marca', $equipo?->marca) }}" id="marca" placeholder="Ingrese la marca">

                        @error('marca')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror

                    </div>


                    {{-- MODELO --}}
                    <div class="col-md-6 mb-3">

                        <label for="modelo" class="form-label">
                            Modelo
                        </label>

                        <input type="text" name="modelo" class="form-control @error('modelo') is-invalid @enderror"
                            value="{{ old('modelo', $equipo?->modelo) }}" id="modelo" placeholder="Ingrese el modelo">

                        @error('modelo')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror

                    </div>


                    {{-- UBICACIÓN --}}
                    <div class="col-md-6 mb-3">

                        <label for="ubicacion_id" class="form-label">
                            Ubicación
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
                    <div class="col-md-6 mb-3">

                        <label for="fecha_registro" class="form-label">
                            Fecha de Registro
                        </label>

                        <input type="date" name="fecha_registro"
                            class="form-control @error('fecha_registro') is-invalid @enderror"
                            value="{{ old('fecha_registro', $equipo?->fecha_registro) }}" id="fecha_registro">

                        @error('fecha_registro')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror

                    </div>
                </div>
            </div>
        </div>

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

                    <h6 class="fw-bold text-success mb-3">
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

                            <input type="text" name="ram" id="ram" class="form-control" placeholder="Ej. 8GB DDR4"
                                value="{{ old('ram', $equipo->especificacionesLaptops?->ram) }}">

                        </div>


                        {{-- DISCO DURO --}}
                        <div class="col-md-6 mb-3">

                            <label for="disco_duro" class="form-label">
                                Disco Duro
                            </label>

                            <input type="text" name="disco_duro" id="disco_duro" class="form-control"
                                placeholder="Ej. SSD 512GB"
                                value="{{ old('disco_duro', $equipo->especificacionesLaptops?->disco_duro) }}">

                        </div>


                        {{-- COLOR --}}
                        <div class="col-md-6 mb-3">

                            <label for="color_laptop" class="form-label">
                                Color
                            </label>

                            <input type="text" name="color_laptop" id="color_laptop" class="form-control"
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

                            <textarea name="observaciones_laptop" id="observaciones_laptop" class="form-control"
                                rows="3"
                                placeholder="Observaciones de la laptop">{{ old('observaciones_laptop', $equipo->especificacionesLaptops?->observaciones) }}</textarea>

                        </div>
                    </div>
                </div>


                {{-- ================================================= --}}
                {{-- ESPECIFICACIONES PARA OTROS EQUIPOS --}}
                {{-- ================================================= --}}

                <div id="especificaciones-equipo" style="display: none;">

                    <h6 class="fw-bold text-success mb-3">
                        <i class="bi bi-box"></i>
                        Especificaciones del Equipo
                    </h6>

                    <div class="row">

                        {{-- DESCRIPCIÓN --}}
                        <div class="col-md-6 mb-3">

                            <label for="descripcion" class="form-label">
                                Descripción
                            </label>

                            <input type="text" name="descripcion" id="descripcion" class="form-control"
                                placeholder="Descripción del equipo"
                                value="{{ old('descripcion', $equipo->especificacionesEquipo?->descripcion) }}">

                        </div>


                        {{-- COLOR --}}
                        <div class="col-md-6 mb-3">

                            <label for="color_equipo" class="form-label">
                                Color
                            </label>

                            <input type="text" name="color_equipo" id="color_equipo" class="form-control"
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

                            <textarea name="observaciones_equipo" id="observaciones_equipo" class="form-control"
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

                        {{-- ACCESORIOS EXISTENTES --}}
                        @if(isset($equipo->accesoriosEquipos))

                            @foreach($equipo->accesoriosEquipos as $indice => $accesorio)

                                <div class="accesorio-item border rounded p-3 mb-3">

                                    {{-- ID DEL ACCESORIO EXISTENTE --}}
                                    <input type="hidden" name="accesorios[{{ $indice }}][id]" value="{{ $accesorio->id }}">

                                    <div class="row">

                                        {{-- TIPO --}}
                                        <div class="col-md-2 mb-3">

                                            <label class="form-label">
                                                Tipo
                                            </label>

                                            <select name="accesorios[{{ $indice }}][tipo]" class="form-select">

                                                <option value="Batería" {{ $accesorio->tipo == 'Batería' ? 'selected' : '' }}>
                                                    Batería
                                                </option>

                                                <option value="Cargador" {{ $accesorio->tipo == 'Cargador' ? 'selected' : '' }}>
                                                    Cargador
                                                </option>

                                            </select>

                                        </div>


                                        {{-- MARCA --}}
                                        <div class="col-md-2 mb-3">

                                            <label class="form-label">
                                                Marca
                                            </label>

                                            <input type="text" name="accesorios[{{ $indice }}][marca]" class="form-control"
                                                value="{{ $accesorio->marca }}" placeholder="Marca">

                                        </div>


                                        {{-- NÚMERO DE SERIE --}}
                                        <div class="col-md-2 mb-3">

                                            <label class="form-label">
                                                N.º de Serie
                                            </label>

                                            <input type="text" name="accesorios[{{ $indice }}][num_serie]" class="form-control"
                                                value="{{ $accesorio->num_serie }}" placeholder="N.º Serie">

                                        </div>


                                        {{-- ESTADO --}}
                                        <div class="col-md-2 mb-3">

                                            <label class="form-label">
                                                Estado
                                            </label>

                                            <select name="accesorios[{{ $indice }}][estado]" class="form-select">

                                                <option value="Regular" {{ $accesorio->estado == 'Regular' ? 'selected' : '' }}>
                                                    REGULAR
                                                </option>

                                                <option value="Bueno" {{ $accesorio->estado == 'Bueno' ? 'selected' : '' }}>
                                                    BUENO
                                                </option>

                                                <option value="Malogrado" {{ $accesorio->estado == 'Malogrado' ? 'selected' : '' }}>
                                                    MALOGRADO
                                                </option>

                                            </select>

                                        </div>


                                        {{-- OBSERVACIONES --}}
                                        <div class="col-md-3 mb-3">

                                            <label class="form-label">
                                                Observaciones
                                            </label>

                                            <textarea name="accesorios[{{ $indice }}][observaciones]" class="form-control"
                                                rows="1" placeholder="Observaciones">{{ $accesorio->observaciones }}</textarea>

                                        </div>


                                        {{-- ELIMINAR --}}
                                        <div class="col-md-1 mb-3 d-flex align-items-end">

                                            <button type="button" class="btn btn-danger btn-eliminar-accesorio"
                                                title="Eliminar accesorio">
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

                        <button type="button" id="agregar-accesorio" class="btn btn-success">
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
            const tipoEquipo = document.getElementById('tipo_equipo_id');
            const laptop = document.getElementById('especificaciones-laptop');
            const equipo = document.getElementById('especificaciones-equipo');
            const mensaje = document.getElementById('mensaje-especificaciones');

            function mostrarEspecificaciones() {

                const textoSeleccionado =
                    tipoEquipo.options[tipoEquipo.selectedIndex]?.text
                        .trim()
                        .toUpperCase();


                // Ocultar todo primero
                laptop.style.display = 'none';
                equipo.style.display = 'none';
                mensaje.style.display = 'none';


                // Si no se seleccionó ningún tipo
                if (!tipoEquipo.value) {
                    mensaje.style.display = 'block';
                    return;
                }


                // Si es LAPTOP
                if (textoSeleccionado === 'LAPTOP') {
                    laptop.style.display = 'block';

                } else {
                    // Cualquier otro tipo
                    equipo.style.display = 'block';
                }

            }

            // Ejecutar cuando se cambie el tipo
            tipoEquipo.addEventListener('change', mostrarEspecificaciones);

            // Ejecutar al cargar la página
            mostrarEspecificaciones();
        });

    </script>



<script>

document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('accesorios-container');
    const botonAgregar = document.getElementById('agregar-accesorio');
    const mensajeVacio = document.getElementById('sin-accesorios');

    // Empezamos después de los accesorios existentes
    let contador = container.children.length;


    // =====================================================
    // ACTUALIZAR MENSAJE
    // =====================================================

    function actualizarMensaje() {

        if (container.children.length === 0) {
            mensajeVacio.style.display = 'block';
        } else {
            mensajeVacio.style.display = 'none';
        }

    }


    actualizarMensaje();


    // =====================================================
    // AGREGAR ACCESORIO
    // =====================================================

    botonAgregar.addEventListener('click', function () {

        mensajeVacio.style.display = 'none';

        const accesorio = document.createElement('div');

        accesorio.className =
            'accesorio-item border rounded p-3 mb-3';

        accesorio.innerHTML = `

            <div class="row">

                {{-- TIPO --}}
                <div class="col-md-2 mb-3">

                    <label class="form-label">
                        Tipo
                    </label>

                    <select
                        name="accesorios[${contador}][tipo]"
                        class="form-select"
                    >

                        <option value="">
                            Seleccione
                        </option>

                        <option value="Batería">
                            Batería
                        </option>

                        <option value="Cargador">
                            Cargador
                        </option>

                    </select>

                </div>


                {{-- MARCA --}}
                <div class="col-md-2 mb-3">

                    <label class="form-label">
                        Marca
                    </label>

                    <input
                        type="text"
                        name="accesorios[${contador}][marca]"
                        class="form-control"
                        placeholder="Marca"
                    >

                </div>


                {{-- NÚMERO DE SERIE --}}
                <div class="col-md-2 mb-3">

                    <label class="form-label">
                        N.º de Serie
                    </label>

                    <input
                        type="text"
                        name="accesorios[${contador}][num_serie]"
                        class="form-control"
                        placeholder="N.º Serie"
                    >

                </div>


                {{-- ESTADO --}}
                <div class="col-md-2 mb-3">

                    <label class="form-label">
                        Estado
                    </label>

                    <select
                        name="accesorios[${contador}][estado]"
                        class="form-select"
                    >

                        <option value="Regular" selected>
                            REGULAR
                        </option>

                        <option value="Bueno">
                            BUENO
                        </option>

                        <option value="Malogrado">
                            MALOGRADO
                        </option>

                    </select>

                </div>


                {{-- OBSERVACIONES --}}
                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        Observaciones
                    </label>

                    <textarea
                        name="accesorios[${contador}][observaciones]"
                        class="form-control"
                        rows="1"
                        placeholder="Observaciones"
                    ></textarea>

                </div>


                {{-- ELIMINAR --}}
                <div class="col-md-1 mb-3 d-flex align-items-end">

                    <button
                        type="button"
                        class="btn btn-danger btn-eliminar-accesorio"
                        title="Eliminar accesorio"
                    >

                        <i class="bi bi-trash"></i>

                    </button>

                </div>

            </div>
        `;

        container.appendChild(accesorio);

        contador++;

        actualizarMensaje();

    });


    // =====================================================
    // ELIMINAR ACCESORIO
    // =====================================================

    container.addEventListener('click', function (event) {

        const botonEliminar =
            event.target.closest('.btn-eliminar-accesorio');

        if (!botonEliminar) {
            return;
        }

        const accesorio =
            botonEliminar.closest('.accesorio-item');

        accesorio.remove();

        actualizarMensaje();

    });

});

</script>