<?php

use core\Route;

Route::get('/','app/controllers/IndexController@index');
Route::get('/user','app/controllers/UserController@index');
Route::get('/blog','app/controllers/BlogController@index');


?>