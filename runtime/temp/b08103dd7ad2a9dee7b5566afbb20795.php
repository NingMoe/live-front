<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"D:\phpStudy\WWW\yiqiu\public/../application/index\view\setup\danmu.html";i:1508813139;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>弹幕飞屏</title>
    <link href="/static/layui/css/layui.css" rel="stylesheet" />
    <script src="/static/layui/layui.js"></script>
</head>
<body>
<form style="margin-top:30px;" class="layui-form" action="<?php echo url('Setup/danmu'); ?>" method="post" id="aa">

    <div class="layui-form-item">
        <label class="layui-form-label">链接</label>
        <div class="layui-input-block">
            <input type="text" name="link"  placeholder="请输入标题" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">内容</label>
        <div class="layui-input-block">
            <textarea name="desc" placeholder="请输入内容" class="layui-textarea"></textarea>
        </div>
    </div>


    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
</body>
<script>
    layui.use(['form'], function(){
        var form = layui.form;
        var $ = layui.$;
        //监听提交
        form.on('submit(formDemo)', function(data){
            console.log(data);
        });

    });
</script>
</html>