<?php

use core\Route;

// test
Route::get('/test/test', 'app/controllers/IndexController@test');

Route::get('/', 'app/controllers/IndexController@index')->name('index');
Route::get('/index/top', 'app/controllers/IndexController@top')->name('index.top');
Route::get('/index/menu', 'app/controllers/IndexController@menu')->name('index.menu');
Route::get('/index/main', 'app/controllers/IndexController@main')->name('index.main');
