<?php

use App\Http\Controllers\BuyerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChooseTypeController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisBuyerController;
use App\Http\Controllers\RegisSellerController;
use App\Http\Controllers\RegisUserController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Middleware\GuestOrBuyerMiddleware;

// Route::middleware('web')->group(function () {
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [ProductController::class, 'indexBuyer'])->name('home');
// });



Route::middleware(['guestOrBuyer'])->group(function () {
    Route::get('products/detailProduct/{id}', [ProductController::class, 'detailProductBuyer'])->name('products.detailBuyer');
    Route::get('/buyer/products', [ProductController::class, 'indexBuyer'])->name('buyer.products.index');
    Route::get('/buyer/products/shop/{id}', [ProductController::class, 'productByShop'])->name('buyer.products.shop');

    Route::post('/favorite/store/{product}', [FavoriteController::class, 'store'])->name('favorite.store');
    Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite.index');

    Route::resource('/cart', CartController::class);
    Route::post('/cart/storeBuy', [CartController::class, 'storeBuy'])->name('cart.buy.store');

    Route::post('/order', [OrderController::class,'checkout'])->name('order.checkout');
    Route::get('/order', [OrderController::class,'success'])->name('order.success');
    Route::patch('seller/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');
    Route::get('/buyer/orders/pending', [OrderController::class,'buyerPending'])->name('buyer.orders.pending');
    Route::get('/buyer/orders/shipped', [OrderController::class,'buyerShipped'])->name('buyer.orders.shipped');
    Route::get('/buyer/orders/completed', [OrderController::class,'buyerCompleted'])->name('buyer.orders.completed');
    Route::get('/buyer/orders/cancelled', [OrderController::class,'buyerCancelled'])->name('buyer.orders.cancelled');

    Route::resource('/profile', ProfileController::class);
    Route::put('/profile/{id}/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    });

// ROUTE UNTUK LOGIN DAN LOGOUT
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginUserController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginUserController::class, 'login'])->name('login.post');
    Route::resource('/registerBuyer', RegisBuyerController::class);
    Route::resource('/registerSeller', RegisSellerController::class);
    Route::resource('/chooseType', ChooseTypeController::class);
});

Route::post('logout', [LoginUserController::class, 'logout'])->name('logout');

// ROUTE UNTUK SELLER
Route::middleware('seller')->group(function () {
    Route::resource('seller/products', ProductController::class);
    // Route::post('/seller/products/create', [ProductController::class, 'storeImage'])->name('products.images.store');
    Route::get('/seller/products', [ProductController::class, 'indexSeller'])->name('sellerPage.products.index');
    Route::get('seller/products/detailProduct/{id}', [ProductController::class, 'detailProduct'])->name('products.detail');
    Route::get('/seller/orders', [OrderController::class, 'sellerOrders'])->name('seller.orders');
    Route::patch('/seller/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('seller.orders.update-status');
    Route::get('/seller/shipped', [OrderController::class, 'shippedOrders'])->name('seller.shipped');
    Route::get('/seller/cancelled', [OrderController::class, 'cancelledOrders'])->name('seller.cancelled');
    Route::get('/seller/completed', [OrderController::class, 'completedOrders'])->name('seller.completed');
    // Route::patch('seller/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');
    Route::get('/seller/settings', [SettingController::class, 'sellerIndex'])->name('seller.settings.index');
    Route::put('/seller/profile/{id}', [SettingController::class, 'updateSellerProfile'])->name('seller.profile.update');
    Route::put('/seller/password/{id}', [SettingController::class, 'updateSellerPassword'])->name('seller.password.update');
    Route::delete('/seller/profile/{id}', [SettingController::class, 'destroySellerProfile'])->name('seller.profile.destroy');
});

// ROUTE ADMIN
Route::middleware('admin')->group(function () {
    Route::resource('/adminPageSeller', SellerController::class);
    Route::resource('/adminPageBuyer', BuyerController::class);
    Route::resource('/category', CategoryController::class);
    Route::get('/adminPage/category', [CategoryController::class, 'index'])->name('adminPage.category.index');
    Route::get('/adminPage/category/create', [CategoryController::class, 'create'])->name('adminPage.category.create');
    Route::get('/adminPage/category/{categoryId}/productList', [CategoryController::class, 'productList'])->name('adminPage.category.productList');
    Route::post('/adminPage/category', [CategoryController::class, 'store'])->name('adminPage.category.store');
    Route::get('/adminPage/category/{id}/edit', [CategoryController::class, 'edit'])->name('adminPage.category.edit');
    Route::put('/adminPage/category/{id}', [CategoryController::class, 'update'])->name('adminPage.category.update');
    Route::delete('/adminPage/category/{id}', [ProductController::class, 'destroyAdmin'])->name('adminPage.category.destroy');
});
