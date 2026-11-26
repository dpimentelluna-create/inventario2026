@extends('layouts.app')

@php
    $tipoAccesorio = strtoupper($accesoriosEquipo->tipo ?? 'ACCESORIO');
    $marcaAccesorio = strtoupper($accesoriosEquipo->marca ?? 'SIN MARCA');
    $serieAccesorio = $accesoriosEquipo->num_serie ?: 'SIN-SERIE';

    $estadoAccesorio = strtoupper($accesoriosEquipo->estado ?? '');
    $claseEstado = match ($estadoAccesorio) {
        'MALOGRADO' => 'estado-malogrado',
        'REGULAR' => 'estado-regular',
        'BUENO', 'OPERATIVO' => 'estado-bueno',
        default => 'estado-neutro',
    };

    $equipo = $accesoriosEquipo->equipo;

    // Ubicación efectiva: del equipo o propia del accesorio
    $ubicacionEfectiva = $equipo
        ? $equipo->ubicacione
        : $accesoriosEquipo->ubicacion;

    $tipoEquipo = strtoupper($equipo->tipoEquipo->nombre ?? 'NO REGISTRADO');
    $estadoEquipo = strtoupper($equipo->estado ?? 'NO REGISTRADO');

    $claseEstadoEquipo = match ($estadoEquipo) {
        'MALOGRADO' => 'estado-malogrado',
        'REGULAR' => 'estado-regular',
        'BUENO', 'OPERATIVO' => 'estado-bueno',
        default => 'estado-neutro',
    };

    $fechaEquipo = $equipo && $equipo->fecha_registro
        ? \Carbon\Carbon::parse($equipo->fecha_registro)->format('d-m-Y')
        : 'NO REGISTRADA';
@endphp

@section('template_title')
    Accesorio {{ $accesoriosEquipo->id }} - {{ $tipoAccesorio }} - {{ $serieAccesorio }}
@endsection

@section('content')
    <style>
        .accesorio-contenedor {
            max-width: 1150px;
            margin: 0 auto;
            padding-bottom: 25px;
        }

        .accesorio-encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }

        .accesorio-encabezado h2 {
            font-size: 25px;
            font-weight: 700;
            color: #212529;
            margin: 0 0 5px;
        }

        .accesorio-subtitulo {
            color: #6c757d;
            margin: 0;
            font-size: 14px;
        }

        .accesorio-panel {
            background: #fff;
            border: 1px solid #dee2e6;
            border-left: 5px solid #0d6efd;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .05);
            overflow: hidden;
        }

        .accesorio-panel-cuerpo {
            padding: 25px;
        }

        .accesorio-resumen {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 25px;
        }

        .accesorio-resumen-item {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 16px;
            min-width: 0;
        }

        .accesorio-resumen-label {
            display: block;
            color: #6c757d;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 7px;
        }

        .accesorio-resumen-valor {
            display: block;
            color: #212529;
            font-size: 16px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .accesorio-seccion {
            font-size: 17px;
            font-weight: 700;
            padding-bottom: 10px;
            margin: 26px 0 17px;
            border-bottom: 1px solid #dee2e6;
            color: #343a40;
        }

        .accesorio-seccion:first-child {
            margin-top: 0;
        }

        .accesorio-datos {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px 28px;
        }

        .accesorio-dato {
            min-width: 0;
        }

        .accesorio-dato-completo {
            grid-column: 1 / -1;
        }

        .accesorio-dato strong {
            display: block;
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .accesorio-dato p {
            margin: 0;
            color: #212529;
            font-size: 14px;
            overflow-wrap: anywhere;
            white-space: pre-line;
        }

        .estado-etiqueta {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .estado-bueno {
            background: #d1e7dd;
            color: #0f5132;
        }

        .estado-regular {
            background: #fff3cd;
            color: #664d03;
        }

        .estado-malogrado {
            background: #f8d7da;
            color: #842029;
        }

        .estado-neutro {
            background: #e2e3e5;
            color: #41464b;
        }

        .accesorio-relacionado {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
        }

        .accesorio-alerta {
            padding: 14px;
            background: #fff3cd;
            border: 1px solid #ffecb5;
            border-radius: 6px;
            color: #664d03;
        }

        .accesorio-acciones {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 22px;
        }

        @media (max-width: 768px) {
            .accesorio-resumen {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .accesorio-panel-cuerpo {
                padding: 17px;
            }
        }

        @media (max-width: 480px) {
            .accesorio-datos {
                grid-template-columns: 1fr;
            }

            .accesorio-dato-completo {
                grid-column: auto;
            }
        }

        @page {
            size: A4 portrait;
            margin: 12mm;
        }

        @media print {

            html,
            body {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #fff !important;
            }

            body * {
                visibility: hidden !important;
            }

            #accesorio-ficha-print,
            #accesorio-ficha-print * {
                visibility: visible !important;
            }

            #accesorio-ficha-print {
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                margin: 0 !important;
                border: 1px solid #adb5bd !important;
                border-left: 4px solid #0d6efd !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                overflow: visible !important;
                background: #fff !important;
            }

            #accesorio-ficha-print .no-print,
            #accesorio-ficha-print .accesorio-acciones {
                display: none !important;
            }

            #accesorio-ficha-print .accesorio-panel-cuerpo {
                padding: 15px !important;
            }

            #accesorio-ficha-print .accesorio-resumen {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 8px !important;
            }

            #accesorio-ficha-print .accesorio-resumen-item {
                padding: 10px !important;
                break-inside: avoid;
            }

            #accesorio-ficha-print .accesorio-seccion {
                margin-top: 18px !important;
                break-after: avoid;
            }

            #accesorio-ficha-print .accesorio-datos,
            #accesorio-ficha-print .accesorio-relacionado {
                break-inside: avoid;
            }

            #accesorio-ficha-print .estado-etiqueta {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            a {
                color: #212529 !important;
                text-decoration: none !important;
            }
        }
    </style>
<section class="content container-fluid accesorio-contenedor">
        {{-- ENCABEZADO --}}
        <div class="accesorio-encabezado no-print">
            <div>
                <h2>FICHA DEL ACCESORIO</h2>
                <p class="accesorio-subtitulo">
                    Información del accesorio y del equipo al que se encuentra asociado.
                </p>
            </div>
            <button type="button" class="btn btn-primary" onclick="window.print()">
                <i class="bi bi-printer"></i> IMPRIMIR FICHA
            </button>
        </div>

        {{-- FICHA --}}
        <div class="accesorio-panel" id="accesorio-ficha-print">
            <div class="accesorio-panel-cuerpo">

                <div class="mb-4">
                    <h3 style="font-size:21px;font-weight:700;margin-bottom:5px;">
                        {{ $tipoAccesorio }}
                    </h3>
                    <p style="color:#6c757d;margin:0;">
                        Registro de Accesorio - ID: {{ $accesoriosEquipo->id }}
                    </p>
                </div>

                {{-- RESUMEN --}}
                <div class="accesorio-resumen">
                    <div class="accesorio-resumen-item">
                        <span class="accesorio-resumen-label">Tipo de accesorio</span>
                        <span class="accesorio-resumen-valor">{{ $tipoAccesorio }}</span>
                    </div>
                    <div class="accesorio-resumen-item">
                        <span class="accesorio-resumen-label">Número de serie</span>
                        <span class="accesorio-resumen-valor">{{ $accesoriosEquipo->num_serie ?: 'SIN REGISTRAR' }}</span>
                    </div>
                    <div class="accesorio-resumen-item">
                        <span class="accesorio-resumen-label">Marca</span>
                        <span class="accesorio-resumen-valor">{{ $marcaAccesorio }}</span>
                    </div>
                    <div class="accesorio-resumen-item">
                        <span class="accesorio-resumen-label">Observaciones</span>
                        <span class="accesorio-resumen-valor">{{ $accesoriosEquipo->observaciones ?: 'SIN OBSERVACIONES' }}</span>
                    </div>
                </div>

                {{-- EQUIPO RELACIONADO --}}
                <h4 class="accesorio-seccion">
                    {{ $equipo ? 'EQUIPO RELACIONADO' : 'UBICACIÓN DEL ACCESORIO' }}
                </h4>

                @if($equipo)
                    <div class="accesorio-relacionado">
                        <div class="accesorio-datos">
                            <div class="accesorio-dato">
                                <strong>ID del equipo</strong>
                                <p>{{ $equipo->id }}</p>
                            </div>
                            <div class="accesorio-dato">
                                <strong>Tipo de equipo</strong>
                                <p>{{ $tipoEquipo }}</p>
                            </div>
                            <div class="accesorio-dato">
                                <strong>Marca</strong>
                                <p>{{ $equipo->marca ?: 'NO REGISTRADA' }}</p>
                            </div>
                            <div class="accesorio-dato">
                                <strong>Modelo</strong>
                                <p>{{ $equipo->modelo ?: 'NO REGISTRADO' }}</p>
                            </div>
                            <div class="accesorio-dato">
                                <strong>Número de serie</strong>
                                <p>{{ $equipo->num_serie ?: 'NO REGISTRADO' }}</p>
                            </div>
                            <div class="accesorio-dato">
                                <strong>Estado del equipo</strong>
                                <p>
                                    <span class="estado-etiqueta {{ $claseEstadoEquipo }}">
                                        {{ $estadoEquipo }}
                                    </span>
                                </p>
                            </div>
                            <div class="accesorio-dato">
                                <strong>Ubicación</strong>
                                <p>{{ $ubicacionEfectiva->nombre ?? 'NO REGISTRADA' }}</p>
                            </div>
                            <div class="accesorio-dato">
                                <strong>Fecha de registro</strong>
                                <p>{{ $fechaEquipo }}</p>
                            </div>
                            <div class="accesorio-dato accesorio-dato-completo">
                                <strong>Observación del equipo</strong>
                                <p>{{ $equipo->observacion ?: 'SIN OBSERVACIONES' }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    @if($accesoriosEquipo->equipo_id)
                        <div class="accesorio-alerta">
                            No se encontró información del equipo asociado a este accesorio.
                        </div>
                    @else
                        <div class="accesorio-relacionado">
                            <div class="accesorio-datos">
                                <div class="accesorio-dato accesorio-dato-completo">
                                    <strong>Tipo de registro</strong>
                                    <p>ACCESORIO INDEPENDIENTE (SIN EQUIPO RELACIONADO)</p>
                                </div>
                                <div class="accesorio-dato">
                                    <strong>Ubicación del accesorio</strong>
                                    <p>{{ $ubicacionEfectiva->nombre ?? 'NO REGISTRADA' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                {{-- ESTADO Y OBSERVACIONES --}}
                <h4 class="accesorio-seccion">ESTADO Y OBSERVACIONES</h4>
                <div class="accesorio-datos">
                    <div class="accesorio-dato">
                        <strong>Estado actual del accesorio</strong>
                        <p>
                            <span class="estado-etiqueta {{ $claseEstado }}">
                                {{ $estadoAccesorio ?: 'NO REGISTRADO' }}
                            </span>
                        </p>
                    </div>
                    <div class="accesorio-dato">
                        <strong>Estado del equipo relacionado</strong>
                        <p>
                            @if($equipo)
                                <span class="estado-etiqueta {{ $claseEstadoEquipo }}">
                                    {{ $estadoEquipo }}
                                </span>
                            @else
                                NO DISPONIBLE
                            @endif
                        </p>
                    </div>
                    <div class="accesorio-dato accesorio-dato-completo">
                        <strong>Observaciones del accesorio</strong>
                        <p>{{ $accesoriosEquipo->observaciones ?: 'SIN OBSERVACIONES' }}</p>
                    </div>
                    @if($equipo)
                        <div class="accesorio-dato accesorio-dato-completo">
                            <strong>Observación del equipo relacionado</strong>
                            <p>{{ $equipo->observacion ?: 'SIN OBSERVACIONES' }}</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>

        {{-- ACCIONES --}}
        <div class="accesorio-acciones no-print">
            <a href="{{ route('accesorios-equipo.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> VOLVER
            </a>
            <a href="{{ route('accesorios-equipo.edit', $accesoriosEquipo->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square"></i> EDITAR ACCESORIO
            </a>
        </div>

    </section>
@endsection
<!-- FIX_ACC_SHOW_DARK_START -->
<style id="acc-dark-common-style">
  html.dark #panel_filtros,
  html.dark #panel_filtros .card,
  html.dark #panel_filtros .card-body,
  html.dark #panel_filtros .card-header,
  html[data-bs-theme="dark"] #panel_filtros,
  html[data-bs-theme="dark"] #panel_filtros .card,
  html[data-bs-theme="dark"] #panel_filtros .card-body,
  html[data-bs-theme="dark"] #panel_filtros .card-header,
  body.dark #panel_filtros,
  body.dark #panel_filtros .card,
  body.dark #panel_filtros .card-body,
  body.dark #panel_filtros .card-header,
  body.dark-mode #panel_filtros,
  body.dark-mode #panel_filtros .card,
  body.dark-mode #panel_filtros .card-body,
  body.dark-mode #panel_filtros .card-header,
  body.tema-oscuro-activo #panel_filtros,
  body.tema-oscuro-activo #panel_filtros .card,
  body.tema-oscuro-activo #panel_filtros .card-body,
  body.tema-oscuro-activo #panel_filtros .card-header {
    background-color: #111827 !important;
    border-color: #1f2937 !important;
    color: #f8fafc !important;
  }

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

  html.dark .select2-results__option,
  html.dark .list-group-item,
  html.dark .dropdown-item,
  html[data-bs-theme="dark"] .select2-results__option,
  html[data-bs-theme="dark"] .list-group-item,
  html[data-bs-theme="dark"] .dropdown-item,
  body.dark .select2-results__option,
  body.dark .list-group-item,
  body.dark .dropdown-item,
  body.dark-mode .select2-results__option,
  body.dark-mode .list-group-item,
  body.dark-mode .dropdown-item,
  body.tema-oscuro-activo .select2-results__option,
  body.tema-oscuro-activo .list-group-item,
  body.tema-oscuro-activo .dropdown-item {
    background-color: #1e293b !important;
    color: #f8fafc !important;
    -webkit-text-fill-color: #f8fafc !important;
  }
</style>
<script id="acc-dark-common-script">
(function () {
  function esOscuroAcc() {
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

  function fijarAccDark() {
    var oscuro = esOscuroAcc();
    var body = document.body;
    if (!body) return;

    // 1. Contenedores y tarjetas claras -> oscuro en Modo Oscuro
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

      var t = (el.textContent || "").trim().toUpperCase();
      var esPillFiltro = t.indexOf("COINCIDENCIA") !== -1 || (t.indexOf("FILTROS") !== -1 && t.length <= 25);

      if (oscuro && (esClaro || esPillFiltro)) {
        el.dataset.accDarkBg = "1";
        var isPill = el.tagName === "BUTTON" || el.classList.contains("btn") || el.classList.contains("badge") || el.closest("button, .btn") || esPillFiltro;
        el.style.setProperty("background-color", isPill ? "#1e293b" : "#111827", "important");
        el.style.setProperty("border-color", "#334155", "important");
        el.style.setProperty("color", "#f8fafc", "important");
        el.style.setProperty("-webkit-text-fill-color", "#f8fafc", "important");
      } else if (!oscuro && el.dataset.accDarkBg === "1") {
        delete el.dataset.accDarkBg;
        el.style.removeProperty("background-color");
        el.style.removeProperty("border-color");
        el.style.removeProperty("color");
        el.style.removeProperty("-webkit-text-fill-color");
      }
    });

    // 2. Addons / botones internos de input-group
    body.querySelectorAll(".input-group-text, .input-group > button, .input-group > .btn").forEach(function (btn) {
      if (btn.closest("nav, aside, .sidebar")) return;
      if (btn.classList.contains("btn-success") || btn.classList.contains("btn-primary") || btn.classList.contains("btn-danger")) return;
      if (oscuro) {
        btn.dataset.accAddon = "1";
        btn.style.setProperty("background-color", "#1e293b", "important");
        btn.style.setProperty("border-color", "#334155", "important");
        btn.style.setProperty("color", "#f8fafc", "important");
        btn.style.setProperty("-webkit-text-fill-color", "#f8fafc", "important");
        btn.querySelectorAll("i, svg, path, span").forEach(function (ch) {
          ch.style.setProperty("color", "#f8fafc", "important");
          ch.style.setProperty("-webkit-text-fill-color", "#f8fafc", "important");
          ch.style.setProperty("fill", "#f8fafc", "important");
          ch.style.setProperty("stroke", "#f8fafc", "important");
          ch.style.setProperty("opacity", "1", "important");
        });
      } else if (btn.dataset.accAddon === "1") {
        delete btn.dataset.accAddon;
        btn.style.removeProperty("background-color");
        btn.style.removeProperty("border-color");
        btn.style.removeProperty("color");
        btn.style.removeProperty("-webkit-text-fill-color");
        btn.querySelectorAll("i, svg, path, span").forEach(function (ch) {
          ch.style.removeProperty("color");
          ch.style.removeProperty("-webkit-text-fill-color");
          ch.style.removeProperty("fill");
          ch.style.removeProperty("stroke");
          ch.style.removeProperty("opacity");
        });
      }
    });

    // 3. Textos, etiquetas, encabezados y ayudas en Modo Oscuro
    body.querySelectorAll("h1, h2, h3, h4, h5, h6, p, span, small, label, strong, b, div, i, svg").forEach(function (el) {
      if (el.closest("table, nav, aside, .sidebar")) return;
      if (el.querySelector("div, p, h1, h2, h3, h4, h5, h6, table, input, select, textarea")) return;
      var t = (el.textContent || "").trim();
      if (!t && el.tagName !== "I" && el.tagName !== "SVG") return;

      var esSecundario =
        t.indexOf("Utiliza los campos") !== -1 ||
        t.indexOf("Puedes combinar") !== -1 ||
        t.indexOf("Seleccione el equipo") !== -1 ||
        t.indexOf("Indique dónde") !== -1 ||
        t.indexOf("Indique donde") !== -1 ||
        t.indexOf("Información de identificación") !== -1 ||
        t.indexOf("Informacion de identificacion") !== -1 ||
        t.indexOf("Puede utilizar la marca") !== -1 ||
        t.indexOf("Si selecciona un equipo") !== -1 ||
        t.indexOf("Registro de Accesorio") !== -1 ||
        el.classList.contains("text-muted");

      if (oscuro) {
        el.dataset.accDarkFg = "1";
        var fg = esSecundario ? "#cbd5e1" : "#f8fafc";
        el.style.setProperty("color", fg, "important");
        el.style.setProperty("-webkit-text-fill-color", fg, "important");
        el.style.setProperty("fill", fg, "important");
        el.style.setProperty("opacity", "1", "important");
        el.style.setProperty("visibility", "visible", "important");
      } else if (el.dataset.accDarkFg === "1") {
        delete el.dataset.accDarkFg;
        el.style.removeProperty("color");
        el.style.removeProperty("-webkit-text-fill-color");
        el.style.removeProperty("fill");
        el.style.removeProperty("opacity");
        el.style.removeProperty("visibility");
      }
    });

    // 4. Inputs y selects
    body.querySelectorAll("input, select, textarea").forEach(function (inp) {
      if (inp.closest("nav, aside, .sidebar")) return;
      if (oscuro) {
        inp.dataset.accDarkInp = "1";
        inp.style.setProperty("color", "#f8fafc", "important");
        inp.style.setProperty("-webkit-text-fill-color", "#f8fafc", "important");
      } else if (inp.dataset.accDarkInp === "1") {
        delete inp.dataset.accDarkInp;
        inp.style.removeProperty("color");
        inp.style.removeProperty("-webkit-text-fill-color");
      }
    });
  }

  fijarAccDark();
  document.addEventListener("DOMContentLoaded", function () {
    fijarAccDark();
    setTimeout(fijarAccDark, 150);
    setTimeout(fijarAccDark, 500);
    setTimeout(fijarAccDark, 1000);
  });
  window.addEventListener("load", function () {
    fijarAccDark();
    setTimeout(fijarAccDark, 300);
  });
  document.addEventListener("click", function () {
    setTimeout(fijarAccDark, 60);
    setTimeout(fijarAccDark, 250);
  });
  document.addEventListener("input", function () {
    setTimeout(fijarAccDark, 40);
  });
})();
</script>
<!-- FIX_ACC_SHOW_DARK_END -->
