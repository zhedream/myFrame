<?php

use core\Route;

// test
Route::get('/test/test', 'app/controllers/IndexController@test');

Route::get('/chat', 'app/controllers/ChatController@index')->name('chat.index'); // 首页
Route::get('/', 'app/controllers/IndexController@chat')->name('index.chat'); // 首页

// code
Route::get('/code/Captcha','app/controllers/CodeController@getCaptcha')->name('code.Captcha'); // 验证码
    
Route::get('/user','app/controllers/IndexController@user')->name('index.user');
        
