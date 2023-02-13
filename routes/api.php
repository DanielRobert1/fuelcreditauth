<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegistrationController;
use App\Http\Controllers\Api\FallbackController;
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


/**
 * ===================================================================
 * GUEST ONLY ROUTES
 * ===================================================================
 */

Route::group(['middleware' => ['guest:sanctum']], function () {
    Route::post('/register', [RegistrationController::class, 'register'])->name('api.register');
    Route::post('/login', [LoginController::class, 'login'])->name('api.login');
});


/**
 * ===================================================================
 * AUTH ROUTES
 * ===================================================================
 */

 Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('users', [LoginController::class, 'getUser'])->name('api.user');
    Route::post('logout', [LoginController::class, 'logout'])->name('api.logout');
    Route::post('devices/logout', [LoginController::class, 'logoutAllDevices'])->name('api.devices.logout');
 });


 Route::any('{uri}', [FallbackController::class, 'missing'])->where('uri', '.*');
