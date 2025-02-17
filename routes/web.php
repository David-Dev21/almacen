<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportePDFController;
use App\Http\Controllers\ReporteController;

Route::get('/', function () {
    return redirect('/login'); // Redirige directamente al formulario de login
});

Route::resource('almacen/categorias', CategoriaController::class)->middleware('auth');
Route::resource('almacen/productos', ProductoController::class)->middleware('auth');
Route::resource('almacen/proveedores', ProveedorController::class)->middleware('auth');
Route::resource('almacen/unidades', UnidadController::class)->middleware('auth');
Route::resource('almacen/ingresos', IngresoController::class)->middleware('auth');
Route::resource('almacen/salidas', SalidaController::class)->middleware('auth');
Route::resource('almacen/usuarios', UsuarioController::class)->middleware('auth');

Auth::routes(['register' => false], ['verify' => false], ['reset' => false]);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/reporte-salida/{id}', [ReporteController::class, 'generarPDF'])->name('reporte-salida')->middleware('auth');
