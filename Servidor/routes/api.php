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
use App\Http\Middleware\ControlaDadesComentaris;
use App\Models\Usuari;
use App\Models\Illa;
use App\Models\Municipis;
use App\Http\Controllers\IllesController;
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
use App\Http\Middleware\ControlaDadesAudios;
use App\Http\Middleware\ControlaDadesFotos;
use App\Http\Middleware\ControlaDadesPuntsInteres;
use App\Http\Middleware\ControlaDadesValoracions;
use App\Http\Middleware\ControlaDadesVisites;

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
    $router->put('delete/{id}', [UsuarisController::class, 'delete'])->withoutMiddleware([ControlaAdministrador::class])->middleware(ControlaDadesUsuari::class);
    $router->delete('{id}', [UsuarisController::class, 'destroy']);
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

//comentaris
$router->group(['prefix' => 'comentaris'], function () use ($router) {
    $router->get('', [ComentarisController::class, 'index']);
    $router->get('{id}', [ComentarisController::class, 'show']);
    $router->post('', [ComentarisController::class, 'store'])->middleware(ControlaToken::class);
    $router->put('{id}', [ComentarisController::class, 'update'])->middleware(ControlaDadesComentaris::class);
    $router->delete('{id}', [ComentarisController::class, 'destroy'])->middleware(ControlaAdministrador::class);
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar valoracions
$router->group(['prefix' => 'valoracions'], function () use ($router) {
    $router->get('', [ValoracionsController::class, 'index']);
    $router->get('{id}', [ValoracionsController::class, 'show']);
    $router->post('', [ValoracionsController::class, 'store'])->middleware(ControlaToken::class);
    $router->put('{id}', [ValoracionsController::class, 'update'])->middleware(ControlaDadesValoracions::class);
    $router->delete('{id}', [ValoracionsController::class, 'destroy'])->middleware(ControlaAdministrador::class);
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar islas
$router->group(['prefix' => 'illes', 'middleware' => ControlaAdministrador::class], function () use ($router) {
    $router->get('', [IllesController::class, 'index']);
    $router->get('{id}', [IllesController::class, 'show']);
    $router->post('', [IllesController::class, 'store']);
    $router->put('{id}', [IllesController::class, 'update']);
    $router->delete('{id}', [IllesController::class, 'destroy']);
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar municipis
$router->group(['prefix' => 'municipis', 'middleware' => ControlaAdministrador::class], function () use ($router) {
    $router->get('', [MunicipisController::class, 'index']);
    $router->get('{id}', [MunicipisController::class, 'show']);
    $router->post('', [MunicipisController::class, 'store']);
    $router->put('{id}', [MunicipisController::class, 'update']);
    $router->delete('{id}', [MunicipisController::class, 'destroy']);
});

// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar modalitats
$router->group(['prefix' => 'modalitats', 'middleware' => ControlaAdministrador::class], function () use ($router) {
    $router->get('', [ModalitatsController::class, 'index']);
    $router->get('{id}', [ModalitatsController::class, 'show']);
    $router->post('', [ModalitatsController::class, 'store']);
    $router->put('{id}', [ModalitatsController::class, 'update']);
    $router->delete('{id}', [ModalitatsController::class, 'destroy']);
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar punts_interes
$router->group(['prefix' => 'punts_interes'], function () use ($router) {
    $router->get('', [PuntsInteresController::class, 'index']);
    $router->get('{id}', [PuntsInteresController::class, 'show']);
    $router->post('', [PuntsInteresController::class, 'store'])->middleware(ControlaAdministrador::class);
    $router->put('{id}', [PuntsInteresController::class, 'update'])->middleware(ControlaDadesPuntsInteres::class);
    $router->put('delete/{id}', [EspaisController::class, 'delete'])->middleware(ControlaAdministrador::class);
    $router->delete('{id}', [PuntsInteresController::class, 'destroy'])->middleware(ControlaAdministrador::class);
});

// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar audios
$router->group(['prefix' => 'audios'], function () use ($router) {
    $router->get('', [AudiosController::class, 'index']);
    $router->get('{id}', [AudiosController::class, 'show']);
    $router->post('', [AudiosController::class, 'store'])->middleware(ControlaAdministrador::class);
    $router->put('{id}', [AudiosController::class, 'update'])->middleware(ControlaDadesAudios::class);
    $router->delete('{id}', [AudiosController::class, 'destroy'])->middleware(ControlaAdministrador::class);
    $router->put('delete/{id}', [AudiosController::class, 'delete'])->middleware(ControlaAdministrador::class);
});

// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar fotos
$router->group(['prefix' => 'fotos'], function () use ($router) {
    $router->get('', [FotosController::class, 'index']);
    $router->get('{id}', [FotosController::class, 'show']);
    $router->post('', [FotosController::class, 'store'])->middleware(ControlaAdministrador::class);
    $router->put('{id}', [FotosController::class, 'update'])->middleware(ControlaDadesFotos::class);
    $router->delete('{id}', [FotosController::class, 'destroy'])->middleware(ControlaAdministrador::class);
    $router->put('delete/{id}', [FotosController::class, 'delete'])->middleware(ControlaAdministrador::class);
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar visites
$router->group(['prefix' => 'visites', 'middleware' => ControlaAdministrador::class], function () use ($router) {
    $router->get('', [VisitesController::class, 'index']);
    $router->get('{id}', [VisitesController::class, 'show']);
    $router->post('', [VisitesController::class, 'store'])->middleware(ControlaAdministrador::class);
    $router->put('{id}', [VisitesController::class, 'update'])->middleware(ControlaDadesVisites::class);
    $router->put('delete/{id}', [VisitesController::class, 'delete'])->middleware(ControlaAdministrador::class);
    $router->delete('{id}', [VisitesController::class, 'destroy'])->middleware(ControlaAdministrador::class);
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar serveis
$router->group(['prefix' => 'serveis', 'middleware' => ControlaAdministrador::class], function () use ($router) {
    $router->get('', [ServeisController::class, 'index']);
    $router->get('{id}', [ServeisController::class, 'show']);
    $router->post('', [ServeisController::class, 'store']);
    $router->put('{id}', [ServeisController::class, 'update']);
    $router->delete('{id}', [ServeisController::class, 'destroy']);
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar tipus
$router->group(['prefix' => 'tipus', 'middleware' => ControlaAdministrador::class], function () use ($router) {
    $router->get('', [TipusController::class, 'index']);
    $router->get('{id}', [TipusController::class, 'show']);
    $router->post('', [TipusController::class, 'store']);
    $router->put('{id}', [TipusController::class, 'update']);
    $router->delete('{id}', [TipusController::class, 'destroy']);
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar visites_punts_interes
$router->group(['prefix' => 'visites_punts_interes', 'middleware' => ControlaAdministrador::class], function () use ($router) {
    $router->get('', [VisitesPuntsInteresController::class, 'index']);
    $router->post('', [VisitesPuntsInteresController::class, 'store']);
    $router->get('/{visita_id}/{punts_interes_id}', [VisitesPuntsInteresController::class, 'show'])->where(['visita_id' => '[0-9]+', 'punts_interes_id' => '[0-9]+']);
    $router->put('/{visita_id}/{punts_interes_id}', [VisitesPuntsInteresController::class, 'update'])->where(['visita_id' => '[0-9]+', 'punts_interes_id' => '[0-9]+']);
    $router->delete('/{visita_id}/{punts_interes_id}', [VisitesPuntsInteresController::class, 'destroy'])->where(['visita_id' => '[0-9]+', 'punts_interes_id' => '[0-9]+']);
});

// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar arquitectes
$router->group(['prefix' => 'arquitectes', 'middleware' => ControlaAdministrador::class], function () use ($router) {
    $router->get('', [ArquitectesController::class, 'index']);
    $router->get('{id}', [ArquitectesController::class, 'show']);
    $router->post('', [ArquitectesController::class, 'store']);
    $router->put('{id}', [ArquitectesController::class, 'update']);
    $router->delete('{id}', [ArquitectesController::class, 'destroy']);
});

// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar idiomes
$router->group(['prefix' => 'idiomes', 'middleware' => ControlaAdministrador::class], function () use ($router) {
    $router->get('', [IdiomesController::class, 'index']);
    $router->get('{id}', [IdiomesController::class, 'show']);
    $router->post('', [IdiomesController::class, 'store']);
    $router->put('{id}', [IdiomesController::class, 'update']);
    $router->delete('{id}', [IdiomesController::class, 'destroy']);
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar modalitats_idiomes
$router->group(['prefix' => 'modalitats_idiomes', 'middleware' => ControlaAdministrador::class], function () use ($router) {
    $router->get('', [ModalitatsIdiomesController::class, 'index']);
    $router->post('', [ModalitatsIdiomesController::class, 'store']);
    $router->get('/{idioma_id}/{modalitat_id}', [ModalitatsIdiomesController::class, 'show'])->where(['idioma_id' => '[0-9]+', 'modalitat_id' => '[0-9]+']);
    $router->put('/{idioma_id}/{modalitat_id}', [ModalitatsIdiomesController::class, 'update'])->where(['idioma_id' => '[0-9]+', 'modalitat_id' => '[0-9]+']);
    $router->delete('/{idioma_id}/{modalitat_id}', [ModalitatsIdiomesController::class, 'destroy'])->where(['idioma_id' => '[0-9]+', 'modalitat_id' => '[0-9]+']);
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

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar serveis_idiomes
Route::group(['prefix' => 'serveis_idiomes', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [ServeisIdiomesController::class, 'index'])->name('serveis_idiomes.index');
    Route::post('', [ServeisIdiomesController::class, 'store'])->name('serveis_idiomes.store');
    Route::get('/{servei_id}', [ServeisIdiomesController::class, 'show'])->name('serveis_idiomes.show');
    Route::put('/{servei_id}', [ServeisIdiomesController::class, 'update'])->name('serveis_idiomes.update');
    Route::delete('/{servei_id}', [ServeisIdiomesController::class, 'destroy'])->name('serveis_idiomes.destroy');
});

// Rutas para listar, crear, almacenar, mostrar, editar, actualizar y eliminar visites_idiomes
Route::group(['prefix' => 'visites_idiomes', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [VisitesIdiomesController::class, 'index'])->name('visites_idiomes.index');
    Route::post('', [VisitesIdiomesController::class, 'store'])->name('visites_idiomes.store');
    Route::get('/{visita_idioma}', [VisitesIdiomesController::class, 'show'])->name('visites_idiomes.show');
    Route::put('/{visita_idioma}', [VisitesIdiomesController::class, 'update'])->name('visites_idiomes.update');
    Route::delete('/{visita_idioma}', [VisitesIdiomesController::class, 'destroy'])->name('visites_idiomes.destroy');
});

// Rutes per a llistar, crear, emmagatzemar, mostrar, editar, actualitzar i eliminar espais_idiomes
Route::group(['prefix' => 'espais_idiomes', 'middleware' => ControlaAdministrador::class], function () {
    Route::get('', [EspaisIdiomesController::class, 'index'])->name('espais_idiomes.index');
    Route::post('', [EspaisIdiomesController::class, 'store'])->name('espais_idiomes.store');
    Route::get('/{idioma_id}/{espai_id}', [EspaisIdiomesController::class, 'show'])->where(['idioma_id' => '[0-9]+', 'espai_id' => '[0-9]+'])->name('espais_idiomes.show');
    Route::put('/{idioma_id}/{espai_id}', [EspaisIdiomesController::class, 'update'])->where(['idioma_id' => '[0-9]+', 'espai_id' => '[0-9]+'])->name('espais_idiomes.update');
    Route::delete('/{idioma_id}/{espai_id}', [EspaisIdiomesController::class, 'destroy'])->where(['idioma_id' => '[0-9]+', 'espai_id' => '[0-9]+'])->name('espais_idiomes.destroy');
});