<?php

use Illuminate\Support\Facades\Route;


Route::controller(\App\Http\Controllers\Frontend\HomeController::class)->group(function (){
    Route::get('/', 'index');
    Route::get('product-details/{slug}', 'product_details')->name('product_details');

    Route::get('/cart', 'view_cart')->name('view_cart');
    Route::post('add-to-cart/{id}', 'add_to_card')->name('add_to_card');
    Route::get('update-qty', 'update_qty')->name('update_qty');
    Route::get('remove-item-cart/{key}', 'remove_item_cart')->name('remove_item_cart');
    Route::get('clear-cart', 'clear_cart')->name('clear_cart');
    Route::get('apply-coupon', 'apply_coupon')->name('apply_coupon');
    Route::get('remove-coupon', 'remove_coupon')->name('remove_coupon');

});

Route::controller(\App\Http\Controllers\Frontend\CheckoutController::class)->group(function (){
   Route::get('checkout', 'checkout')->name('checkout')->middleware('auth');
});


Route::controller(\App\Http\Controllers\Frontend\AuthController::class)->group(function (){
    Route::match(['get', 'post'], 'login', 'login')->name('login');
    Route::match(['get', 'post'], 'register', 'register')->name('register');
    Route::post('/logout', 'logout')->name('user.logout')->middleware('auth');
});


Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => 'auth'], function (){

    Route::controller(\App\Http\Controllers\Frontend\UserController::class)->group(function (){

        Route::get('/dashboard', 'dashboard')->name('dashboard');


    });

});


//admin routes
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function (){

    //auth routes
    Route::controller(\App\Http\Controllers\Backend\AuthController::class)->group(function (){
        Route::match(['get', 'post'], '/', 'admin_login')->name('login');

        Route::get('/dashboard', 'dashboard')->name('dashboard')->middleware('admin');
        Route::post('/logout', 'logout')->name('logout')->middleware('admin');

        Route::match(['get', 'post'], 'profile', 'profile')->name('profile');
        Route::match(['get', 'post'], 'change-password', 'change_password')->name('change_password');

    });

    Route::middleware('admin')->group(function (){

        //category routes
        Route::resource('categories',\App\Http\Controllers\Backend\CategoryController::class);

        //subcategory routes
        Route::resource('subcategories', \App\Http\Controllers\Backend\SubCategoryController::class);

        //brand routes
        Route::resource('brands', \App\Http\Controllers\Backend\BrandController::class);

        //attribute routes
        Route::resource('attributes', \App\Http\Controllers\Backend\AttributeController::class);

        //product routes
        Route::resource('products', \App\Http\Controllers\Backend\ProductController::class);
        Route::get('get-subcategories', [\App\Http\Controllers\Backend\ProductController::class, 'get_subcategories'])->name('get_subcategories');
        Route::match(['get', 'post'],'product/gallery/{id}', [\App\Http\Controllers\Backend\ProductController::class, 'product_gallery'])->name('products.gallery');
        Route::get('product/gallery/destroy/{id}', [\App\Http\Controllers\Backend\ProductController::class, 'product_gallery_destroy'])->name('products.gallery.destroy');

        //slider routes
        Route::resource('sliders', \App\Http\Controllers\Backend\SliderController::class);

        //coupon routes
        Route::resource('coupons', \App\Http\Controllers\Backend\CouponController::class);

        //settings
        Route::match(['get', 'post'], 'website-settings', [\App\Http\Controllers\Backend\SettingController::class, 'website_settings'])->name('website_settings');

    });



});
