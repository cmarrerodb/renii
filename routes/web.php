<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
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
Route::get('/ejemplo', function () {
    return 'Esta es una ruta de ejemplo';
});
Route::get('/', function () {
    return view('welcome');
});
Route::get('/send-email', function () {
    $emailController = new EmailController();
    $emailController->sendEmail(new \Illuminate\Http\Request([
        'to' => 'marrero.c@gmail.com'
    ]));
});
