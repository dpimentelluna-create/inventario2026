<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdministradorSeeder extends Seeder
{
    public function run(): void
    {
        $email = strtolower(trim((string) config('inventario.admin.email')));
        $password = (string) config('inventario.admin.password');
        $nombre = trim((string) config('inventario.admin.name', 'Administrador'));

        if ($email === '' || $password === '') {
            $this->command?->error('Define ADMIN_EMAIL y ADMIN_PASSWORD en el archivo .env.');
            return;
        }

        if (mb_strlen($password) < 10) {
            $this->command?->error('ADMIN_PASSWORD debe tener al menos 10 caracteres.');
            return;
        }

        $usuario = User::where('email', $email)->first() ?? new User();
        $nuevo = ! $usuario->exists;

        $usuario->name = $usuario->exists ? $usuario->name : $nombre;
        $usuario->email = $email;
        $usuario->rol = User::ROL_ADMINISTRADOR;
        $usuario->activo = true;

        if ($nuevo) {
            $usuario->password = $password;
            $usuario->debe_cambiar_password = true;
        }

        $usuario->save();

        $this->command?->info($nuevo
            ? "Administrador creado: {$email} (deberá cambiar la contraseña al ingresar)."
            : "Usuario existente promovido a administrador: {$email}.");
    }
}