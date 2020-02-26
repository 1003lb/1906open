<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
      <title> - 注册</title>
        <h1>注册</h1>
<form action="{{url('/doreg')}}" method="post">
           		 @csrf
                公司名<input type="text" name="name"><br>
                法人<input type="text" name="l_name"><br>
                公司地址<input type="text" name="address"><br>
                联系人电话<input type="text" name="tel"><br>
                邮箱<input type="text" name="emali"><br>
                <input type="submit" value="注册">
                </form>

</body>
</html>

