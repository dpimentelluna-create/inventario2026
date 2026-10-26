@extends('layouts.app')

@section('template_title')
    Editar Baja Administrativa
@endsection

@section('content')
@php
    $entregantesGuardados = $baja->entregantes ?: [
        [
            'nombre' => $baja->quien_entrego ?? '',
            'cargo' => '',
        ],
    ];

    $receptoresGuardados = $baja->receptores ?: [
        [
            'nombre' => $baja->quien_recibio ?? '',
            'cargo' => '',
        ],
    ];

    $entregantesOld = old('entregantes', $entregantesGuardados);
    $receptoresOld = old('receptores', $receptoresGuardados);

    if (empty($entregantesOld)) {
        $entregantesOld = [['nombre' => '', 'cargo' => '']];
    }

    if (empty($receptoresOld)) {
        $receptoresOld = [['nombre' => '', 'cargo' => '']];
    }
@endphp

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-xl-10 mx-auto">
            <div class="card shadow-sm">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-1 fw-bold">
                        <i class="bi bi-pencil-square me-2 text-primary"></i>
                        EDITAR BAJA ADMINISTRATIVA
                    </h5>
                    <small class="text-muted">
                        Registro #{{ $baja->id }} — Corrige los datos de la baja.
                    </small>
                </div>

                <div class="card-body">

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-1"></i>
                        En esta pantalla puedes corregir la información del acta.
                        El equipo asociado y su situación administrativa no se modificarán.
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>No se pudo actualizar la baja.</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form
                        action="{{ route('bajas-equipos.update', $baja->id) }}"
                        method="POST"
                        id="form-baja-equipo"
                    >
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- EQUIPO ASOCIADO: SOLO LECTURA --}}
                            <div class="col-12">
                                <div class="border rounded p-3">
                                    <h6 class="fw-bold mb-2">
                                        <i class="bi bi-pc-display me-2"></i>
                                        EQUIPO ASOCIADO
                                    </h6>

                                    <div class="row g-2">
                                        <div class="col-12 col-md-6">
                                            <small class="text-muted d-block">Tipo de equipo</small>
                                            <strong>
                                                {{ $baja->equipo->tipoEquipo->nombre ?? 'NO REGISTRADO' }}
                                            </strong>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <small class="text-muted d-block">Marca y modelo</small>
                                            <strong>
                                                {{ $baja->equipo->marca ?? '—' }}
                                                {{ $baja->equipo->modelo ?? '' }}
                                            </strong>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <small class="text-muted d-block">Número de serie</small>
                                            <strong>
                                                {{ $baja->equipo->num_serie ?: '—' }}
                                            </strong>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <small class="text-muted d-block">Código de inventario</small>
                                            <strong>
                                                {{ $baja->equipo->codigo_inventario ?: '—' }}
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- FECHA --}}
                            <div class="col-12 col-md-6">
                                <label for="fecha" class="form-label fw-semibold">
                                    Fecha de salida <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="date"
                                    name="fecha"
                                    id="fecha"
                                    class="form-control @error('fecha') is-invalid @enderror"
                                    value="{{ old('fecha', $baja->fecha ? \Illuminate\Support\Carbon::parse($baja->fecha)->format('Y-m-d') : '') }}"
                                    required
                                >

                                @error('fecha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- DESTINO --}}
                            <div class="col-12 col-md-6">
                                <label for="destino" class="form-label fw-semibold">
                                    Destino <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="destino"
                                    id="destino"
                                    class="form-control campo-mayusculas @error('destino') is-invalid @enderror"
                                    maxlength="150"
                                    value="{{ old('destino', $baja->destino) }}"
                                    required
                                >

                                @error('destino')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- QUIÉN ENTREGA --}}
                            <div class="col-12">
                                <div class="border rounded p-3">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                        <div>
                                            <h6 class="fw-bold mb-1">
                                                <i class="bi bi-box-arrow-up-right me-2"></i>
                                                QUIÉN ENTREGA
                                            </h6>
                                            <small class="text-muted">
                                                Registra al menos una persona e indica su cargo.
                                            </small>
                                        </div>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-success"
                                            data-agregar-integrante="entregantes"
                                        >
                                            <i class="bi bi-plus-circle me-1"></i>
                                            AGREGAR PERSONA
                                        </button>
                                    </div>

                                    <div id="lista-entregantes">
                                        @foreach ($entregantesOld as $i => $persona)
                                            <div class="row g-2 mb-3 integrante-row">
                                                <div class="col-12 col-md-5">
                                                    <label class="form-label">Nombre o comisión *</label>
                                                    <input
                                                        type="text"
                                                        name="entregantes[{{ $i }}][nombre]"
                                                        class="form-control campo-mayusculas"
                                                        maxlength="150"
                                                        value="{{ $persona['nombre'] ?? '' }}"
                                                        required
                                                    >
                                                </div>

                                                <div class="col-12 col-md-5">
                                                    <label class="form-label">Cargo *</label>
                                                    <input
                                                        type="text"
                                                        name="entregantes[{{ $i }}][cargo]"
                                                        class="form-control campo-mayusculas"
                                                        maxlength="150"
                                                        value="{{ $persona['cargo'] ?? '' }}"
                                                        required
                                                    >
                                                </div>

                                                <div class="col-12 col-md-2 d-flex align-items-end">
                                                    <button
                                                        type="button"
                                                        class="btn btn-outline-danger w-100"
                                                        data-quitar-integrante
                                                    >
                                                        <i class="bi bi-trash"></i>
                                                        QUITAR
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    @error('entregantes')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- QUIÉN RECIBE --}}
                            <div class="col-12">
                                <div class="border rounded p-3">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                        <div>
                                            <h6 class="fw-bold mb-1">
                                                <i class="bi bi-box-arrow-in-down me-2"></i>
                                                QUIÉN RECIBE
                                            </h6>
                                            <small class="text-muted">
                                                Registra al menos una persona e indica su cargo.
                                            </small>
                                        </div>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-success"
                                            data-agregar-integrante="receptores"
                                        >
                                            <i class="bi bi-plus-circle me-1"></i>
                                            AGREGAR PERSONA
                                        </button>
                                    </div>

                                    <div id="lista-receptores">
                                        @foreach ($receptoresOld as $i => $persona)
                                            <div class="row g-2 mb-3 integrante-row">
                                                <div class="col-12 col-md-5">
                                                    <label class="form-label">Nombre o comisión *</label>
                                                    <input
                                                        type="text"
                                                        name="receptores[{{ $i }}][nombre]"
                                                        class="form-control campo-mayusculas"
                                                        maxlength="150"
                                                        value="{{ $persona['nombre'] ?? '' }}"
                                                        required
                                                    >
                                                </div>

                                                <div class="col-12 col-md-5">
                                                    <label class="form-label">Cargo *</label>
                                                    <input
                                                        type="text"
                                                        name="receptores[{{ $i }}][cargo]"
                                                        class="form-control campo-mayusculas"
                                                        maxlength="150"
                                                        value="{{ $persona['cargo'] ?? '' }}"
                                                        required
                                                    >
                                                </div>

                                                <div class="col-12 col-md-2 d-flex align-items-end">
                                                    <button
                                                        type="button"
                                                        class="btn btn-outline-danger w-100"
                                                        data-quitar-integrante
                                                    >
                                                        <i class="bi bi-trash"></i>
                                                        QUITAR
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    @error('receptores')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- OBSERVACIONES --}}
                            <div class="col-12">
                                <label for="observaciones" class="form-label fw-semibold">
                                    Observaciones
                                </label>

                                <textarea
                                    name="observaciones"
                                    id="observaciones"
                                    class="form-control campo-mayusculas @error('observaciones') is-invalid @enderror"
                                    rows="4"
                                    maxlength="5000"
                                >{{ old('observaciones', $baja->observaciones) }}</textarea>

                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="d-flex justify-content-end flex-wrap gap-2 mt-4">
                            <a
                                href="{{ route('bajas-equipos.show', $baja->id) }}"
                                class="btn btn-outline-secondary"
                            >
                                <i class="bi bi-arrow-left me-1"></i>
                                CANCELAR
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check2-circle me-1"></i>
                                GUARDAR CAMBIOS
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    ['entregantes', 'receptores'].forEach(function (grupo) {
        const lista = document.getElementById('lista-' + grupo);

        if (!lista) return;

        let siguienteIndice = 0;

        lista.querySelectorAll('.integrante-row input[name]').forEach(function (input) {
            const coincidencia = input.name.match(new RegExp('^' + grupo + '\\[(\\d+)\\]'));

            if (coincidencia) {
                siguienteIndice = Math.max(
                    siguienteIndice,
                    Number(coincidencia[1]) + 1
                );
            }
        });

        function actualizarBotones() {
            const filas = lista.querySelectorAll('.integrante-row');

            filas.forEach(function (fila) {
                const boton = fila.querySelector('[data-quitar-integrante]');

                if (boton) {
                    boton.disabled = filas.length === 1;
                }
            });
        }

        document.querySelectorAll('[data-agregar-integrante="' + grupo + '"]')
            .forEach(function (boton) {
                boton.addEventListener('click', function () {
                    const indice = siguienteIndice++;

                    const fila = document.createElement('div');
                    fila.className = 'row g-2 mb-3 integrante-row';

                    fila.innerHTML = `
                        <div class="col-12 col-md-5">
                            <label class="form-label">Nombre o comisión *</label>
                            <input
                                type="text"
                                name="${grupo}[${indice}][nombre]"
                                class="form-control campo-mayusculas"
                                maxlength="150"
                                required
                            >
                        </div>

                        <div class="col-12 col-md-5">
                            <label class="form-label">Cargo *</label>
                            <input
                                type="text"
                                name="${grupo}[${indice}][cargo]"
                                class="form-control campo-mayusculas"
                                maxlength="150"
                                required
                            >
                        </div>

                        <div class="col-12 col-md-2 d-flex align-items-end">
                            <button
                                type="button"
                                class="btn btn-outline-danger w-100"
                                data-quitar-integrante
                            >
                                <i class="bi bi-trash"></i>
                                QUITAR
                            </button>
                        </div>
                    `;

                    lista.appendChild(fila);
                    actualizarBotones();
                    fila.querySelector('input').focus();
                });
            });

        lista.addEventListener('click', function (evento) {
            const boton = evento.target.closest('[data-quitar-integrante]');

            if (!boton || lista.querySelectorAll('.integrante-row').length <= 1) {
                return;
            }

            boton.closest('.integrante-row').remove();
            actualizarBotones();
        });

        actualizarBotones();
    });
});
</script>
@endsection
