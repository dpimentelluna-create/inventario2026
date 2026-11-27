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
        #sidebar { overflow-x: hidden !important; scrollbar-width: none !important; }
        #sidebar::-webkit-scrollbar { display: none !important; }
        #sidebar.collapsed .sidebar-brand img { display: none !important; }

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
        html[data-bs-theme="dark"] .bg-success-subtle,
        html[data-bs-theme="dark"] [class*="bg-success-subtle"],
        html.dark .card,
        html.dark .bg-success-subtle,
        html.dark [class*="bg-success-subtle"] {
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
            background-color: #ecfdf5 !important;
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
            background-color: #ecfdf5 !important;
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
  [class*="bg-success-subtle"]:not(table):not(tr):not(td):not(th) {
    background-color: #ecfdf5 !important;
    color: #0f172a !important;
    opacity: 1 !important;
  }
  [class*="bg-success-subtle"]:not(table):not(tr):not(td):not(th) *:not(.btn):not(button):not(.badge):not(i):not(svg):not(path) {
    color: #0f172a !important;
    -webkit-text-fill-color: #0f172a !important;
    opacity: 1 !important;
  }

  /* Controles de tabla y etiquetas sobre fondo oscuro (Mostrar, registros por pagina, Buscar) */
  html.dark label:not([class*="bg-success-subtle"] *),
  html.dark .dataTables_wrapper label, html.dark .dataTables_wrapper .dataTables_info,
  html.dark .dataTables_wrapper .dataTables_length, html.dark .dataTables_wrapper .dataTables_filter,
  body.dark label:not([class*="bg-success-subtle"] *),
  body.dark .dataTables_wrapper label, body.dark .dataTables_wrapper .dataTables_info,
  body.dark .dataTables_wrapper .dataTables_length, body.dark .dataTables_wrapper .dataTables_filter,
  body.dark-mode label:not([class*="bg-success-subtle"] *),
  body.dark-mode .dataTables_wrapper label, body.dark-mode .dataTables_wrapper .dataTables_info,
  body.dark-mode .dataTables_wrapper .dataTables_length, body.dark-mode .dataTables_wrapper .dataTables_filter,
  body.tema-oscuro-activo label:not([class*="bg-success-subtle"] *),
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
  [class*="bg-success-subtle"] h1, [class*="bg-success-subtle"] h2, [class*="bg-success-subtle"] h3, [class*="bg-success-subtle"] h4,
  [class*="bg-success-subtle"] p, [class*="bg-success-subtle"] span:not(.badge), [class*="bg-success-subtle"] div,
  .card.bg-success-subtle *, .card[style*="background: #d1fae5"] *, .card[style*="background-color: #ecfdf5"] *,
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
</style><!-- INV_THEME_FIX_CSS_START -->
<style id="inv-theme-fix-css">
  /* Solo corregir textos con bajo contraste en Modo Oscuro sin pisar componentes propios */
  html.dark main .text-muted,
  body.dark main .text-muted,
  html[data-bs-theme="dark"] main .text-muted {
    color: #94a3b8 !important;
  }

  /* Tarjetas o cajas blancas dentro de modo oscuro: evitar texto blanco sobre blanco */
  html.dark main :is(.bg-success-subtle, [style*="background:#fff"], [style*="background: #fff"], [style*="background:#ffffff"], [style*="background: #ffffff"], [style*="background-color:#fff"], [style*="background-color: #fff"], [style*="background-color:#ffffff"], [style*="background-color: #ffffff"]),
  body.dark main :is(.bg-success-subtle, [style*="background:#fff"], [style*="background: #fff"], [style*="background:#ffffff"], [style*="background: #ffffff"], [style*="background-color:#fff"], [style*="background-color: #fff"], [style*="background-color:#ffffff"], [style*="background-color: #ffffff"]),
  html[data-bs-theme="dark"] main :is(.bg-success-subtle, [style*="background:#fff"], [style*="background: #fff"], [style*="background:#ffffff"], [style*="background: #ffffff"], [style*="background-color:#fff"], [style*="background-color: #fff"], [style*="background-color:#ffffff"], [style*="background-color: #ffffff"]) {
    background-color: #111827 !important;
    color: #f8fafc !important;
    border-color: #334155 !important;
  }

  /* Modo Claro: asegurar texto oscuro legible en textos apagados */
  html:not(.dark):not([data-bs-theme="dark"]) body:not(.dark) main .text-muted {
    color: #475569 !important;
  }
</style>
<!-- INV_THEME_FIX_CSS_END -->

<!-- FIX_FILTROS_EXPORTAR_START -->
<!-- FIX_FILTROS_EXPORTAR_END --><!-- FIX_HAMBURGER_LINES_START -->
<!-- FIX_HAMBURGER_LINES_END --></head>

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
                        <a class="sidebar-brand d-flex align-items-center px-3 py-3 text-decoration-none" href="{{ url('/inicio-previo') }}">
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
                        type="button" title="Cambiar Tema" onclick="toggleThemeDirecto()" style="display:none !important;">
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

    @stack('scripts')<!-- FIX_ALL_THEMES_AUTO_START -->
<!-- FIX_ALL_THEMES_AUTO_END -->
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
















































<style id="tema-verde-sidebar-contraste-total">
  /* Ocultar el botón/rectángulo de cambio de modo */
  [id*="modo-oscuro"],
  [id*="dark-mode"],
  [id*="theme-toggle"],
  [class*="modo-oscuro"],
  [class*="dark-mode"],
  [class*="theme-toggle"] {
    display: none !important;
  }

  /* Fondo general verde menta en el contenido principal */
  html,
  body,
  #app,
  .wrapper,
  .main-content,
  .content-wrapper,
  .page-content,
  main,
  section,
  .container,
  .container-fluid {
    background-color: #dcfce7 !important;
    color: #052e16 !important;
  }

  /* Barra lateral en verde esmeralda oscuro */
  aside,
  #sidebar,
  .sidebar,
  nav.sidebar,
  .offcanvas {
    background: linear-gradient(180deg, #065f46 0%, #047857 100%) !important;
    background-color: #065f46 !important;
    color: #ecfdf5 !important;
    border-right: 1px solid #10b981 !important;
  }

  /* Título y todos los textos/íconos sobre fondo verde oscuro del sidebar */
  aside h1, aside h2, aside h3, aside h4, aside h5, aside h6,
  #sidebar h1, #sidebar h2, #sidebar h3, #sidebar h4, #sidebar h5, #sidebar h6,
  .sidebar h1, .sidebar h2, .sidebar h3, .sidebar h4, .sidebar h5, .sidebar h6,
  aside p, #sidebar p, .sidebar p,
  aside small, #sidebar small, .sidebar small,
  aside label, #sidebar label, .sidebar label,
  aside a, #sidebar a, .sidebar a,
  aside span:not(.badge), #sidebar span:not(.badge), .sidebar span:not(.badge),
  aside i, #sidebar i, .sidebar i,
  aside svg, #sidebar svg, .sidebar svg {
    color: #ecfdf5 !important;
    opacity: 1 !important;
  }

  /* Enlaces activos y tarjetas claras dentro del sidebar: fondo verde menta con texto oscuro nítido */
  aside .nav-link.active,
  aside a.active,
  aside .active,
  #sidebar .active,
  .sidebar .active,
  aside .card,
  aside .bg-light,
  aside .bg-white,
  #sidebar .card,
  #sidebar .bg-light,
  #sidebar .bg-white,
  .sidebar .card,
  .sidebar .bg-light,
  .sidebar .bg-white {
    background-color: #bbf7d0 !important;
    color: #052e16 !important;
    border-color: #34d399 !important;
  }

  aside .nav-link.active *,
  aside a.active *,
  aside .active *,
  #sidebar .active *,
  .sidebar .active *,
  aside .card *,
  aside .bg-light *,
  aside .bg-white *,
  #sidebar .card *,
  #sidebar .bg-light *,
  #sidebar .bg-white *,
  .sidebar .card *,
  .sidebar .bg-light *,
  .sidebar .bg-white * {
    color: #052e16 !important;
    opacity: 1 !important;
  }

  /* Menús desplegables (incluyendo "Cambiar contraseña" y listas flotantes): fondo verde menta sólido y texto oscuro */
  .dropdown-menu,
  .dropdown-item,
  .position-absolute.w-100,
  .lista-tipos-accesorio {
    background-color: #bbf7d0 !important;
    color: #052e16 !important;
    border-color: #16a34a !important;
    opacity: 1 !important;
  }

  .dropdown-menu *,
  .dropdown-item *,
  .position-absolute.w-100 > *,
  .lista-tipos-accesorio > * {
    color: #052e16 !important;
    opacity: 1 !important;
  }

  .dropdown-item:hover,
  .dropdown-item:focus,
  .position-absolute.w-100 > *:hover,
  .lista-tipos-accesorio > *:hover {
    background-color: #86efac !important;
    color: #052e16 !important;
  }

  /* Tarjetas, paneles, manual, acordeones y modales en verde menta */
  main .card,
  main .card-header,
  main .card-body,
  main .card-footer,
  main .dashboard-tarjeta,
  main .dashboard-cabecera,
  main .accordion-item,
  main .accordion-button,
  main .accordion-body,
  main .alert,
  main .bg-white,
  main .bg-light,
  .modal-content,
  .modal-header,
  .modal-body,
  .modal-footer {
    background-color: #d1fae5 !important;
    color: #052e16 !important;
    border-color: #4ade80 !important;
  }

  /* Tablas con contraste limpio */
  table tbody td {
    background-color: #ecfdf5 !important;
    box-shadow: inset 0 0 0 9999px #ecfdf5 !important;
    color: #052e16 !important;
    border-color: #86efac !important;
  }

  table tbody tr:hover > td {
    background-color: #bbf7d0 !important;
    box-shadow: inset 0 0 0 9999px #bbf7d0 !important;
    color: #052e16 !important;
  }

  table thead th {
    background-color: #a7f3d0 !important;
    box-shadow: inset 0 0 0 9999px #a7f3d0 !important;
    color: #052e16 !important;
    border-color: #4ade80 !important;
    font-weight: 700 !important;
  }

  /* Inputs, selects, botones y paginación */
  .form-control,
  .form-select,
  .page-link,
  .input-group .btn,
  .input-group button {
    background-color: #ecfdf5 !important;
    color: #052e16 !important;
    border-color: #34d399 !important;
  }

  /* Impresión en blanco limpio */
  @media print {
    html, body, #app, main, section, .card, .card-body, .dashboard-cabecera, .dashboard-tarjeta, table, table td, table th {
      background-color: #ffffff !important;
      background: #ffffff !important;
      box-shadow: none !important;
      color: #0f172a !important;
      border-color: #cbd5e1 !important;
    }
  }
</style>
<script id="tema-verde-sidebar-contraste-js">
(function() {
  document.documentElement.removeAttribute("data-bs-theme");
  document.documentElement.classList.remove("home-dark", "dark", "theme-dark");

  function aplicarContrasteVerde() {
    // Ocultar botón/rectángulo de modo
    document.querySelectorAll("button, a, div, label, span").forEach(el => {
      if (el.children.length > 2) return;
      const txt = (el.textContent || "").trim();
      if (txt === "Modo Oscuro" || txt === "Modo Claro") {
        const btn = el.closest("button, a") || el;
        btn.style.setProperty("display", "none", "important");
      }
    });

    // Asegurar contraste alto en el menú desplegable (ej. "Cambiar contraseña")
    document.querySelectorAll(".dropdown-menu, .dropdown-item").forEach(el => {
      el.style.setProperty("background-color", "#bbf7d0", "important");
      el.style.setProperty("color", "#052e16", "important");
      el.style.setProperty("opacity", "1", "important");
    });

    // Asegurar contraste claro en textos e íconos del sidebar
    document.querySelectorAll("aside h1, aside h2, aside h3, aside h4, aside h5, aside h6, #sidebar h1, #sidebar h2, #sidebar h3, #sidebar h4, #sidebar h5, #sidebar h6, .sidebar h1, .sidebar h2, .sidebar h3, .sidebar h4, .sidebar h5, .sidebar h6").forEach(h => {
      h.style.setProperty("color", "#ecfdf5", "important");
      h.style.setProperty("opacity", "1", "important");
    });
  }

  document.addEventListener("DOMContentLoaded", function() {
    aplicarContrasteVerde();
    setTimeout(aplicarContrasteVerde, 200);
    setTimeout(aplicarContrasteVerde, 600);
  });
})();
</script>

<style id="tema-verde-force-fix">
  /* Forzar contraste claro en todo texto/ícono de la barra lateral sobre fondo verde oscuro */
  body aside, body #sidebar, body .sidebar, body nav.sidebar {
    background-color: #065f46 !important;
    color: #ecfdf5 !important;
  }
  body aside *, body #sidebar *, body .sidebar *, body nav.sidebar * {
    opacity: 1 !important;
  }
  body aside h1, body aside h2, body aside h3, body aside h4, body aside h5, body aside h6,
  body #sidebar h1, body #sidebar h2, body #sidebar h3, body #sidebar h4, body #sidebar h5, body #sidebar h6,
  body .sidebar h1, body .sidebar h2, body .sidebar h3, body .sidebar h4, body .sidebar h5, body .sidebar h6 {
    color: #ffffff !important;
  }

  /* Forzar fondo verde menta sólido y texto oscuro nítido en menús desplegables y opciones de cuenta */
  body .dropdown-menu,
  body .dropdown-menu li,
  body .dropdown-menu a,
  body .dropdown-menu button,
  body .dropdown-item {
    background-color: #bbf7d0 !important;
    color: #052e16 !important;
    opacity: 1 !important;
  }
  body .dropdown-menu a *,
  body .dropdown-menu button *,
  body .dropdown-item * {
    color: #052e16 !important;
    opacity: 1 !important;
  }
  body .dropdown-item:hover,
  body .dropdown-menu a:hover,
  body .dropdown-menu button:hover {
    background-color: #86efac !important;
    color: #052e16 !important;
  }
</style>
<script id="tema-verde-force-fix-js">
(function() {
  function fixElementos() {
    // 1. Título del sidebar en blanco/menta claro legible
    document.querySelectorAll("aside, #sidebar, .sidebar").forEach(sb => {
      sb.querySelectorAll("h1, h2, h3, h4, h5, h6, .brand-text, .sidebar-title").forEach(t => {
        t.style.setProperty("color", "#ffffff", "important");
        t.style.setProperty("opacity", "1", "important");
      });
    });

    // 2. Cualquier enlace o botón que diga "Cambiar contraseña" o esté dentro de un dropdown abierto
    document.querySelectorAll("a, button, li, div").forEach(el => {
      const txt = (el.textContent || "").trim();
      if (txt === "Cambiar contraseña" || el.classList.contains("dropdown-menu") || el.classList.contains("dropdown-item")) {
        if (el.tagName === "A" || el.tagName === "BUTTON" || el.classList.contains("dropdown-menu")) {
          el.style.setProperty("background-color", "#bbf7d0", "important");
          el.style.setProperty("color", "#052e16", "important");
          el.style.setProperty("opacity", "1", "important");
        }
        el.querySelectorAll("span, i, svg, small, b, strong").forEach(c => {
          c.style.setProperty("color", "#052e16", "important");
          c.style.setProperty("opacity", "1", "important");
        });
      }
    });
  }

  document.addEventListener("DOMContentLoaded", function() {
    fixElementos();
    setTimeout(fixElementos, 200);
    setTimeout(fixElementos, 700);
    document.addEventListener("click", () => setTimeout(fixElementos, 80));
  });
})();
</script>

<style id="tema-verde-definitivo-clean">
  /* 1. Ocultar por completo el botón de cambio de modo */
  #btn-switch-theme,
  [id*="btn-switch-theme"],
  [id*="modo-oscuro"],
  [id*="dark-mode"],
  [id*="theme-toggle"] {
    display: none !important;
    visibility: hidden !important;
  }

  /* 2. Menú desplegable de usuario ("Cambiar contraseña", etc.) siempre legible y contrastado */
  #sidebar .user-dropdown-container .dropdown-menu,
  .user-dropdown-container .dropdown-menu,
  .dropdown-menu {
    background-color: #bbf7d0 !important;
    border: 1px solid #16a34a !important;
    opacity: 1 !important;
  }

  #sidebar .user-dropdown-container .dropdown-menu .dropdown-item,
  .user-dropdown-container .dropdown-menu .dropdown-item,
  .dropdown-menu .dropdown-item,
  .dropdown-menu a,
  .dropdown-menu button {
    background-color: #bbf7d0 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    opacity: 1 !important;
  }

  #sidebar .user-dropdown-container .dropdown-menu .dropdown-item *,
  .user-dropdown-container .dropdown-menu .dropdown-item *,
  .dropdown-menu .dropdown-item *,
  .dropdown-menu a *,
  .dropdown-menu button * {
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    opacity: 1 !important;
  }

  #sidebar .user-dropdown-container .dropdown-menu .dropdown-item:hover,
  .user-dropdown-container .dropdown-menu .dropdown-item:hover,
  .dropdown-menu .dropdown-item:hover,
  .dropdown-menu a:hover,
  .dropdown-menu button:hover {
    background-color: #86efac !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
  }

  /* 3. Título del sidebar bien visible */
  #sidebar .sidebar-brand-text,
  .sidebar-brand-text {
    color: #ecfdf5 !important;
    -webkit-text-fill-color: #ecfdf5 !important;
    opacity: 1 !important;
  }
</style>
<script id="tema-verde-definitivo-js">
(function() {
  // Neutralizar cualquier intento de activar modo oscuro
  window.toggleThemeDirecto = function() { return false; };
  document.documentElement.removeAttribute("data-bs-theme");
  document.documentElement.classList.remove("home-dark", "dark", "theme-dark");

  function reforzarElementos() {
    const btnModo = document.getElementById("btn-switch-theme");
    if (btnModo) {
      btnModo.style.setProperty("display", "none", "important");
    }

    document.querySelectorAll(".dropdown-menu, .dropdown-menu .dropdown-item, .dropdown-menu a, .dropdown-menu button").forEach(el => {
      el.style.setProperty("background-color", "#bbf7d0", "important");
      el.style.setProperty("color", "#052e16", "important");
      el.style.setProperty("-webkit-text-fill-color", "#052e16", "important");
      el.style.setProperty("opacity", "1", "important");
      el.querySelectorAll("span, i, svg, small").forEach(child => {
        child.style.setProperty("color", "#052e16", "important");
        child.style.setProperty("-webkit-text-fill-color", "#052e16", "important");
        child.style.setProperty("opacity", "1", "important");
      });
    });

    document.querySelectorAll(".sidebar-brand-text").forEach(brand => {
      brand.style.setProperty("color", "#ecfdf5", "important");
      brand.style.setProperty("-webkit-text-fill-color", "#ecfdf5", "important");
      brand.style.setProperty("opacity", "1", "important");
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", reforzarElementos);
  } else {
    reforzarElementos();
  }
  setTimeout(reforzarElementos, 150);
  setTimeout(reforzarElementos, 500);
  document.addEventListener("click", () => setTimeout(reforzarElementos, 60));
})();
</script>

<style id="tema-verde-sin-blancos-v3">
  /* 1. Enlace activo del menú lateral ("Inicio"): fondo verde esmeralda fuerte y texto/ícono blanco nítido */
  #sidebar .sidebar-link.active,
  #sidebar a.active,
  #sidebar .nav-link.active,
  aside .sidebar-link.active,
  aside a.active,
  aside .nav-link.active {
    background-color: #059669 !important;
    background: #059669 !important;
    color: #ffffff !important;
    border-color: #34d399 !important;
  }

  #sidebar .sidebar-link.active *,
  #sidebar a.active *,
  #sidebar .nav-link.active *,
  aside .sidebar-link.active *,
  aside a.active *,
  aside .nav-link.active * {
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
    opacity: 1 !important;
  }

  /* 2. Tarjeta inferior de Rol / Registrador en el sidebar: contraste fuerte y legible */
  #sidebar .user-info-cards .card,
  #sidebar .user-info-cards .card-body,
  aside .user-info-cards .card,
  aside .user-info-cards .card-body {
    background-color: #064e3b !important;
    border-color: #34d399 !important;
  }

  #sidebar .user-info-cards *,
  aside .user-info-cards * {
    color: #ecfdf5 !important;
    -webkit-text-fill-color: #ecfdf5 !important;
    opacity: 1 !important;
  }

  /* 3. Celdas de tablas, filas y botones secundarios ("VER", paginación, etc.) sin blanco */
  table tbody td,
  table tbody tr td,
  .table tbody td,
  .table > :not(caption) > * > * {
    background-color: #dcfce7 !important;
    background: #dcfce7 !important;
    box-shadow: inset 0 0 0 9999px #dcfce7 !important;
    color: #052e16 !important;
    border-color: #86efac !important;
  }

  table tbody tr:hover > td,
  .table tbody tr:hover > td {
    background-color: #bbf7d0 !important;
    background: #bbf7d0 !important;
    box-shadow: inset 0 0 0 9999px #bbf7d0 !important;
    color: #052e16 !important;
  }

  table thead th,
  .table thead th {
    background-color: #a7f3d0 !important;
    background: #a7f3d0 !important;
    box-shadow: inset 0 0 0 9999px #a7f3d0 !important;
    color: #052e16 !important;
    border-color: #4ade80 !important;
  }

  /* Botones claros tipo "VER" o de acción secundaria dentro de tarjetas/tablas */
  main .btn-light,
  main .btn-outline-secondary,
  main .btn-outline-light,
  main .btn-white,
  main a.btn.btn-sm:not(.btn-primary):not(.btn-success):not(.btn-danger):not(.btn-warning),
  main button.btn.btn-sm:not(.btn-primary):not(.btn-success):not(.btn-danger):not(.btn-warning) {
    background-color: #bbf7d0 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    border-color: #16a34a !important;
  }

  /* 4. Impresión siempre en blanco limpio */
  @media print {
    html, body, #app, main, section, .card, .card-body, table, table td, table th, .btn {
      background-color: #ffffff !important;
      background: #ffffff !important;
      box-shadow: none !important;
      color: #0f172a !important;
      -webkit-text-fill-color: #0f172a !important;
      border-color: #cbd5e1 !important;
    }
  }
</style>
<script id="tema-verde-sin-blancos-v3-js">
(function() {
  function quitarBlancosPuntuales() {
    // 1. Enlace activo del sidebar ("Inicio")
    document.querySelectorAll("#sidebar .sidebar-link.active, #sidebar a.active, aside .sidebar-link.active, aside a.active").forEach(el => {
      el.style.setProperty("background-color", "#059669", "important");
      el.style.setProperty("background", "#059669", "important");
      el.style.setProperty("color", "#ffffff", "important");
      el.querySelectorAll("span, i, svg").forEach(c => {
        c.style.setProperty("color", "#ffffff", "important");
        c.style.setProperty("-webkit-text-fill-color", "#ffffff", "important");
      });
    });

    // 2. Celdas de tablas y botones claros dentro de tablas/tarjetas
    document.querySelectorAll("table tbody td, table tbody tr").forEach(el => {
      el.style.setProperty("background-color", "#dcfce7", "important");
      el.style.setProperty("box-shadow", "inset 0 0 0 9999px #dcfce7", "important");
      el.style.setProperty("color", "#052e16", "important");
    });

    document.querySelectorAll("main .btn-light, main .btn-outline-secondary, main .btn-outline-light, main a.btn, main button.btn").forEach(btn => {
      const bg = getComputedStyle(btn).backgroundColor;
      const m = bg && bg.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/i);
      if (m && parseInt(m[1], 10) >= 235 && parseInt(m[2], 10) >= 235 && parseInt(m[3], 10) >= 235) {
        btn.style.setProperty("background-color", "#bbf7d0", "important");
        btn.style.setProperty("color", "#052e16", "important");
        btn.style.setProperty("-webkit-text-fill-color", "#052e16", "important");
        btn.style.setProperty("border-color", "#16a34a", "important");
      }
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", quitarBlancosPuntuales);
  } else {
    quitarBlancosPuntuales();
  }
  setTimeout(quitarBlancosPuntuales, 150);
  setTimeout(quitarBlancosPuntuales, 500);
})();
</script>

<style id="tema-verde-prestamos-fix">
  /* Eliminar fondos blancos en contenedores principales, wrappers y tablas de préstamos */
  body,
  main,
  main > div,
  main .container,
  main .container-fluid,
  .content-wrapper,
  .page-wrapper,
  .table-responsive,
  .dataTables_wrapper {
    background-color: #dcfce7 !important;
    color: #052e16 !important;
  }

  /* Botones de acción en filas de tablas (ojo, editar, devolver, eliminar, etc.) en verde menta */
  table tbody td .btn,
  table tbody td a.btn,
  table tbody td button,
  table tbody td a {
    background-color: #bbf7d0 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    border-color: #34d399 !important;
  }

  table tbody td .btn:hover,
  table tbody td a.btn:hover,
  table tbody td button:hover,
  table tbody td a:hover {
    background-color: #86efac !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
  }

  /* Paginación ("Mostrando 1 a 9...", « < 1 > ») en verde menta */
  .pagination .page-link,
  .page-item .page-link,
  nav[aria-label*="Pagination"] a,
  nav[aria-label*="Pagination"] span {
    background-color: #ecfdf5 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    border-color: #34d399 !important;
  }

  .pagination .page-item.active .page-link,
  .page-item.active .page-link {
    background-color: #059669 !important;
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
    border-color: #059669 !important;
  }

  /* Impresión siempre en blanco limpio */
  @media print {
    html, body, #app, main, main > div, .table-responsive, table, table td, table th, .btn, .page-link {
      background-color: #ffffff !important;
      background: #ffffff !important;
      box-shadow: none !important;
      color: #0f172a !important;
      -webkit-text-fill-color: #0f172a !important;
      border-color: #cbd5e1 !important;
    }
  }
</style>
<script id="tema-verde-prestamos-fix-js">
(function() {
  function limpiarBlancosEnTablasYContenedores() {
    document.querySelectorAll("main > div, .table-responsive, .dataTables_wrapper, .pagination .page-link, table tbody td a, table tbody td button").forEach(el => {
      if (el.closest(".badge")) return;
      const bg = getComputedStyle(el).backgroundColor;
      const m = bg && bg.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/i);
      if (m && parseInt(m[1], 10) >= 235 && parseInt(m[2], 10) >= 235 && parseInt(m[3], 10) >= 235) {
        const targetBg = el.classList.contains("page-link") || el.tagName === "A" || el.tagName === "BUTTON" ? "#bbf7d0" : "#dcfce7";
        el.style.setProperty("background-color", targetBg, "important");
        el.style.setProperty("background", targetBg, "important");
        el.style.setProperty("color", "#052e16", "important");
        el.style.setProperty("-webkit-text-fill-color", "#052e16", "important");
      }
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", limpiarBlancosEnTablasYContenedores);
  } else {
    limpiarBlancosEnTablasYContenedores();
  }
  setTimeout(limpiarBlancosEnTablasYContenedores, 150);
  setTimeout(limpiarBlancosEnTablasYContenedores, 500);
})();
</script>
<style id="todo-verde-forzado-final">
  /* Forzar verde menta en fondos de página, tarjetas, tablas y contenedores */
  html, body, #app, main, main > div, main > section,
  .container, .container-fluid, .content-wrapper, .page-content,
  .card, .card-header, .card-body, .card-footer,
  .table-responsive, .dataTables_wrapper {
    background-color: #dcfce7 !important;
    background: #dcfce7 !important;
    color: #052e16 !important;
  }

  /* Cabeceras de tabla en verde menta medio y celdas en verde menta claro */
  table thead th, .table thead th {
    background-color: #a7f3d0 !important;
    background: #a7f3d0 !important;
    box-shadow: inset 0 0 0 9999px #a7f3d0 !important;
    color: #052e16 !important;
    border-color: #4ade80 !important;
  }

  table tbody td, .table tbody td {
    background-color: #ecfdf5 !important;
    background: #ecfdf5 !important;
    box-shadow: inset 0 0 0 9999px #ecfdf5 !important;
    color: #052e16 !important;
    border-color: #86efac !important;
  }

  table tbody tr:hover > td, .table tbody tr:hover > td {
    background-color: #bbf7d0 !important;
    background: #bbf7d0 !important;
    box-shadow: inset 0 0 0 9999px #bbf7d0 !important;
    color: #052e16 !important;
  }

  /* Inputs, selects, botones secundarios y paginación en verde */
  .form-control, .form-select, .dataTables_filter input, .dataTables_length select,
  .page-link, .pagination .page-link {
    background-color: #ecfdf5 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    border-color: #34d399 !important;
  }

  table tbody td .btn, table tbody td a.btn, table tbody td button, table tbody td a {
    background-color: #bbf7d0 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    border-color: #34d399 !important;
  }

  .pagination .page-item.active .page-link, .page-item.active .page-link {
    background-color: #059669 !important;
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
    border-color: #059669 !important;
  }

  /* Impresión en blanco */
  @media print {
    html, body, #app, main, main > div, .card, .card-body, .table-responsive, table, table td, table th, .btn, .page-link {
      background-color: #ffffff !important;
      background: #ffffff !important;
      box-shadow: none !important;
      color: #0f172a !important;
      -webkit-text-fill-color: #0f172a !important;
      border-color: #cbd5e1 !important;
    }
  }
</style>
<style id="manual-tema-verde-completo">
  /* Fondo general del manual en verde menta */
  body,
  main,
  .container,
  .container-fluid,
  .manual-wrapper,
  .manual-container {
    background-color: #dcfce7 !important;
    color: #052e16 !important;
  }

  /* Barra de búsqueda y botón Limpiar en verde */
  input[placeholder*="Buscar en el manual"],
  .manual-search input,
  .manual-buscador input,
  input.form-control[type="search"],
  input.form-control[type="text"] {
    background-color: #ecfdf5 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    border: 1px solid #34d399 !important;
  }

  input[placeholder*="Buscar en el manual"]::placeholder {
    color: #166534 !important;
    opacity: 1 !important;
  }

  /* Botones / píldoras de navegación rápida (1. Objetivo, 2.1 Registro, etc.) y botón Limpiar */
  main button:not(.btn-primary):not(.btn-danger),
  main .btn:not(.btn-primary):not(.btn-danger),
  main a.badge,
  main span.badge,
  .filtro-seccion,
  .nav-pill-manual,
  .btn-filtro-manual {
    background-color: #bbf7d0 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    border: 1px solid #22c55e !important;
  }

  main button:not(.btn-primary):not(.btn-danger):hover,
  main .btn:not(.btn-primary):not(.btn-danger):hover,
  .filtro-seccion:hover,
  .filtro-seccion.active,
  .nav-pill-manual.active {
    background-color: #059669 !important;
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
    border-color: #047857 !important;
  }

  /* Acordeones, tarjetas y secciones del manual (1. Objetivo del módulo, 2.1, 2.2...) */
  main .card,
  main .card-header,
  main .card-body,
  main .accordion,
  main .accordion-item,
  main .accordion-header,
  main .accordion-button,
  main .accordion-collapse,
  main .accordion-body,
  main .alert,
  main .callout,
  main .nota-importantes,
  main [class*="simulador"],
  main [class*="seccion"],
  main [class*="bloque"] {
    background-color: #d1fae5 !important;
    background: #d1fae5 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    border-color: #4ade80 !important;
  }

  /* Encabezados de acordeones / secciones con un tono verde ligeramente más marcado para distinguirlos */
  main .accordion-button,
  main .accordion-button:not(.collapsed),
  main .card-header {
    background-color: #a7f3d0 !important;
    background: #a7f3d0 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
  }

  main .accordion-button::after {
    filter: none !important;
  }

  /* Textos, listas, strong y párrafos dentro de las secciones del manual */
  main .card-body *,
  main .accordion-body *,
  main .alert *,
  main [class*="simulador"] * {
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
  }

  /* Selects dentro del simulador rápido */
  main select,
  main .form-select {
    background-color: #ecfdf5 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    border: 1px solid #22c55e !important;
  }

  /* Tabla dentro del manual */
  main table thead th {
    background-color: #a7f3d0 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    border-color: #4ade80 !important;
  }

  main table tbody td {
    background-color: #ecfdf5 !important;
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
    border-color: #86efac !important;
  }

  /* Impresión en blanco limpio */
  @media print {
    html, body, main, .card, .card-body, .accordion-item, .accordion-button, .accordion-body, table, table td, table th, .btn {
      background-color: #ffffff !important;
      background: #ffffff !important;
      box-shadow: none !important;
      color: #0f172a !important;
      -webkit-text-fill-color: #0f172a !important;
      border-color: #cbd5e1 !important;
    }
  }
</style>
<script id="manual-tema-verde-js">
(function() {
  function pintarManualVerde() {
    document.querySelectorAll("main div, main section, main article, main button, main a, main input, main select").forEach(el => {
      if (el.closest("#sidebar") || el.closest("aside") || el.closest(".navbar")) return;
      const bg = getComputedStyle(el).backgroundColor;
      const m = bg && bg.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/i);
      if (!m) return;
      const r = parseInt(m[1], 10), g = parseInt(m[2], 10), b = parseInt(m[3], 10);
      if (r + g + b < 130) {
        const esBoton = (el.tagName === "BUTTON" || el.classList.contains("btn"));
        const nuevoBg = esBoton ? "#bbf7d0" : "#d1fae5";
        el.style.setProperty("background-color", nuevoBg, "important");
        el.style.setProperty("background", nuevoBg, "important");
        el.style.setProperty("color", "#052e16", "important");
        el.style.setProperty("-webkit-text-fill-color", "#052e16", "important");
        el.style.setProperty("border-color", "#34d399", "important");
      }
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", pintarManualVerde);
  } else {
    pintarManualVerde();
  }
  setTimeout(pintarManualVerde, 150);
  setTimeout(pintarManualVerde, 500);
})();
</script>