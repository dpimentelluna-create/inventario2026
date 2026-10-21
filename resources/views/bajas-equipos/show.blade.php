@extends('layouts.app')

@section('template_title')
    Detalle de baja administrativa

<script>
function confirmarAnularBaja(form) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'warning',
            title: '¿Anular esta baja?',
            text: 'El equipo volverá a EN_INVENTARIO. Esta acción no se puede deshacer.',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, anular',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then(r => { if (r.isConfirmed) form.submit(); });
    } else if (confirm('¿Anular esta baja? El equipo volverá a EN_INVENTARIO.')) {
        form.submit();
    }
}
</script>

@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-xl-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h5 class="mb-1 fw-bold">
                                <i class="bi bi-archive me-2 text-success"></i>
                                DETALLE DE BAJA ADMINISTRATIVA
                            </h5>
                            <small class="text-muted">
                                Registro #{{ $baja->id }}
                            </small>
                        </div>

                        <span class="badge bg-danger fs-6">DE_BAJA</span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="alert alert-warning">
                        Este registro documenta la salida administrativa del equipo.
                        El equipo permanece guardado en el inventario histórico.
                    </div>

                    <h6 class="fw-bold mb-3">INFORMACIÓN DEL EQUIPO</h6>

                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <small class="text-muted d-block">Identificador</small>
                            <strong>ID: {{ $baja->equipo_id }}</strong>
                        </div>

                        <div class="col-12 col-md-6">
                            <small class="text-muted d-block">Tipo de equipo</small>
                            <strong>{{ $baja->equipo->tipoEquipo->nombre ?? 'SIN TIPO' }}</strong>
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
                            <strong>{{ $baja->equipo->num_serie ?: 'NO REGISTRADO' }}</strong>
                        </div>

                        <div class="col-12 col-md-6">
                            <small class="text-muted d-block">Ubicación registrada</small>
                            <strong>
                                {{ $baja->equipo->ubicacione->nombre ?? 'NO REGISTRADA' }}
                            </strong>
                        </div>

                        <div class="col-12 col-md-6">
                            <small class="text-muted d-block">Situación administrativa</small>
                            <strong>{{ $baja->equipo->situacion_administrativa }}</strong>
                        </div>
                    </div>

                    <hr>

                    <h6 class="fw-bold mb-3">DATOS DE LA SALIDA</h6>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <small class="text-muted d-block">Fecha</small>
                            <strong>
                                {{ $baja->fecha ? \Illuminate\Support\Carbon::parse($baja->fecha)->format('d/m/Y') : '—' }}
                            </strong>
                        </div>

                        <div class="col-12 col-md-6">
                            <small class="text-muted d-block">Destino</small>
                            <strong>{{ $baja->destino }}</strong>
                        </div>

                        <div class="col-12 col-md-6">
                            <small class="text-muted d-block">Quién entrega</small>
                            <strong>{{ $baja->quien_entrego }}</strong>
                        </div>

                        <div class="col-12 col-md-6">
                            <small class="text-muted d-block">Quién recibe</small>
                            <strong>{{ $baja->quien_recibio }}</strong>
                        </div>

                        <div class="col-12">
                            <small class="text-muted d-block">Observaciones</small>
                            <div class="border rounded p-3 bg-light">
                                {{ $baja->observaciones ?: 'Sin observaciones.' }}
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-end gap-2 flex-wrap">
                        <a href="{{ route('bajas-equipos.index') }}"
                           class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>
                            VOLVER
                        </a>
                        <a href="{{ route('bajas-equipos.edit', $baja->id) }}"
                           class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i>
                            EDITAR
                        </a>
                        <form action="{{ route('bajas-equipos.destroy', $baja->id) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                    class="btn btn-danger"
                                    onclick="confirmarAnularBaja(this.closest('form'))">
                                <i class="bi bi-trash me-1"></i>
                                ANULAR BAJA
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmarAnularBaja(form) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'warning',
            title: '¿Anular esta baja?',
            text: 'El equipo volverá a EN_INVENTARIO. Esta acción no se puede deshacer.',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, anular',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then(r => { if (r.isConfirmed) form.submit(); });
    } else if (confirm('¿Anular esta baja? El equipo volverá a EN_INVENTARIO.')) {
        form.submit();
    }
}
</script>

@endsection