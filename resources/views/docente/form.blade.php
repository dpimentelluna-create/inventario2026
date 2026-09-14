<div class="row padding-1 p-1">
    <div class="col-md-12">

        <div class="form-group mb-3">
            <label for="nombres" class="form-label">
                NOMBRES
                <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                name="nombres"
                id="nombres"
                class="form-control campo-mayusculas campo-solo-letras @error('nombres') is-invalid @enderror"
                value="{{ old('nombres', $docente->nombres ?? '') }}"
                placeholder="NOMBRES"
                required
            >
            {!! $errors->first('nombres', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="apellidos" class="form-label">
                APELLIDOS
                <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                name="apellidos"
                id="apellidos"
                class="form-control campo-mayusculas campo-solo-letras @error('apellidos') is-invalid @enderror"
                value="{{ old('apellidos', $docente->apellidos ?? '') }}"
                placeholder="APELLIDOS"
                required
            >
            {!! $errors->first('apellidos', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="cargo" class="form-label">
                CARGO
                <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                name="cargo"
                id="cargo"
                class="form-control campo-mayusculas campo-solo-letras @error('cargo') is-invalid @enderror"
                value="{{ old('cargo', $docente->cargo ?? '') }}"
                placeholder="CARGO"
                required
            >
            {!! $errors->first('cargo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input
                type="text"
                name="dni"
                id="dni"
                class="form-control campo-solo-numeros @error('dni') is-invalid @enderror"
                value="{{ old('dni', $docente->dni ?? '') }}"
                placeholder="DNI"
                maxlength="8"
                inputmode="numeric"
            >
            {!! $errors->first('dni', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="correo" class="form-label">CORREO</label>
            <input
                type="email"
                name="correo"
                id="correo"
                class="form-control @error('correo') is-invalid @enderror"
                value="{{ old('correo', $docente->correo ?? '') }}"
                placeholder="CORREO"
            >
            {!! $errors->first('correo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="celular" class="form-label">CELULAR</label>
            <input
                type="text"
                name="celular"
                id="celular"
                class="form-control campo-solo-numeros @error('celular') is-invalid @enderror"
                value="{{ old('celular', $docente->celular ?? '') }}"
                placeholder="CELULAR"
                maxlength="9"
                inputmode="numeric"
            >
            {!! $errors->first('celular', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
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

    function campoValido(campo) {
        const valor = (campo.value || '').trim();

        if (campo.id === 'dni') {
            return valor === '' || /^\d{8}$/.test(valor);
        }

        if (campo.id === 'celular') {
            return valor === '' || /^\d{9}$/.test(valor);
        }

        if (campo.id === 'correo') {
            return valor === '' || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(valor);
        }

        if (campo.hasAttribute('required') || ['nombres', 'apellidos', 'cargo'].includes(campo.id)) {
            return valor !== '' && !/[0-9]/.test(valor);
        }

        return true;
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
        });
    });

    document.querySelectorAll('.campo-solo-numeros').forEach(function (campo) {
        campo.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });

    const dni = document.getElementById('dni');
    const celular = document.getElementById('celular');
    const form = document.querySelector('form');

    document.querySelectorAll('#nombres, #apellidos, #cargo, #dni, #correo, #celular').forEach(function (campo) {
        campo.addEventListener('input', function () {
            if (campoValido(this)) {
                limpiarError(this);
            }
        });

        campo.addEventListener('blur', function () {
            if (this.id === 'dni' && this.value.trim() !== '' && this.value.trim().length !== 8) {
                mostrarError(this, 'El DNI debe tener 8 dígitos.');
            }
            if (this.id === 'celular' && this.value.trim() !== '' && this.value.trim().length !== 9) {
                mostrarError(this, 'Ingrese un numero correcto');
            }
            if (this.id === 'correo' && this.value.trim() !== '' && !campoValido(this)) {
                mostrarError(this, 'Ingrese un correo válido.');
            }
        });
    });

    if (form) {
        form.addEventListener('submit', function (event) {
            if (dni && dni.value.trim() !== '' && dni.value.trim().length !== 8) {
                event.preventDefault();
                mostrarError(dni, 'El DNI debe tener 8 dígitos.');
                dni.focus();
                return;
            }
            if (celular && celular.value.trim() !== '' && celular.value.trim().length !== 9) {
                event.preventDefault();
                mostrarError(celular, 'Ingrese un numero correcto');
                celular.focus();
                return;
            }
            const correo = document.getElementById('correo');
            if (correo && correo.value.trim() !== '' && !campoValido(correo)) {
                event.preventDefault();
                mostrarError(correo, 'Ingrese un correo válido.');
                correo.focus();
            }
        });
    }

});
</script>
