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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::post('/add-to-cart', 'CartController@addProduct');
Route::post('/clear-cart', 'CartController@removeAll');
Route::post('/clear-one', 'CartController@removeOne');
Route::post('/minus-cart-product', 'CartController@minusOneProduct');
Route::post('/plus-cart-product', 'CartController@plusOneProduct');
Route::get('/checkout', 'CartController@checkout');
Route::post('/choose-nparea', 'CartController@getNpCities');  //ajax - checkout.blade.php
Route::post('/choose-npcity', 'CartController@getNpWarehouses');  //ajax - checkout.blade.php
Route::post('/buy', 'CartController@buy');
Route::post('/add-review', 'ReviewController@addReview');
Route::get('/product/{slug}', 'HomeController@showProduct');     //web/page/show.blade.php - один продукт
Route::get('/category/{id}', 'Admin\CategoryController@show');   //web/page/category.blade.php - все продукты по категории
Route::get('/delivery-details', 'HomeController@deliveryDetails');
Route::get('/contacts', 'ContactUSController@contacts');
Route::post('/send-mail', 'ContactUSController@sendContactMail');
Route::get('/filtered-products', 'Admin\ProductController@filteredProducts');
Route::get('/brand/{id}', 'Admin\BrandController@show');   //web/page/brand.blade.php - все продукты по бренду


Route::get('/search', 'Admin\ProductController@search');

//User pages
Route::group(['prefix'=>'profile'], function(){

	Route::get('/', 'ProfileController@profilePage');
	Route::get('/my-history', 'ProfileController@userHistory');
	Route::get('/change-password', 'ProfileController@changePassword');
	Route::post('/update-password', 'ProfileController@updatePassword');
	Route::get('/profile-details', 'ProfileController@index');
	Route::put('/edit-profile-details', 'ProfileController@update');  
	Route::resource('/wishlist', 'WishlistController', ['except' => ['create', 'edit', 'show', 'update']]);
	Route::post('/delete-product', 'WishlistController@deleteWishProduct');  //ajax - admin-script.js
	Route::get('/my-reviews', 'ProfileController@userReview');

});


//Admin pages
Route::group([
	'prefix'=>'admin',
	'namespace'=>'Admin',
	'middleware'=>['auth', 'admin']
], function(){
	Route::get('/', 'AdminController@index');
	Route::resource('/users', 'UserController');	
	Route::resource('/brand', 'BrandController');
	Route::resource('/category', 'CategoryController');
	Route::post('/title-categories', 'CategoryController@titleCategories');


	Route::resource('/product', 'ProductController');
	Route::post('/edit-hit', 'ProductController@editHit');
	Route::post('/edit-status', 'ProductController@editStatus');
	Route::post('/delete-product', 'ProductController@deleteProduct');  //ajax - admin-script.js
	Route::post('/update-price', 'ProductController@updatePrice');
	Route::get('/review/product/{id}', 'ProductController@showProductReview');    //admin/review/productReviews.blade.php
	Route::get('/review/user/{id}', 'UserController@userReviews');    //admin/review/userReviews.blade.php

	Route::post('/edit-club-member', 'UserController@editClubMember');

	Route::resource('/order', 'OrderController');
	Route::post('/order-status', 'OrderController@orderStatus');
	Route::get('/order/user/{id}', 'OrderController@userHistory');
	Route::post('/order-details', 'OrderController@orderDetails');
	Route::resource('/discount', 'DiscountController');
	Route::post('/category-detailed', 'CategoryController@categoryList');

	

});

	Route::get('/admin/review', 'ReviewController@index');     //admin/review/index.blade.php

