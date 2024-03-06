<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Client\Dashboard as ClientDashboard;
use App\Http\Controllers\Client\MarketPlaceController as ClientMarketPlace;
use App\Http\Controllers\Client\ProfileController as ClientProfile;
use App\Http\Controllers\Client\SalesReportController as SalesReportController;
use App\Http\Controllers\Client\SettingController as SettingController;
use App\Http\Controllers\Client\StockController as StockController;
use App\Http\Controllers\Client\ProductController as ProductController;
use App\Http\Controllers\Client\OrderController as OrderController;
use App\Http\Controllers\Client\ChatController as ChatController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MarketPlace\Tokopeida;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentConfigController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Tokopedia\Category;
use App\Http\Controllers\Tokopedia\Product as TokopediaProduct;
use App\Http\Controllers\Tokopedia\ShopManagment;
use App\Http\Controllers\UserController;
use App\Models\DepositRecord;
use App\Models\Tokopedia\TokopediaToken;
use GuzzleHttp\Client;
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
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/login', [LoginController::class, 'index'])->name('forget');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login-post');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'registerpost'])->name('registerpost');
Route::get('/user/verify/{token}', [LoginController::class, 'verifyUser'])->name('verifyUser');
Route::get('/ridertracker/{userid}/journey/{journeyId}', [UserController::class, 'riderTracker'])->name('riderTracker');
Route::post('/MapData', [UserController::class, 'MapData'])->name('MapData');
Route::prefix('super-admin')->group(function () {
    Route::middleware(['auth', 'check.type', 'prevent-back-history'])->group(function () {
        Route::get('/dashboard', [Dashboard::class, 'index'])->name('sdashboard');
        Route::get('/profile', [ProfileController::class, 'index'])->name('sprofile');
        Route::post('/profile', [ProfileController::class, 'profile_update'])->name('spprofile');
        Route::get('/package', [PackageController::class, 'index'])->name('package');
        Route::get('/payment-config', [PaymentConfigController::class, 'index'])->name('payment-config');
        Route::get('/deposit', [DepositController::class, 'index'])->name('sdeposit');
        Route::get('/coupons', [CouponsController::class, 'index'])->name('coupons');
        Route::post('/coupons-store', [CouponsController::class, 'store'])->name('coupons-store');
        Route::get('/user', [UserController::class, 'index'])->name('user');
        Route::post('/user-store', [UserController::class, 'store'])->name('user-store');
        Route::post('/user/lockUser', [UserController::class, 'lockUser'])->name('lockUser');
        Route::post('/user/unlockUser', [UserController::class, 'unlockUser'])->name('unlockUser');
        Route::get('/activity', [ActivityController::class, 'index'])->name('activity');
        Route::post('/package-store', [PackageController::class, 'store'])->name('package-store');
        Route::post('/deposit-store', [DepositController::class, 'store'])->name('deposit-store');
        Route::post('/payment-store', [PaymentConfigController::class, 'store'])->name('payment-store');
        Route::get('/user-journey/{userid}', [UserController::class, 'journey'])->name('user-journey');

    });
});

Route::prefix('client')->group(function () {
    Route::middleware(['auth', 'check.package.buy', 'prevent-back-history'])->group(function () {
        Route::get('/dashboard', [ClientDashboard::class, 'index'])->name('dashboard');
        Route::get('/profile', [ClientProfile::class, 'index'])->name('profile');
        Route::post('/profile', [ClientProfile::class, 'profile_update'])->name('pprofile');
        Route::get('/product', [ProductController::class, 'marketplace'])->name('product');
        Route::get('/new-product', [ProductController::class, 'new_product'])->name('new-product');
        Route::get('/chat', [ChatController::class, 'index'])->name('chat');
        Route::get('/chat-detail', [ChatController::class, 'chatDetail'])->name('chatDetail');
        Route::get('/dashboard-chat', [ChatController::class, 'index'])->name('dchat');
        Route::get('/order', [OrderController::class, 'index'])->name('order');
        Route::get('/order-detail', [OrderController::class, 'orderDetail'])->name('orderDetail');
        Route::get('/new-order', [OrderController::class, 'new'])->name('new-order');
        Route::get('/stock', [StockController::class, 'index'])->name('stock');
        Route::get('/stock-detail', [StockController::class, 'stockDetail'])->name('stockDetail');
        Route::get('/sales-report', [SalesReportController::class, 'index'])->name('sales-report');
        Route::get('/sales-detail', [SalesReportController::class, 'detail'])->name('sales-detail');
        Route::get('/packages', [SettingController::class, 'packages'])->name('packages');
        Route::post('/packages', [SettingController::class, 'getPaymentAmount'])->name('getPaymentAmount');
        Route::post('/store-buy-packages', [SettingController::class, 'getStorePackagePaymentAmount'])->name('getStorePackagePaymentAmount');
        Route::get('/deposit', [SettingController::class, 'deposit'])->name('deposit');
        Route::get('/market', [ClientMarketPlace::class, 'index'])->name('market');
        Route::post('/new-market', [ClientMarketPlace::class, 'new_marketplace'])->name('new-market');
        Route::get('/list-market', [ClientMarketPlace::class, 'list_marketplace'])->name('list-market');
        Route::get('/tokopedia/{slug?}', [Tokopeida::class, 'index'])->name('tokopedia');
        Route::get('/addtokopedia', [Tokopeida::class, 'add'])->name('addtokopedia');
        Route::post('/tokopedia', [Tokopeida::class, 'tokopedia_post'])->name('tokopedia-post');
        Route::get('/shop/{tokenId}', [ShopManagment::class, 'index'])->name('tokopedia-shop');
        Route::get('refresh-shop/{tokenId}', [ShopManagment::class, 'refresh'])->name('tokopedia-shop-refresh');
        Route::get('/categories/{tokenId}/{fs_id}', [Category::class, 'index'])->name('tokopedia-categories');
        Route::get('/refresh-categories/{tokenId}/{fs_id}', [Category::class, 'refresh'])->name('tokopedia-categories-refresh');
        Route::get('/tokopeida/product/{tokenId}/{fs_id}/{shop_id}', [TokopediaProduct::class, 'productInfo'])->name('tokopedia-product');
        Route::get('/tokopeida/product-refresh/{tokenId}/{fs_id}/{shop_id}', [TokopediaProduct::class, 'refresh'])->name('tokopedia-product-refresh');
        Route::post('/shop/details', [ShopManagment::class, 'getShopInfo'])->name('getShopInfo');
        Route::post('/categories/details', [Category::class, 'getCategoryInfo'])->name('getCategoryInfo');
        Route::post('/product/add-product', [ProductController::class, 'addProduct'])->name('addProduct');
        Route::post('/product/edit-product', [ProductController::class, 'editProduct'])->name('editProduct');
        Route::post('/product/delete-product', [ProductController::class, 'deleteProduct'])->name('deleteProduct');
        Route::post('/product/undelete-product', [ProductController::class, 'undeleteProduct'])->name('undeleteProduct');
    });
});
