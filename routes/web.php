<?php

Route::namespace('Home')->group(function () {


    Route::get('/', 'IndexController@index');
    Route::any('register', 'MemberController@register');
    Route::any('register_do', 'MemberController@register_do');
    Route::any('login', 'MemberController@login');
    Route::any('login_do', 'MemberController@login_do');

    Route::post('paysuc', 'OrderController@paysuc');

    Route::get('callback','OrderController@callback');
});

Route::group(['namespace' => 'Home','middleware' => 'auth'], function () {

    Route::any('logout', 'MemberController@logout');

    Route::post('addCart', 'CartController@addCart');
    Route::get('showCart', 'CartController@showCart');
    Route::post('delCart', 'CartController@delCart');
    Route::post('clearCart', 'CartController@clearCart');

    Route::post('changeDeli', 'CartController@changeDeli');
    Route::get('checkout', 'CartController@checkout');
    Route::any('order', 'OrderController@order');
    //如果前端使用jquery ajax 这儿必须使用post，不能使用any,larant
    Route::post('deliveryFeeAndCardFee', 'OrderController@deliveryFeeAndCardFee');


    Route::any('returnUrl/{id}', 'OrderController@returnUrl');
    Route::any('cancel_return/{id}', 'OrderController@cancel_return');
    Route::get('retry_paypal/{id}', 'MemberController@retry_paypal');

    Route::get('password', 'MemberController@password');
    Route::post('password_do', 'MemberController@password_do');

    Route::get('profile', 'MemberController@profile');
    Route::post('profile_do', 'MemberController@profile_do');


    Route::get('myorders', 'MemberController@myorders');
    Route::get('vieworder/{id}', 'MemberController@vieworder');
});





