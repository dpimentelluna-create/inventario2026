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
        value="{{ old('buscar_equipo', $especificacionesLaptop->equipo->num_serie ?? '') }}"
        >

        <input
        type="hidden"
        name="equipo_id"
        id="equipo_id"
        value="{{ old('equipo_id', $especificacionesLaptop->equipo_id ?? '') }}"
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

        {{-- PROCESADOR --}}
            <div class="form-group mb-2 mb20">
                <label for="procesador" class="form-label">{{ __('Procesador') }}</label>
                <input type="text" name="procesador" class="form-control @error('procesador') is-invalid @enderror" value="{{ old('procesador', $especificacionesLaptop?->procesador) }}" id="procesador" placeholder="Procesador">
                {!! $errors->first('procesador', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            </div>

        {{-- MEMORIA RAM --}}
            <div class="form-group mb-2 mb20">
                <label for="ram" class="form-label">{{ __('Memoria RAM') }}</label>
                <input type="text" name="ram" class="form-control @error('ram') is-invalid @enderror" value="{{ old('ram', $especificacionesLaptop?->ram) }}" id="ram" placeholder="Ram">
                {!! $errors->first('ram', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            </div>
        
        {{-- DISCO DURO --}}
            <div class="form-group mb-2 mb20">
                <label for="disco_duro" class="form-label">{{ __('Disco Duro') }}</label>
                <input type="text" name="disco_duro" class="form-control @error('disco_duro') is-invalid @enderror" value="{{ old('disco_duro', $especificacionesLaptop?->disco_duro) }}" id="disco_duro" placeholder="Disco Duro">
                {!! $errors->first('disco_duro', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            </div>

        {{-- COLOR --}}
            <div class="form-group mb-2 mb20">
                <label for="color" class="form-label">{{ __('Color') }}</label>
                <input type="text" name="color" class="form-control @error('color') is-invalid @enderror" value="{{ old('color', $especificacionesLaptop?->color) }}" id="color" placeholder="Color">
                {!! $errors->first('color', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            </div>

        {{-- ESTADO --}}
            {{-- ESTADO --}}
<div class="form-group mb-2 mb20">

    <label for="estado" class="form-label">
        {{ __('Estado') }}
    </label>

    <select
        name="estado"
        id="estado"
        class="form-select @error('estado') is-invalid @enderror"
    >

        <option value="">
            Seleccione un Estado
        </option>

        <option value="Operativo"
            {{ old('estado', $especificacionesLaptop?->estado) == 'Operativo' ? 'selected' : '' }}>
            OPERATIVO
        </option>

        <option value="Regular"
            {{ old('estado', $especificacionesLaptop?->estado) == 'Regular' ? 'selected' : '' }}>
            REGULAR
        </option>

        <option value="Malogrado"
            {{ old('estado', $especificacionesLaptop?->estado) == 'Malogrado' ? 'selected' : '' }}>
            MALOGRADO
        </option>

        <option value="De baja"
            {{ old('estado', $especificacionesLaptop?->estado) == 'De baja' ? 'selected' : '' }}>
            DE BAJA
        </option>

    </select>

    {!! $errors->first(
        'estado',
        '<div class="invalid-feedback" role="alert">
            <strong>:message</strong>
        </div>'
    ) !!}

    </div>

    {{-- OBSERVACIONES --}}
    <div class="form-group mb-2 mb20">
        <label for="observaciones" class="form-label">
        {{ __('Observaciones') }}
        </label>

    <textarea
        name="observaciones"
        class="form-control @error('observaciones') is-invalid @enderror"
        id="observaciones"
        placeholder="Observaciones"
        rows="4"
    >{{ old('observaciones', $especificacionesLaptop?->observaciones) }}</textarea>

    {!! $errors->first(
        'observaciones',
        '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>'
    ) !!}
    </div>

    <div class="col-md-12 mt20 mt-2">
            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
            <a href="{{ route('especificaciones-laptop.index') }}"
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
@if($especificacionesLaptop->equipo)
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const buscador = document.getElementById('buscar_equipo');

            buscador.value = "{{ $especificacionesLaptop->equipo->num_serie }}";

        });
    </script>
@endif