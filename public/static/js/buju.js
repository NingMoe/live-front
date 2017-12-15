var winWidth = window.innerWidth;//可见区域宽度
var winHeight= window.innerHeight;//可见区域高度
var head = 50;//头部高度
var foot = 32;//底部高度
/**
 *
 * */
function scheme1(){


    //计算main区域高度
    var main = winHeight-head-foot;
    $('.main').height(main-16);//减去上下margin

    //菜单栏宽度70+10
    var width = winWidth-80;
    width = width-230;
    //隐藏会员列表
    //$('.column1').hide();
    //视频放左侧
    $('.column3').css('float','left');
    //聊天放右侧
    $('.column2').css('float','right');
    //调整宽度 去除margin
    $('.column2').css('margin',0);
    //$('.column3').css('margin',0);
    $('.column2').css('width',width*0.4);
    $('.column3').css('width',width*0.6-10);
}

/**
 * 隐藏用户列表 2
 * */
function scheme2(){


    //计算main区域高度
    var main = winHeight-head-foot;
    $('.main').height(main-16);//减去上下margin

    //菜单栏宽度70+10
	var width = winWidth-80;
    //隐藏会员列表
    $('.column1').hide();
    //视频放左侧
    $('.column3').css('float','left');
    //聊天放右侧
    $('.column2').css('float','right');
    //调整宽度 去除margin
    $('.column2').css('margin',0);
    $('.column3').css('margin',0);
    $('.column2').css('width',width*0.4);
    $('.column3').css('width',width*0.6-10);
}
scheme2();