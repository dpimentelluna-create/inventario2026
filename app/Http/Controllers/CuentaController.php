<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CuentaController extends Controller
{
    public function editarPassword(Request $request): View
    {
        return view('cuenta.password', ['obligatorio' => $request->user()->debe_cambiar_password]);
    }

    public function actualizarPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'password_actual' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'different:password_actual', UsuarioRequest::reglaPassword()],
        ], UsuarioRequest::mensajesPassword() + [
            'password_actual.required' => 'Ingresa tu contraseña actual.',
            'password_actual.current_password' => 'La contraseña actual no es correcta.',
            'password.different' => 'La nueva contraseña debe ser distinta de la actual.',
        ]);

        $usuario = $request->user();
        $usuario->password = $request->password;
        $usuario->debe_cambiar_password = false;
        $usuario->save();

        return redirect()->route('home')
            ->with('success', 'Contraseña actualizada.')
            ->with('toast_tipo', 'exito');
    }
}