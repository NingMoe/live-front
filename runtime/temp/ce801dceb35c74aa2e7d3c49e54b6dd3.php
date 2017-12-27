<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\phpStudy\WWW\yiqiu\public/../application/index\view\index\mobile.html";i:1514355024;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.5" />
    <title>Title</title>
    <link rel="stylesheet" href="/static/css/mobile.css">
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link href="/static/css/face.css" rel="stylesheet" />
    <link rel="stylesheet" href="/static/css/index.css">
</head>
<body>
<div class="main">
    <div class="head">
        <a class="logo" href="/">
            <img style="margin-bottom: 10px;" src="/static/images/logo.png" alt="">
        </a>
        <div class="user-info">

            <div class="user-head">
                <img src="<?php echo $user['head']; ?>" alt="">
            </div>
            <div>
                <span class="user-nickname"><?php echo $user['nickname']; ?></span>
                <?php if($user['profile']['level']>1): ?>
                <a style="margin-bottom: 10px;" class="login layui-btn layui-btn-xs layui-btn-radius layui-btn-normal" href="/index/User/logout">退出</a>
                <?php else: ?>
                <a style="margin-bottom: 10px;" class="login layui-btn layui-btn-xs layui-btn-radius layui-btn-normal" href="/index/User/login">登录/注册</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="live">
        <gs:video-live id="videoComponent" site="shrz888.gensee.com" ctx="webcast" ownerid="0c870b0f9ebb46318bdac9de97e4eae3" uname="" authcode="" class="gs-sdk-widget"><iframe id="97ba1043712e4c7e803992db0ce6eca7" frameborder="0" width="100%" height="100%" name="video_videoComponent_0c870b0f9ebb46318bdac9de97e4eae3_" src="http://shrz888.gensee.com//sdk/site/sdk/media?ownerid=0c870b0f9ebb46318bdac9de97e4eae3&amp;groupId=&amp;android=false&amp;widgetid=videoComponent&amp;uname=visitor_zCzOqS&amp;appName=&amp;uid=9901606030&amp;sc=0&amp;video=&amp;lang=&amp;bar=&amp;bgimg=&amp;compress=false&amp;showChatInAnyCase=false&amp;stream=&amp;userdata=&amp;btnimg="></iframe></gs:video-live>
    </div>
    <div class="chat">
        <div class="chat-head">
            <div class="chats">
                <div class="item bt cur">聊天</div>
            </div>
            <div class="">
                <div class="item">实时数据</div>
            </div>
            <div class="">
                <div class="item">在线客服</div>
            </div>
            <div style="width:100%;" class="chat-content">
                <div class="chat-content-item1" style="transform:translate(0,0);"></div>
                <div class="chat-content-item2" style="transform:translate(0,0);display: none;">
                    <iframe id="iframe"  height="8000px"  width="100%"  frameborder="0" scrolling="no" src="http://www.jin10.com/example/jin10.com.html"></iframe>
                </div>
            </div>
            <div style="width:100%;" class="chat-message">
                <div onclick="showFacePanel(this,'#editor')" class="chat-face">
                    <a><img style="width:70%;height:70%;" src="/static/images/face.png" alt=""></a>
                </div>
                <div class="chat-input">
                    <div class="message_editor" id="editor" style="width: 100%;height: 100%;" contenteditable="true">

                    </div>
                </div>
                <div class="chat-send">
                    <a style="color:white;" href="javascript:send_msg()">发送</a>
                </div>
            </div>
            <div id="face" style="font-size:.1rem;position: absolute; bottom: 100px; left: inherit; display: none;" toinput="#editor"></div>
        </div>
    </div>
</div>

</body>
<script type="text/javascript" src="/static/js/jquery.js"></script>
<script type="text/javascript" src="/static/js/socket-mobile.js"></script>
<script type="text/javascript" src="/static/js/md5.js"></script>
<script>

    //获取用户信息
    var user = '<?php echo $userinfo; ?>';
    localStorage.setItem('user',user);

    function scheme(){
        var width = $(window).width();
        var height = $(window).height();
        height-=$('.head').height();
        $('.live').height(height*0.4);
        $('.chat').height(height*0.6);
        $('.chat-content').height(height*0.6-$('.chat-head').height()-$('.chat-message').height());
    }
    $(window).load(function(){
        scheme();
    });
    $(window).resize(function(){
        scheme();
    });

    $('.item').click(function(){
        var name = $(this).html();
        $('.item').removeClass('cur');
        $('.item').removeClass('bt');
        $(this).addClass('cur');
        $(this).addClass('bt');
        if(name=='聊天'){
            $('.chat-content-item1').css('display','block').siblings('div').css('display','none');
        }else if(name=='实时数据'){
            $('.chat-content-item2').css('display','block').siblings('div').css('display','none');
            $('.chat-message').css('display','none');
        }else if(name='在线客服'){
            $.post('/index/index/qq',{},function(data){
                location.href='http://wpa.qq.com/msgrd?v=3&uin='+data+'&site=qq&menu=yes';
            });
        }
    });
    $('#editor').focus(function(){
        var val = $(this).html();
        if(val.indexOf('发表此刻你最想说的话')>0){
            $(this).html('');
        }
    });

    $('#editor').keydown(function(e){
        if(e.which==13){
            send_msg();
        }
    });


    //发送消息
    function send_msg(){
        var user = JSON.parse(localStorage.getItem('user'));
        var con  = $('#editor').html();
        var mid = createId(user.uname);
        con = processMsg(con);
        if(con.length<=0){
            return;
        }
        var _html = packageMsg(user.profile['class'],user.nickname,con);
        $('.chat-content-item1').append(_html);
        scrollBar();
        //发送消息
        $.post('/push/Worker/sendMsg',{msg:con,mid:mid},function(data){

        });
    }

    //生成唯一id
    function createId(uid){
        var time = new Date().getTime();
        return md5(uid+time);
    }

    //拼装消息
    function packageMsg(className,nickname,msg){
        var _html = '<p class="dm-item">';
        _html += '<span class="'+className+'"></span>';
        _html += ' <span>'+nickname+'：</span>';
        _html += msg;
        _html += '</p>';
        return _html;
    }

    //调整滚动条位置
    function scrollBar(){
        $('#editor').html('');
        $('.chat-content-item1').scrollTop($('.chat-content-item1').prop("scrollHeight"));
    }

    //消息替换
    function processMsg(message){
        message = message.replace(/<br>/g,"");
        message = message.replace(/<div>/g,"");
        message = message.replace(/<\/div>/g,"");
        message = message.replace(/\"/g,"'");
        return message;
    }

    //表情包
    function showFacePanel(e,toinput){
        $('#face').css('display','block');
        $.get('<?php echo url("Index/face"); ?>',function(data){
            $('#face').html(data);
            $('#facenav li').click(function(){
                var rel = $(this).attr('rel');
                $('#face dl').hide();
                $('#f_'+rel).show();
                $(this).siblings().removeClass('f_cur');
                $(this).addClass('f_cur');
            });
            $('#face dd').click(function(){
                var img_link = $(this).find('img').attr('src');
                var img_alt  = $(this).attr('title');
                var cur = $('#msg_text').html();
                cur+= '<img src="'+img_link+'" alt="'+img_alt+'" />';
                $('#msg_text').html(cur);
                $('#msg_text').scrollTop( $('#msg_text').prop("scrollHeight"));
            });
        }).success(function(e){
            $(document).bind('mouseup',function(e){
                if($(e.target).attr('isface')!='1' && $(e.target).attr('isface')!='2')
                {
                    $('#face').hide();
                    $(document).unbind('mouseup');
                }
                else if($(e.target).attr('isface')=='1')
                {
                    var toinput =$('#face').attr("toinput");
                    if($(e.target).attr('src')!=undefined){
                        $(toinput).append('<img src="'+$(e.target).attr('src')+'" onresizestart="return false" contenteditable="false">');}
                }
            });
        });

    }

    //页面初始化
    $(function(){

        //$('#editor').html('发表此刻你最想说的话~');

        //查询发言记录
        $.post('/index/Index/message',{},function(data){
            data = JSON.parse(data);
            for(var i=data.length-1;i>=0;i--){
                var nickname = data[i].nickname;
                var className = data[i].class;
                var con  = data[i].message;
                var _html = packageMsg(className,nickname,con);
                $('.chat-content-item1').append(_html);
            }
            scrollBar();
        });
    });
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