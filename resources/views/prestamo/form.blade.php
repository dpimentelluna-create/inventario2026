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
                            DOCENTE <span class="text-danger">*</span>
                        </label>

                        <select
                            name="docente_id"
                            id="docente_id"
                            class="form-select @error('docente_id') is-invalid @enderror"
                            required
                        >
                            <option value="">-- Seleccionar docente --</option>

                            @foreach ($docentes as $docente)
                                <option
                                    value="{{ $docente->id }}"
                                    @selected(old('docente_id', $prestamo->docente_id) == $docente->id)
                                >
                                    {{ $docente->apellidos }} {{ $docente->nombres }}
                                </option>
                            @endforeach
                        </select>

                        @error('docente_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- CARGO --}}
                    <div class="col-md-6 mb-3">
                        <label for="cargo" class="form-label">
                            CARGO <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="cargo"
                            id="cargo"
                            class="form-control campo-mayusculas @error('cargo') is-invalid @enderror"
                            value="{{ old('cargo', $prestamo->cargo ?? 'DOCENTE') }}"
                            maxlength="100"
                            required
                        >

                        @error('cargo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- FECHA --}}
                    <div class="col-md-4 mb-3">
                        <label for="fecha" class="form-label">
                            FECHA <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="fecha"
                            id="fecha"
                            class="form-control @error('fecha') is-invalid @enderror"
                            value="{{ old('fecha', $prestamo->fecha ? $prestamo->fecha->format('Y-m-d') : '') }}"
                            required
                        >

                        @error('fecha')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- HORA INICIO --}}
                    <div class="col-md-4 mb-3">
                        <label for="hora_inicio" class="form-label">
                            HORA INICIO <span class="text-danger">*</span>
                        </label>

                        <input
                            type="time"
                            name="hora_inicio"
                            id="hora_inicio"
                            class="form-control @error('hora_inicio') is-invalid @enderror"
                            value="{{ old('hora_inicio', $prestamo->hora_inicio ? substr($prestamo->hora_inicio, 0, 5) : '') }}"
                            required
                        >

                        @error('hora_inicio')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- HORA FIN --}}
                    <div class="col-md-4 mb-3">
                        <label for="hora_fin" class="form-label">
                            HORA FINAL
                        </label>

                        <input
                            type="time"
                            name="hora_fin"
                            id="hora_fin"
                            class="form-control @error('hora_fin') is-invalid @enderror"
                            value="{{ old('hora_fin', $prestamo->hora_fin ? substr($prestamo->hora_fin, 0, 5) : '') }}"
                        >

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

                        <label for="tipo_equipo_id" class="form-label">
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

                        <label for="buscar_equipo" class="form-label">
                            BUSCAR EQUIPO
                        </label>

                        <input
                            type="text"
                            id="buscar_equipo"
                            class="form-control campo-mayusculas"
                            placeholder="Buscar por tipo, marca, modelo, N/S o código de inventario..."
                            autocomplete="off"
                        >

                    </div>

                </div>


                {{-- RESULTADOS DE BÚSQUEDA --}}
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


    {{-- BOTONES --}}
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
                GUARDAR PRÉSTAMO
            </button>

        </div>

    </div>

</div>

<!--SCRIPT PARA BUSCAR-->
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const buscarEquipo = document.getElementById('buscar_equipo');
        const tipoEquipo = document.getElementById('tipo_equipo_id');
        const resultados = document.getElementById('resultados_equipos');
        const equiposSeleccionados = new Set();

        buscarEquipo.addEventListener('input', buscarEquipos);
        tipoEquipo.addEventListener('change', buscarEquipos);


        function buscarEquipos() {

            const buscar = buscarEquipo.value.trim();
            const tipoId = tipoEquipo.value;

            if (buscar === '' && tipoId === '') {

                resultados.innerHTML = `
                <div class="text-muted text-center py-3">
                    Escribe para buscar un equipo.
                </div>
            `;

                return;
            }

            resultados.innerHTML = `
            <div class="text-center py-3">
                <div class="spinner-border text-success" role="status"></div>
                <div class="mt-2 text-muted">
                    Buscando equipos...
                </div>
            </div>
        `;


            const parametros = new URLSearchParams();

            if (buscar !== '') {
                parametros.append('buscar', buscar);
            }

            if (tipoId !== '') {
                parametros.append('tipo_equipo_id', tipoId);
            }


            fetch(
                `{{ route('prestamos.buscarEquipos') }}?${parametros.toString()}`
            )
                .then(response => {

                    if (!response.ok) {
                        throw new Error('Error al buscar equipos');
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

                html += `
                <button
                    type="button"
                    class="list-group-item list-group-item-action equipo-resultado"
                    data-id="${equipo.id}"
                >

                    <div class="d-flex justify-content-between align-items-center">

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


                        <span class="badge bg-secondary">
                            ${equipo.estado ?? ''}
                        </span>

                    </div>

                </button>
            `;
            });


            html += `
            </div>
        `;


            resultados.innerHTML = html;


            document
                .querySelectorAll('.equipo-resultado')
                .forEach(elemento => {

                    elemento.addEventListener('click', function () {

                        const equipoId = this.dataset.id;

                        agregarEquipo(equipoId);

                    });

                });
        }


        function agregarEquipo(equipoId) {

            if (equiposSeleccionados.has(String(equipoId))) {

                alert('Este equipo ya ha sido seleccionado.');

                return;
            }


            // Buscar nuevamente el equipo para obtener todos sus datos
            const tipoId = tipoEquipo.value;
            const buscar = buscarEquipo.value.trim();

            const parametros = new URLSearchParams();

            if (buscar !== '') {
                parametros.append('buscar', buscar);
            }

            if (tipoId !== '') {
                parametros.append('tipo_equipo_id', tipoId);
            }


            fetch(
                `{{ route('prestamos.buscarEquipos') }}?${parametros.toString()}`
            )
                .then(response => response.json())
                .then(equipos => {

                    const equipo = equipos.find(
                        e => String(e.id) === String(equipoId)
                    );

                    if (!equipo) {

                        alert('No se pudo encontrar el equipo seleccionado.');

                        return;
                    }

                    equiposSeleccionados.add(String(equipo.id));

                    mostrarEquipoSeleccionado(equipo);

                    buscarEquipo.value = '';

                    resultados.innerHTML = `
                    <div class="text-muted text-center py-3">
                        Equipo agregado correctamente.
                        Puedes buscar otro equipo.
                    </div>
                    `;

                })
                .catch(error => {

                    console.error(error);

                    alert('Ocurrió un error al seleccionar el equipo.');

                });

        }

        function mostrarEquipoSeleccionado(equipo) {

            const contenedor = document.getElementById(
                'equipos_seleccionados'
            );

            const mensaje = document.getElementById(
                'mensaje_sin_equipos'
            );

            if (mensaje) {
                mensaje.remove();
            }


            const indice = document.querySelectorAll(
                '.equipo-seleccionado'
            ).length;


            let accesoriosHtml = '';


            if (
                equipo.accesorios_equipos &&
                equipo.accesorios_equipos.length > 0
            ) {

                equipo.accesorios_equipos.forEach(
                    (accesorio, accesorioIndex) => {

                        accesoriosHtml += `
                    <div
                        class="border rounded p-3 mb-3 accesorio-prestamo"
                    >

                        <input
                            type="hidden"
                            name="equipos[${indice}][accesorios][${accesorioIndex}][accesorio_equipo_id]"
                            value="${accesorio.id}"
                        >


                        <div class="row">

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


                            <div class="col-md-5 mb-3">

                                <label class="form-label">
                                    ESTADO
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="equipos[${indice}][accesorios][${accesorioIndex}][estado]"
                                    class="form-select"
                                    required
                                >

                                    <option value="REGULAR">
                                        REGULAR
                                    </option>

                                    <option value="BUENO" selected>
                                        BUENO
                                    </option>

                                    <option value="MALOGRADO">
                                        MALOGRADO
                                    </option>

                                </select>

                            </div>


                            <div class="col-md-7 mb-3">

                                <label class="form-label">
                                    OBSERVACIÓN
                                </label>

                                <input
                                    type="text"
                                    name="equipos[${indice}][accesorios][${accesorioIndex}][observacion]"
                                    class="form-control"
                                    placeholder="Observación del accesorio..."
                                >

                            </div>

                        </div>

                    </div>
                `;
                    }
                );

            } else {

                accesoriosHtml = `
            <div class="text-muted">
                Este equipo no tiene accesorios registrados.
            </div>
        `;
            }


            const equipoHtml = `

        <div
            class="card mb-4 equipo-seleccionado"
            data-equipo-id="${equipo.id}"
        >

            <div class="card-header">

                <div
                    class="d-flex justify-content-between align-items-center"
                >

                    <strong class="titulo-equipo">
                        EQUIPO ${indice + 1}
                    </strong>

                    <button
                        type="button"
                        class="btn btn-danger btn-sm quitar-equipo"
                    >
                        <i class="bi bi-trash"></i>
                        QUITAR
                    </button>

                </div>

            </div>


            <div class="card-body">

                <input
                    type="hidden"
                    name="equipos[${indice}][equipo_id]"
                    value="${equipo.id}"
                >


                {{-- DATOS DEL EQUIPO --}}

                <div class="row">

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


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            ESTADO
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="equipos[${indice}][estado]"
                            class="form-select"
                            required
                        >

                            <option value="REGULAR">
                                REGULAR
                            </option>

                            <option value="BUENO" selected>
                                BUENO
                            </option>

                            <option value="MALOGRADO">
                                MALOGRADO
                            </option>

                        </select>

                    </div>


                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            OBSERVACIÓN DEL EQUIPO
                        </label>

                        <textarea
                            name="equipos[${indice}][observacion]"
                            class="form-control"
                            rows="2"
                            placeholder="Observación del equipo..."
                        ></textarea>

                    </div>

                </div>


                {{-- ACCESORIOS --}}

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


            contenedor.insertAdjacentHTML(
                'beforeend',
                equipoHtml
            );


            actualizarEventosQuitarEquipo();
        }

        function actualizarEventosQuitarEquipo() {

            document
        .querySelectorAll('.quitar-equipo')
        .forEach(boton => {

            boton.onclick = function () {

                const equipo = this.closest(
                    '.equipo-seleccionado'
                );

                if (!equipo) {
                    return;
                }


                const equipoId = equipo.dataset.equipoId;

                equiposSeleccionados.delete(
                    String(equipoId)
                );

                equipo.remove();


                renumerarEquipos();


                const equipos = document.querySelectorAll(
                    '.equipo-seleccionado'
                );


                if (equipos.length === 0) {

                    const contenedor =
                        document.getElementById(
                            'equipos_seleccionados'
                        );

                    contenedor.innerHTML = `
                        <div
                            id="mensaje_sin_equipos"
                            class="text-center text-muted py-3"
                        >
                            No hay equipos seleccionados.
                        </div>
                    `;
                }

            };

        });

        }

        function renumerarEquipos() {

    const equipos = document.querySelectorAll(
        '.equipo-seleccionado'
    );


    equipos.forEach((equipo, indice) => {

        // -------------------------------------------------
        // Cambiar el texto EQUIPO 1, EQUIPO 2, etc.
        // -------------------------------------------------

        const titulo = equipo.querySelector(
            '.titulo-equipo'
        );

        if (titulo) {

            titulo.textContent =
                `EQUIPO ${indice + 1}`;

        }


        // -------------------------------------------------
        // Actualizar todos los name del equipo
        // -------------------------------------------------

        equipo
            .querySelectorAll('[name]')
            .forEach(campo => {

                const nombreActual = campo.getAttribute(
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

    });

}

});
</script>