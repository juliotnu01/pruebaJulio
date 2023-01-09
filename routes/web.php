<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/productos', function () {
    return Inertia::render('productos');
})->middleware(['auth', 'verified'])->name('productos');

Route::get('/facturas', function () {
    return Inertia::render('facturas');
})->middleware(['auth', 'verified'])->name('facturas');

Route::get('/view-producto/{producto?}', [ProductoController::class, 'show'] )->middleware(['auth', 'verified'])->name('view.productos');


require __DIR__.'/auth.php';
