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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/','IndexController@index');

//Route::get('/admin','AdminController@login');
Route::match(['get','post'],'/admin','AdminController@login');
//Category Listing page
Route::get('/products/{url}','ProductsController@productWithCategoryURL');

//Product Detail Page
Route::get('product/{id}','ProductsController@product');

//Get Product Attributes Price 
Route::get('/get-product-price','ProductsController@getProductPrice');

//Add to cart Route
Route::match(['get','post'],'/add-cart','ProductsController@addCart');
Route::match(['get', 'post'], '/cart','ProductsController@cart');

//Delete to cart item
Route::get('/cart/delete-product/{id}','ProductsController@deleteCartProduct');

//Update Quantity
Route::get('/cart/update-quantity/{id}/{quantity}','ProductsController@updateCartQuantity');



Auth::routes();

Route::group(['middleware' => ['auth']], function() {
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
    Route::get('/admin/delete-product-image/{id}','ProductsController@deleteProductImage');
    Route::get('/admin/delete-alt-image/{id}','ProductsController@deleteAltImage');
    Route::get('/admin/delete-product/{id}','ProductsController@deleteProduct');

    //PRODUCT ATTRIIBUTE ROUTE
    Route::match(['get','post'],'admin/add-attributes/{id}','ProductsController@addAttributes');
    Route::match(['get','post'],'admin/edit-attributes/{id}','ProductsController@editAttributes');
    Route::get('/admin/delete-attributes/{id}','ProductsController@deleteAttributes');
    

    //ADD PRODUCT MULTIPLE IMAGE
    Route::match(['get','post'],'admin/add-images/{id}','ProductsController@addImages');

    //ADD Coupon CODE Function
    Route::match(['get','post'],'/admin/add-coupon','CouponsController@addCoupon');
    Route::get('admin/view-coupons','CouponsController@viewCoupons');
    Route::match(['get','post'],'/admin/edit-coupon/{id}','CouponsController@editCoupon');
    Route::get('/admin/delete-coupon/{id}','CouponsController@deleteCoupon');


});


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'AdminController@logout');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
