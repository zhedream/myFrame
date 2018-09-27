<?php

use core\Route;

// test
Route::get('/test/test', 'app/controllers/IndexController@test');

Route::get('/', 'app/controllers/IndexController@index')->name('index');
Route::get('/index/top', 'app/controllers/IndexController@top')->name('index.top');
Route::get('/index/menu', 'app/controllers/IndexController@menu')->name('index.menu');
Route::get('/index/main', 'app/controllers/IndexController@main')->name('index.main');
// goods
Route::get('/goods/index','app/controllers/GoodsController@index')->name('goods.index'); // 显示列表
Route::get('/goods/search','app/controllers/GoodsController@search')->name('goods.search'); // 搜索
Route::get('/goods/add','app/controllers/GoodsController@add')->name('goods.add'); // 显示 添加
Route::post('/goods/insert','app/controllers/GoodsController@insert')->name('goods.insert'); // 添加
Route::post('/goods/del','app/controllers/GoodsController@del')->name('goods.del'); // 删除
Route::get('/goods/mod','app/controllers/GoodsController@mod')->name('goods.mod'); // 显示 修改
Route::post('/goods/update','app/controllers/GoodsController@update')->name('goods.update'); // 修改
        