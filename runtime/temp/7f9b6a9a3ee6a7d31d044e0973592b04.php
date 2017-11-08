<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"D:\phpStudy\WWW\yiqiu\public/../application/index\view\depot\jiancang_add.html";i:1509691053;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>建仓提醒</title>
    <link href="/static/layui/css/layui.css" rel="stylesheet" />
    <script src="/static/layui/layui.js"></script>
</head>
<body>
<form style="margin-top:30px;" class="layui-form" action="<?php echo url('Depot/jiancang_add'); ?>" method="post" id="aa">
    <div class="layui-form-item">
        <label class="layui-form-label">产品</label>
        <div class="layui-input-block">
            <select name="goods_id" lay-verify="required" lay-filter="goods_id">
                <option value=""></option>
                <?php foreach($goods as $val): ?>
                <option value="<?php echo $val['goods_id']; ?>"><?php echo $val['goods_name']; ?></option>
                <?php endforeach; ?>
            </select><div class="layui-unselect layui-form-select"><div class="layui-select-title"><input type="text" placeholder="请选择" value="" readonly="" class="layui-input layui-unselect"><i class="layui-edge"></i></div><dl class="layui-anim layui-anim-upbit" style=""><dd lay-value="" class="layui-select-tips">请选择</dd><dd lay-value="0" class="">北京</dd><dd lay-value="1" class="">上海</dd><dd lay-value="2" class="">广州</dd><dd lay-value="3" class="">深圳</dd><dd lay-value="4" class="">杭州</dd></dl></div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">类型</label>
        <div class="layui-input-block">
            <select name="type" lay-verify="required">
                <option value=""></option>
                <?php foreach($type as $val): ?>
                <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                <?php endforeach; ?>
            </select><div class="layui-unselect layui-form-select"><div class="layui-select-title"><input type="text" placeholder="请选择" value="" readonly="" class="layui-input layui-unselect"><i class="layui-edge"></i></div><dl class="layui-anim layui-anim-upbit" style=""><dd lay-value="" class="layui-select-tips">请选择</dd><dd lay-value="0" class="">北京</dd><dd lay-value="1" class="">上海</dd><dd lay-value="2" class="">广州</dd><dd lay-value="3" class="">深圳</dd><dd lay-value="4" class="">杭州</dd></dl></div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">麦单类型</label>
        <div class="layui-input-block">
            <select name="maidan" lay-verify="required">
                <option value=""></option>
                <?php foreach($maidan as $val): ?>
                <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                <?php endforeach; ?>
            </select><div class="layui-unselect layui-form-select"><div class="layui-select-title"><input type="text" placeholder="请选择" value="" readonly="" class="layui-input layui-unselect"><i class="layui-edge"></i></div><dl class="layui-anim layui-anim-upbit" style=""><dd lay-value="" class="layui-select-tips">请选择</dd><dd lay-value="0" class="">北京</dd><dd lay-value="1" class="">上海</dd><dd lay-value="2" class="">广州</dd><dd lay-value="3" class="">深圳</dd><dd lay-value="4" class="">杭州</dd></dl></div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">仓位</label>
        <div class="layui-input-block">
            <input type="text" name="cangwei" required  lay-verify="required" value="" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">开仓价</label>
        <div class="layui-input-block">
            <input type="text" name="kaicang" required  lay-verify="required" value="" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">止损</label>
        <div class="layui-input-block">
            <input type="text" name="zhisun" required  lay-verify="required" value="" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">止盈</label>
        <div class="layui-input-block">
            <input type="text" name="zhiying" required  lay-verify="required" value="" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
    <input type="hidden" id="goods_name" name="goods_name">
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

       form.on('select(goods_id)',function(data){
           var goods = data.elem[data.elem.selectedIndex].innerHTML;
           $('#goods_name').val(goods);
       });
    });

</script>
</html>