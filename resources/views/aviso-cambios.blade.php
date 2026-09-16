{{-- Incluir al final de create/edit: @include('aviso-cambios') --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('main form') || document.querySelector('form');
    if (!form) return;

    let conCambios = false;

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
            if (r.isConfirmed) accion();
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

    // ESC = retroceder (con confirmación si hay cambios sin guardar)
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        e.preventDefault();

        function retroceder() {
            if (window.history.length > 1) {
                window.history.back();
            }
        }

        if (!conCambios) {
            retroceder();
            return;
        }

        confirmarSalida(retroceder);
    });

    window.addEventListener('beforeunload', function (e) {
        if (!conCambios) return;
        e.preventDefault();
        e.returnValue = '';
    });
});
</script>