@extends('layouts.app')

@section('template_title')
    {{ __('Crear') }} Docente
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Registrar') }} Solicitante | Docente</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('docentes.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('docente.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@include('aviso-cambios')
<!-- FIX_DOC_CREATE_DARK_START -->
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
<!-- FIX_DOC_CREATE_DARK_END -->
