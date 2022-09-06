<?php

use App\Http\Controllers\Api\Auth\ApiLoginController;
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

Route::controller(ApiLoginController::class)->group(function(){
    Route::post('login', 'login');
    Route::middleware(['auth:sanctum', 'ability:check-status'])->group(function(){
        Route::get('/user-login', 'userLogin');
        Route::get('/user-image/image="{filename}"', 'userImage');
        Route::post('/logout', 'logout');
    });
});
