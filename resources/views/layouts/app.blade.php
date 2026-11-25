<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        };
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('template_title')
        @yield('template_title') | Inventario 2026
        @else
        Inventario 2026
        @endif</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!--LINK PARA ICONOS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Script antiparpadeo del tema -->
    <script>
        (function() {
            const t = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', t);
            document.documentElement.classList.toggle('dark', t === 'dark');
        })();
    </script>

    <!--ESTILOS GENERALES Y DISEÑO DE BARRA LATERAL Y LOADER-->
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-accion {
            width: 38px;
            height: 38px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .btn-accion i {
            font-size: 16px;
        }

        .columna-acciones {
            width: 140px !important;
            min-width: 140px !important;
            max-width: 140px !important;
            white-space: nowrap;
        }

        /* --- LAYOUT DE BARRA LATERAL FIJA --- */
        #app-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        #sidebar {
            width: 260px;
            min-width: 260px;
            transition: background-color 0.3s ease, color 0.3s ease, width 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            z-index: 1000;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            padding: 1rem 0.75rem !important;
        }

        #sidebar.collapsed {
            width: 72px;
            min-width: 72px;
        }

        #sidebar.collapsed .sidebar-text,
        #sidebar.collapsed .brand-text,
        #sidebar.collapsed .sidebar-brand-text,
        #sidebar.collapsed .auth-buttons-container,
        #sidebar.collapsed .user-name-text,
        #sidebar.collapsed .user-info-cards {
            display: none !important;
        }

        #sidebar.collapsed .sidebar-link {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        #sidebar.collapsed .sidebar-link i {
            margin-right: 0 !important;
            font-size: 1.25rem;
        }

        #sidebar.collapsed .user-dropdown-container .dropdown-toggle {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        #sidebar.collapsed .user-dropdown-container .dropdown-toggle .rounded-circle {
            margin-right: 0 !important;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.6rem 0.75rem;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: background-color 0.2s, color 0.2s;
            margin-bottom: 0.25rem;
        }

        #content-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* --- ESTILOS DEL LOADER CIRCULAR DE PUNTOS --- */
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.85);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            transition: opacity 0.3s ease;
        }

        [data-bs-theme="light"] #page-loader {
            background-color: rgba(248, 250, 252, 0.85);
        }

        .dot-spinner-container {
            position: relative;
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: spin 1.2s linear infinite;
        }

        .dot-spinner-container .dot {
            position: absolute;
            width: 12px;
            height: 12px;
            background-color: #cbd5e1;
            border-radius: 50%;
        }

        [data-bs-theme="light"] .dot-spinner-container .dot {
            background-color: #475569;
        }

        .dot-spinner-container .dot:nth-child(1) { transform: rotate(0deg) translate(45px); opacity: 0.1; }
        .dot-spinner-container .dot:nth-child(2) { transform: rotate(22.5deg) translate(45px); opacity: 0.15; }
        .dot-spinner-container .dot:nth-child(3) { transform: rotate(45deg) translate(45px); opacity: 0.2; }
        .dot-spinner-container .dot:nth-child(4) { transform: rotate(67.5deg) translate(45px); opacity: 0.25; }
        .dot-spinner-container .dot:nth-child(5) { transform: rotate(90deg) translate(45px); opacity: 0.3; }
        .dot-spinner-container .dot:nth-child(6) { transform: rotate(112.5deg) translate(45px); opacity: 0.4; }
        .dot-spinner-container .dot:nth-child(7) { transform: rotate(135deg) translate(45px); opacity: 0.5; }
        .dot-spinner-container .dot:nth-child(8) { transform: rotate(157.5deg) translate(45px); opacity: 0.6; }
        .dot-spinner-container .dot:nth-child(9) { transform: rotate(180deg) translate(45px); opacity: 0.7; }
        .dot-spinner-container .dot:nth-child(10) { transform: rotate(202.5deg) translate(45px); opacity: 0.8; }
        .dot-spinner-container .dot:nth-child(11) { transform: rotate(225deg) translate(45px); opacity: 0.85; }
        .dot-spinner-container .dot:nth-child(12) { transform: rotate(247.5deg) translate(45px); opacity: 0.9; }
        .dot-spinner-container .dot:nth-child(13) { transform: rotate(270deg) translate(45px); opacity: 0.95; }
        .dot-spinner-container .dot:nth-child(14) { transform: rotate(292.5deg) translate(45px); opacity: 1; }
        .dot-spinner-container .dot:nth-child(15) { transform: rotate(315deg) translate(45px); opacity: 1; }
        .dot-spinner-container .dot:nth-child(16) { transform: rotate(337.5deg) translate(45px); opacity: 1; }

        .loading-text {
            margin-top: 20px;
            font-size: 1.25rem;
            font-weight: 600;
            letter-spacing: 1px;
            color: #e2e8f0;
        }

        [data-bs-theme="light"] .loading-text {
            color: #334155;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ==========================================
            FORZADO GLOBAL DE MODO OSCURO / CLARO
           ========================================== */
        [data-bs-theme="dark"] body {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
        }

        [data-bs-theme="dark"] #content-wrapper {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
        }

        [data-bs-theme="dark"] #sidebar {
            background-color: #1e293b !important;
            border-right: 1px solid #334155 !important;
            color: #e2e8f0 !important;
        }

        [data-bs-theme="dark"] #sidebar .sidebar-link {
            color: #cbd5e1 !important;
        }

        [data-bs-theme="dark"] #sidebar .sidebar-link:hover,
        [data-bs-theme="dark"] #sidebar .sidebar-link.active {
            background-color: #334155 !important;
            color: #ffffff !important;
        }

        [data-bs-theme="dark"] #sidebar .sidebar-brand-text,
        [data-bs-theme="dark"] #sidebar .user-name-text,
        [data-bs-theme="dark"] #sidebar small {
            color: #e2e8f0 !important;
        }

        /* SOLUCIÓN DEFINITIVA: FORZAR TARJETAS Y CUADROS BLANCOS A MODO OSCURO */
        html[data-bs-theme="dark"] .card,
        html[data-bs-theme="dark"] .bg-white,
        html[data-bs-theme="dark"] [class*="bg-white"],
        html.dark .card,
        html.dark .bg-white,
        html.dark [class*="bg-white"] {
            background-color: #1e293b !important;
            color: #e2e8f0 !important;
            border-color: #334155 !important;
        }

        [data-bs-theme="dark"] .card-header,
        [data-bs-theme="dark"] .card-footer {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #e2e8f0 !important;
        }

        [data-bs-theme="dark"] h1,
        [data-bs-theme="dark"] h2,
        [data-bs-theme="dark"] h3,
        [data-bs-theme="dark"] h4,
        [data-bs-theme="dark"] h5,
        [data-bs-theme="dark"] h6,
        [data-bs-theme="dark"] .text-muted,
        [data-bs-theme="dark"] .text-dark,
        [data-bs-theme="dark"] .text-secondary {
            color: #94a3b8 !important;
        }

        [data-bs-theme="dark"] .card-title,
        [data-bs-theme="dark"] strong {
            color: #f8fafc !important;
        }

        [data-bs-theme="dark"] table.dataTable,
        [data-bs-theme="dark"] table.dataTable thead,
        [data-bs-theme="dark"] table.dataTable thead th,
        [data-bs-theme="dark"] table.dataTable thead td,
        [data-bs-theme="dark"] .table,
        [data-bs-theme="dark"] .table thead,
        [data-bs-theme="dark"] .table thead th,
        [data-bs-theme="dark"] .table thead td,
        [data-bs-theme="dark"] .table-success,
        [data-bs-theme="dark"] .table-success > th,
        [data-bs-theme="dark"] .table-success > td {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
            border-color: #334155 !important;
        }

        [data-bs-theme="dark"] table.dataTable thead th *,
        [data-bs-theme="dark"] .table thead th * {
            color: #e2e8f0 !important;
        }

        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
            border-color: #334155 !important;
        }

        /* ==========================================
            MODO CLARO (ESTÁNDAR)
           ========================================== */
        [data-bs-theme="light"] body {
            background-color: #f8fafc !important;
            color: #334155 !important;
        }

        [data-bs-theme="light"] #content-wrapper {
            background-color: #f8fafc !important;
            color: #334155 !important;
        }

        [data-bs-theme="light"] #sidebar {
            background-color: #ffffff !important;
            border-right: 1px solid #e2e8f0 !important;
            color: #334155 !important;
        }

        [data-bs-theme="light"] #sidebar .sidebar-link {
            color: #475569 !important;
        }

        [data-bs-theme="light"] #sidebar .sidebar-link:hover,
        [data-bs-theme="light"] #sidebar .sidebar-link.active {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
        }

        [data-bs-theme="light"] #sidebar .sidebar-brand-text,
        [data-bs-theme="light"] #sidebar .user-name-text {
            color: #334155 !important;
        }

        [data-bs-theme="light"] .card,
        [data-bs-theme="light"] .card-body,
        [data-bs-theme="light"] .dropdown-menu {
            background-color: #ffffff !important;
            color: #334155 !important;
            border-color: #e2e8f0 !important;
        }

        [data-bs-theme="light"] .card-header,
        [data-bs-theme="light"] .card-footer {
            background-color: #f8fafc !important;
            border-color: #e2e8f0 !important;
            color: #334155 !important;
        }

        [data-bs-theme="light"] table.dataTable thead th,
        [data-bs-theme="light"] table.dataTable thead td,
        [data-bs-theme="light"] .table thead th,
        [data-bs-theme="light"] .table thead td {
            background-color: #f8fafc !important;
            color: #334155 !important;
            border-color: #e2e8f0 !important;
        }

        [data-bs-theme="dark"] .dataTables_wrapper .dataTables_filter input,
        [data-bs-theme="dark"] .dataTables_wrapper .dataTables_length select {
            background-color: #0f172a;
            color: #e2e8f0;
            border-color: #334155;
        }

        .sidebar-footer {
            margin-top: auto;
        }
    </style>
<style id="legibilidad-final">
  /* Tablas en modo oscuro */
  html.dark table tbody tr, html.dark table tbody td, html.dark table tbody th,
  body.dark table tbody tr, body.dark table tbody td, body.dark table tbody th,
  body.dark-mode table tbody tr, body.dark-mode table tbody td, body.dark-mode table tbody th,
  body.tema-oscuro-activo table tbody tr, body.tema-oscuro-activo table tbody td, body.tema-oscuro-activo table tbody th {
    background-color: #1e293b !important;
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
    border-color: #475569 !important;
    opacity: 1 !important;
  }
  html.dark table tbody td *:not(.btn):not(button):not(.badge):not(i):not(svg):not(path),
  body.dark table tbody td *:not(.btn):not(button):not(.badge):not(i):not(svg):not(path),
  body.dark-mode table tbody td *:not(.btn):not(button):not(.badge):not(i):not(svg):not(path),
  body.tema-oscuro-activo table tbody td *:not(.btn):not(button):not(.badge):not(i):not(svg):not(path) {
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
    opacity: 1 !important;
  }

  /* Tablas en modo claro */
  html:not(.dark):not([data-theme="dark"]):not([data-bs-theme="dark"]) body:not(.dark):not(.dark-mode):not(.tema-oscuro-activo) table tbody tr,
  html:not(.dark):not([data-theme="dark"]):not([data-bs-theme="dark"]) body:not(.dark):not(.dark-mode):not(.tema-oscuro-activo) table tbody td,
  html:not(.dark):not([data-theme="dark"]):not([data-bs-theme="dark"]) body:not(.dark):not(.dark-mode):not(.tema-oscuro-activo) table tbody th {
    background-color: #ffffff !important;
    color: #0f172a !important;
    -webkit-text-fill-color: #0f172a !important;
    border-color: #e2e8f0 !important;
    opacity: 1 !important;
  }

  /* Numeros y textos dentro de tarjetas/cajas blancas */
  [class*="bg-white"]:not(table):not(tr):not(td):not(th) {
    background-color: #ffffff !important;
    color: #0f172a !important;
    opacity: 1 !important;
  }
  [class*="bg-white"]:not(table):not(tr):not(td):not(th) *:not(.btn):not(button):not(.badge):not(i):not(svg):not(path) {
    color: #0f172a !important;
    -webkit-text-fill-color: #0f172a !important;
    opacity: 1 !important;
  }

  /* Controles de tabla y etiquetas sobre fondo oscuro (Mostrar, registros por pagina, Buscar) */
  html.dark label:not([class*="bg-white"] *),
  html.dark .dataTables_wrapper label, html.dark .dataTables_wrapper .dataTables_info,
  html.dark .dataTables_wrapper .dataTables_length, html.dark .dataTables_wrapper .dataTables_filter,
  body.dark label:not([class*="bg-white"] *),
  body.dark .dataTables_wrapper label, body.dark .dataTables_wrapper .dataTables_info,
  body.dark .dataTables_wrapper .dataTables_length, body.dark .dataTables_wrapper .dataTables_filter,
  body.dark-mode label:not([class*="bg-white"] *),
  body.dark-mode .dataTables_wrapper label, body.dark-mode .dataTables_wrapper .dataTables_info,
  body.dark-mode .dataTables_wrapper .dataTables_length, body.dark-mode .dataTables_wrapper .dataTables_filter,
  body.tema-oscuro-activo label:not([class*="bg-white"] *),
  body.tema-oscuro-activo .dataTables_wrapper label, body.tema-oscuro-activo .dataTables_wrapper .dataTables_info,
  body.tema-oscuro-activo .dataTables_wrapper .dataTables_length, body.tema-oscuro-activo .dataTables_wrapper .dataTables_filter {
    color: #e2e8f0 !important;
    -webkit-text-fill-color: #e2e8f0 !important;
    opacity: 1 !important;
  }

  /* Texto "Mostrando X a Y de Z registros" y pie de tabla en modo oscuro */
  html.dark .dataTables_info, html.dark .pagination, html.dark .page-link,
  body.dark .dataTables_info, body.dark .pagination, body.dark .page-link,
  body.dark-mode .dataTables_info, body.dark-mode .pagination, body.dark-mode .page-link,
  body.tema-oscuro-activo .dataTables_info, body.tema-oscuro-activo .pagination, body.tema-oscuro-activo .page-link,
  html.dark [class*="dataTables"] .dataTables_info,
  body.dark [class*="dataTables"] .dataTables_info,
  body.dark-mode [class*="dataTables"] .dataTables_info,
  body.tema-oscuro-activo [class*="dataTables"] .dataTables_info {
    color: #e2e8f0 !important;
    -webkit-text-fill-color: #e2e8f0 !important;
    opacity: 1 !important;
  }
  html.dark .card-body > div:last-child p, html.dark .card-body > div:last-child span, html.dark .card-body > div:last-child small,
  body.dark .card-body > div:last-child p, body.dark .card-body > div:last-child span, body.dark .card-body > div:last-child small,
  body.dark-mode .card-body > div:last-child p, body.dark-mode .card-body > div:last-child span, body.dark-mode .card-body > div:last-child small,
  body.tema-oscuro-activo .card-body > div:last-child p, body.tema-oscuro-activo .card-body > div:last-child span, body.tema-oscuro-activo .card-body > div:last-child small {
    color: #e2e8f0 !important;
    -webkit-text-fill-color: #e2e8f0 !important;
    opacity: 1 !important;
  }

  /* Info de registros y paginacion en modo oscuro */
  html.dark [class*="paginacion"], html.dark [class*="paginacion"] *,
  html.dark div[id$="_info"], html.dark div[id$="_info"] *,
  body.dark [class*="paginacion"], body.dark [class*="paginacion"] *,
  body.dark div[id$="_info"], body.dark div[id$="_info"] *,
  body.dark-mode [class*="paginacion"], body.dark-mode [class*="paginacion"] *,
  body.dark-mode div[id$="_info"], body.dark-mode div[id$="_info"] *,
  body.tema-oscuro-activo [class*="paginacion"], body.tema-oscuro-activo [class*="paginacion"] *,
  body.tema-oscuro-activo div[id$="_info"], body.tema-oscuro-activo div[id$="_info"] * {
    color: #e2e8f0 !important;
    -webkit-text-fill-color: #e2e8f0 !important;
    opacity: 1 !important;
  }

  /* Numeros grandes y textos en tarjetas claras (Accesorios, Dashboard, etc.) */
  [class*="bg-white"] h1, [class*="bg-white"] h2, [class*="bg-white"] h3, [class*="bg-white"] h4,
  [class*="bg-white"] p, [class*="bg-white"] span:not(.badge), [class*="bg-white"] div,
  .card.bg-white *, .card[style*="background: #fff"] *, .card[style*="background-color: #fff"] *,
  .card[style*="background: white"] *, .card[style*="background-color: white"] * {
    color: #0f172a !important;
    -webkit-text-fill-color: #0f172a !important;
    opacity: 1 !important;
  }

  /* Numeros de tarjetas indicadoras (Accesorios y modulos con .indicador-contenido) */
  .indicador-contenido strong,
  .indicador-contenido [id^="indicador_"],
  strong[id^="indicador_"],
  html.dark .indicador-contenido strong,
  html.dark strong[id^="indicador_"],
  body.dark .indicador-contenido strong,
  body.dark strong[id^="indicador_"],
  body.dark-mode .indicador-contenido strong,
  body.dark-mode strong[id^="indicador_"],
  body.tema-oscuro-activo .indicador-contenido strong,
  body.tema-oscuro-activo strong[id^="indicador_"] {
    color: #0f172a !important;
    -webkit-text-fill-color: #0f172a !important;
    opacity: 1 !important;
  }

  /* Textos y etiquetas en tarjetas blancas del manual de usuario */
  .card strong, .card b, .card span:not(.badge), .card p, .card li, .card small,
  [class*="card"] strong, [class*="card"] b, [class*="card"] span:not(.badge), [class*="card"] p, [class*="card"] li,
  html.dark .card strong, html.dark .card b, html.dark .card span:not(.badge), html.dark .card p, html.dark .card li,
  body.dark .card strong, body.dark .card b, body.dark .card span:not(.badge), body.dark .card p, body.dark .card li,
  body.dark-mode .card strong, body.dark-mode .card b, body.dark-mode .card span:not(.badge), body.dark-mode .card p, body.dark-mode .card li,
  body.tema-oscuro-activo .card strong, body.tema-oscuro-activo .card b, body.tema-oscuro-activo .card span:not(.badge), body.tema-oscuro-activo .card p, body.tema-oscuro-activo .card li {
    color: #0f172a !important;
    -webkit-text-fill-color: #0f172a !important;
    opacity: 1 !important;
  }

  /* Visibilidad de Sesion activa y estado en la barra lateral */
  #sidebar [class*="sesion"], #sidebar [class*="sesion"] *,
  #sidebar [class*="status"], #sidebar [class*="status"] *,
  #sidebar .badge, #sidebar .alert,
  aside [class*="sesion"], aside [class*="sesion"] *,
  html.dark #sidebar [class*="sesion"], html.dark #sidebar [class*="sesion"] *,
  body.dark #sidebar [class*="sesion"], body.dark #sidebar [class*="sesion"] *,
  body.dark-mode #sidebar [class*="sesion"], body.dark-mode #sidebar [class*="sesion"] *,
  body.tema-oscuro-activo #sidebar [class*="sesion"], body.tema-oscuro-activo #sidebar [class*="sesion"] * {
    color: #bbf7d0 !important;
    -webkit-text-fill-color: #bbf7d0 !important;
    opacity: 1 !important;
  }
  #sidebar [class*="sesion"],
  aside [class*="sesion"] {
    background-color: rgba(22, 163, 74, 0.22) !important;
    border-color: rgba(74, 222, 128, 0.45) !important;
  }

  /* Sidebar inferior (Rol / Sesion activa), FILTROS y encabezado superior en modo oscuro */
  html.dark aside [class*="sesion"], html.dark aside [class*="sesion"] *,
  html.dark #sidebar [class*="sesion"], html.dark #sidebar [class*="sesion"] *,
  html.dark aside small, html.dark #sidebar small,
  body.dark aside [class*="sesion"], body.dark aside [class*="sesion"] *,
  body.dark #sidebar [class*="sesion"], body.dark #sidebar [class*="sesion"] *,
  body.dark aside small, body.dark #sidebar small,
  body.dark-mode aside [class*="sesion"], body.dark-mode aside [class*="sesion"] *,
  body.dark-mode #sidebar [class*="sesion"], body.dark-mode #sidebar [class*="sesion"] *,
  body.dark-mode aside small, body.dark-mode #sidebar small,
  body.tema-oscuro-activo aside [class*="sesion"], body.tema-oscuro-activo aside [class*="sesion"] *,
  body.tema-oscuro-activo #sidebar [class*="sesion"], body.tema-oscuro-activo #sidebar [class*="sesion"] *,
  body.tema-oscuro-activo aside small, body.tema-oscuro-activo #sidebar small {
    color: #e2e8f0 !important;
    -webkit-text-fill-color: #e2e8f0 !important;
    opacity: 1 !important;
  }
  html.dark .barra-filtros-equipos, html.dark .barra-filtros-equipos button, html.dark .barra-filtros-equipos span, html.dark .barra-filtros-equipos label,
  body.dark .barra-filtros-equipos, body.dark .barra-filtros-equipos button, body.dark .barra-filtros-equipos span, body.dark .barra-filtros-equipos label,
  body.dark-mode .barra-filtros-equipos, body.dark-mode .barra-filtros-equipos button, body.dark-mode .barra-filtros-equipos span, body.dark-mode .barra-filtros-equipos label,
  body.tema-oscuro-activo .barra-filtros-equipos, body.tema-oscuro-activo .barra-filtros-equipos button, body.tema-oscuro-activo .barra-filtros-equipos span, body.tema-oscuro-activo .barra-filtros-equipos label {
    color: #e2e8f0 !important;
    -webkit-text-fill-color: #e2e8f0 !important;
    opacity: 1 !important;
  }
  html.dark .card-header h1, html.dark .card-header h2, html.dark .card-header h3, html.dark .card-header h4, html.dark .card-header p,
  body.dark .card-header h1, body.dark .card-header h2, body.dark .card-header h3, body.dark .card-header h4, body.dark .card-header p,
  body.dark-mode .card-header h1, body.dark-mode .card-header h2, body.dark-mode .card-header h3, body.dark-mode .card-header h4, body.dark-mode .card-header p,
  body.tema-oscuro-activo .card-header h1, body.tema-oscuro-activo .card-header h2, body.tema-oscuro-activo .card-header h3, body.tema-oscuro-activo .card-header h4, body.tema-oscuro-activo .card-header p {
    color: #f8fafc !important;
    -webkit-text-fill-color: #f8fafc !important;
    opacity: 1 !important;
  }

  /* 1. Textos oscuros sobre tarjetas/contenedores claros en modo oscuro (Detalle prestamo, fichas, etc.) */
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo .card:not(.bg-dark):not([class*="bg-slate-9"]):not([class*="bg-gray-9"]) h1,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo .card:not(.bg-dark):not([class*="bg-slate-9"]):not([class*="bg-gray-9"]) h2,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo .card:not(.bg-dark):not([class*="bg-slate-9"]):not([class*="bg-gray-9"]) h3,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo .card:not(.bg-dark):not([class*="bg-slate-9"]):not([class*="bg-gray-9"]) h4,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo .card:not(.bg-dark):not([class*="bg-slate-9"]):not([class*="bg-gray-9"]) h5,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo .card:not(.bg-dark):not([class*="bg-slate-9"]):not([class*="bg-gray-9"]) h6,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo .card:not(.bg-dark):not([class*="bg-slate-9"]):not([class*="bg-gray-9"]) p,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo .card:not(.bg-dark):not([class*="bg-slate-9"]):not([class*="bg-gray-9"]) span:not(.badge),
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo .card:not(.bg-dark):not([class*="bg-slate-9"]):not([class*="bg-gray-9"]) small,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo .card:not(.bg-dark):not([class*="bg-slate-9"]):not([class*="bg-gray-9"]) strong,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo .card:not(.bg-dark):not([class*="bg-slate-9"]):not([class*="bg-gray-9"]) div:not(.badge) {
    color: #0f172a !important;
    -webkit-text-fill-color: #0f172a !important;
    opacity: 1 !important;
  }

  /* 2. Dropdowns (Exportar Excel/PDF), filtros y controles en modo oscuro */
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo .dropdown-menu,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo .dropdown-menu .dropdown-item,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo .dropdown-menu button,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo .dropdown-menu a {
    background-color: #1e293b !important;
    color: #f8fafc !important;
    -webkit-text-fill-color: #f8fafc !important;
    opacity: 1 !important;
  }
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo .dropdown-menu .dropdown-item:hover,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo .dropdown-menu button:hover,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo .dropdown-menu a:hover {
    background-color: #334155 !important;
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
  }
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo [class*="filtro"],
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo [class*="filtro"] *,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo button[data-bs-toggle*="filtro"],
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo button[data-bs-toggle*="filtro"] * {
    color: #e2e8f0 !important;
    -webkit-text-fill-color: #e2e8f0 !important;
    opacity: 1 !important;
  }

  /* 3. Parte inferior del sidebar (Rol, badge y Sesion activa) */
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo aside,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo #sidebar,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo nav[class*="sidebar"] {
    overflow-y: auto !important;
  }
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo aside .badge,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo #sidebar .badge,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo aside [class*="rol"],
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo #sidebar [class*="rol"],
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo aside [class*="sesion"],
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo #sidebar [class*="sesion"],
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo aside [class*="sesion"] *,
  html.dark, body.dark, body.dark-mode, body.tema-oscuro-activo #sidebar [class*="sesion"] * {
    color: #f8fafc !important;
    -webkit-text-fill-color: #f8fafc !important;
    opacity: 1 !important;
  }
</style>
<style id="solo-logo-sidebar-cerrado">
  aside.w-16 a[href*="password"], aside.w-16 button[onclick*="password"],
  aside.w-20 a[href*="password"], aside.w-20 button[onclick*="password"],
  aside.collapsed a[href*="password"], aside.collapsed button[onclick*="password"],
  aside.w-16 a[href*="logout"], aside.w-16 button[type="submit"],
  aside.w-20 a[href*="logout"], aside.w-20 button[type="submit"],
  aside.collapsed a[href*="logout"], aside.collapsed button[type="submit"] {
    padding-left: 6px !important;
    padding-right: 6px !important;
    justify-content: center !important;
  }
</style>
<style id="logo-menu-usuario-cerrado">
  aside.collapsed .texto-menu-usuario,
  aside.sidebar-collapsed .texto-menu-usuario,
  aside.is-collapsed .texto-menu-usuario,
  aside.mini .texto-menu-usuario,
  aside.w-16 .texto-menu-usuario,
  aside.w-20 .texto-menu-usuario,
  .sidebar.collapsed .texto-menu-usuario,
  .sidebar.sidebar-collapsed .texto-menu-usuario,
  .sidebar.is-collapsed .texto-menu-usuario,
  .sidebar.mini .texto-menu-usuario,
  .sidebar.w-16 .texto-menu-usuario,
  .sidebar.w-20 .texto-menu-usuario,
  body.sidebar-collapsed .texto-menu-usuario,
  body.sb-collapsed .texto-menu-usuario {
    display: none !important;
  }
  aside.collapsed .dropdown-menu .dropdown-item,
  aside.sidebar-collapsed .dropdown-menu .dropdown-item,
  aside.is-collapsed .dropdown-menu .dropdown-item,
  aside.mini .dropdown-menu .dropdown-item,
  aside.w-16 .dropdown-menu .dropdown-item,
  aside.w-20 .dropdown-menu .dropdown-item,
  .sidebar.collapsed .dropdown-menu .dropdown-item,
  .sidebar.sidebar-collapsed .dropdown-menu .dropdown-item,
  .sidebar.is-collapsed .dropdown-menu .dropdown-item,
  .sidebar.mini .dropdown-menu .dropdown-item,
  .sidebar.w-16 .dropdown-menu .dropdown-item,
  .sidebar.w-20 .dropdown-menu .dropdown-item {
    justify-content: center !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
  }
  aside.collapsed .dropdown-menu .dropdown-item i,
  aside.sidebar-collapsed .dropdown-menu .dropdown-item i,
  aside.is-collapsed .dropdown-menu .dropdown-item i,
  aside.mini .dropdown-menu .dropdown-item i,
  aside.w-16 .dropdown-menu .dropdown-item i,
  aside.w-20 .dropdown-menu .dropdown-item i,
  .sidebar.collapsed .dropdown-menu .dropdown-item i,
  .sidebar.sidebar-collapsed .dropdown-menu .dropdown-item i,
  .sidebar.is-collapsed .dropdown-menu .dropdown-item i,
  .sidebar.mini .dropdown-menu .dropdown-item i,
  .sidebar.w-16 .dropdown-menu .dropdown-item i,
  .sidebar.w-20 .dropdown-menu .dropdown-item i {
    margin-right: 0 !important;
  }
</style>
<style id="sidebar-collapsed-user-logo">
  #sidebar.collapsed .user-dropdown-container .dropdown-menu {
    min-width: auto !important;
    width: auto !important;
    padding: 4px !important;
  }
  #sidebar.collapsed .user-dropdown-container .dropdown-item {
    justify-content: center !important;
    padding: 6px 8px !important;
    font-size: 0 !important;
    gap: 0 !important;
  }
  #sidebar.collapsed .user-dropdown-container .dropdown-item .texto-menu-usuario {
    display: none !important;
    font-size: 0 !important;
  }
  #sidebar.collapsed .user-dropdown-container .dropdown-item i,
  #sidebar.collapsed .user-dropdown-container .dropdown-item svg {
    font-size: 1.1rem !important;
    margin-right: 0 !important;
  }
</style>
</head>

<body>
    <!-- PANTALLA DE CARGA (LOADER) -->
    <div id="page-loader">
        <div class="dot-spinner-container">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
        <div class="loading-text">Cargando......</div>
    </div>

    <div id="app">
        @auth
        <div id="app-container">
            <!-- BARRA LATERAL -->
            <nav id="sidebar" class="shadow-sm">
                <script>
                    if (localStorage.getItem('sidebarCollapsed') === 'true') {
                        document.currentScript.parentElement.classList.add('collapsed');
                    }
                </script>
                <div>
                    <!-- Cabecera de la Barra Lateral -->
                    <div class="d-flex align-items-center mb-3 px-1">
                        <button id="sidebar-toggle" class="btn btn-sm btn-outline-secondary rounded-circle me-2 btn-accion"
                            title="Ocultar/Mostrar menú">
                            <i class="bi bi-list"></i>
                        </button>
                        <a class="sidebar-brand d-flex align-items-center px-3 py-3 text-decoration-none" href="{{ url('/home') }}">
                            <img src="{{ asset('logo/logo.jpg') }}" alt="Logo" style="height: 36px; width: auto; border-radius: 6px; margin-right: 10px;">
                            <span class="sidebar-brand-text fw-bold" style="font-size: 0.95rem; line-height: 1.2;">
                                Inventario de Equipos<br>Tecnológicos 2026
                            </span>
                        </a>
                    </div>

                    <!-- Enlaces de navegación -->
                    <div class="nav flex-column">
                        <a href="{{ url('/home') }}"
                            class="sidebar-link {{ request()->routeIs('home') || request()->is('/') ? 'active' : '' }}"
                            title="Inicio">
                            <i class="bi bi-house-door me-3 fs-5"></i>
                            <span class="sidebar-text">Inicio</span>
                        </a>

                        <a href="{{ route('prestamos.index') }}"
                            class="sidebar-link {{ request()->routeIs('prestamos.*') ? 'active' : '' }}" title="Préstamos">
                            <i class="bi bi-journal-check me-3 fs-5"></i>
                            <span class="sidebar-text">Préstamos</span>
                        </a>

                        <a href="{{ route('equipos.index') }}"
                            class="sidebar-link {{ request()->routeIs('equipos.*') ? 'active' : '' }}" title="Equipos">
                            <i class="bi bi-laptop me-3 fs-5"></i>
                            <span class="sidebar-text">Equipos</span>
                        </a>

                        @can('gestionar-bajas')
                            <a href="{{ route('bajas-equipos.index') }}"
                                class="sidebar-link {{ request()->routeIs('bajas-equipos.*') ? 'active' : '' }}"
                                title="Bajas Administrativas">
                                <i class="bi bi-archive me-3 fs-5"></i>
                                <span class="sidebar-text">Bajas Administrativas</span>
                            </a>
                        @endcan

                        <a href="{{ route('accesorios-equipo.index') }}"
                            class="sidebar-link {{ request()->routeIs('accesorios-equipo.*') ? 'active' : '' }}"
                            title="Accesorios Equipo">
                            <i class="bi bi-mouse me-3 fs-5"></i>
                            <span class="sidebar-text">Accesorios Equipo</span>
                        </a>

                        <a href="{{ route('docentes.index') }}"
                            class="sidebar-link {{ request()->routeIs('docentes.*') ? 'active' : '' }}"
                            title="Solicitantes">
                            <i class="bi bi-people me-3 fs-5"></i>
                            <span class="sidebar-text">Solicitantes</span>
                        </a>

                        <a href="{{ route('tipos-equipo.index') }}"
                            class="sidebar-link {{ request()->routeIs('tipos-equipo.*') ? 'active' : '' }}"
                            title="Tipos Equipos">
                            <i class="bi bi-tags me-3 fs-5"></i>
                            <span class="sidebar-text">Tipos Equipos</span>
                        </a>

                        <a href="{{ route('ubicaciones.index') }}"
                            class="sidebar-link {{ request()->routeIs('ubicaciones.*') ? 'active' : '' }}"
                            title="Ubicaciones">
                            <i class="bi bi-geo-alt me-3 fs-5"></i>
                            <span class="sidebar-text">Ubicaciones</span>
                        </a>

                        <a class="sidebar-link" title="Manual del Usuario"
                            href="/manual-usuario">
                            <i class="bi bi-file-earmark-text me-3 fs-5"></i>
                            <span class="sidebar-text">Manual del Usuario</span>
                        </a>
                    </div>
                </div>

                @can('gestionar-usuarios')
                <a href="{{ route('usuarios.index') }}"
                    class="sidebar-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}"
                    title="Usuarios">
                    <i class="bi bi-person-gear me-3 fs-5"></i>
                    <span class="sidebar-text">Usuarios</span>
                </a>
                @endcan

                <!-- Pie de la Barra Lateral -->
                <div class="pt-2 border-top mt-2 flex-shrink-0">
                    <button id="btn-switch-theme"
                        class="btn btn-sm btn-outline-secondary w-100 d-flex align-items-center justify-content-center gap-2 mb-2"
                        type="button" title="Cambiar Tema" onclick="toggleThemeDirecto()">
                        <i id="themeIcon" class="fas fa-moon me-1"></i>
                        <span id="themeText" class="sidebar-text">Modo Oscuro</span>
                    </button>
                    
                    @auth
                    {{-- Nombre del usuario (con dropdown) --}}
                    <div class="dropdown user-dropdown-container px-1 mb-2">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle py-1"
                            id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false"
                            title="{{ Auth::user()->name }}">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                style="width: 32px; height: 32px; font-weight: bold; font-size: 14px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="user-name-text small fw-semibold text-truncate">{{ Auth::user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser" style="min-width: 200px;">
                            <li>
                                <a class="dropdown-item d-flex align-items-center text-dark" href="{{ route('cuenta.password.edit') }}">
                                    <i class="bi bi-key me-2"></i> <span class="texto-menu-usuario">Cambiar contraseña</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center text-danger" href="{{ route('logout') }}"
                                    onclick="confirmarCierreSesion(event, document.getElementById('logout-form-dropdown'));">
                                    <i class="bi bi-box-arrow-right me-2"></i> <span class="texto-menu-usuario">Cerrar sesión</span>
                                </a>
                            </li>
                        </ul>

                        <form id="logout-form-dropdown" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>

                    {{-- Tarjetas de rol y sesión --}}
                    <div class="user-info-cards">
                        <div class="px-1 mb-2">
                            <div class="card border-0 mb-0">
                                <div class="card-body p-2 text-center">
                                    <small class="text-muted d-block" style="font-size: 0.7rem;">Rol</small>
                                    <span class="badge bg-primary">{{ Auth::user()->etiquetaRol() }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="px-1">
                            <div class="card border-success mb-0">
                                <div class="card-body p-2 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <small class="text-success fw-semibold">Sesión activa</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @else
                    <div class="auth-buttons-container d-flex flex-column gap-1 px-1">
                        @if (Route::has('login'))
                        <a class="btn btn-outline-primary btn-sm px-2 py-1 text-decoration-none d-flex align-items-center"
                            href="{{ route('login') }}" title="Iniciar sesión" style="font-size: 0.75rem;">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                        </a>
                        @endif
                    </div>
                    @endauth
                </div>
            </nav>

            <!-- CONTENEDOR PRINCIPAL DERECHO -->
            <div id="content-wrapper">
                <main class="py-4 px-4 flex-grow-1">
                    @yield('content')
                </main>
            </div>
        </div>
        @else
        <main class="py-5">
            @yield('content')
        </main>
        @endauth
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>

    <!-- Script para ocultar y mostrar el loader -->
    <script>
        (function() {
            const loader = document.getElementById('page-loader');
            if (!loader) return;

            function ocultarLoader() {
                loader.style.opacity = '0';
                loader.style.pointerEvents = 'none';
                setTimeout(function() {
                    loader.style.display = 'none';
                }, 200);
            }

            function mostrarLoader() {
                if (document.querySelector('.swal2-container')) return;
                loader.style.display = 'flex';
                loader.style.pointerEvents = 'auto';
                loader.style.opacity = '1';
            }

            window.addEventListener('load', ocultarLoader);
            window.addEventListener('pageshow', ocultarLoader);
            window.addEventListener('popstate', ocultarLoader);

            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (!link) return;

                const href = link.getAttribute('href') || '';
                if (!href || href === '#' || href.startsWith('#') || href.startsWith('javascript:')) return;
                if (link.target === '_blank') return;
                if (link.hasAttribute('download')) return;
                if (href.indexOf('export') !== -1) return;
                if (href.indexOf('acta') !== -1) return;
                if (link.hasAttribute('onclick')) return;
                if (link.hostname && link.hostname !== window.location.hostname) return;
                if (document.querySelector('.swal2-container')) return;

                mostrarLoader();
            });

            document.addEventListener('submit', function(e) {
                if (e.defaultPrevented) return;
                if (document.querySelector('.swal2-container')) return;
                mostrarLoader();
            });
        })();
    </script>

    <!-- Script de Sincronización de Tema Limpio y Efectivo -->
    <script>
        function actualizarBotonTema(theme) {
            const themeIcon = document.getElementById('themeIcon');
            const themeText = document.getElementById('themeText');
            if (themeIcon && themeText) {
                if (theme === 'dark') {
                    themeIcon.className = 'fas fa-sun me-1';
                    themeText.textContent = 'Modo Claro';
                } else {
                    themeIcon.className = 'fas fa-moon me-1';
                    themeText.textContent = 'Modo Oscuro';
                }
            }
        }

        function toggleThemeDirecto() {
            const htmlTag = document.documentElement;
            const currentTheme = htmlTag.getAttribute('data-bs-theme') || 'light';
            const newTheme = (currentTheme === 'dark') ? 'light' : 'dark';

            htmlTag.setAttribute('data-bs-theme', newTheme);
            htmlTag.classList.toggle('dark', newTheme === 'dark');
            localStorage.setItem('theme', newTheme);
            actualizarBotonTema(newTheme);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const temaGuardado = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', temaGuardado);
            document.documentElement.classList.toggle('dark', temaGuardado === 'dark');
            actualizarBotonTema(temaGuardado);

            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    localStorage.setItem(
                        'sidebarCollapsed',
                        sidebar.classList.contains('collapsed') ? 'true' : 'false'
                    );
                });
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmarEliminar(form) {
            const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
            Swal.fire({
                title: '¿Eliminar registro?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                background: isDark ? '#1e293b' : '#ffffff',
                color: isDark ? '#e2e8f0' : '#334155',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
        }

        function confirmarCierreSesion(event, form) {
            event.preventDefault();
            const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
            Swal.fire({
                title: '¿Deseas cerrar sesión?',
                text: 'Tendrás que iniciar sesión nuevamente para ingresar.',
                icon: 'question',
                background: isDark ? '#1e293b' : '#ffffff',
                color: isDark ? '#e2e8f0' : '#334155',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

    @php
    $mensajeToast = session('success') ?? session('error') ?? session('warning');
    $tipoToast = session('toast_tipo', session('success') ? 'exito' : 'error');
    @endphp

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        (function() {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 3500,
                showMethod: 'fadeIn',
                hideMethod: 'fadeOut'
            };
        })();
    </script>

    @if (session('success') || session('error') || session('warning'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tipo = @json(session('toast_tipo'));
            const mensaje = @json(session('success') ?? session('error') ?? session('warning'));

            if (tipo === 'error') {
                toastr.error(mensaje);
            } else if (tipo === 'aviso' || tipo === 'warning') {
                toastr.warning(mensaje);
            } else {
                toastr.success(mensaje);
            }
        });
    </script>
    @endif

    @stack('scripts')<style id="fix-both-modes-clean">
  /* MODO CLARO: cabecera de tabla clara con texto oscuro legible */
  html:not(.dark):not([data-bs-theme="dark"]) table thead,
  html:not(.dark):not([data-bs-theme="dark"]) table thead tr,
  html:not(.dark):not([data-bs-theme="dark"]) table thead th,
  body:not(.dark):not(.dark-mode):not(.tema-oscuro-activo):not([data-bs-theme="dark"]) table thead,
  body:not(.dark):not(.dark-mode):not(.tema-oscuro-activo):not([data-bs-theme="dark"]) table thead tr,
  body:not(.dark):not(.dark-mode):not(.tema-oscuro-activo):not([data-bs-theme="dark"]) table thead th {
    background-color: #e2e8f0 !important;
    color: #0f172a !important;
    border-color: #cbd5e1 !important;
    opacity: 1 !important;
  }

  html:not(.dark):not([data-bs-theme="dark"]) table thead th *,
  body:not(.dark):not(.dark-mode):not(.tema-oscuro-activo):not([data-bs-theme="dark"]) table thead th * {
    color: #0f172a !important;
    fill: #0f172a !important;
    opacity: 1 !important;
  }

  /* MODO OSCURO: cabecera de tabla oscura con texto blanco y titulos visibles */
  html.dark table thead,
  html.dark table thead tr,
  html.dark table thead th,
  html[data-bs-theme="dark"] table thead,
  html[data-bs-theme="dark"] table thead tr,
  html[data-bs-theme="dark"] table thead th,
  body.dark table thead,
  body.dark table thead tr,
  body.dark table thead th,
  body.dark-mode table thead,
  body.dark-mode table thead tr,
  body.dark-mode table thead th,
  body.tema-oscuro-activo table thead,
  body.tema-oscuro-activo table thead tr,
  body.tema-oscuro-activo table thead th {
    background-color: #0f172a !important;
    color: #ffffff !important;
    border-color: #334155 !important;
    opacity: 1 !important;
  }

  html.dark table thead th *,
  html[data-bs-theme="dark"] table thead th *,
  body.dark table thead th *,
  body.dark-mode table thead th *,
  body.tema-oscuro-activo table thead th * {
    color: #ffffff !important;
    fill: #ffffff !important;
    opacity: 1 !important;
  }

  /* Botones de acciones en tabla: conservar visibilidad clara en ambos modos */
  table tbody td .btn,
  table tbody td button,
  table tbody td a.btn {
    opacity: 1 !important;
  }
</style>
<script id="fix-both-modes-clean">
(function() {
  function detectDarkMode() {
    var attrHtml = (document.documentElement.getAttribute("data-bs-theme") || "").toLowerCase();
    var attrBody = (document.body && document.body.getAttribute("data-bs-theme") || "").toLowerCase();
    var cls = ((document.documentElement.className || "") + " " + ((document.body && document.body.className) || "")).toLowerCase();
    var btnText = (document.body && document.body.innerText) || "";
    if (attrHtml === "dark" || attrBody === "dark") return true;
    if (cls.indexOf("dark") !== -1 || cls.indexOf("tema-oscuro") !== -1) return true;
    if (btnText.indexOf("Modo Claro") !== -1) return true;
    return false;
  }

  function applyThemeLegibility() {
    var isDark = detectDarkMode();

    // 1. Encabezado de tabla segun modo claro u oscuro
    document.querySelectorAll("table thead th").forEach(function(th) {
      var bg = isDark ? "#0f172a" : "#e2e8f0";
      var fg = isDark ? "#ffffff" : "#0f172a";
      th.style.setProperty("background-color", bg, "important");
      th.style.setProperty("color", fg, "important");
      th.style.setProperty("opacity", "1", "important");
      th.querySelectorAll("*").forEach(function(ch) {
        ch.style.setProperty("color", fg, "important");
        ch.style.setProperty("fill", fg, "important");
        ch.style.setProperty("opacity", "1", "important");
      });
    });

    // 2. Boton FILTROS fuera de la tabla
    document.querySelectorAll("button, a").forEach(function(el) {
      if (el.closest("table")) return;
      var txt = (el.innerText || el.textContent || "").trim().toUpperCase();
      if (txt.indexOf("FILTRO") === -1 || txt.length > 35) return;

      var bg = isDark ? "#1e293b" : "#f1f5f9";
      var fg = isDark ? "#f8fafc" : "#0f172a";
      var bd = isDark ? "#64748b" : "#cbd5e1";

      el.style.setProperty("background-color", bg, "important");
      el.style.setProperty("border-color", bd, "important");
      el.style.setProperty("color", fg, "important");
      el.style.setProperty("opacity", "1", "important");

      el.querySelectorAll("*").forEach(function(ch) {
        ch.style.setProperty("color", fg, "important");
        ch.style.setProperty("fill", fg, "important");
        ch.style.setProperty("stroke", fg, "important");
        ch.style.setProperty("opacity", "1", "important");
      });
    });

    // 3. Titulos, subtitulos y etiquetas fuera de tablas/botones/badges
    document.querySelectorAll("h1, h2, h3, h4, h5, h6, p, label, span, div").forEach(function(el) {
      if (el.closest("table") || el.closest("button") || el.closest("a") || el.closest(".badge") || el.closest(".btn")) return;
      var hasDirectText = Array.prototype.some.call(el.childNodes, function(n) {
        return n.nodeType === 3 && n.textContent.trim().length > 0;
      });
      if (!hasDirectText) return;

      var cs = window.getComputedStyle(el);
      var col = cs.color || "";
      var m = col.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/);
      if (!m) return;

      var r = parseInt(m[1], 10), g = parseInt(m[2], 10), b = parseInt(m[3], 10);

      if (isDark) {
        // En modo oscuro, si el texto es oscuro o transparente, volverlo claro
        if ((r < 115 && g < 115 && b < 115) || parseFloat(cs.opacity || "1") < 0.5) {
          var targetDark = /^H[1-6]$/.test(el.tagName) ? "#ffffff" : "#e2e8f0";
          el.style.setProperty("color", targetDark, "important");
          el.style.setProperty("opacity", "1", "important");
        }
      } else {
        // En modo claro, si el texto es muy claro (blanco/gris claro), volverlo oscuro
        if ((r > 210 && g > 210 && b > 210) || parseFloat(cs.opacity || "1") < 0.5) {
          var targetLight = /^H[1-6]$/.test(el.tagName) ? "#0f172a" : "#334155";
          el.style.setProperty("color", targetLight, "important");
          el.style.setProperty("opacity", "1", "important");
        }
      }
    });
  }

  applyThemeLegibility();
  document.addEventListener("DOMContentLoaded", function() {
    applyThemeLegibility();
    setTimeout(applyThemeLegibility, 200);
    setTimeout(applyThemeLegibility, 650);
  });
  window.addEventListener("load", applyThemeLegibility);
  document.addEventListener("click", function() {
    setTimeout(applyThemeLegibility, 90);
  });
})();
</script><style id="fix-btn-accion-dark">
  /* Solo en Modo Oscuro: iconos dentro de .btn-accion bien visibles */
  html.dark .btn-accion,
  html.dark .btn-accion i,
  html.dark .btn-accion svg,
  html[data-bs-theme="dark"] .btn-accion,
  html[data-bs-theme="dark"] .btn-accion i,
  html[data-bs-theme="dark"] .btn-accion svg,
  body.dark .btn-accion,
  body.dark .btn-accion i,
  body.dark .btn-accion svg,
  body.dark-mode .btn-accion,
  body.dark-mode .btn-accion i,
  body.dark-mode .btn-accion svg,
  body.tema-oscuro-activo .btn-accion,
  body.tema-oscuro-activo .btn-accion i,
  body.tema-oscuro-activo .btn-accion svg {
    opacity: 1 !important;
  }

  html.dark .btn-accion i,
  html.dark .btn-accion svg,
  html[data-bs-theme="dark"] .btn-accion i,
  html[data-bs-theme="dark"] .btn-accion svg,
  body.dark .btn-accion i,
  body.dark .btn-accion svg,
  body.dark-mode .btn-accion i,
  body.dark-mode .btn-accion svg,
  body.tema-oscuro-activo .btn-accion i,
  body.tema-oscuro-activo .btn-accion svg {
    color: #0f172a !important;
    fill: #0f172a !important;
    stroke: #0f172a !important;
  }
</style>
<script id="fix-btn-accion-dark">
(function() {
  function esOscuro() {
    var hAttr = (document.documentElement.getAttribute("data-bs-theme") || "").toLowerCase();
    var bAttr = (document.body && document.body.getAttribute("data-bs-theme") || "").toLowerCase();
    var cls = ((document.documentElement.className || "") + " " + ((document.body && document.body.className) || "")).toLowerCase();
    var txt = (document.body && document.body.innerText) || "";
    return hAttr === "dark" || bAttr === "dark" || cls.indexOf("dark") !== -1 || cls.indexOf("tema-oscuro") !== -1 || txt.indexOf("Modo Claro") !== -1;
  }

  function aplicarAjustePuntual() {
    if (!esOscuro()) return;

    // 1. Iconos dentro de .btn-accion (y botones de acciones en tbody)
    document.querySelectorAll(".btn-accion, table tbody td .btn, table tbody td button, table tbody td a").forEach(function(el) {
      el.style.setProperty("opacity", "1", "important");
      el.querySelectorAll("i, svg, path").forEach(function(ic) {
        ic.style.setProperty("color", "#0f172a", "important");
        ic.style.setProperty("fill", "#0f172a", "important");
        ic.style.setProperty("stroke", "#0f172a", "important");
        ic.style.setProperty("opacity", "1", "important");
      });
    });

    // 2. Titulo PRÉSTAMOS y subtitulo "Consulta y administra los préstamos..."
    document.querySelectorAll("h1, h2, h3, h4, p, span, div, small, label").forEach(function(el) {
      if (el.closest("table") || el.closest("button") || el.closest("a") || el.closest(".btn") || el.closest(".badge")) return;
      var t = (el.textContent || "").trim();
      var up = t.toUpperCase();
      if (up === "PRÉSTAMOS" || up === "PRESTAMOS") {
        el.style.setProperty("color", "#ffffff", "important");
        el.style.setProperty("opacity", "1", "important");
      } else if (t.indexOf("Consulta y administra los préstamos") !== -1 || t.indexOf("Consulta y administra los prestamos") !== -1) {
        el.style.setProperty("color", "#cbd5e1", "important");
        el.style.setProperty("opacity", "1", "important");
      }
    });
  }

  aplicarAjustePuntual();
  document.addEventListener("DOMContentLoaded", function() {
    aplicarAjustePuntual();
    setTimeout(aplicarAjustePuntual, 250);
    setTimeout(aplicarAjustePuntual, 700);
  });
  window.addEventListener("load", aplicarAjustePuntual);
})();
</script>
</body>

</html>





<style id="legibilidad-override-final">
  /* Bloques de detalle (.bloque-dato, .etiqueta, .valor) sobre tarjetas claras en modo oscuro */
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo .bloque-dato,
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo .bloque-dato *,
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo .etiqueta,
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo .etiqueta *,
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo .valor,
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo .valor * {
    color: #0f172a !important;
    -webkit-text-fill-color: #0f172a !important;
    opacity: 1 !important;
  }

  /* Mantener blanco/claro si el .bloque-dato esta dentro de un contenedor oscuro */
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo [class*="bg-dark"] .bloque-dato,
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo [class*="bg-dark"] .bloque-dato *,
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo [class*="bg-dark"] .etiqueta,
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo [class*="bg-dark"] .etiqueta *,
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo [class*="bg-dark"] .valor,
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo [class*="bg-dark"] .valor * {
    color: #f8fafc !important;
    -webkit-text-fill-color: #f8fafc !important;
  }

  /* Botones y paneles de FILTROS, dropdowns y sidebar inferior */
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo button[id*="filtro"], [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo button[id*="filtro"] *,
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo button[class*="filtro"], [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo button[class*="filtro"] *,
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo [id*="filtro"], [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo [id*="filtro"] *,
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo [class*="filtro"], [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo [class*="filtro"] *,
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo .dropdown-menu, [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo .dropdown-menu *,
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo #sidebar small, [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo #sidebar [class*="sesion"], [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo #sidebar [class*="sesion"] *,
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo #sidebar [class*="rol"] {
    color: #f8fafc !important;
    -webkit-text-fill-color: #f8fafc !important;
    opacity: 1 !important;
  }
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo .dropdown-menu {
    background-color: #1e293b !important;
    border-color: #334155 !important;
  }
  [data-bs-theme="dark"], html[data-bs-theme="dark"], body.dark, body.dark-mode, body.tema-oscuro-activo #sidebar {
    overflow-y: auto !important;
  }
</style>
