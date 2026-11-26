@extends('layouts.app')

@section('template_title')
    Editar Ubicación
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header encabezado-verde">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil-square"></i>
                        Editar Ubicación
                    </h4>
                </div>
                <div class="card-body bg-white">
                    <form method="POST" action="{{ route('ubicaciones.update', $ubicacione->id) }}" role="form">
                        @method('PATCH')
                        @csrf
                        @include('ubicacione.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<style>
    .encabezado-verde {
        background-color: #90EE90 !important;
        color: #000000;
        border-bottom: 1px solid #000000;
        text-align: center;
        padding: 15px;
    }
    .card {
        border: 1px solid #000000;
        border-radius: 6px;
        overflow: hidden;
    }
    .form-label {
        font-weight: 600;
        color: #198754;
    }
    .form-control,
    .form-select {
        border: 1px solid #000000;
        border-radius: 5px;
    }
    .form-control:focus,
    .form-select:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.15rem rgba(25, 135, 84, 0.15);
    }
    .btn {
        min-width: 100px;
    }
</style>
@include('aviso-cambios')
<!-- FIX_UB_DARK_1_START -->
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
<!-- FIX_UB_DARK_1_END -->

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
