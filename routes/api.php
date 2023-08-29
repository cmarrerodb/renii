<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
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
Route::post('/register', [App\Http\Controllers\Api\Auth\RegisterController::class, 'register']);
Route::get('/api/verify-email/{id}', [App\Http\Controllers\Api\Auth\RegisterController::class, 'verify'])->name('verification.verify');
Route::match(['get', 'post'], '/password/reset', [App\Http\Controllers\Api\Auth\ResetPasswordController::class,'resetPassword'])->name('password.reset');
Route::post('/password_update', [App\Http\Controllers\Api\Auth\ResetPasswordController::class, 'password_update'])->name('password.update');
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/login',[App\Http\Controllers\Api\Auth\LoginController::class,'login']);
Route::post('/login',[App\Http\Controllers\Api\Auth\AuthController::class,'login']);

// Route::group(['middleware' => ['auth:sanctum']], function () {
Route::middleware(['auth:sanctum','verified'])->group(function () {
//     Route::post('/pueblos_indigenas',[PueblosIndigenasController::class,'store']);
//     Route::put('/pueblos_indigenas/{id}',[PueblosIndigenasController::class,'update']);
//     Route::delete('/pueblos_indigenas/{id}',[PueblosIndigenasController::class,'destroy']);
    Route::post('/logout',[App\Http\Controllers\Api\Auth\AuthController::class,'logout']);
});

