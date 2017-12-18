<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\phpStudy\WWW\yiqiu\public/../application/index\view\jiqiren\index.html";i:1513581879;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>用户总数--layui后台管理模板</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/static/yiqiu/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/static/yiqiu/css/font_eolqem241z66flxr.css" media="all" />
    <link rel="stylesheet" href="/static/yiqiu/css/user.css" media="all" />
</head>
<body class="childrenBody">
<a href="<?php echo url('Jiqiren/add'); ?>" class="layui-btn layui-btn-normal">添加</a>
<div class="layui-form news_list">
    <table class="layui-table">
        <colgroup>
            <col width="50">
            <col>
            <col width="18%">
            <col width="8%">
            <col width="12%">
            <col width="12%">
            <col width="18%">
            <col width="15%">
        </colgroup>
        <thead>
        <tr>
            <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
            <th>昵称</th>
            <th>等级</th>
            <th>操作</th>
        </tr>
        <tbody>
        <?php if(is_array($role) || $role instanceof \think\Collection || $role instanceof \think\Paginator): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <td></td>
                <td><?php echo $vo['name']; ?></td>
                <td><?php echo $vo['profile']['name']; ?></td>
                <td>
                    <a href="javascript:del('<?php echo $vo['id']; ?>')" class="layui-btn layui-btn-danger layui-btn-mini users_del" data-id="1"><i class="layui-icon"></i> 删除</a>
                </td>
            </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
        </thead>
        <tbody class="users_content"></tbody>
    </table>
</div>
<div id="page"></div>
<script type="text/javascript" src="/static/yiqiu/layui/layui.js"></script>
<script type="text/javascript" src="/static/js/jquery.js"></script>
<script>
    function del(id){
        if(confirm('删除后不可恢复')){
            $.post('<?php echo url("Jiqiren/del"); ?>',{id:id},function(result){
                result = JSON.parse(result);
                if(result.status=='success'){
                    location.reload();
                }else{
                    layui.use('layer',function(){
                        var layer = layui.layer;
                        layer.msg(result.msg);
                    });
                }
            });
        }
    }
</script>
</body>
</html>