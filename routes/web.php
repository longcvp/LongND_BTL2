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
//login logout

Route::get('/login', 'AuthController@getLogin')->name('login.index');

Route::get('/logout', 'AuthController@getLogOut')->name('logout');

Route::post('/login', 'AuthController@postLogin')->name('login');

Route::get('/signup', 'AuthController@getSignup')->name('signup.index');

Route::post('/signup', 'AuthController@postSignup')->name('signup');

Route::get('/reset', 'AuthController@getReset')->name('reset.index');

Route::post('/reset', 'AuthController@postReset')->name('reset');

Route::get('/auth/login/{token}', 'AuthController@authToken')->name('auth.active');

//users
Route::group(['middleware' => 'auth'], function() {

    Route::group(['middleware' => 'active'], function() {
        Route::get('/', 'UserController@index')->name('users.index');

        Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');

        Route::patch('users/{user}', 'UserController@update')->name('users.update');

        Route::get('/password/reset/{user}', 'AuthController@getResetPassword')->name('password.show');

        Route::post('/password/reset/{user}', 'AuthController@postResetPassword')->name('password.request');

        Route::get('/wallets', 'WalletController@index')->name('wallets.index');

        Route::get('/wallets/create', 'WalletController@create')->name('wallets.create');

        Route::post('/wallets', 'WalletController@store')->name('wallets.store');

        Route::get('wallets/{wallet}/edit', 'WalletController@edit')->name('wallets.edit');

        Route::patch('wallets/{wallet}', 'WalletController@update')->name('wallets.update');

        Route::delete('wallets/{wallet}', 'WalletController@destroy')->name('wallets.destroy');

        Route::get('transfer', 'WalletController@getTransfer')->name('wallets.transfer');

        Route::post('transfer', 'WalletController@postTransfer')->name('wallets.post_transfer');

        Route::post('transfer/change/user', 'WalletController@changeTransfer')->name('wallets.change_transfer');

        Route::get('/categories', 'CategoryController@index')->name('categories.index');

        Route::get('/categories/create', 'CategoryController@create')->name('categories.create');

        Route::post('/categories', 'CategoryController@store')->name('categories.store');

        Route::get('categories/{wallet}/edit', 'CategoryController@edit')->name('categories.edit');

        Route::patch('categories/{wallet}', 'CategoryController@update')->name('categories.update');

        Route::delete('categories/{wallet}', 'CategoryController@destroy')->name('categories.destroy');

    });

});