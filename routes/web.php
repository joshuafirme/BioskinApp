<?php

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

Route::get('/', function(){
    return view('index');
});

Route::get('/phpinfo', 'DashboardController@phpInfo');

Route::get('/home', 'HomePageController@index');
Route::get('/terms-and-conditions', 'PagesController@termsAndConditions');
Route::get('/about-us', 'PagesController@aboutUs');
Route::get('/contact-us', 'PagesController@contactUs');
Route::get('/not-auth', 'PagesController@notAuth');

Route::get('/read-packaging-name/{id}', 'ProductController@readPackagingNameByID');

Route::middleware('auth')->group(function () {
    Route::middleware('access_rights:1:3:4:5:6:7:8')->group(function () {
        Route::get('/dashboard', 'DashboardController@index');
        Route::get('/manage-order', 'ManageOrderController@index');
        Route::get('/manage-order/read-orders', 'ManageOrderController@readOrders');
        Route::get('/manage-order/read-one-order/{order_id}', 'ManageOrderController@readOneOrder');
        Route::post('/manage-order/change-status/{order_id}', 'ManageOrderController@changeOrderStatus');
        Route::resource('/users', 'UserController');
        Route::post('/users/archive/{id}', 'UserController@archive');
        Route::get('/read-users', 'UserController@readUsers');
        Route::resource('/product', 'ProductController');
        Route::get('/delete-product-cache', 'ProductController@deleteProductCache')->name('delete-product-cache');
        Route::post('/product/archive/{id}', 'ProductController@archive');
        Route::get('/read-product', 'ProductController@readAllProduct');
        Route::post('/delete-image/{id}', 'ProductController@deleteImage');
        Route::resource('/packaging', 'PackagingController');
        Route::get('/delete-packaging-cache', 'PackagingController@deletePackagingCache')->name('delete-packaging-cache');
        Route::resource('/closures', 'ClosuresController');
        Route::get('/read-closures/{packaging_id}', 'ClosuresController@readClosuresByPackaging');
        Route::resource('/size', 'SizeController');
        Route::resource('/variation', 'VariationController');
        Route::resource('/carousel', 'CarouselController');
        Route::resource('/courier', 'CourierController');
        Route::resource('/voucher', 'VoucherController');
    });

    Route::get('/cart', 'CartController@index');
    Route::post('/cart/delete/{id}', 'CartController@removeOneItem');
    Route::get('/cart-count', 'CartController@cartCount');
    Route::get('/read-cart', 'CartController@readCart');
    Route::post('/cart/remove/{ids}', 'CartController@removeItem');
    Route::post('/cart/check-item/{id}', 'CartController@checkItem');
    Route::get('/cart/read-packaging/{sku}', 'CartController@readPackagingName');

    Route::get('/checkout', 'CheckoutController@index');
    Route::get('/read-default-address', 'CheckoutController@readDefaultAddress');
    Route::get('/checkout/read-courier', 'CheckoutController@readCourier');
    Route::get('/validate-voucher', 'CheckoutController@validateVoucher');
    Route::post('/place-order', 'CheckoutController@placeOrder');

    Route::get('/my-purchases', 'MyPurchasesController@index');
    Route::get('/my-purchases/search', 'MyPurchasesController@search');
    Route::get('/my-purchase/{order_id}', 'MyPurchasesController@readOne');
    Route::post('/order/cancel/{order_id}', 'MyPurchasesController@cancelOrder');
    
    Route::post('/paynamics-payment', 'CheckoutController@paynamicsPayment')->name('paynamicsPayment');
    Route::get('/paynamics-notification', 'CheckoutController@paynamicsNotification')->name('paynamicsNotification');
    Route::get('/checkout/paynamics-form', 'CheckoutController@paynamicsForm');
    
    Route::get('/read-order-details/{order_id}', 'ManageOrderController@readOrderDetails');
    

    Route::get('/account', 'AccountController@index');
    Route::post('/account-update', 'AccountController@update');
    Route::post('/account/change-password', 'AccountController@changePassword');
    Route::get('/account/read-addresses', 'AccountController@readAddresses');
    Route::post('/account/add-address', 'AccountController@addAddress');
    Route::post('/account/delete-address/{id}', 'AccountController@deleteAddress');
    Route::post('/account/address-set-default/{id}', 'AccountController@setAddressDefault');
    Route::get('/get-provinces/{region}', 'AccountController@getProvinces');
    Route::get('/get-municipalities', 'AccountController@getMunicipalities');
    Route::get('/get-brgys', 'AccountController@getBrgys');
});

Route::post('/add-to-cart', 'CartController@addToCart');


Route::resource('/category', 'CategoryController');
Route::get('/category/read-one/{id}', 'CategoryController@readCategory');
Route::resource('/subcategory', 'SubcategoryController');
Route::get('/read-subcategory/{category_id}', 'SubcategoryController@readSubcategoryByCategory');
Route::get('/read-price-per-volume/{sku}', 'PackagingController@readPricePerVolume');
Route::post('/remove-price-per-volume', 'PackagingController@removePricePerVolume');

Route::get('/read-category-id/{subcategory_id}', 'ShopController@readCategoryID');

Route::get('/shop', 'ShopController@index');
Route::get('/shop/category/{id}', 'ShopController@categoryProduct');
Route::get('/shop/subcategory/{id}', 'ShopController@categoryProduct');
Route::get('/read-image/{sku}', 'ShopController@readImage');
Route::get('/shop/read-all-product', 'ShopController@readAllProduct');
Route::get('/shop/read-all-category', 'ShopController@readAllCategory');
Route::get('/shop/read-all-packaging', 'ShopController@readAllPackaging');
Route::get('/shop/read-packaging/{subcategory_id}', 'ShopController@readPackagingBySubcategory');
Route::get('/shop/read-images/{sku}', 'ShopController@readImages');
Route::get('/shop/{sku}/{category_name}', 'ShopController@readOneProduct');
Route::get('/shop/read-one/{sku}/{category_name}', 'ShopController@readProductInfoAjax');

Route::get('/rebrand/{sku}/{category_name}', 'ShopController@readRebrandProduct');

Route::get('/read-volumes/{sku}', 'ShopController@readVolumes');
Route::get('/read-price-by-volume', 'ShopController@readOnePriceBySKUAndVolume');
Route::get('/read-packaging/{ids}', 'ShopController@readPackaging');

Route::get('/login', 'UserController@login_view');
Route::get('/logout', 'UserController@logout');
Route::get('/signup', 'UserController@signup_view');
Route::post('/do-login', 'UserController@doLogin');
Route::post('/login-ajax', 'UserController@doLoginAjax');
Route::post('/do-signup', 'UserController@doSignup');