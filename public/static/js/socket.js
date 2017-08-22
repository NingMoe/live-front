ws = new WebSocket('ws://127.0.0.1:2346');

//连接成功
ws.onopen = function(msg){

    if(typeof msg=='string'){
        ws.send(msg);
    }else if(typeof msg=='object'){
        var message = JSON.parse(localStorage.getItem('user'));
        message['type'] = 0;
        ws.send(JSON.stringify(message));
    }
};

//处理消息
ws.onmessage = function(e){
   var json_data = e.data;
   var data = JSON.parse(e.data);
   switch(data.type){
       case 1:
           data.msg += '<div class="escdata" attr="'+escape(json_data)+'"></div></div>';
           $('.chat').append(data.msg);
           scrollBar();
           break;
   }

}

//连接失败
ws.onerror = function(){
   console.log('聊天服务器连接失败');
}

