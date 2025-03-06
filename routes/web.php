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

Route::get('/almacen/productos/generar-codigo/{id_categoria}', [ProductoController::class, 'generarCodigo'])->name('productos.generar-codigo');

Auth::routes(['register' => false], ['verify' => false], ['reset' => false]);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/reporte-salida/{id}', [ReporteController::class, 'generarSalidaPDF'])->name('reporte-salida')->middleware('auth');
Route::get('/movimientos', [ReporteController::class, 'movimientoAlmacen'])->name('movimientos')->middleware('auth');
Route::get('/movimientos/imprimir', [ReporteController::class, 'imprimirMovimientoPDF'])->name('movimientos.imprimir')->middleware('auth');

Route::get('/saldo-almacen', [ReporteController::class, 'saldoAlmacen'])->name('saldo')->middleware('auth');
Route::get('/saldo-almacen/imprimir', [ReporteController::class, 'imprimirSaldoPDF'])->name('saldo.imprimir')->middleware('auth');
