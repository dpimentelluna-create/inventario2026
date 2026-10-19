@extends('layouts.app')

@section('template_title')
    Acceso denegado
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card mt-4">
                    <div class="card-header">
                        <span class="card-title">ACCESO DENEGADO</span>
                    </div>
                    <div class="card-body text-center py-5">
                        <i class="bi bi-shield-lock fs-1 text-danger"></i>
                        <p class="mt-3 mb-1 fw-semibold">No tienes permiso para realizar esta acción.</p>
                        <p class="text-muted mb-4">
                            {{ $exception->getMessage() ?: 'Si crees que es un error, contacta al administrador del sistema.' }}
                        </p>
                        <a href="{{ url('/home') }}" class="btn btn-primary btn-sm">Volver al inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection