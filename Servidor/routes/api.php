<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarisController;
use App\Http\Middleware\Controlatoken;
use App\Http\Middleware\ControlaAdministrador;
use App\Http\Middleware\ControlaDadesUsuari;
use App\Http\Middleware\ControlaRegistreUsuaris;
use App\Http\Middleware\ControlaDadesEspais;
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
use App\Http\Controllers\ComentarisController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//login
$router->post('login', [LoginController::class, 'login']);

//usuaris
$router->group(['prefix' => 'usuaris', 'middleware' => ControlaAdministrador::class], function () use ($router) {
    $router->get('', [UsuarisController::class, 'index']);
    $router->get('{id}', [UsuarisController::class, 'show'])->withoutMiddleware([ControlaAdministrador::class])->middleware(ControlaDadesUsuari::class);
    $router->post('', [UsuarisController::class, 'store'])->withoutMiddleware([ControlaAdministrador::class]);
    $router->put('{id}', [UsuarisController::class, 'update'])->withoutMiddleware([ControlaAdministrador::class])->middleware(ControlaDadesUsuari::class);
    $router->put('delete/{id}', [UsuarisController::class, 'delete']);
    $router->delete('{id}', [UsuarisController::class, 'destroy']);
});

//comentaris
$router->group(['prefix' => 'comentaris', 'middleware' => ControlaAdministrador::class], function () use ($router) {
    $router->get('', [ComentarisController::class, 'index']);
    $router->get('{id}', [ComentarisController::class, 'show'])->withoutMiddleware([ControlaAdministrador::class])->middleware(ControlaDadesUsuari::class);
    $router->post('', [ComentarisController::class, 'store'])->withoutMiddleware([ControlaAdministrador::class]);
    $router->put('{id}', [ComentarisController::class, 'update'])->withoutMiddleware([ControlaAdministrador::class])->middleware(ControlaDadesUsuari::class);
    $router->delete('{id}', [ComentarisController::class, 'destroy']);
});

// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar espais
$router->group(['prefix' => 'espais', 'middleware' => ControlaAdministrador::class], function () use ($router) {
    $router->get('', [EspaisController::class, 'index'])->withoutMiddleware([ControlaAdministrador::class]);
    $router->get('{id}', [EspaisController::class, 'show'])->withoutMiddleware([ControlaAdministrador::class])->middleware(ControlaDadesEspais::class);
    $router->post('', [EspaisController::class, 'store']);
    $router->put('{id}', [EspaisController::class, 'update'])->withoutMiddleware([ControlaAdministrador::class])->middleware(ControlaDadesEspais::class);
    $router->put('delete/{id}', [EspaisController::class, 'delete']);
    $router->delete('{id}', [EspaisController::class, 'destroy']);
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar islas
Route::group(['prefix' => 'illes', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [IllaController::class, 'index'])->name('illes.index');
    Route::post('', [IllaController::class, 'store'])->name('illes.store');
    Route::get('/{illa}', [IllaController::class, 'show'])->name('illes.show');
    Route::put('/{illa}', [IllaController::class, 'update'])->name('illes.update');
    Route::delete('/{illa}', [IllaController::class, 'destroy'])->name('illes.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar municipis
Route::group(['prefix' => 'municipis', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [MunicipisController::class, 'index'])->name('municipis.index');
    Route::post('', [MunicipisController::class, 'store'])->name('municipis.store');
    Route::get('/{municipi}', [MunicipisController::class, 'show'])->name('municipis.show');
    Route::put('/{municipi}', [MunicipisController::class, 'update'])->name('municipis.update');
    Route::delete('/{municipi}', [MunicipisController::class, 'destroy'])->name('municipis.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar modalitats_idiomes
Route::group(['prefix' => 'modalitats_idiomes', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [ModalitatsIdiomesController::class, 'index'])->name('modalitats_idiomes.index');
    Route::post('', [ModalitatsIdiomesController::class, 'store'])->name('modalitats_idiomes.store');
    Route::get('/{modalitat_id}', [ModalitatsIdiomesController::class, 'show'])->name('modalitats_idiomes.show');
    Route::put('/{modalitat_id}', [ModalitatsIdiomesController::class, 'update'])->name('modalitats_idiomes.update');
    Route::delete('/{modalitat_id}', [ModalitatsIdiomesController::class, 'destroy'])->name('modalitats_idiomes.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar punts_interes
Route::group(['prefix' => 'punts_interes', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [PuntsInteresController::class, 'index'])->name('punts_interes.index');
    Route::post('', [PuntsInteresController::class, 'store'])->name('punts_interes.store');
    Route::get('/{punt_interes}', [PuntsInteresController::class, 'show'])->name('punts_interes.show');
    Route::put('/{punt_interes}', [PuntsInteresController::class, 'update'])->name('punts_interes.update');
    Route::delete('/{punt_interes}', [PuntsInteresController::class, 'destroy'])->name('punts_interes.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar serveis
Route::group(['prefix' => 'serveis', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [ServeisController::class, 'index'])->name('serveis.index');
    Route::post('', [ServeisController::class, 'store'])->name('serveis.store');
    Route::get('/{servei}', [ServeisController::class, 'show'])->name('serveis.show');
    Route::put('/{servei}', [ServeisController::class, 'update'])->name('serveis.update');
    Route::delete('/{servei}', [ServeisController::class, 'destroy'])->name('serveis.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar serveis_idiomes
Route::group(['prefix' => 'serveis_idiomes', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [ServeisIdiomesController::class, 'index'])->name('serveis_idiomes.index');
    Route::post('', [ServeisIdiomesController::class, 'store'])->name('serveis_idiomes.store');
    Route::get('/{servei_id}', [ServeisIdiomesController::class, 'show'])->name('serveis_idiomes.show');
    Route::put('/{servei_id}', [ServeisIdiomesController::class, 'update'])->name('serveis_idiomes.update');
    Route::delete('/{servei_id}', [ServeisIdiomesController::class, 'destroy'])->name('serveis_idiomes.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar tipus
Route::group(['prefix' => 'tipus', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [TipusController::class, 'index'])->name('tipus.index');
    Route::post('', [TipusController::class, 'store'])->name('tipus.store');
    Route::get('/{tipus}', [TipusController::class, 'show'])->name('tipus.show');
    Route::put('/{tipus}', [TipusController::class, 'update'])->name('tipus.update');
    Route::delete('/{tipus}', [TipusController::class, 'destroy'])->name('tipus.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar valoracions
Route::group(['prefix' => 'valoracions', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [ValoracionsController::class, 'index'])->name('valoracions.index');
    Route::post('', [ValoracionsController::class, 'store'])->name('valoracions.store');
    Route::get('/{valoracio}', [ValoracionsController::class, 'show'])->name('valoracions.show');
    Route::put('/{valoracio}', [ValoracionsController::class, 'update'])->name('valoracions.update');
    Route::delete('/{valoracio}', [ValoracionsController::class, 'destroy'])->name('valoracions.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar visites
Route::group(['prefix' => 'visites', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [VisitesController::class, 'index'])->name('visites.index');
    Route::post('', [VisitesController::class, 'store'])->name('visites.store');
    Route::get('/{visita}', [VisitesController::class, 'show'])->name('visites.show');
    Route::put('/{visita}', [VisitesController::class, 'update'])->name('visites.update');
    Route::delete('/{visita}', [VisitesController::class, 'destroy'])->name('visites.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar visites_idiomes
Route::group(['prefix' => 'visites_idiomes', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [VisitesIdiomesController::class, 'index'])->name('visites_idiomes.index');
    Route::post('', [VisitesIdiomesController::class, 'store'])->name('visites_idiomes.store');
    Route::get('/{visita_idioma}', [VisitesIdiomesController::class, 'show'])->name('visites_idiomes.show');
    Route::put('/{visita_idioma}', [VisitesIdiomesController::class, 'update'])->name('visites_idiomes.update');
    Route::delete('/{visita_idioma}', [VisitesIdiomesController::class, 'destroy'])->name('visites_idiomes.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar visites_punts_interes
Route::group(['prefix' => 'visites_punts_interes', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('/{visitaId}/punts-interes', [VisitesPuntsInteresController::class, 'index']);
    Route::post('/punts-interes', [VisitesPuntsInteresController::class, 'store']);
    Route::get('/{visitaId}/punts-interes/{puntInteresId}', [VisitesPuntsInteresController::class, 'show']);
    Route::delete('/{visitaId}/punts-interes/{puntInteresId}', [VisitesPuntsInteresController::class, 'destroy']);
});

// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar arquitectes
Route::group(['prefix' => 'arquitectes', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [ArquitectesController::class, 'index'])->name('arquitectes.index');
    Route::post('', [ArquitectesController::class, 'store'])->name('arquitectes.store');
    Route::get('/{arquitecte}', [ArquitectesController::class, 'show'])->name('arquitectes.show');
    Route::put('/{arquitecte}', [ArquitectesController::class, 'update'])->name('arquitectes.update');
    Route::delete('/{arquitecte}', [ArquitectesController::class, 'destroy'])->name('arquitectes.destroy');
});


// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar audios
Route::group(['prefix' => 'audios', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [AudiosController::class, 'index'])->name('audios.index');
    Route::post('', [AudiosController::class, 'store'])->name('audios.store');
    Route::get('/{audio}', [AudiosController::class, 'show'])->name('audios.show');
    Route::put('/{audio}', [AudiosController::class, 'update'])->name('audios.update');
    Route::delete('/{audio}', [AudiosController::class, 'destroy'])->name('audios.destroy');
});


// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar espais_idiomes
Route::group(['prefix' => 'espais_idiomes', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [EspaisIdiomesController::class, 'index'])->name('espais_idiomes.index');
    Route::post('', [EspaisIdiomesController::class, 'store'])->name('espais_idiomes.store');
    Route::get('/{idioma_id}/{espai_id}', [EspaisIdiomesController::class, 'show'])->where(['idioma_id' => '[0-9]+', 'espai_id' => '[0-9]+'])->name('espais_idiomes.show');
    Route::put('/{idioma_id}/{espai_id}', [EspaisIdiomesController::class, 'update'])->where(['idioma_id' => '[0-9]+', 'espai_id' => '[0-9]+'])->name('espais_idiomes.update');
    Route::delete('/{idioma_id}/{espai_id}', [EspaisIdiomesController::class, 'destroy'])->where(['idioma_id' => '[0-9]+', 'espai_id' => '[0-9]+'])->name('espais_idiomes.destroy');
});


// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar espais_modalitats
Route::group(['prefix' => 'espais_modalitats', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [EspaisModalitatsController::class, 'index'])->name('espais_modalitats.index');
    Route::post('', [EspaisModalitatsController::class, 'store'])->name('espais_modalitats.store');
    Route::get('/{espai_id}/{modalitat_id}', [EspaisModalitatsController::class, 'show'])->where(['espai_id' => '[0-9]+', 'modalitat_id' => '[0-9]+'])->name('espais_modalitats.show');
    Route::put('/{espai_id}/{modalitat_id}', [EspaisModalitatsController::class, 'update'])->where(['espai_id' => '[0-9]+', 'modalitat_id' => '[0-9]+'])->name('espais_modalitats.update');
    Route::delete('/{espai_id}/{modalitat_id}', [EspaisModalitatsController::class, 'destroy'])->where(['espai_id' => '[0-9]+', 'modalitat_id' => '[0-9]+'])->name('espais_modalitats.destroy');
});


// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar espais_serveis
Route::group(['prefix' => 'espais_serveis', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [EspaisServeisController::class, 'index'])->name('espais_serveis.index');
    Route::post('', [EspaisServeisController::class, 'store'])->name('espais_serveis.store');
    Route::get('/{espai_id}/{servei_id}', [EspaisServeisController::class, 'show'])->where(['espai_id' => '[0-9]+', 'servei_id' => '[0-9]+'])->name('espais_serveis.show');
    Route::put('/{espai_id}/{servei_id}', [EspaisServeisController::class, 'update'])->where(['espai_id' => '[0-9]+', 'servei_id' => '[0-9]+'])->name('espais_serveis.update');
    Route::delete('/{espai_id}/{servei_id}', [EspaisServeisController::class, 'destroy'])->where(['espai_id' => '[0-9]+', 'servei_id' => '[0-9]+'])->name('espais_serveis.destroy');
});


// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar fotos
Route::group(['prefix' => 'fotos', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [FotosController::class, 'index'])->name('fotos.index');
    Route::post('', [FotosController::class, 'store'])->name('fotos.store');
    Route::get('/{foto_id}', [FotosController::class, 'show'])->where(['foto_id' => '[0-9]+'])->name('fotos.show');
    Route::put('/{foto_id}', [FotosController::class, 'update'])->where(['foto_id' => '[0-9]+'])->name('fotos.update');
    Route::delete('/{foto_id}', [FotosController::class, 'destroy'])->where(['foto_id' => '[0-9]+'])->name('fotos.destroy');
});


// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar idiomes
Route::group(['prefix' => 'idiomes', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [IdiomesController::class, 'index'])->name('idiomes.index');
    Route::post('', [IdiomesController::class, 'store'])->name('idiomes.store');
    Route::get('/{idioma_id}', [IdiomesController::class, 'show'])->where(['idioma_id' => '[0-9]+'])->name('idiomes.show');
    Route::put('/{idioma_id}', [IdiomesController::class, 'update'])->where(['idioma_id' => '[0-9]+'])->name('idiomes.update');
    Route::delete('/{idioma_id}', [IdiomesController::class, 'destroy'])->where(['idioma_id' => '[0-9]+'])->name('idiomes.destroy');
});


// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar modalitats
Route::group(['prefix' => 'modalitats', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [ModalitatsController::class, 'index'])->name('modalitats.index');
    Route::post('', [ModalitatsController::class, 'store'])->name('modalitats.store');
    Route::get('/{modalitat_id}', [ModalitatsController::class, 'show'])->where(['modalitat_id' => '[0-9]+'])->name('modalitats.show');
    Route::put('/{modalitat_id}', [ModalitatsController::class, 'update'])->where(['modalitat_id' => '[0-9]+'])->name('modalitats.update');
    Route::delete('/{modalitat_id}', [ModalitatsController::class, 'destroy'])->where(['modalitat_id' => '[0-9]+'])->name('modalitats.destroy');
});
