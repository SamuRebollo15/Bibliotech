<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\IdiomaController;
use App\Http\Middleware\EsAdmin;


// Página principal: lista de libros (acceso público)
Route::get('/', [LibroController::class, 'index'])->name('libros.index');
// Cambio de idioma (público, sin login)
Route::post('/cambiar-idioma', [IdiomaController::class, 'cambiar'])->name('cambiar.idioma');

// Ruta que espera Laravel Breeze tras el login (redirige al catálogo)
Route::get('/dashboard', function () {
    return redirect()->route('libros.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Ruta para crear un nuevo libro (hay que definirla antes que la de {libro})
Route::get('/libros/create', [LibroController::class, 'create'])->name('libros.create');

// Mostrar detalles de libro (acceso público)
Route::get('/libros/{libro}', [LibroController::class, 'show'])->name('libros.show');

// Formulario y procesamiento del alquiler de libros (usuarios autenticados)
Route::middleware(['auth'])->group(function () {
    Route::get('/libros/{libro}/alquilar', [PrestamoController::class, 'formulario'])->name('prestamos.formulario');
    Route::post('/libros/{libro}/alquilar', [PrestamoController::class, 'realizar'])->name('prestamos.realizar');
});

// Rutas protegidas: autenticación obligatoria
Route::middleware(['auth'])->group(function () {
    Route::resource('prestamos', PrestamoController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Vista general de cuenta (tarjetas de opciones)
    Route::get('/cuenta', [CuentaController::class, 'index'])->middleware(['auth'])->name('cuenta.index');

   Route::patch('/prestamos/{prestamo}/prorrogar', [PrestamoController::class, 'prorrogar'])->name('prestamos.prorrogar');


    // Vista específica de préstamos activos
    Route::get('/cuenta/prestamos', [CuentaController::class, 'prestamos'])->middleware(['auth'])->name('cuenta.prestamos');
});

// Rutas solo para administradores
Route::middleware(['auth', EsAdmin::class])->group(function () {
    // Las rutas de libros, excepto index, show y create (ya están definidas arriba)
    Route::resource('libros', LibroController::class)->except(['index', 'show', 'create']);

    // Gestión de categorías
    Route::resource('categorias', CategoriaController::class)->except(['index', 'show']);

    // Gestión de usuarios (solo desde admin)
    Route::resource('usuarios', UsuarioController::class)->except(['show']);

    Route::get('/admin/prestamos', [PrestamoController::class, 'gestion'])->name('admin.prestamos.gestion');
    Route::patch('/admin/prestamos/{prestamo}', [PrestamoController::class, 'actualizarEstado'])->name('admin.prestamos.actualizar');
    // En rutas de administradores:
    Route::patch('/admin/usuarios/{user}/bloquear', [UsuarioController::class, 'bloquear'])->name('admin.usuarios.bloquear');
    Route::patch('/admin/usuarios/{user}/desbloquear', [UsuarioController::class, 'desbloquear'])->name('admin.usuarios.desbloquear');
});

// Rutas Breeze (login, register, etc.)
require __DIR__ . '/auth.php';
