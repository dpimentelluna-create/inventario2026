<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Inventario - IE. 88021 Alfonso Ugarte</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f0f4f1] text-gray-800 font-sans min-h-screen flex flex-col justify-between">

    <!-- CONTENIDO PRINCIPAL -->
    <main class="container mx-auto px-6 py-10 flex-grow flex flex-col justify-center">
        
        <!-- SECCIÓN SUPERIOR (Hero: Título, Botones e Insignia Oficial) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center mb-10">
            
            <!-- Columna Izquierda: Título de la Institución y Botones -->
            <div class="lg:col-span-7 space-y-6">
                <h1 class="text-5xl sm:text-6xl font-extrabold text-[#0d7a46] leading-[1.12] tracking-tight">
                    Gestión de<br>Equipos y<br>Préstamos
                </h1>

                <p class="text-gray-600 text-base max-w-lg leading-relaxed">
                    Sistema web desarrollado para facilitar el registro, control y seguimiento de los equipos tecnológicos utilizados dentro de la institución educativa.
                </p>

                <!-- Botones de Acción -->
                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <!-- Botón 1: Ingresar al Sistema -->
                    <a href="{{ route('login') }}" 
                       class="bg-[#128a52] hover:bg-[#0e7042] text-white font-semibold text-sm px-6 py-3.5 rounded-lg shadow-sm transition duration-200 flex items-center gap-2 uppercase tracking-wide">
                        INGRESAR AL SISTEMA &rarr;
                    </a>

                    <!-- Botón 2: Conocer el Sistema (Filtro para las 4 tarjetas) -->
                    <button type="button" 
                            onclick="toggleCuatroModulos()" 
                            class="bg-white hover:bg-gray-50 text-[#128a52] border border-gray-200 font-semibold text-sm px-6 py-3.5 rounded-lg shadow-sm transition duration-200 uppercase tracking-wide cursor-pointer">
                        CONOCER EL SISTEMA
                    </button>
                </div>
            </div>

            <!-- Columna Derecha: Tarjeta de la Insignia de la I.E. N° 88021 "ALFONSO UGARTE" -->
            <div class="lg:col-span-5 flex justify-center lg:justify-end">
                <div class="bg-white/90 backdrop-blur-sm p-8 rounded-3xl shadow-sm border border-gray-100 max-w-sm w-full text-center">
                    
                    <!-- INSIGNIA VECTORIAL EXACTA DE LA I.E. 88021 ALFONSO UGARTE -->
                    <div class="w-52 h-auto mx-auto mb-4 drop-shadow-md">
                        <svg viewBox="0 0 240 300" class="w-full h-auto" xmlns="http://www.w3.org/2000/svg">
                            <!-- Borde dorado y fondo azul principal -->
                            <path d="M 10 20 L 230 20 L 230 160 C 230 230, 120 285, 120 285 C 120 285, 10 230, 10 160 Z" fill="#1d4ed8" stroke="#f59e0b" stroke-width="7" stroke-linejoin="round"/>
                            
                            <!-- Franja Superior Roja -->
                            <path d="M 14 24 L 226 24 L 226 78 L 14 78 Z" fill="#dc2626"/>
                            
                            <!-- Texto 'I' izquierda y 'E' derecha -->
                            <text x="38" y="62" text-anchor="middle" fill="#ffffff" font-weight="900" font-size="30" font-family="sans-serif">I</text>
                            <text x="202" y="62" text-anchor="middle" fill="#ffffff" font-weight="900" font-size="30" font-family="sans-serif">E</text>
                            
                            <!-- Recuadro Blanco Central '88021' -->
                            <rect x="68" y="34" width="104" height="38" rx="4" fill="#ffffff"/>
                            <text x="120" y="62" text-anchor="middle" fill="#000000" font-weight="900" font-size="22" font-family="sans-serif" letter-spacing="1">88021</text>

                            <!-- Cinta Amarilla 'ALFONSO UGARTE' -->
                            <path d="M 12 78 Q 120 102 228 78 L 218 116 Q 120 138 22 116 Z" fill="#facc15" stroke="#d97706" stroke-width="2"/>
                            <path id="textPathUgarte" d="M 25 106 Q 120 128 215 106" fill="none"/>
                            <text font-weight="900" font-size="16" font-family="sans-serif" fill="#000000">
                                <textPath href="#textPathUgarte" startOffset="50%" text-anchor="middle">ALFONSO UGARTE</textPath>
                            </text>

                            <!-- Laureles Verdes -->
                            <path d="M 42 155 Q 32 195 72 225" stroke="#16a34a" stroke-width="12" fill="none" stroke-linecap="round"/>
                            <path d="M 198 155 Q 208 195 168 225" stroke="#16a34a" stroke-width="12" fill="none" stroke-linecap="round"/>

                            <!-- Busto de Alfonso Ugarte -->
                            <g transform="translate(120, 178)">
                                <!-- Uniforme Militar -->
                                <path d="M -36 36 L -30 10 C -20 0, 20 0, 30 10 L 36 36 Z" fill="#1e293b"/>
                                <path d="M -22 12 L -6 26 M 22 12 L 6 26 M 0 10 L 0 36" stroke="#facc15" stroke-width="3" stroke-linecap="round"/>
                                <!-- Rostro -->
                                <ellipse cx="0" cy="-8" rx="14" ry="16" fill="#fdba74"/>
                                <path d="M -8 -2 Q 0 4 8 -2" stroke="#0f172a" stroke-width="3" fill="none"/>
                                <!-- Gorra Militar -->
                                <path d="M -18 -18 L 18 -18 L 22 -12 L -22 -12 Z" fill="#000000"/>
                                <path d="M -16 -18 C -16 -30, 16 -30, 16 -18 Z" fill="#1d4ed8"/>
                                <rect x="-16" y="-22" width="32" height="4" fill="#facc15"/>
                            </g>

                            <!-- Cinta Inferior 'NVO. CHIMBOTE' -->
                            <path d="M 25 218 L 120 262 L 215 218 L 200 242 L 120 282 L 40 242 Z" fill="#facc15" stroke="#d97706" stroke-width="2"/>
                            <path id="textPathNvo" d="M 35 238 L 110 272" fill="none"/>
                            <path id="textPathChimbote" d="M 130 272 L 205 238" fill="none"/>
                            <text font-weight="900" font-size="13" font-family="sans-serif" fill="#000000">
                                <textPath href="#textPathNvo" startOffset="50%" text-anchor="middle">NVO.</textPath>
                            </text>
                            <text font-weight="900" font-size="13" font-family="sans-serif" fill="#000000">
                                <textPath href="#textPathChimbote" startOffset="50%" text-anchor="middle">CHIMBOTE</textPath>
                            </text>
                        </svg>
                    </div>
                    
                    <h2 class="font-extrabold text-gray-800 text-base uppercase tracking-wide mb-1">
                        IE. 88021 ALFONSO UGARTE
                    </h2>
                    <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider leading-snug">
                        COORDINACIÓN EN INNOVACIÓN Y<br>SOPORTE TECNOLÓGICO
                    </p>
                </div>
            </div>

        </div>

        <!-- SECCIÓN DE LAS 4 TARJETAS DEL INVENTARIO (Ocultas inicialmente) -->
        <div id="seccionModulos" class="hidden opacity-0 translate-y-4 transition-all duration-500 ease-in-out grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- 1. EQUIPOS -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center mb-4 text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 text-sm uppercase mb-2 tracking-wide">EQUIPOS</h3>
                <p class="text-gray-500 text-xs leading-relaxed">
                    Registro y administración de los equipos tecnológicos de la institución.
                </p>
            </div>

            <!-- 2. PRÉSTAMOS -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center mb-4 text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 text-sm uppercase mb-2 tracking-wide">PRÉSTAMOS</h3>
                <p class="text-gray-500 text-xs leading-relaxed">
                    Control de préstamos, responsables, fechas y devolución de equipos.
                </p>
            </div>

            <!-- 3. ACCESORIOS -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center mb-4 text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 text-sm uppercase mb-2 tracking-wide">ACCESORIOS</h3>
                <p class="text-gray-500 text-xs leading-relaxed">
                    Gestión de accesorios asociados a cada equipo tecnológico.
                </p>
            </div>

            <!-- 4. CONTROL -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center mb-4 text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 text-sm uppercase mb-2 tracking-wide">CONTROL</h3>
                <p class="text-gray-500 text-xs leading-relaxed">
                    Información organizada para facilitar la gestión y seguimiento tecnológico.
                </p>
            </div>

        </div>

    </main>

    <!-- FOOTER INFERIOR -->
    <footer class="w-full border-t border-gray-200/60 py-4 text-[11px] text-gray-400 font-medium bg-transparent">
        <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-2">
            <span>SISTEMA DE GESTIÓN DE EQUIPOS Y PRÉSTAMOS</span>
            <span>COORDINACIÓN EN INNOVACIÓN Y SOPORTE TECNOLÓGICO</span>
            <span>© 2026 · IE. 88021 ALFONSO UGARTE</span>
        </div>
    </footer>

    <!-- SCRIPT DE JAVASCRIPT PARA EL FILTRO / TOGGLE -->
    <script>
        function toggleCuatroModulos() {
            const seccion = document.getElementById('seccionModulos');
            
            if (seccion.classList.contains('hidden')) {
                // Muestra las 4 tarjetas con suave animación de entrada
                seccion.classList.remove('hidden');
                setTimeout(() => {
                    seccion.classList.remove('opacity-0', 'translate-y-4');
                    seccion.classList.add('opacity-100', 'translate-y-0');
                }, 20);
                
                // Hace desplazamiento suave hacia las tarjetas
                seccion.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } else {
                // Oculta las 4 tarjetas
                seccion.classList.remove('opacity-100', 'translate-y-0');
                seccion.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => {
                    seccion.classList.add('hidden');
                }, 300);
            }
        }
    </script>
</body>
</html>