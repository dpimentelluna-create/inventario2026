@extends('layouts.app')

@section('template_title')
    Bajas administrativas
@endsection

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



@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h5 class="mb-1 fw-bold">
                                <i class="bi bi-archive me-2 text-success"></i>
                                BAJAS ADMINISTRATIVAS
                            </h5>
                            <small class="text-muted">
                                Historial de equipos retirados del inventario institucional.
                            </small>
                        </div>

                        <a href="{{ route('bajas-equipos.create') }}"
                           class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i>
                            REGISTRAR BAJA
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show"
                             role="alert">
                            {{ session('success') }}
                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="Cerrar"></button>
                        </div>
                    @endif

                    @if ($bajas->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-inbox display-4 text-muted"></i>
                            <h6 class="mt-3 fw-bold">NO HAY BAJAS REGISTRADAS</h6>
                            <p class="text-muted mb-0">
                                Cuando registres una baja administrativa, aparecerá aquí.
                            </p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>FECHA</th>
                                        <th>EQUIPO</th>
                                        <th>DESTINO</th>
                                        <th>QUIÉN ENTREGA</th>
                                        <th>QUIÉN RECIBE</th>
                                        <th class="text-center">ACCIONES</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($bajas as $baja)
                                        <tr>
                                            <td>{{ $baja->id }}</td>
                                            <td>
                                                {{ $baja->fecha ? \Illuminate\Support\Carbon::parse($baja->fecha)->format('d/m/Y') : '—' }}
                                            </td>
                                            <td>
                                                <div class="fw-semibold">
                                                    {{ $baja->equipo->tipoEquipo->nombre ?? 'SIN TIPO' }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ $baja->equipo->marca ?? '' }}
                                                    {{ $baja->equipo->modelo ?? '' }}
                                                    · ID {{ $baja->equipo_id }}
                                                </small>
                                                @if ($baja->equipo?->num_serie)
                                                    <small class="d-block text-muted">
                                                        Serie: {{ $baja->equipo->num_serie }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td>{{ $baja->destino }}</td>
                                            <td>{{ $baja->quien_entrego }}</td>
                                            <td>{{ $baja->quien_recibio }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1 flex-wrap">
                                                    <a href="{{ route('bajas-equipos.show', $baja->id) }}"
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="Ver detalle">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('bajas-equipos.edit', $baja->id) }}"
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('bajas-equipos.destroy', $baja->id) }}"
                                                          method="POST"
                                                          class="d-inline"
                                                          onsubmit="return false;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-danger"
                                                                title="Anular baja"
                                                                onclick="confirmarAnularBaja(this.closest('form'))">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $bajas->links() }}
                        </div>
                    @endif
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