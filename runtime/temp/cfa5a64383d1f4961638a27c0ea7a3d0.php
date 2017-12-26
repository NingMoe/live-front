<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"D:\phpStudy\WWW\yiqiu\public/../application/index\view\article\details.html";i:1513065553;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        .wrap{
            width:800px;
            margin:0 auto;
            height:auto;
        }
        h1{
            text-align: center;
        }
        .wrap-state{
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
    <link rel="stylesheet" href="/static/layui/css/layui.css"  media="all">
    <script src="/static/layui/layui.js"></script>
    <script src="/static/js/jquery.js"></script>
</head>
<body>
<div class="wrap">
    <h1 style="font-size: 30px;font-weight: 600;margin-bottom:10px;"><?php echo $article['title']; ?></h1>
    <div class="wrap-state">
        <span>发布时间：<?php echo $article['create_time']; ?></span>
        <span style="margin-left:20px;margin-right:20px;"><i class="layui-icon"></i>&nbsp;<?php echo $name['room_name']; ?></span>
        <?php if(!(empty($article['url']) || (($article['url'] instanceof \think\Collection || $article['url'] instanceof \think\Paginator ) && $article['url']->isEmpty()))): ?>
        <a onclick="downloadNumber('<?php echo $article['id']; ?>')" href="<?php echo $article['url']; ?>" style="background: #FF5722;color:white;border-radius: 5px;">下载附件</a>
        <?php endif; ?>
    </div>
    <?php echo htmlspecialchars_decode($article['content']); ?>
</div>
<script>
    function downloadNumber(id){
        $.post('<?php echo url("Index/Article/downloadNumber"); ?>',{id:id},function(data){
            console.log(data);
        });
    }
</script>
</body>
</html>