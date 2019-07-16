<?php

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
# login page
Route::get('login', 'HomepageController@login')->name('login')->middleware('guest');
Route::post('login', 'LoginController@login')->middleware('guest');

Route::group(['middleware' => ['auth']], function () {
    # dashboard / homepage
    Route::get('/', 'HomepageController@index');

    # logout
    Route::get('logout', 'LoginController@logout');
    
    # catalog
    Route::get('catalog', 'HomepageController@catalog');
    Route::get('catalog/image/{file?}/{size?}', 'Rest\CatalogController@generate_image');

    # category
    Route::get('category', 'HomepageController@category');
});