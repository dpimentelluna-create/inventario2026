@extends('layouts.app')

@section('template_title')
    {{ __('Ver Préstamo') }}
@endsection

@section('content')

    <section class="content container-fluid">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    {{-- ENCABEZADO --}}
                    <div class="card-header" style="
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                        ">

                        <div>
                            <span class="card-title">
                                {{ __('Detalle del Préstamo') }}
                            </span>
                        </div>

                        <div>

                            <a class="btn btn-primary btn-sm" href="{{ route('prestamos.index') }}">
                                <i class="fa fa-arrow-left"></i>
                                Volver
                            </a>

                            <a class="btn btn-success btn-sm" href="{{ route('prestamos.edit', $prestamo->id) }}">
                                <i class="fa fa-edit"></i>
                                Editar
                            </a>

                            <button type="button" class="btn btn-secondary btn-sm" onclick="window.print()">
                                <i class="fa fa-print"></i>
                                Imprimir
                            </button>

                        </div>

                    </div>


                    <div class="card-body bg-white">

                        {{-- ========================================== --}}
                        {{-- INFORMACIÓN DEL PRÉSTAMO --}}
                        {{-- ========================================== --}}

                        <div class="card mb-4">

                            <div class="card-header">
                                <strong>
                                    Información del préstamo
                                </strong>
                            </div>

                            <div class="card-body">

                                <div class="row">

                                    {{-- DOCENTE --}}
                                    <div class="col-md-6 mb-3">

                                        <strong>
                                            Apellidos y nombres:
                                        </strong>

                                        <br>

                                        {{ $prestamo->docente->apellidos ?? '' }}
                                        {{ $prestamo->docente->nombres ?? '' }}

                                    </div>


                                    {{-- CARGO --}}
                                    <div class="col-md-6 mb-3">

                                        <strong>
                                            Cargo:
                                        </strong>

                                        <br>

                                        {{ $prestamo->cargo }}

                                    </div>


                                    {{-- FECHA --}}
                                    <div class="col-md-4 mb-3">

                                        <strong>
                                            Fecha:
                                        </strong>

                                        <br>

                                        {{ $prestamo->fecha
        ? $prestamo->fecha->format('d-m-Y')
        : ''
                                        }}

                                    </div>


                                    {{-- HORA INICIO --}}
                                    <div class="col-md-4 mb-3">

                                        <strong>
                                            Hora de inicio:
                                        </strong>

                                        <br>

                                        {{ $prestamo->hora_inicio
        ? substr($prestamo->hora_inicio, 0, 5)
        : ''
                                        }}

                                    </div>


                                    {{-- HORA FINAL --}}
                                    <div class="col-md-4 mb-3">

                                        <strong>
                                            Hora final:
                                        </strong>

                                        <br>

                                        @if ($prestamo->hora_fin)

                                            {{ substr($prestamo->hora_fin, 0, 5) }}

                                        @else

                                            <span class="text-muted">
                                                —
                                            </span>

                                        @endif

                                    </div>


                                    {{-- ESTADO --}}
                                    <div class="col-md-12">

                                        <strong>
                                            Estado:
                                        </strong>

                                        <br>

                                        @if ($prestamo->estado === 'ACTIVO')

                                            <span class="badge bg-success">
                                                ACTIVO
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                TERMINADO
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- ========================================== --}}
                        {{-- EQUIPOS --}}
                        {{-- ========================================== --}}

                        <h4 class="mb-3">
                            Equipos del préstamo
                        </h4>


                        @forelse ($prestamo->prestamoEquipos as $indice => $prestamoEquipo)

                            <div class="card mb-4">

                                {{-- CABECERA DEL EQUIPO --}}
                                <div class="card-header">

                                    <strong>
                                        EQUIPO {{ $indice + 1 }}
                                    </strong>

                                </div>


                                <div class="card-body">

                                    <div class="row">

                                        {{-- TIPO --}}
                                        <div class="col-md-6 mb-3">

                                            <strong>
                                                Tipo de equipo:
                                            </strong>

                                            <br>

                                            {{ $prestamoEquipo->equipo->tipoEquipo->nombre ?? 'Sin tipo' }}

                                        </div>


                                        {{-- MARCA --}}
                                        <div class="col-md-6 mb-3">

                                            <strong>
                                                Marca:
                                            </strong>

                                            <br>

                                            {{ $prestamoEquipo->equipo->marca ?? '' }}

                                        </div>


                                        {{-- MODELO --}}
                                        <div class="col-md-6 mb-3">

                                            <strong>
                                                Modelo:
                                            </strong>

                                            <br>

                                            {{ $prestamoEquipo->equipo->modelo ?? '—' }}

                                        </div>


                                        {{-- NÚMERO DE SERIE --}}
                                        <div class="col-md-6 mb-3">

                                            <strong>
                                                Número de serie:
                                            </strong>

                                            <br>

                                            {{ $prestamoEquipo->equipo->num_serie ?? '—' }}

                                        </div>


                                        {{-- ESTADO DEL EQUIPO --}}
                                        <div class="col-md-6 mb-3">

                                            <strong>
                                                Estado del equipo:
                                            </strong>

                                            <br>

                                            @if ($prestamoEquipo->estado === 'BUENO')

                                                <span class="badge bg-success">
                                                    BUENO
                                                </span>

                                            @elseif ($prestamoEquipo->estado === 'REGULAR')

                                                <span class="badge bg-warning text-dark">
                                                    REGULAR
                                                </span>

                                            @else

                                                <span class="badge bg-danger">
                                                    MALOGRADO
                                                </span>

                                            @endif

                                        </div>


                                        {{-- OBSERVACIÓN DEL EQUIPO --}}
                                        <div class="col-md-12 mb-3">

                                            <strong>
                                                Observación del equipo:
                                            </strong>

                                            <br>

                                            @if ($prestamoEquipo->observacion)

                                                {{ $prestamoEquipo->observacion }}

                                            @else

                                                <span class="text-muted">
                                                    Sin observaciones
                                                </span>

                                            @endif

                                        </div>

                                    </div>


                                    {{-- ================================= --}}
                                    {{-- ACCESORIOS --}}
                                    {{-- ================================= --}}

                                    @if ($prestamoEquipo->prestamoAccesorios->count())

                                        <hr>

                                        <h5 class="mb-3">
                                            Accesorios
                                        </h5>


                                        <div class="table-responsive">

                                            <table class="table table-bordered">

                                                <thead>

                                                    <tr>

                                                        <th>
                                                            Tipo
                                                        </th>

                                                        <th>
                                                            Marca
                                                        </th>

                                                        <th>
                                                            Número de serie
                                                        </th>

                                                        <th>
                                                            Estado
                                                        </th>

                                                        <th>
                                                            Observación
                                                        </th>

                                                    </tr>

                                                </thead>


                                                <tbody>

                                                    @foreach (
                                                                                    $prestamoEquipo->prestamoAccesorios
                                                                                    as $prestamoAccesorio
                                                                                )

                                                                                <tr>

                                                                                    {{-- TIPO --}}
                                                                                    <td>

                                                                                        {{
                                                        $prestamoAccesorio
                                                            ->accesorioEquipo
                                                            ->tipo
                                                        ?? '—'
                                                                                                    }}

                                                                                    </td>


                                                                                    {{-- MARCA --}}
                                                                                    <td>

                                                                                        {{
                                                        $prestamoAccesorio
                                                            ->accesorioEquipo
                                                            ->marca
                                                        ?? '—'
                                                                                                    }}

                                                                                    </td>


                                                                                    {{-- SERIE --}}
                                                                                    <td>

                                                                                        {{
                                                        $prestamoAccesorio
                                                            ->accesorioEquipo
                                                            ->num_serie
                                                        ?? '—'
                                                                                                    }}

                                                                                    </td>


                                                                                    {{-- ESTADO --}}
                                                                                    <td>

                                                                                        @if (
                                                                                                $prestamoAccesorio->estado
                                                                                                === 'BUENO'
                                                                                            )

                                                                                            <span class="badge bg-success">
                                                                                                BUENO
                                                                                            </span>

                                                                                        @elseif (
                                                                                                $prestamoAccesorio->estado
                                                                                                === 'REGULAR'
                                                                                            )

                                                                                            <span class="badge bg-warning text-dark">
                                                                                                REGULAR
                                                                                            </span>

                                                                                        @else

                                                                                            <span class="badge bg-danger">
                                                                                                MALOGRADO
                                                                                            </span>

                                                                                        @endif

                                                                                    </td>


                                                                                    {{-- OBSERVACIÓN --}}
                                                                                    <td>

                                                                                        {{
                                                        $prestamoAccesorio
                                                            ->observacion
                                                        ?: 'Sin observaciones'
                                                                                                    }}

                                                                                    </td>

                                                                                </tr>

                                                    @endforeach

                                                </tbody>

                                            </table>

                                        </div>

                                    @else

                                        <div class="text-muted">

                                            Este equipo no tiene accesorios registrados en el préstamo.

                                        </div>

                                    @endif

                                </div>

                            </div>

                        @empty

                            <div class="alert alert-warning">

                                No hay equipos asociados a este préstamo.

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- ========================================== --}}
    {{-- ESTILOS PARA IMPRESIÓN --}}
    {{-- ========================================== --}}

    <style>
        @media print {

            .btn,
            .navbar,
            .sidebar,
            .main-footer,
            footer {
                display: none !important;
            }

            .card {
                border: 1px solid #000 !important;
                box-shadow: none !important;
            }

            body {
                background: white !important;
            }

        }
    </style>

@endsection