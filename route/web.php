<?php

use core\Route;

Route::get('/','app/controllers/IndexController@index')->name('index');
// 注册
Route::get('/user/regist','app/controllers/UserController@regist')->name('user.reg');
Route::post('/user/regist','app/controllers/UserController@doregist')->name('doregist');
Route::get('/user/active','app/controllers/UserController@active');

// 登陆
Route::get('/user/login','app/controllers/UserController@login')->name('user.login');
Route::get('/user/logout','app/controllers/UserController@logout')->name('user.logout');
Route::get('/user/loging','app/controllers/UserController@loging');
Route::post('/user/login','app/controllers/UserController@dologin');
// blog
Route::get('/blog/display/{id}','app/controllers/BlogController@increase')->name('display');
Route::get('/blog/{id}','app/controllers/BlogController@get');
Route::get('/blog/create','app/controllers/BlogController@create')->name('blog.create');





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
// var_dump(Route::$map);
// var_dump(Route::$gets);
// var_dump(Route::$posts);
// die;
?>