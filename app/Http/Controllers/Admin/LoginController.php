<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Login;
class LoginController extends Controller
{
   $post=request()->except('_token');//接收值
  	$user=Login::where($post)->first();//在数据库查询单条数据
	if($user){
	//如果成立
  		session(['user'=>$user]);//用户名存入session
  		request()->session()->save();//session添加到服务端
  		return redirect('/admin/index');//并进行页面跳转

  	}

}
