<?php

use App\Http\Controllers\Api\SensorPintuController;
use App\Http\Controllers\Api\JenisPuraController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PuraController;
use App\Http\Controllers\Api\RoleController;
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
Route::post('/alert-device', [SensorPintuController::class, 'alertDevice'])->name('api.alertDevice');

Route::middleware('auth:sanctum')->group(function() {
    //User
    Route::prefix('users')->apiResource('user', UserController::class, ['as' => 'api']);

    //Role
    Route::prefix('roles')->apiResource('role', RoleController::class, ['as' => 'api']);
    Route::prefix('puras')->apiResource('pura', PuraController::class, ['as' => 'api']);
    Route::prefix('jenis-puras')->apiResource('jenis-pura', JenisPuraController::class, [
        'as' => 'api',
        'parameters' => [
            'jenis-pura' => 'jenis_pura'
        ]
    ]);

    //Permissions
    Route::group(['prefix' => 'roles', 'as' => 'api.role.'], function () {
        Route::post('/permission', [RoleController::class, 'permissionStore'])->name('permission.store');
        Route::get('/permission', [RoleController::class, 'permissionList'])->name('permission.list');
    });
});
