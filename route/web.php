<?php

use core\Route;

// test
Route::get('/test/test', 'app/controllers/IndexController@test');

Route::get('/', 'app/controllers/IndexController@index')->name('index');
Route::get('/index/top', 'app/controllers/IndexController@top')->name('index.top');
Route::get('/index/menu', 'app/controllers/IndexController@menu')->name('index.menu');
Route::get('/index/main', 'app/controllers/IndexController@main')->name('index.main');
        
// user
Route::get('/user/index','app/controllers/UserController@index')->name('user.index'); // 显示列表
Route::get('/user/search','app/controllers/UserController@search')->name('user.search'); // 搜索
Route::get('/user/add','app/controllers/UserController@add')->name('user.add'); // 显示 添加
Route::post('/user/insert','app/controllers/UserController@insert')->name('user.insert'); // 添加
Route::get('/user/del/{id}','app/controllers/UserController@del')->name('user.del'); // 删除
Route::get('/user/mod/{id}','app/controllers/UserController@mod')->name('user.mod'); // 显示 修改
Route::post('/user/update/{id}','app/controllers/UserController@update')->name('user.update'); // 修改
        
