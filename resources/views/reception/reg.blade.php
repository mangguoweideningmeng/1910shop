<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>前台用户注册</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
​<center><h2>前台用户注册</h2></center>

<form class="form-horizontal" role="form" action="{{url('/user/regdo')}}" method='post' enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">用户名</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="firstname"
                   placeholder="请输入用户名" name='user_name'>

        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">邮箱</label>
        <div class="col-sm-8">
            <input type="email" class="form-control" id="firstname"
                   placeholder="请输入邮箱" name='email'>

        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">密码</label>
        <div class="col-sm-8">
            <input type="password" class="form-control" id="lastname"
                   placeholder="请输入密码" name='password'>

        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">确认密码</label>
        <div class="col-sm-8">
            <input type="password" class="form-control" id="lastname"
                   placeholder="确认密码" name='passwords'>

        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">注册</button>
        </div>
    </div>

