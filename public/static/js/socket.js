ws = new WebSocket('ws://101.132.223.157:8282');

//连接成功
ws.onopen = function(msg){

    console.log('连接服务器成功...');
};

//处理消息
ws.onmessage = function(e){console.log(e);
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

           var user = JSON.parse(localStorage.getItem('user'));
           if(data.cid == user.clientId){
               data.msg = matchAite(data.msg);//匹配@+姓名 如果匹配成功 姓名替换成您
               //桌面通知
               showDeskTopNotice('系统通知','有人@您~','/static/images/timg.jpg');
           }

           //判断推送的消息是否存在 如果存在则不添加
           if($('#'+data.mid).length>0){
               if($('#'+data.mid).find('.case1').length>0){//如果审核按钮存在,删除审核按钮
                   $('#'+data.mid).find('.case1').remove();
               }
           }else{
               $('.chat').append(data.msg);
               //判断非管理权限,去除审核、删除按钮
               var user = JSON.parse(localStorage.getItem('user'));
               if( $('#'+data.mid).length>0){
                   if(user['group']['check_msg']!=0){
                       $('#'+data.mid).find('.case1').remove();
                       $('#'+data.mid).find('.case2').remove();
                   }
               }
               scrollBar();
           }
           break;
       case 'ping':
           //响应心跳,避免断开连接
           ws.send('yes');
           console.log('检测心跳...');
           break;
       case 'delete':
           if($('#'+data.mid).length>0){
               $('#'+data.mid).remove();
           }
           break;
       case 'online':
           //alert(data.nickname+'上线啦');
           break;
       case 'close':
           //前端将对应的clientId删除
           $('#'+data.clientId).remove();
           break;
       case 'feiping':
           danmu(data.link,data.head,data.desc);
           break;
       case 'blackList':
           location.href='/index/Error/index';
           break;
       case 'jiancang':
           depot(data.goods_type,data.name,data.goods,data.url);
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

