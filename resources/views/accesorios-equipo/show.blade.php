@extends('layouts.app')

@section('template_title')
    {{ $accesoriosEquipo->name ?? __('Show') . " " . __('Accesorios Equipo') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Accesorios Equipo</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('accesorios-equipo.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="row padding-1 p-1">

    {{-- INFORMACIÓN DEL ACCESORIO --}}
    <div class="col-md-12">

        <h4 class="mb-3">
            Información del Accesorio
        </h4>

        <div class="card mb-4">
            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <strong>Tipo:</strong>
                        <p class="mb-0">
                            {{ $accesoriosEquipo->tipo }}
                        </p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Marca:</strong>
                        <p class="mb-0">
                            {{ $accesoriosEquipo->marca ?? 'No registrado' }}
                        </p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>N.º de Serie:</strong>
                        <p class="mb-0">
                            {{ $accesoriosEquipo->num_serie ?? 'No registrado' }}
                        </p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Estado:</strong>
                        <p class="mb-0">
                            {{ $accesoriosEquipo->estado }}
                        </p>
                    </div>

                    <div class="col-md-12 mb-3">
                        <strong>Observaciones:</strong>
                        <p class="mb-0">
                            {{ $accesoriosEquipo->observaciones ?? 'Sin observaciones' }}
                        </p>
                    </div>

                </div>

            </div>
        </div>


        {{-- EQUIPO RELACIONADO --}}
        <h4 class="mb-3">
            Equipo Relacionado
        </h4>

        <div class="card">
            <div class="card-body">

                @if($accesoriosEquipo->equipo)

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <strong>Tipo de Equipo:</strong>
                            <p class="mb-0">
                                {{ $accesoriosEquipo->equipo->tipoEquipo->nombre ?? 'No registrado' }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Marca:</strong>
                            <p class="mb-0">
                                {{ $accesoriosEquipo->equipo->marca ?? 'No registrado' }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Modelo:</strong>
                            <p class="mb-0">
                                {{ $accesoriosEquipo->equipo->modelo ?? 'No registrado' }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>N.º de Serie:</strong>
                            <p class="mb-0">
                                {{ $accesoriosEquipo->equipo->num_serie ?? 'No registrado' }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Código de Inventario:</strong>
                            <p class="mb-0">
                                {{ $accesoriosEquipo->equipo->codigo_inventario ?? 'No registrado' }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Estado del Equipo:</strong>
                            <p class="mb-0">
                                {{ $accesoriosEquipo->equipo->estado ?? 'No registrado' }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Ubicación:</strong>
                            <p class="mb-0">
                                {{ $accesoriosEquipo->equipo->ubicacione->nombre ?? 'No registrada' }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Fecha de Registro:</strong>
                            <p class="mb-0">
                                {{ $accesoriosEquipo->equipo->fecha_registro ?? 'No registrada' }}
                            </p>
                        </div>

                        <div class="col-md-12 mb-3">
                            <strong>Observación del Equipo:</strong>
                            <p class="mb-0">
                                {{ $accesoriosEquipo->equipo->observacion ?? 'Sin observaciones' }}
                            </p>
                        </div>

                    </div>

                @else

                    <div class="alert alert-warning">
                        No se encontró información del equipo asociado.
                    </div>

                @endif

            </div>
        </div>

    </div>


    {{-- BOTONES --}}
    <div class="col-md-12 mt-3">

        <a href="{{ route('accesorios-equipo.index') }}"
           class="btn btn-secondary">
            Volver
        </a>
    </div>

</div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
