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

$(window).resize(function(){
	
	resetBase();//窗口改变时,重新计算元素高度
	
});

$(window).load(function(){
	
	resetBase();
	
});

function resetBase(){
	
	/*计算主体高度*/
	var head = 50; 		//头部高度
	var foot = 32;		//底部高度
	var more = 8+8;		//上下外边距

	var winHeight = $(window).height();
	winHeight = winHeight-head-foot-more;
	$('.main').height(winHeight);
	
	//计算聊天窗口高度
	var ms = winHeight-more-170;
	$('.message').height(ms);
	
	//计算视频区宽度
	var winWidth = $(window).width();
	var column0 = 70;
	var column1 = 220;
	var column2 = 0;
	var margin  = 40.5;
	
	var videoWidth = winWidth-column0-column1-column2-margin;
	$('.column3').width(videoWidth*0.6);
	$('.column2').width(videoWidth*0.4);
	
	//计算视频块高度
	var videoHeight = winHeight-40-115;
	$('.videoLive').height(videoHeight);
	
}

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



