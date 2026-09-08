<div class="row padding-1 p-1">

    {{-- ========================================================= --}}
    {{-- PARTE 1 — DATOS DEL PRÉSTAMO --}}
    {{-- ========================================================= --}}

    <div class="col-md-12">

        <div class="card mb-4">

            <div class="card-header encabezado-verde">

                <h5 class="mb-0">

                    <i class="bi bi-clipboard-check"></i>

                    PARTE 1 — DATOS DEL PRÉSTAMO

                </h5>

            </div>


            <div class="card-body">

                <div class="row">

                    {{-- DOCENTE --}}
                    <div class="col-md-6 mb-3">

                        <label for="docente_id" class="form-label">

                            DOCENTE
                            <span class="text-danger">*</span>

                        </label>


                        <div class="position-relative">

                            {{-- ID REAL DEL DOCENTE --}}
                            <input type="hidden" name="docente_id" id="docente_id"
                                value="{{ old('docente_id', $prestamo->docente_id) }}">

                            {{-- BUSCADOR --}}
                            <input type="text" id="buscar_docente"
                                class="form-control @error('docente_id') is-invalid @enderror"
                                placeholder="Escribir nombre o apellido..." autocomplete="off" value="{{ old(
    'buscar_docente',
    $prestamo->exists && $prestamo->docente
    ? $prestamo->docente->apellidos . ' ' . $prestamo->docente->nombres
    : ''
) }}" required>

                            {{-- RESULTADOS --}}
                            <div id="resultados_docentes" class="list-group position-absolute w-100 shadow-sm"
                                style="z-index: 1050; display: none;"></div>

                        </div>

                        @error('docente_id')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-------------- CARGO -----------------}}
                    <div class="col-md-6 mb-3">
                    
                        <label for="cargo" class="form-label">
                    
                            CARGO
                            <span class="text-danger">*</span>
                    
                        </label>
                    
                        <div class="position-relative">
                    
                            <input type="text" name="cargo" id="cargo"
                                class="form-control campo-mayusculas @error('cargo') is-invalid @enderror"
                                value="{{ old('cargo', $prestamo->cargo ?? 'DOCENTE') }}" maxlength="100" autocomplete="off" required>
                    
                            <div id="resultados_cargos" class="list-group position-absolute w-100 shadow-sm"
                                style="z-index: 1050; display: none;"></div>
                    
                        </div>
                    
                        @error('cargo')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror
                    
                    </div>


                    {{-------------- FECHA -----------------}}
                    <div class="col-md-4 mb-3">

                        <label for="fecha" class="form-label">

                            FECHA
                            <span class="text-danger">*</span>

                        </label>


                        <div class="input-group">

                            <input type="date" name="fecha" id="fecha"
                                class="form-control @error('fecha') is-invalid @enderror" value="{{ old(
    'fecha',
    $prestamo->fecha
    ? $prestamo->fecha->format('Y-m-d')
    : now()->format('Y-m-d')
) }}" required>

                            <button type="button" class="btn btn-outline-success" id="btn_hoy">
                                <i class="bi bi-calendar-check"></i>
                                HOY
                            </button>

                        </div>

                        @error('fecha')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- HORA INICIO --}}
                    <div class="col-md-4 mb-3">

                        <label for="hora_inicio" class="form-label">

                            HORA INICIO
                            <span class="text-danger">*</span>

                        </label>

                        <input type="time" name="hora_inicio" id="hora_inicio"
                            class="form-control @error('hora_inicio') is-invalid @enderror" value="{{ old(
    'hora_inicio',
    $prestamo->hora_inicio
    ? substr($prestamo->hora_inicio, 0, 5)
    : ''
) }}" required>


                        @error('hora_inicio')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- HORA FINAL --}}
                    <div class="col-md-4 mb-3">

                        <label for="hora_fin" class="form-label">

                            HORA FINAL

                        </label>

                        <input type="time" name="hora_fin" id="hora_fin"
                            class="form-control @error('hora_fin') is-invalid @enderror" value="{{ old(
    'hora_fin',
    $prestamo->hora_fin
    ? substr($prestamo->hora_fin, 0, 5)
    : ''
) }}">

                        <small class="text-muted">

                            Dejar vacío si el préstamo continúa activo.

                        </small>


                        @error('hora_fin')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- PARTE 2 — SELECCIÓN DE EQUIPOS --}}
    {{-- ========================================================= --}}

    <div class="col-md-12">

        <div class="card mb-4">

            <div class="card-header encabezado-verde">

                <h5 class="mb-0">

                    <i class="bi bi-pc-display"></i>

                    PARTE 2 — SELECCIÓN DE EQUIPOS

                </h5>

            </div>


            <div class="card-body">

                <div class="row">

                    {{-- TIPO DE EQUIPO --}}
                    <div class="col-md-4 mb-3">

                        <label
                            for="tipo_equipo_id"
                            class="form-label"
                        >

                            TIPO DE EQUIPO

                        </label>


                        <select
                            id="tipo_equipo_id"
                            class="form-select"
                        >

                            <option value="">
                                TODOS
                            </option>


                            @foreach ($tiposEquipo as $tipo)

                                <option value="{{ $tipo->id }}">

                                    {{ $tipo->nombre }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- BUSCAR EQUIPO --}}
                    <div class="col-md-8 mb-3">

                        <label
                            for="buscar_equipo"
                            class="form-label"
                        >

                            BUSCAR EQUIPO

                        </label>


                        <input
                            type="text"
                            id="buscar_equipo"
                            class="form-control campo-mayusculas"
                            placeholder="Buscar por tipo, marca, modelo o N/S..."
                            autocomplete="off"
                        >

                    </div>

                </div>


                {{-- RESULTADOS --}}
                <div
                    id="resultados_equipos"
                    class="mt-2"
                >

                    <div class="text-muted text-center py-3">

                        Escribe para buscar un equipo.

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- PARTE 3 — EQUIPOS SELECCIONADOS --}}
    {{-- ========================================================= --}}

    <div class="col-md-12">

        <div class="card mb-4">

            <div class="card-header encabezado-verde">

                <h5 class="mb-0">

                    <i class="bi bi-list-check"></i>

                    PARTE 3 — EQUIPOS SELECCIONADOS

                </h5>

            </div>


            <div class="card-body">

                <div id="equipos_seleccionados">

                    <div
                        id="mensaje_sin_equipos"
                        class="text-center text-muted py-3"
                    >

                        No hay equipos seleccionados.

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- BOTONES --}}
    {{-- ========================================================= --}}

    <div class="col-md-12 mt-2">

        <div class="d-flex justify-content-end gap-2">

            <a
                href="{{ route('prestamos.index') }}"
                class="btn btn-secondary"
            >

                <i class="bi bi-x-circle"></i>

                CANCELAR

            </a>


            <button
                type="submit"
                class="btn btn-success"
            >

                <i class="bi bi-save"></i>

                {{ $prestamo->exists ? 'ACTUALIZAR PRÉSTAMO' : 'GUARDAR PRÉSTAMO' }}

            </button>

        </div>

    </div>

</div>



{{-- ============================================================= --}}
{{-- DATOS EXISTENTES PARA EDICIÓN --}}
{{-- ============================================================= --}}

<script>

    const prestamosExistentes = {!! json_encode(
    $prestamo->exists
    ? $prestamo->prestamoEquipos->map(function ($prestamoEquipo) {
        return [
            'equipo_id' => $prestamoEquipo->equipo_id,
            'estado' => $prestamoEquipo->estado,
            'observacion' => $prestamoEquipo->observacion,

            'equipo' => [
                'id' => $prestamoEquipo->equipo->id,
                'tipo_equipo_id' => $prestamoEquipo->equipo->tipo_equipo_id,
                'marca' => $prestamoEquipo->equipo->marca,
                'modelo' => $prestamoEquipo->equipo->modelo,
                'num_serie' => $prestamoEquipo->equipo->num_serie,

                'tipo_equipo' => [
                    'nombre' => $prestamoEquipo->equipo->tipoEquipo->nombre
                ],

                'accesorios_equipos' =>
                    $prestamoEquipo->equipo->accesoriosEquipos->map(function ($accesorio) use ($prestamoEquipo) {

                        $prestamoAccesorio =
                            $prestamoEquipo->prestamoAccesorios
                                ->firstWhere(
                                    'accesorio_equipo_id',
                                    $accesorio->id
                                );

                        return [
                            'id' => $accesorio->id,
                            'tipo' => $accesorio->tipo,
                            'marca' => $accesorio->marca,
                            'num_serie' => $accesorio->num_serie,

                            'estado' => $prestamoAccesorio
                                ? $prestamoAccesorio->estado
                                : 'BUENO',

                            'observacion' => $prestamoAccesorio
                                ? $prestamoAccesorio->observacion
                                : null,
                        ];

                    })->values()->toArray()
            ]
        ];
    })->values()->toArray()
    : []
) !!};

</script>

@php
$docentesParaJs = $docentes->map(function ($docente) {
    return [
        'id' => $docente->id,
        'nombres' => $docente->nombres,
        'apellidos' => $docente->apellidos,
        'cargo' => $docente->cargo,
    ];
})->values();
@endphp



{{-- ============================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ============================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const buscarEquipo =
        document.getElementById('buscar_equipo');

    const tipoEquipo =
        document.getElementById('tipo_equipo_id');

    const resultados =
        document.getElementById('resultados_equipos');

    /*
     * =========================================================
     * BUSCADOR DE DOCENTES
     * =========================================================
     */

    const buscarDocente =
        document.getElementById('buscar_docente');

    const docenteId =
        document.getElementById('docente_id');

    const resultadosDocentes =
        document.getElementById('resultados_docentes');


    // Lista de docentes existente en Laravel
    const docentes = @json($docentesParaJs);

    /*
 * =========================================================
 * BUSCADOR DE CARGOS
 * =========================================================
 */

const cargo = document.getElementById('cargo');

const resultadosCargos =
    document.getElementById('resultados_cargos');


/*
 * Obtener cargos únicos de los docentes
 */

const cargos = [
    ...new Set(
        docentes
            .map(docente => docente.cargo)
            .filter(cargo => cargo && cargo.trim() !== '')
            .map(cargo => cargo.trim())
    )
].sort();


/*
 * BUSCAR CARGO MIENTRAS SE ESCRIBE
 */

cargo.addEventListener(
    'input',
    function () {

        const texto =
            this.value.trim().toLowerCase();


        const resultados =
            cargos.filter(cargoExistente =>
                cargoExistente
                    .toLowerCase()
                    .includes(texto)
            );


        mostrarResultadosCargos(
            resultados
        );
    }
);

/*
 * =========================================================
 * MOSTRAR RESULTADOS DE CARGOS
 * =========================================================
 */

function mostrarResultadosCargos(resultados) {

    resultadosCargos.innerHTML = '';


    /*
     * Si no hay resultados
     */

    if (resultados.length === 0) {

        resultadosCargos.style.display =
            'none';

        return;
    }


    /*
     * Mostrar cargos encontrados
     */

    resultados.forEach(cargoExistente => {

        const elemento =
            document.createElement('button');


        elemento.type = 'button';


        elemento.className =
            'list-group-item list-group-item-action';


        elemento.textContent =
            cargoExistente;


        elemento.addEventListener(
            'click',
            function () {

                cargo.value =
                    cargoExistente;


                resultadosCargos.innerHTML =
                    '';

                resultadosCargos.style.display =
                    'none';


                /*
                 * Disparar input por si
                 * otra función depende del cambio.
                 */

                cargo.dispatchEvent(
                    new Event('change')
                );
            }
        );


        resultadosCargos.appendChild(
            elemento
        );
    });


    resultadosCargos.style.display =
        'block';
}

/*
 * =========================================================
 * OCULTAR CARGOS AL HACER CLIC FUERA
 * =========================================================
 */

document.addEventListener(
    'click',
    function (event) {

        if (
            !cargo.contains(event.target) &&
            !resultadosCargos.contains(event.target)
        ) {

            resultadosCargos.innerHTML = '';

            resultadosCargos.style.display =
                'none';
        }
    }
);

    
    /*
     * BUSCAR MIENTRAS SE ESCRIBE
     */
    buscarDocente.addEventListener(
        'input',
    function () {

            const texto =
            this.value.trim()
                .toLowerCase();

            /*
             * Si está vacío, limpiar resultados.
             */
        if (texto === '') {

                docenteId.value = '';

                resultadosDocentes.innerHTML = '';

                resultadosDocentes.style.display =
                'none';

                    return;
        }


            /*
             * Buscar por nombre o apellido.
             */
        const resultados =
            docentes.filter(docente => {

                    const nombreCompleto =
                    `${docente.apellidos} ${docente.nombres}`
                        .toLowerCase();

                    return nombreCompleto.includes(
                        texto
                    );
            });


            /*
             * Mostrar resultados.
             */
         mostrarResultadosDocentes(
                resultados
            );
        }
);

    
/*
     * MOSTRAR RESULTADOS
     */
    function mostrarResultadosDocentes(
        resultados
) {

        resultadosDocentes.innerHTML = '';


        /*
         * No existen coincidencias.
         */
    if (resultados.length === 0) {

            resultadosDocentes.innerHTML = `
            <div class="list-group-item">

                <div class="text-muted mb-2">
                    No se encontró el docente.
                </div>

                <button
                    type="button"
                    class="btn btn-success btn-sm w-100"
                    id="registrar_docente_nuevo"
                >
                    <i class="bi bi-person-plus"></i>
                    REGISTRAR NUEVO DOCENTE
                </button>

            </div>
        `;

            resultadosDocentes.style.display =
            'block';

                return;
    }


        /*
         * Mostrar docentes encontrados.
         */
    resultados.forEach(docente => {

            const elemento =
            document.createElement('button');

            elemento.type = 'button';

            elemento.className =
            'list-group-item list-group-item-action';

            elemento.innerHTML = `
            <div>
                <strong>
                    ${docente.apellidos}
                    ${docente.nombres}
                </strong>

                <br>

                <small class="text-muted">
                    ${docente.cargo ?? 'Sin cargo'}
                </small>
            </div>
        `;


            elemento.addEventListener(
                'click',
            function () {

                    /*
                     * Guardar ID real.
                     */
                docenteId.value =
                    docente.id;


                    /*
                     * Mostrar nombre completo.
                     */
                buscarDocente.value =
                    `${docente.apellidos} ${docente.nombres}`;


                    /*
                     * Cargar cargo automáticamente.
                     */
                const campoCargo =
                    document.getElementById('cargo');

                    if (campoCargo) {

                        campoCargo.value =
                            docente.cargo ?? '';
                }


                    /*
                     * Ocultar resultados.
                     */
                resultadosDocentes.innerHTML =
                    '';

                    resultadosDocentes.style.display =
                        'none';
                }
        );


            resultadosDocentes.appendChild(
                elemento
            );
    });


        resultadosDocentes.style.display =
            'block';
}

/*
 * =========================================================
 * BOTÓN HOY
 * =========================================================
 */

const fecha =
    document.getElementById('fecha');

const btnHoy =
    document.getElementById('btn_hoy');


btnHoy.addEventListener(
    'click',
    function () {

        const hoy =
            new Date();

        const año =
            hoy.getFullYear();

        const mes =
            String(
                hoy.getMonth() + 1
            ).padStart(2, '0');

        const dia =
            String(
                hoy.getDate()
            ).padStart(2, '0');


        fecha.value  =
                 `${año}-${mes}-${dia}`;


        /*
         * Disparar evento por si
         * alguna otra función depende
         * del cambio de fecha.
         */
        fecha.dispatchEvent(
            new Event('change')
        );
    }
);


    const contenedor =
        document.getElementById('equipos_seleccionados');

    const equiposSeleccionados =
        new Set();


    /* ========================================================= */
    /* BUSCAR EQUIPOS */
    /* ========================================================= */

    buscarEquipo.addEventListener(
        'input',
        buscarEquipos
    );


    tipoEquipo.addEventListener(
        'change',
        buscarEquipos
    );


    function buscarEquipos() {

        const buscar =
            buscarEquipo.value.trim();

        const tipoId =
            tipoEquipo.value;


        if (
            buscar === '' &&
            tipoId === ''
        ) {

            resultados.innerHTML = `

                <div class="text-muted text-center py-3">

                    Escribe para buscar un equipo.

                </div>

            `;

            return;

        }


        resultados.innerHTML = `

            <div class="text-center py-3">

                <div
                    class="spinner-border text-success"
                    role="status"
                ></div>

                <div class="mt-2 text-muted">

                    Buscando equipos...

                </div>

            </div>

        `;


        const parametros =
            new URLSearchParams();


        if (buscar !== '') {

            parametros.append(
                'buscar',
                buscar
            );

        }


        if (tipoId !== '') {

            parametros.append(
                'tipo_equipo_id',
                tipoId
            );

        }


        fetch(
            `{{ route('prestamos.buscarEquipos') }}?${parametros.toString()}`
        )

        .then(response => {

            if (!response.ok) {

                throw new Error(
                    'Error al buscar equipos'
                );

            }

            return response.json();

        })

        .then(equipos => {

            mostrarResultados(equipos);

        })

        .catch(error => {

            console.error(error);

            resultados.innerHTML = `

                <div class="alert alert-danger">

                    Ocurrió un error al buscar los equipos.

                </div>

            `;

        });

    }



    /* ========================================================= */
    /* MOSTRAR RESULTADOS */
    /* ========================================================= */

    function mostrarResultados(equipos) {

        if (equipos.length === 0) {

            resultados.innerHTML = `

                <div class="alert alert-warning">

                    No se encontraron equipos.

                </div>

            `;

            return;

        }


        let html = `

            <div class="list-group">

        `;


        equipos.forEach(equipo => {

            const yaSeleccionado =
                equiposSeleccionados.has(
                    String(equipo.id)
                );


            html += `

                <button

                    type="button"

                    class="
                        list-group-item
                        list-group-item-action
                        equipo-resultado
                        ${yaSeleccionado ? 'disabled' : ''}
                    "

                    data-id="${equipo.id}"

                    ${yaSeleccionado ? 'disabled' : ''}

                >

                    <div
                        class="
                            d-flex
                            justify-content-between
                            align-items-center
                        "
                    >

                        <div>

                            <strong>

                                ${equipo.tipo_equipo?.nombre ?? 'Sin tipo'}

                            </strong>

                            <br>

                            <span>

                                ${equipo.marca ?? ''}

                                ${equipo.modelo ?? ''}

                            </span>

                            <br>

                            <small class="text-muted">

                                N/S:

                                ${equipo.num_serie ?? 'Sin número de serie'}

                            </small>

                        </div>


                        ${
                            yaSeleccionado
                                ? `
                                    <span class="badge bg-success">
                                        SELECCIONADO
                                    </span>
                                  `
                                : `
                                    <span class="badge bg-primary">
                                        SELECCIONAR
                                    </span>
                                  `
                        }

                    </div>

                </button>

            `;

        });


        html += `

            </div>

        `;


        resultados.innerHTML = html;


        document
    .querySelectorAll('.equipo-resultado:not(.disabled)')
    .forEach(elemento => {

        elemento.addEventListener(
            'click',
            function () {

                const equipoId =
                    this.dataset.id;

                const equipo =
                    equipos.find(
                        e => String(e.id) === String(equipoId)
                    );

                if (!equipo) {

                    console.error(
                        'No se pudo encontrar el equipo seleccionado:',
                        equipoId
                    );

                    return;
                }

                agregarEquipo(equipo);

            }
        );

    });

    }

    /* ========================================================= */
    /* AGREGAR EQUIPO */
    /* ========================================================= */
    function agregarEquipo(equipo) {

        if (!equipo || !equipo.id) {

            console.error(
                'Equipo inválido:',
                equipo
            );

            return;
        }

        const equipoId =
            String(equipo.id);

        // Evitar seleccionar el mismo equipo dos veces
        if (equiposSeleccionados.has(equipoId)) {
            return;
        }


        equiposSeleccionados.add(equipoId);


        // Mostrar directamente el equipo seleccionado
        mostrarEquipoSeleccionado(equipo);


        // Limpiar buscador
        buscarEquipo.value = '';


        resultados.innerHTML = `

        <div class="alert alert-success mb-0">

            Equipo agregado correctamente.
            Puedes buscar otro equipo.

        </div>

    `;
}

    /* ========================================================= */
    /* MOSTRAR EQUIPO SELECCIONADO */
    /* ========================================================= */
    function mostrarEquipoSeleccionado(
        equipo,
        estadoEquipo = null,
        observacionEquipo = '',
        accesoriosExistentes = null
    ) {

        /*
         * Si no se proporciona un estado manual,
         * utilizamos el estado actual del equipo.
         */
        if (!estadoEquipo) {
            estadoEquipo = equipo.estado_actual ?? 'BUENO';
        }

        const mensaje =
            document.getElementById('mensaje_sin_equipos');

        if (mensaje) {
            mensaje.remove();
        }

        const indice =
            document.querySelectorAll(
                '.equipo-seleccionado'
            ).length;


        /* =========================================================
           ACCESORIOS DEL EQUIPO
        ========================================================= */

        let accesoriosHtml = '';

        const accesorios =
            accesoriosExistentes ??
            equipo.accesorios_equipos ??
            [];


        if (accesorios.length > 0) {

            accesoriosHtml = accesorios.map(
                (accesorio, accesorioIndex) => {

                    /*
                     * En creación:
                     * usamos el estado actual del accesorio.
                     *
                     * En edición:
                     * accesoriosExistentes contiene el estado
                     * guardado en el préstamo.
                     */
                    const estado =
                        accesorio.estado ?? 'BUENO';

                    const observacion =
                        accesorio.observacion ?? '';


                    return `
                    <div
                        class="border rounded p-3 mb-3 accesorio-prestamo"
                    >

                        <input
                            type="hidden"
                            name="equipos[${indice}][accesorios][${accesorioIndex}][accesorio_equipo_id]"
                            value="${accesorio.id}"
                        >

                        <div class="row">

                            <!-- TIPO -->
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    TIPO
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="${accesorio.tipo ?? ''}"
                                    readonly
                                >

                            </div>


                            <!-- MARCA -->
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    MARCA
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="${accesorio.marca ?? ''}"
                                    readonly
                                >

                            </div>


                            <!-- NÚMERO DE SERIE -->
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    NÚMERO DE SERIE
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="${accesorio.num_serie ?? ''}"
                                    readonly
                                >

                            </div>


                            <!-- ESTADO -->
                            <div class="col-md-5 mb-3">

                                <label class="form-label">
                                    ESTADO
                                    <span class="text-danger">
                                        *
                                    </span>
                                </label>

                                <select
                                    name="equipos[${indice}][accesorios][${accesorioIndex}][estado]"
                                    class="form-select"
                                    required
                                >

                                    <option
                                        value="REGULAR"
                                        ${estado === 'REGULAR' ? 'selected' : ''}
                                    >
                                        REGULAR
                                    </option>

                                    <option
                                        value="BUENO"
                                        ${estado === 'BUENO' ? 'selected' : ''}
                                    >
                                        BUENO
                                    </option>

                                    <option
                                        value="MALOGRADO"
                                        ${estado === 'MALOGRADO' ? 'selected' : ''}
                                    >
                                        MALOGRADO
                                    </option>

                                </select>

                            </div>


                            <!-- OBSERVACIÓN -->
                            <div class="col-md-7 mb-3">

                                <label class="form-label">
                                    OBSERVACIÓN
                                </label>

                                <input
                                    type="text"
                                    name="equipos[${indice}][accesorios][${accesorioIndex}][observacion]"
                                    class="form-control"
                                    value="${observacion}"
                                    placeholder="Observación del accesorio..."
                                >

                            </div>

                        </div>

                    </div>
                `;
                }
            ).join('');

        } else {

            accesoriosHtml = `
            <div class="text-muted">
                Este equipo no tiene accesorios registrados.
            </div>
        `;
        }


        /* =========================================================
           TARJETA DEL EQUIPO
        ========================================================= */

        const equipoHtml = `

        <div
            class="card mb-4 equipo-seleccionado"
            data-equipo-id="${equipo.id}"
        >

            <div class="card-header">

                <div
                    class="
                        d-flex
                        justify-content-between
                        align-items-center
                    "
                >

                    <strong class="titulo-equipo">
                        EQUIPO ${indice + 1}
                    </strong>


                    <button
                        type="button"
                        class="
                            btn
                            btn-danger
                            btn-sm
                            quitar-equipo
                        "
                    >

                        <i class="bi bi-trash"></i>

                        QUITAR

                    </button>

                </div>

            </div>


            <div class="card-body">

                <!-- ID DEL EQUIPO -->

                <input
                    type="hidden"
                    name="equipos[${indice}][equipo_id]"
                    value="${equipo.id}"
                >


                <div class="row">

                    <!-- TIPO -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            TIPO DE EQUIPO
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="${equipo.tipo_equipo?.nombre ?? ''}"
                            readonly
                        >

                    </div>


                    <!-- MARCA -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            MARCA
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="${equipo.marca ?? ''}"
                            readonly
                        >

                    </div>


                    <!-- MODELO -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            MODELO
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="${equipo.modelo ?? ''}"
                            readonly
                        >

                    </div>


                    <!-- NÚMERO DE SERIE -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            NÚMERO DE SERIE
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="${equipo.num_serie ?? ''}"
                            readonly
                        >

                    </div>


                    <!-- ESTADO -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            ESTADO
                            <span class="text-danger">
                                *
                            </span>
                        </label>

                        <select
                            name="equipos[${indice}][estado]"
                            class="form-select"
                            required
                        >

                            <option
                                value="REGULAR"
                                ${estadoEquipo === 'REGULAR' ? 'selected' : ''}
                            >
                                REGULAR
                            </option>

                            <option
                                value="BUENO"
                                ${estadoEquipo === 'BUENO' ? 'selected' : ''}
                            >
                                BUENO
                            </option>

                            <option
                                value="MALOGRADO"
                                ${estadoEquipo === 'MALOGRADO' ? 'selected' : ''}
                            >
                                MALOGRADO
                            </option>

                        </select>

                    </div>


                    <!-- OBSERVACIÓN -->

                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            OBSERVACIÓN DEL EQUIPO
                        </label>

                        <textarea
                            name="equipos[${indice}][observacion]"
                            class="form-control"
                            rows="2"
                            placeholder="Observación del equipo..."
                        >${observacionEquipo ?? ''}</textarea>

                    </div>

                </div>


                <!-- ACCESORIOS -->

                <div class="mt-3">

                    <h6 class="mb-3">

                        <i class="bi bi-puzzle"></i>

                        ACCESORIOS DEL EQUIPO

                    </h6>

                    ${accesoriosHtml}

                </div>

            </div>

        </div>

    `;


        /* =========================================================
           INSERTAR EQUIPO
        ========================================================= */

        contenedor.insertAdjacentHTML(
            'beforeend',
            equipoHtml
        );


        actualizarEventosQuitarEquipo();
    }


    /* ========================================================= */
    /* QUITAR EQUIPO */
    /* ========================================================= */

    function actualizarEventosQuitarEquipo() {

        document
            .querySelectorAll('.quitar-equipo')
            .forEach(boton => {

                boton.onclick = function () {

                    const equipo =
                        this.closest(
                            '.equipo-seleccionado'
                        );


                    if (!equipo) {

                        return;

                    }


                    const equipoId =
                        equipo.dataset.equipoId;


                    equiposSeleccionados.delete(
                        String(equipoId)
                    );


                    equipo.remove();


                    renumerarEquipos();


                    const equipos =
                        document.querySelectorAll(
                            '.equipo-seleccionado'
                        );


                    if (equipos.length === 0) {

                        contenedor.innerHTML = `

                            <div
                                id="mensaje_sin_equipos"
                                class="
                                    text-center
                                    text-muted
                                    py-3
                                "
                            >

                                No hay equipos seleccionados.

                            </div>

                        `;

                    }

                };

            });

    }



    /* ========================================================= */
    /* RENUMERAR EQUIPOS */
    /* ========================================================= */

    function renumerarEquipos() {

        const equipos =
            document.querySelectorAll(
                '.equipo-seleccionado'
            );


        equipos.forEach(
            (equipo, indice) => {

                const titulo =
                    equipo.querySelector(
                        '.titulo-equipo'
                    );


                if (titulo) {

                    titulo.textContent =
                        `EQUIPO ${indice + 1}`;

                }


                equipo
                    .querySelectorAll('[name]')
                    .forEach(campo => {

                        const nombreActual =
                            campo.getAttribute(
                                'name'
                            );


                        const nombreNuevo =
                            nombreActual.replace(
                                /^equipos\[\d+\]/,
                                `equipos[${indice}]`
                            );


                        campo.setAttribute(
                            'name',
                            nombreNuevo
                        );

                    });

            }
        );

    }



    /* ========================================================= */
    /* CARGAR EQUIPOS EXISTENTES EN EDICIÓN */
    /* ========================================================= */

    if (
        Array.isArray(prestamosExistentes)
        &&
        prestamosExistentes.length > 0
    ) {

        prestamosExistentes.forEach(
            prestamoEquipo => {

                const equipo =
                    prestamoEquipo.equipo;


                equiposSeleccionados.add(
                    String(equipo.id)
                );


                mostrarEquipoSeleccionado(

                    equipo,

                    prestamoEquipo.estado
                        ?? 'BUENO',

                    prestamoEquipo.observacion
                        ?? '',

                    equipo.accesorios_equipos
                        ?? []

                );

            }
        );

    }


});

</script>