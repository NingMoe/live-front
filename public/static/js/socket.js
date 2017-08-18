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

   console.log(e.data);

}

//连接失败
ws.onerror = function(){
   console.log('聊天服务器连接失败');
}
