<?php

use Illuminate\Http\Request;

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

# API for page

# user
Route::group(['prefix' => 'user'], function () {
	# frontend neccessary
	Route::group(['middleware' => ['api.verify']], function(){
		Route::post('login', 'Rest\UserController@login');
		Route::post('ssttt', 'Rest\UserController@inject_verifying_account');
		Route::post('/', 'Rest\UserController@store');
	});
	
	# user actions
	Route::group(['middleware' => ['jwt.verify']], function(){
		Route::put('/', 'Rest\UserController@update');
		Route::get('logout', 'Rest\UserController@logout');
		
		# user address
		Route::group(['prefix' => 'address'], function () {
			Route::get('/', 'Rest\UserController@get_address');
			Route::post('/', 'Rest\UserController@store_address');
			Route::put('{id}', 'Rest\UserController@update_address');
			Route::put('{id}/as-shipping-address', 'Rest\UserController@make_shipping_address');
			Route::delete('{id}', 'Rest\UserController@delete_address');
		});

		# user wishlist
		Route::group(['prefix' => 'wishlist'], function () {
			Route::post('/', 'Rest\WishlistController@add');
			Route::delete('{id}', 'Rest\WishlistController@remove');
		});
	});
	
	# backend neccessary
	Route::get('all', 'Rest\UserController@get_all');
	Route::get('{id}', 'Rest\UserController@show');
	Route::delete('{id}', 'Rest\UserController@delete');
});

# catalog
Route::group(['prefix' => 'catalog'], function () {
	# frontend neccessary
	Route::group(['middleware' => ['api.verify']], function(){
		Route::get('all', 'Rest\CatalogController@get_all');
		Route::get('{slug}', 'Rest\CatalogController@detail');
	});
	
	# backend neccessary
	Route::get('get/{id}', 'Rest\CatalogController@show');
	Route::post('/', 'Rest\CatalogController@store');
	Route::put('{id}', 'Rest\CatalogController@update');
	Route::delete('{id}', 'Rest\CatalogController@delete');
});

# category
Route::group(['prefix' => 'category'], function () {
	# frontend neccessary
	Route::group(['middleware' => ['api.verify']], function(){
		Route::get('all', 'Rest\CategoryController@get_all')->middleware('api.verify');
		Route::get('pinned', 'Rest\CategoryController@get_pinned')->middleware('api.verify');
	});

	# backend neccessary
	Route::get('{id}', 'Rest\CategoryController@show');
	Route::post('/', 'Rest\CategoryController@store');
	Route::put('{id}', 'Rest\CategoryController@update');
	Route::put('{id}/pinned', 'Rest\CategoryController@pinned');
	Route::delete('{id}', 'Rest\CategoryController@delete');
});

# payment
Route::group(['prefix' => 'payment'], function () {
	# user actions
	Route::group(['middleware' => ['jwt.verify']], function(){
		Route::post('make', 'Rest\PaymentController@make');
	});

	Route::match(['get', 'post'], 'notify', 'Rest\PaymentController@notify');
});

# article
Route::group(['prefix' => 'article'], function () {
	Route::get('all', 'Rest\ArticleController@get_all');
	Route::get('{id}', 'Rest\ArticleController@read');

	Route::post('/', 'Rest\ArticleController@store');
	Route::put('{id}', 'Rest\ArticleController@update');
	Route::delete('{id}', 'Rest\ArticleController@delete');
});