@extends('layouts.app')

@section('template_title')
    {{ __('Update') }} Usuario
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Actualizar') }} Usuario</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}" role="form" autocomplete="off">
                            @method('PUT')
                            @csrf
                            @include('usuarios.form')
                        </form>
                    </div>
                </div>

                <div class="card card-default mt-3">
                    <div class="card-header">
                        <span class="card-title">Restablecer contraseña</span>
                    </div>
                    <div class="card-body bg-white">
                        <p class="text-muted">
                            Define una contraseña nueva para este usuario. Deberá cambiarla la próxima vez que ingrese.
                        </p>
                        <form method="POST" action="{{ route('usuarios.password', $usuario->id) }}" role="form" autocomplete="off">
                            @method('PUT')
                            @csrf
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">NUEVA CONTRASEÑA</label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="NUEVA CONTRASEÑA" autocomplete="new-password" required>
                                <div class="form-text">Mínimo 10 caracteres, con mayúsculas, minúsculas y un número.</div>
                                {!! $errors->first('password', '<div class="invalid-feedback d-block" role="alert"><strong>:message</strong></div>') !!}
                            </div>
                            <div class="form-group mb-3">
                                <label for="password_confirmation" class="form-label">CONFIRMAR CONTRASEÑA</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" placeholder="CONFIRMAR CONTRASEÑA"
                                    autocomplete="new-password" required>
                            </div>
                            <button type="submit" class="btn btn-warning">RESTABLECER CONTRASEÑA</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection