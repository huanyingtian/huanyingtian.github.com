<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<!--{if $config.pcico eq ''}--><!--{else}-->
<link rel="shortcut icon" type="image/x-icon" href="../<!--{$config.pcico}-->" />
<!--{/if}-->
<title><!--{$plat_name}--></title>
<link href="xycms/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="xycms/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="xycms/css/component.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="xycms/css/index.css" />
<link rel="stylesheet" type="text/css" href="xycms/css/style.css" id="styleswitch" />
<script type='text/javascript' src='js/jquery-1.9.1.min.js'></script>
<script type='text/javascript' src='js/bootstrap.min.js'></script>
<script type='text/javascript' src='js/jump.js'></script>
<script type='text/javascript' src='js/vue.js'></script>
<script type='text/javascript' src='js/move.js'></script>
</head>
<body>
<!-- top -->
<div id="message-notice"><i class="fa fa-hand-o-right"></i><span></span></div>
<div class="top">
	<strong id="logo">
	<!--{if $version == 'fuxing'}-->
       福星后台
     <!--{else}-->
       祥云平台
    <!--{/if}--></strong>
	<div id="navs">
		<ul>
		  <li class="current"><a href="" rel="index">首 页</a></li>
	      <li><a href="" rel="content">内容中心</a></li>
		  <li><a href="" rel="product">产品管理</a></li>
		  <li><a href="" rel="info">新闻管理</a></li>
		  <li><a href="" rel="other">营销中心</a></li>
	      <li><a href="" rel="system">系统设置</a></li>
	      <!--{if $uc_adminname == 'master'}-->
	     	 <li><a href="" rel="super">高级设置</a></li>
	      <!--{/if}-->
		</ul>  
	</div>
	<ul class="top-list">
		<li><i class="fa fa-bookmark-o fa-size"></i><a href="../" target="_blank">网站首页</a></li>
		<li><i class="fa fa-user fa-size"></i><span><!--{$uc_adminname}--></span></li>
		<li class="manager">
			<i class="fa fa-cogs fa-size"></i><span>管理中心</span>
			<div class="manager-list">
				<a href="xycms_admin.php?action=changepassword" target="right"><i class="fa fa-unlock-alt"></i>修改密码</a>
				<a href="logout.php" target="_top"><i class="fa fa-unlink"></i>退出系统</a>
			</div>
		</li>
	</ul>
	<div class="clearboth"></div>
</div>
<!-- end -->
<div id="content">
<!-- left -->
	<div id="left_menuchange" class="left_menu"></div>
<!-- end -->

<!-- main -->
	<div class="right_frame">
		<div class="content" style="position:relative;overflow:hidden;zoom:1;">
			<iframe id="main_frame" name="right" src="admincp.php?mod=main" frameborder="false" scrolling="auto" style="border: none;" height="auto" width="100%" allowtransparency="true"></iframe>
		</div>
	</div>
<!-- end -->
</div>
<!-- script -->
<script>
window.onload = function (){
	wsize();
	$('.left_menu').load('frm_left.php', {'mod':'index'});
};

$(window).resize(function() {
	wsize();
});

//一级导航点击
$('#navs').on('click', 'a', function(e){
	e.preventDefault();
	e.stopPropagation();
	$(this).parent().addClass('current').siblings().removeClass('current');
	var mod = $(this).attr('rel');
	$('.left_menu').load('frm_left.php', {'mod':mod}, function(){
	$(".left_menu").find("a").first().click();
	});
	var leftwidth = parseInt($('.left_menu').css('width'));
	var notice    = document.getElementById('message-notice');
	var left_menu = document.getElementById("left_menuchange");
	if(leftwidth == 40){
		startMove(left_menu, "width", 200);
	}
});


//左侧导航点击
$('.left_menu').on('click', 'a', function(e){
	if($(this).data('url') != 'link'){
      e.preventDefault();
	  e.stopPropagation();
	}
	var target = $(this).attr('rel');
	$('.menu dd').removeClass('current');
	$(this).parent().addClass('current');
	$('#main_frame').attr('src', target);
});

$('.left_menu').on('click', 'h3', function(e){
	if($(this).find('span').hasClass('plus-change')) {
		$(this).find('span').removeClass('plus-change');
	}else {
		$(this).find('span').addClass('plus-change');
	}
	$(this).siblings('.menu-box').stop().slideToggle().parents('.menu').siblings().children('.menu-box').slideUp();
	$(this).find('span').parents('.menu').siblings().find('span').removeClass('plus-change');
});
	
function wsize(){
	var height = $(window).height() - 68;
	// $('#sidebar').height(height);
	$('.left_menu').height(height);
	$('#main_frame').height(height);
}

$(".manager").hover(function(){
	$(this).find(".manager-list").stop().slideDown();
},function(){
	$(this).find(".manager-list").stop().slideUp();
});	
$('.manager-list a').last().css('border','none');
</script>
</body>
</html>