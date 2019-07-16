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
Route::group(['prefix' => 'user'], function () {
	Route::post('login', 'Rest\UserController@login');
	Route::get('logout', 'Rest\UserController@logout');

	Route::get('all', 'Rest\UserController@get_all');
	Route::get('{id}', 'Rest\UserController@show');
	Route::post('/', 'Rest\UserController@store');
	Route::put('{id}', 'Rest\UserController@update');
	Route::delete('{id}', 'Rest\UserController@delete');
});

Route::group(['prefix' => 'catalog'], function () {
	Route::get('all', 'Rest\CatalogController@get_all');
	Route::get('{id}', 'Rest\CatalogController@show');

	Route::post('/', 'Rest\CatalogController@store');
	Route::put('{id}', 'Rest\CatalogController@update');
	Route::delete('{id}', 'Rest\CatalogController@delete');
});

Route::group(['prefix' => 'category'], function () {
	Route::get('all', 'Rest\CategoryController@get_all');
	Route::get('pinned', 'Rest\CategoryController@get_pinned');
	Route::get('{id}', 'Rest\CategoryController@show');

	Route::post('/', 'Rest\CategoryController@store');
	Route::put('{id}', 'Rest\CategoryController@update');
	Route::put('{id}/pinned', 'Rest\CategoryController@pinned');
	Route::delete('{id}', 'Rest\CategoryController@delete');
});

Route::group(['prefix' => 'payment'], function () {
	Route::post('make', 'Rest\PaymentController@make');
});

Route::group(['prefix' => 'article'], function () {
	Route::get('all', 'Rest\ArticleController@get_all');
	Route::get('{id}', 'Rest\ArticleController@read');

	Route::post('/', 'Rest\ArticleController@store');
	Route::put('{id}', 'Rest\ArticleController@update');
	Route::delete('{id}', 'Rest\ArticleController@delete');
});