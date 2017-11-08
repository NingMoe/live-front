<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:68:"D:\phpStudy\WWW\yiqiu\public/../application/index\view\setup\qq.html";i:1508896288;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QQ客服</title>
    <link href="/static/layui/css/layui.css" rel="stylesheet" />
    <script src="/static/layui/layui.js"></script>
</head>
<body>
<form style="margin-top:30px;" class="layui-form" action="<?php echo url('Setup/qq'); ?>" method="post" id="aa">

    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">QQ</label>
        <div class="layui-input-block">
            <textarea name="qq" placeholder="请输入内容" class="layui-textarea"><?php echo $data['qq']; ?></textarea>
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