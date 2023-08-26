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
// Route::post('/emails', [EmailController::class, 'sendEmail']);
// Route::post('/register', 'Api\Auth\RegisterController@register')->name('register');
Route::post('/register', [App\Http\Controllers\Api\Auth\RegisterController::class, 'register']);

// Route::get('/verify-email/{id}', [App\Http\Controllers\Api\Auth\RegisterController::class, 'verify']);
// Route::get('/verify-email/{id}', [App\Http\Controllers\Api\Auth\RegisterController::class, 'verify']);

// Route::get('/api/verify-email/{id}', 'Api\Auth\RegisterController@verify')->name('verification.verify');

// Route::match(['get','post'],'/password/reset', [App\Http\Controllers\Api\Auth\ResetPasswordController::class,'resetPassword'])->name('password.reset');

// Route::post('/password/reset', [App\Http\Controllers\Api\Auth\ResetPasswordController::class,'resetPassword'])->name('password.reset');

// Route::get('reset-password/{token}', 'Auth\ResetPasswordController@resetPasswordForm')->name('reset.password.form');
Route::match(['get', 'post'], '/password/reset', [App\Http\Controllers\Api\Auth\ResetPasswordController::class,'resetPassword'])->name('password.reset');
Route::post('/password_update', [App\Http\Controllers\Api\Auth\RegisterController::class, 'password_update'])->name('password.update');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

