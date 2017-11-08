var winWidth = window.innerWidth;
var winHeight= window.innerHeight;
function scheme1(){
	//隐藏菜单栏
	$('.column0').hide();
	//隐藏会员列表
    $('.column1').hide();
    //视频放左侧
    $('.column3').css('float','left');
    //聊天放右侧
    $('.column2').css('float','right');
    //调整宽度 去除margin
    $('.column2').css('margin',0);
    $('.column3').css('margin',0);
    $('.column2').css('width',winWidth*0.4);
    $('.column3').css('width',winWidth*0.6-10);
}

function scheme2(){
    //菜单栏宽度70+10
	winWidth -=80;
    //隐藏会员列表
    $('.column1').hide();
    //视频放左侧
    $('.column3').css('float','left');
    //聊天放右侧
    $('.column2').css('float','right');
    //调整宽度 去除margin
    $('.column2').css('margin',0);
    $('.column3').css('margin',0);
    $('.column2').css('width',winWidth*0.4);
    $('.column3').css('width',winWidth*0.6-10);
}
scheme2();