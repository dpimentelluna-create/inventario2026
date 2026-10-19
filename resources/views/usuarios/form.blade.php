@php $esUnoMismo = $usuario->exists && $usuario->is(auth()->user()); @endphp
<div class="row padding-1 p-1">
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="name" class="form-label">
                NOMBRE COMPLETO <span class="text-danger">*</span>
            </label>
            <input type="text" name="name" id="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $usuario->name) }}" placeholder="NOMBRE COMPLETO"
                maxlength="100" required>
            {!! $errors->first('name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="email" class="form-label">
                CORREO <span class="text-danger">*</span>
            </label>
            <input type="email" name="email" id="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $usuario->email) }}" placeholder="CORREO"
                maxlength="150" autocomplete="off" required>
            {!! $errors->first('email', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-3">
            <label for="rol" class="form-label">
                ROL <span class="text-danger">*</span>
            </label>
            <select name="rol" id="rol"
                class="form-select @error('rol') is-invalid @enderror"
                @disabled($esUnoMismo) required>
                @foreach (\App\Models\User::ROLES as $valor => $etiqueta)
                    <option value="{{ $valor }}" @selected(old('rol', $usuario->rol) === $valor)>{{ $etiqueta }}</option>
                @endforeach
            </select>
            @if ($esUnoMismo)
                <input type="hidden" name="rol" value="{{ $usuario->rol }}">
                <div class="form-text">No puedes cambiar tu propio rol.</div>
            @else
                <div class="form-text">
                    Administrador: todo, incluido eliminar y gestionar usuarios.
                    Registrador: crear y editar, sin eliminar.
                    Consulta: solo ver y exportar.
                </div>
            @endif
            {!! $errors->first('rol', '<div class="invalid-feedback d-block" role="alert"><strong>:message</strong></div>') !!}
        </div>

        @unless ($usuario->exists)
            <div class="form-group mb-3">
                <label for="password" class="form-label">
                    CONTRASEÑA INICIAL <span class="text-danger">*</span>
                </label>
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="CONTRASEÑA INICIAL" autocomplete="new-password" required>
                <div class="form-text">Mínimo 10 caracteres, con mayúsculas, minúsculas y un número. El usuario deberá cambiarla al ingresar.</div>
                {!! $errors->first('password', '<div class="invalid-feedback d-block" role="alert"><strong>:message</strong></div>') !!}
            </div>
            <div class="form-group mb-3">
                <label for="password_confirmation" class="form-label">
                    CONFIRMAR CONTRASEÑA <span class="text-danger">*</span>
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="form-control" placeholder="CONFIRMAR CONTRASEÑA"
                    autocomplete="new-password" required>
            </div>
        @endunless
    </div>

    <div class="col-md-12 mt-2">
        <button type="submit" class="btn btn-primary">GUARDAR</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">CANCELAR</a>
    </div>
</div>