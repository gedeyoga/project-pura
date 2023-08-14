<?php

use App\Http\Controllers\Admin\JenisPuraController;
use App\Http\Controllers\Admin\PuraController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SensorPintuController;
use App\Http\Controllers\Admin\SensorCctvController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect()->to(route('login'));
})->name('root');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //users
    Route::resource('users', UserController::class);
    Route::get('/users/{user}/profile', [UserController::class, 'profile'])->name('users.profile');

    //Roles
    Route::resource('roles', RoleController::class);

    //Jenis Pura
    Route::prefix('jenis-puras')->group(function() {
        Route::get('/' ,[ JenisPuraController::class , 'index'])->name('jenis-puras.index');
        Route::get('/create' , [JenisPuraController::class , 'create'])->name('jenis-puras.create');
        Route::get('/{jenis_pura}/edit' , [JenisPuraController::class , 'edit'])->name('jenis-puras.edit');
    });

    Route::prefix('puras')->group(function() {
        Route::get('/' ,[ PuraController::class , 'index'])->name('puras.index');
        Route::get('/create' , [PuraController::class , 'create'])->name('puras.create');
        Route::get('/{pura}/edit' , [PuraController::class , 'edit'])->name('puras.edit');
    });

    Route::prefix('sensor-pintu')->group(function() {
        Route::get('/' ,[ SensorPintuController::class , 'index'])->name('sensor-pintu.index');
        Route::get('/create' , [SensorPintuController::class , 'create'])->name('sensor-pintu.create');
        Route::get('/{pura}/edit' , [SensorPintuController::class , 'edit'])->name('sensor-pintu.edit');
    });

    Route::prefix('sensor-cctv')->group(function() {
        Route::get('/' ,[ SensorCctvController::class , 'index'])->name('sensor-cctv.index');
    });
});

Route::group(['prefix' => 'auth'], function () {
    Auth::routes();
    // Route::get('/login' , [AuthController::class , 'login'])->name('auth.login');
});
