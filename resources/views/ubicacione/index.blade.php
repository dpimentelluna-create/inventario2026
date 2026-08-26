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
                                {{ __('Ubicaciones') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('ubicaciones.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
									<th >Nombre</th>
									<th >Tipo</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ubicaciones as $ubicacione)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $ubicacione->nombre }}</td>
										<td >{{ $ubicacione->tipo }}</td>

                                            <td>
                                                <form action="{{ route('ubicaciones.destroy', $ubicacione->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('ubicaciones.show', $ubicacione->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('ubicaciones.edit', $ubicacione->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
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
                {!! $ubicaciones->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
