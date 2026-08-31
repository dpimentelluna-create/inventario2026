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

Auth::routes();

//HOME:
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//UBICACIONES
Route::resource('ubicaciones', App\Http\Controllers\UbicacioneController::class);

//TIPOS DE EQUIPO
Route::resource('tipos-equipo', App\Http\Controllers\TiposEquipoController::class);

//EQUIPOS
Route::post('/equipos/{equipo}/accesorios', [EquipoController::class, 'guardarAccesorios'])
    ->name('equipos.accesorios.store');
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
Route::get(
    '/prestamos/equipos-por-tipo/{tipoId}',
    [PrestamoController::class, 'equiposPorTipo']
)->name('prestamos.equiposPorTipo');
Route::get(
    '/prestamos/buscar-equipos',
    [PrestamoController::class, 'buscarEquipos']
)->name('prestamos.buscarEquipos');
Route::resource('prestamos', App\Http\Controllers\PrestamoController::class);
