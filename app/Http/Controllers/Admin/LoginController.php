<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Login;
use App\Model\AppModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;
	class LoginController extends Controller{
    //用户注册
    public function doReg(Request $request) 
    {
        $pwd = $request->input('password');
        $pwd1 = $request->input('password1');
        $username = $request->input('username');
        if($pwd != $pwd1){
            echo "<script>alert('密码与确认密码不一致'); window.history.back(-1); </script>";

        }
        $pwd = password_hash($pwd,PASSWORD_BCRYPT);
        $data = [
            'cname' => $request->input('cname'),
            'username' => $username,
            'password' => $pwd,
           
            'address' => $request->input('address'),
            'tel' => $request->input('tel'),
            'emali' => $request->input('emali'),
        ];
       
        dump($data);
        $uid = Login::insertGetId($data);
  

        if($uid>0){
           echo "注册成功";
            echo "<script>alert('注册成功',location='/login')</script>";
        }else{
            echo "注册失败";
           // echo "<script>alert('注册失败',location='/reg')</script>";
        }

        // 为用户生成APPID SECRET
        $app_id = Login::Appid($username);
        $app_secret = Login::Secret();
        // 写入app表中
        $app_info = [
            'uid'       => $uid,
            'app_id'     => $app_id,
            'app_secret'    => $app_secret,
        ]; 
        $app_id = AppModel::insertGetId($app_info);
        if($app_id){
          echo "ok"."<br>";
        }else{
          echo "no";
        }
        echo "APPID：".$app_id."<hr>";
        echo "secret:".$app_secret;
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
    

      $token=Str::random(16);//测试token给客户端

      Cookie::queue('token',$token,60);
      //将token保存到Redis中
      $redis_h_token='h:token:'.$token; //h:token:XIB1MVhRRl9F5PEp

      $login_info=[
      'uid'=> $user->id,
      'user_name'=>$user->user_name,
      'cname'=>$user->cname,
      'login_time'=>time(),
      ];
      Redis::hMset($redis_h_token,$login_info);
      Redis::expire($redis_h_token,60*60);
          echo "登录成功";
  		return redirect('/center');//并进行页面跳转

  		}
	}
  public function center(){
    //echo "欢迎来到个人中心:";echo "<hr>";
    $token=Cookie::get('token');
    //print_r($token);echo "<hr>";

       if(empty($token)){
            echo "<script>alert('请先去登陆');location='/login'</script>";
        }
    //拿到token拼接redis key
    $redis_h_token='h:token:'.$token;
    //echo $key=$redis_h_token;echo "<hr>";

    $login_info=Redis::hgetAll($redis_h_token);
    //print_r($login_info);echo "<br>";

    //获取用户APP应用信息
   $app_info=AppModel::where(['uid'=>$login_info['uid']])->first();

    //dump($app_info);
    //$arr=$app_info;
    //var_dump($app_info);
   echo "欢迎来到个人中心:".$login_info['user_name'];echo "<br>";
    echo "APPID:".$app_info['app_id']."<hr>";
    echo "APPSECRET:".$app_info['app_secret']."<hr>";

  }
//获取accesstoken 记录有效起
  public function getAccessToken(Request $request){
    //print_r($_GET);echo "<br>";

   
    $app_id=$request->get('app_id');
    $app_secret=$request->get('app_secret');

     if(empty($app_secret) || empty($app_id)){
        echo "缺少参数";die;
    }
    //echo 'app_id:'.$app_id;echo "<br>";
    //echo 'app_secret:'.$app_secret;echo "<br>";

    //为用户生成accessToken 供后续接口调用
    $str=$app_id.$app_secret.time().mt_rand().Str::random(16);
    //echo "str:".$str;echo "<br>";
    $access_token=sha1($str).md5($str);
    //echo 'access_token:'.$access_token;echo "<br>";

    $redis_h_key='h:access_token:'.$access_token;
    //echo $redis_h_key;echo "<br>";

    $app_info=[
        'app_id'=>$app_id,
        'addtime'=>date('Y-m-d H:i:s'),
    ];

    Redis::hMset($redis_h_key,$app_info);
    Redis::expire($redis_h_key,7200);

    $response=[
    'error'=>0,
    'access_token'=>$access_token,
    'expire'=>7200,
    ];
    return  $response;

  

 

  }
}
