<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"C:\PhpStudy\WWW\live-front\public/../application/index\view\depot\pingcang.html";i:1513316597;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>平仓</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/static/layui/css/layui.css"  media="all">
    <script src="/static/layui/layui.js"></script>
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>
<blockquote style="margin:0;" class="layui-elem-quote mylog-info-tit">
    <div class="layui-inline">
        <form class="layui-form" id="resSearchForm" method="" action="">
            <div class="layui-input-inline" style="width:110px;">
                <input type="text" class="layui-input" id="beginDate" name="beginDate" placeholder="开始日期">
            </div>
            --<div class="layui-input-inline" style="width:110px;">
                <input type="text" class="layui-input" id="endDate" name="endDate" placeholder="结束日期">
            </div>
            <div class="layui-input-inline" style="width:110px;">
                <select name="uid">
                    <option value="">选择讲师</option>
                    <?php foreach($teacher as $val): ?>
                    <option value="<?php echo $val['uname']; ?>"><?php echo $val['nickname']; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="layui-unselect layui-form-select"><div class="layui-select-title"><input type="text" placeholder="请选择" value="菜单名称" readonly="" class="layui-input layui-unselect"><i class="layui-edge"></i></div><dl class="layui-anim layui-anim-upbit" style=""><dd lay-value="resNameTerm" class="layui-this">菜单名称</dd><dd lay-value="parentNameTerm" class="">父级菜单</dd><dd lay-value="resTypeTerm" class="">菜单类型</dd><dd lay-value="resLevelTerm" class="">菜单级别</dd></dl></div>
            </div>
            <div class="layui-input-inline" style="width:110px;">
                <select name="goods_id">
                    <option value="">选择商品</option>
                    <?php foreach($goods as $val): ?>
                    <option value="<?php echo $val['goods_id']; ?>"><?php echo $val['goods_name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="layui-unselect layui-form-select"><div class="layui-select-title"><input type="text" placeholder="请选择" value="菜单名称" readonly="" class="layui-input layui-unselect"><i class="layui-edge"></i></div><dl class="layui-anim layui-anim-upbit" style=""><dd lay-value="resNameTerm" class="layui-this">菜单名称</dd><dd lay-value="parentNameTerm" class="">父级菜单</dd><dd lay-value="resTypeTerm" class="">菜单类型</dd><dd lay-value="resLevelTerm" class="">菜单级别</dd></dl></div>
            </div>
            <a class="layui-btn resSearchList_btn" lay-submit="" lay-filter="resSearchFilter"><i class="layui-icon larry-icon larry-chaxun7"></i>查询</a>
            <input type="hidden" name="depot_type" value="2">
        </form>
    </div>
</blockquote>
<!-- 菜单列表 -->
<div style="padding:0;" class="layui-tab-item layui-show" style="padding: 10px 15px;">
    <table id="resTableList" lay-filter="resTableId"></table>
</div>

</body>
<script src="/static/js/jquery.js"></script>
<script type="text/javascript">

    layui.config({
        base : "/static/js/"
    }).use(['form', 'table', 'layer','laydate'], function () {
        var $ = layui.$,
            form = layui.form,
            table = layui.table,
            layer = layui.layer;
            laydate = layui.laydate;

        //日期空间
        laydate.render({
            elem:'#beginDate'
        });
        laydate.render({
            elem:'#endDate'
        });

        /**用户表格加载*/
        table.render({
            elem: '#resTableList',
            url: '/index/Depot/jiancangInfo?depot_type=2',
            id:'resTableId',
            method: 'post',
            height:'525px',
            skin:'row',
            even:'true',
            size: 'sm',
            cols: [[
                {field:'goods_name', title: '商品',width: 130,style:'color:#EE3B3B' },
                {field:'type', title: '类型',width: 80 },
                {field:'cangwei', title: '仓位',width: 85},
                {field:'kaicang', title: '开仓价',width: 85,templet: '#resStatusTpl'},
                {field:'zhisun', title: '止损价',width: 85},
                {field:'zhiying', title: '止盈价',width: 85,templet: '#resTypeTpl'},
                {field:'pingcang', title: '平仓价',width: 120,templet: '#pingcang',style:'background-color: #5FB878;color:white;'},
                {field:'maidan', title: '麦单类型',width: 85,templet: '#resLevelTpl'},
                {field:'nickname', title: '老师名称',width: 100,style:'color:#01AAED',align:'center'},
                {field:'create_time', title: '建仓时间',width: 145 },
                {field:'end_time', title: '平仓时间',width: 145 ,templet:'#pjTime'},
                {field:'did', title: '',width: 150 ,toolbar:'#handle'},
            ]],
            page: true,
            limit: '<?php echo $jcCount; ?>'//默认显示10条
        });

        /**查询*/
        //监听提交
        $(".resSearchList_btn").click(function(){

            form.on('submit(resSearchFilter)', function (data) {
                table.reload('resTableId',{
                    where: {
                        beginDate:data.field.beginDate,
                        endDate:data.field.endDate,
                        uid:data.field.uid,
                        goods_id:data.field.goods_id,
                        depot_type:data.field.depot_type
                    },
                    height:'full-140'
                });

            });
        });


        /**新增菜单*/
        $(".resAdd_btn").click(function(){
            var url = "/res/res_edit.do";
            common.cmsLayOpen('新增菜单',url,'750px','470px');
        });

        /**监听工具条*/
        table.on('tool(resTableId)', function(obj) {
            var data = obj.data; //获得当前行数据
            var layEvent = obj.event; //获得 lay-event 对应的值

            //编辑菜单
            if(layEvent === 'res_edit') {

                var resId = data.resId;
                var url =  "/res/res_update.do?resId="+resId;
                common.cmsLayOpen('编辑菜单',url,'750px','470px');
                //失效菜单
            }else if(layEvent === 'res_fail'){

            }



        });

    });

</script>

<script type="text/html" id="handle">
    {{#  if('<?php echo $edit; ?>'){ }}
        <a onclick="edit('{{d.did}}')" class="layui-btn layui-btn-danger layui-btn-mini" >修改</a>
    {{#  } }}
    {{#  if('<?php echo $del; ?>'){ }}
        <a onclick="del('{{d.did}}')" class="layui-btn layui-btn-danger layui-btn-mini" >删除</a>
    {{#  } }}

</script>

<script>

    function edit(id){
        location.href='<?php echo url("Depot/jiancang_edit"); ?>?id='+id;
    }

    function del(id){
        $.post('/index/Depot/jiancang_delete',{id:id},function(data){
            JSON.parse(data);
            if(data.type='success'){
                location.reload();
            }else{
                layui.use('layer', function(){
                    var layer = layui.layer;
                    layer.msg(data.msg);
                });
            }
        });
    }
</script>
</html>