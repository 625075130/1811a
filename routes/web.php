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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/','Index\IndexController@index');
Route::prefix('/index')->group(function (){
    Route::get('admin','Index\IndexController@admin');
});
//商品分组
Route::prefix('goods/')->middleware('checkLogin')->group(function (){
   Route::get('index','Index\GoodsController@index');
   Route::get('goodsinfo/goods_id/{goods_id}','Index\GoodsController@goodsinfo');
    Route::post('talkAdd','Index\GoodsController@talkAdd');
});
//注册  登陆
Route::prefix('login/')->group(function (){
    Route::get('register','Index\LoginController@register');
    Route::post('register_do','Index\LoginController@registerHandle');
    Route::post('sendemail','Index\LoginController@sendemail');
    Route::post('checkname','Index\LoginController@checkname');
    Route::post('checkcode','Index\LoginController@checkcode');
    Route::get('login','Index\LoginController@login');
    Route::post('login_do','Index\LoginController@loginHandle');
    Route::get('loginout','Index\LoginController@loginout');
});
//购物车
Route::prefix('/car')->middleware('checkLogin')->group(function (){
    Route::post('addcar','Index\CarController@addcar');
    Route::get('index','Index\CarController@index');
    Route::post('update','Index\CarController@update');
    Route::post('gettotal','Index\CarController@gettotal');
    Route::post('getcount','Index\CarController@getcount');
    Route::get('conform','Index\CarController@conform');
});
//收货地址
Route::prefix('/address')->middleware('checkLogin')->group(function (){
    Route::get('index','Index\AddressController@index');
    Route::get('add','Index\AddressController@add');
    Route::post('addarea','Index\AddressController@addArea');
    Route::post('addHandle','Index\AddressController@addHandle');
});
//订单
Route::prefix('/order')->middleware('checkLogin')->group(function (){
    Route::post('addOrder','Index\OrderController@addOrder');
    Route::get('successOrder','Index\OrderController@successOrder');
});
//内测
Route::prefix('/shangpin')->group(function(){
	Route::get('add','ShangpinController@create');
	Route::get('list','ShangpinController@index');
	Route::post('add_do','ShangpinController@store');
	Route::get('edit/{id}','ShangpinController@edit');
	Route::post('update/{id}','ShangpinController@update');
	Route::post('del/{shang_id}','ShangpinController@destroy');
	Route::get('xiangqing/{news_id}','ShangpinController@xiangqing');
});