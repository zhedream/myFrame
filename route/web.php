<?php

use core\Route;

Route::get('/','app/controllers/IndexController@index')->name('index.index');
Route::get('/user','app/controllers/IndexController@user')->name('index.user');
        
