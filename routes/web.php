<?php

use Illuminate\Support\Facades\Route;

Route::get('/storage-link', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    dd('Storage Linked');
});

Route::controller(\App\Http\Controllers\Frontend\HomeController::class)->group(function (){
    Route::get('/', 'index');
    Route::get('product-details/{slug}', 'product_details')->name('product_details');

    Route::get('quick-view/{slug}', 'quick_view')->name('quick_view');

    Route::get('products', 'category_product')->name('category_product');

    Route::get('/cart', 'view_cart')->name('view_cart');
    Route::post('add-to-cart/{id}', 'add_to_card')->name('add_to_card');
    Route::get('update-qty', 'update_qty')->name('update_qty');
    Route::get('remove-item-cart/{key}', 'remove_item_cart')->name('remove_item_cart');
    Route::get('clear-cart', 'clear_cart')->name('clear_cart');
    Route::get('apply-coupon', 'apply_coupon')->name('apply_coupon');
    Route::get('remove-coupon', 'remove_coupon')->name('remove_coupon');

    Route::get('/page/{slug}', 'dynamic_page')->name('dynamic_page');

    Route::get('contact-us', 'contact_us')->name('contact_us');
    Route::post('contact-store', 'contact_store')->name('contact_store');
    Route::post('subscribe', 'subscribe')->name('subscribe');

    Route::get('videos', 'videos')->name('videos');

});

Route::controller(\App\Http\Controllers\Frontend\CheckoutController::class)->group(function (){
   Route::get('checkout', 'checkout')->name('checkout')->middleware('auth', 'active_user');
   Route::post('checkout/store', 'checkout_store')->name('checkout_store')->middleware('auth', 'active_user');
   Route::get('order-complete', 'order_complete')->name('order_complete')->middleware('auth', 'active_user');
});


Route::controller(\App\Http\Controllers\Frontend\AuthController::class)->group(function (){
    Route::match(['get', 'post'], 'login', 'login')->name('login');
    Route::match(['get', 'post'], 'register', 'register')->name('register');
    Route::post('/logout', 'logout')->name('user.logout')->middleware('auth');

    Route::match(['get', 'post'], 'forgot-password', 'forgot_password')->name('forgot_password');
    Route::match(['get', 'post'], 'reset-password/{opt}', 'reset_password')->name('reset_password');
});

//wishlist
Route::controller(\App\Http\Controllers\Frontend\WishlistController::class)->group(function (){

    Route::get('wishlist', 'index')->name('wishlist.index')->middleware('auth');
    Route::get('wishlist-store', 'store')->name('wishlist.store');
    Route::get('wishlist-remove/{id}', 'remove')->name('wishlist.remove')->middleware('auth');

});


Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['auth', 'active_user']], function (){

    Route::controller(\App\Http\Controllers\Frontend\UserController::class)->group(function (){
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/transactions', 'transactions')->name('transactions');
        Route::get('/my-refer/{type?}', 'my_refer')->name('my_refer');
        Route::match(['get', 'post'],'convert-to-main', 'convert_to_main_balance')->name('convert_to_main_balance');

        //account details
        Route::get('account-details', 'account_details')->name('account_details');
        Route::post('update-account-details', 'update_account_details')->name('update_account_details');
        Route::post('update-password', 'update_password')->name('update_password');

    });

    //deposit
    Route::controller(\App\Http\Controllers\Frontend\DepositController::class)->group(function (){
       Route::get('deposits', 'deposit_list')->name('deposit_list');
       Route::post('deposits/store', 'deposit_store')->name('deposit_store');
       Route::get('deposits/details/{id}', 'deposit_details')->name('deposit_details');
    });

    //withdraw
    Route::controller(\App\Http\Controllers\Frontend\WithdrawController::class)->group(function (){
        Route::get('withdraws', 'withdraw_list')->name('withdraw_list');
        Route::post('withdraws/store', 'withdraw_store')->name('withdraw_store');
        Route::get('withdraws/details/{id}', 'withdraw_details')->name('withdraw_details');
    });

    //orders
    Route::controller(\App\Http\Controllers\Frontend\OrderController::class)->group(function (){
        Route::get('orders', 'order_list')->name('order_list');
        Route::get('orders/details/{id}', 'order_details')->name('order_details');
    });

    //review
    Route::controller(\App\Http\Controllers\Frontend\ReviewController::class)->group(function (){
        Route::get('my-reviews', 'my_reviews')->name('my_reviews');
        Route::get('review-details/{id}', 'review_details')->name('review_details');
        Route::post('store-review', 'store_review')->name('store_review');
    });

});


//sslcommerz
Route::controller(\App\Http\Controllers\Payment\SslcommerzController::class)->group(function (){
    Route::prefix('deposit')->group(function (){
        Route::get('ssl_commerz/pay', 'deposit_sslcommerz_pay')->name('deposit.sslcommerz.pay');
        Route::post('ssl_commerz/success', 'deposit_sslcommerz_success')->name('deposit.sslcommerz.success');
        Route::post('ssl_commerz/fail', 'deposit_sslcommerz_fail')->name('deposit.sslcommerz.fail');
        Route::post('ssl_commerz/cancel', 'deposit_sslcommerz_cancel')->name('deposit.sslcommerz.cancel');
    });

    Route::prefix('payment')->group(function (){
        Route::get('ssl_commerz/pay', 'payment_sslcommerz_pay')->name('payment.sslcommerz.pay');
        Route::post('ssl_commerz/success', 'payment_sslcommerz_success')->name('payment.sslcommerz.success');
        Route::post('ssl_commerz/fail', 'payment_sslcommerz_fail')->name('payment.sslcommerz.fail');
        Route::post('ssl_commerz/cancel', 'payment_sslcommerz_cancel')->name('payment.sslcommerz.cancel');
    });

});


//admin routes
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function (){

    //auth routes
    Route::controller(\App\Http\Controllers\Backend\AuthController::class)->group(function (){
        Route::match(['get', 'post'], '/', 'admin_login')->name('login');

        Route::get('/dashboard', 'dashboard')->name('dashboard')->middleware('admin');
        Route::get('/dashboard/order_static', 'order_static')->name('dashboard.order_static');
        Route::get('/dashboard/sales_static', 'sales_static')->name('dashboard.sales_static');


        Route::post('/logout', 'logout')->name('logout')->middleware('admin');

        Route::match(['get', 'post'], 'profile', 'profile')->name('profile');
        Route::match(['get', 'post'], 'change-password', 'change_password')->name('change_password');

    });

    Route::middleware('admin')->group(function (){

        //category routes
        Route::resource('categories',\App\Http\Controllers\Backend\CategoryController::class);
        Route::get('category/show_home_page', [\App\Http\Controllers\Backend\CategoryController::class, 'show_home_page'])->name('categories.show_home_page');


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
        Route::get('product/is_featured', [\App\Http\Controllers\Backend\ProductController::class, 'is_featured'])->name('products.is_featured');
        Route::get('product/hot_deals', [\App\Http\Controllers\Backend\ProductController::class, 'hot_deals'])->name('products.hot_deals');

        //deposit routes
        Route::get('deposits', [\App\Http\Controllers\Backend\DepositController::class, 'index'])->name('deposits.index');
        Route::get('deposits/details/{id}', [\App\Http\Controllers\Backend\DepositController::class, 'details'])->name('deposits.details');
        Route::post('deposits/update-status/{id}', [\App\Http\Controllers\Backend\DepositController::class, 'update_status'])->name('deposits.update_status');

        //order routes
        Route::controller(\App\Http\Controllers\Backend\OrderController::class)->group(function (){
           Route::get('orders', 'index')->name('orders.index');
           Route::get('orders/details/{id}', 'details')->name('orders.details');
           Route::get('orders/update-payment-status', 'update_payment_status')->name('orders.update_payment_status');
           Route::post('orders/update-status/{id}', 'update_status')->name('orders.update_status');
        });

        //coupon routes
        Route::resource('coupons', \App\Http\Controllers\Backend\CouponController::class);

        //users routes
        Route::controller(\App\Http\Controllers\Backend\UserController::class)->group(function (){
           Route::get('users', 'index')->name('users.index');
           Route::get('users/details/{id}', 'details')->name('users.details');
           Route::post('users/status/{id}', 'status')->name('users.status');

            //transactions
            Route::get('transactions', 'transactions')->name('transactions');

        });


        //slider routes
        Route::resource('sliders', \App\Http\Controllers\Backend\SliderController::class);

        //promotional category
        Route::resource('promotional-categories', \App\Http\Controllers\Backend\PromotionalCategoryController::class);

        //promotional category
        Route::resource('pages', \App\Http\Controllers\Backend\DynamicPageController::class);


        //offline payment method
        Route::resource('offline-payment-method', \App\Http\Controllers\Backend\OfflinePaymentMethodController::class);

        //online payment method
        Route::controller(\App\Http\Controllers\Backend\OnlinePaymentMethodController::class)->group(function (){
            Route::get('online-payment-methods', 'online_payment_method')->name('online_payment_method');
            Route::post('online-payment-methods/update', 'online_payment_method_update')->name('online_payment_method_update');
        });

        //withdraw method
        Route::resource('withdraw-methods', \App\Http\Controllers\Backend\WithdrawMethodController::class);

        //withdraw routes
        Route::get('withdraws', [\App\Http\Controllers\Backend\WithdrawController::class, 'index'])->name('withdraws.index');
        Route::get('withdraws/details/{id}', [\App\Http\Controllers\Backend\WithdrawController::class, 'details'])->name('withdraws.details');
        Route::post('withdraws/update-status/{id}', [\App\Http\Controllers\Backend\WithdrawController::class, 'update_status'])->name('withdraws.update_status');

        //product Reviews
        Route::get('reviews', [\App\Http\Controllers\Backend\ProductController::class, 'reviews'])->name('reviews.index');
        Route::get('reviews/details/{id}', [\App\Http\Controllers\Backend\ProductController::class, 'review_details'])->name('reviews.details');
        Route::post('reviews/status/{id}', [\App\Http\Controllers\Backend\ProductController::class, 'review_status'])->name('reviews.status');
        Route::get('reviews/destroy/{id}', [\App\Http\Controllers\Backend\ProductController::class, 'review_destroy'])->name('reviews.destroy');

        //contact us
        Route::get('contacts', [\App\Http\Controllers\Backend\SettingController::class, 'contact_us'])->name('contact_us');
        Route::get('contacts/details/{id}', [\App\Http\Controllers\Backend\SettingController::class, 'contact_details'])->name('contact_details');

        //subscribe
        Route::get('subscribers', [\App\Http\Controllers\Backend\SettingController::class, 'subscribers'])->name('subscribers');
        Route::get('subscribers/destroy/{id}', [\App\Http\Controllers\Backend\SettingController::class, 'subscribers_destroy'])->name('subscribers_destroy');

        //videos
        Route::resource('videos', \App\Http\Controllers\Backend\VideoController::class);

        //settings
        Route::match(['get', 'post'], 'website-settings', [\App\Http\Controllers\Backend\SettingController::class, 'website_settings'])->name('website_settings');

    });



});
