@extends('layouts.app')

@section('template_title')
    Usuarios
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('USUARIOS DEL SISTEMA') }}
                            </span>
                            <div class="float-right">
                                <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm float-right">
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
                                        <th class="text-center">Correo</th>
                                        <th class="text-center">Rol</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center columna-acciones">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usuarios as $i => $usuario)
                                        @php $esUnoMismo = $usuario->is(auth()->user()); @endphp
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $usuario->name }}@if ($esUnoMismo) <span class="text-muted">(tú)</span>@endif</td>
                                            <td>{{ $usuario->email }}</td>
                                            <td class="text-center">
                                                @php
                                                    $claseRol = match ($usuario->rol) {
                                                        \App\Models\User::ROL_ADMINISTRADOR => 'text-bg-dark',
                                                        \App\Models\User::ROL_REGISTRADOR => 'text-bg-primary',
                                                        default => 'text-bg-secondary',
                                                    };
                                                @endphp
                                                <span class="badge {{ $claseRol }}">{{ $usuario->etiquetaRol() }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge {{ $usuario->activo ? 'text-bg-success' : 'text-bg-danger' }}">
                                                    {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </td>
                                            <td class="text-center columna-acciones">
                                                <div class="d-flex justify-content-center align-items-center gap-1">
                                                    <form action="{{ route('usuarios.estado', $usuario->id) }}" method="POST">
                                                        @csrf
                                                        <a class="btn btn-warning btn-accion" href="{{ route('usuarios.edit', $usuario->id) }}"
                                                            title="Editar usuario">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        @if ($usuario->activo)
                                                            <button type="button" class="btn btn-danger btn-accion"
                                                                title="Desactivar usuario" @disabled($esUnoMismo)
                                                                onclick="confirmarCambioEstado(this.closest('form'), false, @js($usuario->name));">
                                                                <i class="fa-solid fa-user-slash"></i>
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-success btn-accion"
                                                                title="Activar usuario"
                                                                onclick="confirmarCambioEstado(this.closest('form'), true, @js($usuario->name));">
                                                                <i class="fa-solid fa-user-check"></i>
                                                            </button>
                                                        @endif
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

    <script>
        function confirmarCambioEstado(form, activar, nombre) {
            const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
            Swal.fire({
                title: activar ? '¿Activar usuario?' : '¿Desactivar usuario?',
                text: activar
                    ? nombre + ' podrá volver a iniciar sesión.'
                    : nombre + ' ya no podrá iniciar sesión. Sus registros se conservan.',
                icon: 'question',
                background: isDark ? '#1e293b' : '#ffffff',
                color: isDark ? '#e2e8f0' : '#334155',
                showCancelButton: true,
                confirmButtonColor: activar ? '#198754' : '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: activar ? 'Sí, activar' : 'Sí, desactivar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
@endsection