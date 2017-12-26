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
       case 'pass':
           var nickname = data.nickname;
           var className = data.class;
           var con  = data.msg;
           var _html = packageMsg(className,nickname,con);
           $('.chat-content-item1').append(_html);
           scrollBar();
           break;
       case 'msg':
           var nickname = data.user['nickname'];
           var className = data.user['profile']['class'];
           var con  = data.msg;
           var _html = packageMsg(className,nickname,con);

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
           _html += '温馨提示:';
           _html += data.desc;
           _html += '</div>';
           $('.chat-content').prepend(_html);
           setTimeout(function(){$('.chat-notice').remove();},5000);
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

