@extends('layouts.app')

@section('template_title')
    Especificaciones Laptops
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Especificaciones Laptops') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('especificaciones-laptop.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Crear Nuevo') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table id = "example" class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
									<th >Equipo</th>
									<th >Procesador</th>
									<th >Memoria Ram</th>
									<th >Disco Duro</th>
                                    <th >Estado</th>
                                    <th >Observaciones</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($especificacionesLaptops as $especificacionesLaptop)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $especificacionesLaptop->equipo->num_serie }}</td>
										<td >{{ $especificacionesLaptop->procesador }}</td>
										<td >{{ $especificacionesLaptop->ram }}</td>
										<td >{{ $especificacionesLaptop->disco_duro }}</td>
                                        <td >{{ $especificacionesLaptop->estado }}</td>
                                        <td >{{ $especificacionesLaptop->observaciones }}</td>

                                            <td>
                                                <form action="{{ route('especificaciones-laptop.destroy', $especificacionesLaptop->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('especificaciones-laptop.show', $especificacionesLaptop->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('especificaciones-laptop.edit', $especificacionesLaptop->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $especificacionesLaptops->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection

<style id="fix-all-tables-dark">
  html.home-dark table.dataTable thead th,
  html.home-dark table thead th,
  body.dark-mode table.dataTable thead th,
  body.dark table.dataTable thead th,
  [data-bs-theme="dark"] table.dataTable thead th,
  [data-theme="dark"] table.dataTable thead th {
    background-color: #1e293b !important;
    color: #f8fafc !important;
    border-color: #334155 !important;
  }

  html.home-dark .dataTables_wrapper .dataTables_length select,
  html.home-dark .dataTables_wrapper .dataTables_filter input,
  body.dark-mode .dataTables_wrapper .dataTables_length select,
  body.dark-mode .dataTables_wrapper .dataTables_filter input,
  [data-bs-theme="dark"] .dataTables_wrapper .dataTables_length select,
  [data-bs-theme="dark"] .dataTables_wrapper .dataTables_filter input {
    background-color: #0f172a !important;
    color: #f8fafc !important;
    border: 1px solid #334155 !important;
  }
</style>