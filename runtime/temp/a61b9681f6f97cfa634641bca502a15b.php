<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\phpStudy\WWW\yiqiu\public/../application/index\view\setup\banner.html";i:1507802135;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>设置</title>
    <link href="/static/layui/css/layui.css" rel="stylesheet" />
    <script src="/static/layui/layui.js"></script>
</head>
<body>
<table class="layui-table">
    <colgroup>
        <col width="150">
        <col width="200">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>图片</th>
        <th>链接</th>
        <th>排序</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($banner as $val): ?>
    <tr>
        <td><img src="<?php echo $val['img']; ?>" alt=""></td>
        <td><?php echo $val['link']; ?></td>
        <td><?php echo $val['sort']; ?></td>
        <td><a href="javascript:del('<?php echo $val['id']; ?>')">删除</a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<form class="layui-form" action="<?php echo url('Setup/banner'); ?>" method="post" id="aa">
    <div class="layui-form-item">
        <label class="layui-form-label">链接</label>
        <div class="layui-input-block">
            <input type="text" name="link" required  lay-verify="required" value="" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item" id="test1">
        <label class="layui-form-label">图片</label>
        <img id="r_img" src="" style="max-height: 200px;max-width: 200px;" alt="">
        <input type="hidden" name="img" id="img" value="">
        <button type="button" class="layui-btn" >
            <i class="layui-icon">&#xe67c;</i>上传图片
        </button>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-block">
            <input type="text" name="sort" required  lay-verify="required" value="" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
<script src="/static/js/jquery.js"></script>
<script>
    function del(id){
        $.post('<?php echo url("Setup/banner_del"); ?>',{id:id},function(data){
            if(data){
                location.reload();
            }else{
                alert('删除失败');
            }
        });
    }
    //Demo
    layui.use(['form','upload','jquery'], function(){
        var form = layui.form;
        var upload = layui.upload;
        var $ = layui.$;
        //监听提交
        form.on('submit(formDemo)', function(data){
            console.log(data);
        });

        //执行实例
        upload.render({
            elem: '#test1' //绑定元素
            ,url: '<?php echo url("Upload/image"); ?>' //上传接口
            ,done: function(res){
                //上传完毕回调
                $('#img').val(res.src);
                $('#r_img').attr('src',res.src);
            }
            ,error: function(){
                //请求异常回调
            }
        });

    });
</script>
</body>
</html>