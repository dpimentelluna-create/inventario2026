<!DOCTYPE html>
<html lang="es" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Inventario Tecnológico - I.E. 88021 Alfonso Ugarte</title>

    <!-- FontAwesome y Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Script inicial para evitar parpadeo blanco al cargar -->
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            min-height: 100vh;
            background:
                radial-gradient(circle at 10% 20%, rgba(25, 135, 84, 0.18), transparent 30%),
                radial-gradient(circle at 90% 80%, rgba(13, 110, 253, 0.15), transparent 30%),
                linear-gradient(135deg, #f5fff8 0%, #eef7f2 50%, #f8fbff 100%);
            color: #1f2937;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* =====================================================
            BARRA SUPERIOR
        ===================================================== */
        .topbar {
            width: 100%;
            padding: 18px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            background: rgba(255, 255, 255, 0.80);
            backdrop-filter: blur(12px);
            position: relative;
            z-index: 10;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .institution {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .institution-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: #198754;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 8px 20px rgba(25, 135, 84, 0.25);
        }

        .institution-text strong {
            display: block;
            font-size: 15px;
            color: #123d2b;
            letter-spacing: .04em;
        }

        .institution-text span {
            font-size: 12px;
            color: #6b7280;
        }

        .area-label {
            padding: 9px 15px;
            border-radius: 30px;
            background: #e8f7ef;
            color: #198754;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: .04em;
        }

        /* Botón de cambio de tema */
        .btn-theme-toggle {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            color: #334155;
            padding: 8px 14px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-theme-toggle:hover {
            background: #e2e8f0;
        }

        /* =====================================================
            CONTENEDOR PRINCIPAL / PRESENTACIÓN
        ===================================================== */
        .hero {
            width: 88%;
            max-width: 1250px;
            margin: 55px auto 0;
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            gap: 60px;
            align-items: center;
        }

        .hero-content {
            animation: aparecer .8s ease;
        }

        .tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 30px;
            background: #e8f7ef;
            color: #198754;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: .05em;
            margin-bottom: 20px;
        }

        .hero h1 {
            font-size: clamp(38px, 5vw, 68px);
            line-height: 1.03;
            color: #123d2b;
            margin-bottom: 22px;
        }

        .hero h1 span {
            color: #198754;
        }

        .hero-description {
            max-width: 650px;
            color: #667085;
            font-size: 17px;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        /* =====================================================
            BOTONES
        ===================================================== */
        .buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            text-decoration: none;
            padding: 13px 22px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: bold;
            transition: .25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #198754;
            color: white;
            box-shadow: 0 8px 20px rgba(25, 135, 84, .22);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            background: #157347;
        }

        .btn-secondary {
            background: white;
            color: #198754;
            border: 1px solid #d7e8df;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            background: #f5faf7;
        }

        /* =====================================================
            LOGO / PANEL DERECHO
        ===================================================== */
        .visual {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo-card {
            width: 390px;
            min-height: 390px;
            border-radius: 35px;
            background: rgba(255, 255, 255, .82);
            border: 1px solid rgba(25, 135, 84, .14);
            box-shadow: 0 25px 70px rgba(30, 70, 50, .12);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 2;
            animation: flotar 5s ease-in-out infinite;
        }

        .logo-colegio img {
            width: 140px;
            height: 140px;
            object-fit: contain;
            margin-bottom: 20px;
            filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.1));
        }

        .logo-card h2 {
            color: #123d2b;
            font-size: 18px;
            text-align: center;
            letter-spacing: .02em;
        }

        .logo-card p {
            color: #7a8694;
            font-size: 12px;
            margin-top: 8px;
            text-align: center;
            line-height: 1.4;
        }

        /* =====================================================
            ELEMENTOS DECORATIVOS
        ===================================================== */
        .circle {
            position: absolute;
            border-radius: 50%;
            z-index: 1;
        }

        .circle-one {
            width: 110px;
            height: 110px;
            background: rgba(25, 135, 84, .12);
            top: -30px;
            right: -25px;
        }

        .circle-two {
            width: 75px;
            height: 75px;
            background: rgba(13, 110, 253, .10);
            bottom: -25px;
            left: -30px;
        }

        /* =====================================================
            TARJETAS DE MÓDULOS
        ===================================================== */
        .modules {
            width: 88%;
            max-width: 1250px;
            margin: 70px auto 40px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .module {
            background: rgba(255, 255, 255, .82);
            border: 1px solid rgba(0, 0, 0, .06);
            border-radius: 18px;
            padding: 22px;
            transition: .25s ease;
        }

        .module:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, .08);
        }

        .module-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e8f7ef;
            color: #198754;
            font-size: 21px;
            margin-bottom: 15px;
        }

        .module h3 {
            font-size: 16px;
            color: #123d2b;
            margin-bottom: 7px;
        }

        .module p {
            color: #7a8694;
            font-size: 12px;
            line-height: 1.5;
        }

        /* =====================================================
            PIE DE PÁGINA
        ===================================================== */
        footer {
            width: 88%;
            max-width: 1250px;
            margin: 35px auto 25px;
            padding-top: 20px;
            border-top: 1px solid rgba(0, 0, 0, .08);
            display: flex;
            justify-content: space-between;
            gap: 20px;
            color: #8a939d;
            font-size: 11px;
            transition: border-color 0.3s ease;
        }

        /* =====================================================
            MODO OSCURO (DARK MODE) ADAPTADO
        ===================================================== */
        [data-bs-theme="dark"] body {
            background: #0f172a !important;
            color: #e2e8f0 !important;
        }

        [data-bs-theme="dark"] .topbar {
            background: rgba(30, 41, 59, 0.85) !important;
            border-bottom: 1px solid #334155 !important;
        }

        [data-bs-theme="dark"] .institution-text strong {
            color: #f8fafc !important;
        }

        [data-bs-theme="dark"] .institution-text span {
            color: #94a3b8 !important;
        }

        [data-bs-theme="dark"] .area-label {
            background: rgba(16, 185, 129, 0.15) !important;
            color: #34d399 !important;
        }

        [data-bs-theme="dark"] .btn-theme-toggle {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }

        [data-bs-theme="dark"] .btn-theme-toggle:hover {
            background: #334155 !important;
        }

        [data-bs-theme="dark"] .tag {
            background: rgba(16, 185, 129, 0.15) !important;
            color: #34d399 !important;
        }

        [data-bs-theme="dark"] .hero h1 {
            color: #f8fafc !important;
        }

        [data-bs-theme="dark"] .hero h1 span {
            color: #34d399 !important;
        }

        [data-bs-theme="dark"] .hero-description {
            color: #94a3b8 !important;
        }

        [data-bs-theme="dark"] .btn-secondary {
            background: #1e293b !important;
            color: #34d399 !important;
            border-color: #334155 !important;
        }

        [data-bs-theme="dark"] .btn-secondary:hover {
            background: #334155 !important;
        }

        [data-bs-theme="dark"] .logo-card {
            background: rgba(30, 41, 59, 0.85) !important;
            border-color: #334155 !important;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4) !important;
        }

        [data-bs-theme="dark"] .logo-card h2 {
            color: #f8fafc !important;
        }

        [data-bs-theme="dark"] .logo-card p {
            color: #94a3b8 !important;
        }

        [data-bs-theme="dark"] .module {
            background: rgba(30, 41, 59, 0.85) !important;
            border-color: #334155 !important;
        }

        [data-bs-theme="dark"] .module-icon {
            background: rgba(16, 185, 129, 0.15) !important;
            color: #34d399 !important;
        }

        [data-bs-theme="dark"] .module h3 {
            color: #f8fafc !important;
        }

        [data-bs-theme="dark"] .module p {
            color: #94a3b8 !important;
        }

        [data-bs-theme="dark"] footer {
            border-top: 1px solid #334155 !important;
            color: #94a3b8 !important;
        }

        /* =====================================================
            ANIMACIONES
        ===================================================== */
        @keyframes aparecer {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes flotar {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-8px);
            }
        }

        /* =====================================================
            RESPONSIVE
        ===================================================== */
        @media (max-width: 900px) {
            .hero {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 35px;
            }

            .hero-description {
                margin-left: auto;
                margin-right: auto;
            }

            .buttons {
                justify-content: center;
            }

            .modules {
                grid-template-columns: repeat(2, 1fr);
            }

            .visual {
                order: -1;
            }

            .logo-card {
                width: 330px;
                min-height: 330px;
            }
        }

        @media (max-width: 600px) {
            .topbar {
                padding: 15px 5%;
            }

            .area-label {
                display: none;
            }

            .hero {
                width: 90%;
                margin-top: 35px;
            }

            .modules {
                width: 90%;
                grid-template-columns: 1fr;
                margin-top: 45px;
            }

            .logo-card {
                width: 280px;
                min-height: 280px;
            }

            footer {
                width: 90%;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    {{-- =====================================================
         BARRA SUPERIOR
    ===================================================== --}}
    <header class="topbar">
        <div class="institution">
            <div class="institution-icon">
                🏫
            </div>
            <div class="institution-text">
                <strong>IE. 88021 ALFONSO UGARTE</strong>
                <span>Institución Educativa</span>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 15px;">
            <!-- BOTÓN MODO OSCURO / CLARO -->
            <button type="button" onclick="toggleTheme()" class="btn-theme-toggle" id="themeBtnText" title="Cambiar Tema">
                <i id="themeIcon" class="fas fa-moon"></i>
                <span id="themeLabel">Modo Oscuro</span>
            </button>

            <div class="area-label">
                COORDINACIÓN EN INNOVACIÓN Y SOPORTE TECNÓLOGICO
            </div>
        </div>
    </header>

    {{-- =====================================================
         PRESENTACIÓN
    ===================================================== --}}
    <main class="hero">
        <div class="hero-content">
            <div class="tag">
                💻 SISTEMA INSTITUCIONAL
            </div>

            <h1>
                Gestión de <br>
                <span>Equipos</span>
                y Préstamos
            </h1>

            <p class="hero-description">
                Sistema web desarrollado para facilitar el registro, control y seguimiento de los equipos tecnológicos utilizados dentro de la institución educativa.
            </p>

            <div class="buttons">
                @auth
                    <a href="{{ url('/home') }}" class="btn btn-primary">
                        <span>Ir al Panel Principal</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        INGRESAR AL SISTEMA →
                    </a>
                @endauth
                <a href="#modulos" class="btn btn-secondary">
                    CONOCER EL SISTEMA
                </a>
            </div>
        </div>

        {{-- =================================================
         LOGO
        ================================================== --}}
        <div class="visual">
            <div class="circle circle-one"></div>
            <div class="circle circle-two"></div>

            <div class="logo-card">
                <div class="logo-colegio">
                    <img src="{{ asset('logo/logo.jpg') }}" alt="Logo del colegio">
                </div>

                <h2>
                    IE. 88021 ALFONSO UGARTE
                </h2>

                <p>
                    COORDINACIÓN EN INNOVACIÓN Y <br>
                    SOPORTE TECNÓLOGICO
                </p>
            </div>
        </div>
    </main>

    {{-- =====================================================
         MÓDULOS
    ===================================================== --}}
    <section class="modules" id="modulos">
        <div class="module">
            <div class="module-icon">
                💻
            </div>
            <h3>EQUIPOS</h3>
            <p>Registro y administración de los equipos tecnológicos de la institución.</p>
        </div>

        <div class="module">
            <div class="module-icon">
                📋
            </div>
            <h3>PRÉSTAMOS</h3>
            <p>Control de préstamos, responsables, fechas y devoluciones.</p>
        </div>

        <div class="module">
            <div class="module-icon">
                🎧
            </div>
            <h3>ACCESORIOS</h3>
            <p>Gestión de accesorios asociados a cada dispositivo.</p>
        </div>

        <div class="module">
            <div class="module-icon">
                📊
            </div>
            <h3>CONTROL</h3>
            <p>Información organizada para facilitar la gestión técnica.</p>
        </div>
    </section>

    <!-- PIE DE PÁGINA -->
    <footer>
        <div>
            I.E. 88021 Alfonso Ugarte — Área de Innovación y Soporte Tecnológico © 2026
        </div>
        <div>
            Sistema de Gestión de Inventario
        </div>
    </footer>

    <!-- SCRIPT DE CAMBIO DE TEMA Y PERSISTENCIA -->
    <script>
        function updateThemeUI(theme) {
            const icon = document.getElementById('themeIcon');
            const label = document.getElementById('themeLabel');
            if (!icon || !label) return;

            if (theme === 'dark') {
                icon.className = 'fas fa-sun text-warning';
                label.textContent = 'Modo Claro';
            } else {
                icon.className = 'fas fa-moon';
                label.textContent = 'Modo Oscuro';
            }
        }

        function toggleTheme() {
            const html = document.documentElement;
            const current = html.getAttribute('data-bs-theme') || 'light';
            const next = current === 'dark' ? 'light' : 'dark';

            html.setAttribute('data-bs-theme', next);
            localStorage.setItem('theme', next);
            updateThemeUI(next);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
            updateThemeUI(savedTheme);
        });
    </script>
</body>

</html>