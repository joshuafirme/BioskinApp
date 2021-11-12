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