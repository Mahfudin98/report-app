<?php

use App\Http\Controllers\Api\Administrator\ApiDivisionsController;
use App\Http\Controllers\Api\Auth\ApiLoginController;
use App\Http\Controllers\Api\Auth\ApiUsersController;
use App\Http\Controllers\Api\Transaction\ApiTransactionController;
use App\Http\Controllers\Api\Transaction\RajaOngkirController;
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
Route::controller(RajaOngkirController::class)->group(function(){
    Route::get('/provinsi', 'provinsi')->name('provinsi');
    Route::get('/kota/{id}', 'kota')->name('kota');
    Route::get('/kecamatan/{id}', 'kecamatan')->name('kecamatan');
    Route::post('/cek-ongkir', 'cekOngkir')->name('cek-ongkir');
});

Route::controller(ApiLoginController::class)->group(function(){
    Route::post('login', 'login');
    Route::middleware(['auth:sanctum'])->group(function(){
        Route::get('/user-login', 'userLogin');
        Route::post('/logout', 'logout');
        Route::get('/user-image', 'userImage');
    });
});

Route::controller(ApiUsersController::class)->group(function(){
    Route::middleware(['auth:sanctum'])->group(function(){
        Route::get('/user-list', 'index');
        Route::get('/user-edit', 'edit');
        Route::get('/user-adv', 'getAdv');
        Route::post('/profile-update', 'profileUpdate');
    });
});

Route::controller(ApiDivisionsController::class)->group(function(){
    Route::middleware(['auth:sanctum'])->group(function(){
        Route::get('/division-list', 'index');
    });
});

Route::controller(ApiTransactionController::class)->group(function(){
    Route::middleware(['auth:sanctum'])->group(function(){
        Route::post('/transaction-store', 'transactionStore');
    });
});
