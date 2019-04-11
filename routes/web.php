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

        //Ví cá nhân
        Route::get('/wallets', 'WalletController@index')->name('wallets.index');

        Route::get('/wallets/create', 'WalletController@create')->name('wallets.create');

        Route::post('/wallets', 'WalletController@store')->name('wallets.store');

        Route::get('wallets/{wallet}/edit', 'WalletController@edit')->name('wallets.edit');

        Route::patch('wallets/{wallet}', 'WalletController@update')->name('wallets.update');

        Route::delete('wallets/{wallet}', 'WalletController@destroy')->name('wallets.destroy');

        Route::get('/transfer/{type}', 'WalletController@getTransfer')->name('wallets.transfer');

        Route::post('/transfer', 'WalletController@postTransfer')->name('wallets.post_transfer');

        Route::post('/transfer/change/user', 'WalletController@changeTransfer')->name('wallets.change_transfer');



        //danh mục cá nhân
        Route::get('/categories', 'CategoryController@index')->name('categories.index');

        Route::get('/categories/create', 'CategoryController@create')->name('categories.create');

        Route::post('/categories', 'CategoryController@store')->name('categories.store');

        Route::get('/categories/{wallet}/edit', 'CategoryController@edit')->name('categories.edit');

        Route::patch('/categories/{wallet}', 'CategoryController@update')->name('categories.update');

        Route::delete('/categories/{wallet}', 'CategoryController@destroy')->name('categories.destroy');

        Route::post('/categories/change/user', 'CategoryController@changeType')->name('wallets.change_type');

        //Giao dịch cá nhân
        Route::get('/transactions', 'TransactionController@index')->name('transactions.index');

        Route::get('/transactions/create', 'TransactionController@create')
                ->name('transactions.create');

        Route::post('/transactions', 'TransactionController@store')->name('transactions.store');

        Route::get('/transactions/{wallet}/edit', 'TransactionController@edit')->name('transactions.edit');

        Route::patch('/transactions/{wallet}', 'TransactionController@update')->name('transactions.update');

        Route::delete('/transactions/{wallet}', 'TransactionController@destroy')->name('transactions.destroy');

        Route::get('/transactions/show/per-day', 'TransactionController@showPerDay')->name('transactions.per-day');

        Route::get('/transactions/show/per-month', 'TransactionController@showPerMonth')->name('transactions.per-month');

        Route::post('/excel', 'TransactionController@excel')->name('transactions.excel');      

    });

});