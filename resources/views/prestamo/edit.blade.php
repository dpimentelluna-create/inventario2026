@extends('layouts.app')

@section('template_title')
    Editar Préstamo
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-11">
            <div class="card shadow-sm">
                <div class="card-header encabezado-verde">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil-square"></i>
                        Editar Préstamo
                    </h4>
                </div>
                <div class="card-body bg-white">
                    <form method="POST" action="{{ route('prestamos.update', $prestamo->id) }}" role="form">
                        @method('PATCH')
                        @csrf
                        @include('prestamo.form')
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
        color: #000000;
        border-bottom: 1px solid #000000;
        text-align: center;
        padding: 15px;
    }
    .card {
        border: 1px solid #000000;
        border-radius: 6px;
        overflow: hidden;
    }
</style>
@include('aviso-cambios')