
@extends('layouts.app')

@section('template_title')
    Usuarios
@endsection

@section('content')
<div class="container-fluid usuario-index-container">
    <div class="row">
        <div class="col-12">

            <div class="card usuario-index-card">

                {{-- ENCABEZADO --}}
                <div class="card-header usuario-index-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                        <div class="usuario-index-titulo">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-people-fill usuario-index-icono"></i>

                                <span id="card_title">
                                    USUARIOS DEL SISTEMA
                                </span>
                            </div>

                            <small class="usuario-index-descripcion">
                                Consulta y administra las cuentas de acceso al inventario.
                            </small>
                        </div>

                        <div class="usuario-index-acciones-header">
                            <a href="{{ route('usuarios.create') }}"
                               id="btn_nuevo_usuario"
                               class="btn btn-success btn-nuevo-usuario">
                                <i class="fa-solid fa-plus me-1"></i>
                                Registrar Nuevo
                            </a>
                        </div>

                    </div>
                </div>

                {{-- CONTENIDO --}}
                <div class="card-body usuario-index-body">

                    <div class="table-responsive usuario-tabla-responsive">

                        <table id="example"
                               class="table table-bordered table-hover table-striped align-middle usuario-datatable"
                               style="width: 100%">

                            <thead>
                                <tr>
                                    <th class="columna-numero">N.º</th>
                                    <th>Nombre</th>
                                    <th>Correo electrónico</th>
                                    <th class="text-center">Rol</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center columna-acciones">Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($usuarios as $i => $usuario)
                                    @php
                                        $esUnoMismo = $usuario->is(auth()->user());

                                        $claseRol = match ($usuario->rol) {
                                            \App\Models\User::ROL_ADMINISTRADOR => 'usuario-rol-admin',
                                            \App\Models\User::ROL_REGISTRADOR => 'usuario-rol-registrador',
                                            default => 'usuario-rol-otro',
                                        };
                                    @endphp

                                    <tr>
                                        {{-- NÚMERO --}}
                                        <td class="columna-numero">
                                            {{ $i + 1 }}
                                        </td>

                                        {{-- NOMBRE --}}
                                        <td class="usuario-nombre">
                                            <span class="usuario-nombre-texto">
                                                {{ $usuario->name }}
                                            </span>

                                            @if ($esUnoMismo)
                                                <span class="usuario-etiqueta-propio">
                                                    TÚ
                                                </span>
                                            @endif
                                        </td>

                                        {{-- CORREO --}}
                                        <td class="usuario-correo">
                                            {{ $usuario->email }}
                                        </td>

                                        {{-- ROL --}}
                                        <td class="text-center">
                                            <span class="usuario-badge-rol {{ $claseRol }}">
                                                {{ $usuario->etiquetaRol() }}
                                            </span>
                                        </td>

                                        {{-- ESTADO --}}
                                        <td class="text-center">
                                            <span class="usuario-badge-estado {{ $usuario->activo ? 'usuario-estado-activo' : 'usuario-estado-inactivo' }}">
                                                <span class="usuario-estado-punto"></span>
                                                {{ $usuario->activo ? 'ACTIVO' : 'INACTIVO' }}
                                            </span>
                                        </td>

                                        {{-- ACCIONES --}}
                                        <td class="text-center columna-acciones">
                                            <div class="usuario-grupo-acciones">

                                                {{-- VER --}}
                                                <a href="{{ route('usuarios.show', $usuario->id) }}"
                                                   class="btn btn-info usuario-btn-accion"
                                                   title="Ver usuario"
                                                   aria-label="Ver usuario">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>

                                                {{-- EDITAR --}}
                                                <a href="{{ route('usuarios.edit', $usuario->id) }}"
                                                   class="btn btn-warning usuario-btn-accion"
                                                   title="Editar usuario"
                                                   aria-label="Editar usuario">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>

                                                {{-- ACTIVAR / DESACTIVAR --}}
                                                <form action="{{ route('usuarios.estado', $usuario->id) }}"
                                                      method="POST"
                                                      class="d-inline">
                                                    @csrf

                                                    @if ($usuario->activo)
                                                        <button type="button"
                                                                class="btn btn-danger usuario-btn-accion"
                                                                title="Desactivar usuario"
                                                                aria-label="Desactivar usuario"
                                                                @disabled($esUnoMismo)
                                                                onclick="confirmarCambioEstado(this.closest('form'), false, @js($usuario->name));">
                                                            <i class="fa-solid fa-user-slash"></i>
                                                        </button>
                                                    @else
                                                        <button type="button"
                                                                class="btn btn-success usuario-btn-accion"
                                                                title="Activar usuario"
                                                                aria-label="Activar usuario"
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

{{-- CONFIRMACIÓN DE CAMBIO DE ESTADO --}}
<script>
    function confirmarCambioEstado(form, activar, nombre) {
        const isDark =
            document.documentElement.getAttribute('data-bs-theme') === 'dark';

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

            confirmButtonText: activar
                ? 'Sí, activar'
                : 'Sí, desactivar',

            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            focusCancel: true
        }).then(function (result) {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endsection

{{-- ESTILOS DEL MÓDULO --}}
<style>
    /* =========================================
       CONTENEDOR Y TARJETA
    ========================================= */

    .usuario-index-container {
        padding-bottom: 20px;
    }

    .usuario-index-card {
        background: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    /* =========================================
       ENCABEZADO
    ========================================= */

    .usuario-index-header {
        background: #e9f7e9;
        color: #212529;
        border-bottom: 1px solid #c8e6c9;
        padding: 16px 20px;
    }

    .usuario-index-titulo {
        min-width: 0;
    }

    .usuario-index-titulo > div {
        gap: 10px !important;
    }

    .usuario-index-icono {
        color: #198754;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .usuario-index-header #card_title {
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: 0.25px;
    }

    .usuario-index-descripcion {
        display: block;
        margin-top: 5px;
        margin-left: 2px;
        color: #6c757d;
        font-size: 0.84rem;
        line-height: 1.5;
    }

    .usuario-index-acciones-header {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-nuevo-usuario {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 3px;
        padding: 9px 14px;
        border-radius: 6px;
        font-size: 0.86rem;
        font-weight: 600;
        white-space: nowrap;
        transition: background-color 0.2s ease,
                    box-shadow 0.2s ease;
    }

    .btn-nuevo-usuario:hover {
        box-shadow: 0 2px 5px rgba(25, 135, 84, 0.2);
    }

    /* =========================================
       CUERPO Y TABLA
    ========================================= */

    .usuario-index-body {
        padding: 20px;
    }

    .usuario-tabla-responsive {
        width: 100%;
    }

    .usuario-datatable {
        margin-bottom: 0 !important;
        color: #343a40;
        font-size: 0.88rem;
        vertical-align: middle;
    }

    .usuario-datatable thead th {
        background-color: #f8fafc;
        color: #334155;
        border-color: #e2e8f0;
        font-weight: 700;
        font-size: 0.84rem;
        padding: 12px 10px;
        vertical-align: middle;
        white-space: nowrap;
    }

    .usuario-datatable tbody td {
        padding: 11px 10px;
        border-color: #e9ecef;
        vertical-align: middle;
    }

    .usuario-datatable tbody tr {
        transition: background-color 0.15s ease;
    }

    .usuario-datatable tbody tr:hover > * {
        --bs-table-bg: #f3f9f5;
    }

    .usuario-datatable .columna-numero {
        width: 55px;
        text-align: center;
        color: #64748b;
        font-size: 0.83rem;
    }

    .usuario-nombre {
        min-width: 155px;
        font-weight: 600;
        color: #334155;
    }

    .usuario-nombre-texto {
        overflow-wrap: anywhere;
    }

    .usuario-correo {
        min-width: 190px;
        overflow-wrap: anywhere;
        color: #475569;
    }

    /* =========================================
       INSIGNIAS DE ROL
    ========================================= */

    .usuario-badge-rol {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 0.74rem;
        font-weight: 700;
        line-height: 1.3;
        white-space: nowrap;
    }

    .usuario-rol-admin {
        background: #343a40;
        color: #ffffff;
    }

    .usuario-rol-registrador {
        background: #0d6efd;
        color: #ffffff;
    }

    .usuario-rol-otro {
        background: #6c757d;
        color: #ffffff;
    }

    /* =========================================
       INSIGNIAS DE ESTADO
    ========================================= */

    .usuario-badge-estado {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 0.74rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .usuario-estado-activo {
        background: #d1e7dd;
        color: #146c43;
    }

    .usuario-estado-inactivo {
        background: #f8d7da;
        color: #b02a37;
    }

    .usuario-estado-punto {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
        flex-shrink: 0;
    }

    /* =========================================
       INDICADOR DEL USUARIO ACTUAL
    ========================================= */

    .usuario-etiqueta-propio {
        display: inline-block;
        margin-left: 5px;
        padding: 2px 6px;
        border-radius: 4px;
        background: #e2e8f0;
        color: #475569;
        font-size: 0.66rem;
        font-weight: 700;
        vertical-align: middle;
    }

    /* =========================================
       BOTONES DE ACCIÓN
    ========================================= */

    .usuario-grupo-acciones {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .usuario-grupo-acciones form {
        margin: 0;
    }

    .usuario-btn-accion {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
        padding: 0;
        border: 0;
        border-radius: 6px;
        font-size: 0.86rem;
        transition: filter 0.15s ease,
                    transform 0.15s ease;
    }

    .usuario-btn-accion:hover:not(:disabled) {
        filter: brightness(0.92);
        transform: translateY(-1px);
    }

    .usuario-btn-accion:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    /* =========================================
       DATATABLES: BUSCADOR Y PAGINACIÓN
    ========================================= */

    .usuario-index-card #example_wrapper {
        width: 100%;
        color: #343a40;
        font-size: 0.86rem;
    }

    .usuario-index-card #example_wrapper .dataTables_length,
    .usuario-index-card #example_wrapper .dataTables_filter {
        margin-bottom: 14px;
        color: #495057;
    }

    .usuario-index-card #example_wrapper .dataTables_length label,
    .usuario-index-card #example_wrapper .dataTables_filter label {
        color: #475569;
        font-weight: 500;
    }

    .usuario-index-card #example_wrapper .dataTables_length select,
    .usuario-index-card #example_wrapper .dataTables_filter input {
        min-height: 35px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        padding: 6px 9px;
        background-color: #ffffff;
        color: #212529;
        font-size: 0.84rem;
        transition: border-color 0.15s ease,
                    box-shadow 0.15s ease;
    }

    .usuario-index-card #example_wrapper .dataTables_length select {
        margin: 0 5px;
    }

    .usuario-index-card #example_wrapper .dataTables_filter input {
        margin-left: 7px;
        max-width: 230px;
    }

    .usuario-index-card #example_wrapper .dataTables_length select:focus,
    .usuario-index-card #example_wrapper .dataTables_filter input:focus {
        outline: none;
        border-color: #86b7a0;
        box-shadow: 0 0 0 0.15rem rgba(25, 135, 84, 0.12);
    }

    .usuario-index-card #example_wrapper .dataTables_info {
        padding-top: 12px;
        color: #64748b;
        font-size: 0.82rem;
    }

    .usuario-index-card #example_wrapper .dataTables_paginate {
        padding-top: 8px;
    }

    .usuario-index-card #example_wrapper .dataTables_paginate .paginate_button {
        margin: 0 2px;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 0.83rem;
    }

    .usuario-index-card #example_wrapper .dataTables_paginate .paginate_button.current {
        border: 1px solid #198754 !important;
        background: #198754 !important;
        color: #ffffff !important;
    }

    .usuario-index-card #example_wrapper .dataTables_paginate .paginate_button:hover {
        border: 1px solid #c8e6c9 !important;
        background: #e9f7e9 !important;
        color: #146c43 !important;
    }

    /* =========================================
       RESPONSIVE
    ========================================= */

    @media (max-width: 768px) {
        .usuario-index-header {
            padding: 14px;
        }

        .usuario-index-body {
            padding: 12px;
        }

        .usuario-index-header > .d-flex {
            align-items: stretch !important;
        }

        .usuario-index-acciones-header,
        .btn-nuevo-usuario {
            width: 100%;
        }

        .usuario-index-acciones-header {
            margin-top: 2px;
        }

        .usuario-datatable {
            font-size: 0.82rem;
        }

        .usuario-datatable thead th,
        .usuario-datatable tbody td {
            padding: 9px 8px;
        }

        .usuario-index-card #example_wrapper .dataTables_length,
        .usuario-index-card #example_wrapper .dataTables_filter {
            float: none;
            width: 100%;
            text-align: left;
        }

        .usuario-index-card #example_wrapper .dataTables_filter input {
            width: min(65%, 230px);
            max-width: none;
        }

        .usuario-index-card #example_wrapper .dataTables_info,
        .usuario-index-card #example_wrapper .dataTables_paginate {
            float: none;
            width: 100%;
            text-align: center;
        }
    }

    /* =========================================
       TEMA OSCURO
       Se activa si el diseño global usa Bootstrap 5.
    ========================================= */

    [data-bs-theme="dark"] .usuario-index-card {
        background: #1e293b;
        border-color: #334155;
    }

    [data-bs-theme="dark"] .usuario-index-header {
        background: #1b382d;
        color: #e2e8f0;
        border-bottom-color: #315442;
    }

    [data-bs-theme="dark"] .usuario-index-descripcion {
        color: #b0becb;
    }

    [data-bs-theme="dark"] .usuario-index-body,
    [data-bs-theme="dark"] .usuario-datatable {
        color: #e2e8f0;
    }

    [data-bs-theme="dark"] .usuario-datatable thead th {
        background: #273449;
        color: #e2e8f0;
        border-color: #3b4a60;
    }

    [data-bs-theme="dark"] .usuario-datatable tbody td {
        border-color: #334155;
    }

    [data-bs-theme="dark"] .usuario-datatable tbody tr:hover > * {
        --bs-table-bg: #263b36;
        color: #f1f5f9;
    }

    [data-bs-theme="dark"] .usuario-nombre,
    [data-bs-theme="dark"] .usuario-correo {
        color: #e2e8f0;
    }

    [data-bs-theme="dark"] .usuario-etiqueta-propio {
        background: #334155;
        color: #e2e8f0;
    }

    [data-bs-theme="dark"] .usuario-index-card #example_wrapper,
    [data-bs-theme="dark"] .usuario-index-card #example_wrapper .dataTables_length,
    [data-bs-theme="dark"] .usuario-index-card #example_wrapper .dataTables_filter,
    [data-bs-theme="dark"] .usuario-index-card #example_wrapper .dataTables_length label,
    [data-bs-theme="dark"] .usuario-index-card #example_wrapper .dataTables_filter label,
    [data-bs-theme="dark"] .usuario-index-card #example_wrapper .dataTables_info {
        color: #cbd5e1;
    }

    [data-bs-theme="dark"] .usuario-index-card #example_wrapper .dataTables_length select,
    [data-bs-theme="dark"] .usuario-index-card #example_wrapper .dataTables_filter input {
        background: #273449;
        color: #e2e8f0;
        border-color: #475569;
    }
</style>
