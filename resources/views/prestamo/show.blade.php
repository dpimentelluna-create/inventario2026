@extends('layouts.app')

@section('template_title')
    {{ $prestamo->name ?? __('Show') . " " . __('Prestamo') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Prestamo</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('prestamos.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <h4>Información del equipo</h4>

<p>
    <strong>Tipo:</strong>
    {{ $prestamo->equipo->tipoEquipo->nombre }}
</p>

<p>
    <strong>Marca:</strong>
    {{ $prestamo->equipo->marca }}
</p>

<p>
    <strong>Modelo:</strong>
    {{ $prestamo->equipo->modelo }}
</p>

<p>
    <strong>Número de serie:</strong>
    {{ $prestamo->equipo->num_serie }}
</p>

<p>
    <strong>Código de inventario:</strong>
    {{ $prestamo->equipo->codigo_inventario }}
</p>
                                <div class="form-group mb-2 mb20">
                                    <strong>Docente Id:</strong>
                                    {{ $prestamo->docente_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Ubicacion Destino Id:</strong>
                                    {{ $prestamo->ubicacion_destino_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Entrega:</strong>
                                    {{ $prestamo->fecha_entrega }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Devolucion Prevista:</strong>
                                    {{ $prestamo->fecha_devolucion_prevista }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Devolucion Real:</strong>
                                    {{ $prestamo->fecha_devolucion_real }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Estado:</strong>
                                    {{ $prestamo->estado }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Observacion:</strong>
                                    {{ $prestamo->observacion }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
