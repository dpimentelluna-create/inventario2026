 @extends('layouts.app')

 @section('content')
 <style>
     .dashboard-titulo {
         color: #212529;
         font-weight: 700;
     }

     .dashboard-subtitulo {
         color: #6c757d;
     }

     .dashboard-tarjeta {
         background: #d1fae5;
         border: 1px solid #dee2e6;
         border-radius: 8px;
         box-shadow: 0 2px 5px rgba(0, 0, 0, .06);
         height: 100%;
         color: #212529;
         text-decoration: none;
         display: block;
         transition: border-color .2s, box-shadow .2s;
     }

     .dashboard-tarjeta:hover {
         border-color: #198754;
         box-shadow: 0 4px 10px rgba(0, 0, 0, .10);
         color: #212529;
     }

     .dashboard-cabecera {
         background: #90ee90;
         color: #212529;
         font-weight: 700;
         padding: 13px 16px;
         border-bottom: 1px solid #c8e6c9;
     }

     .dashboard-numero {
         font-size: 2rem;
         line-height: 1.2;
         font-weight: 700;
         margin: 12px 0;
     }

     .dashboard-etiqueta {
         color: #495057;
         font-size: .82rem;
         font-weight: 700;
         text-transform: uppercase;
     }

     .dashboard-tabla th {
         background: #e9f7e9;
         color: #212529;
         white-space: nowrap;
         font-size: .8rem;
     }

     .dashboard-tabla td {
         vertical-align: middle;
         font-size: .9rem;
     }

     .dashboard-info-fila {
         display: flex;
         justify-content: space-between;
         gap: 12px;
         padding: 9px 0;
         border-bottom: 1px solid #e9ecef;
     }

     .dashboard-info-fila:last-child {
         border-bottom: 0;
     }

     .dashboard-info-fila span:first-child {
         color: #495057;
     }

     .dashboard-info-fila strong {
         color: #212529;
         white-space: nowrap;
     }

     @media (max-width: 576px) {
         .dashboard-numero {
             font-size: 1.7rem;
         }
     }
 </style>

 <div class="container-fluid py-4">

     {{-- ENCABEZADO --}}
     <div class="mb-4">
         <h1 class="dashboard-titulo h3 mb-1">
             <i class="fas fa-chart-pie text-success me-2"></i>
             PANEL DE CONTROL
         </h1>
         <p class="dashboard-subtitulo mb-0">
             Resumen general del estado de los equipos y del inventario institucional.
         </p>
     </div>

        
    {{-- TARJETAS PRINCIPALES --}}
    <div class="row g-3 mb-4">

        {{-- TOTAL EQUIPOS EN INVENTARIO --}}
        <div class="col-12 col-sm-6 col-xl">
            <a href="{{ route('equipos.index', ['situacion' => 'EN_INVENTARIO', 'desde_dashboard' => 1]) }}"
                class="dashboard-tarjeta p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="dashboard-etiqueta">Total equipos</span>
                    <i class="fas fa-laptop text-primary"></i>
                </div>
                <div class="dashboard-numero">{{ number_format($totalEquipos) }}</div>
                <span class="small text-primary">
                    Ver equipos en inventario <i class="fas fa-arrow-right"></i>
                </span>
            </a>
        </div>

        {{-- EQUIPOS BUENOS --}}
        <div class="col-12 col-sm-6 col-xl">
            <a href="{{ route('equipos.index', ['situacion' => 'EN_INVENTARIO', 'estado' => 'BUENO', 'desde_dashboard' => 1]) }}"
                class="dashboard-tarjeta p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="dashboard-etiqueta">En buen estado</span>
                    <i class="fas fa-check-circle text-success"></i>
                </div>
                <div class="dashboard-numero text-success">{{ number_format($equiposBuenos) }}</div>
                <span class="small text-success">
                    Ver equipos BUENOS <i class="fas fa-arrow-right"></i>
                </span>
            </a>
        </div>

        {{-- EQUIPOS REGULARES --}}
        <div class="col-12 col-sm-6 col-xl">
            <a href="{{ route('equipos.index', ['situacion' => 'EN_INVENTARIO', 'estado' => 'REGULAR', 'desde_dashboard' => 1]) }}"
                class="dashboard-tarjeta p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="dashboard-etiqueta">Estado regular</span>
                    <i class="fas fa-exclamation-circle text-warning"></i>
                </div>
                <div class="dashboard-numero text-warning">{{ number_format($equiposRegulares) }}</div>
                <span class="small text-warning">
                    Ver equipos REGULARES <i class="fas fa-arrow-right"></i>
                </span>
            </a>
        </div>

    {{-- EQUIPOS MALOGRADOS --}}
    <div class="col-12 col-sm-6 col-xl">
            <a href="{{ route('equipos.index', ['situacion' => 'EN_INVENTARIO', 'estado' => 'MALOGRADO', 'desde_dashboard' => 1]) }}"
                class="dashboard-tarjeta p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="dashboard-etiqueta">Equipos malogrados</span>
                    <i class="fas fa-times-circle text-danger"></i>
                </div>
                <div class="dashboard-numero text-danger">{{ number_format($equiposMalogrados) }}</div>
                <span class="small text-danger">
                    Ver equipos MALOGRADOS <i class="fas fa-arrow-right"></i>
                </span>
            </a>
        </div>

        {{-- EQUIPOS DADOS DE BAJA --}}
        <div class="col-12 col-sm-6 col-xl">
            <a href="{{ route('equipos.index', ['situacion' => 'DE_BAJA', 'desde_dashboard' => 1]) }}"
                class="dashboard-tarjeta p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="dashboard-etiqueta">Equipos dados de baja</span>
                    <i class="fas fa-box-archive text-secondary"></i>
                </div>
                <div class="dashboard-numero text-secondary">{{ number_format($totalEquiposDadosBaja) }}</div>
                <span class="small text-secondary">
                    Ver equipos DE BAJA <i class="fas fa-arrow-right"></i>
                </span>
            </a>
        </div>

        {{-- PRÉSTAMOS ACTIVOS --}}
        <div class="col-12 col-sm-6 col-xl">
            <a href="{{ route('prestamos.index', ['estado' => 'ACTIVO', 'desde_dashboard' => 1]) }}"
                class="dashboard-tarjeta p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="dashboard-etiqueta">Préstamos activos</span>
                    <i class="fas fa-clipboard-list text-warning"></i>
                </div>
                <div class="dashboard-numero text-warning">{{ number_format($prestamosActivos) }}</div>
                <span class="small text-warning">
                    Ver préstamos ACTIVOS <i class="fas fa-arrow-right"></i>
                </span>
            </a>
        </div>

    </div>


     {{-- RESUMEN ADICIONAL --}}
     <div class="row g-3 mb-4">
        <div class="col-12 col-md-6">
            @php
                $totalTiposDashboard = $totalTiposEquipos
                    ?? (isset($tiposEquipos) ? (is_countable($tiposEquipos) ? count($tiposEquipos) : $tiposEquipos->count()) : \App\Models\TiposEquipo::count());
            @endphp
            <a href="{{ route('tipos-equipo.index') }}" class="dashboard-tarjeta p-3">
                <div class="dashboard-etiqueta">Tipos de equipos</div>
                <div class="dashboard-numero">{{ number_format($totalTiposDashboard) }}</div>
                <span class="small text-primary">Consultar tipos de equipos <i class="fas fa-arrow-right"></i></span>
            </a>
        </div>

         <div class="col-12 col-md-6">
             <a href="{{ route('ubicaciones.index') }}" class="dashboard-tarjeta p-3">
                 <div class="dashboard-etiqueta">Ubicaciones registradas</div>
                 <div class="dashboard-numero">{{ number_format($totalUbicaciones) }}</div>
                 <span class="small text-success">Consultar ubicaciones <i class="fas fa-arrow-right"></i></span>
             </a>
         </div>
     </div>

     {{-- TABLAS DE CONSULTA RÁPIDA --}}
     <div class="row g-4 mb-4">

         {{-- EQUIPOS POR TIPO --}}
         <div class="col-12 col-xl-6">
             <div class="dashboard-tarjeta overflow-hidden">
                 <div class="dashboard-cabecera d-flex justify-content-between align-items-center flex-wrap gap-2">
                     <span><i class="fas fa-laptop me-2"></i>EQUIPOS POR TIPO</span>
                     <a href="{{ route('tipos-equipo.index') }}" class="btn btn-sm btn-outline-dark">
                         VER TIPOS
                     </a>
                 </div>

                 <div class="table-responsive p-2">
                     <table id="tabla_equipos_tipo" class="table table-bordered table-hover dashboard-tabla mb-0">
                         <thead>
                             <tr>
                                 <th>TIPO</th>
                                 <th class="text-center">TOTAL</th>
                                 <th class="text-center">BUENOS</th>
                                 <th class="text-center">REGULARES</th>
                                 <th class="text-center">MALOGRADOS</th>
                                 <th class="text-center">DETALLE</th>
                             </tr>
                         </thead>
                         <tbody>
                             @forelse ($tiposEquipoResumen as $tipo)
                             <tr class="{{ $loop->index >= 3 ? 'dashboard-fila-oculta' : '' }}"
                                 data-dashboard-extra="{{ $loop->index >= 3 ? '1' : '0' }}">
                                 <td>{{ $tipo->nombre }}</td>
                                 <td class="text-center fw-bold">{{ $tipo->total }}</td>
                                 <td class="text-center text-success fw-bold">{{ $tipo->buenos }}</td>
                                 <td class="text-center text-warning fw-bold">{{ $tipo->regulares }}</td>
                                 <td class="text-center text-danger fw-bold">{{ $tipo->malogrados }}</td>
                                 <td class="text-center">
                                     <a href="{{ route('tipos-equipo.show', $tipo->id) }}"
                                         class="btn btn-sm btn-outline-secondary">
                                         VER
                                     </a>
                                 </td>
                             </tr>
                             @empty
                             <tr>
                                 <td colspan="6" class="text-center text-muted py-4">
                                     No hay tipos de equipos registrados.
                                 </td>
                             </tr>
                             @endforelse
                         </tbody>
                     </table>
                 </div>

                 @if ($tiposEquipoResumen->count() > 3)
                 <div class="text-center px-3 pb-3">
                     <button type="button"
                         class="btn btn-sm btn-outline-success"
                         onclick="alternarFilasDashboard('tabla_equipos_tipo', this)"
                         aria-expanded="false">
                         VER MÁS <i class="fas fa-chevron-down ms-1"></i>
                     </button>
                 </div>
                 @endif
             </div>
         </div>

         {{-- EQUIPOS POR UBICACIÓN --}}
         <div class="col-12 col-xl-6">
             <div class="dashboard-tarjeta overflow-hidden">
                 <div class="dashboard-cabecera d-flex justify-content-between align-items-center flex-wrap gap-2">
                     <span><i class="fas fa-map-marker-alt me-2"></i>EQUIPOS POR UBICACIÓN</span>
                     <a href="{{ route('ubicaciones.index') }}" class="btn btn-sm btn-outline-dark">
                         VER UBICACIONES
                     </a>
                 </div>

                 <div class="table-responsive p-2">
                     <table id="tabla_equipos_ubicacion" class="table table-bordered table-hover dashboard-tabla mb-0">
                         <thead>
                             <tr>
                                 <th>UBICACIÓN</th>
                                 <th>TIPO</th>
                                 <th class="text-center">TOTAL</th>
                                 <th class="text-center">BUENOS</th>
                                 <th class="text-center">MALOGRADOS</th>
                                 <th class="text-center">DETALLE</th>
                             </tr>
                         </thead>
                         <tbody>
                             @forelse ($ubicacionesResumen as $ubicacion)
                             <tr class="{{ $loop->index >= 3 ? 'dashboard-fila-oculta' : '' }}"
                                 data-dashboard-extra="{{ $loop->index >= 3 ? '1' : '0' }}">
                                 <td>{{ $ubicacion->nombre }}</td>
                                 <td>{{ $ubicacion->tipo ?: '-' }}</td>
                                 <td class="text-center fw-bold">{{ $ubicacion->total }}</td>
                                 <td class="text-center text-success fw-bold">{{ $ubicacion->buenos }}</td>
                                 <td class="text-center text-danger fw-bold">{{ $ubicacion->malogrados }}</td>
                                 <td class="text-center">
                                     <a href="{{ route('ubicaciones.show', $ubicacion->id) }}"
                                         class="btn btn-sm btn-outline-secondary">
                                         VER
                                     </a>
                                 </td>
                             </tr>
                             @empty
                             <tr>
                                 <td colspan="6" class="text-center text-muted py-4">
                                     No hay ubicaciones registradas.
                                 </td>
                             </tr>
                             @endforelse
                         </tbody>
                     </table>
                     @if ($ubicacionesResumen->count() > 3)
                     <div class="text-center px-3 pb-3">
                         <button type="button"
                             class="btn btn-sm btn-outline-success"
                             onclick="alternarFilasDashboard('tabla_equipos_ubicacion', this)"
                             aria-expanded="false">
                             VER MÁS <i class="fas fa-chevron-down ms-1"></i>
                         </button>
                     </div>
                     @endif
                 </div>
             </div>
         </div>

     </div>

     {{-- ACCESOS RÁPIDOS E INFORMACIÓN DEL SISTEMA --}}
     <div class="row g-4 align-items-stretch">

         {{-- ACCESO RÁPIDO A LOS MÓDULOS --}}
         <div class="col-12 col-lg-8">
             <div class="dashboard-tarjeta overflow-hidden">
                 <div class="dashboard-cabecera">
                     <i class="fas fa-th-large me-2"></i>
                     ACCESO RÁPIDO A LOS MÓDULOS
                 </div>

                 <div class="p-3">
                     <p class="dashboard-subtitulo small mb-3">
                         Selecciona un módulo para acceder a sus funciones principales.
                     </p>

                     <div class="row g-3">

                         {{-- PRÉSTAMOS --}}
                         <div class="col-12 col-sm-6">
                             <a href="{{ route('prestamos.index') }}"
                                 class="dashboard-modulo">
                                 <div class="dashboard-modulo-icono">
                                     <i class="fas fa-clipboard-list"></i>
                                 </div>
                                 <div class="dashboard-modulo-contenido">
                                     <div class="dashboard-modulo-titulo">
                                         PRÉSTAMOS
                                     </div>
                                     <p>
                                         Registra y consulta préstamos, controla su estado
                                         y revisa las entregas y devoluciones.
                                     </p>
                                     <span>INGRESAR <i class="fas fa-arrow-right ms-1"></i></span>
                                 </div>
                             </a>
                         </div>

                         {{-- EQUIPOS --}}
                         <div class="col-12 col-sm-6">
                             <a href="{{ route('equipos.index', ['desde_dashboard' => 1]) }}"
                                 class="dashboard-modulo">
                                 <div class="dashboard-modulo-icono">
                                     <i class="fas fa-laptop"></i>
                                 </div>
                                 <div class="dashboard-modulo-contenido">
                                     <div class="dashboard-modulo-titulo">
                                         EQUIPOS
                                     </div>
                                     <p>
                                         Consulta los equipos registrados, sus características,
                                         estados y ubicaciones.
                                     </p>
                                     <span>INGRESAR <i class="fas fa-arrow-right ms-1"></i></span>
                                 </div>
                             </a>
                         </div>

                         {{-- ACCESORIOS --}}
                         <div class="col-12 col-sm-6">
                             @if(Route::has('accesorios-equipo.index'))
                             <a href="{{ route('accesorios-equipo.index') }}"
                                 class="dashboard-modulo">
                                 @elseif(Route::has('accesorios-equipos.index'))
                                 <a href="{{ route('accesorios-equipos.index') }}"
                                     class="dashboard-modulo">
                                     @elseif(Route::has('accesorios_equipo.index'))
                                     <a href="{{ route('accesorios_equipo.index') }}"
                                         class="dashboard-modulo">
                                         @else
                                         <div class="dashboard-modulo dashboard-modulo-pendiente">
                                             @endif
                                             <div class="dashboard-modulo-icono">
                                                 <i class="fas fa-puzzle-piece"></i>
                                             </div>
                                             <div class="dashboard-modulo-contenido">
                                                 <div class="dashboard-modulo-titulo">
                                                     ACCESORIOS DE EQUIPO
                                                 </div>
                                                 <p>
                                                     Administra cargadores, baterías, números de serie,
                                                     estados y observaciones.
                                                 </p>
                                                 @if(
                                                 Route::has('accesorios-equipo.index') ||
                                                 Route::has('accesorios-equipos.index') ||
                                                 Route::has('accesorios_equipo.index')
                                                 )
                                                 <span>INGRESAR <i class="fas fa-arrow-right ms-1"></i></span>
                                                 @else
                                                 <span class="text-muted">REVISAR RUTA DEL MÓDULO</span>
                                                 @endif
                                             </div>
                                             @if(
                                             Route::has('accesorios-equipo.index') ||
                                             Route::has('accesorios-equipos.index') ||
                                             Route::has('accesorios_equipo.index')
                                             )
                                     </a>
                                     @else
                         </div>
                         @endif
                     </div>

                     {{-- TIPOS DE EQUIPO --}}
                     <div class="col-12 col-sm-6">
                         <a href="{{ route('tipos-equipo.index') }}"
                             class="dashboard-modulo">
                             <div class="dashboard-modulo-icono">
                                 <i class="fas fa-list"></i>
                             </div>
                             <div class="dashboard-modulo-contenido">
                                 <div class="dashboard-modulo-titulo">
                                     TIPOS DE EQUIPO
                                 </div>
                                 <p>
                                     Gestiona las categorías utilizadas para clasificar
                                     los equipos del inventario.
                                 </p>
                                 <span>INGRESAR <i class="fas fa-arrow-right ms-1"></i></span>
                             </div>
                         </a>
                     </div>

                     {{-- UBICACIONES --}}
                     <div class="col-12 col-sm-6">
                         <a href="{{ route('ubicaciones.index') }}"
                             class="dashboard-modulo">
                             <div class="dashboard-modulo-icono">
                                 <i class="fas fa-map-marker-alt"></i>
                             </div>
                             <div class="dashboard-modulo-contenido">
                                 <div class="dashboard-modulo-titulo">
                                     UBICACIONES
                                 </div>
                                 <p>
                                     Administra los ambientes y lugares donde se encuentran
                                     los equipos registrados.
                                 </p>
                                 <span>INGRESAR <i class="fas fa-arrow-right ms-1"></i></span>
                             </div>
                         </a>
                     </div>

                     {{-- SOLICITANTES --}}
                     @php
                     $rutaSolicitantes = collect([
                     'docentes.index',
                     'docente.index',
                     'solicitantes.index',
                     ])->first(fn ($nombreRuta) => Route::has($nombreRuta));
                     @endphp

                     <div class="col-12 col-sm-6">
                         @if ($rutaSolicitantes)
                         <a href="{{ route($rutaSolicitantes) }}"
                             class="dashboard-modulo">
                             @else
                             <div class="dashboard-modulo dashboard-modulo-pendiente">
                                 @endif

                                 <div class="dashboard-modulo-icono">
                                     <i class="fas fa-users"></i>
                                 </div>

                                 <div class="dashboard-modulo-contenido">
                                     <div class="dashboard-modulo-titulo">
                                         SOLICITANTES
                                     </div>

                                     <p>
                                         Consulta y administra los solicitantes registrados
                                         para facilitar la gestión de los préstamos.
                                     </p>

                                     @if ($rutaSolicitantes)
                                     <span>
                                         INGRESAR <i class="fas fa-arrow-right ms-1"></i>
                                     </span>
                                     @else
                                     <span class="text-muted">
                                         REVISAR RUTA DEL MÓDULO
                                     </span>
                                     @endif
                                 </div>

                                 @if ($rutaSolicitantes)
                         </a>
                         @else
                     </div>
                     @endif
                 </div>

                 {{-- USUARIOS Y ROLES --}}

                 {{-- USUARIOS Y ROLES --}}
                 @php
                 $rutaUsuarios = collect([
                 'admin.usuarios.index',
                 'admin.users.index',
                 'usuarios.index',
                 ])->first(fn ($nombreRuta) => Route::has($nombreRuta));
                 @endphp

                 <div class="col-12 col-sm-6">

                     @if (auth()->user()?->esAdministrador() && $rutaUsuarios)
                     <a href="{{ route($rutaUsuarios) }}"
                         class="dashboard-modulo">

                         @else
                         <div class="dashboard-modulo dashboard-modulo-bloqueado"
                             aria-disabled="true">
                             @endif

                             <div class="dashboard-modulo-icono">
                                 <i class="fas fa-user-shield"></i>
                             </div>

                             <div class="dashboard-modulo-contenido">
                                 <div class="dashboard-modulo-titulo">
                                     USUARIOS Y ROLES
                                 </div>

                                 <p>
                                     Administra las cuentas de acceso y los permisos
                                     asignados a cada usuario.
                                 </p>

                                 @if (auth()->user()?->esAdministrador() && $rutaUsuarios)
                                 <span>
                                     INGRESAR
                                     <i class="fas fa-arrow-right ms-1"></i>
                                 </span>
                                 @elseif (auth()->user()?->esAdministrador())
                                 <span class="text-warning">
                                     <i class="fas fa-exclamation-circle me-1"></i>
                                     REVISAR RUTA DEL MÓDULO
                                 </span>
                                 @else
                                 <span class="text-muted">
                                     <i class="fas fa-lock me-1"></i>
                                     ACCESO RESTRINGIDO
                                 </span>
                                 @endif
                             </div>

                             @if (auth()->user()?->esAdministrador() && $rutaUsuarios)
                     </a>
                     @else
                 </div>
                 @endif

             </div>


             {{-- MANUAL DEL USUARIO --}}
             <div class="col-12 col-sm-6">
                 <div class="dashboard-modulo dashboard-modulo-pendiente">
                     <div class="dashboard-modulo-icono">
                         <i class="fas fa-book-open"></i>
                     </div>
                     <div class="dashboard-modulo-contenido">
                         <div class="dashboard-modulo-titulo">
                             MANUAL DEL USUARIO
                         </div>
                         <p>
                             Consulta las instrucciones para utilizar los módulos
                             y realizar las tareas frecuentes.
                         </p>
                         <span class="text-muted">
                             <i class="fas fa-clock me-1"></i>PRÓXIMAMENTE
                         </span>
                     </div>
                 </div>
             </div>

         </div>
     </div>
 </div>
 </div>

 {{-- INFORMACIÓN DEL SISTEMA --}}
 <div class="col-12 col-lg-4">
     <div class="dashboard-tarjeta overflow-hidden h-100">
         <div class="dashboard-cabecera">
             <i class="fas fa-info-circle me-2"></i>
             INFORMACIÓN DEL SISTEMA
         </div>

         <div class="p-3">
             <p class="small dashboard-subtitulo mb-2">
                 Resumen de los registros disponibles en cada módulo.
             </p>

             <div class="dashboard-info-fila">
                 <span>Préstamos registrados:</span>
                 <strong>{{ number_format($totalPrestamos) }}</strong>
             </div>

             <div class="dashboard-info-fila">
                 <span>Equipos registrados:</span>
                 <strong>{{ number_format($totalEquipos) }}</strong>
             </div>

             <div class="dashboard-info-fila">
                 <span>Accesorios registrados:</span>
                 <strong>{{ number_format($totalAccesorios) }}</strong>
             </div>

             <div class="dashboard-info-fila">
                 <span>Solicitantes registrados:</span>
                 <strong>{{ number_format($totalDocentes) }}</strong>
             </div>

             <div class="dashboard-info-fila">
                 <span>Tipos de equipo registrados:</span>
                 <strong>{{ number_format($totalTiposEquipo) }}</strong>
             </div>

             <div class="dashboard-info-fila">
                 <span>Ubicaciones registradas:</span>
                 <strong>{{ number_format($totalUbicaciones) }}</strong>
             </div>

             <div class="alert alert-success py-2 px-3 mt-3 mb-0 small">
                 <i class="fas fa-check-circle me-1"></i>
                 Sesión iniciada correctamente.
             </div>
         </div>
     </div>
 </div>

 </div>

 {{-- ESTILOS DE LAS TARJETAS DE ACCESO --}}
 <style>
     .dashboard-modulo {
         display: flex;
         align-items: flex-start;
         gap: 12px;
         height: 100%;
         min-height: 145px;
         padding: 15px;
         background: #d1fae5;
         border: 1px solid #dee2e6;
         border-radius: 8px;
         color: #212529;
         text-decoration: none;
         transition: border-color .2s, box-shadow .2s, transform .2s;
     }

     .dashboard-modulo:hover {
         border-color: #198754;
         box-shadow: 0 3px 9px rgba(0, 0, 0, .08);
         color: #212529;
         transform: translateY(-2px);
     }

     .dashboard-modulo-icono {
         display: flex;
         align-items: center;
         justify-content: center;
         flex: 0 0 40px;
         width: 40px;
         height: 40px;
         background: #e9f7e9;
         color: #198754;
         border-radius: 8px;
         font-size: 1.1rem;
     }

     .dashboard-modulo-contenido {
         flex: 1;
         min-width: 0;
     }

     .dashboard-modulo-titulo {
         font-size: .83rem;
         font-weight: 700;
         margin-bottom: 6px;
     }

     .dashboard-modulo-contenido p {
         color: #6c757d;
         font-size: .79rem;
         line-height: 1.45;
         margin-bottom: 10px;
     }

     .dashboard-modulo-contenido>span {
         display: inline-block;
         color: #198754;
         font-size: .72rem;
         font-weight: 700;
     }

     .dashboard-modulo-pendiente {
         background: #f8f9fa;
         border-style: dashed;
     }

     .dashboard-modulo-pendiente .dashboard-modulo-icono {
         background: #e9ecef;
         color: #6c757d;
     }

     @media (max-width: 576px) {
         .dashboard-modulo {
             min-height: 0;
         }
     }

     .dashboard-fila-oculta {
         display: none;


         /* Módulo restringido para roles sin autorización */
         .dashboard-modulo-bloqueado {
             background: #f8f9fa;
             border-color: #dee2e6;
             cursor: not-allowed;
             opacity: .75;
             box-shadow: none;
             transform: none;
         }

         .dashboard-modulo-bloqueado:hover {
             background: #f8f9fa;
             border-color: #dee2e6;
             color: #212529;
             box-shadow: none;
             transform: none;
         }

         .dashboard-modulo-bloqueado .dashboard-modulo-icono {
             background: #e9ecef;
             color: #6c757d;
         }

         .dashboard-modulo-bloqueado .dashboard-modulo-contenido>span {
             color: #6c757d;
         }

     }
 </style>

 <script>
     function alternarFilasDashboard(idTabla, boton) {
         const tabla = document.getElementById(idTabla);

         if (!tabla) {
             return;
         }

         const filasOcultas = tabla.querySelectorAll(
             'tbody tr[data-dashboard-extra="1"]'
         );

         const expandir = boton.getAttribute('aria-expanded') !== 'true';

         filasOcultas.forEach(function(fila) {
             fila.style.display = expandir ? 'table-row' : '';
         });

         boton.setAttribute('aria-expanded', expandir ? 'true' : 'false');

         boton.innerHTML = expandir ?
             'VER MENOS <i class="fas fa-chevron-up ms-1"></i>' :
             'VER MÁS <i class="fas fa-chevron-down ms-1"></i>';
     }
 </script>
 @endsection



<style id="fix-dark-kpi-cards">
  /* MODO OSCURO */
  html.home-dark .dashboard-tarjeta,
  html.home-dark .card,
  html.home-dark .bg-success-subtle,
  html.home-dark [class*="tarjeta"],
  html.home-dark [class*="modulo"] {
    background-color: #162032 !important;
    border-color: #283852 !important;
    color: #f8fafc !important;
  }
  html.home-dark .dashboard-tarjeta .dashboard-numero,
  html.home-dark .card h1, html.home-dark .card h2, html.home-dark .card h3,
  html.home-dark .card h4, html.home-dark .card h5, html.home-dark .card h6,
  html.home-dark [class*="tarjeta"] h5, html.home-dark [class*="tarjeta"] h6,
  html.home-dark [class*="tarjeta"] .fw-bold {
    color: #ffffff !important;
  }
  html.home-dark .dashboard-tarjeta .dashboard-etiqueta,
  html.home-dark .dashboard-tarjeta span.small,
  html.home-dark .card p, html.home-dark .card small,
  html.home-dark [class*="tarjeta"] p, html.home-dark [class*="tarjeta"] small {
    color: #cbd5e1 !important;
  }
  html.home-dark .card a,
  html.home-dark [class*="tarjeta"] a {
    color: #38bdf8 !important;
  }

  /* MODO CLARO */
  html.home-light .dashboard-tarjeta,
  html.home-light .card,
  html.home-light .bg-success-subtle,
  html.home-light [class*="tarjeta"],
  html.home-light [class*="modulo"] {
    background-color: #d1fae5 !important;
    border-color: #6ee7b7 !important;
    color: #0f172a !important;
  }
  html.home-light .dashboard-tarjeta .dashboard-numero,
  html.home-light .card h1, html.home-light .card h2, html.home-light .card h3,
  html.home-light .card h4, html.home-light .card h5, html.home-light .card h6,
  html.home-light [class*="tarjeta"] h5, html.home-light [class*="tarjeta"] h6,
  html.home-light [class*="tarjeta"] .fw-bold {
    color: #0f172a !important;
  }
  html.home-light .dashboard-tarjeta .dashboard-etiqueta,
  html.home-light .dashboard-tarjeta span.small,
  html.home-light .card p, html.home-light .card small,
  html.home-light [class*="tarjeta"] p, html.home-light [class*="tarjeta"] small {
    color: #475569 !important;
  }
</style>
<script id="fix-dark-kpi-js">
document.addEventListener("DOMContentLoaded", function() {
  function syncHomeTheme() {
    const isDark = document.body.innerText.includes("Modo Claro") ||
                   document.documentElement.classList.contains("dark") ||
                   document.body.classList.contains("dark-mode") ||
                   document.body.classList.contains("dark") ||
                   document.documentElement.getAttribute("data-bs-theme") === "dark" ||
                   document.documentElement.getAttribute("data-theme") === "dark";

    document.documentElement.classList.toggle("home-dark", isDark);
    document.documentElement.classList.toggle("home-light", !isDark);

    const targets = document.querySelectorAll(
      ".dashboard-tarjeta, .card, .bg-success-subtle, [class*=\"tarjeta\"], [class*=\"modulo\"]"
    );

    targets.forEach(el => {
      if (isDark) {
        el.style.setProperty("background-color", "#162032", "important");
        el.style.setProperty("border-color", "#283852", "important");
        el.querySelectorAll("h1, h2, h3, h4, h5, h6, .dashboard-numero, .fw-bold").forEach(t => {
          t.style.setProperty("color", "#ffffff", "important");
        });
        el.querySelectorAll("p, span, small, .dashboard-etiqueta").forEach(t => {
          if (!t.classList.contains("dashboard-numero") && !t.classList.contains("fw-bold") && !t.closest("a")) {
            t.style.setProperty("color", "#cbd5e1", "important");
          }
        });
        el.querySelectorAll("a").forEach(a => {
          a.style.setProperty("color", "#38bdf8", "important");
        });
      } else {
        el.style.setProperty("background-color", "#d1fae5", "important");
        el.style.setProperty("border-color", "#6ee7b7", "important");
        el.querySelectorAll("h1, h2, h3, h4, h5, h6, .dashboard-numero, .fw-bold").forEach(t => {
          t.style.setProperty("color", "#0f172a", "important");
        });
        el.querySelectorAll("p, span, small, .dashboard-etiqueta").forEach(t => {
          if (!t.classList.contains("dashboard-numero") && !t.classList.contains("fw-bold") && !t.closest("a")) {
            t.style.setProperty("color", "#475569", "important");
          }
        });
      }
    });
  }

  syncHomeTheme();
  new MutationObserver(syncHomeTheme).observe(document.documentElement, {
    attributes: true,
    subtree: true,
    childList: true
  });
});
</script>
<style id="fix-all-tables-dark">
  html.home-dark table.dataTable thead th,
  html.home-dark table thead th,
  body.dark-mode table.dataTable thead th,
  body.dark table.dataTable thead th,
  [data-bs-theme="dark"] table.dataTable thead th,
  [data-theme="dark"] table.dataTable thead th {
    background-color: #1e293b !important;
    color: #f8fafc !important;
    border-color: #334155 !important;
  }

  html.home-dark .dataTables_wrapper .dataTables_length select,
  html.home-dark .dataTables_wrapper .dataTables_filter input,
  body.dark-mode .dataTables_wrapper .dataTables_length select,
  body.dark-mode .dataTables_wrapper .dataTables_filter input,
  [data-bs-theme="dark"] .dataTables_wrapper .dataTables_length select,
  [data-bs-theme="dark"] .dataTables_wrapper .dataTables_filter input {
    background-color: #0f172a !important;
    color: #f8fafc !important;
    border: 1px solid #334155 !important;
  }
</style>




<style id="colores-tarjetas-resumen">
  /* Base estilística para letras y números en tarjetas del dashboard */
  a.dashboard-tarjeta {
    border-radius: 12px !important;
    text-decoration: none !important;
    transition: transform 0.2s ease, box-shadow 0.2s ease !important;
  }

  /* 1. TOTAL EQUIPOS - Azul zafiro */
  a.dashboard-tarjeta[href*="equipos"]:not([href*="estado="]):not([href*="bajas"]) {
    border-left: 4px solid #2563eb !important;
  }
  a.dashboard-tarjeta[href*="equipos"]:not([href*="estado="]):not([href*="bajas"]) * {
    color: #1d4ed8 !important;
    -webkit-text-fill-color: #1d4ed8 !important;
  }

  /* 2. EN BUEN ESTADO - Verde esmeralda */
  a.dashboard-tarjeta[href*="BUENO"] {
    border-left: 4px solid #10b981 !important;
  }
  a.dashboard-tarjeta[href*="BUENO"] * {
    color: #047857 !important;
    -webkit-text-fill-color: #047857 !important;
  }

  /* 3. ESTADO REGULAR - Ámbar cálido */
  a.dashboard-tarjeta[href*="REGULAR"] {
    border-left: 4px solid #f59e0b !important;
  }
  a.dashboard-tarjeta[href*="REGULAR"] * {
    color: #b45309 !important;
    -webkit-text-fill-color: #b45309 !important;
  }

  /* 4. EQUIPOS MALOGRADOS - Rojo coral */
  a.dashboard-tarjeta[href*="MALOGRADO"] {
    border-left: 4px solid #ef4444 !important;
  }
  a.dashboard-tarjeta[href*="MALOGRADO"] * {
    color: #b91c1c !important;
    -webkit-text-fill-color: #b91c1c !important;
  }

  /* 5. EQUIPOS DADOS DE BAJA - Gris pizarra */
  a.dashboard-tarjeta[href*="bajas"] {
    border-left: 4px solid #64748b !important;
  }
  a.dashboard-tarjeta[href*="bajas"] * {
    color: #334155 !important;
    -webkit-text-fill-color: #334155 !important;
  }

  /* 6. PRÉSTAMOS ACTIVOS - Cian */
  a.dashboard-tarjeta[href*="prestamos"] {
    border-left: 4px solid #06b6d4 !important;
  }
  a.dashboard-tarjeta[href*="prestamos"] * {
    color: #0e7490 !important;
    -webkit-text-fill-color: #0e7490 !important;
  }
</style>




<style id="fix-parches-blancos-home">
  html.home-light .row,
  html.home-light .container,
  html.home-light .container-fluid,
  html.home-light [class*="encabezado"],
  html.home-light [class*="header"],
  html.home-light [class*="banner"] {
    background-color: #dcfce7 !important;
  }
  html.home-light .dashboard-tarjeta,
  html.home-light .card,
  html.home-light .card-body {
    background-color: #d1fae5 !important;
    border-color: #6ee7b7 !important;
  }
  html.home-light .dashboard-tarjeta *,
  html.home-light .card-body * {
    background-color: transparent !important;
  }
  html.home-dark .dashboard-tarjeta,
  html.home-dark .card,
  html.home-dark .card-body {
    background-color: #113020 !important;
    border-color: #1f5136 !important;
  }
  html.home-dark .dashboard-tarjeta *,
  html.home-dark .card-body * {
    background-color: transparent !important;
  }
</style>
<script id="fix-parches-blancos-home-js">
document.addEventListener("DOMContentLoaded", function() {
  function pintarTodoVerde() {
    const isDark = document.documentElement.classList.contains("home-dark") ||
                   document.documentElement.getAttribute("data-bs-theme") === "dark";
    const bgCard = isDark ? "#113020" : "#d1fae5";
    const bgWrap = isDark ? "#091e13" : "#dcfce7";

    document.querySelectorAll("div, section, header, nav, aside, main").forEach(el => {
      if (el.classList.contains("btn") || el.classList.contains("badge") || el.closest("button") || el.closest(".badge")) return;
      const comp = getComputedStyle(el).backgroundColor;
      if (comp === "rgb(255, 255, 255)" || comp === "rgb(248, 249, 250)") {
        const esTarjeta = el.classList.contains("dashboard-tarjeta") || el.classList.contains("card") || el.classList.contains("card-body");
        el.style.setProperty("background-color", esTarjeta ? bgCard : bgWrap, "important");
      }
    });
  }
  pintarTodoVerde();
  setTimeout(pintarTodoVerde, 250);
});
</script>

<style id="fix-encabezado-verde-home">
  /* Eliminar franjas blancas detrás de PANEL DE CONTROL y su subtítulo */
  html.home-light h1,
  html.home-light h2,
  html.home-light .dashboard-subtitulo,
  html.home-light [class*="titulo"],
  html.home-light [class*="subtitulo"],
  html.home-light [class*="encabezado"],
  html.home-light .d-flex.justify-content-between,
  html.home-light .mb-4 > div,
  html.home-light .mb-3 > div {
    background-color: transparent !important;
  }

  /* Asegurar contraste nítido en título y subtítulo sobre el verde menta */
  html.home-light h1,
  html.home-light h2 {
    color: #052e16 !important;
    -webkit-text-fill-color: #052e16 !important;
  }

  html.home-light .dashboard-subtitulo {
    color: #14532d !important;
    -webkit-text-fill-color: #14532d !important;
  }
</style>
<script id="fix-encabezado-verde-home-js">
document.addEventListener("DOMContentLoaded", function() {
  function limpiarFranjasHeader() {
    const isDark = document.documentElement.classList.contains("home-dark") ||
                   document.documentElement.getAttribute("data-bs-theme") === "dark";
    const bg = isDark ? "#091e13" : "#dcfce7";

    document.querySelectorAll("h1, h2, h3, p, span, div").forEach(el => {
      if (el.closest(".dashboard-tarjeta") || el.closest(".card") || el.classList.contains("btn") || el.classList.contains("badge")) return;
      const rect = el.getBoundingClientRect();
      if (rect.top < 260 && rect.height > 0 && rect.height < 120) {
        const bgComp = getComputedStyle(el).backgroundColor;
        if (bgComp === "rgb(255, 255, 255)" || bgComp === "rgb(248, 249, 250)") {
          el.style.setProperty("background-color", bg, "important");
        }
      }
    });
  }
  limpiarFranjasHeader();
  setTimeout(limpiarFranjasHeader, 200);
});
</script>

<script id="fix-tablas-verde-js">
document.addEventListener("DOMContentLoaded", function() {
  function aplicarVerdeTablas() {
    const isDark = document.documentElement.classList.contains("home-dark") ||
                   document.documentElement.getAttribute("data-bs-theme") === "dark";
    const bgCelda = isDark ? "#113020" : "#ecfdf5";
    const bgHead  = isDark ? "#17422c" : "#bbf7d0";
    const txtColor = isDark ? "#f1f5f9" : "#0f172a";

    document.querySelectorAll("table tbody tr, table tbody td").forEach(el => {
      el.style.setProperty("background-color", bgCelda, "important");
      el.style.setProperty("color", txtColor, "important");
    });

    document.querySelectorAll("table thead th").forEach(th => {
      th.style.setProperty("background-color", bgHead, "important");
      th.style.setProperty("color", isDark ? "#ffffff" : "#052e16", "important");
    });
  }
  aplicarVerdeTablas();
  setTimeout(aplicarVerdeTablas, 300);
});
</script>