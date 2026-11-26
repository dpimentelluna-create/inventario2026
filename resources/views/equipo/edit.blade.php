<title>Editar Equipo</title>
@extends('layouts.app')

@section('template_title')
    Editar Equipo
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <div class="text-muted small">MÓDULO EQUIPOS</div>
                    <h3 class="mb-0 fw-bold">
                        EDITAR EQUIPO
                        <span class="text-muted fs-5">· {{ $equipo->num_serie ?? '' }}</span>
                    </h3>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('equipos.show', $equipo->id) }}" class="btn btn-info btn-sm">VER</a>
                    <a href="{{ route('equipos.index') }}" class="btn btn-secondary btn-sm">ATRÁS</a>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body bg-white">
                    <form method="POST" action="{{ route('equipos.update', $equipo->id) }}" role="form" novalidate>
                        @method('PATCH')
                        @csrf
                        @include('equipo.form')
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
        color: #000;
        border-bottom: 1px solid #000;
    }
    .dato-label, .form-label {
        font-size: 12px;
        letter-spacing: .04em;
        color: #198754;
        font-weight: 700;
    }
    .card {
        border: 1px solid #000;
        border-radius: 6px;
        overflow: hidden;
    }
</style>
@include('aviso-cambios')
<!-- FIX_EQUIPOS_EDIT_DARK_START -->
<style id="equipos-edit-dark-style">
  /* SOLO MODO OSCURO en /equipos/{id}/edit: todas las letras visibles */
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
<script id="equipos-edit-dark-script">
(function () {
  function esOscuroEqEdit() {
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

  function fijarEqEditDark() {
    var oscuro = esOscuroEqEdit();
    var body = document.body;
    if (!body) return;

    body.querySelectorAll("h1, h2, h3, h4, h5, h6, label, .form-label, .col-form-label, .card-header, small, .text-muted, p, span, strong, b, div, i, svg").forEach(function (el) {
      if (el.closest("nav, aside, .sidebar, button, .btn, input, select, textarea")) return;
      if (el.querySelector("input, select, textarea, button")) return;
      var t = (el.textContent || "").trim();
      if (!t && el.tagName !== "I" && el.tagName !== "SVG") return;

      var esTextoEdicion =
        el.tagName === "LABEL" ||
        el.tagName === "SMALL" ||
        el.tagName === "I" ||
        el.tagName === "SVG" ||
        el.classList.contains("form-label") ||
        el.classList.contains("col-form-label") ||
        el.classList.contains("card-header") ||
        el.classList.contains("text-muted") ||
        /^H[1-6]$/.test(el.tagName) ||
        t.indexOf("PARTE ") !== -1 ||
        t.indexOf("ESPECIFICACIONES") !== -1 ||
        t.indexOf("TIPO DE EQUIPO") !== -1 ||
        t.indexOf("NÚMERO DE SERIE") !== -1 ||
        t.indexOf("MARCA") !== -1 ||
        t.indexOf("MODELO") !== -1 ||
        t.indexOf("UBICACIÓN") !== -1 ||
        t.indexOf("FECHA DE REGISTRO") !== -1 ||
        t.indexOf("PROCESADOR") !== -1 ||
        t.indexOf("MEMORIA RAM") !== -1 ||
        t.indexOf("DISCO DURO") !== -1 ||
        t.indexOf("SISTEMA OPERATIVO") !== -1;

      if (oscuro && esTextoEdicion) {
        el.dataset.eqEditTxt = "1";
        var fg = (el.tagName === "SMALL" || el.classList.contains("text-muted")) ? "#cbd5e1" : "#f8fafc";
        el.style.setProperty("color", fg, "important");
        el.style.setProperty("-webkit-text-fill-color", fg, "important");
        el.style.setProperty("fill", fg, "important");
        el.style.setProperty("opacity", "1", "important");
        el.style.setProperty("visibility", "visible", "important");
      } else if (!oscuro && el.dataset.eqEditTxt === "1") {
        delete el.dataset.eqEditTxt;
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
        inp.dataset.eqEditInp = "1";
        inp.style.setProperty("color", "#f8fafc", "important");
        inp.style.setProperty("-webkit-text-fill-color", "#f8fafc", "important");
      } else if (inp.dataset.eqEditInp === "1") {
        delete inp.dataset.eqEditInp;
        inp.style.removeProperty("color");
        inp.style.removeProperty("-webkit-text-fill-color");
      }
    });
  }

  fijarEqEditDark();
  document.addEventListener("DOMContentLoaded", function () {
    fijarEqEditDark();
    setTimeout(fijarEqEditDark, 150);
    setTimeout(fijarEqEditDark, 500);
  });
  window.addEventListener("load", fijarEqEditDark);
  document.addEventListener("click", function () {
    setTimeout(fijarEqEditDark, 60);
    setTimeout(fijarEqEditDark, 250);
  });
  document.addEventListener("input", function () {
    setTimeout(fijarEqEditDark, 40);
  });
  document.addEventListener("change", function () {
    setTimeout(fijarEqEditDark, 60);
  });
})();
</script>
<!-- FIX_EQUIPOS_EDIT_DARK_END -->
