<?php

use core\Route;

// test
Route::get('/test/test', 'app/controllers/IndexController@test');

Route::get('/', 'app/controllers/IndexController@index')->name('index');
Route::get('/index/top', 'app/controllers/IndexController@top')->name('index.top');
Route::get('/index/menu', 'app/controllers/IndexController@menu')->name('index.menu');
Route::get('/index/main', 'app/controllers/IndexController@main')->name('index.main');
        

// 添加中间件
Route::middleware(['CheckLogin'],function(){
    


// 加锁 开启权限验证
Route::lock(function(){

// user
Route::get('/user/index','app/controllers/UserController@index')->name('user.index'); // 显示列表
Route::get('/user/search','app/controllers/UserController@search')->name('user.search'); // 搜索
Route::get('/user/add','app/controllers/UserController@add')->name('user.add'); // 显示 添加
Route::post('/user/insert','app/controllers/UserController@insert')->name('user.insert'); // 添加
Route::get('/user/del/{id}','app/controllers/UserController@del')->name('user.del'); // 删除
Route::get('/user/mod/{id}','app/controllers/UserController@mod')->name('user.mod'); // 显示 修改
Route::post('/user/update/{id}','app/controllers/UserController@update')->name('user.update'); // 修改

// category
Route::get('/category/index','app/controllers/CategoryController@index')->name('category.index')->lockName('AAA'); // 显示列表
Route::get('/category/search','app/controllers/CategoryController@search')->name('category.search'); // 搜索
Route::get('/category/add','app/controllers/CategoryController@add')->name('category.add'); // 显示 添加
Route::post('/category/insert','app/controllers/CategoryController@insert')->name('category.insert'); // 添加
Route::get('/category/del/{id}','app/controllers/CategoryController@del')->name('category.del'); // 删除
Route::get('/category/mod/{id}','app/controllers/CategoryController@mod')->name('category.mod'); // 显示 修改
Route::post('/category/update/{id}','app/controllers/CategoryController@update')->name('category.update'); // 修改

// brand
Route::get('/brand/index','app/controllers/BrandController@index')->name('brand.index'); // 显示列表
Route::get('/brand/search','app/controllers/BrandController@search')->name('brand.search'); // 搜索
Route::get('/brand/add','app/controllers/BrandController@add')->name('brand.add'); // 显示 添加
Route::post('/brand/insert','app/controllers/BrandController@insert')->name('brand.insert'); // 添加
Route::get('/brand/del/{id}','app/controllers/BrandController@del')->name('brand.del'); // 删除 post
Route::get('/brand/mod/{id}','app/controllers/BrandController@mod')->name('brand.mod'); // 显示 修改
Route::post('/brand/update/{id}','app/controllers/BrandController@update')->name('brand.update'); // 修改

// goods
Route::get('/goods/index','app/controllers/GoodsController@index')->name('goods.index'); // 显示列表
Route::get('/goods/search','app/controllers/GoodsController@search')->name('goods.search'); // 搜索
Route::get('/goods/add','app/controllers/GoodsController@add')->name('goods.add'); // 显示 添加
Route::post('/goods/insert','app/controllers/GoodsController@insert')->name('goods.insert'); // 添加
Route::get('/goods/del/{id}','app/controllers/GoodsController@del')->name('goods.del'); // 删除 post
Route::get('/goods/mod/{id}','app/controllers/GoodsController@mod')->name('goods.mod'); // 显示 修改
Route::post('/goods/update/{id}','app/controllers/GoodsController@update')->name('goods.update'); // 修改

});

});

// var_dump(Route::$gets,Route::$posts);die;


// privilege
Route::get('/privilege/base','app/controllers/PrivilegeController@base')->name('privilege.base'); // 显示列表
Route::get('/privilege/index','app/controllers/PrivilegeController@index')->name('privilege.index'); // 显示列表
Route::get('/privilege/search','app/controllers/PrivilegeController@search')->name('privilege.search'); // 搜索
Route::get('/privilege/add','app/controllers/PrivilegeController@add')->name('privilege.add'); // 显示 添加
Route::post('/privilege/insert','app/controllers/PrivilegeController@insert')->name('privilege.insert'); // 添加
Route::get('/privilege/del/{id}','app/controllers/PrivilegeController@del')->name('privilege.del'); // 删除 post
Route::get('/privilege/mod/{id}','app/controllers/PrivilegeController@mod')->name('privilege.mod'); // 显示 修改
Route::post('/privilege/update/{id}','app/controllers/PrivilegeController@update')->name('privilege.update'); // 修改

// role
Route::get('/role/index','app/controllers/RoleController@index')->name('role.index'); // 显示列表
Route::get('/role/search','app/controllers/RoleController@search')->name('role.search'); // 搜索
Route::get('/role/add','app/controllers/RoleController@add')->name('role.add'); // 显示 添加
Route::post('/role/insert','app/controllers/RoleController@insert')->name('role.insert'); // 添加
Route::get('/role/del/{id}','app/controllers/RoleController@del')->name('role.del'); // 删除 post
Route::get('/role/mod/{id}','app/controllers/RoleController@mod')->name('role.mod'); // 显示 修改
Route::post('/role/update/{id}','app/controllers/RoleController@update')->name('role.update'); // 修改
        
// admin
Route::get('/admin/index','app/controllers/AdminController@index')->name('admin.index'); // 显示列表
Route::get('/admin/search','app/controllers/AdminController@search')->name('admin.search'); // 搜索
Route::get('/admin/add','app/controllers/AdminController@add')->name('admin.add'); // 显示 添加
Route::post('/admin/insert','app/controllers/AdminController@insert')->name('admin.insert'); // 添加
Route::get('/admin/del/{id}','app/controllers/AdminController@del')->name('admin.del'); // 删除 post
Route::get('/admin/mod/{id}','app/controllers/AdminController@mod')->name('admin.mod'); // 显示 修改
Route::post('/admin/update/{id}','app/controllers/AdminController@update')->name('admin.update'); // 修改
        
