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
    Route::resource('investigadores', 'InvestigadoresController');
    Route::get('/investigadores/email/{email}',[InvestigadoresController::class,'search_email'])->name('investigadores.email');
    Route::get('/investigadores/cedula/{ci}',[InvestigadoresController::class,'search_cedula'])->name('investigadores.cedula');
    Route::get('/cedula/{cedula}',[IdentificacionController::class,'show']);
    Route::resource('sexo','Api\Investigadores\SexoController');
    Route::resource('estado_civil','Api\Investigadores\EstadoCivilController');
    Route::resource('pueblos_indigenas','Api\Investigadores\PueblosIndigenasController');
    Route::resource('tiempo_dedicacion','Api\Investigadores\TiempoDedicacionController');
    Route::resource('tipo_dedicacion','Api\Investigadores\TipoDedicacionController');
    Route::resource('organizaciones_sociales','Api\Investigadores\OrganizacionesSocialesController');
    // Route::get('/prueba1', [RegisterController::class, 'prueba1'])->name('prueba1');
//     Route::post('/pueblos_indigenas',[PueblosIndigenasController::class,'store']);
//     Route::put('/pueblos_indigenas/{id}',[PueblosIndigenasController::class,'update']);
//     Route::delete('/pueblos_indigenas/{id}',[PueblosIndigenasController::class,'destroy']);
    Route::post('/logout',[AuthController::class,'logout']);
});
