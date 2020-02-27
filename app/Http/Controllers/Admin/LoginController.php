<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Login;
use App\Model\AppModel;
	class LoginController extends Controller{
    //用户注册
    public function doreg(){
      
        //为用户生成AppID与secret
    $name=request()->input('name');
      $post=request()->except('_token');
    //dump($post);
   $res=Login::insert($post);
    //dd($res);
  //写入APP表中

  if($res){
    echo "<script>alert('注册成功');</script>";
  }

   $app_id=Login::Appid($name);
    $app_secret=Login::Secret();
  //写入APP表中
    $app_info=[
      'id' => $id,
      'apps_id'=> $apps_id,
      'apps_secret'=> $apps_secret,
    ];
    $app_id=AppModel::insertGetId($app_info);
    if($app_id>0){
          echo "ok";
        }else{
          echo "内部错误请联系管理员";
      }
    
  echo "用户APPID：".$app_id;echo "<hr>";
  echo "app_secret：".$app_secret;echo "<hr>";
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
