<div class="row padding-1 p-1">
    <div class="col-md-12">

        {{-- EQUIPO --}}
        <div class="form-group mb-3">
            <label for="buscar_equipo" class="form-label">
                EQUIPO
                <span class="text-danger">*</span>
            </label>

            <input
                type="text"
                id="buscar_equipo"
                class="form-control campo-mayusculas"
                placeholder="BUSCAR POR NÚMERO DE SERIE..."
                autocomplete="off"
                value="{{ old('buscar_equipo', $accesoriosEquipo->equipo->num_serie ?? '') }}"
            >

            <input
                type="hidden"
                name="equipo_id"
                id="equipo_id"
                value="{{ old('equipo_id', $accesoriosEquipo->equipo_id ?? '') }}"
            >

            <div
                id="resultados_equipos"
                class="list-group mt-1"
                style="position: relative; z-index: 1000;">
            </div>

            @error('equipo_id')
                <div class="invalid-feedback d-block">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>

        {{-- TIPO --}}
        <div class="form-group mb-3">
            <label for="tipo" class="form-label">
                TIPO
                <span class="text-danger">*</span>
            </label>

            <select
                name="tipo"
                id="tipo"
                class="form-select @error('tipo') is-invalid @enderror"
                required
            >
                <option value="">SELECCIONE UN TIPO</option>
                <option value="BATERÍA" {{ old('tipo', $accesoriosEquipo->tipo ?? '') == 'BATERÍA' ? 'selected' : '' }}>
                    BATERÍA
                </option>
                <option value="CARGADOR" {{ old('tipo', $accesoriosEquipo->tipo ?? '') == 'CARGADOR' ? 'selected' : '' }}>
                    CARGADOR
                </option>
            </select>

            @error('tipo')
                <div class="invalid-feedback d-block">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>

        {{-- MARCA --}}
        <div class="form-group mb-3">
            <label for="marca" class="form-label">MARCA</label>
            <input
                type="text"
                name="marca"
                id="marca"
                class="form-control campo-mayusculas @error('marca') is-invalid @enderror"
                value="{{ old('marca', $accesoriosEquipo->marca ?? '') }}"
                placeholder="MARCA"
            >
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
            <input
                type="text"
                name="num_serie"
                id="num_serie"
                class="form-control campo-mayusculas @error('num_serie') is-invalid @enderror"
                value="{{ old('num_serie', $accesoriosEquipo->num_serie ?? '') }}"
                placeholder="NÚMERO DE SERIE"
                required
            >
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

            <select
                name="estado"
                id="estado"
                class="form-select @error('estado') is-invalid @enderror"
                required
            >
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
            <textarea
                name="observaciones"
                id="observaciones"
                class="form-control campo-mayusculas @error('observaciones') is-invalid @enderror"
                placeholder="OBSERVACIONES"
                rows="4"
            >{{ old('observaciones', $accesoriosEquipo->observaciones ?? $accesoriosEquipo->observacion ?? '') }}</textarea>
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

    buscador.addEventListener('input', function () {

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
                    item.innerHTML = `
                        <strong>${equipo.num_serie ?? ''}</strong>
                        <br>
                        <small>
                            ${equipo.marca ?? ''}
                            ${equipo.modelo ? ' - ' + equipo.modelo : ''}
                        </small>
                    `;

                    item.addEventListener('click', function () {
                        buscador.value = (equipo.num_serie ?? '').toUpperCase();
                        equipoId.value = equipo.id;
                        resultados.innerHTML = '';
                    });

                    resultados.appendChild(item);
                });
            })
            .catch(error => {
                console.error('Error al buscar equipos:', error);
            });
    });

    const formulario = buscador ? buscador.closest('form') : null;
    const campoTipo = document.getElementById('tipo');
    const campoSerie = document.getElementById('num_serie');
    const campoEstado = document.getElementById('estado');

    if (formulario) {
        formulario.addEventListener('submit', function (event) {
            [buscador, campoTipo, campoSerie, campoEstado].forEach(limpiarError);

            if (!equipoId || equipoId.value.trim() === '') {
                event.preventDefault();
                return mostrarError(buscador, 'SELECCIONE UN EQUIPO DE LA LISTA.');
            }

            if (!campoTipo || campoTipo.value.trim() === '') {
                event.preventDefault();
                return mostrarError(campoTipo, 'SELECCIONE EL TIPO DE ACCESORIO.');
            }

            if (!campoSerie || campoSerie.value.trim() === '') {
                event.preventDefault();
                return mostrarError(campoSerie, 'EL NÚMERO DE SERIE ES OBLIGATORIO.');
            }

            const estados = ['BUENO', 'REGULAR', 'MALOGRADO'];
            if (!campoEstado || !estados.includes(campoEstado.value)) {
                event.preventDefault();
                return mostrarError(campoEstado, 'EL ESTADO DEBE SER BUENO, REGULAR O MALOGRADO.');
            }
        });
    }
});
</script>
