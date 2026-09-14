@extends('layouts.app')

@section('template_title')
    Registrar Ubicación
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header encabezado-verde">
                    <h4 class="mb-0">
                        <i class="bi bi-plus-circle"></i>
                        Registrar Ubicación
                    </h4>
                </div>
                <div class="card-body bg-white">
                    <form method="POST" action="{{ route('ubicaciones.store') }}" role="form">
                        @csrf
                        @include('ubicacione.form')
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
    .form-label {
        font-weight: 600;
        color: #198754;
    }
    .form-control,
    .form-select {
        border: 1px solid #000000;
        border-radius: 5px;
    }
    .form-control:focus,
    .form-select:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.15rem rgba(25, 135, 84, 0.15);
    }
    .btn {
        min-width: 100px;
    }
</style>
