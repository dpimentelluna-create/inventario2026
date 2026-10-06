/**
 * Validación compartida de formularios (equipos y préstamos).
 * No incluye parte1Completa ni el bloqueo de tarjetas: eso sigue en cada form.
 *
 * Uso, antes del script del form:
 *   <script src="{{ asset('js/form-validaciones.js') }}"></script>
 *   FormValidacion.init({
 *       toastId: 'toast_equipo',
 *       textoId: 'toast_equipo_texto',
 *       toastEnCampo: false
 *   });
 */
(function (window) {
    'use strict';

    var config = {
        toastId: null,
        textoId: null,
        toastEnCampo: false,
        focusDelay: 200
    };

    function init(opciones) {
        config = Object.assign({}, config, opciones || {});
    }

    function aMayusculas(campo) {
        if (!campo) return;
        var start = campo.selectionStart;
        var end = campo.selectionEnd;
        campo.value = campo.value.toUpperCase();
        if (typeof start === 'number') campo.setSelectionRange(start, end);
    }

    function bindMayusculas(raiz) {
        (raiz || document).querySelectorAll('.campo-mayusculas').forEach(function (campo) {
            campo.addEventListener('input', function () {
                aMayusculas(this);
            });
        });
    }

    function mostrarToast(mensaje, tipo) {
        if (!config.toastId || !config.textoId) return;
        var toastEl = document.getElementById(config.toastId);
        var textoEl = document.getElementById(config.textoId);
        if (!toastEl || !textoEl || typeof bootstrap === 'undefined') return;

        textoEl.textContent = mensaje;
        toastEl.classList.remove('text-bg-success', 'text-bg-danger', 'text-bg-primary');
        toastEl.classList.add(tipo === 'danger' ? 'text-bg-danger' : 'text-bg-success');
        bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 3000 }).show();
    }

    function limpiarErroresCampos() {
        document.querySelectorAll('.error-toast-campo').forEach(function (el) {
            el.remove();
        });
        document.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });
    }

    function claseAviso() {
        return config.toastEnCampo
            ? 'error-toast-campo alert alert-danger py-1 px-2 small mt-1 mb-0'
            : 'error-toast-campo text-danger small mt-1 mb-0';
    }

    function marcarError(campo, mensaje) {
        if (!campo) return;
        campo.classList.add('is-invalid');
        var contenedor = campo.closest('.mb-3') || campo.parentElement;
        if (!contenedor) return;
        var aviso = contenedor.querySelector('.error-toast-campo');
        if (!aviso) {
            aviso = document.createElement('div');
            aviso.className = claseAviso();
            campo.insertAdjacentElement('afterend', aviso);
        }
        aviso.textContent = mensaje;
    }

    function limpiarErrorCampo(campo) {
        if (!campo) return;
        campo.classList.remove('is-invalid');
        var caja = campo.closest('.mb-3') || campo.parentElement;
        var err = caja ? caja.querySelector('.error-toast-campo') : null;
        if (err) err.remove();
    }

    function mostrarErrorCampo(campo, mensaje) {
        if (!campo) {
            mostrarToast(mensaje, 'danger');
            return;
        }
        marcarError(campo, mensaje);
        if (config.toastEnCampo) mostrarToast(mensaje, 'danger');
        campo.scrollIntoView({ behavior: 'smooth', block: 'center' });
        window.setTimeout(function () {
            campo.focus();
        }, config.focusDelay);
    }

    function validarCampoVivo(id, mensaje, extra) {
        var campo = document.getElementById(id);
        if (!campo) return;
        campo.addEventListener('blur', function () {
            if (this.readOnly || this.disabled) return;
            if (typeof extra === 'function') {
                extra(this);
                return;
            }
            if (!this.value.trim()) marcarError(this, mensaje);
            else limpiarErrorCampo(this);
        });
        campo.addEventListener('input', function () {
            if (this.value.trim()) limpiarErrorCampo(this);
        });
        campo.addEventListener('change', function () {
            if (this.value.trim()) limpiarErrorCampo(this);
        });
    }

    window.FormValidacion = {
        init: init,
        aMayusculas: aMayusculas,
        bindMayusculas: bindMayusculas,
        mostrarToast: mostrarToast,
        limpiarErroresCampos: limpiarErroresCampos,
        marcarError: marcarError,
        limpiarErrorCampo: limpiarErrorCampo,
        mostrarErrorCampo: mostrarErrorCampo,
        validarCampoVivo: validarCampoVivo
    };
})(window);
