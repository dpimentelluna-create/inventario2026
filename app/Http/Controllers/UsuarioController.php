<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Models\Auditoria;

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
        Auditoria::registrar(
            'CREAR',
            'USUARIOS',
            'Registro la cuenta del usuario ' . $usuario->name . '.',
            $usuario
        );

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
        $valoresAnteriores = [
            'name' => $usuario->name,
            'email' => $usuario->email,
            'rol' => $usuario->rol,
        ];
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

        $valoresNuevos = [
            'name' => $usuario->name,
            'email' => $usuario->email,
            'rol' => $usuario->rol,
        ];

        $cambios = [];

        foreach ($valoresAnteriores as $campo => $anterior) {
            if ($anterior !== $valoresNuevos[$campo]) {
                $cambios[$campo] = [
                    'anterior' => $anterior,
                    'nuevo' => $valoresNuevos[$campo],
                ];
            }
        }

        if (!empty($cambios)) {
            Auditoria::registrar(
                'ACTUALIZAR',
                'USUARIOS',
                'Actualizó los datos de la cuenta ' . $usuario->name . '.',
                $usuario,
                $cambios
            );
        }

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado.')
            ->with('toast_tipo', 'aviso');
    }

    public function show(User $usuario): View
    {
        $consultaAuditoria = Auditoria::where(
            'usuario_id',
            $usuario->id
        );

        $totalAuditorias = (clone $consultaAuditoria)->count();

        $ultimaActividad = (clone $consultaAuditoria)
            ->latest('created_at')
            ->first();

        $auditorias = (clone $consultaAuditoria)
            ->latest('created_at')
            ->latest('id')
            ->paginate(10);

        return view('usuarios.show', compact(
            'usuario',
            'auditorias',
            'totalAuditorias',
            'ultimaActividad'
        ));
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

        $usuario->activo = !$usuario->activo;
        $usuario->setRememberToken(Str::random(60));
        $usuario->save();

        Auditoria::registrar(
            $usuario->activo ? 'ACTIVAR' : 'DESACTIVAR',
            'USUARIOS',
            ($usuario->activo ? 'Activó' : 'Desactivó')
            . ' la cuenta de ' . $usuario->name . '.',
            $usuario,
            [
                'activo' => [
                    'anterior' => !$usuario->activo,
                    'nuevo' => $usuario->activo,
                ],
            ]
        );

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

        Auditoria::registrar(
            'RESTABLECER_PASSWORD',
            'USUARIOS',
            'Restableció la contraseña de la cuenta '
            . $usuario->name . '.',
            $usuario
        );

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