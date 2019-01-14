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

Route::get('/', 'IndexController@index')->name('indexpage');
Route::get('/products/{url}', 'ProductsController@products');
Route::get('/product/{id}', 'ProductsController@product')->name('product');
//Add To Cart Route
Route::match(['get', 'post'], '/add-cart', 'ProductsController@addtoCart')->name('cart');
//Cart Page
Route::match(['get', 'post'], '/cart', 'ProductsController@cart')->name('viewcart');

Route::get('/cart/delete-product/{id}', 'ProductsController@deleteCartProduct')->name('cart.delete');

Route::get('/cart/update-quantity/{id}/{quantity}', 'ProductsController@updateCartQuantity')->name('cartupdate.quantity');

//Get The Product Attribute Price
Route::post('/product/get-product-price', 'ProductsController@getProductPrice');

Route::post('/cart/apply-coupon', 'ProductsController@applyCoupon')->name('apply.coupon');

Route::match(['get', 'post'], '/admin', 'AdminController@login');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => ['auth']], function(){
    Route::get('/admin/dashboard', 'AdminController@dashboard');
    Route::any('/admin/settings', 'AdminController@settings');
    Route::get('/admin/check-pwd', 'AdminController@chkPassword');
    Route::match(['get','post'], '/admin/update-pwd', 'AdminController@updatePassword');

    // Categories Routes (Admin)
    Route::match(['get','post'], '/admin/add-category','CategoryController@addCategory')->name('category.add');
    Route::match(['get','post'], '/admin/edit-category/{id}','CategoryController@editCategory');
    Route::match(['get','post'], '/admin/delete-category/{id}','CategoryController@deleteCategory');
    Route::get('/admin/view-categories', 'CategoryController@viewCategories');


//    Products Routes
    Route::match(['get', 'post'], 'admin/add-product', 'ProductsController@addProduct');
    Route::get('/admin/view-products', 'ProductsController@viewProducts');
    Route::match(['get','post'], '/admin/edit-product/{id}', 'ProductsController@editProduct');
    Route::get('/admin/delete-product-image/{id}', 'ProductsController@deleteProductImage');
    Route::get('/admin/delete-product/{id}', 'ProductsController@deleteProduct');
    Route::get('/admin/delete-alt-image/{id}', 'ProductsController@deleteAltImage');

//    Product Attributes
    Route::match(['get', 'post'], '/admin/add-attribute/{id}', 'ProductsController@addAttributes');
    Route::match(['get', 'post'], '/admin/edit-attribute/{id}', 'ProductsController@editAttributes');
    Route::match(['get', 'post'], '/admin/add-images/{id}', 'ProductsController@addImages');
    Route::get('/admin/delete-attribute/{id}', 'ProductsController@deleteAttribute');

//    Coupons Routes
    Route::match(['get', 'post'], '/admin/add-coupon', 'CouponsController@addCoupon');
    Route::get('/admin/view-coupons', 'CouponsController@viewCoupons')->name('view.coupon');
    Route::match(['get', 'post'], '/admin/edit-coupon/{id}', 'CouponsController@editCoupon')->name('edit.coupon');
    Route::get('/admin/delete-coupon/{id}', 'CouponsController@deleteCoupon')->name('delete.coupon');

});


Route::get('/logout', 'AdminController@logout');
