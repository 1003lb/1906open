<?php

namespace App\Tools;
use Illuminate\Support\Facades\Cache;
//微信核心类
class Wechat{
const appId="wx0c07147423577602";
const appSerect="f611f1e6030d909b04c00f8371ad11bc";

public static function reponseText($xmlObj,$msg){
            echo "<xml>
          <ToUserName><![CDATA[".$xmlObj->FromUserName."]]></ToUserName>
          <FromUserName><![CDATA[".$xmlObj->ToUserName."]]></FromUserName>
          <CreateTime>".time()."</CreateTime>
          <MsgType><![CDATA[text]]></MsgType>
         <Content><![CDATA[".$msg."]]></Content>
        </xml>";die;
    }

    //获取微信接口数据   access_toke
    //
    public static function getAccessToken(){
    	//先判断是否有数据
		$access_token=Cache::get('access_token');
	//数据之间返回    	
		if(empty($access_token)){
			    	//获取access_token（微信接口调用凭证）
$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".Self::appId."&secret=".Self::appSerect;
		$data=file_get_contents($url);
		$data=json_decode($data,true);
		$access_token=$data['access_token']; //access_token如何存储两小时

		Cache::put('access_token',$access_token,7200);//2小时
		}
    	//没有数据再进去调微信接口获取-》缓存
    	return $access_token;

    }
    public static function getUserInfoByOpenId($openid){
		$access_token=Self::getAccessToken();
		$url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
		$data=file_get_contents($url);
		$data=json_decode($data,true);
		return $data;
    }
//上传素材接口
    public function uploadMedia(){
    	$access_token=Self::getAccessToken();
		//$type="image";
		$url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token."&type=".$data['media_format'];
		$filePathObj = new \CURLFile(public_path()."/".$filePath);//curl发送文件的时候=》CURFIE处理
		//dd($filePath);
		$postData = ['media'=>$filePathObj];
		//dd($postData);
		$res=Curl::post($url,$postData);
		$res=json_decode($res,true);
    }
}
