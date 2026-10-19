<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ControlAcceso
{
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = $request->user();

        if (! $usuario || ! $usuario->activo) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Tu cuenta está desactivada. Contacta al administrador.']);
        }

        if ($request->routeIs('cuenta.*')) {
            return $next($request);
        }

        if ($usuario->debe_cambiar_password) {
            return redirect()->route('cuenta.password.edit')
                ->with('warning', 'Debes cambiar tu contraseña antes de continuar.');
        }

        $ruta = $request->route();
        $nombre = $ruta?->getName() ?? '';
        $accion = $ruta?->getActionMethod();

        $esLectura = $request->isMethodSafe() && ! in_array($accion, ['create', 'edit'], true);
        $esExportacion = str_contains($nombre, '.export.');

        if ($esLectura || $esExportacion) {
            return $next($request);
        }

        if ($request->isMethod('DELETE')) {
            abort_unless($usuario->puedeEliminar(), 403, 'Solo el administrador puede eliminar registros.');
            return $next($request);
        }

        abort_unless($usuario->puedeRegistrar(), 403, 'Tu rol es de solo consulta: no puedes crear ni modificar registros.');

        return $next($request);
    }
}