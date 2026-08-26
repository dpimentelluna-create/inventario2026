@extends('layouts.app')

@section('template_title')
    Accesorios Equipos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Accesorios Equipos') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('accesorios-equipo.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                            <table id = "example" class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
									<th >Equipo</th>
									<th >Tipo</th>
									<th >Marca</th>
									<th >Num Serie</th>
									<th >Estado</th>
                                    <th >Observaciones</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accesoriosEquipos as $accesoriosEquipo)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $accesoriosEquipo->equipo->num_serie }}</td>
										<td >{{ $accesoriosEquipo->tipo }}</td>
										<td >{{ $accesoriosEquipo->marca }}</td>
										<td >{{ $accesoriosEquipo->num_serie }}</td>
										<td >{{ $accesoriosEquipo->estado }}</td>
                                        <td >{{ $accesoriosEquipo->observaciones }}</td>

                                            <td>
                                                <form action="{{ route('accesorios-equipo.destroy', $accesoriosEquipo->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('accesorios-equipo.show', $accesoriosEquipo->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('accesorios-equipo.edit', $accesoriosEquipo->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
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
                {!! $accesoriosEquipos->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
