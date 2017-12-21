<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\phpStudy\WWW\yiqiu\public/../application/index\view\user\m-login.html";i:1513845279;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录/注册</title>
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta content="telephone=no,email=no" name="format-detection">
    <meta name="viewport" content="initial-scale=0.3333333333333333, maximum-scale=0.3333333333333333, minimum-scale=0.3333333333333333, user-scalable=no">
</head>
<link rel="stylesheet" href="/static/css/mobile.css">
<link rel="stylesheet" href="/static/layui/css/layui.css">
<body>
<div class="login-title">
    <a href="javascript:;" onclick="history.back()" class="login-return"></a>
    <a href="/v1/to_register.html?url=http://www.1234tv.com/hys/205197" class="login-reg">注册</a>
    用户登录
</div>
<div class="login-content">
    <ul class="login-from">
        <li>
            <div class="formfile"><i class="icon1"></i> <input type="text" placeholder="用户名" id="username"></div>
        </li>
        <li class="showPswli">
            <div class="formfile"><i class="icon2"></i> <input type="password" placeholder="密码" id="password"></div>
        </li>
        <li class="ma" id="login-yzm" style="display: none;">
            <div class="formfile"><i class="icon3"></i> <input style="width: 3.5rem;" type="text" placeholder="验证码" id="captcha"></div>
            <span><img src="/captcha.html" id="captchaimg"></span> <a href="javascript:;" onclick="change_captcha()">换一张</a>
        </li>
        <div class="login-btn"><a href="javascript:;" onclick="login()">登录</a></div>
    </ul>
</div>
</body>
<script type="text/javascript" src="/static/js/jquery.js"></script>
<script>
    function change_captcha(){
        $('#captchaimg').attr('src','/captcha.html?t='+Math.random());
    }

    function login(){
        var name=$('#username').val();
        var pwd =$('#password').val();
        var yzm = $('#captcha').val();
        if(name.length<=0){
            alert('用户名不能为空');
            return;
        }else if(pwd.length<=0){
            alert('密码不能为空');
            return;
        }
        $.post('/index/User/login',{uname:name,upwd:pwd,yzm:yzm},function(res){
            res = JSON.parse(res);
            if(res.status!='success'){
                alert(res.msg);
            }else{
                location.href='/index/index/index';
            }
        });
    }
</script>
<script>
    (function(doc, win) {
        var dpr, rem, scale;
        var docEl = document.documentElement;
        var metaEl = document.querySelector('meta[name="viewport"]');
        var resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize';


        /*isAndroid = navigator.userAgent.match(/(Android)/) ? true:false;
        isIos = navigator.userAgent.match(/(iPad|iPhone)/) ? true:false;*/
        if (navigator.userAgent.match(/(Android)/)) {
            dpr = 1;
        } else {
            dpr = win.devicePixelRatio || 1;
        }
        scale = 1 / dpr;
// 设置viewport，进行缩放，达到高清效果
        metaEl.setAttribute('content', 'width=device-width,initial-scale=' + scale + ',maximum-scale=' + scale + ', minimum-scale=' + scale + ',user-scalable=no,shrink-to-fit=no');
// 设置data-dpr属性，留作的css hack之用
        docEl.setAttribute('data-dpr', dpr);
        var recalc = function() {
// if (docEl.style.fontSize) return;
            clientWidth = docEl.clientWidth;
// console.log(clientWidth);
            if (!clientWidth) return;
            docEl.style.fontSize = clientWidth / 10 + 'px';
            if (document.body) {
                document.body.style.fontSize = docEl.style.fontSize;
            }
            if (dpr == 1) {
// 动态写入样式
                var fontEl = document.getElementById('init_style');
                var pxscale = clientWidth / 750;
                docEl.firstElementChild.appendChild(fontEl);
                fontEl.innerHTML = '.px-scale{transform:scale(' + pxscale + ') !important;-webkit-transform:scale(' + pxscale + ') !important;}'; //雪碧图缩放
            }
        };
        recalc();

// 给js调用的，某一dpr下rem和px之间的转换函数
        window.rem2px = function(v) {
            v = parseFloat(v);
            return v * rem;
        };
        window.px2rem = function(v) {
            v = parseFloat(v);
            return v / rem;
        };

        window.dpr = dpr;
        window.rem = rem;

        if (!doc.addEventListener) return;
        win.addEventListener(resizeEvt, recalc, false);
        doc.addEventListener('DOMContentLoaded', recalc, false);
// doc.addEventListener('touchstart', function(e) { e.preventDefault();}, false);

    })(document, window);
</script>
</html>