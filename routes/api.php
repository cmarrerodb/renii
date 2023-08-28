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
Route::match(['get', 'post'], '/password/reset', [App\Http\Controllers\Api\Auth\ResetPasswordController::class,'resetPassword'])->name('password.reset');
Route::post('/password_update', [App\Http\Controllers\Api\Auth\ResetPasswordController::class, 'password_update'])->name('password.update');
Route::get('/password/form', [PasswordController::class, 'password_form'])->name('password.form');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

