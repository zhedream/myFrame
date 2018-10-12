<?php

use core\Route;

// test
Route::get('/test/test', 'app/controllers/IndexController@test');



Route::get('/', 'app/controllers/IndexController@index')->name('index');

Route::middleware(['CheckLogin'],function(){
    Route::get('/index/index','app/controllers/IndexController@index')->name('index.index'); // 显示首页

});

Route::get('/user/login','app/controllers/UserController@login')->name('user.login'); // 显示 登陆

Route::middleware(['PassErrTime'],function(){
    Route::post('/user/login','app/controllers/UserController@dologin')->name('user.dologin'); // 登陆
});


Route::get('/user/reg','app/controllers/UserController@reg')->name('user.reg'); // 邮箱注册
Route::get('/user/reg2','app/controllers/UserController@reg2')->name('user.reg2'); // 手机注册
Route::post('/user/sendsms','app/controllers/UserController@sendsms')->name('user.sendsms'); // 手机注册

Route::post('/user/reg','app/controllers/UserController@doreg')->name('user.doreg'); // 注册
Route::post('/user/reg2','app/controllers/UserController@doreg2')->name('user.doreg2'); // 注册
// code
Route::get('/code/Captcha','app/controllers/CodeController@getCaptcha')->name('code.Captcha'); // 验证码
    
// article
Route::get('/article/index','app/controllers/ArticleController@index')->name('article.index'); // 显示列表
Route::get('/article/search','app/controllers/ArticleController@search')->name('article.search'); // 搜索
Route::get('/article/add','app/controllers/ArticleController@add')->name('article.add'); // 显示 添加
Route::post('/article/insert','app/controllers/ArticleController@insert')->name('article.insert'); // 添加
Route::get('/article/del/{id}','app/controllers/ArticleController@del')->name('article.del'); // 删除 post
Route::get('/article/mod/{id}','app/controllers/ArticleController@mod')->name('article.mod'); // 显示 修改
Route::post('/article/update/{id}','app/controllers/ArticleController@update')->name('article.update'); // 修改
