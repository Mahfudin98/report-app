<?php

use App\Http\Controllers\Api\Administrator\ApiDivisionsController;
use App\Http\Controllers\Api\Administrator\ApiMembersController;
use App\Http\Controllers\Api\Administrator\ApiProductsController;
use App\Http\Controllers\Api\Administrator\LogisticController;
use App\Http\Controllers\Api\Auth\ApiLoginController;
use App\Http\Controllers\Api\Auth\ApiUsersController;
use App\Http\Controllers\Api\Auth\TiktokKeyController;
use App\Http\Controllers\Api\Dashboard\ActivityUserController;
use App\Http\Controllers\Api\Dashboard\DashboardIndex;
use App\Http\Controllers\Api\Dashboard\ProfileDashboardController;
use App\Http\Controllers\Api\Owner\Dashboard\CardController;
use App\Http\Controllers\Api\Owner\Dashboard\DashboardController;
use App\Http\Controllers\Api\Owner\Dashboard\MembersDataController;
use App\Http\Controllers\Api\Owner\TargetController;
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

Route::controller(RajaOngkirController::class)->group(function () {
    Route::get('/provinsi', 'provinsi')->name('provinsi');
    Route::get('/kota/{id}', 'kota')->name('kota');
    Route::get('/kecamatan/{id}', 'kecamatan')->name('kecamatan');
    Route::post('/cek-ongkir', 'cekOngkir')->name('cek-ongkir');
});

Route::controller(ApiLoginController::class)->group(function () {
    Route::post('login', 'login');
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/user-login', 'userLogin');
        Route::post('/logout', 'logout');
        Route::get('/user-image', 'userImage');
    });
});

Route::controller(ApiUsersController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/user-list', 'index');
        Route::get('/user-show/{username}', 'show');
        Route::get('/user-edit', 'edit');
        Route::get('/user-adv', 'getAdv');
        Route::post('/profile-update', 'profileUpdate');
    });
});

Route::controller(ApiDivisionsController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/division-list', 'index');
    });
});

Route::controller(ApiTransactionController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/transaction-index', 'index');
        Route::get('/transaction-show/{code}', 'show');
        Route::post('/transaction-store', 'transactionStore');
        Route::delete('/transaction-delete/{code}', 'delete');
        Route::get('/all-transaction', 'order');
        Route::post('/update-order/{code}', 'updateOrder');
    });
});

Route::controller(ApiProductsController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/product-index', 'index');
        Route::get('/product-category', 'category');
        Route::get('/product-select', 'selectProduct');
        Route::get('/product-list-gudang', 'listGudang');
        Route::post('/product-stock-update/{code}', 'updateStock');
    });
    Route::get('/product-list-customer', 'listCustomer');
});

Route::controller(ApiMembersController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/member-index-cs', 'indexCS');
        Route::get('/member-select', 'selectMember');
        Route::post('/member-store', 'store');
        Route::get('/member-edit/{id}', 'edit');
        Route::post('/member-update/{id}', 'update');
    });
});

Route::controller(ProfileDashboardController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/profile-bar/{username}', 'barChart');
    });
});

Route::controller(ActivityUserController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/user-activity/{username}', 'userActivity');
        Route::get('/user-activity-list/{id}', 'userActivityDetail');
    });
});

Route::controller(DashboardIndex::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/line-chart-dashboard', 'lineChart');
        Route::get('/top-cs', 'topCS');
        Route::get('/top-product', 'topProduk');
        Route::get('/card-status', 'cardStatus');
    });
});

Route::controller(DashboardController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/owner-chart-dashboard', 'lineChart');
        Route::get('/owner-bar-dashboard', 'barChart');
        Route::get('/owner-top-cs', 'topCS');
        Route::get('/owner-top-product', 'topProduk');
        Route::get('/owner-cs-performance', 'csPerformance');
        Route::get('/owner-chart/{id}', 'chartId');
        Route::get('/owner-bar/{id}', 'barId');
    });
});

Route::controller(TargetController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/owner-target-adv', 'advList');
        Route::get('/owner-target-index', 'index');
        Route::post('/owner-target-store', 'store');
        Route::get('/owner-target-persen', 'percent');
    });
});

Route::controller(CardController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/owner-card-omset', 'omset');
        Route::get('/owner-card-produk', 'produk');
    });
});

Route::controller(TiktokKeyController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/tiktok-get-access', 'getAccess');
        Route::post('/tiktok-key-store', 'storeAccess');
    });
});

Route::controller(LogisticController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/index-logistic', 'index');
        Route::get('/edit-logistic/{id}', 'editLogistic');
        Route::get('/edit-category-logistic/{code}', 'editCategory');
        Route::get('/select-category-logistic', 'selectCategory');
        Route::post('/store-logistic', 'storeLogistic');
        Route::post('/update-logistic/{id}', 'updateLogistic');
        Route::post('/store-category-logistic', 'storeCategory');
        Route::post('/update-category-logistic/{code}', "updateCategoryLogistic");
    });
});

Route::controller(MembersDataController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/owner-list-data-member', 'listMember');
        Route::get('/owner-list-data-cs', 'listCSMember');
        Route::get('/owner-line-data-member', 'lineChartMember');
        Route::get('/owner-line-data-member/{id}', 'lineChartMemberID');
        Route::get('/owner-bar-data-member', 'barChartMember');
        Route::get('/owner-bar-data-member/{id}', 'barChartMemberID');
        Route::get('/owner-performance-member', 'performanceMember');
        Route::get('/owner-member-activity/{id}', 'activityID');
    });
});
