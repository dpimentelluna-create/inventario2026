<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
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

    <!-- LINK PARA ICONOS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script>
        (function() {
            const t = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', t);
            if (t === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <!-- ESTILOS GENERALES Y DISEÑO DE BARRA LATERAL Y LOADER -->
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            overflow-x: hidden;
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
            transition: all 0.3s ease;
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
        #sidebar.collapsed .sidebar-brand-text,
        #sidebar.collapsed .auth-buttons-container,
        #sidebar.collapsed .user-name-text {
            display: none;
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

        #sidebar.collapsed .user-info-cards {
            display: none !important;
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
            transition: background-color 0.2s;
            margin-bottom: 0.25rem;
        }

        #content-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .sidebar-footer {
            margin-top: auto;
        }

        /* --- LOADER CIRCULAR --- */
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

        /* --- MODO OSCURO (REFORZADO) --- */
        [data-bs-theme="dark"] body {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
        }

        [data-bs-theme="dark"] #sidebar {
            background-color: #1e293b !important;
            border-right: 1px solid #334155 !important;
            color: #e2e8f0 !important;
        }

        [data-bs-theme="dark"] .sidebar-link {
            color: #cbd5e1;
        }

        [data-bs-theme="dark"] .sidebar-link:hover,
        [data-bs-theme="dark"] .sidebar-link.active {
            background-color: #334155 !important;
            color: #ffffff !important;
        }

        /* SOBREESCRITURA FORZADA DE TARJETAS Y FONDOS BLANCOS */
        [data-bs-theme="dark"] .card,
        [data-bs-theme="dark"] .card-body,
        [data-bs-theme="dark"] .bg-white,
        [data-bs-theme="dark"] .bg-light,
        [data-bs-theme="dark"] .dropdown-menu,
        [data-bs-theme="dark"] .border {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #e2e8f0 !important;
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
        [data-bs-theme="dark"] .table-success>th,
        [data-bs-theme="dark"] .table-success>td {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
            border-color: #334155 !important;
        }

        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
            border-color: #334155 !important;
        }

        /* --- MODO CLARO --- */
        [data-bs-theme="light"] body {
            background-color: #f8fafc !important;
            color: #334155 !important;
        }

        [data-bs-theme="light"] #sidebar {
            background-color: #ffffff !important;
            border-right: 1px solid #e2e8f0 !important;
            color: #334155 !important;
        }

        [data-bs-theme="light"] .sidebar-link {
            color: #475569;
        }

        [data-bs-theme="light"] .sidebar-link:hover,
        [data-bs-theme="light"] .sidebar-link.active {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
        }

        [data-bs-theme="light"] .card,
        [data-bs-theme="light"] .card-body,
        [data-bs-theme="light"] .dropdown-menu {
            background-color: #ffffff !important;
            color: #334155 !important;
            border-color: #e2e8f0 !important;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-950 text-gray-800 dark:text-gray-100">

    <!-- PANTALLA DE CARGA (LOADER) -->
    <div id="page-loader">
        <div class="dot-spinner-container">
            <div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div>
            <div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div>
            <div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div>
            <div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div>
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
                        <button id="sidebar-toggle" class="btn btn-sm btn-outline-secondary rounded-circle me-2 btn-accion" title="Ocultar/Mostrar menú">
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
                        <a href="{{ url('/home') }}" class="sidebar-link {{ request()->routeIs('home') || request()->is('/') ? 'active' : '' }}" title="Inicio">
                            <i class="bi bi-house-door me-3 fs-5"></i> <span class="sidebar-text">Inicio</span>
                        </a>
                        <a href="{{ route('prestamos.index') }}" class="sidebar-link {{ request()->routeIs('prestamos.*') ? 'active' : '' }}" title="Préstamos">
                            <i class="bi bi-journal-check me-3 fs-5"></i> <span class="sidebar-text">Préstamos</span>
                        </a>
                        <a href="{{ route('equipos.index') }}" class="sidebar-link {{ request()->routeIs('equipos.*') ? 'active' : '' }}" title="Equipos">
                            <i class="bi bi-laptop me-3 fs-5"></i> <span class="sidebar-text">Equipos</span>
                        </a>
                        @can('gestionar-bajas')
                            <a href="{{ route('bajas-equipos.index') }}" class="sidebar-link {{ request()->routeIs('bajas-equipos.*') ? 'active' : '' }}" title="Bajas Administrativas">
                                <i class="bi bi-archive me-3 fs-5"></i> <span class="sidebar-text">Bajas Administrativas</span>
                            </a>
                        @endcan
                        <a href="{{ route('accesorios-equipo.index') }}" class="sidebar-link {{ request()->routeIs('accesorios-equipo.*') ? 'active' : '' }}" title="Accesorios Equipo">
                            <i class="bi bi-mouse me-3 fs-5"></i> <span class="sidebar-text">Accesorios Equipo</span>
                        </a>
                        <a href="{{ route('docentes.index') }}" class="sidebar-link {{ request()->routeIs('docentes.*') ? 'active' : '' }}" title="Solicitantes">
                            <i class="bi bi-people me-3 fs-5"></i> <span class="sidebar-text">Solicitantes</span>
                        </a>
                        <a href="{{ route('tipos-equipo.index') }}" class="sidebar-link {{ request()->routeIs('tipos-equipo.*') ? 'active' : '' }}" title="Tipos Equipos">
                            <i class="bi bi-tags me-3 fs-5"></i> <span class="sidebar-text">Tipos Equipos</span>
                        </a>
                        <a href="{{ route('ubicaciones.index') }}" class="sidebar-link {{ request()->routeIs('ubicaciones.*') ? 'active' : '' }}" title="Ubicaciones">
                            <i class="bi bi-geo-alt me-3 fs-5"></i> <span class="sidebar-text">Ubicaciones</span>
                        </a>
                        <a class="sidebar-link" title="Manual del Usuario" href="{{ asset('manual/manual_usuario.pdf') }}" target="_blank">
                            <i class="bi bi-file-earmark-text me-3 fs-5"></i> <span class="sidebar-text">Manual del Usuario</span>
                        </a>

                         @can('gestionar-usuarios')
                        <a href="{{ route('usuarios.index') }}" class="sidebar-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}" title="Usuarios">
                            <i class="bi bi-person-gear me-3 fs-5"></i> <span class="sidebar-text">Usuarios</span>
                        </a>
                        @endcan
                    </div>
                </div>



                <!-- Pie de la Barra Lateral -->
                <div class="sidebar-footer pt-3 border-top mt-2 flex-shrink-0 d-flex flex-column gap-2">
                    <button id="btn-switch-theme" class="btn btn-sm btn-outline-secondary w-100 d-flex align-items-center justify-content-center gap-2" title="Cambiar Tema">
                        <i id="theme-icon" class="bi bi-moon-fill"></i> <span class="sidebar-text">Cambiar Modo</span>
                    </button>

                    @auth
                    <div class="dropdown user-dropdown-container px-1 mb-2">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle py-1" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" title="{{ Auth::user()->name }}">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0" style="width: 32px; height: 32px; font-weight: bold; font-size: 14px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="user-name-text small fw-semibold text-truncate">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser" style="min-width: 200px;">
                            <li><a class="dropdown-item d-flex align-items-center text-dark" href="{{ route('cuenta.password.edit') }}"><i class="bi bi-key me-2"></i> Cambiar contraseña</a></li>
                            <li><a class="dropdown-item d-flex align-items-center text-danger" href="{{ route('logout') }}" onclick="confirmarCierreSesion(event, document.getElementById('logout-form-dropdown'))"><i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión</a></li>
                        </ul>
                        <form id="logout-form-dropdown" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>

                    <div class="user-info-cards">
                        <div class="px-1 mb-2">
                            <div class="card border-0 bg-light mb-0">
                                <div class="card-body p-2 text-center">
                                    <small class="text-muted d-block" style="font-size: 0.7rem;">Rol</small>
                                    <span class="badge bg-primary">{{ Auth::user()->etiquetaRol() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="px-1">
                            <div class="card border-success bg-success bg-opacity-10 mb-0">
                                <div class="card-body p-2 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <small class="text-success fw-semibold">Sesión activa</small>
                                </div>
                            </div>
                        </div>
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

    <!-- Scripts de Bootstrap, DataTables, SweetAlert2 y Toastr -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Script para alternar el tema, colapsar la barra lateral y gestiones de UI -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnSwitch = document.getElementById('btn-switch-theme');
            const themeIcon = document.getElementById('theme-icon');
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');

            if (themeIcon) {
                themeIcon.className = (currentTheme === 'dark') ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
            }

            if (btnSwitch) {
                btnSwitch.addEventListener('click', function() {
                    let theme = document.documentElement.getAttribute('data-bs-theme');
                    let newTheme = (theme === 'dark') ? 'light' : 'dark';

                    document.documentElement.setAttribute('data-bs-theme', newTheme);
                    if (newTheme === 'dark') {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                    localStorage.setItem('theme', newTheme);

                    if (themeIcon) {
                        themeIcon.className = (newTheme === 'dark') ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
                    }
                });
            }

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

        @php
        $mensajeToast = session('success') ?? session('error') ?? session('warning');
        $tipoToast = session('toast_tipo', session('success') ? 'exito' : 'error');
        @endphp

        @if($mensajeToast)
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right'
            };
            @if(session('success'))
                toastr.success("{{ $mensajeToast }}");
            @elseif(session('error'))
                toastr.error("{{ $mensajeToast }}");
            @elseif(session('warning'))
                toastr.warning("{{ $mensajeToast }}");
            @endif
        @endif

        (function() {
            const loader = document.getElementById('page-loader');
            if (!loader) return;

            function ocultarLoader() {
                loader.style.opacity = '0';
                loader.style.pointerEvents = 'none';
                setTimeout(function() { loader.style.display = 'none'; }, 200);
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

    @stack('scripts')
</body>
</html>