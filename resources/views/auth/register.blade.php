@extends('layouts.app')

@section('content')

<div class="register-page">

<div class="register-card">

    {{-- ENCABEZADO --}}
    <div class="register-header">

        <div class="logo-circle">
            <i class="bi bi-person-plus-fill"></i>
        </div>

        <h2>CREAR CUENTA</h2>

        <p>
            Regístrate para acceder al sistema de gestión
            de equipos tecnológicos.
        </p>

    </div>


    {{-- FORMULARIO --}}
    <div class="register-body">

        <form method="POST" action="{{ route('register') }}">
            @csrf


            {{-- NOMBRE --}}
            <div class="form-group">

                <label for="name">
                    <i class="bi bi-person"></i>
                    NOMBRE DE USUARIO
                </label>

                <input
                    id="name"
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autocomplete="name"
                    autofocus
                    placeholder="Ingrese su nombre"
                >

                @error('name')
                    <div class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror

            </div>


            {{-- CORREO --}}
            <div class="form-group">

                <label for="email">
                    <i class="bi bi-envelope"></i>
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
                    placeholder="ejemplo@correo.com"
                >

                @error('email')
                    <div class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror

            </div>


            {{-- CONTRASEÑA --}}
            <div class="form-group">

                <label for="password">
                    <i class="bi bi-lock"></i>
                    CONTRASEÑA
                </label>

                <div class="password-wrapper">

                    <input
                        id="password"
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Ingrese una contraseña"
                    >

                    <button
                        type="button"
                        class="btn-show-password"
                        onclick="mostrarPassword('password', this)"
                    >
                        <i class="bi bi-eye"></i>
                    </button>

                </div>

                @error('password')
                    <div class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror

            </div>


            {{-- CONFIRMAR CONTRASEÑA --}}
            <div class="form-group">

                <label for="password-confirm">
                    <i class="bi bi-shield-lock"></i>
                    CONFIRMAR CONTRASEÑA
                </label>

                <div class="password-wrapper">

                    <input
                        id="password-confirm"
                        type="password"
                        class="form-control"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Repita su contraseña"
                    >

                    <button
                        type="button"
                        class="btn-show-password"
                        onclick="mostrarPassword('password-confirm', this)"
                    >
                        <i class="bi bi-eye"></i>
                    </button>

                </div>

            </div>


            {{-- BOTÓN REGISTRAR --}}
            <button type="submit" class="btn-registrar">

                <i class="bi bi-person-check-fill"></i>

                CREAR CUENTA

            </button>


            {{-- SEPARADOR --}}
            <div class="separador">
                <span>¿YA TIENE UNA CUENTA?</span>
            </div>


            {{-- VOLVER AL LOGIN --}}
            <a href="{{ route('login') }}" class="btn-login">

                <i class="bi bi-box-arrow-in-right"></i>

                INICIAR SESIÓN

            </a>


            {{-- VOLVER A PORTADA --}}
            <div class="volver-portada">

                <a href="{{ url('/') }}">

                    <i class="bi bi-arrow-left"></i>

                    Volver a la portada

                </a>

            </div>

        </form>

    </div>

</div>

</div>
@endsection

<script>
    function mostrarPassword(id, boton) {

        const input = document.getElementById(id);
        const icono = boton.querySelector('i');

        if (input.type === 'password') {

            input.type = 'text';

            icono.classList.remove('bi-eye');
            icono.classList.add('bi-eye-slash');

        } else {

            input.type = 'password';

            icono.classList.remove('bi-eye-slash');
            icono.classList.add('bi-eye');

        }

    }


    // ESC = volver a la portada
    document.addEventListener('keydown', function (e) {

        if (e.key !== 'Escape') return;

        window.location.href = @json(url('/'));

    });
</script>

<style>

    /* =====================================================
       PÁGINA DE REGISTRO
       ===================================================== */

    .register-page {

        min-height: calc(100vh - 56px);

        display: flex;
        justify-content: center;
        align-items: center;

        padding: 40px 20px;

        background:
            linear-gradient(
                135deg,
                #f1fff4 0%,
                #ffffff 50%,
                #e9f9ef 100%
            );

    }


    /* =====================================================
       TARJETA
       ===================================================== */

    .register-card {

        width: 100%;
        max-width: 500px;

        background: #ffffff;

        border-radius: 18px;

        overflow: hidden;

        border: 1px solid #d8e8dc;

        box-shadow:
            0 12px 35px rgba(0, 0, 0, 0.10);

    }


    /* =====================================================
       ENCABEZADO
       ===================================================== */

    .register-header {

        text-align: center;

        padding: 32px 30px 24px;

        background:
            linear-gradient(
                135deg,
                #198754,
                #157347
            );

        color: white;

    }


    .logo-circle {

        width: 70px;
        height: 70px;

        margin: 0 auto 15px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background: rgba(255,255,255,.18);

        border: 2px solid rgba(255,255,255,.55);

    }


    .logo-circle i {

        font-size: 32px;

    }


    .register-header h2 {

        margin: 0;

        font-weight: 800;

        font-size: 25px;

        letter-spacing: .5px;

    }


    .register-header p {

        margin: 10px auto 0;

        max-width: 380px;

        font-size: 13px;

        line-height: 1.5;

        opacity: .9;

    }


    /* =====================================================
       CUERPO
       ===================================================== */

    .register-body {

        padding: 30px 35px 25px;

    }


    /* =====================================================
       CAMPOS
       ===================================================== */

    .form-group {

        margin-bottom: 19px;

    }


    .form-group label {

        display: block;

        margin-bottom: 7px;

        font-size: 12px;

        font-weight: 700;

        letter-spacing: .04em;

        color: #198754;

    }


    .form-group label i {

        margin-right: 5px;

    }


    .form-control {

        height: 46px;

        border-radius: 9px;

        border: 1px solid #ced4da;

        padding: 10px 13px;

        font-size: 14px;

        transition: .2s;

    }


    .form-control:focus {

        border-color: #198754;

        box-shadow:
            0 0 0 .20rem rgba(25,135,84,.12);

    }


    /* =====================================================
       CONTRASEÑA
       ===================================================== */

    .password-wrapper {

        position: relative;

    }


    .password-wrapper .form-control {

        padding-right: 48px;

    }


    .btn-show-password {

        position: absolute;

        right: 5px;
        top: 5px;

        width: 36px;
        height: 36px;

        border: none;

        background: transparent;

        color: #6c757d;

        border-radius: 7px;

        cursor: pointer;

    }


    .btn-show-password:hover {

        background: #f1f3f5;

        color: #198754;

    }


    /* =====================================================
       BOTÓN REGISTRAR
       ===================================================== */

    .btn-registrar {

        width: 100%;

        height: 46px;

        border: none;

        border-radius: 9px;

        background: #198754;

        color: white;

        font-weight: 700;

        font-size: 14px;

        letter-spacing: .03em;

        transition: .2s;

    }


    .btn-registrar:hover {

        background: #157347;

        transform: translateY(-1px);

        box-shadow:
            0 5px 12px rgba(25,135,84,.20);

    }


    .btn-registrar i {

        margin-right: 6px;

    }


    /* =====================================================
       SEPARADOR
       ===================================================== */

    .separador {

        display: flex;

        align-items: center;

        gap: 12px;

        margin: 24px 0 16px;

        color: #8a8a8a;

        font-size: 10px;

        font-weight: 700;

        letter-spacing: .05em;

    }


    .separador::before,
    .separador::after {

        content: "";

        flex: 1;

        height: 1px;

        background: #e5e5e5;

    }


    /* =====================================================
       BOTÓN LOGIN
       ===================================================== */

    .btn-login {

        width: 100%;

        height: 44px;

        display: flex;

        align-items: center;

        justify-content: center;

        gap: 7px;

        border-radius: 9px;

        border: 1px solid #198754;

        color: #198754;

        background: white;

        text-decoration: none;

        font-size: 13px;

        font-weight: 700;

        transition: .2s;

    }


    .btn-login:hover {

        background: #f1fff5;

        color: #157347;

    }


    /* =====================================================
       VOLVER
       ===================================================== */

    .volver-portada {

        text-align: center;

        margin-top: 20px;

    }


    .volver-portada a {

        color: #6c757d;

        text-decoration: none;

        font-size: 12px;

    }


    .volver-portada a:hover {

        color: #198754;

    }


    /* =====================================================
       RESPONSIVE
       ===================================================== */

    @media (max-width: 576px) {

        .register-page {

            padding: 20px 12px;

        }

        .register-body {

            padding: 25px 20px;

        }

        .register-header {

            padding: 28px 20px 22px;

        }

    }

</style>
