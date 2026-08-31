@extends('layouts.app')

@section('template_title')
    Ver Equipo
@endsection

@section('content')

    <section class="content container-fluid">

        <div class="row justify-content-center">

            <div class="col-md-10 col-lg-9">

                <div class="card shadow-sm">

                    {{-- ===================================================== --}}
                    {{-- ENCABEZADO --}}
                    {{-- ===================================================== --}}

                    <div class="card-header encabezado-verde">

                        <h4 class="mb-0">
                            <i class="bi bi-pc-display"></i>
                            Detalles del Equipo
                        </h4>

                    </div>


                    <div class="card-body bg-white">

                        {{-- ===================================================== --}}
                        {{-- PARTE 1 - DATOS DEL EQUIPO --}}
                        {{-- ===================================================== --}}

                        <div class="seccion-titulo">
                            <i class="bi bi-info-circle"></i>
                            Parte 1 — Datos del Equipo
                        </div>

                        <div class="row">

                            {{-- TIPO DE EQUIPO --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Tipo de Equipo
                                </label>

                                <div class="campo-lectura">
                                    {{ $equipo->tipoEquipo->nombre ?? '-' }}
                                </div>
                            </div>


                            {{-- NÚMERO DE SERIE --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Número de Serie
                                </label>

                                <div class="campo-lectura">
                                    {{ $equipo->num_serie ?? '-' }}
                                </div>
                            </div>


                            {{-- MARCA --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Marca
                                </label>

                                <div class="campo-lectura">
                                    {{ $equipo->marca ?? '-' }}
                                </div>
                            </div>


                            {{-- MODELO --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Modelo
                                </label>

                                <div class="campo-lectura">
                                    {{ $equipo->modelo ?? '-' }}
                                </div>
                            </div>


                            {{-- UBICACIÓN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Ubicación
                                </label>

                                <div class="campo-lectura">
                                    {{ $equipo->ubicacione->nombre ?? '-' }}
                                </div>
                            </div>


                            {{-- FECHA --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Fecha de Registro
                                </label>

                                <div class="campo-lectura">
                                    {{ $equipo->fecha_registro ?? '-' }}
                                </div>
                            </div>

                        </div>


                        {{-- ===================================================== --}}
                        {{-- PARTE 2 - ESPECIFICACIONES --}}
                        {{-- ===================================================== --}}

                        <div class="seccion-titulo mt-4">

                            <i class="bi bi-cpu"></i>
                            Parte 2 — Especificaciones

                        </div>


                        {{-- ===================================================== --}}
                        {{-- LAPTOP --}}
                        {{-- ===================================================== --}}

                        @if ($equipo->especificacionesLaptops)
                            <div class="row">

                                {{-- PROCESADOR --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Procesador
                                    </label>

                                    <div class="campo-lectura">
                                        {{ $equipo->especificacionesLaptops->procesador ?? '-' }}
                                    </div>

                                </div>


                                {{-- RAM --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Memoria RAM
                                    </label>

                                    <div class="campo-lectura">
                                        {{ $equipo->especificacionesLaptops->ram ?? '-' }}
                                    </div>

                                </div>


                                {{-- DISCO DURO --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Disco Duro
                                    </label>

                                    <div class="campo-lectura">
                                        {{ $equipo->especificacionesLaptops->disco_duro ?? '-' }}
                                    </div>

                                </div>


                                {{-- COLOR --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Color
                                    </label>

                                    <div class="campo-lectura">
                                        {{ $equipo->especificacionesLaptops->color ?? '-' }}
                                    </div>

                                </div>


                                {{-- ESTADO --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Estado del Equipo
                                    </label>

                                    <div class="campo-lectura">
                                        {{ $equipo->especificacionesLaptops->estado ?? 'Regular' }}
                                    </div>

                                </div>


                                {{-- OBSERVACIONES --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Observaciones
                                    </label>

                                    <div class="campo-lectura campo-observaciones">
                                        {{ $equipo->especificacionesLaptops->observaciones ?? '-' }}
                                    </div>

                                </div>

                            </div>


                            {{-- ===================================================== --}}
                            {{-- OTRO EQUIPO --}}
                            {{-- ===================================================== --}}
                        @elseif($equipo->especificacionesEquipo)
                            <div class="row">

                                {{-- DESCRIPCIÓN --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Descripción
                                    </label>

                                    <div class="campo-lectura">
                                        {{ $equipo->especificacionesEquipo->descripcion ?? '-' }}
                                    </div>

                                </div>


                                {{-- COLOR --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Color
                                    </label>

                                    <div class="campo-lectura">
                                        {{ $equipo->especificacionesEquipo->color ?? '-' }}
                                    </div>

                                </div>


                                {{-- ESTADO --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Estado del Equipo
                                    </label>

                                    <div class="campo-lectura">
                                        {{ $equipo->especificacionesEquipo->estado ?? 'Regular' }}
                                    </div>

                                </div>


                                {{-- OBSERVACIONES --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Observaciones
                                    </label>

                                    <div class="campo-lectura campo-observaciones">
                                        {{ $equipo->especificacionesEquipo->observaciones ?? '-' }}
                                    </div>

                                </div>

                            </div>
                        @endif


                        {{-- ===================================================== --}}
                        {{-- PARTE 3 - ACCESORIOS --}}
                        {{-- ===================================================== --}}

                        <div class="seccion-titulo mt-4">

                            <i class="bi bi-tools"></i>
                            Parte 3 — Accesorios del Equipo

                        </div>


                        @if ($equipo->accesoriosEquipos->count() > 0)
                            @foreach ($equipo->accesoriosEquipos as $accesorio)
                                <div class="accesorio-card mb-3">

                                    <div class="row">

                                        {{-- TIPO --}}
                                        <div class="col-md-3 mb-3">

                                            <label class="form-label">
                                                Tipo
                                            </label>

                                            <div class="campo-lectura">
                                                {{ $accesorio->tipo ?? '-' }}
                                            </div>

                                        </div>


                                        {{-- MARCA --}}
                                        <div class="col-md-3 mb-3">

                                            <label class="form-label">
                                                Marca
                                            </label>

                                            <div class="campo-lectura">
                                                {{ $accesorio->marca ?? '-' }}
                                            </div>

                                        </div>


                                        {{-- NÚMERO DE SERIE --}}
                                        <div class="col-md-3 mb-3">

                                            <label class="form-label">
                                                N.º de Serie
                                            </label>

                                            <div class="campo-lectura">
                                                {{ $accesorio->num_serie ?? '-' }}
                                            </div>

                                        </div>


                                        {{-- ESTADO --}}
                                        <div class="col-md-3 mb-3">

                                            <label class="form-label">
                                                Estado
                                            </label>

                                            <div class="campo-lectura">
                                                {{ $accesorio->estado ?? 'Regular' }}
                                            </div>

                                        </div>


                                        {{-- OBSERVACIONES --}}
                                        <div class="col-md-12">

                                            <label class="form-label">
                                                Observaciones
                                            </label>

                                            <div class="campo-lectura campo-observaciones">
                                                {{ $accesorio->observaciones ?? '-' }}
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-secondary">

                                <i class="bi bi-info-circle"></i>
                                Este equipo no tiene accesorios registrados.

                            </div>
                        @endif


                        {{-- ===================================================== --}}
                        {{-- BOTONES --}}
                        {{-- ===================================================== --}}

                        <div class="mt-4">

                            <a href="{{ route('equipos.index') }}" class="btn btn-secondary">

                                <i class="bi bi-arrow-left"></i>
                                Volver

                            </a>


                            <a href="{{ route('equipos.edit', $equipo->id) }}" class="btn btn-warning">

                                <i class="bi bi-pencil"></i>
                                Editar

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection


<style>
    /* ===================================================== */
    /* TARJETA PRINCIPAL */
    /* ===================================================== */

    .card {
        border: 1px solid #000000;
        border-radius: 6px;
        overflow: hidden;
    }


    /* ===================================================== */
    /* ENCABEZADO */
    /* ===================================================== */

    .encabezado-verde {
        background-color: #90EE90 !important;
        color: #000000;
        border-bottom: 1px solid #000000;
        text-align: center;
        padding: 15px;
    }


    /* ===================================================== */
    /* TÍTULOS DE SECCIÓN */
    /* ===================================================== */

    .seccion-titulo {
        background-color: #f8f9fa;
        border: 1px solid #000000;
        border-radius: 5px;
        padding: 10px 15px;
        margin-bottom: 20px;
        font-weight: bold;
        color: #198754;
    }


    /* ===================================================== */
    /* ETIQUETAS */
    /* ===================================================== */

    .form-label {
        font-weight: 600;
        color: #198754;
    }


    /* ===================================================== */
    /* CAMPOS DE SOLO LECTURA */
    /* ===================================================== */

    .campo-lectura {
        /*border: 1px solid #000000;*/
        border-radius: 5px;
        background-color: #f7fdef;
        min-height: 38px;
        padding: 8px 12px;
        color: #212529;
    }


    /* ===================================================== */
    /* OBSERVACIONES */
    /* ===================================================== */

    .campo-observaciones {
        min-height: 60px;
        white-space: pre-line;
    }


    /* ===================================================== */
    /* TARJETA DE ACCESORIO */
    /* ===================================================== */

    .accesorio-card {
        border: 1px solid #7eac88;
        border-radius: 5px;
        padding: 15px;
        background-color: #ffffff;
    }


    /* ===================================================== */
    /* BOTONES */
    /* ===================================================== */

    .btn {
        min-width: 100px;
    }
</style>