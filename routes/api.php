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
use App\Http\Controllers\Api\Member\Auth\AuthMemberController;
use App\Http\Controllers\Api\Member\DashboardMemberController;
use App\Http\Controllers\Api\Member\ProductMemberController;
use App\Http\Controllers\Api\Owner\Dashboard\CardController;
use App\Http\Controllers\Api\Owner\Dashboard\DashboardController;
use App\Http\Controllers\Api\Owner\Dashboard\MembersDataController;
use App\Http\Controllers\Api\Owner\TargetController;
use App\Http\Controllers\Api\Owner\TiktokPage\TiktiokFinanceController;
use App\Http\Controllers\Api\Owner\TiktokPage\TiktiokFulfillmentController;
use App\Http\Controllers\Api\Owner\TiktokPage\TiktiokGlobalProductController;
use App\Http\Controllers\Api\Owner\TiktokPage\TiktiokLogisticsController;
use App\Http\Controllers\Api\Owner\TiktokPage\TiktiokOrderController;
use App\Http\Controllers\Api\Owner\TiktokPage\TiktiokProductController;
use App\Http\Controllers\Api\Owner\TiktokPage\TiktiokPromotionController;
use App\Http\Controllers\Api\Owner\TiktokPage\TiktiokReverseController;
use App\Http\Controllers\Api\Owner\TiktokPage\TiktiokSupplychainController;
use App\Http\Controllers\Api\Transaction\ApiTransactionController;
use App\Http\Controllers\Api\Transaction\RajaOngkirController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    Route::get('/member-list-guest', 'memberByProvince');
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
        Route::get('/user-edit/{username}', 'edit');
        Route::get('/user-adv', 'getAdv');
        Route::get('/user-cs', 'getCS');
        Route::get('/list-all-user', 'listAllUser');
        Route::post('/profile-update', 'profileUpdate');
        Route::post('/user-update/{username}', 'update');
        Route::post('/user-store', 'store');
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
        Route::get('/product-activity-update/{code}', 'updateActivity');
        Route::get('/product-edit/{code}', 'edit');
        Route::post('/product-add', 'store');
        Route::post('/product-update/{code}', 'update');
        Route::post('/product-stock-update/{code}', 'updateStock');
        // category
        Route::post('/product-category-store', 'storeCategory');
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
        Route::post('/update-table', 'updateTable');
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
        Route::get('/owner-member-edit/{username}', 'editMember');
        Route::post('/owner-update-member/{username}', 'updateMember');
    });
});

Route::controller(AuthMemberController::class)->group(function () {
    Route::post('/auth/member', 'loginMember');
    Route::middleware(['auth:member'])->group(function () {
        Route::get('/member-profile', 'memberProfile');
        Route::post('/auth/member-logout', 'logoutMember');
    });
});

Route::controller(ProductMemberController::class)->group(function () {
    Route::middleware(['auth:member'])->group(function () {
        Route::get('/member-product', 'index');
    });
});

Route::controller(DashboardMemberController::class)->group(function () {
    Route::middleware(['auth:member'])->group(function () {
        Route::get('/member-rank-list', 'list');
        Route::get('/member-line-chart', 'lineChartMemberId');
    });
});

// route for tiktok
Route::controller(TiktokKeyController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/tiktok-get-access', 'getAccess');
        Route::post('/tiktok-key-store', 'storeAccess');
        Route::delete('/tiktok-key-delete/{id}', 'deleteToken');
        // auth
        Route::get('/tiktok-get-auth', 'getAuth');
        Route::get('/tiktok-get-refresh-token', 'refreshToken');
        Route::get('/tiktok-get-request', 'getShop');
    });
}); // tiktok auth

Route::controller(TiktiokOrderController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/tiktok-order-detail', 'getOrderDetail');
        Route::get('/tiktok-order-list', 'getOrderList');
    });
}); // tiktok order

Route::controller(TiktiokProductController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/tiktok-product-upload-file', 'uploadFile');
        Route::get('/tiktok-product-upload-image', 'uploadImage');
        Route::get('/tiktok-product-create-product', 'createProduct');
        Route::get('/tiktok-product-delete-product', 'deleteProduct');
        Route::get('/tiktok-product-edit-product', 'editProduct');
        Route::get('/tiktok-product-update-stock', 'updateStock');
        Route::get('/tiktok-product-get-product-list', 'getProductList');
        Route::get('/tiktok-product-get-product-detail', 'getProductDetail');
        Route::get('/tiktok-product-deactivate-product', 'deactivateProduct');
        Route::get('/tiktok-product-activate-product', 'activateProduct');
        Route::get('/tiktok-product-recover-delete-product', 'recoverDeleteProduct');
        Route::get('/tiktok-product-update-price', 'updatePrice');
        Route::get('/tiktok-product-get-categories', 'getCategories');
        Route::get('/tiktok-product-get-brands', 'getBrands');
        Route::get('/tiktok-product-get-attributes', 'getAttributes');
        Route::get('/tiktok-product-get-category-rule', 'getCategoryRule');
        Route::get('/tiktok-product-category-recomended', 'categoryRecomended');
        Route::get('/tiktok-product-create-draft-product', 'createDraftProduct');
    });
}); // tiktok product

Route::controller(TiktiokFulfillmentController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/tiktok-fulfillment-verify-order-split', 'verifyOrderSplit');
        Route::get('/tiktok-fulfillment-confirm-order-split', 'confirmOrderSplit');
        Route::get('/tiktok-fulfillment-search-pre-combine-pkg', 'searchPreCombinePkg');
        Route::get('/tiktok-fulfillment-get-package-shipping-document', 'getPakageShippingDocument');
        Route::get('/tiktok-fulfillment-update-package-shipping-info', 'updatePackageShippingInfo');
        Route::get('/tiktok-fulfillment-get-package-shipping-info', 'getPackageShippingInfo');
        Route::get('/tiktok-fulfillment-search-package', 'searchPackage');
        Route::get('/tiktok-fulfillment-ship-package', 'shipPackage');
        Route::get('/tiktok-fulfillment-get-package-pickup-config', 'getPackagePickupConfig');
        Route::get('/tiktok-fulfillment-remove-package-order', 'removePackageOrder');
        Route::get('/tiktok-fulfillment-confirm-precombine-package', 'confirmPrecombinePackage');
        Route::get('/tiktok-fulfillment-get-package-detail', 'getPackageDetail');
        Route::get('/tiktok-fulfillment-fulfillment-upload-image', 'fulfillmentUploadImage');
        Route::get('/tiktok-fulfillment-update-package-delivery-status', 'updatePackageDeliveryStatus');
        Route::get('/tiktok-fulfillment-fulfillment-upload-file', 'fulfillmentUploadFile');
        Route::get('/tiktok-fulfillment-batch-ship-package', 'batchShipPackage');
    });
}); // tiktok fullfillment

Route::controller(TiktiokLogisticsController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/tiktok-logistics-get-subscribed-delivery-option', 'getSubscribedDeliveryOption');
        Route::get('/tiktok-logistics-update-shipping-info', 'updateShippingInfo');
        Route::get('/tiktok-logistics-get-shipping-document', 'getShippingDocument');
        Route::get('/tiktok-logistics-get-shipping-provider', 'getShippingProvider');
        Route::get('/tiktok-logistics-get-shipping-info', 'getShippingInfo');
        Route::get('/tiktok-logistics-get-warehouse-list', 'getWarehouseList');
    });
}); // tiktok logistics

Route::controller(TiktiokReverseController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/tiktok-reverse-reject-reverse-request', 'rejectReverseRequest');
        Route::get('/tiktok-reverse-get-reverse-order-list', 'getReverseOrderList');
        Route::get('/tiktok-reverse-confirm-reverse-request', 'confirmReverseRequest');
        Route::get('/tiktok-reverse-cancle-order', 'cancleOrder');
        Route::get('/tiktok-reverse-get-reject-reason-list', 'getRejectReasonList');
    });
}); // tiktok reverse

Route::controller(TiktiokFinanceController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/tiktok-finance-get-settlements', 'getSettlements');
        Route::get('/tiktok-finance-get-transactions', 'getTransactions');
        Route::get('/tiktok-finance-get-order-settlements', 'getOrdersettlements');
    });
}); // tiktok finance

Route::controller(TiktiokGlobalProductController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {});
}); // tiktok global product

Route::controller(TiktiokPromotionController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {});
}); // tiktok promotion

Route::controller(TiktiokSupplychainController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {});
}); // tiktok supplychain
