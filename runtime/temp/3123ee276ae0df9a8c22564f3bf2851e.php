<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\phpStudy\WWW\yiqiu\public/../application/index\view\article\index.html";i:1512634490;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<link rel="stylesheet" href="/static/layui/css/layui.css"  media="all">
<script src="/static/layui/layui.js"></script>
<script src="/static/js/jquery.js"></script>
<style>
    .article a,span{
        color:#666;
    }
    .article ul{
        width:100%;
    }
    .article li{
        width:100%;
        height:30px;
        line-height: 30px;
        border-bottom:1px dashed #ccc;
    }
    .article li span:first-child{
        width:70%;
        display: inline-block;
    }
    .article li span:nth-child(2){
        width:20%;
        display: inline-block;
    }
    .article li span:nth-child(3){
        width:4%;
        display: inline-block;
    }
    .article li span:nth-child(4){
        width:4%;
        display: inline-block;
    }
    .article li:first-child{
        width:100%;
        height:30px;
        background: #eee;
    }

</style>
<body>
<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
    <ul class="layui-tab-title">
        <?php if(is_array($articletype) || $articletype instanceof \think\Collection || $articletype instanceof \think\Paginator): $k = 0; $__LIST__ = $articletype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
        <li <?php if(!(empty($vo['this']) || (($vo['this'] instanceof \think\Collection || $vo['this'] instanceof \think\Paginator ) && $vo['this']->isEmpty()))): ?>class="layui-this"<?php endif; ?>><?php echo $vo['typename']; ?></li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show article">
            <ul>
                <li>
                    <span>标题</span>
                    <span>发布时间</span>
                    <span>点击</span>
                    <span>下载</span>
                </li>
                <?php if(is_array($article) || $article instanceof \think\Collection || $article instanceof \think\Paginator): $i = 0; $__LIST__ = $article;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <li>
                    <span>
                        <img src="/static/images/point.png" alt="">
                        <a onclick="clickNumber('<?php echo $v['id']; ?>')" href="/index/Article/details?id=<?php echo $v['id']; ?>&typeid=<?php echo $v['typeid']; ?>"><?php echo $v['title']; ?></a>
                    </span>
                    <span><?php echo $v['create_time']; ?></span>
                    <span style="color:#5FB878;"><?php echo $v['click_number']; ?></span>
                    <span style="color:#FF5722;"><?php echo $v['download_number']; ?></span>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
</div>
</body>
<script>
    layui.use('element', function(){
        var $ = layui.jquery
            ,element = layui.element
            ,layer = layui.layer; //Tab的切换功能，切换事件监听等，需要依赖element模块

        element.on('tab(docDemoTabBrief)', function(data){
            var type = this.textContent;
            location.href='/index/article/index?typename='+type;
        });


    });

    function clickNumber(id){
        //增加点击数
        $.post('<?php echo url("index/Article/clickNumber"); ?>',{id:id},function(data){
            console.log(data);
        });
    }
</script>
</html>