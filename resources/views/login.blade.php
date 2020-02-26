<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
      <title> - 登录</title>
    
          
            <form action="{{url('/dologin')}}" method="post"  class="m-t">
            @csrf
                用户名<input type="text" name="name"><br>
                密码<input type="password" name="pwd"><br>
                <input type="submit" value="登录">
                </form>

</body>
</html>

