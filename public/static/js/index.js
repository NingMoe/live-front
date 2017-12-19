$('.userListWrap').mouseover(function(){
	$(this).css('overflow','auto');
});
$('.userListWrap').mouseout(function(){
	$(this).css('overflow','hidden');
});
$('.userTable li').click(function(){
	var i = $(this).index();
	$('.column1').children('div').eq(i).css('display','block').siblings('div').css('display','none');
	$(this).css('background','rgba(0, 0, 0, 0.4)').siblings('li').css('background','rgba(0, 0, 0, 0.1)');
});
$('.table li').mouseover(function(){
	$(this).css('background','rgba(0, 0, 0, 0.4)').siblings('li').css('background','rgba(0,0,0,0.1)');
});
$('.caidan').click(function(){
	var i = $(this).attr('dataNumber');
	$(this).addClass('select').siblings('.caidan').removeClass('select');
	buju(i);
});
$('.bg').click(function(){
	var i = $(this).attr('dataNumber');
	$(this).addClass('select').siblings('.bg').removeClass('select');
	bg(i);
});
$('.gexinghua').hover(function(){
	$('.selfdom').show();
},function(){
	$('.selfdom').hide();
});
$('#chatClear').click(function(){
	$('.chat').html('');
});
$('#editor').bind('keyup',function(e){
    if(e.keyCode==13){
        sendMsg();
    }
});
$('.sendBtn').click(function(){
    sendMsg();
});
$('.userList li').bind("contextmenu", function(){
    return false;
});
$('.mousemenu').bind("contextmenu", function(){
    return false;
});

$(".chat .chatInfo").live('mousedown',function(e) {
    //右键为3
    if (3 == e.which) {
    	var cid = $(this).attr('cid');
    	var name= $(this).find('.messageInfo span:nth-child(1)').html();
       	var px = e.pageX;
		var py = e.pageY;
		chatClick(this,name,cid,px,py);
    }
});

/*右击菜单*/
function chatClick(e,name,cid,px,py){
	TAKE_NAME = name;
	CLIENT_ID = cid;
	$('.mousemenu ul li:nth-child(1)').html(name);
    $('.mousemenu').css('display','block');
    $('.mousemenu').css('left',px);
    $('.mousemenu').css('top',py);
}

/*鼠标按下关闭弹出的窗口*/
$('body').mousedown(function(e){
	if($(e.target).parent('.userInfo').length<=0){
        $('.mousemenu').css('display','none');
	}
});

/*艾特*/
$('.aite').mousedown(function(){
    //var con = $('#editor').html();
    var username = $('.aite').attr('username');
    con = '<a href="javascript:void(0)" cid="'+CLIENT_ID+'" class="aiteuser">@'+TAKE_NAME+'&nbsp;</a>';
    $('#editor').html(con);

});

/*封禁*/
$('.banned').mousedown(function(){

	$.post('/index/Front/rid_of',{clientId:CLIENT_ID},function(data){
		data = JSON.parse(data);
		if(data.type==-1){
			layer.msg(data.msg);
		}
	});
});

//机器人
$('#jiqi').change(function(){
    var user  = JSON.parse(localStorage.getItem('user'));
	user['nickname'] = $(this).find('option:selected').attr('name');
    user['head'] = $(this).find('option:selected').attr('avatar');
	user['profile']['class'] = $(this).find('option:selected').attr('levelclass');
    user['level'] = $(this).find('option:selected').attr('level');
	localStorage.setItem('user',JSON.stringify(user));
});
$('.pass').live('click',function(){
	var data = $(this).siblings('.escdata').html();
	var chatInfo  = $(this).parent('.chatInfo');
	chatInfo.find('.pass').remove();
	data = unescape(data);
	data = JSON.parse(data);
	data['ischeck']=1;
	ws.onopen(JSON.stringify(data));
});



function buju(e){
	var ob = $('.main').children('div').toArray();
	switch(e){
		case '0':

			break;
		case '1':
			/*保留聊天和视频区域*/

			break;
		default:
			break;
	}
	$('.main').html(ob);
}

function bg(e){
	
	$('body').css('background-image','url("/static/images/'+e+'.jpg")');
	
}

//设置用户信息
function setUserInfo(user,flag){
    $('#userHead').attr('src',user['head']);
    $('#userName').html(user['nickname']);
}

function artwork(p){
    layer.photos({
        photos: p
        ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
		,closeBtn:true
    });
}

//前台设置
$('.setup li:gt(0)').css('display','none');
$('.setup').hover(function(){
	$('.setup li:eq(0)').siblings('li').css('display','block');
},function(){
    $('.setup li:eq(0)').siblings('li').css('display','none');
});

function danmu(url,img,con){
    //弹幕设置
    var item={
        img:img, //图片
        info:con, //文字
        href:url, //链接
        close:true, //显示关闭按钮
        speed:19, //延迟,单位秒,默认8
        bottom:270, //距离底部高度,单位px,默认随机
        color:'#fff', //颜色,默认白色
        old_ie_color:'#000000', //ie低版兼容色,不能与网页背景相同,默认黑色
    }
    $('body').barrager(item);
}

function qq(obj){
	var key = $(obj).html();
	$.post('/index/index/qq',{key:key},function(data){
		location.href='tencent://message/?Uin='+data+'&Site=www.qq.com&Menu=yes';
	});
}

function matchAite(msg){
	msg = msg.replace(/\@[^\<]+/,'@您&nbsp;');
	return msg;
}

//桌面消息通知
function showDeskTopNotice(title,msg,img){
    var Notification = window.Notification || window.mozNotification || window.webkitNotification;
    if(Notification){
        Notification.requestPermission(function(status){
            //status默认值'default'等同于拒绝 'denied' 意味着用户不想要通知 'granted' 意味着用户同意启用通知
            if("granted" != status){
                return;
            }else{
                var tag = "sds"+Math.random();
                var notify = new Notification(
                    title,
                    {
                        dir:'auto',
                        lang:'zh-CN',
                        tag:tag,//实例化的notification的id
                        icon:img,//通知的缩略图,//icon 支持ico、png、jpg、jpeg格式
                        body:msg //通知的具体内容
                    }
                );
                notify.onclick=function(){
                    //如果通知消息被点击,通知窗口将被激活
                    //alert();
                },
                    notify.onerror = function () {
                        console.log("HTML5桌面消息出错！！！");
                    };
                notify.onshow = function () {
                    setTimeout(function(){
                        notify.close();
                    },5000)
                };
                notify.onclose = function () {
                    //console.log("HTML5桌面消息关闭！！！");
                };
            }
        });
    }else{
        console.log("您的浏览器不支持桌面消息");
    }
}


//建平仓
function depot(goods_type,name,goods,url){
	var str = '<div class="depot">';
		str += '<img src="/static/images/hongbao.png"  alt="">';
		str += '<span>'+goods_type+'</span>';
		str += '<span>商品:'+goods+'</span>';
		str += '<span>'+name+'</span>';
		str += '<a href="'+url+'" target="__blank">[点击查看]</a>';
		str += '</div>';
		$('.chat').append(str);
}