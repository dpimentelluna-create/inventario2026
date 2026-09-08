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

                    {{-- SOLICITANTE O DOCENTE --}}
                    <div class="col-md-6 mb-3">

                        <label for="docente_id" class="form-label">

                            SOLICITANTE
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
                            <div id="resultados_docentes" class="list-group position-absolute w-100 shadow-sm" style="
                                        z-index: 1050; 
                                        display: none;
                                        max-height: 240px;
                                        overflow-y: auto;
                                        background: white;"></div>

                        </div>

                        @error('docente_id')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- ========================================================= --}}
                    {{-- CARGO DEL SOLICITANTE --}}
                    {{-- ========================================================= --}}

                    <div class="col-md-6 mb-3">

                        <label for="cargo" class="form-label">
                            CARGO
                        </label>

                        <input type="text" name="cargo" id="cargo" class="form-control"
                            value="{{ old('cargo', $prestamo->cargo ?? '') }}" readonly>

                        @error('cargo')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- ========================================================= --}}
                    {{-- FORMULARIO NUEVO DOCENTE --}}
                    {{-- ========================================================= --}}

                    <div class="modal fade" id="modalNuevoDocente" tabindex="-1"
                        aria-labelledby="modalNuevoDocenteLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalNuevoDocenteLabel">
                                        <i class="bi bi-person-plus"></i>
                                        REGISTRAR NUEVO SOLICITANTE
                                    </h5>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Cerrar"></button>
                                </div>

                                <div class="modal-body">

                                    {{-- NOMBRES --}}
                                    <div class="mb-3">

                                        <label for="nuevo_docente_nombres" class="form-label">
                                            NOMBRES
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input type="text" id="nuevo_docente_nombres"
                                            class="form-control campo-mayusculas" maxlength="100">

                                    </div>

                                    {{-- APELLIDOS --}}
                                    <div class="mb-3">

                                        <label for="nuevo_docente_apellidos" class="form-label">
                                            APELLIDOS
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input type="text" id="nuevo_docente_apellidos"
                                            class="form-control campo-mayusculas" maxlength="100">

                                    </div>

                                    {{-- CARGO --}}
                                    <div class="mb-3">

                                        <label for="nuevo_docente_cargo" class="form-label">
                                            CARGO
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input type="text" id="nuevo_docente_cargo"
                                            class="form-control campo-mayusculas" maxlength="100">

                                    </div>

                                    {{-- MENSAJE DE ERROR --}}
                                    <div id="error_nuevo_docente" class="alert alert-danger d-none"></div>

                                </div>

                                <div class="modal-footer">

                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        CANCELAR
                                    </button>

                                    <button type="button" class="btn btn-success" id="btn_guardar_nuevo_docente">
                                        <i class="bi bi-save"></i>
                                        REGISTRAR DOCENTE
                                    </button>

                                </div>

                            </div>
                        </div>
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

    <label for="hora_inicio_texto" class="form-label">
        HORA INICIO
        <span class="text-danger">*</span>
    </label>

    {{-- Campo visible --}}
    <input
        type="text"
        id="hora_inicio_texto"
        class="form-control @error('hora_inicio') is-invalid @enderror"
        value="{{ old(
            'hora_inicio',
            $prestamo->hora_inicio
            ? date('h:i A', strtotime($prestamo->hora_inicio))
            : ''
        ) }}"
        placeholder="00:00 AM"
        maxlength="8"
        autocomplete="off"
        inputmode="numeric"
        required
    >

    {{-- Valor que realmente recibe Laravel --}}
    <input
        type="hidden"
        name="hora_inicio"
        id="hora_inicio"
        value="{{ old(
            'hora_inicio',
            $prestamo->hora_inicio
            ? substr($prestamo->hora_inicio, 0, 5)
            : ''
        ) }}"
    >

    <small class="text-muted">
        HORARIO: 06:30 AM - 03:30 PM
    </small>

    @error('hora_inicio')
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror

</div>


                   
{{-- HORA FINAL --}}
<div class="col-md-4 mb-3">

    <label for="hora_fin_texto" class="form-label">
        HORA FINAL
    </label>

    {{-- Campo visible --}}
    <input
        type="text"
        id="hora_fin_texto"
        class="form-control @error('hora_fin') is-invalid @enderror"
        value="{{ old(
            'hora_fin',
            $prestamo->hora_fin
            ? date('h:i A', strtotime($prestamo->hora_fin))
            : ''
        ) }}"
        placeholder="00:00 AM"
        maxlength="8"
        autocomplete="off"
        inputmode="numeric"
    >

    {{-- Valor que realmente recibe Laravel --}}
    <input
        type="hidden"
        name="hora_fin"
        id="hora_fin"
        value="{{ old(
            'hora_fin',
            $prestamo->hora_fin
            ? substr($prestamo->hora_fin, 0, 5)
            : ''
        ) }}"
    >

    <small class="text-muted">
        DEJAR VACÍO SI EL PRÉSTAMO CONTINÚA ACTIVO.
    </small>

    @error('hora_fin')
        <div class="invalid-feedback d-block">
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

    let indiceDocenteSeleccionado = -1;
    
    let docentesFiltrados = [];

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

if (cargo && resultadosCargos) {

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

}

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
 * =========================================================
 * BUSCADOR DE DOCENTES
 * =========================================================
 */


/*
 * =========================================================
 * MOSTRAR RESULTADOS DE DOCENTES
 * =========================================================
 */

function mostrarResultadosDocentes(resultados) {

    docentesFiltrados = resultados;

    resultadosDocentes.innerHTML = '';

    indiceDocenteSeleccionado = -1;


    /*
     * Si no hay resultados
     */

    if (resultados.length === 0) {

    resultadosDocentes.innerHTML = `
        <div class="list-group-item text-muted">
            No se encontró ningún docente.
        </div>

        <button
            type="button"
            class="list-group-item list-group-item-action text-success fw-bold"
            id="btn_nuevo_docente"
        >
            <i class="bi bi-person-plus"></i>
            REGISTRAR NUEVO DOCENTE
        </button>
    `;

    resultadosDocentes.style.display = 'block';

    document
        .getElementById('btn_nuevo_docente')
        .addEventListener('mousedown', function (event) {

            event.preventDefault();

            mostrarFormularioNuevoDocente();

        });

    return;
}


    /*
     * Mostrar docentes
     */

    resultados.forEach(function (docente, indice) {

        const elemento =
            document.createElement('button');


        elemento.type = 'button';


        elemento.className =
            'list-group-item list-group-item-action';


        elemento.dataset.indice =
            indice;


        elemento.innerHTML = `
            <div>
                <strong>
                    ${docente.apellidos}
                    ${docente.nombres}
                </strong>

                <br>

                <small class="text-muted">
                    ${docente.cargo ?? 'SIN CARGO'}
                </small>
            </div>
        `;


        /*
         * Seleccionar con mouse
         */

        elemento.addEventListener(
            'mousedown',
            function (event) {

                event.preventDefault();

                seleccionarDocente(docente);

            }
        );


        /*
         * Efecto visual al pasar el mouse
         */

        elemento.addEventListener(
            'mouseenter',
            function () {

                indiceDocenteSeleccionado =
                    indice;

                actualizarOpcionSeleccionada();

            }
        );


        resultadosDocentes.appendChild(
            elemento
        );

    });


    /*
     * Mostrar lista
     */

    resultadosDocentes.style.display =
        'block';
}

function mostrarFormularioNuevoDocente() {

    resultadosDocentes.innerHTML = '';
    resultadosDocentes.style.display = 'none';

    const modalElemento =
        document.getElementById('modalNuevoDocente');

    const modal =
        new bootstrap.Modal(modalElemento);

    // Limpiar campos
    document.getElementById(
        'nuevo_docente_nombres'
    ).value = '';

    document.getElementById(
        'nuevo_docente_apellidos'
    ).value = '';

    document.getElementById(
        'nuevo_docente_cargo'
    ).value = '';

    document.getElementById(
        'error_nuevo_docente'
    ).classList.add('d-none');

    modal.show();

}

// =========================================================
// REGISTRAR NUEVO DOCENTE
// =========================================================

const btnGuardarNuevoDocente =
    document.getElementById('btn_guardar_nuevo_docente');

if (btnGuardarNuevoDocente) {

    btnGuardarNuevoDocente.addEventListener('click', function () {

        const nombres =
            document.getElementById('nuevo_docente_nombres').value.trim();

        const apellidos =
            document.getElementById('nuevo_docente_apellidos').value.trim();

        const nuevoCargo =
            document.getElementById('nuevo_docente_cargo').value.trim();

        const errorNuevoDocente =
            document.getElementById('error_nuevo_docente');

        // Limpiar error anterior
        errorNuevoDocente.classList.add('d-none');
        errorNuevoDocente.textContent = '';

        // Validación básica
        if (!nombres || !apellidos || !nuevoCargo) {

            errorNuevoDocente.textContent =
                'NOMBRES, APELLIDOS Y CARGO SON OBLIGATORIOS.';

            errorNuevoDocente.classList.remove('d-none');

            return;
        }

        // Desactivar botón mientras se guarda
        btnGuardarNuevoDocente.disabled = true;
        btnGuardarNuevoDocente.innerHTML =
            '<span class="spinner-border spinner-border-sm"></span> REGISTRANDO...';

        fetch('{{ route('prestamos.registrarDocente') }}', {

            method: 'POST',

            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN':
                    document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },

            body: JSON.stringify({

                nombres: nombres.toUpperCase(),
                apellidos: apellidos.toUpperCase(),
                cargo: nuevoCargo.toUpperCase()

            })

        })

        .then(async response => {

            const data = await response.json();

            if (!response.ok) {
                throw data;
            }

            return data;

        })

        .then(data => {

            const nuevoDocente = data.docente;

            // Agregar el nuevo docente a la lista local
            docentes.push(nuevoDocente);

            // Seleccionar automáticamente el nuevo docente
            docenteId.value = nuevoDocente.id;

            buscarDocente.value =
                `${nuevoDocente.apellidos} ${nuevoDocente.nombres}`;

            cargo.value = nuevoDocente.cargo;

            // Agregar el nuevo cargo a la lista de cargos
            if (
                !cargos.some(
                    cargoExistente =>
                        cargoExistente.toLowerCase() ===
                        nuevoDocente.cargo.toLowerCase()
                )
            ) {

                cargos.push(nuevoDocente.cargo);
                cargos.sort();

            }

            // Cerrar modal
            const modalElemento =
                document.getElementById('modalNuevoDocente');

            const modal =
                bootstrap.Modal.getInstance(modalElemento);

            if (modal) {
                modal.hide();
            }

            // Limpiar resultados
            resultadosDocentes.innerHTML = '';
            resultadosDocentes.style.display = 'none';

            indiceDocenteSeleccionado = -1;

        })

        .catch(error => {

            console.error(error);

            if (error.errors) {

                const mensajes =
                    Object.values(error.errors).flat();

                errorNuevoDocente.innerHTML =
                    mensajes.join('<br>');

            } else {

                errorNuevoDocente.textContent =
                    'NO SE PUDO REGISTRAR EL DOCENTE. INTENTA NUEVAMENTE.';

            }

            errorNuevoDocente.classList.remove('d-none');

        })

        .finally(() => {

            btnGuardarNuevoDocente.disabled = false;

            btnGuardarNuevoDocente.innerHTML =
                '<i class="bi bi-save"></i> REGISTRAR DOCENTE';

        });

    });

}

/*
 * =========================================================
 * SELECCIONAR DOCENTE
 * =========================================================
 */

function seleccionarDocente(docente) {

    /*
     * Guardar ID real
     */

    docenteId.value =
        docente.id;


    /*
     * Mostrar nombre completo
     */

    buscarDocente.value =
        `${docente.apellidos} ${docente.nombres}`;


    /*
     * Cargar cargo
     */

    const campoCargo =
        document.getElementById('cargo');


    if (campoCargo) {

        campoCargo.value =
            docente.cargo ?? '';

    }


    /*
     * Ocultar resultados
     */

    resultadosDocentes.innerHTML =
        '';

    resultadosDocentes.style.display =
        'none';


    /*
     * Reiniciar selección
     */

    indiceDocenteSeleccionado =
        -1;

}


/*
 * =========================================================
 * BUSCAR MIENTRAS SE ESCRIBE
 * =========================================================
 */

buscarDocente.addEventListener(
    'input',
    function () {

        const texto =
            this.value
                .trim()
                .toLowerCase();


        /*
         * Al modificar el texto,
         * el ID anterior deja de ser válido.
         */

        docenteId.value =
            '';


        /*
         * Filtrar docentes
         */

        const resultados =
            docentes.filter(function (docente) {

                const nombreCompleto =
                    `${docente.apellidos} ${docente.nombres}`
                        .toLowerCase();


                return nombreCompleto.includes(
                    texto
                );

            });


        /*
         * Mostrar resultados
         */

        mostrarResultadosDocentes(
            resultados
        );

    }
);


/*
 * =========================================================
 * MOSTRAR DOCENTES AL HACER CLICK EN EL CAMPO
 * =========================================================
 */

buscarDocente.addEventListener(
    'focus',
    function () {

        const texto =
            this.value
                .trim()
                .toLowerCase();


        let resultados;


        /*
         * Campo vacío:
         * mostrar TODOS los docentes.
         */

        if (texto === '') {

            resultados =
                docentes;

        } else {

            /*
             * Si ya existe texto:
             * mostrar coincidencias.
             */

            resultados =
                docentes.filter(
                    function (docente) {

                        const nombreCompleto =
                            `${docente.apellidos} ${docente.nombres}`
                                .toLowerCase();


                        return nombreCompleto.includes(
                            texto
                        );

                    }
                );

        }


        mostrarResultadosDocentes(
            resultados
        );

    }
);


/*
 * =========================================================
 * NAVEGACIÓN CON TECLADO
 * =========================================================
 */

buscarDocente.addEventListener(
    'keydown',
    function (event) {

        const opciones =
            resultadosDocentes.querySelectorAll(
                '.list-group-item-action'
            );


        /*
         * No hacer nada si
         * no existen opciones.
         */

        if (opciones.length === 0) {

            return;

        }


        /*
         * -------------------------------------------------
         * FLECHA ABAJO
         * -------------------------------------------------
         */

        if (event.key === 'ArrowDown') {

            event.preventDefault();


            indiceDocenteSeleccionado++;


            if (
                indiceDocenteSeleccionado >=
                opciones.length
            ) {

                indiceDocenteSeleccionado =
                    0;

            }


            actualizarOpcionSeleccionada();

        }


        /*
         * -------------------------------------------------
         * FLECHA ARRIBA
         * -------------------------------------------------
         */

        else if (event.key === 'ArrowUp') {

            event.preventDefault();


            indiceDocenteSeleccionado--;


            if (
                indiceDocenteSeleccionado < 0
            ) {

                indiceDocenteSeleccionado =
                    opciones.length - 1;

            }


            actualizarOpcionSeleccionada();

        }


        /*
         * -------------------------------------------------
         * ENTER
         * -------------------------------------------------
         */

        else if (
            event.key === 'Enter' &&
            indiceDocenteSeleccionado >= 0
        ) {

            event.preventDefault();


            const docente =
                docentesFiltrados[
                    indiceDocenteSeleccionado
                ];


            if (docente) {

                seleccionarDocente(
                    docente
                );

            }

        }

    }
);


/*
 * =========================================================
 * DOCENTES FILTRADOS ACTUALES
 * =========================================================
 */

/*
 * =========================================================
 * ACTUALIZAR OPCIÓN SELECCIONADA
 * =========================================================
 */

function actualizarOpcionSeleccionada() {

    const opciones =
        resultadosDocentes.querySelectorAll(
            '.list-group-item-action'
        );


    opciones.forEach(
        function (opcion, indice) {

            if (
                indice ===
                indiceDocenteSeleccionado
            ) {

                opcion.style.backgroundColor =
                    '#f0f0f0';


                opcion.scrollIntoView({
                    block: 'nearest'
                });

            } else {

                opcion.style.backgroundColor =
                    '';

            }

        }
    );

}


/*
 * =========================================================
 * CERRAR AL HACER CLICK FUERA
 * =========================================================
 */

document.addEventListener(
    'click',
    function (event) {

        if (
            !buscarDocente.contains(
                event.target
            ) &&
            !resultadosDocentes.contains(
                event.target
            )
        ) {

            resultadosDocentes.innerHTML =
                '';

            resultadosDocentes.style.display =
                'none';


            indiceDocenteSeleccionado =
                -1;

        }

    }
);
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

// =========================================================
// MÁSCARA Y VALIDACIÓN DE HORARIOS
// =========================================================

const horaInicioTexto = document.getElementById('hora_inicio_texto');
const horaInicioReal = document.getElementById('hora_inicio');

const horaFinTexto = document.getElementById('hora_fin_texto');
const horaFinReal = document.getElementById('hora_fin');


// ---------------------------------------------------------
// CONVERTIR HORA 24H A FORMATO 12H
// ---------------------------------------------------------
function convertirHora12(horas, minutos) {

    const periodo = horas >= 12 ? 'PM' : 'AM';

    let hora12 = horas % 12;

    if (hora12 === 0) {
        hora12 = 12;
    }

    return (
        String(hora12).padStart(2, '0') +
        ':' +
        String(minutos).padStart(2, '0') +
        ' ' +
        periodo
    );
}


// ---------------------------------------------------------
// CONVERTIR HORA 12H A 24H
// ---------------------------------------------------------
function convertirA24(horas, minutos, periodo) {

    let horas24 = horas;

    if (periodo === 'AM') {

        if (horas === 12) {
            horas24 = 0;
        }

    } else {

        if (horas >= 1 && horas <= 11) {
            horas24 = horas + 12;
        }
    }

    return (
        String(horas24).padStart(2, '0') +
        ':' +
        String(minutos).padStart(2, '0')
    );
}


// ---------------------------------------------------------
// PROCESAR HORA AL SALIR DEL CAMPO
// ---------------------------------------------------------
function procesarHora(campoTexto, campoReal, obligatorio) {

    if (!campoTexto || !campoReal) return;

    let valor = campoTexto.value.trim().toUpperCase();

    if (valor === '') {

        campoReal.value = '';

        if (obligatorio) {
            campoTexto.setCustomValidity(
                'LA HORA DE INICIO ES OBLIGATORIA.'
            );
        } else {
            campoTexto.setCustomValidity('');
        }

        return;
    }


    // -----------------------------------------------------
    // DETECTAR AM / PM
    // -----------------------------------------------------

    let periodo = '';

    if (valor.includes('AM')) {
        periodo = 'AM';
    }

    if (valor.includes('PM')) {
        periodo = 'PM';
    }


    // Eliminar AM / PM
    valor = valor
        .replace(/AM/g, '')
        .replace(/PM/g, '')
        .trim();


    // -----------------------------------------------------
    // SEPARAR HORA Y MINUTOS
    // -----------------------------------------------------

    let horas;
    let minutos;


    if (valor.includes(':')) {

        const partes = valor.split(':');

        if (partes.length !== 2) {

            campoReal.value = '';

            campoTexto.setCustomValidity(
                'FORMATO INVÁLIDO. EJEMPLO: 2:10'
            );

            return;
        }

        horas = parseInt(partes[0], 10);
        minutos = parseInt(partes[1], 10);

    } else {

        const numeros = valor.replace(/\D/g, '');

        if (numeros.length === 3) {

            horas = parseInt(
                numeros.substring(0, 1),
                10
            );

            minutos = parseInt(
                numeros.substring(1, 3),
                10
            );

        } else if (numeros.length === 4) {

            horas = parseInt(
                numeros.substring(0, 2),
                10
            );

            minutos = parseInt(
                numeros.substring(2, 4),
                10
            );

        } else {

            campoReal.value = '';

            campoTexto.setCustomValidity(
                'INGRESA LA HORA. EJEMPLO: 2:10'
            );

            return;
        }
    }


    // -----------------------------------------------------
    // VALIDAR NÚMEROS
    // -----------------------------------------------------

    if (
        Number.isNaN(horas) ||
        Number.isNaN(minutos)
    ) {

        campoReal.value = '';

        campoTexto.setCustomValidity(
            'INGRESA UNA HORA VÁLIDA.'
        );

        return;
    }


    // -----------------------------------------------------
    // VALIDAR MINUTOS
    // -----------------------------------------------------

    if (minutos < 0 || minutos > 59) {

        campoReal.value = '';

        campoTexto.setCustomValidity(
            'LOS MINUTOS DEBEN ESTAR ENTRE 00 Y 59.'
        );

        return;
    }


    // -----------------------------------------------------
    // SI NO ESCRIBIÓ AM / PM
    // -----------------------------------------------------
    //
    // REGLA DEL SISTEMA:
    //
    // 06:30 - 11:59 = AM
    // 12:00 - 12:59 = PM
    // 01:00 - 03:30 = PM
    //
    // Por eso:
    // 2:10 -> 02:10 PM
    // 8:30 -> 08:30 AM
    // 11:45 -> 11:45 AM
    // 12:00 -> 12:00 PM
    // 3:30 -> 03:30 PM
    // -----------------------------------------------------

    if (periodo === '') {

        if (horas >= 6 && horas <= 11) {

            periodo = 'AM';

        } else if (horas === 12) {

            periodo = 'PM';

        } else if (horas >= 1 && horas <= 3) {

            periodo = 'PM';

        } else {

            campoReal.value = '';

            campoTexto.setCustomValidity(
                'EL HORARIO PERMITIDO ES DE 06:30 AM A 03:30 PM.'
            );

            return;
        }
    }


    // -----------------------------------------------------
    // VALIDAR RANGO DE HORAS
    // -----------------------------------------------------

    if (horas < 1 || horas > 12) {

        campoReal.value = '';

        campoTexto.setCustomValidity(
            'LA HORA DEBE ESTAR ENTRE 01 Y 12.'
        );

        return;
    }


    // -----------------------------------------------------
    // CONVERTIR A 24 HORAS
    // -----------------------------------------------------

    const hora24 = convertirA24(
        horas,
        minutos,
        periodo
    );


    const partes24 = hora24.split(':');

    const horas24 = parseInt(partes24[0], 10);
    const minutos24 = parseInt(partes24[1], 10);


    // -----------------------------------------------------
    // VALIDAR HORARIO DEL SISTEMA
    // -----------------------------------------------------

    const totalMinutos =
        (horas24 * 60) + minutos24;

    const minimo =
        (6 * 60) + 30;

    const maximo =
        (15 * 60) + 30;


    if (
        totalMinutos < minimo ||
        totalMinutos > maximo
    ) {

        campoReal.value = '';

        campoTexto.setCustomValidity(
            'EL HORARIO PERMITIDO ES DE 06:30 AM A 03:30 PM.'
        );

        return;
    }


    // -----------------------------------------------------
    // FORMATO FINAL
    // -----------------------------------------------------

    campoTexto.value =
        convertirHora12(horas24, minutos24);

    campoReal.value = hora24;

    campoTexto.setCustomValidity('');
}


// =========================================================
// CONTROL DE ESCRITURA DE HORA
// =========================================================

function controlarEntradaHora(campoTexto) {

    if (!campoTexto) return;

    campoTexto.addEventListener('input', function (event) {

        let valor = this.value.toUpperCase();

        // -------------------------------------------------
        // DETECTAR SI ESTAMOS BORRANDO
        // -------------------------------------------------

        const borrando =
            event.inputType === 'deleteContentBackward' ||
            event.inputType === 'deleteContentForward' ||
            event.inputType === 'deleteByCut';


        // -------------------------------------------------
        // SI ESTÁ BORRANDO
        //
        // NO AGREGAR ":" NI AM/PM
        // -------------------------------------------------

        if (borrando) {

            // Permitir borrar absolutamente todo
            this.value = valor
                .replace(/[^0-9:AMP ]/g, '')
                .substring(0, 8);

            // Limpiar campo oculto
            if (
                this === horaInicioTexto &&
                horaInicioReal
            ) {
                horaInicioReal.value = '';
            }

            if (
                this === horaFinTexto &&
                horaFinReal
            ) {
                horaFinReal.value = '';
            }

            this.setCustomValidity('');

            return;
        }


        // -------------------------------------------------
        // ESCRITURA NORMAL
        // -------------------------------------------------

        valor = valor.replace(
            /[^0-9:AMP ]/g,
            ''
        );


        // -------------------------------------------------
        // NO PERMITIR MÁS DE 4 NÚMEROS
        // -------------------------------------------------

        let numeros =
            valor.replace(/\D/g, '');

        numeros =
            numeros.substring(0, 4);


        // -------------------------------------------------
        // DETECTAR AM / PM
        // -------------------------------------------------

        let periodo = '';

        if (valor.includes('PM')) {
            periodo = 'PM';
        } else if (valor.includes('AM')) {
            periodo = 'AM';
        }


        // -------------------------------------------------
        // DETECTAR SI YA EXISTE :
        // -------------------------------------------------

        const tieneDosPuntos =
            valor.includes(':');


        // -------------------------------------------------
        // FORMATO VISUAL
        //
        // IMPORTANTE:
        // NO FORZAMOS ":" CON UN SOLO DÍGITO.
        //
        // Esto permite escribir:
        //
        // 2:10
        // 8:30
        // 11:45
        // 12:00
        //
        // sin que el cursor se mueva.
        // -------------------------------------------------

        if (tieneDosPuntos) {

            let partes =
                valor.split(':');

            let horas =
                partes[0].replace(/\D/g, '');

            let minutos =
                partes[1]
                    .replace(/\D/g, '')
                    .substring(0, 2);

            horas =
                horas.substring(0, 2);

            this.value =
                horas + ':' + minutos;

        } else {

            // Si todavía no hay ":" simplemente
            // conservar lo que escribió.
            this.value = numeros;
        }


        // -------------------------------------------------
        // LIMPIAR AM / PM MIENTRAS SE ESCRIBE
        // -------------------------------------------------

        if (periodo !== '') {

            this.value =
                this.value
                    .replace(/AM/g, '')
                    .replace(/PM/g, '')
                    .trim();
        }


        // -------------------------------------------------
        // LIMPIAR CAMPO OCULTO
        // -------------------------------------------------

        if (
            this === horaInicioTexto &&
            horaInicioReal
        ) {
            horaInicioReal.value = '';
        }

        if (
            this === horaFinTexto &&
            horaFinReal
        ) {
            horaFinReal.value = '';
        }

        this.setCustomValidity('');
    });


    // =====================================================
    // AL SALIR DEL CAMPO
    // =====================================================

    campoTexto.addEventListener('blur', function () {

        let valor =
            this.value.trim();


        if (valor === '') {
            return;
        }


        // -------------------------------------------------
        // HORA ESCRITA SIN MINUTOS
        //
        // 7  → 07:00 AM
        // 8  → 08:00 AM
        // 9  → 09:00 AM
        // 10 → 10:00 AM
        // 11 → 11:00 AM
        // 12 → 12:00 PM
        // 1  → 01:00 PM
        // 2  → 02:00 PM
        // 3  → 03:00 PM
        // -------------------------------------------------

        const numeros =
            valor.replace(/\D/g, '');

        const tieneDosPuntos =
            valor.includes(':');


        if (
            numeros.length >= 1 &&
            numeros.length <= 2 &&
            !tieneDosPuntos
        ) {

            const hora =
                parseInt(numeros, 10);


            // ---------------------------------------------
            // HORARIO AM
            // ---------------------------------------------

            if (hora >= 7 && hora <= 11) {

                this.value =
                    String(hora).padStart(2, '0') +
                    ':00 AM';
            }


            // ---------------------------------------------
            // 12 DEL MEDIODÍA
            // ---------------------------------------------

            else if (hora === 12) {

                this.value =
                    '12:00 PM';
            }


            // ---------------------------------------------
            // HORARIO PM
            // ---------------------------------------------

            else if (hora >= 1 && hora <= 3) {

                this.value =
                    String(hora).padStart(2, '0') +
                    ':00 PM';
            }
        }


        // -------------------------------------------------
        // PROCESAMIENTO NORMAL
        // -------------------------------------------------

        if (this === horaInicioTexto) {

            procesarHora(
                horaInicioTexto,
                horaInicioReal,
                true
            );

        } else if (this === horaFinTexto) {

            procesarHora(
                horaFinTexto,
                horaFinReal,
                false
            );
        }


        validarHorasEntreSi();
    });
}





// =========================================================
// HORA INICIO
// =========================================================

controlarEntradaHora(horaInicioTexto);

if (horaInicioTexto) {

    horaInicioTexto.addEventListener(
        'blur',
        function () {

            procesarHora(
                horaInicioTexto,
                horaInicioReal,
                true
            );

            validarHorasEntreSi();
        }
    );
}


// =========================================================
// HORA FINAL
// =========================================================

controlarEntradaHora(horaFinTexto);

if (horaFinTexto) {

    horaFinTexto.addEventListener(
        'blur',
        function () {

            procesarHora(
                horaFinTexto,
                horaFinReal,
                false
            );

            validarHorasEntreSi();
        }
    );
}

// =========================================================
// VALIDAR QUE HORA FINAL SEA MAYOR QUE HORA INICIO
// =========================================================

function validarHorasEntreSi() {

    if (!horaInicioReal || !horaFinReal) {
        return;
    }


    // -----------------------------------------------------
    // SI NO HAY HORA DE INICIO
    // NO SE PUEDE COMPARAR
    // -----------------------------------------------------

    if (!horaInicioReal.value) {

        if (horaFinTexto) {
            horaFinTexto.setCustomValidity('');
        }

        return;
    }


    // -----------------------------------------------------
    // SI HORA FINAL ESTÁ VACÍA
    //
    // SE PERMITE:
    // significa que el préstamo sigue activo.
    // -----------------------------------------------------

    if (!horaFinReal.value) {

        if (horaFinTexto) {
            horaFinTexto.setCustomValidity('');
        }

        return;
    }


    // -----------------------------------------------------
    // CONVERTIR A MINUTOS PARA COMPARAR
    // -----------------------------------------------------

    const inicioPartes =
        horaInicioReal.value.split(':');

    const finPartes =
        horaFinReal.value.split(':');


    const inicioMinutos =
        (parseInt(inicioPartes[0], 10) * 60) +
        parseInt(inicioPartes[1], 10);


    const finMinutos =
        (parseInt(finPartes[0], 10) * 60) +
        parseInt(finPartes[1], 10);


    // -----------------------------------------------------
    // HORA FINAL DEBE SER MAYOR
    // -----------------------------------------------------

    if (finMinutos <= inicioMinutos) {

        horaFinTexto.setCustomValidity(
            'LA HORA FINAL DEBE SER MAYOR QUE LA HORA DE INICIO.'
        );

    } else {

        horaFinTexto.setCustomValidity('');
    }
}


// =========================================================
// BLOQUEAR ENVÍO DEL FORMULARIO SI LAS HORAS SON INCORRECTAS
// =========================================================

const formularioPrestamo = horaInicioTexto
    ? horaInicioTexto.closest('form')
    : null;


if (formularioPrestamo) {

    formularioPrestamo.addEventListener('submit', function (event) {

        // ---------------------------------------------
        // PRIMERO PROCESAR LAS HORAS
        // ---------------------------------------------

        if (horaInicioTexto && horaInicioTexto.value.trim() !== '') {

            procesarHora(
                horaInicioTexto,
                horaInicioReal,
                true
            );
        }


        if (horaFinTexto && horaFinTexto.value.trim() !== '') {

            procesarHora(
                horaFinTexto,
                horaFinReal,
                false
            );
        }


        // ---------------------------------------------
        // VALIDAR HORA INICIO VS HORA FINAL
        // ---------------------------------------------

        validarHorasEntreSi();


        // ---------------------------------------------
        // SI HORA FINAL ES INCORRECTA
        // BLOQUEAR EL FORMULARIO
        // ---------------------------------------------

        if (
            horaFinTexto &&
            !horaFinTexto.checkValidity()
        ) {

            event.preventDefault();

            // Llevar automáticamente al campo incorrecto
            horaFinTexto.focus();

            return;
        }


        // ---------------------------------------------
        // VALIDACIÓN GENERAL DEL FORMULARIO
        // ---------------------------------------------

        if (!this.checkValidity()) {

            event.preventDefault();

            // Mostrar la primera validación incorrecta
            this.reportValidity();

            return;
        }
    });
}




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