<?php

use core\Route;

Route::get('/','app/controllers/IndexController@index')->name('index');
// 注册
Route::get('/user/regist','app/controllers/UserController@regist')->name('user.regist');
Route::post('/user/regist','app/controllers/UserController@doregist')->name('doregist');
Route::get('/user/active','app/controllers/UserController@active')->name('user.active');

// 登陆
Route::get('/user/login','app/controllers/UserController@login')->name('user.login');
Route::get('/user/logout','app/controllers/UserController@logout')->name('user.logout');
Route::get('/user/loging','app/controllers/UserController@loging')->name('user.loging');
Route::post('/user/login','app/controllers/UserController@dologin');
// blog
Route::get('/blog/display/{id}','app/controllers/BlogController@increase')->name('display');
Route::get('/blog/{id}','app/controllers/BlogController@get');
// 写
Route::get('/blog/create','app/controllers/BlogController@create')->name('blog.create');
Route::post('/blog/create','app/controllers/BlogController@store')->name('blog.store');
// 删
Route::post('/blog/del','app/controllers/BlogController@del')->name('blog.del');
// 改
Route::get('/blog/edit/{id}','app/controllers/BlogController@edit')->name('blog.edit');
Route::post('/blog/edit/{id}','app/controllers/BlogController@doedit')->name('blog.doedit');
// 博客空间
Route::get('/blog/index','app/controllers/BlogController@index')->name('blog.index');

//alipay

// 支付
Route::get('/alipay/pay','app/controllers/AlipayController@pay');
// 回跳
Route::get('/alipay/return','app/controllers/AlipayController@return');
// 通知
Route::post('/alipay/notify','app/controllers/AlipayController@notify');

// Wxpay
// 支付
Route::get('/wxpay/pay','app/controllers/WxpayController@pay');
// 回跳
Route::get('/wxpay/return','app/controllers/WxpayController@return');
// 通知
Route::post('/wxpay/notify','app/controllers/WxpayController@notify');




// test
Route::get('/test/redis','app/controllers/TestController@redis');
Route::get('/test/mail','app/controllers/TestController@mail');
Route::get('/test/mysql','app/controllers/TestController@mysql');
Route::get('/test/user/{id}','app/controllers/TestController@user');
Route::get('/test/routeName/{id}','app/controllers/TestController@routeName')->name('vvvv');
Route::get('/test/makeUrl/{id}','app/controllers/TestController@makeUrl')->name('asd');
Route::get('/test/csrf','app/controllers/TestController@getcsrf')->name('csrf'); // csrf
// 静态化
Route::get('/test/content2html','app/controllers/TestController@content2html');
Route::get('/test/showtable','app/controllers/TestController@showtable');



// var_dump(Route::$map);
// var_dump(Route::$gets);
// var_dump(Route::$posts);
// die;
?>