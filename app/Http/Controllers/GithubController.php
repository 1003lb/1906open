<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \GuzzleHttp\Client;
use App\Model\GithubUserModel as Git;
use App\Model\Login;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie; 
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Redis;
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

		   $git_user=Git::where('github_id','=',$user['id'])->first();
        if($git_user){

        }else{
            $user_email=[
                'l_email'=>$user['email']
            ];
            $reg=Login::insertGetId($user_email);     //把 gitub email 入到user  返回主键id

            $git_user_info=[
                'l_id'=>$reg,                      //user 主键id  入到gitub  表  
                'github_id'=>$user['id'],
                'location'=>$user['location'],
                'email'=>$user['email']
            ];
            $gitub=Git::create($git_user_info);
        }


        //  登录成功 生成token 返回客户端     
        $token=Str::random(16);
        Cookie::queue('token',$token,60);  //存
        //将token存redis
        $redis_key='uesr:token:'.$token;  //redis的key 
        $user_info=[                     //和取的数据对应
            'l_id'=>$git_user['l_id'],
            'time'=>date('Y-m-d H:i:s')
        ];
        Redis::hMset($redis_key,$user_info);   //哈希
        Redis::expire($redis_key,60*60);      //一小时过期

        header('refresh:0;url=/center');
        echo "登陆成功";
        
    }
}
