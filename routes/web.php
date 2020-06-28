<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test/hello','TestController@hello');
Route::get('/test/redis1','TestController@redis1');


Route::get('/user/reg','RegController@reg');//注册
Route::post('/user/regdo','RegController@regdo');//执行注册
Route::get('/user/login','RegController@login');//登录
Route::post('/user/logindo','RegController@logindo');//执行登录
Route::get('/user/create','RegController@create');//个人中心



Route::post('/api/regdo','Api\UserController@regdo');//执行注册
Route::post('/api/logindo','Api\UserController@logindo');//执行注册
Route::post('/api/create','Api\UserController@create');//个人中心
Route::post('/api/orders','Api\UserController@orders')->middleware('check.pri');//订单



Route::get('/goods/detail','Goods\GoodsController@detail');//商品详情
