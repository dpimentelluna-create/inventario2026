@extends('layouts.app')

@section('content')

<style>
    /* Transición suave al cambiar de tema */
    body {
        transition: background 0.3s ease;
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
        transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
    }

    /* Soporte Dark Mode para la tarjeta en general */
    [data-bs-theme="dark"] .login-card {
        background: #1e293b;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.4);
        border: 1px solid #334155;
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
        overflow: hidden;
    }

    [data-bs-theme="dark"] .login-info {
        background: linear-gradient(145deg, #065f46, #064e3b);
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
        background-color: #ffffff;
        transition: background-color 0.3s ease;
    }

    [data-bs-theme="dark"] .login-form {
        background-color: #1e293b;
    }

    .login-form h3 {
        font-weight: 800;
        color: #212529;
        margin-bottom: 5px;
        transition: color 0.3s ease;
    }

    [data-bs-theme="dark"] .login-form h3 {
        color: #f8fafc;
    }

    .login-subtitle {
        color: #6c757d;
        margin-bottom: 30px;
        transition: color 0.3s ease;
    }

    [data-bs-theme="dark"] .login-subtitle {
        color: #94a3b8;
    }

    .form-label {
        font-weight: 700;
        font-size: 13px;
        color: #343a40;
        transition: color 0.3s ease;
    }

    [data-bs-theme="dark"] .form-label {
        color: #cbd5e1;
    }

    .form-control {
        height: 48px;
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding-left: 15px;
        transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
    }

    [data-bs-theme="dark"] .form-control {
        background-color: #0f172a;
        border-color: #334155;
        color: #e2e8f0;
    }

    [data-bs-theme="dark"] .form-control:focus {
        background-color: #0f172a;
        border-color: #10b981;
        color: #e2e8f0;
        box-shadow: 0 0 0 .2rem rgba(16,185,129,.2);
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
        display: flex;
        align-items: center;
        justify-content: center;
        transition: .2s;
    }

    .btn-login:hover {
        background: #157347;
        transform: translateY(-1px);
    }

    .form-check-label {
        color: #6c757d;
        transition: color 0.3s ease;
    }

    [data-bs-theme="dark"] .form-check-label {
        color: #cbd5e1;
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
        transition: background 0.3s ease;
    }

    [data-bs-theme="dark"] .registro-separador::before,
    [data-bs-theme="dark"] .registro-separador::after {
        background: #334155;
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

    [data-bs-theme="dark"] .btn-registrar {
        background: #1e293b;
        border-color: #10b981;
        color: #34d399;
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
        transition: color 0.3s ease;
    }

    [data-bs-theme="dark"] .volver a {
        color: #94a3b8;
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
                            <img src="{{ asset('images/logo-colegio.png') }}"
                                 alt="Logo del colegio"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <i class="bi bi-building logo-placeholder" style="display:none;"></i>
                        </div>

                        <h2>SISTEMA DE GESTIÓN</h2>
                        <h5>
                            Control y administración<br>
                            de equipos tecnológicos
                        </h5>

                        <div class="area-badge">
                            <i class="bi bi-cpu me-1"></i>
                            COORDINACIÓN DE INNOVACIÓN Y SOPORTE TECNOLÓGICO
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
</script>@endsection
<!-- LOGIN_CREATIVE_COLOR_START -->
<style id="login-creative-color-css">
  *, *::before, *::after {
    box-sizing: border-box !important;
  }

  html, body {
    margin: 0 !important;
    padding: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    overflow: hidden !important;
    background-color: #dcfce7 !important;
    background-image: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 55%, #ecfdf5 100%) !important;
  }

  .login-page {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    min-height: 100vh !important;
    max-height: 100vh !important;
    overflow: hidden !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 16px !important;
    margin: 0 !important;
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 55%, #ecfdf5 100%) !important;
    z-index: 999 !important;
  }

  .login-wrapper {
    width: 100% !important;
    max-width: 1000px !important;
    margin: 0 auto !important;
  }

  .login-info {
    background: linear-gradient(160deg, #ecfdf5 0%, #bbf7d0 100%) !important;
    border-right: 1px solid #86efac !important;
  }

  .login-info h2,
  .login-info p,
  .login-info span,
  .login-info p *,
  .login-info span * {
    background: transparent !important;
    background-color: transparent !important;
    background-image: none !important;
    box-shadow: none !important;
    mix-blend-mode: normal !important;
  }

  .login-info h2 {
    color: #064e3b !important;
    -webkit-text-fill-color: #064e3b !important;
  }

  .login-info p,
  .login-info span {
    color: #065f46 !important;
    -webkit-text-fill-color: #065f46 !important;
  }

  .logo-colegio {
    background: #ffffff !important;
    border: 2px solid #4ade80 !important;
  }

  .login-form h3 {
    color: #064e3b !important;
    -webkit-text-fill-color: #064e3b !important;
  }

  .login-form input[type="email"]:focus,
  .login-form input[type="text"]:focus,
  .login-form input[type="password"]:focus {
    border-color: #16a34a !important;
    box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.2) !important;
    outline: none !important;
  }

  .login-form button[type="submit"],
  .login-form input[type="submit"] {
    background: linear-gradient(135deg, #16a34a 0%, #059669 100%) !important;
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
    border: none !important;
    border-radius: 10px !important;
    box-shadow: 0 10px 20px -6px rgba(22, 163, 74, 0.42) !important;
  }

  .login-form button[type="submit"] *,
  .login-form input[type="submit"] * {
    background: transparent !important;
    background-color: transparent !important;
    background-image: none !important;
    box-shadow: none !important;
    border: none !important;
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
  }

  .login-form button[type="submit"] svg,
  .login-form button[type="submit"] img {
    background: transparent !important;
    background-color: transparent !important;
    mix-blend-mode: screen !important;
  }

  .volver a:hover {
    color: #15803d !important;
  }
</style>
<script id="login-creative-color-js">
(function () {
  var nuevoTexto = "COORDINACIÓN DE INNOVACIÓN Y SOPORTE TECNOLÓGICO";
  function limpiarLogin() {
    var info = document.querySelector(".login-info");
    if (info) {
      var walker = document.createTreeWalker(info, NodeFilter.SHOW_TEXT, null, false);
      var tNode;
      while ((tNode = walker.nextNode())) {
        if (/COORDINACI[ÓO]N\s+Y\s+SERVICIO\s+DE\s+TECNOLOG[ÍI]A/i.test(tNode.nodeValue)) {
          tNode.nodeValue = tNode.nodeValue.replace(/COORDINACI[ÓO]N\s+Y\s+SERVICIO\s+DE\s+TECNOLOG[ÍI]A/gi, nuevoTexto);
        }
      }
      var all = info.querySelectorAll("*");
      for (var i = 0; i < all.length; i++) {
        var el = all[i];
        if (el.closest(".logo-colegio, [class*=badge], [class*=pill], button, a")) continue;
        var txt = (el.textContent || "").trim();
        if (txt.indexOf("Control y administraci") !== -1 || el.tagName === "P" || el.tagName === "SPAN") {
          if (el.hasAttribute("style")) {
            var st = el.getAttribute("style").replace(/background[^;]*;?/gi, "").replace(/box-shadow[^;]*;?/gi, "");
            if (st.trim()) el.setAttribute("style", st);
            else el.removeAttribute("style");
          }
          el.style.setProperty("background", "transparent", "important");
          el.style.setProperty("background-color", "transparent", "important");
          el.style.setProperty("background-image", "none", "important");
          el.style.setProperty("box-shadow", "none", "important");
          el.style.setProperty("mix-blend-mode", "normal", "important");
        }
      }
    }
    var btnKids = document.querySelectorAll(".login-form button[type=submit] *, .login-form input[type=submit] *");
    for (var k = 0; k < btnKids.length; k++) {
      var bEl = btnKids[k];
      if (bEl.hasAttribute("style")) {
        var bSt = bEl.getAttribute("style").replace(/background[^;]*;?/gi, "").replace(/box-shadow[^;]*;?/gi, "");
        if (bSt.trim()) bEl.setAttribute("style", bSt);
        else bEl.removeAttribute("style");
      }
      bEl.style.setProperty("background", "transparent", "important");
      bEl.style.setProperty("background-color", "transparent", "important");
      bEl.style.setProperty("background-image", "none", "important");
      bEl.style.setProperty("box-shadow", "none", "important");
    }
  }
  limpiarLogin();
  document.addEventListener("DOMContentLoaded", limpiarLogin);
  window.addEventListener("load", limpiarLogin);
  setTimeout(limpiarLogin, 100);
  setTimeout(limpiarLogin, 400);
})();
</script>
<!-- LOGIN_CREATIVE_COLOR_END -->



<style id="fix-checkbox-recordarme-check">
  input[type="checkbox"][name="remember"],
  input[type="checkbox"]#remember {
    appearance: none !important;
    -webkit-appearance: none !important;
    position: relative !important;
    width: 18px !important;
    height: 18px !important;
    min-width: 18px !important;
    border: 2px solid #2563eb !important;
    border-radius: 4px !important;
    background-color: #ffffff !important;
    cursor: pointer !important;
    vertical-align: middle !important;
    display: inline-grid !important;
    place-content: center !important;
    transition: background-color 0.15s ease, border-color 0.15s ease !important;
  }

  input[type="checkbox"][name="remember"]:focus,
  input[type="checkbox"]#remember:focus {
    outline: none !important;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.25) !important;
  }

  input[type="checkbox"][name="remember"]:checked,
  input[type="checkbox"]#remember:checked {
    background-color: #2563eb !important;
    border-color: #2563eb !important;
  }

  /* Dibuja el check (✓) al marcarlo */
  input[type="checkbox"][name="remember"]:checked::after,
  input[type="checkbox"]#remember:checked::after {
    content: "" !important;
    position: absolute !important;
    top: 44% !important;
    left: 50% !important;
    width: 5px !important;
    height: 10px !important;
    border: solid #ffffff !important;
    border-width: 0 2.2px 2.2px 0 !important;
    transform: translate(-50%, -50%) rotate(42deg) !important;
  }
</style>

<script id="fix-checkbox-recordarme-js">
  document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="remember"], input[type="checkbox"]#remember');
    checkboxes.forEach((cb) => {
      const label = cb.closest('label') || document.querySelector(`label[for="${cb.id}"]`);
      if (label) {
        label.style.cursor = 'pointer';
        label.style.userSelect = 'none';
      }
      cb.addEventListener('change', () => {
        cb.dispatchEvent(new Event('input', { bubbles: true }));
      });
    });
  });
</script>
