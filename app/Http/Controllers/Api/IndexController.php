<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class IndexController extends Controller
{
    public function test(Request $request){

    	//验证token是否可用
			$token=$request->get('token');
			if(empty($token)){
				echo "授权失败 缺少accesstoken";die;
			} 

			$redis_h_key='h:access_token:'.$token;
			$data=Redis::hGetAll($redis_h_key);

			if(empty($data)){
				echo "授权失败 accesstoken无效";die;
			} 
			//var_dump($data);die;
    	$data=[
    		'user_name'=>'yanan',
    		'time'=>date('Y-m-d H:i:s'),
    	];
    	return $data;
    }

    public function userInfo(){

    	
    	$data=[
    		'user_name'=>'yanan',
    		'emali'=>'yanan@qq.com',
    		'age'       => 13,
            'time'      => date('Y-m-d H:i:s')
    	];
    	return $data;
    }
}
