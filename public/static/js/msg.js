//发送消息
function sendMsg(){
    var msg = $('#editor').html();
    var user= localStorage.getItem('user');
    user = JSON.parse(user);
    //处理消息格式
    msg = processMsg(msg);

    if(msg==''||msg==null){
        layer.msg('消息不能为空');
        $('#editor').html('');
        return;
    }

    //创建消息唯一ID
    var mid = createId(user.uname);

    //拼装消息
    var con =  packageMsg(user.clientId,user.head,user.nickname,user.profile['class'],user.profile['bg'],user.profile['style'],getTime(),msg,mid);
    $('.chat').append(con);

    //调整滚动条
    scrollBar();
    //发送消息
    $.post('/push/Worker/sendMsg',{msg:msg,mid:mid},function(data){

    });
}


//审核按钮
function checkMessage(o){
    o = $(o).parent('.chatInfo');
    var arr = {};
    var mid = $(o).attr('id');
    arr['flag'] = 'pass';
    arr['mid'] = $(o).attr('id');
    arr['cid'] = $(o).attr('cid');
    arr['head'] = $(o).children('img').attr('src');
    arr['nickname'] = $(o).find('.messageInfo span:eq(0)').html();
    arr['time'] = getTime();
    arr['class'] = $(o).find('.messageInfo span:eq(2)').attr('class');
    arr['style'] = $(o).find('.messageContent span').attr('style');
    arr['bg'] = $(o).find('.messageContent').attr('style');
    arr['msg'] = $(o).find('.messageContent span').html();
    arr = JSON.stringify(arr);
    //发送消息
    $.post('/push/Worker/sendToAllMsg',{arr:arr},function(data){
        data = JSON.parse(data);
        if(data.type=='error'){
            layer.msg(data.msg);
        }else{
            //删除当前页面审核按钮
            $('#'+mid).find('.case1').remove();
        }
    });
}

//删除按钮
function deleteMessage(o){

    var mid = $(o).parent('.chatInfo').attr('id');

    //发送消息
    $.post('/push/Worker/sendToAllMsg',{mid:mid,flag:'delete'},function(data){
        data = JSON.parse(data);
        if(data.type=='error'){
            layer.msg(data.msg);
        }else{
            //删除当前页面该条发言
            $('#'+mid).remove();
        }
    });
}

//消息替换
function processMsg(message){
    message = message.replace(/<br>/g,"");
    message = message.replace(/<div>/g,"");
    message = message.replace(/<\/div>/g,"");
    message = message.replace(/\"/g,"'");
    return message;
}

//拼装消息
function packageMsg(cid,avatar,nickname,level,bg,style,time,msg,mid){
    var contents = '<div class="chatInfo" id="'+mid+'" cid="'+cid+'">';
    contents += '<img src="'+avatar+'" class="userHead">';
    contents += '<div class="userRight">';
    contents += '<div class="messageInfo">';
    contents += '<span>'+nickname+'</span>';
    contents += '<span>'+time+'</span>';
    contents += '<span class="'+level+'">';
    contents += '</span>';
    contents += '</div>';
    contents += '<div class="messageContent" style="'+bg+'">';
    contents += '<span style="'+style+'">'+msg+'</span>';
    contents += '</div>';
    contents += '</div>';
    return contents;
}


//获取当前时间
function getTime(){
    var date = new Date();
    var year = date.getFullYear();
    var month = date.getMonth()+1;
    var day = date.getDate();
    var hour = date.getHours();
    var minute = date.getMinutes();
    minute = minute>10?minute:'0'+minute;
    var second = date.getSeconds();
    return hour+':'+minute;
}

//调整滚动条位置
function scrollBar(){
    $('#editor').html('');
    $('.chat').scrollTop( $('.chat').prop("scrollHeight"));
}

//对象转化数组
function transformArr(arr){
    var ob = new Array();
    for(var i in arr){
        ob[i] = arr[i];
    }
    return ob;
}

//生成唯一id
function createId(uid){
   var time = new Date().getTime();
   return md5(uid+time);
}