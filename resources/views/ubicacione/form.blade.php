<div class="row padding-1 p-1">
    <div class="col-md-12">

        <div class="form-group mb-3">
            <label for="nombre" class="form-label">
                NOMBRE
                <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                name="nombre"
                id="nombre"
                class="form-control campo-mayusculas @error('nombre') is-invalid @enderror"
                value="{{ old('nombre', $ubicacione->nombre ?? '') }}"
                placeholder="NOMBRE"
                required
            >
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="tipo" class="form-label">TIPO</label>
            <input
                type="text"
                name="tipo"
                id="tipo"
                class="form-control campo-mayusculas campo-solo-letras @error('tipo') is-invalid @enderror"
                value="{{ old('tipo', $ubicacione->tipo ?? '') }}"
                placeholder="TIPO"
            >
            {!! $errors->first('tipo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>

    <div class="col-md-12 mt-2">
        <button type="submit" class="btn btn-primary">GUARDAR</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    function limpiarError(campo) {
        if (!campo) return;
        campo.classList.remove('is-invalid');
        campo.parentElement.querySelectorAll('.invalid-feedback, .js-error-campo').forEach(function (el) {
            el.remove();
        });
    }

    function mostrarError(campo, mensaje) {
        if (!campo) return;
        limpiarError(campo);
        campo.classList.add('is-invalid');
        const box = document.createElement('div');
        box.className = 'js-error-campo invalid-feedback d-block';
        box.innerHTML = '<strong>' + mensaje + '</strong>';
        campo.insertAdjacentElement('afterend', box);
    }

    document.querySelectorAll('.campo-mayusculas').forEach(function (campo) {
        campo.addEventListener('input', function () {
            const start = this.selectionStart;
            const end = this.selectionEnd;
            this.value = this.value.toUpperCase();
            this.setSelectionRange(start, end);
        });
    });

    document.querySelectorAll('.campo-solo-letras').forEach(function (campo) {
        campo.addEventListener('input', function () {
            const start = this.selectionStart;
            const end = this.selectionEnd;
            this.value = this.value.replace(/[0-9]/g, '').toUpperCase();
            this.setSelectionRange(start, end);
            if (this.value.trim() !== '') {
                limpiarError(this);
            }
        });
    });

    const nombre = document.getElementById('nombre');
    const form = nombre ? nombre.closest('form') : null;

    if (form) {
        form.addEventListener('submit', function (event) {
            if (!nombre || nombre.value.trim() === '') {
                event.preventDefault();
                mostrarError(nombre, 'El nombre de la ubicación es obligatorio.');
                nombre.focus();
            }
        });
    }

});
</script>
