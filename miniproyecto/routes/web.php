<?php

use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;

// Página principal -> Mostrará la página estática
Route::get('/', function () {
    return view('static'); // Muestra "Quiénes Somos"
})->name('home');

// Rutas protegidas con autenticación
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Gestión de usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');

    // Nuevas rutas para editar usuarios (solo clientes)
    Route::get('/usuarios/{user}/edit', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('usuarios.update');

    // Productos
    Route::resource('products', ProductoController::class);

    // Categorías
    Route::resource('categories', CategoriaController::class);

    // Órdenes
    Route::resource('orders', OrdenController::class);
});

// Cargar autenticación
require __DIR__ . '/auth.php';
