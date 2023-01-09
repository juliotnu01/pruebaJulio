<?php

use App\Http\Controllers\CompraController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/get-producto', [ProductoController::class, 'index'])->name('producto');
Route::get('/get-compras', [CompraController::class, 'index'])->name('compras');
Route::put('/update-producto/{producto?}', [ProductoController::class, 'update'])->name('update.producto');
Route::delete('/delete-producto/{producto?}', [ProductoController::class, 'delete'])->name('update.producto');
Route::post('/add-compra', [CompraController::class, 'store'])->name('add.compra');
