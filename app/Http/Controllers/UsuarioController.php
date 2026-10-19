<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:gestionar-usuarios');
    }

    public function index(): View
    {
        $usuarios = User::orderBy('name')->get();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create(): View
    {
        $usuario = new User(['name' => '', 'email' => '']);
        $usuario->rol = User::ROL_CONSULTA;
        return view('usuarios.create', compact('usuario'));
    }

    public function store(UsuarioRequest $request): RedirectResponse
    {
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->rol = $request->rol;
        $usuario->activo = true;
        $usuario->debe_cambiar_password = true;
        $usuario->save();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario registrado. Deberá cambiar su contraseña al ingresar.')
            ->with('toast_tipo', 'exito');
    }

    public function edit(User $usuario): View
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(UsuarioRequest $request, User $usuario): RedirectResponse
    {
        $cambiaRol = $request->rol !== $usuario->rol;

        if ($cambiaRol && $usuario->is($request->user())) {
            return back()->withInput()->withErrors(['rol' => 'No puedes cambiar tu propio rol.']);
        }

        if ($cambiaRol && $this->esUltimoAdministradorActivo($usuario)) {
            return back()->withInput()->withErrors(['rol' => 'Debe existir al menos un administrador activo.']);
        }

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->rol = $request->rol;
        $usuario->save();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado.')
            ->with('toast_tipo', 'aviso');
    }

    public function cambiarEstado(Request $request, User $usuario): RedirectResponse
    {
        if ($usuario->is($request->user())) {
            return redirect()->route('usuarios.index')
                ->with('success', 'No puedes desactivar tu propia cuenta.')
                ->with('toast_tipo', 'error');
        }

        if ($usuario->activo && $this->esUltimoAdministradorActivo($usuario)) {
            return redirect()->route('usuarios.index')
                ->with('success', 'Debe existir al menos un administrador activo.')
                ->with('toast_tipo', 'error');
        }

        $usuario->activo = ! $usuario->activo;
        $usuario->setRememberToken(Str::random(60));
        $usuario->save();

        return redirect()->route('usuarios.index')
            ->with('success', $usuario->activo ? 'Usuario activado.' : 'Usuario desactivado.')
            ->with('toast_tipo', $usuario->activo ? 'exito' : 'aviso');
    }

    public function restablecerPassword(Request $request, User $usuario): RedirectResponse
    {
        $request->validate(
            ['password' => ['required', 'confirmed', UsuarioRequest::reglaPassword()]],
            UsuarioRequest::mensajesPassword()
        );

        $usuario->password = $request->password;
        $usuario->debe_cambiar_password = true;
        $usuario->setRememberToken(Str::random(60));
        $usuario->save();

        return redirect()->route('usuarios.index')
            ->with('success', 'Contraseña restablecida. Deberá cambiarla al ingresar.')
            ->with('toast_tipo', 'aviso');
    }

    private function esUltimoAdministradorActivo(User $usuario): bool
    {
        return $usuario->esAdministrador()
            && $usuario->activo
            && User::administradoresActivos()->count() <= 1;
    }
}