<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
      <title> - 登录</title>
    			<p>还没有注册？<a href="{{url('/reg')}}">点击注册</a></p>
        <form action="{{url('/dologin')}}" method="post"  class="m-t">
           		 @csrf
                公司名<input type="text" name="cname"><br>
                手机号码<input type="text" name="tel"><br>
               邮箱<input type="text" name="emali"><br>
				    <input type="submit" value="登录">
                </form>

</body>
</html>

