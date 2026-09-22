{{-- Incluir al final de create/edit: @include('aviso-cambios') --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('main form') || document.querySelector('form');
    if (!form) return;

    let conCambios = false;

    const esEdicion = !!form.querySelector('input[name="_method"][value="PUT"], input[name="_method"][value="PATCH"]')
        || /\/edit(\?|$)/.test(window.location.pathname);
    if (esEdicion) conCambios = true;

    form.addEventListener('input', function () { conCambios = true; });
    form.addEventListener('change', function () { conCambios = true; });
    form.addEventListener('submit', function () { conCambios = false; });

    function confirmarSalida(accion) {
        if (typeof Swal === 'undefined') {
            if (confirm('Cambios sin guardar. ¿Desea salir?')) accion();
            return;
        }
        Swal.fire({
            icon: 'warning',
            title: 'Cambios sin guardar',
            text: '¿Desea salir?',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, salir',
            cancelButtonText: 'Seguir editando',
            reverseButtons: true
        }).then(function (r) {
            if (r.isConfirmed) {
                conCambios = false;
                accion();
            }
        });
    }

    document.querySelectorAll('a[href]').forEach(function (enlace) {
        const href = enlace.getAttribute('href');
        if (!href || href === '#' || href.startsWith('javascript:')) return;
        enlace.addEventListener('click', function (e) {
            if (!conCambios) return;
            e.preventDefault();
            confirmarSalida(function () { window.location.href = enlace.href; });
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            e.preventDefault();
            function retroceder() {
                if (window.history.length > 1) window.history.back();
            }
            if (!conCambios) { retroceder(); return; }
            confirmarSalida(retroceder);
            return;
        }

        const recarga = e.key === 'F5' ||
            ((e.ctrlKey || e.metaKey) && (e.key === 'r' || e.key === 'R'));

        if (!recarga || !conCambios) return;

        e.preventDefault();
        confirmarSalida(function () { window.location.reload(); });
    });

    window.addEventListener('beforeunload', function (e) {
        if (!conCambios) return;
        e.preventDefault();
        e.returnValue = '';
    });
});
</script>
