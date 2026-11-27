<title>Registrar Préstamo</title>
@extends('layouts.app')

@section('template_title')
    Registrar Préstamo
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-11">
            <div class="card shadow-sm">
                <div class="card-header encabezado-verde">
                    <h4 class="mb-0">
                        <i class="bi bi-plus-circle"></i>
                        Registrar Préstamo
                    </h4>
                </div>
                <div class="card-body bg-success-subtle">
                    <form method="POST" action="{{ route('prestamos.store') }}" role="form">
                        @csrf
                        @include('prestamo.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>@endsection

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

    .seccion-bloqueada {
        opacity: 0.55;
        pointer-events: none;
        filter: grayscale(0.2);
    }
</style>
@include('aviso-cambios')
<!-- FIX_PRESTAMO_CREATE_DARK_START -->
<style id="prestamo-create-dark-style">
  /* SOLO MODO OSCURO en /prestamos/create */
  html.dark label,
  html.dark .form-label,
  html.dark small,
  html.dark .text-muted,
  html[data-bs-theme="dark"] label,
  html[data-bs-theme="dark"] .form-label,
  html[data-bs-theme="dark"] small,
  html[data-bs-theme="dark"] .text-muted,
  body.dark label,
  body.dark .form-label,
  body.dark small,
  body.dark .text-muted,
  body.dark-mode label,
  body.dark-mode .form-label,
  body.dark-mode small,
  body.dark-mode .text-muted,
  body.tema-oscuro-activo label,
  body.tema-oscuro-activo .form-label,
  body.tema-oscuro-activo small,
  body.tema-oscuro-activo .text-muted {
    color: #e2e8f0 !important;
    -webkit-text-fill-color: #e2e8f0 !important;
    opacity: 1 !important;
  }

  /* Encabezados de seccion tipo PARTE 1 / PARTE 2 en Modo Oscuro */
  html.dark .card-header,
  html.dark .card-header *,
  html[data-bs-theme="dark"] .card-header,
  html[data-bs-theme="dark"] .card-header *,
  body.dark .card-header,
  body.dark .card-header *,
  body.dark-mode .card-header,
  body.dark-mode .card-header *,
  body.tema-oscuro-activo .card-header,
  body.tema-oscuro-activo .card-header * {
    color: #f8fafc !important;
    -webkit-text-fill-color: #f8fafc !important;
    opacity: 1 !important;
  }

  /* Inputs, selects y dropdowns de busqueda/solicitante en Modo Oscuro */
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
<script id="prestamo-create-dark-script">
(function () {
  function esOscuroCreate() {
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

  function fijarCreateDark() {
    var oscuro = esOscuroCreate();

    document.querySelectorAll("h1, h2, h3, h4, h5, h6, label, .form-label, .card-header, small, .text-muted, p, span, div").forEach(function (el) {
      if (el.closest("button, .btn, input, select, textarea")) return;
      if (el.querySelector("input, select, textarea, button")) return;
      var t = (el.textContent || "").trim();
      if (!t) return;

      var esParte = t.indexOf("PARTE ") !== -1 || t.indexOf("DATOS DEL PRÉSTAMO") !== -1 || t.indexOf("DATOS DEL PRESTAMO") !== -1;
      var esEtiquetaOAvisos =
        esParte ||
        el.tagName === "LABEL" ||
        el.tagName === "SMALL" ||
        el.classList.contains("form-label") ||
        el.classList.contains("card-header") ||
        el.classList.contains("text-muted") ||
        t.indexOf("HORARIO:") !== -1 ||
        t.indexOf("DEJAR VACÍO") !== -1 ||
        t.indexOf("Complete primero") !== -1;

      var bg = window.getComputedStyle(el).backgroundColor || "";
      var m = bg.match(/\d+/g);
      var fondoOscuro = false;
      if (m && m.length >= 3) {
        var lum = (parseInt(m[0], 10) + parseInt(m[1], 10) + parseInt(m[2], 10)) / 3;
        if (lum < 85) fondoOscuro = true;
      }

      if (oscuro && (esEtiquetaOAvisos || fondoOscuro)) {
        el.dataset.createDarkTxt = "1";
        var col = esParte ? "#ffffff" : (t.indexOf("HORARIO:") !== -1 || t.indexOf("DEJAR VACÍO") !== -1 || el.classList.contains("text-muted") ? "#cbd5e1" : "#f8fafc");
        el.style.setProperty("color", col, "important");
        el.style.setProperty("-webkit-text-fill-color", col, "important");
        el.style.setProperty("opacity", "1", "important");
        el.style.setProperty("visibility", "visible", "important");
      } else if (!oscuro && el.dataset.createDarkTxt === "1") {
        delete el.dataset.createDarkTxt;
        el.style.removeProperty("color");
        el.style.removeProperty("-webkit-text-fill-color");
        el.style.removeProperty("opacity");
        el.style.removeProperty("visibility");
      }
    });

    document.querySelectorAll("input.form-control, select.form-select, textarea.form-control").forEach(function (inp) {
      if (oscuro) {
        inp.dataset.createDarkInp = "1";
        inp.style.setProperty("color", "#f8fafc", "important");
        inp.style.setProperty("-webkit-text-fill-color", "#f8fafc", "important");
      } else if (inp.dataset.createDarkInp === "1") {
        delete inp.dataset.createDarkInp;
        inp.style.removeProperty("color");
        inp.style.removeProperty("-webkit-text-fill-color");
      }
    });
  }

  fijarCreateDark();
  document.addEventListener("DOMContentLoaded", function () {
    fijarCreateDark();
    setTimeout(fijarCreateDark, 200);
  });
  window.addEventListener("load", fijarCreateDark);
  document.addEventListener("click", function () {
    setTimeout(fijarCreateDark, 60);
    setTimeout(fijarCreateDark, 220);
  });
  document.addEventListener("input", function () {
    setTimeout(fijarCreateDark, 40);
  });
})();
</script>
<!-- FIX_PRESTAMO_CREATE_DARK_END -->
