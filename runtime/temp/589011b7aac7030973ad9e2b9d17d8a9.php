<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"C:\PhpStudy\WWW\live-front\public/../application/index\view\user\login.html";i:1513316597;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>登录/注册</title>
    <link rel="stylesheet" type="text/css" href="/static/css/layui.css" />
    <link rel="stylesheet" type="text/css" href="/static/css/style.css" />
</head>
<body>
<div class="cd-user-modal is-visible">
    <div class="cd-user-modal-container">
        <ul class="cd-switcher">
            <li class="on"><a href="#0">用户登录</a></li>
            <li><a href="#0">注册新用户</a></li>
        </ul>

        <div id="cd-login" class="is-selected"> <!-- 登录表单 -->
            <div class="cd-form">
                <p class="fieldset">
                    <label class="image-replace cd-username" for="signin-username">用户名</label>
                    <input class="full-width has-padding has-border" id="signin-username" type="text" placeholder="输入用户名">
                </p>

                <p class="fieldset">
                    <label class="image-replace cd-password" for="signin-password">密码</label>
                    <input class="full-width has-padding has-border" id="signin-password" style="padding: 12px 20px 12px 10px;" type="password"  placeholder="输入密码">
                </p>



                <p class="fieldset">
                    <input class="full-width2" type="submit" onclick="login()" value="登 录">
                </p>
            </div>
        </div>

        <div id="cd-signup"> <!-- 注册表单 -->
            <div class="cd-form" >
                <p class="fieldset">
                    <label class="image-replace cd-username" for="signup-username">昵称</label>
                    <input class="full-width has-padding has-border" id="signup-username" type="text" placeholder="输入昵称">
                </p>

                <p class="fieldset">
                    <label class="image-replace cd-phone" >手机号</label>
                    <input class="full-width has-padding has-border" id="signup-userphone" type="text" placeholder="输入手机号">
                </p>

                <p class="fieldset">
                    <label class="image-replace cd-phone" for="signup-username">验证码</label>
                    <input class="full-width has-padding has-border" id="signup-usercode" style="width:110px;" type="text" placeholder="输入验证码">
                    <button style="margin-left:20px;" id="smsbtn" class="layui-btn layui-btn-normal" onclick="getCode()">获取验证码</button>
                </p>

                <p class="fieldset">
                    <label class="image-replace cd-password" for="signup-password">密码</label>
                    <input class="full-width has-padding has-border" id="signup-password" type="password"  placeholder="输入密码">
                </p>



                <p class="fieldset">
                    <input class="full-width2" type="submit" onclick="register()" value="注册新用户">
                </p>
            </div>
        </div>

        <a href="#0" class="cd-close-form">关闭</a>
    </div>
</div>
<script type="text/javascript" src="/static/js/jquery.js"></script>
<script type="text/javascript" src="/static/js/validate.js"></script>
<script src="/static/js/login.js"></script>
<script src="/static/js/layer/layer.js"></script>
<script type="text/javascript" src="/static/js/index.js"></script>
<script>

    function register(){

        var uname = $('#signup-username').val();
        var uphone = $('#signup-userphone').val();
        var upwd  = $('#signup-password').val();
        var code  = $('#signup-usercode').val();

        if(uname==''||uname==null){
            layer.msg('用户名不能为空');
            return false;
        }else if(!/^\d{11}$/.test(uphone)){
            layer.msg('手机格式不正确');
            return false;
        }else if(upwd==''||upwd==null){
            layer.msg('密码不能为空');
            return false;
        }else if(!/^\d{4}/.test(code)){
            layer.msg('请输入正确的验证码');
            return false;
        }

        $.post('<?php echo url("User/register"); ?>',{nickname:uname,uname:uphone,upwd:upwd,code:code},function(result){
                result = JSON.parse(result);
                if(result.status=='success'){
                    result = JSON.stringify(result.user);
                    localStorage.setItem('user',result);
                    parent.location.reload();
                }else{
                    layer.msg(result.msg);
                }
        });
    }

    function getCode(){
        var uphone = $('#signup-userphone').val();
        if(!/^\d{11}$/.test(uphone)){
            layer.msg('手机格式不正确');
            return false;
        }else{
            $.post('<?php echo url("Sms/getCode"); ?>',{uphone:uphone},function(result){
                result = JSON.parse(result);
                var i = 60;
                if(result.status=='success'){
                    var t = setInterval(function(){
                        i--;
                        $('#smsbtn').addClass('layui-btn-disabled');
                        $('#smsbtn').attr('disabled',true);
                        $('#smsbtn').html(i+'秒后获取');
                        if(i<=0){
                            $('#smsbtn').removeClass('layui-btn-disabled');
                            $('#smsbtn').attr('disabled',false);
                            $('#smsbtn').html('获取验证码');
                            clearInterval(t);
                        }
                    },1000);
                }else{
                    layer.msg(result.msg);
                }
            });
        }
    }

    function login(){
        var phone = $('#signin-username').val();
        var pwd   = $('#signin-password').val();
        if(!/^\d{11}$/.test(phone)){
            layer.msg('手机号码不正确');
            return false;
        }else if(pwd==''||pwd==null){
            layer.msg('密码不能为空');
            return false;
        }
        $.post('<?php echo url("User/login"); ?>',{uname:phone,upwd:pwd},function(result){
            result = JSON.parse(result);
            if(result.status=='success'){
                result = JSON.stringify(result.user);
                localStorage.setItem('user',result);
                parent.location.reload();
            }else{
                layer.msg(result.msg);
            }
        });
    }
</script>
</body>
</html>