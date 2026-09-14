@extends('layouts.app')

@section('template_title')
    Ubicaciones
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('UBICACIONES') }}
                            </span>
                            <div class="float-right">
                                <a href="{{ route('ubicaciones.create') }}" class="btn btn-primary btn-sm float-right">
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
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Tipo</th>
                                        <th class="text-center columna-acciones">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ubicaciones as $i => $ubicacione)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $ubicacione->nombre }}</td>
                                            <td>{{ $ubicacione->tipo ?? '-' }}</td>
                                            <td class="text-center columna-acciones">
                                                <div class="d-flex justify-content-center align-items-center gap-1">
                                                    <form action="{{ route('ubicaciones.destroy', $ubicacione->id) }}" method="POST">
                                                        <a class="btn btn-info btn-accion" href="{{ route('ubicaciones.show', $ubicacione->id) }}">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        <a class="btn btn-warning btn-accion" href="{{ route('ubicaciones.edit', $ubicacione->id) }}">
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
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length {
            text-align: left !important;
            margin-bottom: 10px;
        }

        #example_wrapper {
            overflow-x: auto;
        }
    }
</style>
