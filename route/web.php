<?php

use core\Route;

// test
Route::get('/test/test', 'app/controllers/IndexController@test');



Route::get('/', 'app/controllers/IndexController@index')->name('index');

Route::middleware(['CheckLogin'],function(){
    Route::get('/index/index','app/controllers/IndexController@index')->name('index.index'); // 显示首页

});

Route::get('/user/login','app/controllers/UserController@login')->name('user.login'); // 登陆
Route::post('/user/login','app/controllers/UserController@dologin')->name('user.dologin'); // 登陆

Route::get('/user/reg','app/controllers/UserController@reg')->name('user.reg'); // 注册
Route::post('/user/reg','app/controllers/UserController@doreg')->name('user.doreg'); // 注册
// code
Route::get('/code/Captcha','app/controllers/CodeController@getCaptcha')->name('code.Captcha'); // 验证码
        
        
