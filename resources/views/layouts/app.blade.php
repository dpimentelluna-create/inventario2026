<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

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

    <!--ESTILOS GENERALES Y DISEÑO DE BARRA LATERAL Y LOADER-->
    <style>
        html, body {
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

        /* --- LAYOUT DE BARRA LATERAL --- */
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
            z-index: 1000;
        }

        #sidebar.collapsed {
            width: 72px;
            min-width: 72px;
        }

        #sidebar.collapsed .sidebar-text,
        #sidebar.collapsed .user-name-text,
        #sidebar.collapsed .brand-text,
        #sidebar.collapsed .auth-buttons-container {
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

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.65rem 1rem;
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

        .dot-spinner-container .dot:nth-child(1)  { transform: rotate(0deg) translate(45px); opacity: 0.1; }
        .dot-spinner-container .dot:nth-child(2)  { transform: rotate(22.5deg) translate(45px); opacity: 0.15; }
        .dot-spinner-container .dot:nth-child(3)  { transform: rotate(45deg) translate(45px); opacity: 0.2; }
        .dot-spinner-container .dot:nth-child(4)  { transform: rotate(67.5deg) translate(45px); opacity: 0.25; }
        .dot-spinner-container .dot:nth-child(5)  { transform: rotate(90deg) translate(45px); opacity: 0.3; }
        .dot-spinner-container .dot:nth-child(6)  { transform: rotate(112.5deg) translate(45px); opacity: 0.4; }
        .dot-spinner-container .dot:nth-child(7)  { transform: rotate(135deg) translate(45px); opacity: 0.5; }
        .dot-spinner-container .dot:nth-child(8)  { transform: rotate(157.5deg) translate(45px); opacity: 0.6; }
        .dot-spinner-container .dot:nth-child(9)  { transform: rotate(180deg) translate(45px); opacity: 0.7; }
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

        /* --- MODO OSCURO (AZUL PROFUNDO) --- */
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

        [data-bs-theme="dark"] .top-header-bar {
            background-color: #1e293b !important;
            border-bottom: 1px solid #334155 !important;
        }

        [data-bs-theme="dark"] .card, 
        [data-bs-theme="dark"] .card-body,
        [data-bs-theme="dark"] .dropdown-menu,
        [data-bs-theme="dark"] div[style*="background"],
        [data-bs-theme="dark"] .collapse:not(.show) + div,
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

        /* ANULACIÓN ABSOLUTA DE VERDES EN TABLAS EN MODO OSCURO */
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

        /* --- MODO CLARO (BLANCO / ESTÁNDAR) --- */
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

        [data-bs-theme="light"] .top-header-bar {
            background-color: #ffffff !important;
            border-bottom: 1px solid #e2e8f0 !important;
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
    </style>

    <!-- Script inicial para evitar parpadeos al cargar -->
    <script>
        (function () {
            const storedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-bs-theme', storedTheme);
        })();
    </script>
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
        <div class="loading-text">loading......</div>
    </div>

    <div id="app">
        <div id="app-container">
            <!-- BARRA LATERAL ESTILO GEMINI -->
            <nav id="sidebar" class="p-3 d-flex flex-column justify-content-between shadow-sm">
                <div>
                    <!-- Cabecera de la Barra Lateral -->
                    <div class="d-flex align-items-center mb-4 px-1">
                        <button id="sidebar-toggle" class="btn btn-sm btn-outline-secondary rounded-circle me-2 btn-accion" title="Ocultar/Mostrar menú">
                            <i class="bi bi-list"></i>
                        </button>
                        <span class="brand-text fs-6 fw-bold text-truncate" style="user-select: none;">
                            {{ config('app.name', 'Laravel') }}
                        </span>
                    </div>

                    <!-- Enlaces de navegación -->
                    <div class="nav flex-column">
                        <a href="{{ url('/home') }}" class="sidebar-link {{ request()->routeIs('home') || request()->is('/') ? 'active' : '' }}" title="Inicio">
                            <i class="bi bi-house-door me-3 fs-5"></i>
                            <span class="sidebar-text">Inicio</span>
                        </a>

                        <a href="{{ route('prestamos.index') }}" class="sidebar-link {{ request()->routeIs('prestamos.*') ? 'active' : '' }}" title="Préstamos">
                            <i class="bi bi-journal-check me-3 fs-5"></i>
                            <span class="sidebar-text">Préstamos</span>
                        </a>

                        <a href="{{ route('equipos.index') }}" class="sidebar-link {{ request()->routeIs('equipos.*') ? 'active' : '' }}" title="Equipos">
                            <i class="bi bi-laptop me-3 fs-5"></i>
                            <span class="sidebar-text">Equipos</span>
                        </a>

                        <a href="{{ route('accesorios-equipo.index') }}" class="sidebar-link {{ request()->routeIs('accesorios-equipo.*') ? 'active' : '' }}" title="Accesorios Equipo">
                            <i class="bi bi-mouse me-3 fs-5"></i>
                            <span class="sidebar-text">Accesorios Equipo</span>
                        </a>

                        <a href="{{ route('docentes.index') }}" class="sidebar-link {{ request()->routeIs('docentes.*') ? 'active' : '' }}" title="Solicitantes">
                            <i class="bi bi-people me-3 fs-5"></i>
                            <span class="sidebar-text">Solicitantes</span>
                        </a>

                        <a href="{{ route('tipos-equipo.index') }}" class="sidebar-link {{ request()->routeIs('tipos-equipo.*') ? 'active' : '' }}" title="Tipos Equipos">
                            <i class="bi bi-tags me-3 fs-5"></i>
                            <span class="sidebar-text">Tipos Equipos</span>
                        </a>

                        <a href="{{ route('ubicaciones.index') }}" class="sidebar-link {{ request()->routeIs('ubicaciones.*') ? 'active' : '' }}" title="Ubicaciones">
                            <i class="bi bi-geo-alt me-3 fs-5"></i>
                            <span class="sidebar-text">Ubicaciones</span>
                        </a>
                    </div>
                </div>

                <!-- Pie de la Barra Lateral -->
                <div class="pt-3 border-top mt-3">
                    @auth
                        <div class="d-flex align-items-center mb-2 px-1">
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0" style="width: 35px; height: 35px; font-weight: bold;">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="user-name-text small fw-semibold text-truncate">{{ Auth::user()->name }}</span>
                        </div>
                    @endauth

                    <div class="d-flex align-items-center justify-content-between px-1">
                        <!-- Botón de Modo Oscuro / Claro -->
                        <button id="btn-switch-theme" class="btn btn-outline-secondary btn-sm rounded-circle btn-accion" title="Cambiar modo de color">
                            <i id="theme-icon" class="bi bi-sun-fill"></i>
                        </button>

                        @auth
                            <!-- Botón de Cerrar Sesión -->
                            <a class="btn btn-outline-danger btn-sm rounded-circle btn-accion" href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Cerrar sesión">
                                <i class="bi bi-box-arrow-right"></i>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @else
                            <!-- Botones de Iniciar Sesión y Registrarse Compactos -->
                            <div class="auth-buttons-container d-flex gap-1">
                                @if (Route::has('login'))
                                    <a class="btn btn-outline-primary btn-sm px-2 py-1 text-decoration-none d-flex align-items-center" href="{{ route('login') }}" title="Iniciar sesión" style="font-size: 0.75rem;">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                                    </a>
                                @endif
                                @if (Route::has('register'))
                                    <a class="btn btn-outline-success btn-sm px-2 py-1 text-decoration-none d-flex align-items-center" href="{{ route('register') }}" title="Registrarse" style="font-size: 0.75rem;">
                                        <i class="bi bi-person-plus me-1"></i> Registro
                                    </a>
                                @endif
                            </div>
                        @endauth
                    </div>
                </div>
            </nav>

            <!-- CONTENEDOR PRINCIPAL DERECHO -->
            <div id="content-wrapper">
                <main class="py-4 px-4 flex-grow-1">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
    
    <!-- Script para ocultar y mostrar el loader -->
    <script>
        window.addEventListener('load', function() {
            const loader = document.getElementById('page-loader');
            loader.style.opacity = '0';
            setTimeout(function() {
                loader.style.display = 'none';
            }, 300);
        });

        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link && link.href && !link.getAttribute('href').startsWith('#') && !link.getAttribute('target') && !link.getAttribute('onclick')) {
                const loader = document.getElementById('page-loader');
                loader.style.display = 'flex';
                loader.style.opacity = '1';
            }
        });

        document.addEventListener('submit', function() {
            const loader = document.getElementById('page-loader');
            loader.style.display = 'flex';
            loader.style.opacity = '1';
        });
    </script>

    <!-- Script para alternar el tema y colapsar la barra lateral -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnSwitch = document.getElementById('btn-switch-theme');
            const themeIcon = document.getElementById('theme-icon');
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');

            if (currentTheme === 'dark') {
                themeIcon.className = 'bi bi-sun-fill';
            } else {
                themeIcon.className = 'bi bi-moon-fill';
            }

            if(btnSwitch) {
                btnSwitch.addEventListener('click', function () {
                    let theme = document.documentElement.getAttribute('data-bs-theme');
                    let newTheme = (theme === 'dark') ? 'light' : 'dark';

                    document.documentElement.setAttribute('data-bs-theme', newTheme);
                    localStorage.setItem('theme', newTheme);

                    if (newTheme === 'dark') {
                        themeIcon.className = 'bi bi-sun-fill';
                    } else {
                        themeIcon.className = 'bi bi-moon-fill';
                    }
                });
            }

            if(sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                });
            }
        });
    </script>

    <script>
        if(document.querySelector('#example')) {
            new DataTable('#example', {
                pageLength: 10,
                lengthMenu: [5, 10, 25, 100],
                responsive: true,
                language: {
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros.",
                    search: "Buscar:",
                    zeroRecords: "No se encontraron registros",
                    infoEmpty: "No hay registros disponibles",
                    infoFiltered: "(filtrado de _MAX_ registros en total)",
                }
            });
        }
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
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
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
        document.addEventListener('DOMContentLoaded', function () {
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
</body>
</html>