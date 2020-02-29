<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \GuzzleHttp\Client;
use App\Model\GithubUserModel;
use App\Model\Login;
class GithubController extends Controller
{
    public function index(){
    	return view('github.index');
    }

    public function callback(){

    	$client=new Client();
    	//echo "登录成功"."<hr>";
    	//print_r($_GET);echo "<hr>";
    	//获取code
    	$code=$_GET['code']; //github给我们code

    	//用code 去githup 获取access_token
    	$uri='https://github.com/login/oauth/access_token';

    	$response=$client->request("POST",$uri,[
    		'headers' => [
    			'Accept'=>'application/json'
    		],

    		'form_params' =>[
    		'client_id'=> env('GITHUB_CLIENT_ID'),
    		'client_secret'=> env('GITHUB_CLIENT_SECRET'),
    		'code'=>$code
    		]
		]);
		$body=$response->getBody();
    	echo $body;

    	$info=json_decode($body,true);
    	//dd($info);
    	$access_token=$info['access_token'];
		//too 使用access_token 获取用户信息
    	$url='https://api.github.com/user';
    	//$client=new Client();
    	$response=$client->request('GET',$url,[
    		'headers' => [
    			'Authorization'=>'OAYTH-TOKEN',
    		],
    		'query'=>[
    			'access_token' =>$access_token['access_token']
    		]
		]);
		$user=$response->getBody();
		//$user_info=json_decode($response->getBody(),true);
		print_r($user);
		$u=GithubUserModel::where(['github_id' => $user['id']])->first();
		if($u){
			echo "欢迎回来";echo "<hr>";
		}else{
			//echo "欢迎新用户";echo "<hr>";

			$u_data=[
			'emali'=>$user['id'],
			];
			$uid=Login::insertGetId($u_data);

			$github_user_info=[
		'github_id' => $user['id'],
		'location' =>$user['location'],
		'emali'=>$user['emali']
		];
		$gid= GithubUserModel::insertGetId($github_user_info);
		//写入用户主表
			$u_info=[

			];
		}

		if($gid>0){

		}else{

		}
		header("location:/center");
		echo "登录成功跳转至个人中心";
    }
}
