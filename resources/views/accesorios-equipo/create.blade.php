@extends('layouts.app')

@section('template_title')
    Registrar Accesorio Equipo
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Crear') }} Accesorios Equipo</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('accesorios-equipo.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('accesorios-equipo.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>@endsection
@include('aviso-cambios')
<!-- FIX_ACC_CREATE_DARK_START -->
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
<!-- FIX_ACC_CREATE_DARK_END -->
