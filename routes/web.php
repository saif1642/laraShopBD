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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin','AdminController@login');
Route::match(['get','post'],'/admin','AdminController@login');

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/admin/dashboard','AdminController@dashboard');
    Route::get('/admin/setting','AdminController@setting');
    Route::get('/admin/check-pwd','AdminController@checkPassword');
    Route::match(['get','post'],'/admin/update-pwd','AdminController@updatePassword');
    //ADMIN CATEGORY ROUTES
    Route::match(['get','post'],'/admin/add-category','CategoryController@addCategory');
    Route::get('/admin/view-categories','CategoryController@viewCategories');
    Route::match(['get','post'],'/admin/edit-category/{id}','CategoryController@editCategory');
    Route::match(['get','post'],'/admin/delete-category/{id}','CategoryController@deleteCategory');
    //ADMIN PRODUCTS ROUTES
    Route::match(['get','post'],'/admin/add-product','ProductsController@addProduct');
    Route::get('/admin/view-product','ProductsController@viewProducts');
    Route::match(['get','post'],'/admin/edit-product/{id}','ProductsController@editProduct');
});


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'AdminController@logout');
