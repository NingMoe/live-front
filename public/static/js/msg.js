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
    var con =  packageMsg(user,msg,mid);
    $('.chat').append(con);

    //调整滚动条
    scrollBar();
    //发送消息
    $.post('/push/Worker/sendMsg',{msg:con,mid:mid,cid:CLIENT_ID},function(data){

    });
}


//审核按钮
function checkMessage(o){

    var mid = $(o).parent('.chatInfo').attr('id');
    var cid = $(o).parent('.chatInfo').attr('cid');

    //获取html 去除按钮
    var par =  $('#'+mid).clone();
    par.find('i').remove();
    var con = par.html();



    //获取不到当前元素的html 只能获取子元素的html 直接拼接
    var _html = '<div class="chatInfo" id="'+mid+'">';
    _html += con;
    _html += '</div>';

    //发送消息
    $.post('/push/Worker/sendToAllMsg',{cid:cid,msg:_html,mid:mid,flag:'pass'},function(data){
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
function packageMsg(user,msg,mid){
    var contents = '<div class="chatInfo" id="'+mid+'" cid="'+user.clientId+'">';
    contents += '<img src="'+user.head+'" class="userHead">';
    contents += '<div class="userRight">';
    contents += '<div class="messageInfo">';
    contents += '<span>'+user.nickname+'</span>';
    contents += '<span>'+getTime()+'</span>';
    contents += '<span class="'+user.profile['class']+'">';
    contents += '</span>';
    contents += '</div>';
    contents += '<div class="messageContent" style="'+user.profile['bg']+'">';
    contents += '<span style="'+user.profile['style']+'">'+msg+'</span>';
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