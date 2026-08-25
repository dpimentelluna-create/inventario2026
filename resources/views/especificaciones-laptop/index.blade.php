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
                            <table class="table table-striped table-hover">
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
                                                    <a class="btn btn-sm btn-primary " href="{{ route('especificaciones-laptop.show', $especificacionesLaptop->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('especificaciones-laptop.edit', $especificacionesLaptop->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $especificacionesLaptops->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
