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
                    <div class="col-12 col-lg-6 mb-3">

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
                    <div class="col-12 col-lg-6 mb-3">

                        <label for="marca" class="form-label">
                            Marca
                        </label>

                        <input type="text" name="marca" class="form-control  @error('marca') is-invalid @enderror"
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
                            Modelo
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
                    <div class="col-12 col-lg-6 mb-3">

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
    const tiposAccesorios = @json($tiposAccesorios);
    console.log('TIPOS:', tiposAccesorios);
console.log('CANTIDAD:', tiposAccesorios.length);
</script>


<script>

    document.addEventListener('DOMContentLoaded', function () {

        // =====================================================
        // CONVERTIR TEXTO A MAYÚSCULAS
        // =====================================================

        function convertirAMayusculas(campo) {

            if (!campo) {
                return;
            }

            campo.value = campo.value.toUpperCase();
        }

        // =====================================================
        // CAMPOS CON MAYÚSCULAS
        // =====================================================

        document.querySelectorAll('.campo-mayusculas').forEach(function (campo) {

            campo.addEventListener('input', function () {
                convertirAMayusculas(this);
            });

        });

        // =====================================================
        // VALORES POR DEFECTO PARA LAPTOPS
        // =====================================================

        const valoresPorDefectoLaptop = {
            procesador: 'Intel Core-I3-400 CPU 1.70 Ghz',
            ram: '4GB DDR3',
            disco_duro: 'HGST 465 GB',
            color_laptop: 'NEGRO',
            estado_laptop: 'Regular',
            observaciones_laptop: ' '
        };

        // =====================================================
        // PARTE 2 - ESPECIFICACIONES
        // =====================================================

        const tipoEquipo = document.getElementById('tipo_equipo_id');
        const laptop = document.getElementById('especificaciones-laptop');
        const equipo = document.getElementById('especificaciones-equipo');
        const mensaje = document.getElementById('mensaje-especificaciones');


        function mostrarEspecificaciones() {

            if (!tipoEquipo || !laptop || !equipo || !mensaje) {
                return;
            }

            const textoSeleccionado =
                tipoEquipo.options[tipoEquipo.selectedIndex]?.text
                    .trim()
                    .toUpperCase();


            // Ocultar todo
            laptop.style.display = 'none';
            equipo.style.display = 'none';
            mensaje.style.display = 'none';


            // Sin selección
            if (!tipoEquipo.value) {

                mensaje.style.display = 'block';

                return;
            }


            // LAPTOP
            if (textoSeleccionado === 'LAPTOP') {

                laptop.style.display = 'block';

                // Rellenar valores por defecto
                const procesador = document.getElementById('procesador');
                const ram = document.getElementById('ram');
                const discoDuro = document.getElementById('disco_duro');
                const colorLaptop = document.getElementById('color_laptop');
                const estadoLaptop = document.getElementById('estado_laptop');
                const observacionesLaptop = document.getElementById('observaciones_laptop');

                if (procesador && !procesador.value) {
                    procesador.value = valoresPorDefectoLaptop.procesador;
                }

                if (ram && !ram.value) {
                    ram.value = valoresPorDefectoLaptop.ram;
                }

                if (discoDuro && !discoDuro.value) {
                    discoDuro.value = valoresPorDefectoLaptop.disco_duro;
                }

                if (colorLaptop && !colorLaptop.value) {
                    colorLaptop.value = valoresPorDefectoLaptop.color_laptop;
                }

                if (estadoLaptop && !estadoLaptop.value) {
                    estadoLaptop.value = valoresPorDefectoLaptop.estado_laptop;
                }

                if (observacionesLaptop && !observacionesLaptop.value) {
                    observacionesLaptop.value = valoresPorDefectoLaptop.observaciones_laptop;
                }

            } else {
                // Cualquier otro tipo
                equipo.style.display = 'block';
            }
        }


        if (tipoEquipo) {

            tipoEquipo.addEventListener(
                'change',
                mostrarEspecificaciones
            );

            mostrarEspecificaciones();
        }


        // =====================================================
        // PARTE 3 - ACCESORIOS
        // =====================================================

        const container =
            document.getElementById('accesorios-container');

        const botonAgregar =
            document.getElementById('agregar-accesorio');

        const mensajeVacio =
            document.getElementById('sin-accesorios');


        if (!container) {
            return;
        }


        // =====================================================
        // TIPOS DE ACCESORIOS
        // =====================================================

        const tiposAccesorios =
            @json($tiposAccesorios);


        // =====================================================
        // CONTADOR
        // =====================================================

        let contador =
            container.querySelectorAll('.accesorio-item').length;


        // =====================================================
        // ACTUALIZAR MENSAJE
        // =====================================================

        function actualizarMensaje() {

            if (!mensajeVacio) {
                return;
            }


            const existenAccesorios =
                container.querySelector('.accesorio-item');


            if (existenAccesorios) {

                mensajeVacio.style.display = 'none';

            } else {

                mensajeVacio.style.display = 'block';

            }
        }


        // =====================================================
        // MOSTRAR / OCULTAR "OTRO"
        // =====================================================

        function actualizarTipoPersonalizado(accesorio) {

            const inputTipo =
                accesorio.querySelector('.tipo-accesorio');

            const contenedor =
                accesorio.querySelector('.tipo-personalizado-container');

            const inputPersonalizado =
                accesorio.querySelector('.tipo-personalizado');


            if (
                !inputTipo ||
                !contenedor ||
                !inputPersonalizado
            ) {
                return;
            }


            // Si el usuario escribió "Otro"
            if (
                inputTipo.value.trim().toLowerCase() === 'otro'
            ) {

                contenedor.style.display = 'block';

                inputPersonalizado.required = true;

            } else {

                contenedor.style.display = 'none';

                inputPersonalizado.required = false;
            }
        }


        // =====================================================
        // CONFIGURAR COMBOBOX
        // =====================================================

        function configurarCombobox(accesorio) {

            const input =
                accesorio.querySelector('.tipo-accesorio');

            const lista =
                accesorio.querySelector('.lista-tipos-accesorio');


            if (!input || !lista) {
                return;
            }


            // =================================================
            // MOSTRAR RESULTADOS
            // =================================================

            function mostrarLista() {

                const texto =
                    input.value.trim().toLowerCase();


                lista.innerHTML = '';


                // -------------------------------------------------
                // FILTRAR TIPOS
                // -------------------------------------------------

                const resultados =
                    tiposAccesorios.filter(function (tipo) {

                        return tipo
                            .toLowerCase()
                            .includes(texto);

                    });


                // -------------------------------------------------
                // RESULTADOS
                // -------------------------------------------------

                resultados.forEach(function (tipo) {

                    const opcion =
                        document.createElement('div');


                    opcion.className =
                        'px-3 py-2';


                    opcion.style.cursor =
                        'pointer';


                    opcion.textContent =
                        tipo;


                    // ---------------------------------------------
                    // SELECCIONAR
                    // ---------------------------------------------

                    opcion.addEventListener(
                        'mousedown',
                        function (event) {

                            event.preventDefault();

                            input.value = tipo;

                            lista.style.display = 'none';

                            actualizarTipoPersonalizado(
                                accesorio
                            );

                        }
                    );


                    // ---------------------------------------------
                    // EFECTO AL PASAR EL MOUSE
                    // ---------------------------------------------

                    opcion.addEventListener(
                        'mouseenter',
                        function () {

                            opcion.style.backgroundColor =
                                '#f0f0f0';

                        }
                    );


                    opcion.addEventListener(
                        'mouseleave',
                        function () {

                            opcion.style.backgroundColor =
                                '';

                        }
                    );


                    lista.appendChild(opcion);

                });


                // -------------------------------------------------
                // OPCIÓN "OTRO"
                // -------------------------------------------------

                const opcionOtro =
                    document.createElement('div');


                opcionOtro.className =
                    'px-3 py-2';


                opcionOtro.style.cursor =
                    'pointer';


                opcionOtro.textContent =
                    'Otro...';


                opcionOtro.addEventListener(
                    'mousedown',
                    function (event) {

                        event.preventDefault();

                        input.value = 'Otro';

                        lista.style.display = 'none';

                        actualizarTipoPersonalizado(
                            accesorio
                        );

                    }
                );


                opcionOtro.addEventListener(
                    'mouseenter',
                    function () {

                        opcionOtro.style.backgroundColor =
                            '#f0f0f0';

                    }
                );


                opcionOtro.addEventListener(
                    'mouseleave',
                    function () {

                        opcionOtro.style.backgroundColor =
                            '';

                    }
                );


                lista.appendChild(opcionOtro);


                // -------------------------------------------------
                // MOSTRAR LISTA
                // -------------------------------------------------

                lista.style.display =
                    'block';
            }


            // =================================================
            // AL ESCRIBIR
            // =================================================

            input.addEventListener(
                'input',
                function () {

                    mostrarLista();

                    actualizarTipoPersonalizado(
                        accesorio
                    );

                }
            );


            // =================================================
            // AL HACER CLICK
            // =================================================

            input.addEventListener(
                'focus',
                function () {

                    mostrarLista();

                }
            );


            // =================================================
            // CERRAR LISTA AL HACER CLICK AFUERA
            // =================================================

            document.addEventListener(
                'click',
                function (event) {

                    if (
                        !accesorio.contains(
                            event.target
                        )
                    ) {

                        lista.style.display =
                            'none';

                    }

                }
            );

        }


        // =====================================================
        // CONFIGURAR ACCESORIOS EXISTENTES
        // =====================================================

        container
            .querySelectorAll('.accesorio-item')
            .forEach(function (accesorio) {

                configurarCombobox(accesorio);

                actualizarTipoPersonalizado(
                    accesorio
                );

            });


        actualizarMensaje();


        // =====================================================
        // AGREGAR NUEVO ACCESORIO
        // =====================================================

        if (botonAgregar) {

            botonAgregar.addEventListener(
                'click',
                function () {


                    const accesorio =
                        document.createElement('div');


                    accesorio.className =
                        'accesorio-item border rounded p-3 mb-3';


                    accesorio.innerHTML = `

                    <div class="row">

                        {{-- TIPO --}}
                        <div class="col-12 col-md-12 mb-3">

                            <label class="form-label">
                                Tipo
                            </label>

                            <div class="contenedor-tipo-accesorio position-relative">

    <input
        type="text"
        name="accesorios[${contador}][tipo]"
        class="form-control tipo-accesorio campo-mayusculas"
        placeholder="Escriba o seleccione..."
        autocomplete="off"
    >

    <div
        class="lista-tipos-accesorio"
        style="
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            max-height: 300px;
            overflow-y: auto;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,.15);
            z-index: 9999;
        "
    >
    </div>

</div>

                            {{-- TIPO PERSONALIZADO --}}
                            <div
                                class="tipo-personalizado-container mt-2"
                                style="display: none;"
                            >

                                <label class="form-label">
                                    Especifique el tipo
                                </label>

                                <input
                                    type="text"
                                    name="accesorios[${contador}][tipo_personalizado]"
                                    class="form-control tipo-personalizado campo-mayusculas"
                                    placeholder="Ej. Cable HDMI"
                                >

                            </div>

                        </div>


                        {{-- MARCA --}}
                        <div class="col-12 col-md-12 mb-3">

                            <label class="form-label">
                                Marca
                            </label>

                            <input
                                type="text"
                                name="accesorios[${contador}][marca]"
                                class="form-control campo-mayusculas"
                                placeholder="Marca"
                            >

                        </div>


                        {{-- NÚMERO DE SERIE --}}
                        <div class="col-12 col-md-12 mb-3">

                            <label class="form-label">
                                N.º de Serie
                            </label>

                            <input
                                type="text"
                                name="accesorios[${contador}][num_serie]"
                                class="form-control campo-mayusculas"
                                placeholder="N.º Serie"
                            >

                        </div>


                        {{-- ESTADO --}}
                        <div class="col-12 col-md-12 mb-3">

                            <label class="form-label">
                                Estado
                            </label>

                            <select
                                name="accesorios[${contador}][estado]"
                                class="form-select"
                            >

                                <option
                                    value="Regular"
                                    selected
                                >
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
                        <div class="col-12 col-md-12 mb-3">

                            <label class="form-label">
                                Observaciones
                            </label>

                            <textarea
                                name="accesorios[${contador}][observaciones]"
                                class="form-control campo-mayusculas"
                                rows="1"
                                placeholder="Observaciones"
                            ></textarea>

                        </div>


                        {{-- ELIMINAR --}}
                        <div class="col-12 col-md-1 mb-3 d-flex align-items-end">

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


                    container.appendChild(
                        accesorio
                    );

                    // Aplicar mayúsculas a los campos del nuevo accesorio
                    accesorio.querySelectorAll('.campo-mayusculas').forEach(function (campo) {

                        campo.addEventListener('input', function () {
                            convertirAMayusculas(this);
                        });

                    });

                    // Configurar combobox
                    configurarCombobox(
                        accesorio
                    );

                    contador++;

                    actualizarMensaje();

                }
            );

        }


        // =====================================================
        // ELIMINAR ACCESORIO
        // =====================================================

        container.addEventListener(
            'click',
            function (event) {

                const botonEliminar =
                    event.target.closest(
                        '.btn-eliminar-accesorio'
                    );


                if (!botonEliminar) {
                    return;
                }

                const confirmar = confirm(
                    '¿Está seguro de que desea eliminar este accesorio?'
                );

                 if (!confirmar) {
                    return;
                }

                const accesorio =
                    botonEliminar.closest(
                        '.accesorio-item'
                    );


                if (accesorio) {

                    accesorio.remove();

                }

                actualizarMensaje();

            }
        );


        // =====================================================
        // CERRAR COMBOBOX AL HACER CLICK FUERA
        // =====================================================

        document.addEventListener(
            'click',
            function (event) {

                document
                    .querySelectorAll(
                        '.lista-tipos-accesorio'
                    )
                    .forEach(function (lista) {

                        const accesorio =
                            lista.closest(
                                '.accesorio-item'
                            );


                        if (
                            accesorio &&
                            !accesorio.contains(
                                event.target
                            )
                        ) {

                            lista.style.display =
                                'none';

                        }

                    });

            }
        );
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