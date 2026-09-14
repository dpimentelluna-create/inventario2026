@extends('layouts.app')

@section('template_title')
    Ver Ubicación
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header encabezado-verde d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="mb-0">
                        <i class="bi bi-geo-alt"></i>
                        Ubicación
                    </h4>
                    <a class="btn btn-primary btn-sm" href="{{ route('ubicaciones.index') }}">ATRÁS</a>
                </div>
                <div class="card-body bg-white">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">NOMBRE</label>
                            <input type="text" class="form-control" value="{{ $ubicacione->nombre }}" readonly>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">TIPO</label>
                            <input type="text" class="form-control" value="{{ $ubicacione->tipo ?? '-' }}" readonly>
                        </div>
                    </div>
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
</style>
