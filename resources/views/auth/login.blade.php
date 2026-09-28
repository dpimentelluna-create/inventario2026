@extends('layouts.app')

@section('content')

<style>
    body {
        background: linear-gradient(135deg, #f4fff4 0%, #ffffff 50%, #eaffea 100%);
    }

    .login-page {
        min-height: calc(100vh - 56px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 15px;
    }

    .login-wrapper {
        width: 100%;
        max-width: 1000px;
    }

    .login-card {
        background: #ffffff;
        border: none;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.12);
    }

    /* PANEL IZQUIERDO */

    .login-info {
        background: linear-gradient(145deg, #198754, #116b42);
        color: white;
        min-height: 560px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px;
        position: relative;
    }

    .login-info::before {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border: 2px solid rgba(255,255,255,.12);
        border-radius: 50%;
        top: -70px;
        right: -70px;
    }

    .login-info::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        border: 2px solid rgba(255,255,255,.10);
        border-radius: 50%;
        bottom: -70px;
        left: -60px;
    }

    .logo-colegio {
        width: 125px;
        height: 125px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        box-shadow: 0 6px 18px rgba(0,0,0,.18);
        overflow: hidden;
    }

    .logo-colegio img {
        width: 90%;
        height: 90%;
        object-fit: contain;
    }

    .logo-placeholder {
        color: #198754;
        font-size: 48px;
    }

    .login-info h2 {
        font-weight: 800;
        font-size: 28px;
        margin-bottom: 8px;
        position: relative;
        z-index: 2;
    }

    .login-info h5 {
        font-weight: 400;
        opacity: .95;
        margin-bottom: 25px;
        position: relative;
        z-index: 2;
    }

    .area-badge {
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.25);
        border-radius: 30px;
        padding: 10px 20px;
        font-size: 13px;
        font-weight: 600;
        position: relative;
        z-index: 2;
    }

    /* PANEL DERECHO */

    .login-form {
        padding: 55px 55px;
        min-height: 560px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .login-form h3 {
        font-weight: 800;
        color: #212529;
        margin-bottom: 5px;
    }

    .login-subtitle {
        color: #6c757d;
        margin-bottom: 30px;
    }

    .form-label {
        font-weight: 700;
        font-size: 13px;
        color: #343a40;
    }

    .form-control {
        height: 48px;
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding-left: 15px;
    }

    .form-control:focus {
        border-color: #198754;
        box-shadow: 0 0 0 .2rem rgba(25,135,84,.15);
    }

    .btn-login {
        width: 100%;
        height: 48px;
        border-radius: 8px;
        background: #198754;
        border: none;
        color: white;
        font-weight: 700;
        transition: .2s;
    }

    .btn-login:hover {
        background: #157347;
        transform: translateY(-1px);
    }

    .registro-separador {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 25px 0 18px;
        color: #adb5bd;
        font-size: 13px;
    }

    .registro-separador::before,
    .registro-separador::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #dee2e6;
    }

    .btn-registrar {
        width: 100%;
        height: 45px;
        border-radius: 8px;
        border: 1px solid #198754;
        background: white;
        color: #198754;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: .2s;
    }

    .btn-registrar:hover {
        background: #198754;
        color: white;
    }

    .volver {
        text-align: center;
        margin-top: 25px;
    }

    .volver a {
        color: #6c757d;
        text-decoration: none;
        font-size: 14px;
    }

    .volver a:hover {
        color: #198754;
    }

    @media (max-width: 767px) {

        .login-info {
            min-height: 300px;
            padding: 30px 20px;
        }

        .logo-colegio {
            width: 90px;
            height: 90px;
            margin-bottom: 15px;
        }

        .login-info h2 {
            font-size: 22px;
        }

        .login-form {
            min-height: auto;
            padding: 35px 25px;
        }
    }
</style>

<div class="login-page">

<div class="login-wrapper">

    <div class="login-card">

        <div class="row g-0">

            {{-- ================================================= --}}
            {{-- PANEL IZQUIERDO --}}
            {{-- ================================================= --}}

            <div class="col-md-5">

                <div class="login-info">

                    {{-- LOGO DEL COLEGIO --}}
                    <div class="logo-colegio">

                        {{-- 
                            CUANDO TENGAS EL LOGO:
                            coloca el archivo en public/images/logo-colegio.png
                            y descomenta la siguiente línea.
                        --}}

                        <img src="{{ asset('images/logo-colegio.png') }}"
                             alt="Logo del colegio"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">

                        <i class="bi bi-building logo-placeholder"
                           style="display:none;"></i>

                    </div>

                    <h2>SISTEMA DE GESTIÓN</h2>

                    <h5>
                        Control y administración<br>
                        de equipos tecnológicos
                    </h5>

                    <div class="area-badge">
                        <i class="bi bi-cpu me-1"></i>
                        COORDINACIÓN Y SERVICIO DE TECNOLOGÍA
                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- PANEL DERECHO --}}
            {{-- ================================================= --}}

            <div class="col-md-7">

                <div class="login-form">

                    <div>

                        <h3>Bienvenido</h3>

                        <p class="login-subtitle">
                            Ingresa a tu cuenta para continuar.
                        </p>


                        <form method="POST" action="{{ route('login') }}">

                            @csrf


                            {{-- CORREO --}}

                            <div class="mb-3">

                                <label for="email" class="form-label">
                                    CORREO ELECTRÓNICO
                                </label>

                                <input
                                    id="email"
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    autofocus
                                    placeholder="Ingrese su correo electrónico"
                                >

                                @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror

                            </div>


                            {{-- CONTRASEÑA --}}

                            <div class="mb-3">

                                <label for="password" class="form-label">
                                    CONTRASEÑA
                                </label>

                                <input
                                    id="password"
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Ingrese su contraseña"
                                >

                                @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror

                            </div>


                            {{-- RECORDAR --}}

                            <div class="form-check mb-4">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="remember"
                                    id="remember"
                                    {{ old('remember') ? 'checked' : '' }}
                                >

                                <label class="form-check-label" for="remember">
                                    Recordarme
                                </label>

                            </div>


                            {{-- INGRESAR --}}

                            <button type="submit" class="btn-login">
                                <i class="bi bi-box-arrow-in-right me-1"></i>
                                INGRESAR AL SISTEMA
                            </button>


                            {{-- RECUPERAR CONTRASEÑA --}}

                            @if (Route::has('password.request'))

                                <div class="text-center mt-3">

                                    <a
                                        href="{{ route('password.request') }}"
                                        class="text-success text-decoration-none small"
                                    >
                                        ¿Olvidaste tu contraseña?
                                    </a>

                                </div>

                            @endif


                            {{-- REGISTRO --}}

                            @if (Route::has('register'))

                                <div class="registro-separador">
                                    O
                                </div>

                                <a
                                    href="{{ route('register') }}"
                                    class="btn-registrar"
                                >
                                    <i class="bi bi-person-plus me-2"></i>
                                    CREAR NUEVA CUENTA
                                </a>

                            @endif


                            {{-- VOLVER --}}

                            <div class="volver">

                                <a href="{{ url('/') }}">
                                    <i class="bi bi-arrow-left"></i>
                                    Volver a la portada
                                </a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</div>

<script>
    document.addEventListener('keydown', function (e) {

        if (e.key !== 'Escape') return;

        window.location.href = @json(url('/'));

    });
</script>

@endsection
