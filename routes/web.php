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
Route::prefix('/test')->group(function (){
    Route::get('/hello','TestController@hello');
    Route::get('/redis1','TestController@redis1');
    Route::get('/www','TestController@www');    //get请求file_get_contents(签名验签)
    Route::get('/send-data','TestController@sendData');
    Route::get('/post-data','TestController@postData');//post请求curl
    Route::get('/encrypt1','TestController@encrypt1'); //对称加密
    Route::get('/rsa/encrypt1','TestController@rsaeEncrypt1'); //非对称加密
    Route::get('/rsa/encrypt2','TestController@rsaeEncrypt2'); //非对称加密
    Route::get('/rsa/rsaSign','TestController@rsaSign'); //非对称加密签名
});

Route::get('/test/sing1','TestController@sing1');//签名
Route::get('/secret','TestController@secret');//签名



Route::get('/user/reg','RegController@reg');//注册
Route::post('/user/regdo','RegController@regdo');//执行注册
Route::get('/user/login','RegController@login');//登录
Route::post('/user/logindo','RegController@logindo');//执行登录
Route::get('/user/create','RegController@create');//个人中心



Route::post('/api/regdo','Api\UserController@regdo');//执行注册
Route::post('/api/logindo','Api\UserController@logindo');//执行注册
Route::post('/api/create','Api\UserController@create');//个人中心
Route::post('/api/orders','Api\UserController@orders')->middleware('check.pri');//订单

Route::get('/api/a','Api\TestController@a')->middleware('check.pri','access.filter');
Route::get('/api/b','Api\TestController@b');
Route::get('/api/c','Api\TestController@c');

Route::middleware('check.pri','access.filter')->group(function(){
    Route::get('/api/x','Api\TestController@x'); //token、防刷中间件
    Route::get('/api/y','Api\TestController@y');
    Route::get('/api/z','Api\TestController@z');
});




Route::get('/goods/detail','Goods\GoodsController@detail');//商品详情
