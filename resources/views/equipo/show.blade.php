@extends('layouts.app')

@section('template_title')
    {{ $equipo->name ?? __('Ver') . " " . __('Equipo') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Equipo</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('equipos.index') }}"> {{ __('Atrás') }}</a>
                        </div>
                    </div>

                    <!--MODIFICAR DISEÑO DE SHOW-->
                    <div class="card-body bg-white">
                        
                                <div class="container-fluid">

        {{-- TÍTULO --}}
        <div class="mb-4">
            <h3 class="fw-bold">
                Detalles del Equipo
            </h3>
            <p class="text-muted">
                Información registrada del equipo
            </p>
        </div>

        {{-- INFORMACIÓN PRINCIPAL --}}
        <div class="row">

            {{-- TIPO DE EQUIPO --}}
            <div class="col-md-6 mb-3">
                <div class="dato-equipo">
                    <span class="titulo-dato">Tipo de Equipo</span>

                    <span class="valor-dato">
                        {{ $equipo->tipoEquipo->nombre ?? '-' }}
                    </span>
                </div>
            </div>

            {{-- MARCA --}}
            <div class="col-md-6 mb-3">
                <div class="dato-equipo">
                    <span class="titulo-dato">Marca</span>

                    <span class="valor-dato">
                        {{ $equipo->marca ?? '-' }}
                    </span>
                </div>
            </div>

            {{-- MODELO --}}
            <div class="col-md-6 mb-3">
                <div class="dato-equipo">
                    <span class="titulo-dato">Modelo</span>

                    <span class="valor-dato">
                        {{ $equipo->modelo ?? '-' }}
                    </span>
                </div>
            </div>

            {{-- NÚMERO DE SERIE --}}
            <div class="col-md-6 mb-3">
                <div class="dato-equipo">
                    <span class="titulo-dato">Número de Serie</span>

                    <span class="valor-dato">
                        {{ $equipo->num_serie ?? '-' }}
                    </span>
                </div>
            </div>

            {{-- CÓDIGO DE INVENTARIO --}}
            <div class="col-md-6 mb-3">
                <div class="dato-equipo">
                    <span class="titulo-dato">Código de Inventario</span>

                    <span class="valor-dato">
                        {{ $equipo->codigo_inventario ?? '-' }}
                    </span>
                </div>
            </div>

            {{-- ESTADO --}}
            <div class="col-md-6 mb-3">
                <div class="dato-equipo">
                    <span class="titulo-dato">Estado</span>

                    <span class="valor-dato">
                        {{ $equipo->estado ?? '-' }}
                    </span>
                </div>
            </div>

            {{-- UBICACIÓN --}}
            <div class="col-md-6 mb-3">
                <div class="dato-equipo">
                    <span class="titulo-dato">Ubicación</span>

                    <span class="valor-dato">
                        {{ $equipo->ubicacione->nombre ?? '-' }}
                    </span>
                </div>
            </div>

            {{-- FECHA DE REGISTRO --}}
            <div class="col-md-6 mb-3">
                <div class="dato-equipo">
                    <span class="titulo-dato">Fecha de Registro</span>

                    <span class="valor-dato">
                        {{ $equipo->fecha_registro ?? '-' }}
                    </span>
                </div>
            </div>

        </div>

        {{-- OBSERVACIÓN --}}
        <div class="mt-2 mb-4">
            <div class="dato-equipo">
                <span class="titulo-dato">Observaciones</span>

                <div class="valor-observacion">
                    {{ $equipo->observacion ?? '-' }}
                </div>
            </div>
        </div>

        {{-- BOTONES --}}
        <div class="mt-4">

            {{-- BOTONE VOLVER --}}
            <a href="{{ route('equipos.index') }}"
                class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>
                Volver
    </a>

            {{-- BOTON EDITAR --}}
            <a href="{{ route('equipos.edit', $equipo->id) }}"
                class="btn btn-warning">
                <i class="bi bi-pencil"></i>
                Editar
            </a>
        </div>  
    </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<style>
    .dato-equipo {
        /*border: 1px solid #000;
        border-radius: 5px;*/
        padding: 12px 15px;
        background-color: #fff;
        height: 100%;
    }

    .titulo-dato {
        display: block;
        font-size: 14px;
        font-weight: bold;
        color: #198754;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .valor-dato {
        display: block;
        font-size: 16px;
        color: #212529;
    }

    .valor-observacion {
        margin-top: 5px;
        min-height: 70px;
        font-size: 16px;
        color: #212529;
        white-space: pre-line;
    }
</style>