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

Route::get('/', 'HomePageController@index');

Route::resource('/product', 'ProductController');
Route::post('/product/archive/{id}', 'ProductController@archive');
Route::get('/read-product', 'ProductController@readAllProduct');
Route::post('/delete-image/{id}', 'ProductController@deleteImage');
Route::resource('/category', 'CategoryController');
Route::resource('/subcategory', 'SubcategoryController');
Route::get('/read-subcategory/{category_id}', 'SubcategoryController@readSubcategoryByCategory');
Route::resource('/packaging', 'PackagingController');
Route::resource('/closures', 'ClosuresController');
Route::get('/read-closures/{packaging_id}', 'ClosuresController@readClosuresByPackaging');
Route::resource('/size', 'SizeController');
Route::resource('/variation', 'VariationController');
Route::resource('/carousel', 'CarouselController');

Route::get('/read-price-per-volume/{sku}', 'PackagingController@readPricePerVolume');
Route::post('/remove-price-per-volume', 'PackagingController@removePricePerVolume');

Route::get('/shop', 'ShopController@index');
Route::get('/shop/category/{id}', 'ShopController@categoryProduct');
Route::get('/read-image/{sku}', 'ShopController@readImage');
Route::get('/shop/read-all-product', 'ShopController@readAllProduct');
Route::get('/shop/read-all-category', 'ShopController@readAllCategory');