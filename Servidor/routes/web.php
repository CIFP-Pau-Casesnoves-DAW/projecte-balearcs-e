<?php

use App\Models\Usuari;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariController;

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

Route::group(['prefix' => 'usuaris'], function () {
    Route::get('', [UsuariController::class, 'index'])->name('usuari.index');
    Route::get('/{id}', [UsuariController::class, 'show'])->name('usuari.show');
    Route::put('/{id}', [UsuariController::class, 'update'])->name('usuari.update');
});
