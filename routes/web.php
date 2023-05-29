<?php

use App\Http\Controllers\administrator\CategoryController;
use App\Http\Controllers\Helpers\UserActivityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\administrator\DashboardController;
use App\Http\Controllers\administrator\DivisionController;
use App\Http\Controllers\administrator\MemberController;
use App\Http\Controllers\administrator\ProductController;
use App\Http\Controllers\administrator\UsersController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(DivisionController::class)->group(function () {
        Route::get('/division-controller', 'index')->name('division-index');
        Route::post('/division-post', 'store')->name('division-store');
        Route::get('/division-edit/{division_code}', 'edit')->name('division-edit');
        Route::patch('/division-update/{division_code}', 'update')->name('division-update');
    });

    Route::controller(UsersController::class)->group(function () {
        Route::get('/user-controller', 'index')->name('user-index');
        Route::get('/user-create', 'create')->name('user-create');
        Route::post('/user-post', 'store')->name('user-store');
        Route::delete('/user-destroy/{id}', 'destroy')->name('user-destroy');
        Route::get('/user-edit/{id}', 'edit')->name('user-edit');
        Route::patch('/user-update/{id}', 'update')->name('user-update');
        Route::get('/user-image/{filename}', 'userImage')->name('user-image');
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category-controller', 'index')->name('category-index');
        Route::post('/category-post', 'store')->name('category-store');
        Route::get('/category-edit/{code}', 'edit')->name('category-edit');
        Route::patch('/category-update/{code}', 'update')->name('category-update');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('/product-controller', 'index')->name('product-index');
        Route::get('/product-create', 'create')->name('product-create');
        Route::post('/product-post', 'store')->name('product-store');
        Route::get('/product-edit/{code}', 'edit')->name('product-edit');
        Route::patch('/product-update/{id}', 'update')->name('product-update');
        Route::delete('/product-destroy/{id}', 'destroy')->name('product-destroy');
        Route::get('/product-image/{filename}', 'productImage')->name('product-image');
    });

    Route::controller(MemberController::class)->group(function () {
        Route::get('/member-controller', 'index')->name('member-index');
        Route::get('/member-create', 'create')->name('member-create');
        Route::post('/member-post', 'store')->name('member-store');
        Route::get('/member-image/{filename}', 'memberImage')->name('member-image');
    });
});

Route::get('/member-card/{username}', [MemberController::class, 'memberCard'])->name('member-card');

Route::get('add-to-log', [UserActivityController::class, 'testLog']);
Route::get('log-activity', [UserActivityController::class, 'userActivity']);

require __DIR__ . '/auth.php';
