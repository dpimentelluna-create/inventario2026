<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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

    <!--EDITAR ICONOS-->
    <style>
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
    </style>

    <style>
        .columna-acciones {
            width: 140px !important;
            min-width: 140px !important;
            max-width: 140px !important;
            white-space: nowrap;
        }
    </style>
    <!-- Scripts 
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])-->
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else


                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('prestamos.index') }}">
                                    {{ __('Prestamos') }}
                                </a>
                            </li>




                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('equipos.index') }}">
                                    {{ __('Equipos') }}
                                </a>
                            </li>

                            <!-- PAGINA ESPECIFICACIONES - SIN ARREGLAR
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('especificaciones-laptop.index') }}">
                                    {{ __('Especificaciones') }}
                                    </a>
                                </li>-->

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('accesorios-equipo.index') }}">
                                    {{ __('Accesorios Equipo') }}
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('docentes.index') }}">
                                    {{ __('Solicitantes') }}
                                </a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('tipos-equipo.index') }}">
                                    {{ __('Tipos Equipos') }}
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('ubicaciones.index') }}">
                                    {{ __('Ubicaciones') }}
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
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
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmarEliminar(form) {
        Swal.fire({
            title: '¿Eliminar registro?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
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
<!--Fin del script-->


@php
$mensajeToast = session('success') ?? session('error') ?? session('warning');
$tipoToast = session('toast_tipo', session('success') ? 'exito' : 'error');
@endphp

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 3500,
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut'
    };
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

<script>
    /*
     * =========================================================
     * ATAJO GENERAL DEL SISTEMA - RETROCEDER
     * =========================================================
     *
     * ESC = RETROCEDER
     *
     * LOS FORMULARIOS CON CAMBIOS SIN GUARDAR
     * CONTROLAN SU PROPIA SALIDA.
     *
     */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key !== 'Escape') {
                return;
            }


            /*
             * SI ESTA PÁGINA TIENE UN FORMULARIO
             * PROTEGIDO CONTRA CAMBIOS SIN GUARDAR,
             * DEJAR QUE ESE FORMULARIO CONTROLE ESC.
             */

            if (
                typeof formularioModificado !== 'undefined'
            ) {

                return;

            }


            event.preventDefault();


            if (window.history.length > 1) {

                window.history.back();

            }

        }
    );
</script>

</body>

</html>