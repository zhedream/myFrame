<?php

use core\Route;

Route::get('/','app/controllers/IndexController@index');
Route::get('/blog/display/{id}','app/controllers/BlogController@dis');




// test
Route::get('/test/redis','app/controllers/TestController@redis');
Route::get('/test/mysql','app/controllers/TestController@mysql');
Route::get('/test/user/{id}','app/controllers/TestController@user');


?>