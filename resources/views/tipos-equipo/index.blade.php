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
                <th>CANTIDAD DE EQUIPOS</th>
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
</div>@endsection

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
<script id="fix-tipo-cantidad-equipos">
document.addEventListener("DOMContentLoaded", function() {
  const counts = @json(\App\Models\Equipo::selectRaw("tipo_equipo_id, COUNT(*) as total")->groupBy("tipo_equipo_id")->pluck("total", "tipo_equipo_id"));
  const table = document.querySelector("table");
  if (!table) return;
  const headers = Array.from(table.querySelectorAll("thead th"));
  const nombreIdx = headers.findIndex(th => th.innerText.trim().toUpperCase() === "NOMBRE");
  if (nombreIdx === -1) return;

  table.querySelectorAll("tbody tr").forEach(tr => {
    const tds = Array.from(tr.children);
    if (!tds.length) return;
    const id = tds[0].innerText.trim();
    const qty = counts[id] ?? 0;
    const td = document.createElement("td");
    td.innerText = qty;
    if (tds[nombreIdx + 1]) {
      tr.insertBefore(td, tds[nombreIdx + 1]);
    } else {
      tr.appendChild(td);
    }
  });
});
</script>

<script id="fix-tipo-cantidad-order">
(function() {
  function aplicarOrdenMayorAMenor() {
    const table = document.querySelector("table");
    if (!table) return false;

    const headers = Array.from(table.querySelectorAll("thead th"));
    const qtyIdx = headers.findIndex(th => th.innerText.trim().toUpperCase().includes("CANTIDAD"));
    if (qtyIdx === -1) return false;

    table.querySelectorAll("tbody tr").forEach(tr => {
      const td = tr.children[qtyIdx];
      if (td) {
        const val = parseInt(td.innerText.replace(/[^0-9-]/g, ""), 10) || 0;
        td.setAttribute("data-order", val);
      }
    });

    if (window.jQuery && $.fn && $.fn.DataTable && $.fn.DataTable.isDataTable(table)) {
      const dt = $(table).DataTable();
      const current = dt.order();
      if (!current.length || current[0][0] !== qtyIdx || current[0][1] !== "desc") {
        dt.order([qtyIdx, "desc"]).draw();
      }
      return true;
    }
    return false;
  }

  document.addEventListener("DOMContentLoaded", function() {
    if (!aplicarOrdenMayorAMenor()) {
      let intentos = 0;
      const timer = setInterval(function() {
        intentos++;
        if (aplicarOrdenMayorAMenor() || intentos >= 20) {
          clearInterval(timer);
        }
      }, 100);
    }
  });
})();
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
<!-- FIX_TE_INDEX_DARK_START -->
<style id="te-dark-common-style">
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
<script id="te-dark-common-script">
(function () {
  function esOscuroTe() {
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

  function fijarTeDark() {
    var oscuro = esOscuroTe();
    var body = document.body;
    if (!body) return;

    // 1. Contenedores/tarjetas claros -> oscuro en Modo Oscuro (fuera de tablas y sidebar)
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
        el.dataset.teDarkBg = "1";
        var isPill = el.tagName === "BUTTON" || el.classList.contains("btn") || el.classList.contains("badge") || el.closest("button, .btn");
        el.style.setProperty("background-color", isPill ? "#1e293b" : "#111827", "important");
        el.style.setProperty("border-color", "#334155", "important");
        el.style.setProperty("color", "#f8fafc", "important");
        el.style.setProperty("-webkit-text-fill-color", "#f8fafc", "important");
      } else if (!oscuro && el.dataset.teDarkBg === "1") {
        delete el.dataset.teDarkBg;
        el.style.removeProperty("background-color");
        el.style.removeProperty("border-color");
        el.style.removeProperty("color");
        el.style.removeProperty("-webkit-text-fill-color");
      }
    });

    // 2. Textos, etiquetas y encabezados visibles en Modo Oscuro
    body.querySelectorAll("h1, h2, h3, h4, h5, h6, p, span, small, label, strong, b, div, i, svg").forEach(function (el) {
      if (el.closest("table, nav, aside, .sidebar")) return;
      if (el.closest("a, button, .btn")) return;
      if (el.querySelector("div, p, h1, h2, h3, h4, h5, h6, table, input, select, textarea")) return;
      var t = (el.textContent || "").trim();
      if (!t && el.tagName !== "I" && el.tagName !== "SVG") return;

      var esSecundario =
        t.indexOf("RESUMEN DE INVENTARIO") !== -1 ||
        t.indexOf("Código del tipo") !== -1 ||
        t.indexOf("Codigo del tipo") !== -1 ||
        t.indexOf("Registrados y vigentes") !== -1 ||
        t.indexOf("En buen estado") !== -1 ||
        t.indexOf("Requieren seguimiento") !== -1 ||
        t.indexOf("Requieren revisión") !== -1 ||
        t.indexOf("Requieren revision") !== -1 ||
        t.indexOf("Fuera del inventario") !== -1 ||
        el.classList.contains("text-muted");

      if (oscuro) {
        el.dataset.teDarkFg = "1";
        var fg = esSecundario ? "#cbd5e1" : "#f8fafc";
        el.style.setProperty("color", fg, "important");
        el.style.setProperty("-webkit-text-fill-color", fg, "important");
        el.style.setProperty("fill", fg, "important");
        el.style.setProperty("opacity", "1", "important");
        el.style.setProperty("visibility", "visible", "important");
      } else if (el.dataset.teDarkFg === "1") {
        delete el.dataset.teDarkFg;
        el.style.removeProperty("color");
        el.style.removeProperty("-webkit-text-fill-color");
        el.style.removeProperty("fill");
        el.style.removeProperty("opacity");
        el.style.removeProperty("visibility");
      }
    });

    // 3. Inputs, selects y textareas
    body.querySelectorAll("input, select, textarea").forEach(function (inp) {
      if (inp.closest("nav, aside, .sidebar")) return;
      if (oscuro) {
        inp.dataset.teDarkInp = "1";
        inp.style.setProperty("color", "#f8fafc", "important");
        inp.style.setProperty("-webkit-text-fill-color", "#f8fafc", "important");
      } else if (inp.dataset.teDarkInp === "1") {
        delete inp.dataset.teDarkInp;
        inp.style.removeProperty("color");
        inp.style.removeProperty("-webkit-text-fill-color");
      }
    });

    // 4. Cuadraditos de ACCIONES siempre legibles
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

  fijarTeDark();
  document.addEventListener("DOMContentLoaded", function () {
    fijarTeDark();
    setTimeout(fijarTeDark, 150);
    setTimeout(fijarTeDark, 500);
    setTimeout(fijarTeDark, 1000);
  });
  window.addEventListener("load", function () {
    fijarTeDark();
    setTimeout(fijarTeDark, 300);
  });
  document.addEventListener("click", function () {
    setTimeout(fijarTeDark, 60);
    setTimeout(fijarTeDark, 250);
  });
  document.addEventListener("input", function () {
    setTimeout(fijarTeDark, 40);
  });
})();
</script>
<!-- FIX_TE_INDEX_DARK_END -->
