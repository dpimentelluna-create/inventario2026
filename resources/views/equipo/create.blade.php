@extends('layouts.app')

@section('template_title')
    {{ __('Registrar') }} Equipo
@endsection

@section('content')
<section class="content container-fluid">

    <div class="row justify-content-center">

        <div class="col-md-10 col-lg-9">

            <div class="card shadow-sm">

                {{-- ENCABEZADO --}}
                <div class="card-header encabezado-verde">

                    <h4 class="mb-0">
                        <i class="bi bi-plus-circle"></i>
                        Registrar Nuevo Equipo
                    </h4>

                </div>

                {{-- FORMULARIO --}}
                <div class="card-body bg-white">

                    <form method="POST"
                          action="{{ route('equipos.store') }}"
                          role="form"
                          enctype="multipart/form-data">

                        @csrf

                        @include('equipo.form')

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>
@endsection
<style>

    /* ENCABEZADO */
    .encabezado-verde {
        background-color: #90EE90 !important;
        color: #000000;
        border-bottom: 1px solid #000000;
        text-align: center;
        padding: 15px;
    }

    /* TARJETA */
    .card {
        border: 1px solid #000000;
        border-radius: 6px;
        overflow: hidden;
    }

    /* ETIQUETAS */
    .form-label {
        font-weight: 600;
        color: #198754;
    }

    /* CAMPOS */
    .form-control,
    .form-select {
        border: 1px solid #000000;
        border-radius: 5px;
    }

    /* CUANDO SE SELECCIONA UN CAMPO */
    .form-control:focus,
    .form-select:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.15rem rgba(25, 135, 84, 0.15);
    }

    /* BOTONES */
    .btn {
        min-width: 100px;
    }

</style>