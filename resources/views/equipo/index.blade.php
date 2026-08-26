@extends('layouts.app')

@section('template_title')
    Equipos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Equipos') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('equipos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Registrar Nuevo') }}
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
                                        
									<th >Tipo de Equipo</th>
									<th >Marca</th>
									<th >Modelo</th>
									<th >Num Serie</th>
									<th >Codigo Inventario</th>
									<th >Estado</th>
									<th >Ubicacion</th>
									<th >Fecha Registro</th>
									<th >Observacion</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($equipos as $equipo)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $equipo->tipoEquipo->nombre}}</td>
										<td >{{ $equipo->marca }}</td>
										<td >{{ $equipo->modelo }}</td>
										<td >{{ $equipo->num_serie }}</td>
										<td >{{ $equipo->codigo_inventario }}</td>
										<td >{{ $equipo->estado }}</td>
										<td >{{ $equipo->ubicacione->nombre}}</td>
										<td >{{ $equipo->fecha_registro }}</td>
										<td >{{ $equipo->observacion }}</td>

                                            <td>
                                                <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('equipos.show', $equipo->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('equipos.edit', $equipo->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de eliminar?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $equipos->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
