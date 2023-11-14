<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\IdentificacionController;
use App\Http\Controllers\Api\Investigadores\SexoController;
use App\Http\Controllers\Api\Investigadores\EstadoCivilController;
use App\Http\Controllers\Api\Investigadores\PueblosIndigenasController;
use App\Http\Controllers\Api\Investigadores\TiempoDedicacionController;
use App\Http\Controllers\Api\Geolocalizacion\EstadoController;
use App\Http\Controllers\InvestigadoresController;


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
Route::get('/ejemplo', function () {
    return 'Esta es una ruta de ejemplo';
});
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/api/verify-email/{id}', [RegisterController::class, 'verify'])->name('verification.verify');
Route::get('/prueba2', [RegisterController::class, 'prueba2'])->name('prueba2');
Route::post('/resend-verification', [RegisterController::class, 'resendVerify']);
Route::match(['get', 'post'], '/password_reset', [ResetPasswordController::class,'resetPassword'])->name('password.reset');
Route::post('/password_update', [ResetPasswordController::class, 'password_update'])->name('password.update');
Route::post('/login',[AuthController::class,'login']);
Route::put('/mass-update', [ResetPasswordController::class, 'massAssignPasswords']);

Route::middleware(['auth:sanctum','verified'])->group(function () {
    Route::resource('sexo','Api\Investigadores\SexoController');
    Route::resource('estado_civil','Api\Investigadores\EstadoCivilController');
    Route::resource('organizaciones_sociales','Api\Investigadores\OrganizacionesSocialesController');
    Route::resource('pueblos_indigenas','Api\Investigadores\PueblosIndigenasController');
    Route::resource('tiempo_dedicacion','Api\Investigadores\TiempoDedicacionController');
    Route::resource('tipo_dedicacion','Api\Investigadores\TipoDedicacionController');
    Route::get('buscar_pueblo/{pueblo}',[PueblosIndigenasController::class,'search_pueblo'])->name('pueblos_indigenas.buscar');
    
    Route::resource('investigadores', 'InvestigadoresController');
    Route::get('/investigadores/suspender/{id}',[InvestigadoresController::class,'suspend_investigator'])->name('investigadores.suspender');
    Route::get('/investigadores/reactivar/{id}',[InvestigadoresController::class,'reactivate_investigator'])->name('investigadores.reactivar');
    Route::get('/investigadores/recuperar/{id}',[InvestigadoresController::class,'recover_investigator'])->name('investigadores.recuperar');

    Route::post('/vista_investigadores',[InvestigadoresController::class,'investigators_view'])->name('investigadores.vista');
    Route::get('/investigadores/email/{email}',[InvestigadoresController::class,'search_email'])->name('investigadores.email');
    Route::get('/investigadores/cedula/{ci}',[InvestigadoresController::class,'search_cedula'])->name('investigadores.cedula');
    Route::post('/investigador',[InvestigadoresController::class,'logged_investigator'])->name('investigador');
    Route::post('/vista_investigador',[InvestigadoresController::class,'logged_investigator_view'])->name('investigador.vista');
    Route::get('/listados_moduloi',[InvestigadoresController::class,'listados_investigadores'])->name('investigador.listados');

    Route::get('/cne/{cedula}',[IdentificacionController::class,'cne'])->name('investigador.cne');
    // Route::get('/cne/{cedula}',[InvestigadoresController::class,'cne'])->name('investigador.cne');

    Route::get('/cedula/{cedula}',[IdentificacionController::class,'show']);
    //****************  Geolocalización
    Route::resource('estados','Api\Geolocalizacion\EstadoController');
    Route::get('estado_municipios/{estado_id}','Api\Geolocalizacion\EstadoController@estado_municipios')->name('estado.municipio');
    Route::get('municipio_parroquias/{municipio_id}','Api\Geolocalizacion\EstadoController@municipio_parroquias')->name('municipio.parroquias');
    Route::get('buscar_estado/{estado_id}','Api\Geolocalizacion\EstadoController@search_estado')->name('estado.buscar');
    //****************  Geolocalización
    Route::post('/logout',[AuthController::class,'logout']);
});