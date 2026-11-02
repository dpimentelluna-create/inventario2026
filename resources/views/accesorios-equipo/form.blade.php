<div class="row padding-1 p-1">
    <div class="col-md-12">


        {{-- EQUIPO OPCIONAL --}}
        <div class="form-group mb-3">
            <label for="buscar_equipo" class="form-label">
                EQUIPO RELACIONADO
            </label>

            <input type="text" id="buscar_equipo" class="form-control campo-mayusculas"
                placeholder="BUSCAR POR NÚMERO DE SERIE..." autocomplete="off"
                value="{{ old('buscar_equipo', $accesoriosEquipo->equipo->num_serie ?? '') }}">

            <input type="hidden" name="equipo_id" id="equipo_id"
                value="{{ old('equipo_id', $accesoriosEquipo->equipo_id ?? '') }}">

            <div id="resultados_equipos" class="list-group mt-1" style="position: relative; z-index: 1000;">
            </div>

            <small class="text-muted">
                Este campo es opcional. Si no selecciona un equipo,
                el accesorio se registrará como SIN EQUIPO.
            </small>

            @error('equipo_id')
                <div class="invalid-feedback d-block">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>



        {{-- TIPO DE ACCESORIO --}}
        <div class="form-group mb-3">

            <label for="buscar_tipo_accesorio" class="form-label">
                TIPO DE ACCESORIO
                <span class="text-danger">*</span>
            </label>

            {{-- VALOR QUE SE ENVIARÁ AL CONTROLADOR --}}
            <input type="hidden" name="tipo" id="tipo" value="{{ old('tipo', $accesoriosEquipo->tipo ?? '') }}">

            {{-- BUSCADOR --}}
            <div class="position-relative">

                <input type="text" id="buscar_tipo_accesorio"
                    class="form-control campo-mayusculas @error('tipo') is-invalid @enderror"
                    placeholder="ESCRIBA O SELECCIONE..." autocomplete="off"
                    value="{{ old('nuevo_tipo', old('tipo') === 'OTRO' ? '' : old('tipo', $accesoriosEquipo->tipo ?? '')) }}"
                    required>

                {{-- LISTA DE TIPOS --}}
                <div id="lista_tipos_accesorio" class="position-absolute w-100 bg-white border rounded shadow-sm"
                    style="display: none; z-index: 1050; max-height: 220px; overflow-y: auto;">
                </div>

            </div>

            {{-- NUEVO TIPO --}}
            <div id="wrap_nuevo_tipo_accesorio" class="mt-2"
                style="display: {{ old('tipo') === 'OTRO' || old('nuevo_tipo') ? 'block' : 'none' }};">

                <label for="nuevo_tipo" class="form-label">
                    ESPECIFIQUE EL NUEVO TIPO
                </label>

                <input type="text" name="nuevo_tipo" id="nuevo_tipo"
                    class="form-control campo-mayusculas @error('nuevo_tipo') is-invalid @enderror"
                    placeholder="EJ. ADAPTADOR HDMI" value="{{ old('nuevo_tipo') }}" maxlength="100">

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
        <div class="form-group mb-3">
            <label for="marca" class="form-label">MARCA</label>
            <input type="text" name="marca" id="marca"
                class="form-control campo-mayusculas @error('marca') is-invalid @enderror"
                value="{{ old('marca', $accesoriosEquipo->marca ?? '') }}" placeholder="MARCA">
            @error('marca')
                <div class="invalid-feedback d-block">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>

        {{-- NUMERO DE SERIE --}}
        <div class="form-group mb-3">
            <label for="num_serie" class="form-label">
                NÚM. SERIE
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="num_serie" id="num_serie"
                class="form-control campo-mayusculas @error('num_serie') is-invalid @enderror"
                value="{{ old('num_serie', $accesoriosEquipo->num_serie ?? '') }}" placeholder="NÚMERO DE SERIE"
                required>
            @error('num_serie')
                <div class="invalid-feedback d-block">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>

        {{-- ESTADO --}}
        <div class="form-group mb-3">
            <label for="estado" class="form-label">
                ESTADO
                <span class="text-danger">*</span>
            </label>

            <select name="estado" id="estado" class="form-select @error('estado') is-invalid @enderror" required>
                <option value="">SELECCIONE UN ESTADO</option>
                <option value="BUENO" {{ old('estado', $accesoriosEquipo->estado ?? '') == 'BUENO' ? 'selected' : '' }}>
                    BUENO
                </option>
                <option value="REGULAR" {{ old('estado', $accesoriosEquipo->estado ?? '') == 'REGULAR' ? 'selected' : '' }}>
                    REGULAR
                </option>
                <option value="MALOGRADO" {{ old('estado', $accesoriosEquipo->estado ?? '') == 'MALOGRADO' ? 'selected' : '' }}>
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
        <div class="form-group mb-3">
            <label for="observaciones" class="form-label">OBSERVACIONES</label>
            <textarea name="observaciones" id="observaciones"
                class="form-control campo-mayusculas @error('observaciones') is-invalid @enderror"
                placeholder="OBSERVACIONES"
                rows="4">{{ old('observaciones', $accesoriosEquipo->observaciones ?? $accesoriosEquipo->observacion ?? '') }}</textarea>
            @error('observaciones')
                <div class="invalid-feedback d-block">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <button type="submit" class="btn btn-primary">GUARDAR</button>
        <a href="{{ route('accesorios-equipo.index') }}" class="btn btn-secondary">
            VOLVER
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        function limpiarError(campo) {
            if (!campo) return;
            campo.classList.remove('is-invalid');
            const box = campo.parentElement.querySelector('.js-error-campo');
            if (box) box.remove();
        }

        function mostrarError(campo, mensaje) {
            if (!campo) return false;
            limpiarError(campo);
            campo.classList.add('is-invalid');
            const aviso = document.createElement('div');
            aviso.className = 'js-error-campo invalid-feedback d-block';
            aviso.innerHTML = '<strong>' + mensaje + '</strong>';
            campo.insertAdjacentElement('afterend', aviso);
            campo.scrollIntoView({ behavior: 'smooth', block: 'center' });
            campo.focus();
            return false;
        }

        document.querySelectorAll('.campo-mayusculas').forEach(function (campo) {
            campo.addEventListener('input', function () {
                const start = this.selectionStart;
                this.value = this.value.toUpperCase();
                this.setSelectionRange(start, start);
                limpiarError(this);
            });
        });

        document.querySelectorAll('.campo-solo-letras').forEach(function (campo) {
            campo.addEventListener('input', function () {
                const start = this.selectionStart;
                this.value = this.value.replace(/[0-9]/g, '').toUpperCase();
                this.setSelectionRange(start, start);
            });
        });

        document.querySelectorAll('.campo-solo-numeros').forEach(function (campo) {
            campo.addEventListener('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });


        const buscador = document.getElementById('buscar_equipo');
        const resultados = document.getElementById('resultados_equipos');
        const equipoId = document.getElementById('equipo_id');

        const campoTipo = document.getElementById('tipo');
        const buscadorTipo = document.getElementById('buscar_tipo_accesorio');
        const listaTipos = document.getElementById('lista_tipos_accesorio');
        const wrapNuevoTipo = document.getElementById('wrap_nuevo_tipo_accesorio');
        const nuevoTipo = document.getElementById('nuevo_tipo');

        const formulario = buscador ? buscador.closest('form') : null;

        // TIPOS REGISTRADOS EN LA BASE DE DATOS
        const tiposAccesoriosData = @json($tiposAccesorios ?? []);

        const campoSerie = document.getElementById('num_serie');
        const campoEstado = document.getElementById('estado');

        // BUSCAR EQUIPOS
        if (buscador) {

            buscador.addEventListener('input', function () {

                // Al modificar el texto, se invalida la selección anterior.
                equipoId.value = '';
                limpiarError(buscador);

                const buscar = this.value.trim();
                resultados.innerHTML = '';

                if (buscar.length < 2) {
                    return;
                }

                fetch('{{ route("accesorios-equipo.buscarEquipos") }}?buscar=' + encodeURIComponent(buscar))
                    .then(response => response.json())
                    .then(equipos => {

                        resultados.innerHTML = '';

                        if (equipos.length === 0) {
                            resultados.innerHTML = `
                        <div class="list-group-item">
                            NO SE ENCONTRARON EQUIPOS.
                        </div>
                    `;
                            return;
                        }

                        equipos.forEach(equipo => {

                            const item = document.createElement('button');

                            item.type = 'button';
                            item.className = 'list-group-item list-group-item-action';

                            const serie = document.createElement('strong');
                            serie.textContent = equipo.num_serie ?? '';

                            const detalle = document.createElement('small');
                            detalle.textContent =
                                (equipo.marca ?? '') +
                                (equipo.modelo ? ' - ' + equipo.modelo : '');

                            item.appendChild(serie);
                            item.appendChild(document.createElement('br'));
                            item.appendChild(detalle);

                            item.addEventListener('click', function () {

                                buscador.value = (equipo.num_serie ?? '').toUpperCase();
                                equipoId.value = equipo.id;

                                resultados.innerHTML = '';
                                limpiarError(buscador);
                            });

                            resultados.appendChild(item);
                        });
                    })
                    .catch(error => {
                        console.error('Error al buscar equipos:', error);
                    });
            });
        }

        // COMBOBOX DE TIPOS DE ACCESORIOS
        function pintarListaTiposAccesorio(buscar = '') {

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
                });

                listaTipos.appendChild(opcion);
            });

            // OPCIÓN OTRO
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

        // ESCRIBIR O BUSCAR TIPO
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

            // Si coincide exactamente con un tipo existente, seleccionarlo.
            const existente = tiposAccesoriosData.find(tipo =>
                tipo.toUpperCase() === texto
            );

            if (existente) {

                campoTipo.value = existente;
                buscadorTipo.value = existente;

                listaTipos.style.display = 'none';

                return;
            }

            pintarListaTiposAccesorio(texto);
        });

        // MOSTRAR TIPOS AL ENTRAR AL CAMPO
        buscadorTipo.addEventListener('focus', function () {

            pintarListaTiposAccesorio(this.value);
        });

        // CERRAR LISTA AL HACER CLIC FUERA
        document.addEventListener('click', function (event) {

            if (
                !buscadorTipo.contains(event.target) &&
                !listaTipos.contains(event.target)
            ) {
                listaTipos.style.display = 'none';
            }
        });

        // VALIDAR FORMULARIO
        if (formulario) {

            formulario.addEventListener('submit', function (event) {

                [buscador, buscadorTipo, campoTipo, nuevoTipo, campoSerie, campoEstado]
                    .filter(Boolean)
                    .forEach(limpiarError);

                // EQUIPO ES OPCIONAL.
                // Si hay texto escrito, debe haberse seleccionado un resultado.
                if (buscador.value.trim() !== '' && equipoId.value.trim() === '') {

                    event.preventDefault();

                    return mostrarError(
                        buscador,
                        'SELECCIONE UN EQUIPO DE LA LISTA O DEJE EL CAMPO VACÍO.'
                    );
                }

                // VALIDAR TIPO
                if (campoTipo.value.trim() === '') {

                    event.preventDefault();

                    return mostrarError(
                        buscadorTipo,
                        'SELECCIONE O REGISTRE EL TIPO DE ACCESORIO.'
                    );
                }

                if (campoTipo.value === 'OTRO' && nuevoTipo.value.trim() === '') {

                    event.preventDefault();

                    return mostrarError(
                        nuevoTipo,
                        'ESPECIFIQUE EL NUEVO TIPO DE ACCESORIO.'
                    );
                }

                // VALIDAR NÚMERO DE SERIE
                if (!campoSerie || campoSerie.value.trim() === '') {

                    event.preventDefault();

                    return mostrarError(
                        campoSerie,
                        'EL NÚMERO DE SERIE ES OBLIGATORIO.'
                    );
                }

                // VALIDAR ESTADO
                const estados = ['BUENO', 'REGULAR', 'MALOGRADO'];

                if (!campoEstado || !estados.includes(campoEstado.value)) {

                    event.preventDefault();

                    return mostrarError(
                        campoEstado,
                        'EL ESTADO DEBE SER BUENO, REGULAR O MALOGRADO.'
                    );
                }
            });
        }

    });
</script>
