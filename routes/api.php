<?php

use App\Http\Controllers\Api\GedongSimpenController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [LoginController::class, 'login'])->name('api.login');
// Route::post('/register', [RegisterController::class, 'register'])->name('api.register');
Route::post('/alert-device', [GedongSimpenController::class, 'alertDevice'])->name('api.alertDevice');

Route::middleware('auth:sanctum')->group(function() {
    Route::prefix('users')->apiResource('user' , UserController::class , ['as' => 'api']);
});
