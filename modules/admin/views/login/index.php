<!DOCTYPE HTML>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <script type="application/x-javascript">
    </script>
    <!-- Bootstrap Core CSS -->
    <link href="/assets/adminTemplate/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <!-- Custom CSS -->
    <link href="/assets/adminTemplate/css/style.css" rel='stylesheet' type='text/css' />
    <link href="/assets/adminTemplate/css/font-awesome.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="/assets/adminTemplate/js/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <!--<script src="/assets/adminTemplate/js/bootstrap.min.js"></script>-->
    <style type="text/css">
        html body {font-family: '微软雅黑'}
    </style>
    <script type="text/javascript">
$(window).ready(function() {
    var username = $('input[name=username]');
    var password = $('input[name=password]');
    var submit = $('input[name=submit]');
    var errorinfo = $('.errorinfo');
    username.keyup(function() {
        errorinfo.hide();
    });
    username.blur(function(){
        $.ajax({
            "type": "POST",
            "contentType": "application/x-www-form-urlencoded",
            "url": "/admin/login/checkname",
            "data" : {'username' : username.val()},
            "dataType": "json",
            "success": function (data) {
                if(data == '-1') {//用户名为空
                    errorinfo.show().html('用户名不能为空!');
                }
                if(data == '-2') {//用户名不存在
                    errorinfo.show().html('用户名不存在!');
                }
            }
        });
    });
    submit.click(function(){
        $.ajax({
            "type": "POST",
            "contentType": "application/x-www-form-urlencoded",
            "url": "/admin/login/dologin",
            "data" : {'username' : username.val(),'password' : password.val()},
            "dataType": "json",
            "success": function (data) {
                if(data == '-1') {//用户名为空
                    errorinfo.show().html('用户名不能为空!');
                }
                if(data == '-2') {//密码不能为空
                    errorinfo.show().html('密码不能为空!');
                }
                if(data == '-3') {//用户名不存在
                    errorinfo.show().html('用户名不存在!');
                }
                if(data == '-4') {//密码不正确
                    errorinfo.show().html('密码不正确!');
                }
                if(data == 1) {
                    window.location.href = "/admin/index";
                }
            }
        });
    });
});
    </script>
</head>
<body id="login">
<div class="login-logo">
</div>
<h2 class="form-heading" style="font-size:48px;">传媒发布管理系统</h2>
<div class="app-cam">
    <input type="text" class="text" placeholder="用户名" name="username" />
    <input type="password" placeholder="密码" name="password" />
    <label class="text-danger errorinfo" style="display:none;margin-bottom:10px;"></label>
    <div class="submit">
        <input type="submit" name="submit" value="登录" />
    </div>
    <div class="login-social-link">
        <!--<a href="index.html" class="facebook">
            Facebook
        </a>
        <a href="index.html" class="twitter">
            Twitter
        </a>-->
    </div>
    <ul class="new">
        <!--<li class="new_left"><p><a href="#">Forgot Password ?</a></p></li>
        <li class="new_right"><p class="sign">New here ?<a href="register.html"> Sign Up</a></p></li>-->
        <div class="clearfix"></div>
    </ul>
</div>
<div class="copy_layout login">
    <p>Copyright &copy; 2016 - 2026
    </p>
</div>
</body>
</html>
