<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Límite de intentos fallidos de inicio de sesión (por correo + IP).
     */
    protected $maxAttempts = 5;

    /**
     * Minutos de bloqueo al superar el límite de intentos.
     */
    protected $decayMinutes = 5;

    /**
     * Solo las cuentas activas pueden iniciar sesión.
     */
    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['activo' => true]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}