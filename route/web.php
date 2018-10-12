<?php

use core\Route;

// test
Route::get('/test/test', 'app/controllers/IndexController@test');



Route::middleware(['CheckLogin'],function(){

Route::get('/', 'app/controllers/IndexController@index')->name('index');
Route::get('/index/top', 'app/controllers/IndexController@top')->name('index.top');
Route::get('/index/menu', 'app/controllers/IndexController@menu')->name('index.menu');
Route::get('/index/main', 'app/controllers/IndexController@main')->name('index.main');

});

// 添加中间件
Route::middleware(['CheckLogin'],function(){
    

// 加锁 开启权限验证
Route::lock(function(){


});

});

// var_dump(Route::$gets,Route::$posts);die;

        
// index
Route::get('/index/index','app/controllers/IndexController@index')->name('index.index'); // 显示列表
Route::get('/index/search','app/controllers/IndexController@search')->name('index.search'); // 搜索
Route::get('/index/add','app/controllers/IndexController@add')->name('index.add'); // 显示 添加
Route::post('/index/insert','app/controllers/IndexController@insert')->name('index.insert'); // 添加
Route::get('/index/del/{id}','app/controllers/IndexController@del')->name('index.del'); // 删除 post
Route::get('/index/mod/{id}','app/controllers/IndexController@mod')->name('index.mod'); // 显示 修改
Route::post('/index/update/{id}','app/controllers/IndexController@update')->name('index.update'); // 修改
        
