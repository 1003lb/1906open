<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Login;

	class LoginController extends Controller{
    //注册
    public function doreg(){
    $post=request()->except('_token');
    //dd($post);
  $res=Login::insert($post);
  //dd($res);
  if($res){
    echo "<script>alert('注册成功');location.href='/login'</script>";
  }
    }
    //登录
		public function dologin(){
   $post=request()->except('_token');//接收值
   //dd($post);
  	$user=Login::where($post)->first();//在数据库查询单条数据
	if($user){
	//如果成立
  		session(['user'=>$user]);//用户名存入session
  		request()->session()->save();//session添加到服务端
  		return redirect('/admin/index');//并进行页面跳转

  		}
	}
}
