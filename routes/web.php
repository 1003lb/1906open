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

Route::any('phpinfo',function(){
	phpinfo();
});
Route::view('/reg','reg');//注册页面    
Route::any('/doreg','Admin\LoginController@doreg');//登录

Route::view('/login','login');//登录页面    路径写/dologin
Route::any('/dologin','Admin\LoginController@dologin');//登录

Route::any('/center','Admin\LoginController@center');//个人中心

//外部调用接口
Route::any('/getAccessToken','Admin\LoginController@getAccessToken');//获取accesstoken

//接口需要access_token验证
Route::any('/api/test','Api\IndexController@test');//获取accesstoken
Route::any('/api/userinfo','Api\IndexController@userInfo');//获取accesstoken

Route::prefix('admin')->middleware('CheckLogin')->group(function(){
Route::any('/index','Admin\AdminController@index');//后台首页
 

 });