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

Route::prefix('admin')->middleware('CheckLogin')->group(function(){
Route::any('/index','Admin\AdminController@index');//后台首页
 

 });