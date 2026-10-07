@extends('layouts.app')

@section('template_title')
    Accesorios Equipos
@endsection

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="row">
            <div class="col-sm-12">
                
                <!-- Encabezado y Botón Registrar -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-white fw-bold fs-4 d-flex align-items-center gap-2">
                        <span id="card_title">{{ __('Accesorios Equipos') }}</span>
                    </h2>
                    <a href="{{ route('accesorios-equipo.create') }}" class="btn btn-primary btn-sm">
                        {{ __('Registrar Nuevo') }}
                    </a>
                </div>

                <!-- Panel de Filtros -->
                <div class="card bg-dark border-secondary mb-4 p-3 shadow-sm">
                    <div class="d-flex align-items-center text-success fw-bold mb-3 gap-2">
                        <i class="fa-solid fa-filter"></i> FILTROS
                    </div>
                    <form id="formFiltros" method="GET" action="{{ route('accesorios-equipo.index') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label text-secondary small fw-bold">EQUIPO RELACIONADO</label>
                                <input type="text" name="equipo" class="form-control bg-dark text-white border-secondary" placeholder="N.° de Serie" value="{{ request('equipo') }}" autocomplete="off">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label text-secondary small fw-bold">TIPO</label>
                                <input type="text" name="tipo" class="form-control bg-dark text-white border-secondary" placeholder="Elija un tipo" value="{{ request('tipo') }}" autocomplete="off">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label text-secondary small fw-bold">MARCA</label>
                                <input type="text" name="marca" class="form-control bg-dark text-white border-secondary" placeholder="Elija una marca" value="{{ request('marca') }}" autocomplete="off">
                            </div>
                            <div class="col-md-3">
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
                            <a href="{{ route('accesorios-equipo.index') }}" class="btn btn-outline-secondary btn-sm px-4">LIMPIAR</a>
                        </div>
                    </form>
                </div>

                <!-- Contenedor dinámico de la tabla -->
                <div id="tabla-container">
                    <div class="card bg-dark border-secondary shadow-sm">
                        <div class="card-body bg-white p-0">
                            <div class="table-responsive">
                                <table id="example" class="table table-dark table-striped table-hover align-middle mb-0">
                                    <thead>
                                        <tr class="text-uppercase fw-bold text-dark" style="background-color: #198754 !important;">
                                            <th class="py-3 ps-3" style="background-color: #198754 !important; color: #000 !important;">No</th>
                                            <th class="py-3" style="background-color: #198754 !important; color: #000 !important;">Equipo Relacionado</th>
                                            <th class="py-3" style="background-color: #198754 !important; color: #000 !important;">Tipo</th>
                                            <th class="py-3" style="background-color: #198754 !important; color: #000 !important;">Marca</th>
                                            <th class="py-3" style="background-color: #198754 !important; color: #000 !important;">Num Serie</th>
                                            <th class="py-3" style="background-color: #198754 !important; color: #000 !important;">Estado</th>
                                            <th class="py-3" style="background-color: #198754 !important; color: #000 !important;">Observaciones</th>
                                            <th class="py-3 text-center pe-3" style="background-color: #198754 !important; color: #000 !important;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($accesoriosEquipos as $accesoriosEquipo)
                                            <tr>
                                                <td class="ps-3">{{ ++$i }}</td>
                                                <td>{{ $accesoriosEquipo->equipo->num_serie ?? 'N/A' }}</td>
                                                <td>{{ $accesoriosEquipo->tipo }}</td>
                                                <td>{{ $accesoriosEquipo->marca }}</td>
                                                <td>{{ $accesoriosEquipo->num_serie }}</td>
                                                <td>{{ $accesoriosEquipo->estado }}</td>
                                                <td>{{ $accesoriosEquipo->observaciones }}</td>
                                                <td class="text-center pe-3">
                                                    <form action="{{ route('accesorios-equipo.destroy', $accesoriosEquipo->id) }}" method="POST">
                                                        <a class="btn btn-sm btn-info text-white" href="{{ route('accesorios-equipo.show', $accesoriosEquipo->id) }}">
                                                            <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                                        </a>
                                                        <a class="btn btn-sm btn-warning text-dark" href="{{ route('accesorios-equipo.edit', $accesoriosEquipo->id) }}">
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
                                                <td colspan="8" class="text-center text-dark py-4">No se encontraron registros.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        {!! $accesoriosEquipos->withQueryString()->links() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Script: Escribe todo lo que quieras sin interrupciones, busca solo al presionar Enter o al salir del input (blur) -->
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