@extends('layouts.app')

@section('template_title')
    Docentes
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('SOLICITANTES | DOCENTES') }}
                            </span>
                            <div class="float-right">
                                <a href="{{ route('docentes.create') }}" class="btn btn-primary btn-sm float-right">
                                    {{ __('Registrar Nuevo') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-hover" style="width:100%">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th class="text-center">Nombres</th>
                                        <th class="text-center">Apellidos</th>
                                        <th class="text-center">Cargo</th>
                                        <th class="text-center">DNI</th>
                                        <th class="text-center">Correo</th>
                                        <th class="text-center">Celular</th>
                                        <th class="text-center columna-acciones">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($docentes as $i => $docente)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $docente->nombres }}</td>
                                            <td>{{ $docente->apellidos }}</td>
                                            <td>{{ $docente->cargo }}</td>
                                            <td class="text-center">{{ $docente->dni ?? '-' }}</td>
                                            <td>{{ $docente->correo ?? '-' }}</td>
                                            <td class="text-center">{{ $docente->celular ?? '-' }}</td>
                                            <td class="text-center columna-acciones">
                                                <div class="d-flex justify-content-center align-items-center gap-1">
                                                    <form action="{{ route('docentes.destroy', $docente->id) }}" method="POST">
                                                        <a class="btn btn-info btn-accion" href="{{ route('docentes.show', $docente->id) }}">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        <a class="btn btn-warning btn-accion" href="{{ route('docentes.edit', $docente->id) }}">
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
</style>
