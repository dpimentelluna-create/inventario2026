
@extends('layouts.app')

@section('template_title')
    Solicitante {{ $docente->id }} - {{ strtoupper($docente->apellidos . ' ' . $docente->nombres) }}
@endsection

@section('content')
<style>
    .solicitante-contenedor {
        max-width: 1200px;
        margin: 0 auto;
        padding-bottom: 25px;
    }

    .solicitante-encabezado {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .solicitante-encabezado h2 {
        font-size: 25px;
        font-weight: 700;
        margin: 0 0 5px;
        color: #212529;
    }

    .solicitante-subtitulo {
        color: #6c757d;
        font-size: 14px;
        margin: 0;
    }

    .solicitante-panel {
        background: #fff;
        border: 1px solid #dee2e6;
        border-left: 5px solid #0d6efd;
        border-radius: 10px;
        box-shadow: 0 3px 12px rgba(0,0,0,.05);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .solicitante-panel-cuerpo {
        padding: 24px;
    }

    .solicitante-titulo-seccion {
        font-size: 17px;
        font-weight: 700;
        color: #343a40;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 10px;
        margin: 0 0 18px;
    }

    .solicitante-datos {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px 24px;
    }

    .solicitante-dato {
        min-width: 0;
    }

    .solicitante-dato strong {
        display: block;
        font-size: 12px;
        color: #6c757d;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .solicitante-dato p {
        margin: 0;
        color: #212529;
        font-size: 14px;
        overflow-wrap: anywhere;
    }

    .solicitante-resumen {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .solicitante-resumen-item {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 17px;
        background: #f8f9fa;
    }

    .solicitante-resumen-item span {
        display: block;
        color: #6c757d;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 7px;
    }

    .solicitante-resumen-item strong {
        font-size: 25px;
        color: #212529;
    }

    .solicitante-resumen-item.activos {
        border-left: 4px solid #198754;
    }

    .solicitante-resumen-item.terminados {
        border-left: 4px solid #6c757d;
    }

    .solicitante-tabla-contenedor {
        width: 100%;
        overflow-x: auto;
    }

    .solicitante-tabla {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .solicitante-tabla th {
        background: #f1f3f5;
        color: #343a40;
        text-align: left;
        padding: 10px 8px;
        border: 1px solid #dee2e6;
        white-space: nowrap;
    }

    .solicitante-tabla td {
        padding: 9px 8px;
        border: 1px solid #dee2e6;
        vertical-align: top;
        overflow-wrap: anywhere;
    }

    .solicitante-tabla tbody tr:nth-child(even) {
        background: #fafafa;
    }

    .prestamo-estado {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .prestamo-estado-activo {
        color: #0f5132;
        background: #d1e7dd;
    }

    .prestamo-estado-terminado {
        color: #41464b;
        background: #e2e3e5;
    }

    .prestamo-estado-otro {
        color: #664d03;
        background: #fff3cd;
    }

    .solicitante-vacio {
        padding: 25px;
        text-align: center;
        border: 1px dashed #ced4da;
        border-radius: 8px;
        color: #6c757d;
        background: #f8f9fa;
    }

    .solicitante-acciones {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .solicitante-datos {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .solicitante-panel-cuerpo {
            padding: 16px;
        }
    }

    @media (max-width: 480px) {
        .solicitante-datos {
            grid-template-columns: 1fr;
        }

        .solicitante-resumen {
            gap: 8px;
        }

        .solicitante-resumen-item {
            padding: 10px;
        }

        .solicitante-resumen-item strong {
            font-size: 21px;
        }
    }

    @page {
        size: A4 landscape;
        margin: 9mm;
    }

    @media print {
        html, body {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #fff !important;
        }

        body * {
            visibility: hidden !important;
        }

        #solicitante-ficha-print,
        #solicitante-ficha-print * {
            visibility: visible !important;
        }

        #solicitante-ficha-print {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        #solicitante-ficha-print .no-print {
            display: none !important;
        }

        #solicitante-ficha-print .solicitante-panel {
            box-shadow: none !important;
            border-radius: 0 !important;
            overflow: visible !important;
            margin-bottom: 10px !important;
            break-inside: auto;
        }

        #solicitante-ficha-print .solicitante-panel-cuerpo {
            padding: 12px !important;
        }

        #solicitante-ficha-print .solicitante-encabezado {
            margin-bottom: 10px !important;
        }

        #solicitante-ficha-print .solicitante-encabezado h2 {
            font-size: 19px !important;
        }

        #solicitante-ficha-print .solicitante-resumen {
            gap: 8px !important;
            margin-bottom: 12px !important;
        }

        #solicitante-ficha-print .solicitante-resumen-item {
            padding: 9px !important;
        }

        #solicitante-ficha-print .solicitante-resumen-item strong {
            font-size: 18px !important;
        }

        #solicitante-ficha-print .solicitante-titulo-seccion {
            margin-bottom: 10px !important;
            font-size: 14px !important;
        }

        #solicitante-ficha-print .solicitante-datos {
            gap: 10px 16px !important;
        }

        #solicitante-ficha-print .solicitante-tabla-contenedor {
            overflow: visible !important;
        }

        #solicitante-ficha-print .solicitante-tabla {
            width: 100% !important;
            font-size: 9px !important;
            table-layout: fixed;
        }

        #solicitante-ficha-print .solicitante-tabla th,
        #solicitante-ficha-print .solicitante-tabla td {
            padding: 5px 4px !important;
            white-space: normal !important;
            overflow-wrap: anywhere !important;
        }

        #solicitante-ficha-print .solicitante-tabla thead {
            display: table-header-group;
        }

        #solicitante-ficha-print .solicitante-tabla tr {
            break-inside: avoid;
            page-break-inside: avoid;
        }

        #solicitante-ficha-print .prestamo-estado {
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }
    }
</style>

<section class="content container-fluid solicitante-contenedor"
         id="solicitante-ficha-print">

    {{-- ENCABEZADO --}}
    <div class="solicitante-encabezado">
        <div>
            <h2>FICHA DEL SOLICITANTE</h2>
            <p class="solicitante-subtitulo">
                Datos personales e historial de préstamos registrados.
            </p>
        </div>

        <button type="button"
                class="btn btn-primary no-print"
                onclick="window.print()">
            <i class="bi bi-printer"></i> IMPRIMIR FICHA
        </button>
    </div>

    {{-- DATOS DEL SOLICITANTE --}}
    <div class="solicitante-panel">
        <div class="solicitante-panel-cuerpo">
            <h4 class="solicitante-titulo-seccion">
                DATOS DEL SOLICITANTE
            </h4>

            <div class="solicitante-datos">
                <div class="solicitante-dato">
                    <strong>Nombres</strong>
                    <p>{{ $docente->nombres ?: 'NO REGISTRADOS' }}</p>
                </div>

                <div class="solicitante-dato">
                    <strong>Apellidos</strong>
                    <p>{{ $docente->apellidos ?: 'NO REGISTRADOS' }}</p>
                </div>

                <div class="solicitante-dato">
                    <strong>Cargo</strong>
                    <p>{{ $docente->cargo ?: 'SIN CARGO' }}</p>
                </div>

                <div class="solicitante-dato">
                    <strong>DNI</strong>
                    <p>{{ $docente->dni ?: 'NO REGISTRADO' }}</p>
                </div>

                <div class="solicitante-dato">
                    <strong>Correo</strong>
                    <p>{{ $docente->correo ?: 'NO REGISTRADO' }}</p>
                </div>

                <div class="solicitante-dato">
                    <strong>Celular</strong>
                    <p>{{ $docente->celular ?: 'NO REGISTRADO' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- RESUMEN DEL HISTORIAL --}}
    <div class="solicitante-resumen">
        <div class="solicitante-resumen-item">
            <span>Total de préstamos</span>
            <strong>{{ $totalPrestamos }}</strong>
        </div>

        <div class="solicitante-resumen-item activos">
            <span>Préstamos activos</span>
            <strong>{{ $prestamosActivos }}</strong>
        </div>

        <div class="solicitante-resumen-item terminados">
            <span>Préstamos terminados</span>
            <strong>{{ $prestamosTerminados }}</strong>
        </div>
    </div>

    {{-- HISTORIAL --}}
    <div class="solicitante-panel">
        <div class="solicitante-panel-cuerpo">
            <h4 class="solicitante-titulo-seccion">
                HISTORIAL DE PRÉSTAMOS
            </h4>

            <p class="solicitante-subtitulo" style="margin-bottom:15px;">
                Ordenado del más reciente al más antiguo.
            </p>

            @if($prestamos->isNotEmpty())
                <div class="solicitante-tabla-contenedor">
                    <table class="solicitante-tabla">
                        <thead>
                            <tr>
                                <th style="width:6%;">N.º</th>
                                <th style="width:12%;">Fecha</th>
                                <th style="width:38%;">Equipos prestados</th>
                                <th style="width:13%;">Hora inicio</th>
                                <th style="width:13%;">Hora final</th>
                                <th style="width:18%;">Estado</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($prestamos as $prestamo)
                                @php
                                    $estadoPrestamo = strtoupper(
                                        $prestamo->estado
                                        ?: ($prestamo->hora_fin ? 'TERMINADO' : 'ACTIVO')
                                    );

                                    $clasePrestamo = match ($estadoPrestamo) {
                                        'ACTIVO' => 'prestamo-estado-activo',
                                        'TERMINADO' => 'prestamo-estado-terminado',
                                        default => 'prestamo-estado-otro',
                                    };

                                    $fechaPrestamo = $prestamo->fecha
                                        ? \Carbon\Carbon::parse($prestamo->fecha)->format('d-m-Y')
                                        : 'SIN FECHA';

                                    $horaInicio = $prestamo->hora_inicio
                                        ? \Carbon\Carbon::parse($prestamo->hora_inicio)->format('h:i A')
                                        : '—';

                                    $horaFin = $prestamo->hora_fin
                                        ? \Carbon\Carbon::parse($prestamo->hora_fin)->format('h:i A')
                                        : 'PENDIENTE';
                                @endphp

                                <tr>
                                    <td>
                                        {{ $prestamo->id }}
                                    </td>

                                    <td>
                                        {{ $fechaPrestamo }}
                                    </td>

                                    <td>
                                        @forelse($prestamo->prestamoEquipos as $prestamoEquipo)
                                            @php
                                                $equipoPrestado = $prestamoEquipo->equipo;
                                            @endphp

                                            @if($equipoPrestado)
                                                <div style="margin-bottom:4px;">
                                                    <strong>
                                                        {{ strtoupper($equipoPrestado->tipoEquipo->nombre ?? 'EQUIPO') }}
                                                    </strong>

                                                    @if($equipoPrestado->marca)
                                                        - {{ strtoupper($equipoPrestado->marca) }}
                                                    @endif

                                                    @if($equipoPrestado->modelo)
                                                        {{ strtoupper($equipoPrestado->modelo) }}
                                                    @endif

                                                    <br>

                                                    <span>
                                                        SERIE:
                                                        {{ $equipoPrestado->num_serie ?: 'SIN SERIE' }}
                                                    </span>
                                                </div>
                                            @else
                                                <div>EQUIPO NO DISPONIBLE</div>
                                            @endif
                                        @empty
                                            <span>SIN EQUIPOS ASOCIADOS</span>
                                        @endforelse
                                    </td>

                                    <td>{{ $horaInicio }}</td>

                                    <td>{{ $horaFin }}</td>

                                    <td>
                                        <span class="prestamo-estado {{ $clasePrestamo }}">
                                            {{ $estadoPrestamo }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="solicitante-vacio">
                    <strong>Sin historial de préstamos</strong>
                    <p class="mb-0 mt-2">
                        Este solicitante todavía no tiene préstamos registrados.
                    </p>
                </div>
            @endif
        </div>
    </div>

    {{-- BOTONES --}}
    <div class="solicitante-acciones no-print">
        <a href="{{ route('docentes.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> VOLVER
        </a>

        <a href="{{ route('docentes.edit', $docente->id) }}"
           class="btn btn-warning">
            <i class="bi bi-pencil-square"></i> EDITAR SOLICITANTE
        </a>
    </div>

</section>
@endsection

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
<!-- FIX_DOC_SHOW_DARK_START -->
<style id="doc-dark-common-style">
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
<script id="doc-dark-common-script">
(function () {
  function esOscuroDoc() {
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

  function fijarDocDark() {
    var oscuro = esOscuroDoc();
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
        el.dataset.docDarkBg = "1";
        var isPill = el.tagName === "BUTTON" || el.classList.contains("btn") || el.classList.contains("badge") || el.closest("button, .btn");
        el.style.setProperty("background-color", isPill ? "#1e293b" : "#111827", "important");
        el.style.setProperty("border-color", "#334155", "important");
        el.style.setProperty("color", "#f8fafc", "important");
        el.style.setProperty("-webkit-text-fill-color", "#f8fafc", "important");
      } else if (!oscuro && el.dataset.docDarkBg === "1") {
        delete el.dataset.docDarkBg;
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
        t.indexOf("Ordenado del más reciente") !== -1 ||
        t.indexOf("Ordenado del mas reciente") !== -1 ||
        el.classList.contains("text-muted");

      if (oscuro) {
        el.dataset.docDarkFg = "1";
        var fg = esSecundario ? "#cbd5e1" : "#f8fafc";
        el.style.setProperty("color", fg, "important");
        el.style.setProperty("-webkit-text-fill-color", fg, "important");
        el.style.setProperty("fill", fg, "important");
        el.style.setProperty("opacity", "1", "important");
        el.style.setProperty("visibility", "visible", "important");
      } else if (el.dataset.docDarkFg === "1") {
        delete el.dataset.docDarkFg;
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
        inp.dataset.docDarkInp = "1";
        inp.style.setProperty("color", "#f8fafc", "important");
        inp.style.setProperty("-webkit-text-fill-color", "#f8fafc", "important");
      } else if (inp.dataset.docDarkInp === "1") {
        delete inp.dataset.docDarkInp;
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

  fijarDocDark();
  document.addEventListener("DOMContentLoaded", function () {
    fijarDocDark();
    setTimeout(fijarDocDark, 150);
    setTimeout(fijarDocDark, 500);
    setTimeout(fijarDocDark, 1000);
  });
  window.addEventListener("load", function () {
    fijarDocDark();
    setTimeout(fijarDocDark, 300);
  });
  document.addEventListener("click", function () {
    setTimeout(fijarDocDark, 60);
    setTimeout(fijarDocDark, 250);
  });
  document.addEventListener("input", function () {
    setTimeout(fijarDocDark, 40);
  });
})();
</script>
<!-- FIX_DOC_SHOW_DARK_END -->
