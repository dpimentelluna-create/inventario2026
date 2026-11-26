@extends('layouts.app')

@section('template_title')
    {{ strtoupper($tiposEquipo->nombre) }} - TIPOS DE EQUIPOS
@endsection

@section('content')
    <style>
        .tipo-detalle {
            color: #263445;
        }

        .tipo-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            padding: 22px 24px;
            background: #fff;
            border: 1px solid #e5e9ef;
            border-radius: 12px;
            margin-bottom: 22px;
        }

        .tipo-header h2 {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 5px;
            color: #243247;
        }

        .tipo-subtitulo {
            color: #718096;
            font-size: 13px;
            margin: 0;
        }

        .tipo-panel {
            background: #fff;
            border: 1px solid #e5e9ef;
            border-radius: 12px;
            margin-bottom: 22px;
            overflow: hidden;
        }

        .tipo-panel-header {
            padding: 17px 22px;
            border-bottom: 1px solid #e9edf2;
        }

        .tipo-panel-header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #263445;
        }

        .tipo-panel-body {
            padding: 22px;
        }

        .tipo-card {
            height: 100%;
            padding: 20px;
            background: #fff;
            border: 1px solid #e5e9ef;
            border-radius: 12px;
            border-left: 4px solid #64748b;
        }

        .tipo-card.total {
            border-left-color: #2563eb;
        }

        .tipo-card.bueno {
            border-left-color: #16a34a;
        }

        .tipo-card.regular {
            border-left-color: #d97706;
        }

        .tipo-card.malogrado {
            border-left-color: #dc2626;
        }

        .tipo-card.dados-baja {
            border-left-color: #7c3aed;
        }

        .tipo-card-etiqueta {
            color: #718096;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .tipo-card-numero {
            font-size: 30px;
            font-weight: 800;
            margin-top: 8px;
            line-height: 1.2;
            color: #263445;
        }

        .tipo-barra-fondo {
            height: 10px;
            background: #edf0f4;
            border-radius: 20px;
            overflow: hidden;
        }

        .tipo-barra {
            height: 100%;
            border-radius: 20px;
            min-width: 0;
        }

        .tipo-barra.bueno {
            background: #16a34a;
        }

        .tipo-barra.regular {
            background: #d97706;
        }

        .tipo-barra.malogrado {
            background: #dc2626;
        }

        .tipo-barra.pendiente {
            background: #64748b;
        }

        .tipo-estado-fila {
            margin-bottom: 22px;
        }

        .tipo-estado-fila:last-child {
            margin-bottom: 0;
        }

        .tipo-estado-detalle {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .tipo-tabla {
            margin: 0;
            width: 100%;
        }

        .tipo-tabla thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .4px;
            white-space: nowrap;
            border-bottom: 1px solid #e5e9ef;
            padding: 14px 16px;
        }

        .tipo-tabla tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            font-size: 13px;
            border-color: #edf0f4;
        }

        .tipo-tabla tbody tr:hover {
            background: #fafcff;
        }

        .tipo-marca {
            font-weight: 700;
            color: #263445;
        }

        .tipo-serie {
            color: #64748b;
            font-size: 12px;
        }

        .tipo-badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .tipo-badge.bueno {
            color: #166534;
            background: #dcfce7;
        }

        .tipo-badge.regular {
            color: #92400e;
            background: #fef3c7;
        }

        .tipo-badge.malogrado {
            color: #991b1b;
            background: #fee2e2;
        }

        .tipo-badge.pendiente {
            color: #475569;
            background: #e2e8f0;
        }

        .tipo-vacio {
            padding: 35px 20px;
            text-align: center;
            color: #718096;
        }

        .tipo-vacio strong {
            display: block;
            color: #334155;
            margin-bottom: 5px;
        }

        @media (max-width: 767px) {
            .tipo-panel-body {
                padding: 16px;
            }

            .tipo-header {
                padding: 18px;
            }

            .tipo-header h2 {
                font-size: 21px;
            }

            .tipo-card {
                padding: 16px;
            }
        }

        @media print {
            @page {
                size: A4 landscape;
                margin: 12mm;
            }

            body {
                background: #fff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body * {
                visibility: hidden;
            }

            #tipo-equipo-print,
            #tipo-equipo-print * {
                visibility: visible;
            }

            #tipo-equipo-print {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .tipo-acciones,
            .tipo-no-imprimir {
                display: none !important;
            }

            .tipo-panel,
            .tipo-card,
            .tipo-header {
                break-inside: avoid;
                box-shadow: none !important;
            }

            .tipo-tabla thead th,
            .tipo-barra-fondo,
            .tipo-badge {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>

    <section class="content container-fluid tipo-detalle">
        <div id="tipo-equipo-print">

            {{-- ENCABEZADO --}}
            <div class="tipo-header">
                <div>
                    <h2>{{ strtoupper($tiposEquipo->nombre) }}</h2>
                    <p class="tipo-subtitulo">
                        RESUMEN DE INVENTARIO Y ESTADO GENERAL DE LOS EQUIPOS
                    </p>
                    <p class="tipo-subtitulo" style="margin-top: 7px;">
                        Código del tipo: {{ $tiposEquipo->id }}
                        &nbsp;|&nbsp;
                        Fecha del reporte: {{ now()->format('d/m/Y') }}
                    </p>
                </div>

                <div class="tipo-acciones">
                    <button type="button" class="btn btn-secondary" onclick="window.print()">
                        <i class="fas fa-print"></i> IMPRIMIR
                    </button>
                </div>
            </div>

            {{-- TARJETAS DE RESUMEN --}}
            <div class="row mb-4">
                <div class="col-6 col-lg-4 mb-3">
                    <div class="tipo-card total">
                        <div class="tipo-card-etiqueta">Equipos en inventario</div>
                        <div class="tipo-card-numero">{{ $totalEquipos }}</div>
                        <div class="tipo-subtitulo">Registrados y vigentes en este tipo</div>
                    </div>
                </div>

                <div class="col-6 col-lg-4 mb-3">
                    <div class="tipo-card bueno">
                        <div class="tipo-card-etiqueta">BUENOS</div>
                        <div class="tipo-card-numero">{{ $buenos }}</div>
                        <div class="tipo-subtitulo">En buen estado</div>
                    </div>
                </div>

                <div class="col-6 col-lg-4 mb-3">
                    <div class="tipo-card regular">
                        <div class="tipo-card-etiqueta">REGULARES</div>
                        <div class="tipo-card-numero">{{ $regulares }}</div>
                        <div class="tipo-subtitulo">Requieren seguimiento</div>
                    </div>
                </div>

                <div class="col-6 col-lg-4 mb-3">
                    <div class="tipo-card malogrado">
                        <div class="tipo-card-etiqueta">MALOGRADOS</div>
                        <div class="tipo-card-numero">{{ $malogrados }}</div>
                        <div class="tipo-subtitulo">Requieren revisión</div>
                    </div>
                </div>

                <div class="col-6 col-lg-4 mb-3">
                    <div class="tipo-card dados-baja">
                        <div class="tipo-card-etiqueta">
                            <i class="fas fa-box-archive me-1"></i>
                            EQUIPOS DADOS DE BAJA
                        </div>
                        <div class="tipo-card-numero">{{ $equiposDadosBaja }}</div>
                        <div class="tipo-subtitulo">Fuera del inventario vigente</div>
                    </div>
                </div>
            </div>

            {{-- DISTRIBUCIÓN DE ESTADOS --}}
            <div class="tipo-panel">
                <div class="tipo-panel-header">
                    <h4>ESTADO GENERAL DE LOS EQUIPOS</h4>
                </div>

                <div class="tipo-panel-body">
                    @if ($totalEquipos === 0)
                        <div class="tipo-vacio">
                            <strong>Sin equipos registrados</strong>
                            Todavía no hay equipos asociados a este tipo.
                        </div>
                    @else
                        <div class="tipo-estado-fila">
                            <div class="tipo-estado-detalle">
                                <span><strong>BUENOS</strong></span>
                                <span>{{ $buenos }} equipos ({{ $porcentajeBueno }}%)</span>
                            </div>
                            <div class="tipo-barra-fondo">
                                <div class="tipo-barra bueno" style="width: {{ $porcentajeBueno }}%;"></div>
                            </div>
                        </div>

                        <div class="tipo-estado-fila">
                            <div class="tipo-estado-detalle">
                                <span><strong>REGULARES</strong></span>
                                <span>{{ $regulares }} equipos ({{ $porcentajeRegular }}%)</span>
                            </div>
                            <div class="tipo-barra-fondo">
                                <div class="tipo-barra regular" style="width: {{ $porcentajeRegular }}%;"></div>
                            </div>
                        </div>

                        <div class="tipo-estado-fila">
                            <div class="tipo-estado-detalle">
                                <span><strong>MALOGRADOS</strong></span>
                                <span>{{ $malogrados }} equipos ({{ $porcentajeMalogrado }}%)</span>
                            </div>
                            <div class="tipo-barra-fondo">
                                <div class="tipo-barra malogrado" style="width: {{ $porcentajeMalogrado }}%;"></div>
                            </div>
                        </div>

                        @if ($sinClasificar > 0)
                            <div class="tipo-estado-fila">
                                <div class="tipo-estado-detalle">
                                    <span><strong>SIN CLASIFICAR</strong></span>
                                    <span>{{ $sinClasificar }} equipos ({{ $porcentajeSinClasificar }}%)</span>
                                </div>
                                <div class="tipo-barra-fondo">
                                    <div class="tipo-barra pendiente" style="width: {{ $porcentajeSinClasificar }}%;"></div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            {{-- ÚLTIMOS CINCO EQUIPOS --}}
            <div class="tipo-panel">
                <div class="tipo-panel-header d-flex justify-content-between align-items-center flex-wrap"
                    style="gap: 10px;">
                    <h4>ÚLTIMOS 5 EQUIPOS REGISTRADOS</h4>
                    <span class="tipo-subtitulo">
                        Registros más recientes de {{ strtoupper($tiposEquipo->nombre) }}
                    </span>
                </div>

                @if ($ultimosEquipos->isEmpty())
                    <div class="tipo-vacio">
                        <strong>No hay equipos para mostrar</strong>
                        Cuando registres equipos de este tipo, aparecerán aquí.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table tipo-tabla">
                            <thead>
                                <tr>
                                    <th>Equipo</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>N.º de serie</th>
                                    <th>Fecha de registro</th>
                                    <th>Estado</th>
                                    <th class="tipo-no-imprimir">Ficha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ultimosEquipos as $equipo)
                                                @php
                                                    $estadoEquipo = $equipo->especificacionesLaptops?->estado
                                                        ?: $equipo->especificacionesEquipo?->estado
                                                        ?: 'SIN CLASIFICAR';

                                                    $estadoEquipo = strtoupper(trim($estadoEquipo));

                                                    $claseEstado = match ($estadoEquipo) {
                                                        'BUENO' => 'bueno',
                                                        'REGULAR' => 'regular',
                                                        'MALOGRADO' => 'malogrado',
                                                        default => 'pendiente',
                                                    };
                                                @endphp

                                                <tr>
                                                    <td>
                                                        <strong>#{{ $equipo->id }}</strong>
                                                    </td>

                                                    <td>
                                                        <span class="tipo-marca">
                                                            {{ strtoupper($equipo->marca ?? 'SIN MARCA') }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        {{ strtoupper($equipo->modelo ?? 'SIN MODELO') }}
                                                    </td>

                                                    <td>
                                                        <span class="tipo-serie">
                                                            {{ $equipo->num_serie ?: 'SIN SERIE' }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        {{ $equipo->fecha_registro
                                    ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('d/m/Y')
                                    : 'SIN FECHA' }}
                                                    </td>

                                                    <td>
                                                        <span class="tipo-badge {{ $claseEstado }}">
                                                            {{ $estadoEquipo }}
                                                        </span>
                                                    </td>

                                                    <td class="tipo-no-imprimir">
                                                        <a href="{{ route('equipos.show', $equipo->id) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            VER FICHA
                                                        </a>
                                                    </td>
                                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <p class="tipo-subtitulo text-right">
                INVENTARIO 2026 - REPORTE DE TIPOS DE EQUIPOS
            </p>

            <div class="tipo-acciones mt-3 mb-4">
                <a href="{{ route('tipos-equipo.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> VOLVER
                </a>

            </div>
        </div>
    </section>@endsection
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
<!-- FIX_TE_SHOW_DARK_START -->
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
<!-- FIX_TE_SHOW_DARK_END -->
