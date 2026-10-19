<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\EquipoController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::middleware(['auth', 'acceso'])->group(function () {
    // Cambiar contraseña propia
    Route::get('/cuenta/password', [\App\Http\Controllers\CuentaController::class, 'editarPassword'])
        ->name('cuenta.password.edit');
    Route::put('/cuenta/password', [\App\Http\Controllers\CuentaController::class, 'actualizarPassword'])
        ->name('cuenta.password.update');

    // Módulo Usuarios (solo administrador)
    Route::middleware('can:gestionar-usuarios')->group(function () {
        Route::post('/usuarios/{usuario}/estado', [\App\Http\Controllers\UsuarioController::class, 'cambiarEstado'])
            ->name('usuarios.estado');
        Route::put('/usuarios/{usuario}/password', [\App\Http\Controllers\UsuarioController::class, 'restablecerPassword'])
            ->name('usuarios.password');

        Route::resource('usuarios', \App\Http\Controllers\UsuarioController::class)
            ->parameters(['usuarios' => 'usuario'])
            ->except(['destroy']);   // quitamos 'show' del except
    });

    //HOME:
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //UBICACIONES
    Route::resource('ubicaciones', App\Http\Controllers\UbicacioneController::class);

    //TIPOS DE EQUIPO
    Route::resource('tipos-equipo', App\Http\Controllers\TiposEquipoController::class);

    //EQUIPOS
    Route::post('/equipos/{equipo}/accesorios', [EquipoController::class, 'guardarAccesorios'])
        ->name('equipos.accesorios.store');
    Route::post('/equipos/export/pdf', [EquipoController::class, 'exportPdf'])
        ->name('equipos.export.pdf');
    Route::post('/equipos/export-excel', [EquipoController::class, 'exportExcel'])
        ->name('equipos.export.excel');
    Route::get('/equipos/verificar-serie', [EquipoController::class, 'verificarSerie'])
        ->name('equipos.verificarSerie');
    Route::get('/equipos/verificar-serie-accesorio', [EquipoController::class, 'verificarSerieAccesorio'])
        ->name('equipos.verificarSerieAccesorio');
    Route::post('/equipos/{equipo}/auditar-impresion', [EquipoController::class, 'auditarImpresion'])
        ->name('equipos.auditar-impresion');


    Route::resource('equipos', App\Http\Controllers\EquipoController::class);

    //ESPECIFICACIONES LAPTOP
    Route::get(
        '/especificaciones-laptop/buscar-equipos',
        [App\Http\Controllers\EspecificacionesLaptopController::class, 'buscarEquipos']
    )->name('especificaciones-laptop.buscarEquipos');
    Route::resource('especificaciones-laptop', App\Http\Controllers\EspecificacionesLaptopController::class);

    //ACCESORIOS EQUIPO
    Route::get(
        '/accesorios-equipo/buscar-equipos',
        [App\Http\Controllers\AccesoriosEquipoController::class, 'buscarEquipos']
    )->name('accesorios-equipo.buscarEquipos');
    Route::resource('accesorios-equipo', App\Http\Controllers\AccesoriosEquipoController::class);

    //DOCENTES
    Route::resource('docentes', App\Http\Controllers\DocenteController::class);

    //PRESTAMOS
    Route::post(
        '/prestamos/registrar-docente',
        [PrestamoController::class, 'registrarDocente']
    )->name('prestamos.registrarDocente');
    Route::get(
        '/prestamos/equipos-por-tipo/{tipoId}',
        [PrestamoController::class, 'equiposPorTipo']
    )->name('prestamos.equiposPorTipo');
    Route::get(
        '/prestamos/buscar-equipos',
        [PrestamoController::class, 'buscarEquipos']
    )->name('prestamos.buscarEquipos');
    Route::post('/prestamos/export/excel', [PrestamoController::class, 'exportExcel'])
        ->name('prestamos.export.excel');
    Route::post('/prestamos/export/pdf', [PrestamoController::class, 'exportPdf'])
        ->name('prestamos.export.pdf');
    Route::get('/prestamos/{prestamo}/acta/pdf', [PrestamoController::class, 'actaPdf'])
        ->name('prestamos.acta.pdf');
    Route::get('/prestamos/{prestamo}/acta/excel', [PrestamoController::class, 'actaExcel'])
        ->name('prestamos.acta.excel');

    Route::resource('prestamos', App\Http\Controllers\PrestamoController::class);
});