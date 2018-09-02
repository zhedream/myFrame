<?php

use core\Route;

Route::get('/','app/controllers/IndexController@index');
Route::get('/user','app/controllers/UserController@index');
Route::get('/user/{id}','app/controllers/UserController@user');
Route::get('/user/{id}/{b}','app/controllers/UserController@ab');
Route::get('/blog','app/controllers/BlogController@index');


?>