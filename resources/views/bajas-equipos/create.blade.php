@extends('layouts.app')

@section('template_title')
    Registrar baja administrativa
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-xl-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-1 fw-bold">
                        <i class="bi bi-box-arrow-up-right me-2 text-success"></i>
                        REGISTRAR BAJA ADMINISTRATIVA
                    </h5>
                    <small class="text-muted">
                        Registra la salida de un equipo de la institución.
                    </small>
                </div>

                <div class="card-body">
                    <div class="alert alert-warning" role="alert">
                        <strong>Importante:</strong>
                        esta acción cambiará la situación administrativa del equipo a
                        <strong>DE_BAJA</strong>. El equipo no se eliminará del inventario
                        ni se modificará su estado físico.
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>No se pudo registrar la baja.</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($equipos->isEmpty())
                        <div class="alert alert-info">
                            No hay equipos disponibles para registrar una baja administrativa.
                        </div>

                        <a href="{{ route('bajas-equipos.index') }}"
                           class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>
                            VOLVER AL HISTORIAL
                        </a>
                    @else
                        <form action="{{ route('bajas-equipos.store') }}"
                              method="POST"
                              id="form-baja-equipo">
                            @csrf

                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="equipo_id" class="form-label fw-semibold">
                                        Equipo <span class="text-danger">*</span>
                                    </label>

                                    <select name="equipo_id"
                                            id="equipo_id"
                                            class="form-select @error('equipo_id') is-invalid @enderror"
                                            required>
                                        <option value="">Seleccione un equipo</option>

                                        @foreach ($equipos as $equipo)
                                            <option value="{{ $equipo->id }}"
                                                @selected(old('equipo_id') == $equipo->id)>
                                                ID {{ $equipo->id }} —
                                                {{ $equipo->tipoEquipo->nombre ?? 'SIN TIPO' }} —
                                                {{ $equipo->marca }}
                                                {{ $equipo->modelo }}
                                                @if ($equipo->num_serie)
                                                    — Serie: {{ $equipo->num_serie }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('equipo_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <div class="form-text">
                                        Solo se muestran equipos que actualmente figuran
                                        EN_INVENTARIO. La disponibilidad se volverá a validar
                                        al guardar.
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="fecha" class="form-label fw-semibold">
                                        Fecha de salida <span class="text-danger">*</span>
                                    </label>

                                    <input type="date"
                                           name="fecha"
                                           id="fecha"
                                           class="form-control @error('fecha') is-invalid @enderror"
                                           value="{{ old('fecha', now()->format('Y-m-d')) }}"
                                           required>

                                    @error('fecha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="destino" class="form-label fw-semibold">
                                        Destino <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                           name="destino"
                                           id="destino"
                                           class="form-control @error('destino') is-invalid @enderror"
                                           maxlength="150"
                                           value="{{ old('destino') }}"
                                           placeholder="Ej.: UGEL, otra institución"
                                           required>

                                    @error('destino')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="quien_entrego" class="form-label fw-semibold">
                                        Quién entrega <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                           name="quien_entrego"
                                           id="quien_entrego"
                                           class="form-control @error('quien_entrego') is-invalid @enderror"
                                           maxlength="150"
                                           value="{{ old('quien_entrego') }}"
                                           placeholder="Nombre de quien entrega"
                                           required>

                                    @error('quien_entrego')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="quien_recibio" class="form-label fw-semibold">
                                        Quién recibe <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                           name="quien_recibio"
                                           id="quien_recibio"
                                           class="form-control @error('quien_recibio') is-invalid @enderror"
                                           maxlength="150"
                                           value="{{ old('quien_recibio') }}"
                                           placeholder="Nombre de quien recibe"
                                           required>

                                    @error('quien_recibio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="observaciones" class="form-label fw-semibold">
                                        Observaciones
                                    </label>

                                    <textarea name="observaciones"
                                              id="observaciones"
                                              class="form-control @error('observaciones') is-invalid @enderror"
                                              rows="4"
                                              placeholder="Motivo de la salida, reparación, transferencia u otros detalles">{{ old('observaciones') }}</textarea>

                                    @error('observaciones')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-end flex-wrap gap-2">
                                <a href="{{ route('bajas-equipos.index') }}"
                                   class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-1"></i>
                                    CANCELAR
                                </a>

                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i>
                                    REGISTRAR BAJA
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection