@extends('layouts.app')

@section('template_title')
    Ubicaciones
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card ubicacion-index-card">

                {{-- ENCABEZADO --}}
                <div class="card-header ubicacion-index-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <span id="card_title" class="fw-bold">
                            <i class="bi bi-geo-alt me-2 fs-5 text-success"></i>
                            UBICACIONES
                            <small class="d-block fw-normal text-muted mt-1 ms-1">
                                Consulta y administra las ubicaciones registradas.
                            </small>
                        </span>

                        <div class="d-flex align-items-center gap-2">
                            @can('registrar')
                            <a href="{{ route('ubicaciones.create') }}" id="btn_nueva_ubicacion" class="btn btn-success btn-sm">
                                <i class="fa-solid fa-plus"></i> Registrar Nueva Ubicación
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="card-body ubicacion-index-body">

                    {{-- TABLA --}}
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered table-hover table-striped align-middle ubicacion-datatable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Tipo</th>
                                    <th class="text-center columna-acciones">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ubicaciones as $ubicacione)
                                    <tr data-ubicacion-id="{{ $ubicacione->id }}">
                                        <td>{{ $ubicacione->id }}</td>
                                        <td>{{ strtoupper($ubicacione->nombre ?? '-') }}</td>
                                        <td class="text-center">{{ strtoupper($ubicacione->tipo ?? '-') }}</td>
                                        <td class="text-center columna-acciones">
                                            <div class="d-flex justify-content-center align-items-center gap-1">
                                                <form action="{{ route('ubicaciones.destroy', $ubicacione->id) }}" method="POST">
                                                    <a class="btn btn-info btn-accion btn-ver-ubicacion"
                                                        href="{{ route('ubicaciones.show', $ubicacione->id) }}">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    @can('registrar')
                                                    <a class="btn btn-warning btn-accion"
                                                        href="{{ route('ubicaciones.edit', $ubicacione->id) }}">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    @endcan

                                                    @can('eliminar')
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-accion"
                                                        onclick="event.preventDefault(); confirmarEliminarUbicacion(this.closest('form'));">
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
    .ubicacion-index-card {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .06);
        overflow: hidden;
    }

    .ubicacion-index-header {
        background: #e9f7e9;
        color: #212529;
        border-bottom: 1px solid #c8e6c9;
        padding: 15px 18px;
    }

    .ubicacion-index-header #card_title {
        font-size: 1rem;
        letter-spacing: .2px;
    }

    .ubicacion-index-body {
        padding: 18px;
    }

    #btn_nueva_ubicacion {
        font-weight: 600;
    }

    .ubicacion-index-header .btn,
    .ubicacion-index-body .btn {
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
    #example tbody td:nth-child(3),
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
        .ubicacion-index-body { padding: 12px; }
        .ubicacion-index-header { padding: 12px; }

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
    function pintarFilaUbicacion() {
        const idFila = @json(session('ubicacion_resaltado')) || sessionStorage.getItem('ubicacion_resaltado');
        const accFila = @json(session('ubicacion_accion')) || sessionStorage.getItem('ubicacion_accion');
        sessionStorage.removeItem('ubicacion_resaltado');
        sessionStorage.removeItem('ubicacion_accion');
        if (!idFila || !accFila) return;

        let nodo = null;
        tabla.rows({ page: 'all' }).every(function() {
            const tr = this.node();
            if (tr && String(tr.getAttribute('data-ubicacion-id')) === String(idFila)) nodo = tr;
        });
        if (!nodo) return;

        const visibles = tabla.rows({ search: 'applied', order: 'applied' }).indexes().toArray();
        const posicion = visibles.indexOf(tabla.row(nodo).index());
        if (posicion === -1) return;

        const pagina = Math.floor(posicion / tabla.page.len());
        tabla.page(pagina).draw('page');

        setTimeout(function() {
            const visible = document.querySelector(`#example tbody tr[data-ubicacion-id="${idFila}"]`);
            if (!visible) return;
            const color = accFila === 'crear' ? '#d4edda' : accFila === 'editar' ? '#fff3cd' : '#cfe2ff';
            visible.querySelectorAll('td').forEach(td => td.style.backgroundColor = color);
            visible.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => visible.querySelectorAll('td').forEach(td => td.style.backgroundColor = ''), 4000);
        }, 50);
    }

    document.querySelectorAll('.btn-ver-ubicacion').forEach(a => {
        a.addEventListener('click', function() {
            const partes = a.getAttribute('href').split('/').filter(Boolean);
            sessionStorage.setItem('ubicacion_resaltado', partes.pop());
            sessionStorage.setItem('ubicacion_accion', 'ver');
        });
    });

    setTimeout(pintarFilaUbicacion, 300);
    window.pintarFilaUbicacion = pintarFilaUbicacion;

    // Atajo + para nuevo
    document.addEventListener('keydown', function(e) {
        const tag = e.target?.tagName;
        if (tag && ['INPUT','SELECT','TEXTAREA'].includes(tag)) return;
        if (e.key === '+' || e.key === '=') {
            e.preventDefault();
            document.getElementById('btn_nueva_ubicacion')?.click();
        }
    });
});

function confirmarEliminarUbicacion(form) {
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
            title: '¿Eliminar ubicación?',
            text: 'Esta acción no se puede deshacer.',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then(r => { if (r.isConfirmed) enviar(); });
    } else if (confirm('¿Eliminar ubicación?')) {
        enviar();
    }
}

window.addEventListener('pageshow', function() {
    if (typeof pintarFilaUbicacion === 'function') setTimeout(pintarFilaUbicacion, 200);
});
</script>
<style id="fix-all-tables-dark">
  html.home-dark table.dataTable thead th,
  html.home-dark table thead th,
  body.dark-mode table.dataTable thead th,
  body.dark table.dataTable thead th,
  [data-bs-theme="dark"] table.dataTable thead th,
  [data-theme="dark"] table.dataTable thead th {
    background-color: #1e293b !important;
    color: #f8fafc !important;
    border-color: #334155 !important;
  }

  html.home-dark .dataTables_wrapper .dataTables_length select,
  html.home-dark .dataTables_wrapper .dataTables_filter input,
  body.dark-mode .dataTables_wrapper .dataTables_length select,
  body.dark-mode .dataTables_wrapper .dataTables_filter input,
  [data-bs-theme="dark"] .dataTables_wrapper .dataTables_length select,
  [data-bs-theme="dark"] .dataTables_wrapper .dataTables_filter input {
    background-color: #0f172a !important;
    color: #f8fafc !important;
    border: 1px solid #334155 !important;
  }
</style>
<!-- FIX_UB_DARK_3_START -->
<style id="ub-dark-common-style">
  html.dark label,
  html.dark .form-label,
  html.dark .col-form-label,
  html.dark .card-header,
  html.dark .card-header *,
  html.dark small,
  html.dark .text-muted,
  html[data-bs-theme="dark"] label,
  html[data-bs-theme="dark"] .form-label,
  html[data-bs-theme="dark"] .col-form-label,
  html[data-bs-theme="dark"] .card-header,
  html[data-bs-theme="dark"] .card-header *,
  html[data-bs-theme="dark"] small,
  html[data-bs-theme="dark"] .text-muted,
  body.dark label,
  body.dark .form-label,
  body.dark .col-form-label,
  body.dark .card-header,
  body.dark .card-header *,
  body.dark small,
  body.dark .text-muted,
  body.dark-mode label,
  body.dark-mode .form-label,
  body.dark-mode .col-form-label,
  body.dark-mode .card-header,
  body.dark-mode .card-header *,
  body.dark-mode small,
  body.dark-mode .text-muted,
  body.tema-oscuro-activo label,
  body.tema-oscuro-activo .form-label,
  body.tema-oscuro-activo .col-form-label,
  body.tema-oscuro-activo .card-header,
  body.tema-oscuro-activo .card-header *,
  body.tema-oscuro-activo small,
  body.tema-oscuro-activo .text-muted {
    color: #f8fafc !important;
    -webkit-text-fill-color: #f8fafc !important;
    opacity: 1 !important;
    visibility: visible !important;
  }

  html.dark input.form-control,
  html.dark select.form-select,
  html.dark textarea.form-control,
  html[data-bs-theme="dark"] input.form-control,
  html[data-bs-theme="dark"] select.form-select,
  html[data-bs-theme="dark"] textarea.form-control,
  body.dark input.form-control,
  body.dark select.form-select,
  body.dark textarea.form-control,
  body.dark-mode input.form-control,
  body.dark-mode select.form-select,
  body.dark-mode textarea.form-control,
  body.tema-oscuro-activo input.form-control,
  body.tema-oscuro-activo select.form-select,
  body.tema-oscuro-activo textarea.form-control {
    color: #f8fafc !important;
    -webkit-text-fill-color: #f8fafc !important;
    background-color: #0f172a !important;
    border-color: #334155 !important;
  }

  table td:last-child a,
  table td:last-child button,
  table td:last-child .btn,
  .btn-accion {
    opacity: 1 !important;
    visibility: visible !important;
  }

  table td:last-child a i,
  table td:last-child a svg,
  table td:last-child a span,
  table td:last-child button i,
  table td:last-child button svg,
  table td:last-child button span,
  table td:last-child .btn i,
  table td:last-child .btn svg,
  table td:last-child .btn span,
  .btn-accion i,
  .btn-accion svg,
  .btn-accion span {
    color: #0f172a !important;
    -webkit-text-fill-color: #0f172a !important;
    fill: #0f172a !important;
    stroke: #0f172a !important;
    opacity: 1 !important;
    visibility: visible !important;
  }
</style>
<script id="ub-dark-common-script">
(function () {
  function esOscuroUb() {
    var h = document.documentElement;
    var b = document.body;
    if (!b) return false;
    var txt = b.innerText || "";
    if (
      h.classList.contains("dark") ||
      h.getAttribute("data-bs-theme") === "dark" ||
      b.classList.contains("dark") ||
      b.classList.contains("dark-mode") ||
      b.classList.contains("tema-oscuro-activo") ||
      b.getAttribute("data-bs-theme") === "dark"
    ) {
      return true;
    }
    return txt.indexOf("Modo Claro") !== -1;
  }

  function fijarUbDark() {
    var oscuro = esOscuroUb();
    var body = document.body;
    if (!body) return;

    body.querySelectorAll("div, section, article, button, a, span").forEach(function (el) {
      if (el.closest("table, nav, aside, .sidebar")) return;
      if (el === body || el.tagName === "HTML") return;
      if (el.classList.contains("btn-success") || el.classList.contains("btn-primary") || el.classList.contains("btn-danger")) return;

      var cs = window.getComputedStyle(el);
      var bg = cs.backgroundColor || "";
      var m = bg.match(/\d+/g);
      var esClaro = false;
      if (m && m.length >= 3) {
        var r = parseInt(m[0], 10), g = parseInt(m[1], 10), bl = parseInt(m[2], 10);
        var a = m.length >= 4 ? parseFloat(m[3]) : 1;
        var lum = (r + g + bl) / 3;
        if (a > 0.1 && lum > 150) esClaro = true;
      }

      if (oscuro && esClaro) {
        el.dataset.ubDarkBg = "1";
        var isPill = el.tagName === "BUTTON" || el.classList.contains("btn") || el.classList.contains("badge") || el.closest("button, .btn");
        el.style.setProperty("background-color", isPill ? "#1e293b" : "#111827", "important");
        el.style.setProperty("border-color", "#334155", "important");
        el.style.setProperty("color", "#f8fafc", "important");
        el.style.setProperty("-webkit-text-fill-color", "#f8fafc", "important");
      } else if (!oscuro && el.dataset.ubDarkBg === "1") {
        delete el.dataset.ubDarkBg;
        el.style.removeProperty("background-color");
        el.style.removeProperty("border-color");
        el.style.removeProperty("color");
        el.style.removeProperty("-webkit-text-fill-color");
      }
    });

    body.querySelectorAll("h1, h2, h3, h4, h5, h6, p, span, small, label, strong, b, div, i, svg").forEach(function (el) {
      if (el.closest("table, nav, aside, .sidebar")) return;
      if (el.closest("a, button, .btn")) return;
      if (el.querySelector("div, p, h1, h2, h3, h4, h5, h6, table, input, select, textarea")) return;
      var t = (el.textContent || "").trim();
      if (!t && el.tagName !== "I" && el.tagName !== "SVG") return;

      var esSecundario =
        t.indexOf("DETALLE DE UBICACIÓN") !== -1 ||
        t.indexOf("DETALLE DE UBICACION") !== -1 ||
        t.indexOf("Tipo:") !== -1 ||
        t.indexOf("Asignados y vigentes") !== -1 ||
        t.indexOf("En buen estado") !== -1 ||
        t.indexOf("Requieren seguimiento") !== -1 ||
        t.indexOf("Requieren revisión") !== -1 ||
        t.indexOf("Requieren revision") !== -1 ||
        t.indexOf("Fuera del inventario") !== -1 ||
        el.classList.contains("text-muted");

      if (oscuro) {
        el.dataset.ubDarkFg = "1";
        var fg = esSecundario ? "#cbd5e1" : "#f8fafc";
        el.style.setProperty("color", fg, "important");
        el.style.setProperty("-webkit-text-fill-color", fg, "important");
        el.style.setProperty("fill", fg, "important");
        el.style.setProperty("opacity", "1", "important");
        el.style.setProperty("visibility", "visible", "important");
      } else if (el.dataset.ubDarkFg === "1") {
        delete el.dataset.ubDarkFg;
        el.style.removeProperty("color");
        el.style.removeProperty("-webkit-text-fill-color");
        el.style.removeProperty("fill");
        el.style.removeProperty("opacity");
        el.style.removeProperty("visibility");
      }
    });

    body.querySelectorAll("input, select, textarea").forEach(function (inp) {
      if (inp.closest("nav, aside, .sidebar")) return;
      if (oscuro) {
        inp.dataset.ubDarkInp = "1";
        inp.style.setProperty("color", "#f8fafc", "important");
        inp.style.setProperty("-webkit-text-fill-color", "#f8fafc", "important");
      } else if (inp.dataset.ubDarkInp === "1") {
        delete inp.dataset.ubDarkInp;
        inp.style.removeProperty("color");
        inp.style.removeProperty("-webkit-text-fill-color");
      }
    });

    body.querySelectorAll("table td:last-child a, table td:last-child button, table td:last-child .btn, .btn-accion").forEach(function (btn) {
      btn.style.setProperty("opacity", "1", "important");
      btn.style.setProperty("visibility", "visible", "important");
      btn.querySelectorAll("i, svg, path, circle, rect, line, polygon, span").forEach(function (el) {
        var tag = el.tagName.toLowerCase();
        if (tag === "svg" || tag === "path" || tag === "circle" || tag === "rect" || tag === "line" || tag === "polygon") {
          el.style.setProperty("fill", "#0f172a", "important");
          el.style.setProperty("stroke", "#0f172a", "important");
        } else {
          el.style.setProperty("color", "#0f172a", "important");
          el.style.setProperty("-webkit-text-fill-color", "#0f172a", "important");
        }
        el.style.setProperty("opacity", "1", "important");
        el.style.setProperty("visibility", "visible", "important");
      });
    });
  }

  fijarUbDark();
  document.addEventListener("DOMContentLoaded", function () {
    fijarUbDark();
    setTimeout(fijarUbDark, 150);
    setTimeout(fijarUbDark, 500);
    setTimeout(fijarUbDark, 1000);
  });
  window.addEventListener("load", function () {
    fijarUbDark();
    setTimeout(fijarUbDark, 300);
  });
  document.addEventListener("click", function () {
    setTimeout(fijarUbDark, 60);
    setTimeout(fijarUbDark, 250);
  });
  document.addEventListener("input", function () {
    setTimeout(fijarUbDark, 40);
  });
})();
</script>
<!-- FIX_UB_DARK_3_END -->

<!-- FIX_BURGER_CIRCLE_START -->
<style id="burger-circle-fix-style">
  .navbar-toggler,
  .sidebar-toggle,
  [data-toggle="sidebar"] {
    flex-shrink: 0 !important;
  }
</style>
<script id="burger-circle-fix-script">
(function () {
  function fijarBotonesSidebar() {
    var candidatos = document.querySelectorAll("aside button, nav button, .sidebar button, [class*=\"sidebar\"] button, header button, .navbar-toggler, .sidebar-toggle");
    candidatos.forEach(function (btn) {
      if (!btn || btn.closest("table, form")) return;
      var txt = (btn.textContent || "").trim();
      var esBotonTema = txt.indexOf("Modo Claro") !== -1 || txt.indexOf("Modo Oscuro") !== -1;

      if (esBotonTema) {
        btn.style.setProperty("border-radius", "8px", "important");
        btn.style.setProperty("width", "100%", "important");
        btn.style.setProperty("min-width", "0", "important");
        btn.style.setProperty("max-width", "100%", "important");
        btn.style.setProperty("height", "auto", "important");
        btn.style.setProperty("min-height", "38px", "important");
        btn.style.setProperty("max-height", "none", "important");
        btn.style.setProperty("flex", "none", "important");
        btn.style.setProperty("padding", "8px 12px", "important");
        return;
      }

      if (txt.length > 0) return;
      var rect = btn.getBoundingClientRect();
      if (rect.width > 0 && rect.height > 0 && Math.abs(rect.width - rect.height) > 2) {
        var size = Math.round(Math.min(rect.width, rect.height, 44));
        if (size < 28) size = 38;
        btn.style.setProperty("width", size + "px", "important");
        btn.style.setProperty("height", size + "px", "important");
        btn.style.setProperty("min-width", size + "px", "important");
        btn.style.setProperty("max-width", size + "px", "important");
        btn.style.setProperty("min-height", size + "px", "important");
        btn.style.setProperty("max-height", size + "px", "important");
        btn.style.setProperty("flex", "0 0 " + size + "px", "important");
        btn.style.setProperty("padding", "0", "important");
        btn.style.setProperty("border-radius", "50%", "important");
        btn.style.setProperty("display", "inline-flex", "important");
        btn.style.setProperty("align-items", "center", "important");
        btn.style.setProperty("justify-content", "center", "important");
      }
    });
  }
  fijarBotonesSidebar();
  document.addEventListener("DOMContentLoaded", function () {
    fijarBotonesSidebar();
    setTimeout(fijarBotonesSidebar, 150);
    setTimeout(fijarBotonesSidebar, 500);
  });
  window.addEventListener("load", fijarBotonesSidebar);
  document.addEventListener("click", function () {
    setTimeout(fijarBotonesSidebar, 60);
    setTimeout(fijarBotonesSidebar, 200);
  });
})();
</script>
<!-- FIX_BURGER_CIRCLE_END -->
