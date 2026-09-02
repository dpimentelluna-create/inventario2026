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
                                <a href="{{ route('equipos.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
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

                    <!-- MODIFICACIONES RESPONSIVE -->
                    <div class="card-body">
                        <div class="table-responsive">

                            <table id="example" class="table table-bordered table-hover" style="width:100%">

                                <!-- MODIFICACIONES ENCABEZADOS -->
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>

                                        <!--CENTRAR LOS ENCABEZADOS CON CLASS-->
                                        <th class="text-center">Tipo de Equipo</th>
                                        <th class="text-center">Num Serie</th>
                                        <th class="text-center">Marca</th>
                                        <th class="text-center">Modelo</th>
                                        <!--<th class = "text-center">Codigo Inventario</th>-->
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Ubicacion</th>
                                        <th class="text-center">Fecha Registro</th>
                                        <th class="text-center">Observacion</th>

                                        <th class="text-center columna-acciones">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($equipos as $i => $equipo)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>

                                            <!--CENTRAR LOS DATOS CON CLASS-->
                                            <td>{{ $equipo->tipoEquipo->nombre ?? '-'}}</td>
                                            <td class="text-center">{{ $equipo->num_serie }}</td>
                                            <td>{{ $equipo->marca }}</td>
                                            <td>{{ $equipo->modelo }}</td>


                                            <td class="text-center">
                                                @if($equipo->especificacionesLaptops)
                                                    {{ $equipo->especificacionesLaptops->estado ?? '-' }}
                                                @elseif($equipo->especificacionesEquipo)
                                                    {{ $equipo->especificacionesEquipo->estado ?? '-' }}
                                                @else
                                                    -
                                                @endif
                                            </td>


                                            <td class="text-center">{{ $equipo->ubicacione->nombre ?? '-'}}</td>
                                            
                                            <!--TD MODIFICADO PARA CAMBAR FORMATO DE FECHAS SIN ALTERAR LA BD -->
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($equipo->fecha_registro)->format('d-m-Y') }}
                                            </td>

                                            <td>
                                                @if($equipo->especificacionesLaptops)
                                                    {{ $equipo->especificacionesLaptops->observaciones ?? '-' }}
                                                @elseif($equipo->especificacionesEquipo)
                                                    {{ $equipo->especificacionesEquipo->observaciones ?? '-' }}
                                                @else
                                                    -
                                                @endif
                                            </td>


                                            <!--EDITAR LOS BOTONES CON CLASS-->
                                            <td class="text-center columna-acciones">
                                                <div div class="d-flex justify-content-center align-items-center gap-1">
                                                    <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST">
                                                        <a class="btn btn-info btn-accion "
                                                            href="{{ route('equipos.show', $equipo->id) }}"><i
                                                                class="fa-solid fa-eye"></i> {{ __('') }}</a>
                                                        <a class="btn btn-warning btn-accion"
                                                            href="{{ route('equipos.edit', $equipo->id) }}"><i
                                                                class="fa-solid fa-pen-to-square"></i> {{ __('') }}</a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-accion"
                                                            onclick="event.preventDefault(); confirm('¿Estás seguro de eliminar?') ? this.closest('form').submit() : false;"><i
                                                                class="fa-solid fa-trash"></i> {{ __('') }}</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                    </div>
                </div>
            </div>
@endsection

        <!--APLICAR DISEÑO A LA TABLA-->
        <style>
            /* TABLA DE EQUIPOS */
            #example {
                border-collapse: collapse !important;
                width: 100%;
            }

            /* Encabezados */
            #example thead th {
                background-color: #90EE90 !important;
                color: #000000 !important;
                text-align: center !important;
                vertical-align: middle !important;
                /*border: 1px solid #000000 !important;*/
                font-weight: bold;
            }

            /* Celdas */
            #example tbody td {
                /*border: 1px solid #000000 !important;*/
                vertical-align: middle !important;
            }

            /* Centrar contenido de la tabla */
            /*#example tbody td {
        text-align: center;
    }*/

            /* Efecto al pasar el mouse */
            #example tbody tr:hover {
                background-color: #f2f2f2 !important;
            }
        </style>