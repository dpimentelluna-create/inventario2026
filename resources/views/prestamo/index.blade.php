@extends('layouts.app')

@section('template_title')
    Préstamos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                            <span id="card_title">{{ __('PRÉSTAMOS') }}</span>
                            <a href="{{ route('prestamos.create') }}" class="btn btn-primary btn-sm">
                                {{ __('Registrar Nuevo') }}
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-hover" style="width:100%">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th class="text-center">Solicitante</th>
                                        <th class="text-center">Cargo</th>
                                        <th class="text-center">Equipos</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Hora inicio</th>
                                        <th class="text-center">Hora final</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center columna-acciones">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prestamos as $i => $prestamo)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>
                                                {{ $prestamo->docente->apellidos ?? '' }}
                                                {{ $prestamo->docente->nombres ?? '' }}
                                            </td>
                                            <td>{{ $prestamo->cargo }}</td>
                                            <td>
                                                @forelse ($prestamo->prestamoEquipos as $prestamoEquipo)
                                                    <div class="mb-1">
                                                        {{ $prestamoEquipo->equipo->tipoEquipo->nombre ?? '' }}
                                                        {{ $prestamoEquipo->equipo->marca ?? '' }}
                                                        <small class="text-muted">
                                                            N/S {{ $prestamoEquipo->equipo->num_serie ?? '-' }}
                                                        </small>
                                                    </div>
                                                @empty
                                                    —
                                                @endforelse
                                            </td>
                                            <td class="text-center">
                                                {{ $prestamo->fecha ? \Carbon\Carbon::parse($prestamo->fecha)->format('d-m-Y') : '-' }}
                                            </td>
                                            <td class="text-center">
                                                {{ $prestamo->hora_inicio ? substr($prestamo->hora_inicio, 0, 5) : '-' }}
                                            </td>
                                            <td class="text-center">
                                                {{ $prestamo->hora_fin ? substr($prestamo->hora_fin, 0, 5) : '—' }}
                                            </td>
                                            <td class="text-center">
                                                @if ($prestamo->estado === 'ACTIVO')
                                                    <span class="badge bg-success">ACTIVO</span>
                                                @else
                                                    <span class="badge bg-secondary">TERMINADO</span>
                                                @endif
                                            </td>
                                            <td class="text-center columna-acciones">
                                                <div class="d-flex justify-content-center align-items-center gap-1">
                                                    <form action="{{ route('prestamos.destroy', $prestamo->id) }}" method="POST">
                                                        <a class="btn btn-info btn-accion" href="{{ route('prestamos.show', $prestamo->id) }}">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        <a class="btn btn-warning btn-accion" href="{{ route('prestamos.edit', $prestamo->id) }}">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-accion"
                                                            onclick="event.preventDefault(); confirmarEliminar(this.closest('form'));">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    #example {
        border-collapse: collapse !important;
        width: 100%;
    }
    #example thead th {
        background-color: #5fe65f !important;
        color: #000000 !important;
        text-align: center !important;
        vertical-align: middle !important;
        font-weight: bold;
    }
    #example tbody td {
        vertical-align: middle !important;
    }
    #example tbody tr:hover {
        background-color: #f2f2f2 !important;
    }
    @media (max-width: 768px) {
        #example_wrapper {
            overflow-x: auto;
        }
    }
</style>
