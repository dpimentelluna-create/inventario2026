<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-3">

    <label for="tipo_equipo_id" class="form-label">
        Tipo de Equipo
    </label>

    <select id="tipo_equipo_id" class="form-select">
        <option value="">Seleccione un tipo de equipo</option>

        @foreach($tiposEquipo as $id => $nombre)
            <option value="{{ $id }}">
                {{ $nombre }}
            </option>
        @endforeach
    </select>

</div>


<div class="form-group mb-3">

    <label for="buscar_equipo" class="form-label">
        Buscar por número de serie o código de inventario
    </label>

    <input
        type="text"
        id="buscar_equipo"
        class="form-control"
        placeholder="Ejemplo: ABC123 o INV-001"
    >

</div>


<div class="table-responsive">

    <table class="table table-bordered table-hover">

        <thead class="table-dark">

            <tr>
                <th>Marca</th>
                <th>Modelo</th>
                <th>N.º Serie</th>
                <th>Código Inventario</th>
                <th>Acción</th>
            </tr>

        </thead>

        <tbody id="resultados_equipos">

            <tr>
                <td colspan="5" class="text-center">
                    Seleccione un tipo o realice una búsqueda
                </td>
            </tr>

        </tbody>

    </table>

</div>


<input
    type="hidden"
    name="equipo_id"
    id="equipo_id"
    value="{{ old('equipo_id', $prestamo->equipo_id ?? '') }}"
>
        
    <div class="form-group mb-2 mb20">
            <label for="docente_id" class="form-label">{{ __('Docente') }}</label>

            <select name="docente_id"
            class="form-select 
            @error('docente_id') is-invalid @enderror"
            id="docente_id">

        <option value="">Seleccione el Docente</option>

        @foreach($docente as $id => $nombre)
            <option value="{{ $id }}"
                {{ old('docente_id', $equipo->docente_id ?? '') == $id 
                ? 'selected' : '' }}>{{ $nombre }}
            </option>
        @endforeach            
        </select>

        {!! $errors->first('docente_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>


        <div class="form-group mb-2 mb20">
            <label for="ubicacion_destino_id" class="form-label">{{ __('Ubicacion Destino') }}</label>
            <input type="text" name="ubicacion_destino_id" class="form-control @error('ubicacion_destino_id') is-invalid @enderror" value="{{ old('ubicacion_destino_id', $prestamo?->ubicacion_destino_id) }}" id="ubicacion_destino_id" placeholder="Ubicacion Destino Id">
            {!! $errors->first('ubicacion_destino_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="fecha_entrega" class="form-label">{{ __('Fecha Entrega') }}</label>
            <input type="text" name="fecha_entrega" class="form-control @error('fecha_entrega') is-invalid @enderror" value="{{ old('fecha_entrega', $prestamo?->fecha_entrega) }}" id="fecha_entrega" placeholder="Fecha Entrega">
            {!! $errors->first('fecha_entrega', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="fecha_devolucion_prevista" class="form-label">{{ __('Fecha Devolucion Prevista') }}</label>
            <input type="text" name="fecha_devolucion_prevista" class="form-control @error('fecha_devolucion_prevista') is-invalid @enderror" value="{{ old('fecha_devolucion_prevista', $prestamo?->fecha_devolucion_prevista) }}" id="fecha_devolucion_prevista" placeholder="Fecha Devolucion Prevista">
            {!! $errors->first('fecha_devolucion_prevista', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="fecha_devolucion_real" class="form-label">{{ __('Fecha Devolucion Real') }}</label>
            <input type="text" name="fecha_devolucion_real" class="form-control @error('fecha_devolucion_real') is-invalid @enderror" value="{{ old('fecha_devolucion_real', $prestamo?->fecha_devolucion_real) }}" id="fecha_devolucion_real" placeholder="Fecha Devolucion Real">
            {!! $errors->first('fecha_devolucion_real', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="estado" class="form-label">{{ __('Estado') }}</label>
            <input type="text" name="estado" class="form-control @error('estado') is-invalid @enderror" value="{{ old('estado', $prestamo?->estado) }}" id="estado" placeholder="Estado">
            {!! $errors->first('estado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="observacion" class="form-label">{{ __('Observacion') }}</label>
            <input type="text" name="observacion" class="form-control @error('observacion') is-invalid @enderror" value="{{ old('observacion', $prestamo?->observacion) }}" id="observacion" placeholder="Observacion">
            {!! $errors->first('observacion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Registrar') }}</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const tipoEquipo = document.getElementById('tipo_equipo_id');
    const buscar = document.getElementById('buscar_equipo');
    const resultados = document.getElementById('resultados_equipos');
    const equipoId = document.getElementById('equipo_id');

    function buscarEquipos() {

        const tipo = tipoEquipo.value;
        const texto = buscar.value;

        if (tipo === '' && texto === '') {

            resultados.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center">
                        Seleccione un tipo o realice una búsqueda
                    </td>
                </tr>
            `;

            return;
        }

        const url = new URL(
            "{{ route('prestamos.buscarEquipos') }}",
            window.location.origin
        );

        if (tipo !== '') {
            url.searchParams.append(
                'tipo_equipo_id',
                tipo
            );
        }

        if (texto !== '') {
            url.searchParams.append(
                'buscar',
                texto
            );
        }

        fetch(url)
            .then(response => response.json())
            .then(data => {

                resultados.innerHTML = '';

                if (data.length === 0) {

                    resultados.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center">
                                No se encontraron equipos
                            </td>
                        </tr>
                    `;

                    return;
                }

                data.forEach(equipo => {

                    resultados.innerHTML += `
                        <tr>
                            <td>${equipo.marca ?? ''}</td>
                            <td>${equipo.modelo ?? ''}</td>
                            <td>${equipo.num_serie ?? ''}</td>
                            <td>${equipo.codigo_inventario ?? ''}</td>

                            <td>
                                <button
                                    type="button"
                                    class="btn btn-primary btn-sm seleccionar-equipo"
                                    data-id="${equipo.id}"
                                >
                                    Seleccionar
                                </button>
                            </td>
                        </tr>
                    `;

                });

            })
            .catch(error => {

                console.error(error);

                resultados.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center text-danger">
                            Error al buscar equipos
                        </td>
                    </tr>
                `;

            });
    }


    tipoEquipo.addEventListener(
        'change',
        buscarEquipos
    );


    buscar.addEventListener(
        'input',
        buscarEquipos
    );


    resultados.addEventListener(
        'click',
        function (event) {

            if (
                event.target.classList.contains(
                    'seleccionar-equipo'
                )
            ) {

                equipoId.value =
                    event.target.dataset.id;

                resultados.querySelectorAll('tr')
                    .forEach(row => {
                        row.classList.remove(
                            'table-success'
                        );
                    });

                event.target.closest('tr')
                    .classList.add(
                        'table-success'
                    );

                event.target.textContent =
                    'Seleccionado';

            }

        }
    );

});
</script>