<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\PasswordSegura;

class UsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('gestionar-usuarios') ?? false;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim((string) $this->name),
            'email' => strtolower(trim((string) $this->email)),
        ]);
    }

    public function rules(): array
    {
        $usuario = $this->route('usuario');

        $reglas = [
            'name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($usuario),
            ],
            'rol' => ['required', Rule::in(array_keys(User::ROLES))],
        ];

        if ($this->isMethod('POST')) {
            $reglas['password'] = ['required', 'confirmed', self::reglaPassword()];
        }

        return $reglas;
    }

    public static function reglaPassword(): PasswordSegura
    {
        return new PasswordSegura();
    }

    public function messages(): array
    {
        return self::mensajesPassword() + [
            'name.required' => 'Ingresa el nombre del usuario.',
            'name.max' => 'El nombre no puede superar los 100 caracteres.',
            'email.required' => 'Ingresa el correo del usuario.',
            'email.email' => 'Ingresa un correo válido.',
            'email.unique' => 'Ya existe un usuario con este correo.',
            'email.max' => 'El correo no puede superar los 150 caracteres.',
            'rol.required' => 'Selecciona un rol.',
            'rol.in' => 'El rol seleccionado no es válido.',
        ];
    }

    public static function mensajesPassword(): array
    {
        return [
            'password.required' => 'Ingresa la contraseña.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ];
    }
}