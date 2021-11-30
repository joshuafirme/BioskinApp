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

Route::get('/home', 'HomePageController@index');

Route::middleware('auth')->group(function () {
    Route::middleware('access_rights:1:3:4')->group(function () {
        Route::resource('/users', 'UserController');
        Route::get('/read-users', 'UserController@readUsers');
        Route::resource('/product', 'ProductController');
        Route::get('/delete-product-cache', 'ProductController@deleteProductCache')->name('delete-product-cache');
        Route::post('/product/archive/{id}', 'ProductController@archive');
        Route::get('/read-product', 'ProductController@readAllProduct');
        Route::post('/delete-image/{id}', 'ProductController@deleteImage');
        Route::resource('/category', 'CategoryController');
        Route::get('/category/read-one/{id}', 'CategoryController@readCategory');
        Route::resource('/subcategory', 'SubcategoryController');
        Route::get('/read-subcategory/{category_id}', 'SubcategoryController@readSubcategoryByCategory');
        Route::resource('/packaging', 'PackagingController');
        Route::get('/delete-packaging-cache', 'PackagingController@deletePackagingCache')->name('delete-packaging-cache');
        Route::resource('/closures', 'ClosuresController');
        Route::get('/read-closures/{packaging_id}', 'ClosuresController@readClosuresByPackaging');
        Route::resource('/size', 'SizeController');
        Route::resource('/variation', 'VariationController');
        Route::resource('/carousel', 'CarouselController');
    });
});
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

Route::get('/login', 'UserController@login_view');
Route::get('/logout', 'UserController@logout');
Route::get('/signup', 'UserController@signup_view');
Route::post('/do-login', 'UserController@doLogin');
Route::post('/do-signup', 'UserController@doSignup');