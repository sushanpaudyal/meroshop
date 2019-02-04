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

Route::match(['get', 'post'], '/check-email', 'UsersController@checkEmail');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Register/Login

Route::get('/login-register', 'UsersController@userLoginregister');
Route::post('/user-register', 'UsersController@register');


Route::post('/user-login', 'UsersController@login');


//User Logout
Route::get('/user-logout', 'UsersController@logout');


Route::group(['middleware' => ['frontlogin']], function(){
    Route::match(['get', 'post'], '/account', 'UsersController@account');

    Route::post('check-user-pwd', 'UsersController@chkUserPassword');

    Route::post('/update-user-pwd','UsersController@updatePassword');

    Route::match(['get', 'post'], '/checkout', 'ProductsController@checkout');

    Route::match(['get','post'],'/order-review','ProductsController@orderReview')->name('orderreview');

    Route::match(['get','post'],'/place-order','ProductsController@placeOrder');

    Route::get('/thanks','ProductsController@thanks')->name('thanks');

    Route::get('/orders','ProductsController@userOrders')->name('orders');

    Route::get('/orders/{id}','ProductsController@userOrderDetails');

    Route::get('/paypal','ProductsController@paypal')->name('paypal');

});

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

//    Banner Routes
    Route::match(['get', 'post'] , '/admin/add-banner', 'BannersController@addBanner')->name('add.banner');
    Route::get('/admin/view-banners', 'BannersController@viewBanner')->name('view.banner');
    Route::match(['get', 'post'], '/admin/edit-banner/{id}', 'BannersController@editBanner')->name('edit.banner');
    Route::get('/admin/delete-banner/{id}', 'BannersController@deleteBanner')->name('delete.banner');
});


Route::get('/logout', 'AdminController@logout');
