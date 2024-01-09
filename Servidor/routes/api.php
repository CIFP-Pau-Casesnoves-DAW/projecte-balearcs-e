<?php

use Illuminate\Http\Request;

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
use App\Http\Controllers\AudiosController;
use App\Http\Controllers\EspaisController;
use App\Http\Controllers\EspaisIdiomesController;
use App\Http\Controllers\EspaisModalitatsController;
use App\Http\Controllers\EspaisServeisController;
use App\Http\Controllers\FotosController;
use App\Http\Controllers\IdiomesController;
use App\Http\Controllers\ModalitatsController;

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
/*
Route::prefix('api')->group(function () {
     Route::get('/visites/{visitaId}/punts-interes', [VisitesPuntsInteresController::class, 'index']);
     Route::post('/visites/punts-interes', [VisitesPuntsInteresController::class, 'store']);
     Route::get('/visites/{visitaId}/punts-interes/{puntInteresId}', [VisitesPuntsInteresController::class, 'show']);
     Route::delete('/visites/{visitaId}/punts-interes/{puntInteresId}', [VisitesPuntsInteresController::class, 'destroy']);
});
*/
Route::group(['prefix' => 'visites'], function () {
    Route::get('/{visitaId}/punts-interes', [VisitesPuntsInteresController::class, 'index']);
    Route::post('/punts-interes', [VisitesPuntsInteresController::class, 'store']);
    Route::get('/{visitaId}/punts-interes/{puntInteresId}', [VisitesPuntsInteresController::class, 'show']);
    Route::delete('/{visitaId}/punts-interes/{puntInteresId}', [VisitesPuntsInteresController::class, 'destroy']);
});

// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar arquitectes
Route::group(['prefix' => 'arquitectes'], function () {
    Route::get('', [ArquitectesController::class, 'index'])->name('arquitectes.index');
    Route::get('/create', [ArquitectesController::class, 'create'])->name('arquitectes.create');
    Route::post('', [ArquitectesController::class, 'store'])->name('arquitectes.store');
    Route::get('/{arquitecte}', [ArquitectesController::class, 'show'])->name('arquitectes.show');
    Route::get('/{arquitecte}/edit', [ArquitectesController::class, 'edit'])->name('arquitectes.edit');
    Route::put('/{arquitecte}', [ArquitectesController::class, 'update'])->name('arquitectes.update');
    Route::delete('/{arquitecte}', [ArquitectesController::class, 'destroy'])->name('arquitectes.destroy');
});


// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar audios
Route::group(['prefix' => 'audios'], function () {
    Route::get('', [AudiosController::class, 'index'])->name('audios.index');
    Route::get('/create', [AudiosController::class, 'create'])->name('audios.create');
    Route::post('', [AudiosController::class, 'store'])->name('audios.store');
    Route::get('/{audio}', [AudiosController::class, 'show'])->name('audios.show');
    Route::get('/{audio}/edit', [AudiosController::class, 'edit'])->name('audios.edit');
    Route::put('/{audio}', [AudiosController::class, 'update'])->name('audios.update');
    Route::delete('/{audio}', [AudiosController::class, 'destroy'])->name('audios.destroy');
});


// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar espais
Route::group(['prefix' => 'espais'], function () {
    Route::get('', [EspaisController::class, 'index'])->name('espais.index');
    Route::get('/create', [EspaisController::class, 'create'])->name('espais.create');
    Route::post('', [EspaisController::class, 'store'])->name('espais.store');
    Route::get('/{espai}', [EspaisController::class, 'show'])->name('espais.show');
    Route::get('/{espai}/edit', [EspaisController::class, 'edit'])->name('espais.edit');
    Route::put('/{espai}', [EspaisController::class, 'update'])->name('espais.update');
    Route::delete('/{espai}', [EspaisController::class, 'destroy'])->name('espais.destroy');
});


// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar espais_idiomes
Route::group(['prefix' => 'espais_idiomes'], function () {
    Route::get('', [EspaisIdiomesController::class, 'index'])->name('espais_idiomes.index');
    Route::get('/create', [EspaisIdiomesController::class, 'create'])->name('espais_idiomes.create');
    Route::post('', [EspaisIdiomesController::class, 'store'])->name('espais_idiomes.store');
    Route::get('/{idioma_id}/{espai_id}', [EspaisIdiomesController::class, 'show'])->where(['idioma_id' => '[0-9]+', 'espai_id' => '[0-9]+'])->name('espais_idiomes.show');
    Route::get('/{idioma_id}/{espai_id}/edit', [EspaisIdiomesController::class, 'edit'])->where(['idioma_id' => '[0-9]+', 'espai_id' => '[0-9]+'])->name('espais_idiomes.edit');
    Route::put('/{idioma_id}/{espai_id}', [EspaisIdiomesController::class, 'update'])->where(['idioma_id' => '[0-9]+', 'espai_id' => '[0-9]+'])->name('espais_idiomes.update');
    Route::delete('/{idioma_id}/{espai_id}', [EspaisIdiomesController::class, 'destroy'])->where(['idioma_id' => '[0-9]+', 'espai_id' => '[0-9]+'])->name('espais_idiomes.destroy');
});


// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar espais_modalitats
Route::group(['prefix' => 'espais_modalitats'], function () {
    Route::get('', [EspaisModalitatsController::class, 'index'])->name('espais_modalitats.index');
    Route::get('/create', [EspaisModalitatsController::class, 'create'])->name('espais_modalitats.create');
    Route::post('', [EspaisModalitatsController::class, 'store'])->name('espais_modalitats.store');
    Route::get('/{espai_id}/{modalitat_id}', [EspaisModalitatsController::class, 'show'])->where(['espai_id' => '[0-9]+', 'modalitat_id' => '[0-9]+'])->name('espais_modalitats.show');
    Route::get('/{espai_id}/{modalitat_id}/edit', [EspaisModalitatsController::class, 'edit'])->where(['espai_id' => '[0-9]+', 'modalitat_id' => '[0-9]+'])->name('espais_modalitats.edit');
    Route::put('/{espai_id}/{modalitat_id}', [EspaisModalitatsController::class, 'update'])->where(['espai_id' => '[0-9]+', 'modalitat_id' => '[0-9]+'])->name('espais_modalitats.update');
    Route::delete('/{espai_id}/{modalitat_id}', [EspaisModalitatsController::class, 'destroy'])->where(['espai_id' => '[0-9]+', 'modalitat_id' => '[0-9]+'])->name('espais_modalitats.destroy');
});


// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar espais_serveis
Route::group(['prefix' => 'espais_serveis'], function () {
    Route::get('', [EspaisServeisController::class, 'index'])->name('espais_serveis.index');
    Route::get('/create', [EspaisServeisController::class, 'create'])->name('espais_serveis.create');
    Route::post('', [EspaisServeisController::class, 'store'])->name('espais_serveis.store');
    Route::get('/{espai_id}/{servei_id}', [EspaisServeisController::class, 'show'])->where(['espai_id' => '[0-9]+', 'servei_id' => '[0-9]+'])->name('espais_serveis.show');
    Route::get('/{espai_id}/{servei_id}/edit', [EspaisServeisController::class, 'edit'])->where(['espai_id' => '[0-9]+', 'servei_id' => '[0-9]+'])->name('espais_serveis.edit');
    Route::put('/{espai_id}/{servei_id}', [EspaisServeisController::class, 'update'])->where(['espai_id' => '[0-9]+', 'servei_id' => '[0-9]+'])->name('espais_serveis.update');
    Route::delete('/{espai_id}/{servei_id}', [EspaisServeisController::class, 'destroy'])->where(['espai_id' => '[0-9]+', 'servei_id' => '[0-9]+'])->name('espais_serveis.destroy');
});


// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar fotos
Route::group(['prefix' => 'fotos'], function () {
    Route::get('', [FotosController::class, 'index'])->name('fotos.index');
    Route::get('/create', [FotosController::class, 'create'])->name('fotos.create');
    Route::post('', [FotosController::class, 'store'])->name('fotos.store');
    Route::get('/{foto_id}', [FotosController::class, 'show'])->where(['foto_id' => '[0-9]+'])->name('fotos.show');
    Route::get('/{foto_id}/edit', [FotosController::class, 'edit'])->where(['foto_id' => '[0-9]+'])->name('fotos.edit');
    Route::put('/{foto_id}', [FotosController::class, 'update'])->where(['foto_id' => '[0-9]+'])->name('fotos.update');
    Route::delete('/{foto_id}', [FotosController::class, 'destroy'])->where(['foto_id' => '[0-9]+'])->name('fotos.destroy');
});


// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar idiomes
Route::group(['prefix' => 'idiomes'], function () {
    Route::get('', [IdiomesController::class, 'index'])->name('idiomes.index');
    Route::get('/create', [IdiomesController::class, 'create'])->name('idiomes.create');
    Route::post('', [IdiomesController::class, 'store'])->name('idiomes.store');
    Route::get('/{idioma_id}', [IdiomesController::class, 'show'])->where(['idioma_id' => '[0-9]+'])->name('idiomes.show');
    Route::get('/{idioma_id}/edit', [IdiomesController::class, 'edit'])->where(['idioma_id' => '[0-9]+'])->name('idiomes.edit');
    Route::put('/{idioma_id}', [IdiomesController::class, 'update'])->where(['idioma_id' => '[0-9]+'])->name('idiomes.update');
    Route::delete('/{idioma_id}', [IdiomesController::class, 'destroy'])->where(['idioma_id' => '[0-9]+'])->name('idiomes.destroy');
});


// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar modalitats
Route::group(['prefix' => 'modalitats'], function () {
    Route::get('', [ModalitatsController::class, 'index'])->name('modalitats.index');
    Route::get('/create', [ModalitatsController::class, 'create'])->name('modalitats.create');
    Route::post('', [ModalitatsController::class, 'store'])->name('modalitats.store');
    Route::get('/{modalitat_id}', [ModalitatsController::class, 'show'])->where(['modalitat_id' => '[0-9]+'])->name('modalitats.show');
    Route::get('/{modalitat_id}/edit', [ModalitatsController::class, 'edit'])->where(['modalitat_id' => '[0-9]+'])->name('modalitats.edit');
    Route::put('/{modalitat_id}', [ModalitatsController::class, 'update'])->where(['modalitat_id' => '[0-9]+'])->name('modalitats.update');
    Route::delete('/{modalitat_id}', [ModalitatsController::class, 'destroy'])->where(['modalitat_id' => '[0-9]+'])->name('modalitats.destroy');
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
