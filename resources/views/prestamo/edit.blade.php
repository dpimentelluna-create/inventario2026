<title>Editar Préstamo</title>
@extends('layouts.app')

@section('template_title')
    Editar Préstamo
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-11">
            <div class="card shadow-sm">
                <div class="card-header encabezado-verde">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil-square"></i>
                        Editar Préstamo
                    </h4>
                </div>
                <div class="card-body bg-success-subtle">
                    <form method="POST" action="{{ route('prestamos.update', $prestamo->id) }}" role="form">
                        @method('PATCH')
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
<!-- FIX_PRESTAMO_EDIT_DARK_START -->
<style id="prestamo-edit-dark-style">
  /* SOLO MODO OSCURO en /prestamos/{id}/edit: todas las letras visibles */
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
<script id="prestamo-edit-dark-script">
(function () {
  function esOscuroEdit() {
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

  function fijarEditDark() {
    var oscuro = esOscuroEdit();
    var body = document.body;
    if (!body) return;

    // Forzar color claro en etiquetas, encabezados de seccion y textos de apoyo en Modo Oscuro
    body.querySelectorAll("h1, h2, h3, h4, h5, h6, label, .form-label, .col-form-label, .card-header, small, .text-muted, p, span, strong, b, div").forEach(function (el) {
      if (el.closest("nav, aside, .sidebar, button, .btn, input, select, textarea")) return;
      if (el.querySelector("input, select, textarea, button")) return;
      var t = (el.textContent || "").trim();
      if (!t) return;

      var esLabelOSeccion =
        el.tagName === "LABEL" ||
        el.tagName === "SMALL" ||
        el.classList.contains("form-label") ||
        el.classList.contains("col-form-label") ||
        el.classList.contains("card-header") ||
        el.classList.contains("text-muted") ||
        /^H[1-6]$/.test(el.tagName) ||
        t.indexOf("PARTE ") !== -1 ||
        t.indexOf("SOLICITANTE") !== -1 ||
        t.indexOf("CARGO") !== -1 ||
        t.indexOf("FECHA ") !== -1 ||
        t.indexOf("HORA ") !== -1 ||
        t.indexOf("EQUIPO") !== -1 ||
        t.indexOf("HORARIO:") !== -1 ||
        t.indexOf("DEJAR VACÍO") !== -1;

      if (oscuro && esLabelOSeccion) {
        el.dataset.editDarkTxt = "1";
        var fg = (el.tagName === "SMALL" || el.classList.contains("text-muted") || t.indexOf("HORARIO:") !== -1 || t.indexOf("DEJAR VACÍO") !== -1) ? "#cbd5e1" : "#f8fafc";
        el.style.setProperty("color", fg, "important");
        el.style.setProperty("-webkit-text-fill-color", fg, "important");
        el.style.setProperty("opacity", "1", "important");
        el.style.setProperty("visibility", "visible", "important");
      } else if (!oscuro && el.dataset.editDarkTxt === "1") {
        delete el.dataset.editDarkTxt;
        el.style.removeProperty("color");
        el.style.removeProperty("-webkit-text-fill-color");
        el.style.removeProperty("opacity");
        el.style.removeProperty("visibility");
      }
    });

    body.querySelectorAll("input, select, textarea").forEach(function (inp) {
      if (inp.closest("nav, aside, .sidebar")) return;
      if (oscuro) {
        inp.dataset.editDarkInp = "1";
        inp.style.setProperty("color", "#f8fafc", "important");
        inp.style.setProperty("-webkit-text-fill-color", "#f8fafc", "important");
      } else if (inp.dataset.editDarkInp === "1") {
        delete inp.dataset.editDarkInp;
        inp.style.removeProperty("color");
        inp.style.removeProperty("-webkit-text-fill-color");
      }
    });

    body.querySelectorAll("button, .btn, .badge").forEach(function (el) {
      if (el.closest("nav, aside, .sidebar")) return;
      if (el.classList.contains("btn-success") || el.classList.contains("btn-danger") || el.classList.contains("btn-primary")) return;
      if (oscuro) {
        el.dataset.editDarkBtn = "1";
        el.style.setProperty("color", "#f8fafc", "important");
        el.style.setProperty("-webkit-text-fill-color", "#f8fafc", "important");
        el.style.setProperty("opacity", "1", "important");
        el.querySelectorAll("i, svg, span").forEach(function (ch) {
          ch.style.setProperty("color", "#f8fafc", "important");
          ch.style.setProperty("-webkit-text-fill-color", "#f8fafc", "important");
          ch.style.setProperty("fill", "#f8fafc", "important");
          ch.style.setProperty("opacity", "1", "important");
        });
      } else if (el.dataset.editDarkBtn === "1") {
        delete el.dataset.editDarkBtn;
        el.style.removeProperty("color");
        el.style.removeProperty("-webkit-text-fill-color");
        el.style.removeProperty("opacity");
        el.querySelectorAll("i, svg, span").forEach(function (ch) {
          ch.style.removeProperty("color");
          ch.style.removeProperty("-webkit-text-fill-color");
          ch.style.removeProperty("fill");
          ch.style.removeProperty("opacity");
        });
      }
    });
  }

  fijarEditDark();
  document.addEventListener("DOMContentLoaded", function () {
    fijarEditDark();
    setTimeout(fijarEditDark, 150);
    setTimeout(fijarEditDark, 500);
  });
  window.addEventListener("load", fijarEditDark);
  document.addEventListener("click", function () {
    setTimeout(fijarEditDark, 60);
    setTimeout(fijarEditDark, 250);
  });
  document.addEventListener("input", function () {
    setTimeout(fijarEditDark, 40);
  });
})();
</script>
<!-- FIX_PRESTAMO_EDIT_DARK_END -->
