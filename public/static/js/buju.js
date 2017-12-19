/**
 *  布局js
 * */
function scheme(){
    var winWidth = $(window).width();//可见区域宽度
    var winHeight= $(window).height();//可见区域高度
    var head = 50;//头部高度
    var foot = 32;//底部高度
    var MENU = true;//是否显示菜单栏
    var USERLIST = false;//是否显示用户列表
    var main = winHeight-head-foot-16;//去除上下margin的主体区域高度
    var menuHeight = 70;//菜单栏宽度
    var listHeight = 220;//用户列表宽度
    winWidth = MENU?winWidth-menuHeight-10:winWidth;
    winWidth = USERLIST?winWidth-listHeight-10:winWidth;
    var chatWidth = winWidth*0.4-10;
    var liveWidth = winWidth*0.6-10;

    if(!MENU){
        $('.column0').hide();
    }
    if(!USERLIST){
        $('.column1').hide();
    }

    //计算聊天窗口高度
    var ms = main-112;
    $('.message').height(ms);

    //计算视频块高度
    var videoHeight = main-40-115;
    $('.videoLive').height(videoHeight);

    $('.main').height(main);
    //视频放左侧
    $('.column3').css('float','left');
    //聊天放右侧
    $('.column2').css('float','right');
    $('.column2').css('width',chatWidth);
    $('.column3').css('width',liveWidth);
}

scheme();

$(window).resize(function(){

    scheme();//窗口改变时,重新计算元素高度

});

$(window).load(function(){

    scheme();
    scrollBar();//重置一下聊天窗口的滚动条

});
