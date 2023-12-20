<?php

use App\Models\Usuari;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariController;
use App\Models\Illa;
use App\Models\Municipis;
<<<<<<< Updated upstream
=======
use App\Http\Controllers\IllaController;
use App\Http\Controllers\MunicipisController;
>>>>>>> Stashed changes

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
<<<<<<< Updated upstream

=======
//Rutes usuaris
>>>>>>> Stashed changes
Route::group(['prefix' => 'usuaris'], function () {
    Route::get('', [UsuariController::class, 'index'])->name('usuari.index');
    Route::get('/{id}', [UsuariController::class, 'show'])->name('usuari.show');
    Route::put('/{id}', [UsuariController::class, 'update'])->name('usuari.update');
});
<<<<<<< Updated upstream
=======

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar islas
Route::group(['prefix' => 'illes'], function () {
    Route::get('', [IllaController::class, 'index'])->name('illes.index');
    Route::get('/create', [IllaController::class, 'create'])->name('illes.create');
    Route::post('', [IllaController::class, 'store'])->name('illes.store');
    Route::get('/{illa}', [IllaController::class, 'show'])->name('illes.show');
    Route::get('/{illa}/edit', [IllaController::class, 'edit'])->name('illes.edit');
    Route::put('/{illa}', [IllaController::class, 'update'])->name('illes.update');
    Route::delete('/{illa}', [IllaController::class, 'destroy'])->name('illes.destroy');
});
>>>>>>> Stashed changes

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar municipis
Route::group(['prefix' =>'municipis'], function () {
    Route::get('', [MunicipisController::class, 'index'])->name('municipis.index');
    Route::get('/create', [MunicipisController::class, 'create'])->name('municipis.create');
    Route::post('', [MunicipisController::class,'store'])->name('municipis.store');
    Route::get('/{municipi}', [MunicipisController::class,'show'])->name('municipis.show');
    Route::get('/{municipi}/edit', [MunicipisController::class, 'edit'])->name('municipis.edit');
    Route::put('/{municipi}', [MunicipisController::class, 'update'])->name('municipis.update');
    Route::delete('/{municipi}', [MunicipisController::class, 'destroy'])->name('municipis.destroy');
});