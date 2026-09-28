@extends('layouts.app')

@section('template_title')
    Registrar Equipo
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <div class="text-muted small">MÓDULO EQUIPOS</div>
                    <h3 class="mb-0 fw-bold">REGISTRAR EQUIPO</h3>
                </div>
                <a href="{{ route('equipos.index') }}" class="btn btn-secondary btn-sm">ATRÁS</a>
            </div>

            <div class="card shadow-sm">
                <div class="card-body bg-white">
                    <form method="POST" action="{{ route('equipos.store') }}" role="form">
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
    .encabezado-verde {
        background-color: #90EE90 !important;
        color: #000;
        border-bottom: 1px solid #000;
    }
    .dato-label, .form-label {
        font-size: 12px;
        letter-spacing: .04em;
        color: #198754;
        font-weight: 700;
    }
    .card {
        border: 1px solid #000;
        border-radius: 6px;
        overflow: hidden;
    }
</style>
@include('aviso-cambios')
