@extends('layouts.app')

@section('template_title')
    Equipos
@endsection

@section('content')
<<<<<<< Updated upstream
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">

                        {{-- ===================================================== --}}
                        {{-- ENCABEZADO --}}
                        {{-- ===================================================== --}}
                        <div class="card-header">

                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                                {{-- TÍTULO --}}
                                <span id="card_title" class="fw-bold">
                                    <i class="fa-solid fa-laptop me-2"></i>
                                    EQUIPOS
                                </span>

                                {{-- BOTONES --}}
                                <div class="d-flex align-items-center gap-2">

                                    {{-- REGISTRAR NUEVO --}}
                                    <a href="{{ route('equipos.create') }}" id="btn_nuevo_equipo"
                                        class="btn btn-primary btn-sm">

                                        <i class="fa-solid fa-plus"></i>
                                        Registrar Nuevo

                                    </a>

                                    {{-- EXPORTAR --}}
                                    <div class="btn-group">

                                        <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">

                                            <i class="fa-solid fa-download"></i>
                                            Exportar

                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end">

                                            {{-- EXCEL --}}
                                            <a class="dropdown-item" href="#" id="btn_exportar_excel">
        <i class="fa-solid fa-file-excel text-success"></i>
        Excel
    </a>

                                            {{-- PDF --}}
                                            <li>
        <a class="dropdown-item" href="#" id="btn_exportar_pdf">
            <i class="fa-solid fa-file-pdf text-danger"></i>
            PDF
        </a>
    </li>

                                        </ul>
                                    </div>

                                </div>
                            </div>

=======
    <div class="container-fluid px-4 py-4">
        <div class="row">
            <div class="col-sm-12">
                
                <!-- Encabezado y Botón Registrar -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-white fw-bold fs-4 d-flex align-items-center gap-2">
                        <span id="card_title">{{ __('Equipos') }}</span>
                    </h2>
                    <a href="{{ route('equipos.create') }}" class="btn btn-primary btn-sm">
                        {{ __('Registrar Nuevo') }}
                    </a>
                </div>

                <!-- Panel de Filtros -->
                <div class="card bg-dark border-secondary mb-4 p-3 shadow-sm">
                    <div class="d-flex align-items-center text-success fw-bold mb-3 gap-2">
                        <i class="fa-solid fa-filter"></i> FILTROS
                    </div>
                    <form id="formFiltros" method="GET" action="{{ route('equipos.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label text-secondary small fw-bold">N.° DE SERIE</label>
                                <input type="text" name="num_serie" class="form-control bg-dark text-white border-secondary" placeholder="Buscar por N.° de Serie" value="{{ request('num_serie') }}" autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-secondary small fw-bold">ESTADO</label>
                                <select name="estado" class="form-select bg-dark text-white border-secondary">
                                    <option value="">TODOS</option>
                                    <option value="Bueno" {{ request('estado') == 'Bueno' ? 'selected' : '' }}>Bueno</option>
                                    <option value="Regular" {{ request('estado') == 'Regular' ? 'selected' : '' }}>Regular</option>
                                    <option value="Malogrado" {{ request('estado') == 'Malogrado' ? 'selected' : '' }}>Malogrado</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('equipos.index') }}" class="btn btn-outline-secondary btn-sm px-4">LIMPIAR</a>
>>>>>>> Stashed changes
                        </div>
                    </form>
                </div>

<<<<<<< Updated upstream

                        {{-- ===================================================== --}}
                        {{-- CUERPO --}}
                        {{-- ===================================================== --}}
                        <div class="card-body">

                            {{-- BOTÓN FILTROS --}}
                            <div class="d-flex align-items-center gap-2 mb-2">

                                <button type="button" id="btn_toggle_filtros" class="btn btn-outline-success btn-sm">

                                    <i class="fa-solid fa-filter"></i>
                                    FILTROS

                                    <span id="badge_filtros" class="badge bg-success ms-1 d-none">
                                        0
                                    </span>

                                </button>

                                {{-- MENSAJE DE COINCIDENCIAS --}}
                                <span id="mensaje_coincidencias" class="text-success fw-bold" style="visibility:hidden;">

                                    &nbsp;

                                </span>

                            </div>


                        {{-- ===================================================== --}}
                        {{-- PANEL DE FILTROS --}}
                        {{-- ===================================================== --}}
                        <div id="panel_filtros" class="border rounded p-3 mb-3 mt-2 bg-light" style="display:none;">

                            <div class="row g-2">

                                {{-- TIPO --}}
                                <div class="col-12 col-md-4 col-lg-3">

                                    <label class="form-label fw-bold text-success">
                                        TIPO
                                    </label>

                                    <div class="input-group input-group-sm">

                                        <input type="text" id="filtro_tipo" class="form-control form-control-sm"
                                            list="lista_filtro_tipo" placeholder="TODOS" autocomplete="off">

                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo"
                                            data-target="filtro_tipo" tabindex="-1" title="Limpiar">

                                            <i class="fa-solid fa-xmark"></i>

                                        </button>

                                    </div>

                                    <datalist id="lista_filtro_tipo">
                                        @foreach ($filtroTipos as $nombre)
                                            <option value="{{ $nombre }}"></option>
                                        @endforeach
                                    </datalist>

                                </div>


                                {{-- MARCA --}}
                                <div class="col-12 col-md-4 col-lg-3">

                                    <label class="form-label fw-bold text-success">
                                        MARCA
                                    </label>

                                    <div class="input-group input-group-sm">

                                        <input type="text" id="filtro_marca" class="form-control form-control-sm"
                                            list="lista_filtro_marca" placeholder="ELIJA UN TIPO" autocomplete="off" disabled>

                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo"
                                            data-target="filtro_marca" tabindex="-1" title="Limpiar">

                                            <i class="fa-solid fa-xmark"></i>

                                        </button>

                                    </div>

                                    <datalist id="lista_filtro_marca"></datalist>

                                </div>


                                {{-- MODELO --}}
                                <div class="col-12 col-md-4 col-lg-3">

                                    <label class="form-label fw-bold text-success">
                                        MODELO
                                    </label>

                                    <div class="input-group input-group-sm">

                                        <input type="text" id="filtro_modelo" class="form-control form-control-sm"
                                            list="lista_filtro_modelo" placeholder="ELIJA UNA MARCA" autocomplete="off"
                                            disabled>

                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo"
                                            data-target="filtro_modelo" tabindex="-1" title="Limpiar">

                                            <i class="fa-solid fa-xmark"></i>

                                        </button>

                                    </div>

                                    <datalist id="lista_filtro_modelo"></datalist>

                                </div>


                                {{-- UBICACIÓN --}}
                                <div class="col-12 col-md-4 col-lg-3">

                                    <label class="form-label fw-bold text-success">
                                        UBICACIÓN
                                    </label>

                                    <div class="input-group input-group-sm">

                                        <input type="text" id="filtro_ubicacion" class="form-control form-control-sm"
                                            list="lista_filtro_ubicacion" placeholder="TODAS" autocomplete="off">

                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo"
                                            data-target="filtro_ubicacion" tabindex="-1" title="Limpiar">

                                            <i class="fa-solid fa-xmark"></i>

                                        </button>

                                    </div>

                                    <datalist id="lista_filtro_ubicacion">
                                        @foreach ($filtroUbicaciones as $nombre)
                                            <option value="{{ $nombre }}"></option>
                                        @endforeach
                                    </datalist>

                                </div>


                                {{-- ESTADO --}}
                                <div class="col-12 col-md-4 col-lg-3">

                                    <label class="form-label fw-bold text-success">
                                        ESTADO
                                    </label>

                                    <div class="input-group input-group-sm">

                                        <select id="filtro_estado" class="form-select form-select-sm">

                                            <option value="">TODOS</option>
                                            <option value="BUENO">BUENO</option>
                                            <option value="REGULAR">REGULAR</option>
                                            <option value="MALOGRADO">MALOGRADO</option>

                                        </select>

                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo"
                                            data-target="filtro_estado" tabindex="-1" title="Limpiar">

                                            <i class="fa-solid fa-xmark"></i>

                                        </button>

                                    </div>

                                </div>


                                {{-- NÚMERO DE SERIE --}}
                                <div class="col-12 col-md-4 col-lg-3">

                                    <label class="form-label fw-bold text-success">
                                        N.º SERIE
                                    </label>

                                    <div class="input-group input-group-sm">

                                        <input type="text" id="filtro_serie"
                                            class="form-control form-control-sm campo-mayusculas" list="lista_filtro_serie"
                                            placeholder="ESCRIBA 3 CARACTERES" autocomplete="off">

                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo"
                                            data-target="filtro_serie" tabindex="-1" title="Limpiar">

                                            <i class="fa-solid fa-xmark"></i>

                                        </button>

                                    </div>

                                    <datalist id="lista_filtro_serie"></datalist>

                                </div>


                                {{-- FECHA --}}
                                <div class="col-12 col-md-4 col-lg-3">

                                    <label class="form-label fw-bold text-success">
                                        FECHA
                                    </label>

                                    <div class="input-group input-group-sm">

                                        <input type="date" id="filtro_fecha" class="form-control form-control-sm">

                                        <button type="button" id="btn_filtro_hoy" class="btn btn-outline-success btn-sm">

                                            HOY

                                        </button>

                                        <button type="button" class="btn btn-outline-secondary btn-limpiar-campo"
                                            data-target="filtro_fecha" tabindex="-1" title="Limpiar">

                                            <i class="fa-solid fa-xmark"></i>

                                        </button>

                                    </div>

                                </div>


                                {{-- BOTONES DEL FILTRO --}}
                                <div class="col-12 d-flex justify-content-end align-items-end gap-2 mt-2">

                                    <button type="button" id="btn_aplicar_filtros" class="btn btn-success btn-sm">

                                        APLICAR

                                    </button>

                                    <button type="button" id="btn_limpiar_filtros" class="btn btn-outline-secondary btn-sm">

                                        LIMPIAR

                                    </button>

                                </div>

                            </div>

                        </div>


                        {{-- ===================================================== --}}
                        {{-- TABLA --}}
                        {{-- ===================================================== --}}
                        <div class="table-responsive">

                            <table id="example" class="table table-bordered table-hover" style="width:100%">

                                <thead class="thead">

                                    <tr>
                                        <th>No</th>
                                        <th class="text-center">Tipo</th>
                                        <th class="text-center">N.º Serie</th>
                                        <th class="text-center">Marca</th>
                                        <th class="text-center">Modelo</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Ubicación</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Observación</th>
                                        <th class="text-center columna-acciones">
                                            Acciones
                                        </th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($equipos as $i => $equipo)

                                                                        @php
                                        $estado = strtoupper(
                                            $equipo->especificacionesLaptops->estado
                                            ?? $equipo->especificacionesEquipo->estado
                                            ?? ''
                                        );

                                        $fechaIso = $equipo->fecha_registro
                                            ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('Y-m-d')
                                            : '';

                                        $fechaVista = $fechaIso
                                            ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('d-m-Y')
                                            : '-';
                                                                        @endphp

                                                                        <tr data-equipo-id="{{ $equipo->id }}">

                                                                            <td>
                                                                                {{ $equipo->id }}
                                                                            </td>

                                                                            <td>
                                                                                {{ $equipo->tipoEquipo->nombre ?? '-' }}
                                                                            </td>

                                                                            <td class="text-center">
                                                                                {{ $equipo->num_serie }}
                                                                            </td>

                                                                            <td>
                                                                                {{ $equipo->marca }}
                                                                            </td>

                                                                            <td>
                                                                                {{ $equipo->modelo }}
                                                                            </td>

                                                                            <td class="text-center">
                                                                                {{ $estado ?: '-' }}
                                                                            </td>

                                                                            <td class="text-center">
                                                                                {{ $equipo->ubicacione->nombre ?? '-' }}
                                                                            </td>

                                                                            <td class="text-center" data-fecha="{{ $fechaIso }}" data-order="{{ $fechaIso ?: '0000-00-00' }}">
                                                                                {{ $fechaVista }}
                                                                            </td>

                                                                            <td>
                                                                                {{
                                            $equipo->especificacionesLaptops->observaciones
                                            ?? $equipo->especificacionesEquipo->observaciones
                                            ?? '-'
                                                                                }}
                                                                            </td>

                                                                            <td class="text-center columna-acciones">

                                                                                <div class="d-flex justify-content-center align-items-center gap-1">

                                                                                    <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST">

                                                                                        {{-- VER --}}
                                                                                        <a class="btn btn-info btn-accion btn-ver-equipo"
                                                                                            href="{{ route('equipos.show', $equipo->id) }}">

                                                                                            <i class="fa-solid fa-eye"></i>

                                                                                        </a>

                                                                                        {{-- EDITAR --}}
                                                                                        <a class="btn btn-warning btn-accion"
                                                                                            href="{{ route('equipos.edit', $equipo->id) }}">

                                                                                            <i class="fa-solid fa-pen-to-square"></i>

                                                                                        </a>

                                                                                        @csrf
                                                                                        @method('DELETE')

                                                                                        {{-- ELIMINAR --}}
                                                                                        <button type="submit" class="btn btn-danger btn-accion"
                                                                                            onclick="event.preventDefault(); confirmarEliminarFila(this.closest('form'));">
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
=======
                <!-- Contenedor dinámico de la tabla y paginación -->
                <div id="tabla-container">
                    <!-- Tabla con Cabecera Verde -->
                    <div class="card bg-dark border-secondary shadow-sm">
                        <div class="card-body bg-white p-0">
                            <div class="table-responsive">
                                <table id="example" class="table table-dark table-striped table-hover align-middle mb-0">
                                    <thead>
                                        <tr class="text-uppercase fw-bold text-dark" style="background-color: #198754 !important;">
                                            <th class="py-3 ps-3" style="background-color: #198754 !important; color: #000 !important;">No</th>
                                            <th class="py-3" style="background-color: #198754 !important; color: #000 !important;">Tipo</th>
                                            <th class="py-3" style="background-color: #198754 !important; color: #000 !important;">Num Serie</th>
                                            <th class="py-3" style="background-color: #198754 !important; color: #000 !important;">Modelo</th>
                                            <th class="py-3" style="background-color: #198754 !important; color: #000 !important;">Estado</th>
                                            <th class="py-3 text-center pe-3" style="background-color: #198754 !important; color: #000 !important;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($equipos as $equipo)
                                            <tr>
                                                <td class="ps-3">{{ $loop->iteration }}</td>
                                                <td>{{ $equipo->tipoEquipo->nombre ?? 'N/A' }}</td>
                                                <td>{{ $equipo->num_serie }}</td>
                                                <td>{{ $equipo->modelo }}</td>
                                                <td>{{ $equipo->estado }}</td>
                                                <td class="text-center pe-3">
                                                    <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST">
                                                        <a class="btn btn-sm btn-info text-white" href="{{ route('equipos.show', $equipo->id) }}">
                                                            <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                                        </a>
                                                        <a class="btn btn-sm btn-warning text-dark" href="{{ route('equipos.edit', $equipo->id) }}">
                                                            <i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}
                                                        </a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirmarEliminar(this.closest('form'));">
                                                            <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-dark py-4">No se encontraron registros.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-4">
                        {!! $equipos->withQueryString()->links() !!}
>>>>>>> Stashed changes
                    </div>
                </div>

            </div>
        </div>
<<<<<<< Updated upstream
@endsection
=======
    </div>
>>>>>>> Stashed changes

    <!-- Script de búsqueda en vivo fluida para Equipos -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById('formFiltros');
            const inputs = form.querySelectorAll('input, select');

            inputs.forEach(element => {
                if (element.tagName === 'SELECT') {
                    element.addEventListener('change', function () {
                        realizarBusquedaAjax();
                    });
                } 
                else if (element.tagName === 'INPUT') {
                    element.addEventListener('keydown', function (e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            realizarBusquedaAjax();
                        }
                    });

                    element.addEventListener('blur', function () {
                        realizarBusquedaAjax();
                    });
                }
            });

            function realizarBusquedaAjax() {
                const formData = new FormData(form);
                const queryString = new URLSearchParams(formData).toString();
                const url = form.action + '?' + queryString;

                window.history.pushState({}, '', url);

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const nuevoContenedor = doc.getElementById('tabla-container');
                    
                    if (nuevoContenedor) {
                        document.getElementById('tabla-container').innerHTML = nuevoContenedor.innerHTML;
                    }
                })
                .catch(error => console.error('Error al filtrar:', error));
            }
        });
    </script>
@endsection