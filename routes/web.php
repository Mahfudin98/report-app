<?php

use App\Http\Controllers\administrator\CategoryController;
use App\Http\Controllers\Helpers\UserActivityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\administrator\DashboardController;
use App\Http\Controllers\administrator\DivisionController;
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

Route::middleware('auth')->group(function (){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/division-controller', [DivisionController::class, 'index'])->name('division-index');
    Route::post('/division-post', [DivisionController::class, 'store'])->name('division-store');
    Route::get('/division-edit/{division_code}', [DivisionController::class, 'edit'])->name('division-edit');
    Route::patch('/division-update/{division_code}', [DivisionController::class, 'update'])->name('division-update');

    Route::get('/user-controller', [UsersController::class, 'index'])->name('user-index');
    Route::get('/user-create', [UsersController::class, 'create'])->name('user-create');
    Route::post('/user-post', [UsersController::class, 'store'])->name('user-store');
    Route::delete('/user-destroy/{id}', [UsersController::class, 'destroy'])->name('user-destroy');
    Route::get('/user-edit/{id}', [UsersController::class, 'edit'])->name('user-edit');
    Route::patch('/user-update/{id}', [UsersController::class, 'update'])->name('user-update');
    Route::get('/user-image/{filename}', [UsersController::class, 'userImage'])->name('user-image');

    Route::get('/category-controller', [CategoryController::class, 'index'])->name('category-index');
    Route::post('/category-post', [CategoryController::class, 'store'])->name('category-store');
    Route::get('/category-edit/{code}', [CategoryController::class, 'edit'])->name('category-edit');
    Route::patch('/category-update/{code}', [CategoryController::class, 'update'])->name('category-update');

    Route::get('/product-controller', [ProductController::class, 'index'])->name('product-index');
    Route::get('/product-create', [ProductController::class, 'create'])->name('product-create');
    Route::post('/product-post', [ProductController::class, 'store'])->name('product-store');
    Route::get('/product-edit/{code}', [ProductController::class, 'edit'])->name('product-edit');
    Route::patch('/product-update/{id}', [ProductController::class, 'update'])->name('product-update');
    Route::delete('/product-destroy/{id}', [ProductController::class, 'destroy'])->name('product-destroy');
    Route::get('/product-image/{filename}', [ProductController::class, 'productImage'])->name('product-image');
});

Route::get('add-to-log', [UserActivityController::class, 'testLog']);
Route::get('log-activity', [UserActivityController::class, 'userActivity']);

require __DIR__.'/auth.php';
