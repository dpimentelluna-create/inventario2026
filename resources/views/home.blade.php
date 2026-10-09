@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Encabezado del Panel -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white flex items-center gap-2">
            <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Panel de Control (Inicio)
        </h1>
        <p class="text-gray-400 text-sm mt-1">Resumen general del estado de los equipos e inventario institucional.</p>
    </div>

    <!-- Tarjetas de Estadísticas Principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Equipos -->
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-5 shadow-lg">
            <div class="flex justify-between items-center mb-3">
                <span class="text-xs font-semibold tracking-wider text-gray-400 uppercase">Total Equipos</span>
                <span class="w-3 h-3 rounded-full bg-blue-500"></span>
            </div>
            <div class="text-3xl font-bold text-white mb-2">0</div>
            <p class="text-xs text-blue-400 flex items-center gap-1">Registrados en el sistema</p>
        </div>

        <!-- Equipos Operativos -->
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-5 shadow-lg">
            <div class="flex justify-between items-center mb-3">
                <span class="text-xs font-semibold tracking-wider text-gray-400 uppercase">Equipos Operativos</span>
                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
            </div>
            <div class="text-3xl font-bold text-white mb-2">0</div>
            <p class="text-xs text-emerald-400 flex items-center gap-1">En buen estado y disponibles</p>
        </div>

        <!-- Malogrados / Averiados -->
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-5 shadow-lg">
            <div class="flex justify-between items-center mb-3">
                <span class="text-xs font-semibold tracking-wider text-gray-400 uppercase">Malogrados / Averiados</span>
                <span class="w-3 h-3 rounded-full bg-rose-500"></span>
            </div>
            <div class="text-3xl font-bold text-white mb-2">0</div>
            <p class="text-xs text-rose-400 flex items-center gap-1">Requieren atención técnica</p>
        </div>

        <!-- Préstamos Activos -->
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-5 shadow-lg">
            <div class="flex justify-between items-center mb-3">
                <span class="text-xs font-semibold tracking-wider text-gray-400 uppercase">Préstamos Activos</span>
                <span class="w-3 h-3 rounded-full bg-amber-500"></span>
            </div>
            <div class="text-3xl font-bold text-white mb-2">0</div>
            <p class="text-xs text-amber-400 flex items-center gap-1">Equipos actualmente prestados</p>
        </div>
    </div>

    <!-- Sección Inferior: Accesos Rápidos e Información -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Acceso Rápido -->
        <div class="lg:col-span-2 bg-slate-800 border border-slate-700 rounded-xl p-6 shadow-lg">
            <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Acceso Rápido
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('prestamos.index') }}" class="flex items-center p-4 bg-slate-900/60 border border-slate-700/60 rounded-lg hover:border-blue-500 transition group">
                    <div class="p-3 bg-blue-600/20 text-blue-400 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-medium group-hover:text-blue-400 transition">Préstamos</h3>
                        <p class="text-xs text-gray-400">Registrar salidas o devoluciones de equipos.</p>
                    </div>
                </a>

                <a href="{{ route('equipos.index') }}" class="flex items-center p-4 bg-slate-900/60 border border-slate-700/60 rounded-lg hover:border-emerald-500 transition group">
                    <div class="p-3 bg-emerald-600/20 text-emerald-400 rounded-lg group-hover:bg-emerald-600 group-hover:text-white transition mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-medium group-hover:text-emerald-400 transition">Equipos</h3>
                        <p class="text-xs text-gray-400">Ver listado de máquinas y estados.</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Información y Notificación de Sesión Corregida -->
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-6 shadow-lg flex flex-col justify-between">
            <div>
                <h2 class="text-lg font-semibold text-white mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Información
                </h2>
                <p class="text-xs text-gray-300 leading-relaxed mb-4">
                    Bienvenido al sistema de control de inventario y préstamos. Utilice la barra lateral izquierda para navegar rápidamente entre los diferentes módulos y mantener el registro actualizado.
                </p>
            </div>

           <!-- Caja de Estado de Sesión en Modo Oscuro Uniforme -->
            <div class="bg-slate-900/90 border border-slate-700 rounded-lg p-3.5 flex items-center gap-3">
                <div class="text-emerald-400 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-200">Sesión iniciada correctamente como <span class="font-semibold text-emerald-400">Usuario</span>.</p>
                </div>
            </div>
@endsection