<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"D:\phpStudy\WWW\yiqiu\public/../application/index\view\index\index.html";i:1514269690;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $roominfo['room_title']; ?></title>
	<meta name="viewport" content="width=device-width" />
    <meta name="keywords" content="<?php echo $roominfo['room_keyword']; ?>" />
    <meta name="Description" content="<?php echo $roominfo['room_description']; ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="/static/css/swiper-3.4.2.min.css" rel="stylesheet" />
	<link href="/static/layui/css/layui.css" rel="stylesheet" />
	<link href="/static/css/index.css" rel="stylesheet" />
	<link href="/static/css/face.css" rel="stylesheet" />
	<link rel="stylesheet" href="/static/css/barrager.css">
	<style>
		.swiper-container {
			width: 100%;
			height: 100%;

		}
		.swiper-slide {
			text-align: center;
			font-size: 18px;
			background: #fff;

			/* Center slide text vertically */
			display: -webkit-box;
			display: -ms-flexbox;
			display: -webkit-flex;
			display: flex;
			-webkit-box-pack: center;
			-ms-flex-pack: center;
			-webkit-justify-content: center;
			justify-content: center;
			-webkit-box-align: center;
			-ms-flex-align: center;
			-webkit-align-items: center;
			align-items: center;
		}
	</style>
</head>
<body style="
<?php if(!(empty($roominfo['room_bg']) || (($roominfo['room_bg'] instanceof \think\Collection || $roominfo['room_bg'] instanceof \think\Paginator ) && $roominfo['room_bg']->isEmpty()))): ?>
background: url('<?php echo $roominfo['room_bg']; ?>')
<?php else: ?>
background: url('/static/images/bg.jpg')
<?php endif; ?>
">
	<div class="header">
		<div class="logo"><img src="/static/images/logo.png" alt=""></div>
		<div class="guanliyuan">
			<ul class="setup">
				<?php if(!(empty($set) || (($set instanceof \think\Collection || $set instanceof \think\Paginator ) && $set->isEmpty()))): foreach($set as $val): ?>
				<li class="layui-nav-item layui-this"><a href="javascript:popups(700,600,'/<?php echo $val['link']; ?>')"><?php echo $val['menu_name']; ?></a></li>
				<?php endforeach; endif; ?>
            </ul>
			<?php if($user['profile']['level'] >= 10): ?>
			<span id="people_number" style="position:absolute;left:100px;background: #333;color:white;">正在统计人数..</span>
			<?php endif; ?>
		</div>
		<div class="hr">
			<ul>
				<li>
					<a href="#">
						<img id="userHead" src="" alt="" />
						<span id="userName"></span>
					</a>
				</li>
				<?php if($user['level']>1): ?>
					<li>
						<a href="javascript:logout()">
							退出
						</a>
					</li>
					<?php else: ?>
					<li>
						<a href="javascript:popups(378,530,'/index/User/login')">
							登录/注册
						</a>
					</li>
				<?php endif; ?>
				<li class="gexinghua">
					<a href="">
						<img src="/static/images/layer.png" alt="" />
					</a>
					<div class="selfdom">
						<div class="domWrap">
							<span>个性化</span>
						</div>
						<p class="domTitle">布局</p>
						<div class="buju">
							<p class="bujuTitle">观看模式</p>
							<div class="bujuContent">
								<a  class="caidan caidan1 select" dataNumber="0"></a>
								<a  class="caidan caidan2" dataNumber="1"></a>
							</div>
						</div>
						<p class="domTitle">背景图</p>
						<div class="buju">
							<div class="bujuContent">
								<a dataNumber="0" class="bg select"><img src="/static/images/0.jpg" alt="" /></a>
								<a dataNumber="1" class="bg"><img src="/static/images/1.jpg" alt="" /></a>
								<a dataNumber="2" class="bg"><img src="/static/images/2.jpg" alt="" /></a>
								<a dataNumber="3" class="bg"><img src="/static/images/3.jpg" alt="" /></a>
								<a dataNumber="4" class="bg"><img src="/static/images/4.jpg" alt="" /></a>
								<a dataNumber="5" class="bg"><img src="/static/images/5.jpg" alt="" /></a>
							</div>
						</div>
					</div>
				</li>
			</ul>
			
		</div>
	</div>
	<div class="main">
		<div class="column0">
			<ul>
				<li>
					<a href="javascript:popups(800,500,'http://www.jin10.com/example/jin10.com.html')">
						<img src="/static/images/menu_calendar.png" alt="" />
						<p>财经日历</p>
					</a>
				</li>
				<li>
					<a href="javascript:popups(1000,600,'/index/Depot/jiancang')">
						<img src="/static/images/menu_notice.png" alt="" />
						<p>建仓提醒</p>
					</a>
				</li>
				<li>
					<a href="javascript:popups(1000,600,'/index/Depot/pingcang')">
						<img src="/static/images/menu_finance.png" alt="" />
						<p>平仓提醒</p>
					</a>
				</li>
				<li>
					<a href="javascript:popups(1000,600,'/index/Article/index')">
						<img src="/static/images/menu_vote.png" alt="" />
						<p>葵花宝典</p>
					</a>
				</li>
				<li class="kcb">
					<a href="javascript:void(0)">
						<img onclick="artwork('.kcb')" src="/static/images/menu_course.png" layer-src="<?php echo $roominfo['room_kcb']; ?>" alt="" />
						<p>课程安排</p>
					</a>
				</li>
				<li id="phone-tip" >
					<a href="javascript:void(0)">
						<img src="/static/images/menu_phone.png" alt="" />
						<p>手机直播</p>
					</a>
				</li>
			</ul>
		</div>
		<div class="column1">
			<ul class="userTable">
				<li class="select">在线会员</li>
				<li>在线客服</li>
			</ul>
			<div class="userListWrap">
				<ul class="userList">
					<li class="userSearch">
						<input class="searchText" type="text" />
						<a class="searchBtn" href=""></a>
					</li>

						<li class="userInfo" username="游客-30924553" id="">
							<img src="" class="avatar" />
							<span class="nickname"></span>
							<span class="time"></span>
							<img src="" class="groupion" />
						</li>

				</ul>
			</div>
			<div style="display:none;" class="userListWrap">
				<ul class="userList">
					<li class="userInfo">
						<img src="/static/images/youke0.png" class="avatar" />
						<span class="nickname">游客-30924553</span>
						<img src="/static/images/level.png" class="groupion" />
					</li>
					<li style="text-align:center;">
						<a class="kefu tiao_fly" href=""></a>
						<span class="kefuPhone">电话:11111111</span>
					</li>
				</ul>
			</div>
		</div>
		<div class="column2">
			<!--
			<div class="tableWrap">
				<ul class="table">
					<li>大厅</li>
					<li>快讯</li>
				</ul>
			</div>
			<div class="notify">
				<marquee direction=left><?php echo $roominfo['room_notice']; ?></marquee>
			</div>
			-->
			<div class="message">
				<div class="activity" style="display: none;">
					<div class="hongbao">
						<a href="">
							<img src="/static/images/g_hb.gif" />
						</a>
					</div>
					<div class="choujiang">
						<a href="">
							<img src="/static/images/g_cj.gif" />
						</a>
					</div>
					<div class="qingping">
						<a id="chatClear">清屏</a>
					</div>
				</div>
				<div class="chat">

				</div>
			</div>
			<div class="serverQQ">
				<ul>
					<li style="">
						<a onclick="qq(this)" class="kefuqq" href="javascript:void(0)">高级助理</a>
					</li>
					<li style="">
						<a onclick="qq(this)" class="kefuqq" href="javascript:void(0)">错单解套</a>
					</li>
					<li style="">
						<a onclick="qq(this)" class="kefuqq" href="javascript:void(0)">最新策略</a>
					</li>
					<li style="">
						<a onclick="qq(this)" class="kefuqq" href="javascript:void(0)">在线客服</a>
					</li>
					<li style="">
						<a onclick="qq(this)" class="kefuqq" href="javascript:void(0)">老师助理</a>
					</li>
				</ul>
			</div>
			<div class="toolbar">
				<a class="face" href="javascript:showFacePanel(this,'#editor')"></a>
				<a id="upload"></a>
				<?php if($user['level']>=8): ?>
					<select name="jiqi" id="jiqi">
						<option id="current_robot" avatar="<?php echo $user['head']; ?>" levelclass="<?php echo $user['profile']['class']; ?>" value="<?php echo $user['level']; ?>"  level="<?php echo $user['level']; ?>" name="<?php echo $user['nickname']; ?>"><?php echo $user['nickname']; ?>----<?php echo $user['profile']['name']; ?></option>
						<?php if(is_array($role) || $role instanceof \think\Collection || $role instanceof \think\Paginator): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						<option value="<?php echo $vo['level']; ?>" avatar="<?php echo $vo['avatar']; ?>"  levelclass="<?php echo $vo['profile']['class']; ?>" level="<?php echo $vo['level']; ?>"  name="<?php echo $vo['name']; ?>"><?php echo $vo['name']; ?>----<?php echo $vo['profile']['name']; ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				<?php endif; ?>
			</div>
			
			<div class="EnMessage">
				<div class="message_editor" id="editor" contenteditable="true"></div>
				<div class="sendBtn">
					<p style="margin-top: 8px;">发送</p>
					<p>(Enter)</p>
				</div>
			</div>
			<div id="face" style="position: absolute; bottom: 100px; left: inherit; display: none;" toinput="#editor"></div>
		</div>
		<div class="column3">
			<div class="videoTitle">
				<p>视频直播</p>
			</div>
			<div class="videoLive">
				<gs:video-live id="videoComponent" site="shrz888.gensee.com" ctx="webcast" ownerid="0c870b0f9ebb46318bdac9de97e4eae3" uname="" authcode="" class="gs-sdk-widget"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="_GS_FLASH_ID_videoComponent" width="100%" height="100%" codebase="https://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab#version=11.1.0.0">	<param name="movie" value="http://static.gensee.com/webcast/static/sdk/flash/GenseeEasyLive.swf?160426">	<param name="wmode" value="transparent">	<param name="quality" value="high">	<param name="bgcolor" value="#000000">	<param name="allowScriptAccess" value="always">	<param name="allowFullScreen" value="true">	<param name="flashvars" value="sc=0&amp;entry=http%3A%2F%2Fshrz888.gensee.com%2Fwebcast&amp;code=0c870b0f9ebb46318bdac9de97e4eae3__f2557eea287a4c78916afc032a34632f&amp;lang=&amp;nickName=visitor_2EasGn&amp;httpMode=false&amp;group=&amp;widgetid=videoComponent&amp;userdata=&amp;showCBar=&amp;backURI=&amp;ver=4.0&amp;publicChat=&amp;init=&amp;liveImprovedMode=false&amp;visible=true&amp;embedNetSettings=true&amp;batchRecChat=false&amp;fullscreen=false&amp;staticPrefix=http%3A%2F%2Fstatic.gensee.com%2Fwebcast">	<embed src="http://static.gensee.com/webcast/static/sdk/flash/GenseeEasyLive.swf?160426" quality="high" bgcolor="#000000" wmode="transparent" width="100%" height="100%" name="_GS_FLASH_ID_videoComponent" align="middle" play="true" loop="false" allowscriptaccess="always" allowfullscreen="true" type="application/x-shockwave-flash" flashvars="sc=0&amp;entry=http%3A%2F%2Fshrz888.gensee.com%2Fwebcast&amp;code=0c870b0f9ebb46318bdac9de97e4eae3__f2557eea287a4c78916afc032a34632f&amp;lang=&amp;nickName=visitor_2EasGn&amp;httpMode=false&amp;group=&amp;widgetid=videoComponent&amp;userdata=&amp;showCBar=&amp;backURI=&amp;ver=4.0&amp;publicChat=&amp;init=&amp;liveImprovedMode=false&amp;visible=true&amp;embedNetSettings=true&amp;batchRecChat=false&amp;fullscreen=false&amp;staticPrefix=http%3A%2F%2Fstatic.gensee.com%2Fwebcast" pluginspage="http://www.adobe.com/go/getflashplayer">	</object></gs:video-live>
			</div>
			<div class="banner">
				<div class="swiper-container swiper-container-horizontal">
					<div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
						<?php foreach($banner as $val): ?>
						<div class="swiper-slide" style="width: 1080px; margin-right: 30px;">
							<img style="width:100%;height:100%;" src="<?php echo $val['img']; ?>" alt="">
						</div>
						<?php endforeach; ?>
					</div>
					<!-- Add Pagination -->
					<div class="swiper-pagination">

					</div>
					<!-- Add Arrows -->
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer">
		<div class="fenxiang">
		<!--
			<a style="color:white;" href="javascript:void(0)">分享到</a>
			<a class="shearico" href="javascript:void(0);" data-cmd="tsina" title="分享到新浪微博"  style="background-position-x:-120px;"></a>
			<a class="shearico" href="javascript:void(0);" data-cmd="qzone" title="分享到QQ空间" style="background-position-x:-150px;"></a>
			<a class="shearico" href="javascript:void(0);" data-cmd="tqq" title="分享到腾讯微博" style="background-position-x:-93px;"></a>
		-->
			<!-- JiaThis Button BEGIN -->
			<div class="jiathis_style_24x24" style="margin-top:4px;">
				<a class="jiathis_button_qzone"></a>
				<a class="jiathis_button_tsina"></a>
				<a class="jiathis_button_tqq"></a>
				<a class="jiathis_button_weixin"></a>
			</div>
			<script type="text/javascript" src="http://v3.jiathis.com/code_mini/jia.js" charset="utf-8"></script>
			<!-- JiaThis Button END -->
		</div>
	</div>
	<div class="mousemenu">
		<ul>
			<li style="color:#FF5722;font-size: 12px;text-align: center;">游客32143244</li>
			<li class="aite">@他(她)</li>
			<li class="banned">踢出房间</li>
		</ul>
	</div>
	<script type="text/javascript" src="/static/js/config.js"></script>
	<script type="text/javascript" src="/static/js/jquery.js"></script>
	<script type="text/javascript" src="/static/js/jquery.barrager.js"></script>
    <script type="text/javascript" src="/static/js/buju.js"></script>
	<script type="text/javascript" src="/static/js/md5.js"></script>
	<script type="text/javascript" src="/static/layui/layui.all.js"></script>
	<script type="text/javascript" src="/static/js/index.js"></script>
	<script type="text/javascript" src="/static/js/swiper-3.4.2.jquery.min.js"></script>
	<script type="text/javascript" src="/static/js/socket.js"></script>
	<script type="text/javascript" src="/static/js/msg.js"></script>
	<script src="http://chat.51cyxj.com/static/layui/layui.js"></script>
	<script src="http://chat.51cyxj.com/static/js/kefu.js"></script>
	<script>

        var swiper = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            paginationClickable: true,
            spaceBetween: 30,
            centeredSlides: true,
            autoplay: 4000,
            autoplayDisableOnInteraction: false
        });


	function logout(){
	    localStorage.clear();
	    location.href="<?php echo url('User/logout'); ?>";
	}

    //表情包
    function showFacePanel(e,toinput){
        $('#face').css('display','block');
        $.get('<?php echo url("Index/face"); ?>',function(data){
            $('#face').html(data);
            $('#facenav li').click(function(){
                var rel = $(this).attr('rel');
                $('#face dl').hide();
                $('#f_'+rel).show();
                $(this).siblings().removeClass('f_cur');
                $(this).addClass('f_cur');
            });
            $('#face dd').click(function(){
                var img_link = $(this).find('img').attr('src');
                var img_alt  = $(this).attr('title');
                var cur = $('#msg_text').html();
                cur+= '<img src="'+img_link+'" alt="'+img_alt+'" />';
                $('#msg_text').html(cur);
                $('#msg_text').scrollTop( $('#msg_text').prop("scrollHeight"));
            });
        }).success(function(e){
            $(document).bind('mouseup',function(e){
                if($(e.target).attr('isface')!='1' && $(e.target).attr('isface')!='2')
                {
                    $('#face').hide();
                    $(document).unbind('mouseup');
                }
                else if($(e.target).attr('isface')=='1')
                {
                    var toinput =$('#face').attr("toinput");
                    if($(e.target).attr('src')!=undefined){
                        $(toinput).append('<img src="'+$(e.target).attr('src')+'" onresizestart="return false" contenteditable="false">');}
                }
            });
        });

    }

    if(typeof(WebSocket) !== 'function' || typeof localStorage !== 'object'){
        layer.msg('浏览器版本过低,建议使用最新版本的浏览器！');
    }
    //获取用户信息
	var user = '<?php echo $userinfo; ?>';
	localStorage.setItem('user',user);
	setUserInfo(JSON.parse(user));

    /*window.onbeforeunload = function(){
        return '确定离开此页面吗';
    }*/


	</script>


	<script>

		function popups(width,height,url){
            layer.open({
                title:false,
                area:[width+'px',height+'px'],
                content:url,
                type:2,
				fix:false,
            });
		}

		$('#phone-tip').hover(function(){
		    var that = this;
		    layer.tips('<img src="/static/images/cyliveqr.png" />',that,{tips:1,skin:'layui-layer-molv',time:5000});
		},function(){
		    layer.close(layer.index);
		});


		$(function(){

		    //查询在线人数
            $.post('/index/Index/get_number',{},function(data){
                data = JSON.parse(data);
                if(data.type=='success'){
                    $('#people_number').html('当前在线人数:'+data.number);
                }else{
                    $('#people_number').html('获取失败');
                }
            });

			//查询最近发言
			$.post('/index/Index/message',{},function(data){
			    data = JSON.parse(data);
			    var date;
			    var hour;
			    var minute;
			    for(var i=data.length-1;i>=0;i--){
                    data[i]['message'] = packageMsg(data[i]['cid'],data[i]['avatar'],data[i]['nickname'],data[i]['class'],data[i]['bg'],data[i]['style'],data[i]['send_time'],data[i]['message'],data[i]['mid']);
			        var id = $(data[i]['message']).attr('id');
			        $('.chat').append(data[i]['message']);
			        if(data[i]['is_check']==1){
						$('#'+id).append('<i class="case1" onclick="checkMessage(this)">审核通过</i><i class="case2" onclick="deleteMessage(this)">删除</i></div>');
					}
					//修改时间
					date = new Date(parseInt(data[i].send_time)*1000);
			        hour = date.getHours();
			        minute = date.getMinutes();
			        minute = minute>=10?minute:'0'+minute;
			        $('#'+id).find('.messageInfo').find('span').eq(1).html(hour+':'+minute);
				}
                scrollBar();
			});


            layui.use(['layim','upload'], function(){
                //执行实例
                var upload = layui.upload;
                upload.render({
                    elem: '#upload' //绑定元素
                    ,url: '<?php echo url("Upload/image"); ?>' //上传接口
                    ,done: function(res){
                        //上传完毕回调
                        var img = '<img class="sendImages" onclick="artwork(`.messageContent`)" src="'+res.src+'"><br />';
                        $('#editor').append(img);
                    }
                    ,error: function(){
                        //请求异常回调
                    }
                });


            });
		});
	</script>

</body>
</html>