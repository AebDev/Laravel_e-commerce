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

use Gloudemans\Shoppingcart\Cart;
use Gloudemans\Shoppingcart\Facades\Cart as GloudemansCart;

// product
Route::get('/boutique/{slug}','ProductController@show')->name('products.show');
Route::get('/boutique', 'ProductController@index')->name('products.index');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/search', 'ProductController@search')->name('products.search');

// cart
Route::group(['middleware' => ['auth']],function ()
{
    Route::get('/panier','CartController@index')->name('cart.index');
    Route::post('/panier/ajouter','CartController@store')->name('cart.store');
    Route::patch('/panier/{rowId}','CartController@update')->name('cart.update');
    Route::delete('/panier/{rowId}','CartController@destroy')->name('cart.destroy');
    Route::post('/coupon','CartController@storeCoupon')->name('cart.store.coupon');
    Route::delete('/coupon','CartController@destroyCoupon')->name('cart.destroy.coupon');
});





// checkout
Route::group(['middleware' => ['auth']],function () {
    Route::get('/paiement','CheckoutController@index')->name('checkout.index');
    Route::post('/paiement','CheckoutController@store')->name('checkout.store');
    Route::get('/merci','CheckoutController@thankyou')->name('checkout.thankyou');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
