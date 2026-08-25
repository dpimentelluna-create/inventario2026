<div class="row padding-1 p-1">
    <div class="col-md-12">
        
    {{-- EQUIPO --}}
    <div class="form-group mb-3">
        <label for="buscar_equipo" class="form-label">
        Equipo
        </label>

        <input
        type="text"
        id="buscar_equipo"
        class="form-control"
        placeholder="Buscar por número de serie..."
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
    <div class="form-group mb-2 mb20">
        <label for="tipo" class="form-label">{{ __('Tipo') }}</label>

    <select
        name="tipo"
        id="tipo"
        class="form-select @error('tipo') is-invalid @enderror"
        >

        <option value="">Seleccione un tipo</option>

        <option value="Batería"
            {{ old('tipo', $accesoriosEquipo?->tipo) == 'Batería' ? 'selected' : '' }}>
            Batería
        </option>

        <option value="Cargador"
            {{ old('tipo', $accesoriosEquipo?->tipo) == 'Cargador' ? 'selected' : '' }}>
            Cargador
        </option>
    </select>
     {!! $errors->first('tipo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    {{-- MARCA --}}
        <div class="form-group mb-2 mb20">
            <label for="marca" class="form-label">{{ __('Marca') }}</label>
            <input type="text" name="marca" class="form-control @error('marca') is-invalid @enderror" value="{{ old('marca', $accesoriosEquipo?->marca) }}" id="marca" placeholder="Marca">
            {!! $errors->first('marca', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    {{-- NUMERO DE SERIE --}}
        <div class="form-group mb-2 mb20">
            <label for="num_serie" class="form-label">{{ __('Num. Serie') }}</label>
            <input type="text" name="num_serie" class="form-control @error('num_serie') is-invalid @enderror" value="{{ old('num_serie', $accesoriosEquipo?->num_serie) }}" id="num_serie" placeholder="Num Serie">
            {!! $errors->first('num_serie', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    {{-- ESTADO --}}
        <div class="form-group mb-2 mb20">
            <label for="estado" class="form-label">{{ __('Estado') }}</label>
        
    <select
        name="estado"
        id="estado"
        class="form-select @error('estado') is-invalid @enderror"
    >

        <option value="">Seleccione un estado</option>

        <option value="Operativo"
            {{ old('estado', $accesoriosEquipo?->estado) == 'Operativo' ? 'selected' : '' }}>
            Operativo
        </option>

        <option value="Regular"
            {{ old('estado', $accesoriosEquipo?->estado) == 'Regular' ? 'selected' : '' }}>
            Regular
        </option>

        <option value="Malogrado"
            {{ old('estado', $accesoriosEquipo?->estado) == 'Malogrado' ? 'selected' : '' }}>
            Malogrado
        </option>
    </select>            
    {!! $errors->first('estado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- OBSERVACIONES --}}
        <div class="form-group mb-2 mb20">
            <label for="observaciones" class="form-label">{{ __('Observaciones') }}</label>
            <textarea
                name="observacion"
                class="form-control @error('observacion') is-invalid @enderror"
                id="observacion"
                placeholder="Observaciones"
                rows="4"
            >{{ old('observacion', $accesoriosEquipo?->observacion) }}</textarea>            
            {!! $errors->first('observaciones', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>
    <div class="col-md-12 mt20 mt-3">
        <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
        <a href="{{ route('accesorios-equipo.index') }}"
           class="btn btn-secondary">
            Volver
        </a>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

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
                            No se encontraron equipos.
                        </div>
                    `;

                    return;
                }

                equipos.forEach(equipo => {

                    const item = document.createElement('button');

                    item.type = 'button';
                    item.className = 'list-group-item list-group-item-action';

                    item.innerHTML = `
                        <strong>${equipo.num_serie}</strong>
                        <br>
                        <small>
                            ${equipo.marca}
                            ${equipo.modelo ? ' - ' + equipo.modelo : ''}
                            ${equipo.codigo_inventario ? ' | Código: ' + equipo.codigo_inventario : ''}
                        </small>
                    `;

                    item.addEventListener('click', function () {

                        buscador.value = equipo.num_serie;

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

});
</script>
