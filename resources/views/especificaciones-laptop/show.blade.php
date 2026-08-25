@extends('layouts.app')

@section('template_title')
    {{ $especificacionesLaptop->name ?? __('Show') . " " . __('Especificaciones Laptop') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Especificaciones Laptop</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('especificaciones-laptop.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
    <div class="container-fluid">

    <div class="card">

        <div class="card-header">
            <h3>Detalles de Especificaciones de Laptop</h3>
        </div>

        <div class="card-body">

            {{-- EQUIPO --}}

            <div class="mb-3">
                <strong>TIPO:</strong>

                @if($especificacionesLaptop->equipo)
                    {{ $especificacionesLaptop->equipo->tipoEquipo->nombre }}
                @else
                    No asignado
                @endif
            </div>

            <div class="mb-3">
                <strong>Equipo:</strong>

                @if($especificacionesLaptop->equipo)
                    {{ $especificacionesLaptop->equipo->num_serie }}
                @else
                    No asignado
                @endif
            </div>

            {{-- MARCA --}}

            
            <div class="mb-3">
                <strong>Marca:</strong>

                @if($especificacionesLaptop->equipo)
                    {{ $especificacionesLaptop->equipo->marca }}
                @else
                    -
                @endif
            </div>

            {{-- MODELO --}}
            <div class="mb-3">
                <strong>Modelo:</strong>

                @if($especificacionesLaptop->equipo)
                    {{ $especificacionesLaptop->equipo->modelo ?? '-' }}
                @else
                    -
                @endif
            </div>

            {{-- PROCESADOR --}}
            <div class="mb-3">
                <strong>Procesador:</strong>
                {{ $especificacionesLaptop->procesador ?? '-' }}
            </div>

            {{-- RAM --}}
            <div class="mb-3">
                <strong>Memoria RAM:</strong>
                {{ $especificacionesLaptop->ram ?? '-' }}
            </div>

            {{-- DISCO DURO --}}
            <div class="mb-3">
                <strong>Disco Duro:</strong>
                {{ $especificacionesLaptop->disco_duro ?? '-' }}
            </div>

            {{-- COLOR --}}
            <div class="mb-3">
                <strong>Color:</strong>
                {{ $especificacionesLaptop->color ?? '-' }}
            </div>

            {{-- ESTADO --}}
            <div class="mb-3">
                <strong>Estado:</strong>
                {{ $especificacionesLaptop->estado ?? '-' }}
            </div>

            {{-- OBSERVACIONES --}}
            <div class="mb-3">
                <strong>Observaciones:</strong>

                @if($especificacionesLaptop->observaciones)
                    {{ $especificacionesLaptop->observaciones }}
                @else
                    -
                @endif
            </div>

        </div>


        

        </div>
<div class="col-md-12 mt-3">

        <a href="{{ route('especificaciones-laptop.index') }}"
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
