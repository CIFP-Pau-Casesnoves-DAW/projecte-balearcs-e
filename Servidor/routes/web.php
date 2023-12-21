<?php

use App\Models\Usuari;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariController;
use App\Models\Illa;
use App\Models\Municipis;
use App\Http\Controllers\IllaController;
use App\Http\Controllers\MunicipisController;
use App\Http\Controllers\ModalitatsIdiomesController;
use App\Http\Controllers\PuntsInteresController;
use App\Http\Controllers\ServeisController;
use App\Http\Controllers\ServeisIdiomesController;
use App\Http\Controllers\TipusController;
use App\Http\Controllers\ValoracionsController;
use App\Http\Controllers\VisitesController;
use App\Http\Controllers\VisitesIdiomesController;
use App\Http\Controllers\VisitesPuntsInteresController;
use App\Http\Controllers\ArquitectesController;


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

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar modalitats_idiomes
Route::group(['prefix' =>'modalitats_idiomes'], function () {
    Route::get('', [ModalitatsIdiomesController::class, 'index'])->name('modalitats_idiomes.index');
    Route::get('/create', [ModalitatsIdiomesController::class, 'create'])->name('modalitats_idiomes.create');
    Route::post('', [ModalitatsIdiomesController::class,'store'])->name('modalitats_idiomes.store');
    Route::get('/{modalitat_id}', [ModalitatsIdiomesController::class,'show'])->name('modalitats_idiomes.show');
    Route::get('/{modalitat_id}/edit', [ModalitatsIdiomesController::class, 'edit'])->name('modalitats_idiomes.edit');
    Route::put('/{modalitat_id}', [ModalitatsIdiomesController::class, 'update'])->name('modalitats_idiomes.update');
    Route::delete('/{modalitat_id}', [ModalitatsIdiomesController::class, 'destroy'])->name('modalitats_idiomes.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar punts_interes
Route::group(['prefix' => 'punts_interes'], function () {
    Route::get('', [PuntsInteresController::class, 'index'])->name('punts_interes.index');
    Route::get('/create', [PuntsInteresController::class, 'create'])->name('punts_interes.create');
    Route::post('', [PuntsInteresController::class,'store'])->name('punts_interes.store');
    Route::get('/{punt_interes}', [PuntsInteresController::class,'show'])->name('punts_interes.show');
    Route::get('/{punt_interes}/edit', [PuntsInteresController::class, 'edit'])->name('punts_interes.edit');
    Route::put('/{punt_interes}', [PuntsInteresController::class, 'update'])->name('punts_interes.update');
    Route::delete('/{punt_interes}', [PuntsInteresController::class, 'destroy'])->name('punts_interes.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar serveis
Route::group(['prefix' =>'serveis'], function () {
    Route::get('', [ServeisController::class, 'index'])->name('serveis.index');
    Route::get('/create', [ServeisController::class, 'create'])->name('serveis.create');
    Route::post('', [ServeisController::class,'store'])->name('serveis.store');
    Route::get('/{servei}', [ServeisController::class,'show'])->name('serveis.show');
    Route::get('/{servei}/edit', [ServeisController::class, 'edit'])->name('serveis.edit');
    Route::put('/{servei}', [ServeisController::class, 'update'])->name('serveis.update');
    Route::delete('/{servei}', [ServeisController::class, 'destroy'])->name('serveis.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar serveis_idiomes
Route::group(['prefix' =>'serveis_idiomes'], function () {
    Route::get('', [ServeisIdiomesController::class, 'index'])->name('serveis_idiomes.index');
    Route::get('/create', [ServeisIdiomesController::class, 'create'])->name('serveis_idiomes.create');
    Route::post('', [ServeisIdiomesController::class,'store'])->name('serveis_idiomes.store');
    Route::get('/{servei_id}', [ServeisIdiomesController::class,'show'])->name('serveis_idiomes.show');
    Route::get('/{servei_id}/edit', [ServeisIdiomesController::class, 'edit'])->name('serveis_idiomes.edit');
    Route::put('/{servei_id}', [ServeisIdiomesController::class, 'update'])->name('serveis_idiomes.update');
    Route::delete('/{servei_id}', [ServeisIdiomesController::class, 'destroy'])->name('serveis_idiomes.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar tipus
Route::group(['prefix' => 'tipus'], function () {
    Route::get('', [TipusController::class, 'index'])->name('tipus.index');
    Route::get('/create', [TipusController::class, 'create'])->name('tipus.create');
    Route::post('', [TipusController::class,'store'])->name('tipus.store');
    Route::get('/{tipus}', [TipusController::class,'show'])->name('tipus.show');
    Route::get('/{tipus}/edit', [TipusController::class, 'edit'])->name('tipus.edit');
    Route::put('/{tipus}', [TipusController::class, 'update'])->name('tipus.update');
    Route::delete('/{tipus}', [TipusController::class, 'destroy'])->name('tipus.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar valoracions
Route::group(['prefix' => 'valoracions'], function () {
    Route::get('', [ValoracionsController::class, 'index'])->name('valoracions.index');
    Route::get('/create', [ValoracionsController::class, 'create'])->name('valoracions.create');
    Route::post('', [ValoracionsController::class,'store'])->name('valoracions.store');
    Route::get('/{valoracio}', [ValoracionsController::class,'show'])->name('valoracions.show');
    Route::get('/{valoracio}/edit', [ValoracionsController::class, 'edit'])->name('valoracions.edit');
    Route::put('/{valoracio}', [ValoracionsController::class, 'update'])->name('valoracions.update');
    Route::delete('/{valoracio}', [ValoracionsController::class, 'destroy'])->name('valoracions.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar visites
Route::group(['prefix' => 'visites'], function () {
    Route::get('', [VisitesController::class, 'index'])->name('visites.index');
    Route::get('/create', [VisitesController::class, 'create'])->name('visites.create');
    Route::post('', [VisitesController::class,'store'])->name('visites.store');
    Route::get('/{visita}', [VisitesController::class,'show'])->name('visites.show');
    Route::get('/{visita}/edit', [VisitesController::class, 'edit'])->name('visites.edit');
    Route::put('/{visita}', [VisitesController::class, 'update'])->name('visites.update');
    Route::delete('/{visita}', [VisitesController::class, 'destroy'])->name('visites.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar visites_idiomes
Route::group(['prefix' => 'visites_idiomes'], function () {
    Route::get('', [VisitesIdiomesController::class, 'index'])->name('visites_idiomes.index');
    Route::get('/create', [VisitesIdiomesController::class, 'create'])->name('visites_idiomes.create');
    Route::post('', [VisitesIdiomesController::class,'store'])->name('visites_idiomes.store');
    Route::get('/{visita_idioma}', [VisitesIdiomesController::class,'show'])->name('visites_idiomes.show');
    Route::get('/{visita_idioma}/edit', [VisitesIdiomesController::class, 'edit'])->name('visites_idiomes.edit');
    Route::put('/{visita_idioma}', [VisitesIdiomesController::class, 'update'])->name('visites_idiomes.update');
    Route::delete('/{visita_idioma}', [VisitesIdiomesController::class, 'destroy'])->name('visites_idiomes.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar visites_punts_interes
Route::prefix('api')->group(function () {
    Route::get('/visites/{visitaId}/punts-interes', [VisitesPuntsInteresController::class, 'index']);
    Route::post('/visites/punts-interes', [VisitesPuntsInteresController::class, 'store']);
    Route::get('/visites/{visitaId}/punts-interes/{puntInteresId}', [VisitesPuntsInteresController::class, 'show']);
    Route::delete('/visites/{visitaId}/punts-interes/{puntInteresId}', [VisitesPuntsInteresController::class, 'destroy']);
});