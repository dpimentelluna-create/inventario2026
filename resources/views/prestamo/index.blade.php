@extends('layouts.app')

@section('template_title')
    Prestamos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Prestamos') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('prestamos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
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
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
									<th >Equipo Id</th>
									<th >Docente Id</th>
									<th >Ubicacion Destino Id</th>
									<th >Fecha Entrega</th>
									<th >Fecha Devolucion Prevista</th>
									<th >Fecha Devolucion Real</th>
									<th >Estado</th>
									<th >Observacion</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prestamos as $prestamo)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $prestamo->equipo_id }}</td>
										<td >{{ $prestamo->docente_id }}</td>
										<td >{{ $prestamo->ubicacion_destino_id }}</td>
										<td >{{ $prestamo->fecha_entrega }}</td>
										<td >{{ $prestamo->fecha_devolucion_prevista }}</td>
										<td >{{ $prestamo->fecha_devolucion_real }}</td>
										<td >{{ $prestamo->estado }}</td>
										<td >{{ $prestamo->observacion }}</td>

                                            <td>
                                                <form action="{{ route('prestamos.destroy', $prestamo->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('prestamos.show', $prestamo->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('prestamos.edit', $prestamo->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $prestamos->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
