
@extends('layouts.app')

@section('template_title')
    {{ strtoupper($ubicacione->nombre) }} - UBICACIONES
@endsection

@section('content')
<style>
    .ubicacion-detalle {
        color: #263445;
    }

    .ubicacion-header {
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

    .ubicacion-header h2 {
        font-size: 24px;
        font-weight: 700;
        margin: 0 0 6px;
        color: #243247;
    }

    .ubicacion-subtitulo {
        color: #718096;
        font-size: 13px;
        margin: 0;
    }

    .ubicacion-panel {
        background: #fff;
        border: 1px solid #e5e9ef;
        border-radius: 12px;
        margin-bottom: 22px;
        overflow: hidden;
    }

    .ubicacion-panel-header {
        padding: 17px 22px;
        border-bottom: 1px solid #e9edf2;
    }

    .ubicacion-panel-header h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #263445;
    }

    .ubicacion-panel-body {
        padding: 22px;
    }

    .ubicacion-card {
        height: 100%;
        padding: 20px;
        background: #fff;
        border: 1px solid #e5e9ef;
        border-radius: 12px;
        border-left: 4px solid #64748b;
    }

    .ubicacion-card.total {
        border-left-color: #2563eb;
    }

    .ubicacion-card.bueno {
        border-left-color: #16a34a;
    }

    .ubicacion-card.regular {
        border-left-color: #d97706;
    }

    .ubicacion-card.malogrado {
        border-left-color: #dc2626;
    }

    .ubicacion-card.dados-baja {
        border-left-color: #7c3aed;
    }

    .ubicacion-card-etiqueta {
        color: #718096;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .4px;
    }

    .ubicacion-card-numero {
        font-size: 30px;
        font-weight: 800;
        margin-top: 8px;
        line-height: 1.2;
        color: #263445;
    }

    .ubicacion-barra-fondo {
        height: 10px;
        background: #edf0f4;
        border-radius: 20px;
        overflow: hidden;
    }

    .ubicacion-barra {
        height: 100%;
        border-radius: 20px;
    }

    .ubicacion-barra.bueno {
        background: #16a34a;
    }

    .ubicacion-barra.regular {
        background: #d97706;
    }

    .ubicacion-barra.malogrado {
        background: #dc2626;
    }

    .ubicacion-barra.pendiente {
        background: #64748b;
    }

    .ubicacion-estado-fila {
        margin-bottom: 22px;
    }

    .ubicacion-estado-fila:last-child {
        margin-bottom: 0;
    }

    .ubicacion-estado-detalle {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
        font-size: 13px;
    }

    .ubicacion-tabla {
        margin: 0;
        width: 100%;
    }

    .ubicacion-tabla thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .4px;
        white-space: nowrap;
        border-bottom: 1px solid #e5e9ef;
        padding: 14px 16px;
    }

    .ubicacion-tabla tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        font-size: 13px;
        border-color: #edf0f4;
    }

    .ubicacion-tabla tbody tr:hover {
        background: #fafcff;
    }

    .ubicacion-badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .ubicacion-badge.bueno {
        color: #166534;
        background: #dcfce7;
    }

    .ubicacion-badge.regular {
        color: #92400e;
        background: #fef3c7;
    }

    .ubicacion-badge.malogrado {
        color: #991b1b;
        background: #fee2e2;
    }

    .ubicacion-badge.pendiente {
        color: #475569;
        background: #e2e8f0;
    }

    .ubicacion-vacio {
        padding: 35px 20px;
        text-align: center;
        color: #718096;
    }

    .ubicacion-vacio strong {
        display: block;
        color: #334155;
        margin-bottom: 5px;
    }

    @media (max-width: 767px) {
        .ubicacion-header {
            padding: 18px;
        }

        .ubicacion-header h2 {
            font-size: 21px;
        }

        .ubicacion-panel-body {
            padding: 16px;
        }

        .ubicacion-card {
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

        #ubicacion-ficha-print,
        #ubicacion-ficha-print * {
            visibility: visible;
        }

        #ubicacion-ficha-print {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        .ubicacion-no-imprimir {
            display: none !important;
        }

        .ubicacion-panel,
        .ubicacion-card,
        .ubicacion-header {
            break-inside: avoid;
            box-shadow: none !important;
        }

        .ubicacion-tabla thead th,
        .ubicacion-barra-fondo,
        .ubicacion-badge {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
</style>

<section class="content container-fluid ubicacion-detalle">

    {{-- CONTENIDO QUE SE IMPRIME --}}
    <div id="ubicacion-ficha-print">

        {{-- ENCABEZADO --}}
        <div class="ubicacion-header">
            <div>
                <h2>{{ strtoupper($ubicacione->nombre) }}</h2>

                <p class="ubicacion-subtitulo">
                    DETALLE DE UBICACIÓN Y ESTADO DE LOS EQUIPOS
                </p>

                <p class="ubicacion-subtitulo" style="margin-top: 7px;">
                    Tipo: {{ strtoupper($ubicacione->tipo ?? 'SIN TIPO') }}
                    &nbsp;|&nbsp;
                    Código: {{ $ubicacione->id }}
                    &nbsp;|&nbsp;
                    Fecha del reporte: {{ now()->format('d/m/Y') }}
                </p>
            </div>

            <div class="ubicacion-no-imprimir">
                <button type="button"
                        class="btn btn-secondary"
                        onclick="window.print()">
                    <i class="fas fa-print"></i> IMPRIMIR
                </button>
            </div>
        </div>

        
        {{-- TARJETAS DE RESUMEN --}}
        <div class="row mb-4">
            <div class="col-6 col-lg-4 mb-3">
                <div class="ubicacion-card total">
                    <div class="ubicacion-card-etiqueta">EQUIPOS EN INVENTARIO</div>
                    <div class="ubicacion-card-numero">{{ $totalEquipos }}</div>
                    <div class="ubicacion-subtitulo">Asignados y vigentes en esta ubicación</div>
                </div>
            </div>

            <div class="col-6 col-lg-4 mb-3">
                <div class="ubicacion-card bueno">
                    <div class="ubicacion-card-etiqueta">BUENOS</div>
                    <div class="ubicacion-card-numero">{{ $buenos }}</div>
                    <div class="ubicacion-subtitulo">En buen estado</div>
                </div>
            </div>

            <div class="col-6 col-lg-4 mb-3">
                <div class="ubicacion-card regular">
                    <div class="ubicacion-card-etiqueta">REGULARES</div>
                    <div class="ubicacion-card-numero">{{ $regulares }}</div>
                    <div class="ubicacion-subtitulo">Requieren seguimiento</div>
                </div>
            </div>

            <div class="col-6 col-lg-4 mb-3">
                <div class="ubicacion-card malogrado">
                    <div class="ubicacion-card-etiqueta">MALOGRADOS</div>
                    <div class="ubicacion-card-numero">{{ $malogrados }}</div>
                    <div class="ubicacion-subtitulo">Requieren revisión</div>
                </div>
            </div>

            <div class="col-6 col-lg-4 mb-3">
                <div class="ubicacion-card dados-baja">
                    <div class="ubicacion-card-etiqueta">
                        <i class="fas fa-box-archive me-1"></i>
                        EQUIPOS DADOS DE BAJA
                    </div>
                    <div class="ubicacion-card-numero">{{ $equiposDadosBaja }}</div>
                    <div class="ubicacion-subtitulo">Fuera del inventario vigente</div>
                </div>
            </div>
        </div>


        {{-- DISTRIBUCIÓN POR ESTADO --}}
        <div class="ubicacion-panel">
            <div class="ubicacion-panel-header">
                <h4>ESTADO GENERAL DE LOS EQUIPOS</h4>
            </div>

            <div class="ubicacion-panel-body">
                @if ($totalEquipos === 0)
                    <div class="ubicacion-vacio">
                        <strong>Esta ubicación no tiene equipos</strong>
                        Los equipos que se asignen a esta ubicación aparecerán aquí.
                    </div>
                @else
                    <div class="ubicacion-estado-fila">
                        <div class="ubicacion-estado-detalle">
                            <strong>BUENOS</strong>
                            <span>{{ $buenos }} equipos ({{ $porcentajeBueno }}%)</span>
                        </div>
                        <div class="ubicacion-barra-fondo">
                            <div class="ubicacion-barra bueno"
                                 style="width: {{ $porcentajeBueno }}%;"></div>
                        </div>
                    </div>

                    <div class="ubicacion-estado-fila">
                        <div class="ubicacion-estado-detalle">
                            <strong>REGULARES</strong>
                            <span>{{ $regulares }} equipos ({{ $porcentajeRegular }}%)</span>
                        </div>
                        <div class="ubicacion-barra-fondo">
                            <div class="ubicacion-barra regular"
                                 style="width: {{ $porcentajeRegular }}%;"></div>
                        </div>
                    </div>

                    <div class="ubicacion-estado-fila">
                        <div class="ubicacion-estado-detalle">
                            <strong>MALOGRADOS</strong>
                            <span>{{ $malogrados }} equipos ({{ $porcentajeMalogrado }}%)</span>
                        </div>
                        <div class="ubicacion-barra-fondo">
                            <div class="ubicacion-barra malogrado"
                                 style="width: {{ $porcentajeMalogrado }}%;"></div>
                        </div>
                    </div>

                    @if ($sinClasificar > 0)
                        <div class="ubicacion-estado-fila">
                            <div class="ubicacion-estado-detalle">
                                <strong>SIN CLASIFICAR</strong>
                                <span>{{ $sinClasificar }} equipos ({{ $porcentajeSinClasificar }}%)</span>
                            </div>
                            <div class="ubicacion-barra-fondo">
                                <div class="ubicacion-barra pendiente"
                                     style="width: {{ $porcentajeSinClasificar }}%;"></div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        {{-- TABLA DE EQUIPOS --}}
        <div class="ubicacion-panel">
            <div class="ubicacion-panel-header d-flex justify-content-between align-items-center flex-wrap"
                 style="gap: 10px;">
                <h4>EQUIPOS ASIGNADOS A ESTA UBICACIÓN</h4>

                <span class="ubicacion-subtitulo">
                    Total de registros: {{ $totalEquipos }}
                </span>
            </div>

            @if ($equipos->isEmpty())
                <div class="ubicacion-vacio">
                    <strong>No hay equipos para mostrar</strong>
                    Cuando se asignen equipos a esta ubicación, aparecerán aquí.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table ubicacion-tabla">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tipo de equipo</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>N.º de serie</th>
                                <th>Fecha de registro</th>
                                <th>Estado</th>
                                <th class="ubicacion-no-imprimir">Ficha</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($equipos as $equipo)
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
                                    <td><strong>#{{ $equipo->id }}</strong></td>

                                    <td>
                                        {{ strtoupper($equipo->tipoEquipo->nombre ?? 'SIN TIPO') }}
                                    </td>

                                    <td>
                                        {{ strtoupper($equipo->marca ?? 'SIN MARCA') }}
                                    </td>

                                    <td>
                                        {{ strtoupper($equipo->modelo ?? 'SIN MODELO') }}
                                    </td>

                                    <td>
                                        {{ $equipo->num_serie ?: 'SIN SERIE' }}
                                    </td>

                                    <td>
                                        {{ $equipo->fecha_registro
                                            ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('d/m/Y')
                                            : 'SIN FECHA' }}
                                    </td>

                                    <td>
                                        <span class="ubicacion-badge {{ $claseEstado }}">
                                            {{ $estadoEquipo }}
                                        </span>
                                    </td>

                                    <td class="ubicacion-no-imprimir">
                                        <a href="{{ route('equipos.show', $equipo->id) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> VER
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <p class="ubicacion-subtitulo text-right">
            INVENTARIO 2026 - REPORTE DE UBICACIÓN
        </p>
    </div>

    {{-- VOLVER ABAJO A LA IZQUIERDA --}}
    <div class="ubicacion-no-imprimir mt-3 mb-4">
        <a href="{{ route('ubicaciones.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> VOLVER
        </a>
    </div>

</section>@endsection
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
<!-- FIX_UB_DARK_4_START -->
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
<!-- FIX_UB_DARK_4_END -->

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
