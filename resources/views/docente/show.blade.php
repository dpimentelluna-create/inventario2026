@extends('layouts.app')

@section('template_title')
    {{ $docente->name ?? __('Show') . " " . __('Docente') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Docente</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('docentes.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Nombres:</strong>
                                    {{ $docente->nombres }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Apellidos:</strong>
                                    {{ $docente->apellidos }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Cargo:</strong>
                                    {{ $docente->cargo }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Dni:</strong>
                                    {{ $docente->dni }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Correo:</strong>
                                    {{ $docente->correo }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Celular:</strong>
                                    {{ $docente->celular }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
