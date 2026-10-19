@extends('layouts.app')

@section('template_title')
    Tipos de Equipo
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card tipo-equipo-index-card">

                {{-- ENCABEZADO --}}
                <div class="card-header tipo-equipo-index-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <span id="card_title" class="fw-bold">
                            <i class="bi bi-tags me-2 fs-5 text-success"></i>
                            TIPOS DE EQUIPO
                            <small class="d-block fw-normal text-muted mt-1 ms-1">
                                Consulta y administra los tipos de equipo registrados.
                            </small>
                        </span>

                        <div class="d-flex align-items-center gap-2">
                            @can('registrar')
                            <a href="{{ route('tipos-equipo.create') }}" id="btn_nuevo_tipo" class="btn btn-success btn-sm">
                                <i class="fa-solid fa-plus"></i> Registrar Nuevo Tipo
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="card-body tipo-equipo-index-body">

                    {{-- TABLA --}}
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered table-hover table-striped align-middle tipo-equipo-datatable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center columna-acciones">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tiposEquipos as $tipo)
                                    <tr data-tipo-id="{{ $tipo->id }}">
                                        <td>{{ $tipo->id }}</td>
                                        <td>{{ strtoupper($tipo->nombre ?? '-') }}</td>
                                        <td class="text-center columna-acciones">
                                            <div class="d-flex justify-content-center align-items-center gap-1">
                                                <form action="{{ route('tipos-equipo.destroy', $tipo->id) }}" method="POST">
                                                    <a class="btn btn-info btn-accion btn-ver-tipo"
                                                        href="{{ route('tipos-equipo.show', $tipo->id) }}">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>

                                                    @can('registrar')
                                                    <a class="btn btn-warning btn-accion"
                                                        href="{{ route('tipos-equipo.edit', $tipo->id) }}">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    @endcan
                                                    @can('eliminar')
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-accion"
                                                        onclick="event.preventDefault(); confirmarEliminarTipo(this.closest('form'));">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                    @endcan
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
@endsection

<style>
    /* =========================================
       TARJETA PRINCIPAL
    ========================================= */
    .tipo-equipo-index-card {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .06);
        overflow: hidden;
    }

    .tipo-equipo-index-header {
        background: #e9f7e9;
        color: #212529;
        border-bottom: 1px solid #c8e6c9;
        padding: 15px 18px;
    }

    .tipo-equipo-index-header #card_title {
        font-size: 1rem;
        letter-spacing: .2px;
    }

    .tipo-equipo-index-body {
        padding: 18px;
    }

    #btn_nuevo_tipo {
        font-weight: 600;
    }

    .tipo-equipo-index-header .btn,
    .tipo-equipo-index-body .btn {
        border-radius: 6px;
    }

    /* =========================================
       DATATABLE + BÚSQUEDA AMPLIADA
    ========================================= */
    #example_wrapper {
        width: 100%;
        color: #343a40;
        font-size: .88rem;
    }

    #example_wrapper .dataTables_length,
    #example_wrapper .dataTables_filter {
        margin-bottom: 12px;
    }

    #example_wrapper .dataTables_length label,
    #example_wrapper .dataTables_filter label {
        color: #495057;
        font-weight: 500;
    }

    #example_wrapper .dataTables_length select,
    #example_wrapper .dataTables_filter input {
        border: 1px solid #ced4da;
        border-radius: 6px;
        padding: 6px 10px;
        background: #fff;
        color: #212529;
    }

    /* Campo de búsqueda más grande */
    #example_wrapper .dataTables_filter {
        float: none !important;
        text-align: left;
    }

    #example_wrapper .dataTables_filter input {
        margin-left: 8px;
        width: 320px;
        max-width: 100%;
        min-height: 36px;
        font-size: .9rem;
    }

    #example_wrapper .dataTables_length select:focus,
    #example_wrapper .dataTables_filter input:focus {
        outline: none;
        border-color: #86b7a0;
        box-shadow: 0 0 0 .15rem rgba(25, 135, 84, .12);
    }

    #example {
        width: 100% !important;
        margin-bottom: 0 !important;
        border-color: #dee2e6;
    }

    #example thead th {
        background-color: #e9f7e9 !important;
        color: #212529 !important;
        text-align: center;
        vertical-align: middle;
        font-size: .78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .2px;
        white-space: nowrap;
        padding: 12px 10px;
        border-color: #d5e5d7;
    }

    #example tbody td {
        vertical-align: middle !important;
        padding: 10px;
        border-color: #e5e7eb;
        color: #343a40;
    }

    #example tbody tr:nth-child(even) td {
        background-color: #f8faf9;
    }

    #example tbody tr:hover td {
        background-color: #eef7f0;
    }

    #example tbody td:nth-child(1),
    #example tbody td:last-child {
        text-align: center;
    }

    #example .columna-acciones {
        min-width: 125px;
        white-space: nowrap;
    }

    #example .btn-accion {
        width: 31px;
        height: 30px;
        padding: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 5px;
        font-size: .8rem;
        transition: opacity .2s, transform .2s;
    }

    #example .btn-accion:hover {
        opacity: .85;
        transform: translateY(-1px);
    }

    #example .btn-info.btn-accion {
        background-color: #e7f1ff;
        color: #0d6efd;
    }

    #example .btn-warning.btn-accion {
        background-color: #fff3cd;
        color: #856404;
    }

    #example .btn-danger.btn-accion {
        background-color: #f8d7da;
        color: #842029;
    }

    #example_wrapper .dataTables_info {
        padding-top: 10px;
        color: #6c757d;
        font-size: .82rem;
    }

    #example_wrapper .dataTables_paginate {
        padding-top: 8px;
    }

    #example_wrapper .page-link {
        color: #198754;
        border-color: #dee2e6;
    }

    #example_wrapper .page-item.active .page-link {
        background-color: #198754;
        border-color: #198754;
        color: #fff;
    }

    #example_wrapper .page-link:focus {
        box-shadow: 0 0 0 .15rem rgba(25, 135, 84, .15);
    }

    /* Filas resaltadas */
    .fila-crear td  { background-color: #d4edda !important; }
    .fila-editar td { background-color: #fff3cd !important; }
    .fila-ver td    { background-color: #cfe2ff !important; }

    /* =========================================
       RESPONSIVE
    ========================================= */
    @media (max-width: 768px) {
        .tipo-equipo-index-body { padding: 12px; }
        .tipo-equipo-index-header { padding: 12px; }

        #example_wrapper .dataTables_length,
        #example_wrapper .dataTables_filter {
            float: none;
            width: 100%;
            text-align: left;
        }

        #example_wrapper .dataTables_filter input {
            width: 100%;
            max-width: none;
            margin: 6px 0 0;
        }

        #example_wrapper .dataTables_paginate {
            overflow-x: auto;
            white-space: nowrap;
        }
    }
</style>

<script>
window.addEventListener('load', function() {
    if (typeof $ === 'undefined' || !$.fn.DataTable) return;

    const tabla = $.fn.DataTable.isDataTable('#example')
        ? $('#example').DataTable()
        : $('#example').DataTable({
            dom: '<"d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-2"ip>',
            pageLength: 10,
            lengthMenu: [5, 10, 25, 100],
            language: {
                lengthMenu: "Mostrar _MENU_ registros por página",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros.",
                search: "Buscar:",
                zeroRecords: "No se encontraron registros",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(filtrado de _MAX_ registros en total)"
            }
        });

    // Orden por nombre
    tabla.order([[1, 'asc']]).draw();

    // ===================== RESALTADO DE FILA =====================
    function pintarFilaTipo() {
        const idFila = @json(session('tipo_resaltado')) || sessionStorage.getItem('tipo_resaltado');
        const accFila = @json(session('tipo_accion')) || sessionStorage.getItem('tipo_accion');
        sessionStorage.removeItem('tipo_resaltado');
        sessionStorage.removeItem('tipo_accion');
        if (!idFila || !accFila) return;

        let nodo = null;
        tabla.rows({ page: 'all' }).every(function() {
            const tr = this.node();
            if (tr && String(tr.getAttribute('data-tipo-id')) === String(idFila)) nodo = tr;
        });
        if (!nodo) return;

        const visibles = tabla.rows({ search: 'applied', order: 'applied' }).indexes().toArray();
        const posicion = visibles.indexOf(tabla.row(nodo).index());
        if (posicion === -1) return;

        const pagina = Math.floor(posicion / tabla.page.len());
        tabla.page(pagina).draw('page');

        setTimeout(function() {
            const visible = document.querySelector(`#example tbody tr[data-tipo-id="${idFila}"]`);
            if (!visible) return;
            const color = accFila === 'crear' ? '#d4edda' : accFila === 'editar' ? '#fff3cd' : '#cfe2ff';
            visible.querySelectorAll('td').forEach(td => td.style.backgroundColor = color);
            visible.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => visible.querySelectorAll('td').forEach(td => td.style.backgroundColor = ''), 4000);
        }, 50);
    }

    document.querySelectorAll('.btn-ver-tipo').forEach(a => {
        a.addEventListener('click', function() {
            const partes = a.getAttribute('href').split('/').filter(Boolean);
            sessionStorage.setItem('tipo_resaltado', partes.pop());
            sessionStorage.setItem('tipo_accion', 'ver');
        });
    });

    setTimeout(pintarFilaTipo, 300);
    window.pintarFilaTipo = pintarFilaTipo;

    // Atajo + para nuevo
    document.addEventListener('keydown', function(e) {
        const tag = e.target?.tagName;
        if (tag && ['INPUT','SELECT','TEXTAREA'].includes(tag)) return;
        if (e.key === '+' || e.key === '=') {
            e.preventDefault();
            document.getElementById('btn_nuevo_tipo')?.click();
        }
    });
});

function confirmarEliminarTipo(form) {
    if (!form) return;
    const fila = form.closest('tr');

    function enviar() {
        if (fila) {
            fila.querySelectorAll('td').forEach(td => td.style.backgroundColor = '#f8d7da');
            fila.style.transition = 'opacity 0.4s';
            setTimeout(() => fila.style.opacity = '0', 200);
            setTimeout(() => form.submit(), 700);
        } else {
            form.submit();
        }
    }

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'warning',
            title: '¿Eliminar tipo de equipo?',
            text: 'Esta acción no se puede deshacer.',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then(r => { if (r.isConfirmed) enviar(); });
    } else if (confirm('¿Eliminar tipo de equipo?')) {
        enviar();
    }
}

window.addEventListener('pageshow', function() {
    if (typeof pintarFilaTipo === 'function') setTimeout(pintarFilaTipo, 200);
});
</script>