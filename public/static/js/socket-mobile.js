ws = new WebSocket('ws://101.132.223.157:8282');

//连接成功
ws.onopen = function(msg){

    console.log('连接服务器成功...');
};

//处理消息
ws.onmessage = function(e){
   var data = JSON.parse(e.data);
   switch(data.type){
       case 'clientId':
           //绑定clientId
           $.post('/push/Worker/bindUid',{clientId:data.clientId},function(res){
               //获取用户组绑定
               var user = JSON.parse(localStorage.getItem('user'));
               user['group'] = res;
               user['clientId'] = data.clientId;
               localStorage.setItem('user',JSON.stringify(user));
           });
           break;
       case 'msg':
            var name = $(data.msg).find('.messageInfo span:eq(0)').html();
            var className = $(data.msg).find('.messageInfo span:eq(2)').attr('class');
            var con  = $(data.msg).find('.messageContent span').html();
            if(data.is_check){
                //data.msg += '<i class="case1" onclick="checkMessage(this)">审核通过</i><i class="case2" onclick="deleteMessage(this)">删除</i></div>';
            }else{
               // var mid = data.mid;
               // $('#'+mid).find('i').remove();
            }
           var _html = '<p class="dm-item">';
           _html += '<span class="'+className+'"></span>';
           _html += ' <span>'+name+'：</span>';
           _html += con;
           _html += '</p>';
           $('.chat-content-item1').append(_html);
           scrollBar();
           break;
       case 'ping':
           //响应心跳,避免断开连接
           ws.send('yes');
           console.log('检测心跳...');
           break;
       case 'delete':
           break;
       case 'online':
           var _html = '<div class="chatInfo" style="text-align: center;">';
           _html += '<span class="user-online">系统消息:'+data.nickname+'&nbsp;上线了~</span>';
           _html += '</div>';
           $('.chat').append(_html);
           scrollBar();
           break;
       case 'close':
           break;
       case 'feiping':
           $('.chat-notice').remove();
           var _html = '<div class="chat-notice">';
           _html += '<span>温馨提示:</span>';
           _html += data.desc;
           _html += '</div>';
           $('.chat-content-item1').prepend(_html);
           break;
       case 'blackList':
           location.href='/index/Error/index';
           break;
       case 'jiancang':
           scrollBar();
           break;
   }

}

ws.onclose = function(cid){
    //alert('与服务器断开连接');
    console.log('与服务器断开连接');
}

//连接失败
ws.onerror = function(){
   console.log('连接服务器失败...');
}

