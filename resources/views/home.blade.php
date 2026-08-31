@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- TÍTULO --}}
    <div class="mb-4">
        <h2 class="fw-bold">Dashboard de Inventario</h2>
        <p class="text-muted">
            Resumen general de los equipos registrados
        </p>
    </div>


    {{-- ========================= --}}
    {{-- TARJETAS PRINCIPALES --}}
    {{-- ========================= --}}

    <div class="row">

        {{-- TOTAL --}}
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total de Equipos</h6>
                    <h2 class="fw-bold">
                        {{ $totalEquipos }}
                    </h2>
                </div>
            </div>
        </div>


        {{-- BUENOS --}}
<div class="col-md-3 mb-3">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h6 class="text-muted">Buenos</h6>
            <h2 class="fw-bold text-success">
                {{ $buenos }}
            </h2>
        </div>
    </div>
</div>

        {{-- REGULARES --}}
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Regulares</h6>
                    <h2 class="fw-bold text-warning">
                        {{ $regulares }}
                    </h2>
                </div>
            </div>
        </div>


        {{-- MALOGRADOS --}}
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Malogrados</h6>
                    <h2 class="fw-bold text-danger">
                        {{ $malogrados }}
                    </h2>
                </div>
            </div>
        </div>

    </div>


    {{-- ========================= --}}
    {{-- EQUIPOS POR TIPO --}}
    {{-- ========================= --}}

    <div class="row mt-2">

        <div class="col-md-7 mb-3">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        Equipos por Tipo
                    </h5>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover">

                            <thead>
                                <tr>
                                    <th>Tipo de Equipo</th>
                                    <th class="text-center">Cantidad</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($equiposPorTipo as $tipo)

                                    <tr>

                                        <td>
                                            {{ $tipo->nombre }}
                                        </td>

                                        <td class="text-center">
                                            <span class="badge bg-primary">
                                                {{ $tipo->equipos_count }}
                                            </span>
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================= --}}
        {{-- EQUIPOS POR UBICACIÓN --}}
        {{-- ========================= --}}

        <div class="col-md-5 mb-3">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        Equipos por Ubicación
                    </h5>
                </div>

                <div class="card-body">

                    @foreach($equiposPorUbicacion as $ubicacion)

                        <div class="d-flex justify-content-between
                                    align-items-center mb-3">

                            <span>
                                {{ $ubicacion->nombre }}
                            </span>

                            <span class="badge bg-secondary">
                                {{ $ubicacion->equipos_count }}
                            </span>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>


    {{-- ========================= --}}
    {{-- ÚLTIMOS EQUIPOS --}}
    {{-- ========================= --}}

    <div class="row mt-2">

        <div class="col-md-12">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Últimos Equipos Registrados
                    </h5>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover">

                            <thead>

                                <tr>
                                    <th>Tipo</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>N.º Serie</th>
                                    <th>Ubicación</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                </tr>

                            </thead>

                            <tbody>

                                @forelse($ultimosEquipos as $equipo)

                                    <tr>

                                        <td>
                                            {{ $equipo->tipoEquipo->nombre ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $equipo->marca }}
                                        </td>

                                        <td>
                                            {{ $equipo->modelo ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $equipo->num_serie ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $equipo->ubicacione->nombre ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $equipo->estado }}
                                        </td>

                                        <td>
                                            {{ $equipo->created_at ? $equipo->created_at->format('d/m/Y') : '-' }}
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="7"
                                            class="text-center text-muted">
                                            No hay equipos registrados.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>


</div>

@endsection