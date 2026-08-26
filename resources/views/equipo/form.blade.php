<div class="row padding-1 p-1">

    <div class="col-md-12">

        {{-- TIPO DE EQUIPO --}}
        <div class="form-group mb-2 mb20">

            <label for="tipo_equipo_id" class="form-label">
                {{ __('Tipo de Equipo') }}
            </label>

            <select
                name="tipo_equipo_id"
                class="form-select @error('tipo_equipo_id') is-invalid @enderror"
                id="tipo_equipo_id"
            >

                <option value="">
                    Seleccione un Tipo de Equipo
                </option>

                @foreach($tiposequipo as $id => $nombre)

                    <option
                        value="{{ $id }}"
                        {{ old('tipo_equipo_id', $equipo->tipo_equipo_id ?? '') == $id ? 'selected' : '' }}
                    >
                        {{ $nombre }}
                    </option>

                @endforeach

            </select>

            {!! $errors->first(
                'tipo_equipo_id',
                '<div class="invalid-feedback" role="alert">
                    <strong>:message</strong>
                </div>'
            ) !!}

        </div>

        {{-- NÚMERO DE SERIE --}}
        <div class="form-group mb-2 mb20">

            <label for="num_serie" class="form-label">
                {{ __('Num. Serie') }}
            </label>

            <input
                type="text"
                name="num_serie"
                class="form-control @error('num_serie') is-invalid @enderror"
                value="{{ old('num_serie', $equipo?->num_serie) }}"
                id="num_serie"
                placeholder="Num Serie"
            >

            {!! $errors->first(
                'num_serie',
                '<div class="invalid-feedback" role="alert">
                    <strong>:message</strong>
                </div>'
            ) !!}

        </div>

        {{-- MARCA --}}
        <div class="form-group mb-2 mb20">

            <label for="marca" class="form-label">
                {{ __('Marca') }}
            </label>

            <input
                type="text"
                name="marca"
                class="form-control @error('marca') is-invalid @enderror"
                value="{{ old('marca', $equipo?->marca) }}"
                id="marca"
                placeholder="Marca"
            >

            {!! $errors->first(
                'marca',
                '<div class="invalid-feedback" role="alert">
                    <strong>:message</strong>
                </div>'
            ) !!}

        </div>


        {{-- MODELO --}}
        <div class="form-group mb-2 mb20">

            <label for="modelo" class="form-label">
                {{ __('Modelo') }}
            </label>

            <input
                type="text"
                name="modelo"
                class="form-control @error('modelo') is-invalid @enderror"
                value="{{ old('modelo', $equipo?->modelo) }}"
                id="modelo"
                placeholder="Modelo"
            >

            {!! $errors->first(
                'modelo',
                '<div class="invalid-feedback" role="alert">
                    <strong>:message</strong>
                </div>'
            ) !!}

        </div>

        <!--
        {{-- CÓDIGO DE INVENTARIO --}}
        <div class="form-group mb-2 mb20">

            <label for="codigo_inventario" class="form-label">
                {{ __('Codigo Inventario') }}
            </label>

            <input
                type="text"
                name="codigo_inventario"
                class="form-control @error('codigo_inventario') is-invalid @enderror"
                value="{{ old('codigo_inventario', $equipo?->codigo_inventario) }}"
                id="codigo_inventario"
                placeholder="Codigo Inventario"
            >

            {!! $errors->first(
                'codigo_inventario',
                '<div class="invalid-feedback" role="alert">
                    <strong>:message</strong>
                </div>'
            ) !!}

        </div>-->


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

                <option value="Nuevo"
                    {{ old('estado', $equipo?->estado) == 'Nuevo' ? 'selected' : '' }}>
                    NUEVO
                </option>

                <option value="Operativo"
                    {{ old('estado', $equipo?->estado) == 'Operativo' ? 'selected' : '' }}>
                    OPERATIVO
                </option>

                <option value="Regular"
                    {{ old('estado', $equipo?->estado) == 'Regular' ? 'selected' : '' }}>
                    REGULAR
                </option>

                <option value="Malogrado"
                    {{ old('estado', $equipo?->estado) == 'Malogrado' ? 'selected' : '' }}>
                    MALOGRADO
                </option>

                <option value="De baja"
                    {{ old('estado', $equipo?->estado) == 'De baja' ? 'selected' : '' }}>
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


        {{-- UBICACIÓN --}}
        <div class="form-group mb-2 mb20">

            <label for="ubicacion_id" class="form-label">
                {{ __('Ubicacion') }}
            </label>

            <select
                name="ubicacion_id"
                class="form-select @error('ubicacion_id') is-invalid @enderror"
                id="ubicacion_id"
            >

                <option value="">
                    Seleccione una Ubicacion
                </option>

                @foreach($ubicacione as $id => $nombre)

                    <option
                        value="{{ $id }}"
                        {{ old('ubicacion_id', $equipo->ubicacion_id ?? '') == $id ? 'selected' : '' }}
                    >
                        {{ $nombre }}
                    </option>

                @endforeach

            </select>

            {!! $errors->first(
                'ubicacion_id',
                '<div class="invalid-feedback" role="alert">
                    <strong>:message</strong>
                </div>'
            ) !!}

        </div>


        {{-- FECHA DE REGISTRO --}}
        <div class="form-group mb-2 mb20">

            <label for="fecha_registro" class="form-label">
                {{ __('Fecha Registro') }}
            </label>

            <input
                type="date"
                name="fecha_registro"
                class="form-control @error('fecha_registro') is-invalid @enderror"
                value="{{ old('fecha_registro', $equipo?->fecha_registro) }}"
                id="fecha_registro"
            >

            {!! $errors->first(
                'fecha_registro',
                '<div class="invalid-feedback" role="alert">
                    <strong>:message</strong>
                </div>'
            ) !!}

        </div>


        {{-- OBSERVACIÓN --}}
        <div class="form-group mb-2 mb20">

            <label for="observacion" class="form-label">
                {{ __('Observacion') }}
            </label>

            <textarea
                name="observacion"
                class="form-control @error('observacion') is-invalid @enderror"
                id="observacion"
                placeholder="Observacion"
                rows="4"
            >{{ old('observacion', $equipo?->observacion) }}</textarea>

            {!! $errors->first(
                'observacion',
                '<div class="invalid-feedback" role="alert">
                    <strong>:message</strong>
                </div>'
            ) !!}

        </div>

    </div>


    {{-- BOTÓN --}}
    <div class="col-md-12 mt-4">

    <button type="submit" class="btn btn-success">
        <i class="bi bi-check-circle"></i>
        Guardar
    </button>

    <a href="{{ route('equipos.index') }}"
       class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i>
        Volver
    </a>

</div>

</div>