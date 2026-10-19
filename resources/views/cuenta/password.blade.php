@extends('layouts.app')

@section('template_title')
    Cambiar contraseña
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-8 col-lg-6">
                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Cambiar contraseña</span>
                    </div>
                    <div class="card-body bg-white">
                        @if ($obligatorio)
                            <div class="alert alert-warning" role="alert">
                                Por seguridad, debes definir tu propia contraseña antes de usar el sistema.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('cuenta.password.update') }}" role="form">
                            @method('PUT')
                            @csrf

                            <div class="form-group mb-3">
                                <label for="password_actual" class="form-label">
                                    CONTRASEÑA ACTUAL <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="password_actual" id="password_actual"
                                    class="form-control @error('password_actual') is-invalid @enderror"
                                    autocomplete="current-password" required>
                                {!! $errors->first('password_actual', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="form-group mb-3">
                                <label for="password" class="form-label">
                                    NUEVA CONTRASEÑA <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    autocomplete="new-password" required>
                                <div class="form-text">Mínimo 10 caracteres, con mayúsculas, minúsculas y un número.</div>
                                {!! $errors->first('password', '<div class="invalid-feedback d-block" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="form-group mb-3">
                                <label for="password_confirmation" class="form-label">
                                    CONFIRMAR NUEVA CONTRASEÑA <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" autocomplete="new-password" required>
                            </div>

                            <button type="submit" class="btn btn-primary">GUARDAR</button>
                            @unless ($obligatorio)
                                <a href="{{ url('/home') }}" class="btn btn-secondary">CANCELAR</a>
                            @endunless
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection