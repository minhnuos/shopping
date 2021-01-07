<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\BrandProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\NotifyController;

/*
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
// user
Route::prefix('/')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/login', [UserController::class, 'login'])->name('user.login');
    Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');
    Route::post('/sigup', [UserController::class, 'sigup'])->name('user.sigup');
    Route::get('/status-login', [UserController::class, 'getStatusLogin'])->name('user.statuslogin');
    Route::post('/check-login', [UserController::class, 'checkLogin'])->name('user.checklogin');
    Route::get('/danh-muc/{slug}', [CategoryProductController::class, 'getAllProductByCategory'])->name('category.product');
    Route::get('/thuong-hieu/{slug}', [BrandProductController::class, 'getAllProductByBrand'])->name('brand.product');
    Route::get('/chi-tiet-san-pham/{slug}', [ProductController::class, 'showProductDetail'])->name('detail.product');
    Route::prefix('/cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index.cart');
        Route::post('/add', [CartController::class, 'addProductToCart'])->name('add.cart');
        Route::get('/delete/{rowId}', [CartController::class, 'deleteProductToCart'])->name('delete.cart');
        Route::get('/update/{rowId}', [CartController::class, 'updateProductToCart'])->name('update.cart');
    });
    Route::prefix('/check-out')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/store', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/history', [CheckoutController::class, 'history'])->name('checkout.history');
    });
    Route::prefix('coupon')->group(function () {
        Route::post('/check-coupon', [CouponController::class, 'checkCoupon'])->name('check.coupon.coupon');
    });

    Route::prefix('delivery')->group(function () {
        Route::post('/get-delivery', [DeliveryController::class, 'getDelivery'])->name('get.delivery.delivery');
        Route::post('/get-feeship-delivery', [DeliveryController::class, 'getDeliveryAndFeeship'])->name('get.delivery.feeship');
        Route::get('/select', [DeliveryController::class, 'seleteDelivery'])->name('select.delivery');
    });
});

//admin

Route::group(['middleware' => ['check.admin']], function () {
    //
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin');
        Route::get('/login', [AdminController::class, 'login'])->name('admin.login')->withoutMiddleware('check.admin');
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::post('/check-login', [AdminController::class, 'checkLogin'])->name('admin.check.login')->withoutMiddleware('check.admin');

        // category product
        Route::prefix('category-product')->group(function () {
            Route::get('/', [CategoryProductController::class, 'index'])->name('index.category.product');
            Route::get('/create', [CategoryProductController::class, 'create'])->name('create.category.product');
            Route::post('/store', [CategoryProductController::class, 'store'])->name('store.category.product');
            Route::post('/update/{id}', [CategoryProductController::class, 'update'])->name('update.category.product');
            Route::get('/edit/{id}', [CategoryProductController::class, 'edit'])->name('edit.category.product');
            Route::get('/delete/{id}', [CategoryProductController::class, 'delete'])->name('delete.category.product');
            Route::get('/unactive/{id}', [CategoryProductController::class, 'unactive'])->name('unactive.category.product');
            Route::get('/active/{id}', [CategoryProductController::class, 'active'])->name('active.category.product');
        });

        // brand product
        Route::prefix('brand-product')->group(function () {
            Route::get('/', [BrandProductController::class, 'index'])->name('index.brand.product');
            Route::get('/create', [BrandProductController::class, 'create'])->name('create.brand.product');
            Route::post('/store', [BrandProductController::class, 'store'])->name('store.brand.product');
            Route::post('/update/{id}', [BrandProductController::class, 'update'])->name('update.brand.product');
            Route::get('/edit/{id}', [BrandProductController::class, 'edit'])->name('edit.brand.product');
            Route::get('/delete/{id}', [BrandProductController::class, 'delete'])->name('delete.brand.product');
            Route::get('/unactive/{id}', [BrandProductController::class, 'unactive'])->name('unactive.brand.product');
            Route::get('/active/{id}', [BrandProductController::class, 'active'])->name('active.brand.product');
        });

        // product
        Route::prefix('product')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index.product');
            Route::get('/create', [ProductController::class, 'create'])->name('create.product');
            Route::post('/store', [ProductController::class, 'store'])->name('store.product');
            Route::post('/update/{id}', [ProductController::class, 'update'])->name('update.product');
            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit.product');
            Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('delete.product');
            Route::get('/unactive/{id}', [ProductController::class, 'unactive'])->name('unactive.product');
            Route::get('/active/{id}', [ProductController::class, 'active'])->name('active.product');
        });

        // order
        Route::prefix('order')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index.order');
            Route::get('/detail/{id}', [OrderController::class, 'viewDetailOrder'])->name('detail.order');
            Route::get('/print-bill/{order_id}',[OrderController::class, 'printBill'])->name('order.print.bill');
        });

        // shipping
        Route::prefix('shipping')->group(function () {
            Route::get('/', [ShippingController::class, 'index'])->name('index.shipping');
            Route::post('/store', [ShippingController::class, 'store'])->name('store.shipping');
            Route::post('/choose-shipping', [ShippingController::class, 'chooseShipping'])->name('choose.shipping.shipping');
        });


        // coupon
        Route::prefix('coupon')->group(function () {
            Route::get('/', [CouponController::class, 'index'])->name('index.coupon');
            Route::get('/create', [CouponController::class, 'create'])->name('create.coupon');
            Route::post('/store', [CouponController::class, 'store'])->name('store.coupon');
            Route::get('/delete-coupon', [CouponController::class, 'deleteCoupon'])->name('delete.coupon.coupon');
        });
        //
        Route::prefix('delivery')->group(function () {
            Route::get('/', [DeliveryController::class, 'index'])->name('index.delivery');
            Route::post('/get-delivery', [DeliveryController::class, 'getDelivery'])->name('get.delivery.delivery');
            Route::post('/store', [DeliveryController::class, 'store'])->name('store.delivery');
            Route::get('/select', [DeliveryController::class, 'seleteDelivery'])->name('select.delivery');
        });
        Route::prefix('slider')->group(function () {
            Route::get('/', [SliderController::class, 'index'])->name('index.slider');
            Route::get('/create', [SliderController::class, 'create'])->name('create.slider');
            Route::post('/store', [SliderController::class, 'store'])->name('store.slider');
        });

        Route::prefix('notify')->group(function () {
            Route::get('/', [NotifyController::class, 'index'])->name('index.notify');
            Route::get('/number', [NotifyController::class, 'getNumberNotify'])->name('index.number.notify');
            Route::get('/none-number', [NotifyController::class, 'setNumberEqual0'])->name('index.set.number.notify');

        });
    });
});







