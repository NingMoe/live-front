//发送消息
function sendMsg(){
    var msg = $('#editor').html();
    var user= localStorage.getItem('user');
    user = JSON.parse(user);
    msg = processMsg(msg);
    if(msg==''||msg==null){
        layer.msg('消息不能为空');
        $('#editor').html('');
        return;
    }
    var con =  packageMsg(user,msg);
    $('.chat').append(con);
    //调整滚动条
    scrollBar();
    //定义消息格式
    var message = JSON.parse(localStorage.getItem('user'));
    message['type'] = 1;//聊天信息
    message['msg']  = con;//发言内容
    ws.onopen(JSON.stringify(message));
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
function packageMsg(user,msg){
    var contents = '<div class="chatInfo" id="'+user.uid+'">';
    contents += '<img src="'+user.head+'" class="userHead">';
    contents += '<div class="userRight">';
    contents += '<div class="messageInfo">';
    contents += '<span>'+user.nickname+'</span>';
    contents += '<span>['+user.levelname+']</span>';
    contents += '<span>'+getTime()+'</span>';
    contents += '</div>';
    contents += '<div class="messageContent">';
    contents += '<span>'+msg+'</span>';
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