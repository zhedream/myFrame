<?php

use core\Route;

Route::get('/','app/controllers/IndexController@index');
// 注册
Route::get('/user/regist','app/controllers/UserController@regist');
Route::post('/user/regist','app/controllers/UserController@doregist');
Route::get('/user/active','app/controllers/UserController@active');
// 登陆
Route::get('/user/login','app/controllers/UserController@login');
Route::post('/user/login','app/controllers/UserController@dologin');
// blog
Route::post('/blog/display/{id}','app/controllers/BlogController@increase');
Route::get('/blog/{id}','app/controllers/BlogController@get');





// test
Route::get('/test/redis','app/controllers/TestController@redis');
Route::get('/test/mail','app/controllers/TestController@mail');
Route::get('/test/mysql','app/controllers/TestController@mysql');
Route::get('/test/user/{id}','app/controllers/TestController@user');
// 静态化
Route::get('/test/content2html','app/controllers/TestController@content2html');


?>