@extends('layouts.app')

@section('template_title')
    Préstamos
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">

            <div class="col-sm-12">

                <div class="card">

                    {{-- ENCABEZADO --}}
                    <div class="card-header">

                        <div
                            style="
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                            "
                        >

                            <span id="card_title">
                                {{ __('Préstamos') }}
                            </span>

                            <div class="float-right">

                                <a
                                    href="{{ route('prestamos.create') }}"
                                    class="btn btn-primary btn-sm"
                                >
                                    <i class="fa fa-plus"></i>
                                    {{ __('Nuevo Préstamo') }}
                                </a>

                            </div>

                        </div>

                    </div>


                    {{-- MENSAJE --}}
                    @if ($message = Session::get('success'))

                        <div class="alert alert-success m-4">

                            <p class="mb-0">
                                {{ $message }}
                            </p>

                        </div>

                    @endif


                    {{-- TABLA --}}
                    <div class="card-body bg-white">

                        <div class="table-responsive">

                            <table
                                class="table table-striped table-hover align-middle"
                            >

                                <thead class="thead">

                                    <tr>

                                        <th>
                                            No
                                        </th>

                                        <th>
                                            APELLIDOS Y NOMBRES
                                        </th>

                                        <th>
                                            CARGO
                                        </th>

                                        <th>
                                            EQUIPO / EQUIPOS
                                        </th>

                                        <th>
                                            FECHA
                                        </th>

                                        <th>
                                            HORA INICIO
                                        </th>

                                        <th>
                                            HORA FINAL
                                        </th>

                                        <th>
                                            ESTADO
                                        </th>

                                        <th>
                                            OBSERVACIONES
                                        </th>

                                        <th>
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse ($prestamos as $prestamo)

                                        <tr>

                                            {{-- NÚMERO --}}
                                            <td>
                                                {{ ++$i }}
                                            </td>


                                            {{-- DOCENTE --}}
                                            <td>

                                                {{ $prestamo->docente->apellidos ?? '' }}
                                                {{ $prestamo->docente->nombres ?? '' }}

                                            </td>


                                            {{-- CARGO --}}
                                            <td>

                                                {{ $prestamo->cargo }}

                                            </td>


                                            {{-- EQUIPOS --}}
                                            <td>

                                                @foreach ($prestamo->prestamoEquipos as $prestamoEquipo)

                                                    <div class="mb-2">

                                                        <strong>
                                                            {{ $prestamoEquipo->equipo->tipoEquipo->nombre ?? 'Sin tipo' }}
                                                        </strong>

                                                        <br>

                                                        {{ $prestamoEquipo->equipo->marca ?? '' }}
                                                        {{ $prestamoEquipo->equipo->modelo ?? '' }}

                                                        <br>

                                                        <small class="text-muted">

                                                            N/S:
                                                            {{ $prestamoEquipo->equipo->num_serie ?? 'Sin número de serie' }}

                                                        </small>

                                                    </div>

                                                @endforeach

                                            </td>


                                            {{-- FECHA --}}
                                            <td>

                                                {{ $prestamo->fecha
                                                    ? $prestamo->fecha->format('d-m-Y')
                                                    : ''
                                                }}

                                            </td>


                                            {{-- HORA INICIO --}}
                                            <td>

                                                {{ $prestamo->hora_inicio
                                                    ? substr($prestamo->hora_inicio, 0, 5)
                                                    : ''
                                                }}

                                            </td>


                                            {{-- HORA FINAL --}}
                                            <td>

                                                @if ($prestamo->hora_fin)

                                                    {{ substr($prestamo->hora_fin, 0, 5) }}

                                                @else

                                                    <span class="text-muted">
                                                        —
                                                    </span>

                                                @endif

                                            </td>


                                            {{-- ESTADO --}}
                                            <td>

                                                @if ($prestamo->estado === 'ACTIVO')

                                                    <span class="badge bg-success">
                                                        ACTIVO
                                                    </span>

                                                @else

                                                    <span class="badge bg-secondary">
                                                        TERMINADO
                                                    </span>

                                                @endif

                                            </td>


                                            {{-- OBSERVACIONES --}}
                                            <td>

                                                @foreach ($prestamo->prestamoEquipos as $prestamoEquipo)

                                                    @if ($prestamoEquipo->observacion)

                                                        <div class="mb-2">

                                                            <strong>
                                                                {{ $prestamoEquipo->equipo->marca ?? '' }}
                                                                {{ $prestamoEquipo->equipo->modelo ?? '' }}:
                                                            </strong>

                                                            {{ $prestamoEquipo->observacion }}

                                                        </div>

                                                    @endif


                                                    {{-- OBSERVACIONES DE ACCESORIOS --}}
                                                    @foreach ($prestamoEquipo->prestamoAccesorios as $prestamoAccesorio)

                                                        @if ($prestamoAccesorio->observacion)

                                                            <div class="mb-2">

                                                                <small>

                                                                    Accesorio:
                                                                    {{ $prestamoAccesorio->accesorioEquipo->tipo ?? '' }}

                                                                    —
                                                                    {{ $prestamoAccesorio->observacion }}

                                                                </small>

                                                            </div>

                                                        @endif

                                                    @endforeach

                                                @endforeach

                                            </td>


                                            {{-- ACCIONES --}}
                                            <td>

                                                <form
                                                    action="{{ route('prestamos.destroy', $prestamo->id) }}"
                                                    method="POST"
                                                >

                                                    <a
                                                        class="btn btn-sm btn-primary"
                                                        href="{{ route('prestamos.show', $prestamo->id) }}"
                                                    >
                                                        <i class="fa fa-fw fa-eye"></i>
                                                        Ver
                                                    </a>


                                                    <a
                                                        class="btn btn-sm btn-success"
                                                        href="{{ route('prestamos.edit', $prestamo->id) }}"
                                                    >
                                                        <i class="fa fa-fw fa-edit"></i>
                                                        Editar
                                                    </a>


                                                    @csrf
                                                    @method('DELETE')


                                                    <button
                                                        type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="
                                                            event.preventDefault();
                                                            confirm('¿Está seguro de eliminar este préstamo?')
                                                            ? this.closest('form').submit()
                                                            : false;
                                                        "
                                                    >

                                                        <i class="fa fa-fw fa-trash"></i>
                                                        Eliminar

                                                    </button>

                                                </form>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td
                                                colspan="10"
                                                class="text-center text-muted py-4"
                                            >
                                                No hay préstamos registrados.

                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>


                {{-- PAGINACIÓN --}}
                <div class="mt-3">

                    {!! $prestamos->withQueryString()->links() !!}

                </div>

            </div>

        </div>

    </div>
@endsection