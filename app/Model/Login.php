<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Login extends Model
{
     public $primaryKey='id';
   public $table='admin';
   public $timestamps=false;
	//黑名单 表设计中允许为空的
   //protected $guarded = [];	
   
   //生成AppID 规则 根据用户名+时间戳 +随机数 进行MD5
   public static function Appid($name){

    return 'ln'. substr(md5($name.time() . mt_rand(111111,999999)),5,16);

   }
   //生成APP secret
   public static function Secret(){
   	return Str::random(32);
   }
}
