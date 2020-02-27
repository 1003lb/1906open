<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
      <title> - 注册</title>
 <form class="form-horizontal" role="form" action="{{url('/doreg')}}" method="post" enctype="multipart/form-data">
        @csrf
            <label for="firstname" class="col-sm-2 control-label">公司名称</label>
            
                <input type="text" name="cname" class="form-control" id="firstname" placeholder="请输入公司名称"><br>
           
            <label for="lastname" class="col-sm-2 control-label">法人</label>
          
                <input type="text" name="people" class="form-control" id="lastname" placeholder="请输入法人"><br>
           
            <label for="firstname" class="col-sm-2 control-label">用户名</label>
      
                <input type="text" name="username" class="form-control" id="firstname" placeholder="请输入用户名"><br>
     
            <label for="lastname" class="col-sm-2 control-label">密码</label>
         
                <input type="password" name="password" class="form-control" id="lastname" placeholder="请输入密码"><br>
         
            <label for="lastname" class="col-sm-2 control-label">确认密码</label>
          
                <input type="password" name="password1" class="form-control" id="lastname" placeholder="确认密码"><br>
         
            <label for="firstname" class="col-sm-2 control-label">公司地址</label>
         
                <input type="text" name="address" class="form-control" id="firstname" placeholder="请输入公司地址"><br>
          
      
            <label for="lastname" class="col-sm-2 control-label">联系人电话</label>
          
                <input type="tel" name="tel" class="form-control" id="lastname" placeholder="请输入法电话">
          <br>
            <label for="firstname" class="col-sm-2 control-label">email</label>
     
                <input type="email" name="email" class="form-control" id="firstname" placeholder="请输入公司邮箱"><br>
          
                <input type="submit" class="btn btn-default" value="注册">
         
    </form>
</body>
</html>

