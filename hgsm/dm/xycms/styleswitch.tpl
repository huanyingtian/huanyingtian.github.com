<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>样式切换</title>
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<script type='text/javascript' src='js/jquery.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<style type="text/css">
	.skin{margin-top:10px;}
	.skin li{float:left;width:90px;height:60px;cursor:pointer;margin-left:10px;display:inline;padding:5px;border:1px solid #ddd;}
	.skin li a{display:block;width:100%;height:60px;text-align:center;vertical-align:middle;line-height:60px;
font-weight:normal;text-decoration:none;font-size:12px;position:relative;overflow:hidden;color:#fff;}
	.skin li a span{display:block;display:none;position:absolute;height:24px;line-height:24px;background:#27ae61;width:100%;left:0;top:18px;
color:#fff;-webkit-box-shadow:0 2px 3px #000;-moz-box-shadow:0 2px 3px #000;box-shadow:2px 1px 6px #000;}

	.admin .skin li.s1 a{background:#004986;}
	.admin .skin li.s2 a{background:#00A0B1;}
	.admin .skin li.s3 a{background:#73bc0e;}
	.admin .skin li.s4 a{background:#e18814;}
	.admin .skin li.s5 a{background:#cd2410;}
	.admin .skin li.s6 a{background:#1e8fc6;}

	.mobile .skin li.s1 a{background:#e33b3d;}
	.mobile .skin li.s2 a{background:#00A0B1;}
	.mobile .skin li.s3 a{background:#555;}
	.mobile .skin li.s4 a{background:#8CBF26;}
	.mobile .skin li.s5 a{background:#36a9e1;}
	.mobile .skin li.s6 a{background:#fbb450;}

    #kf .skin li.s1 a{background:#40c0ac;}
	#kf .skin li.s2 a{background:#8838cc;}
	#kf .skin li.s3 a{background:#ffc713;}
	#kf .skin li.s4 a{background:#e5212d;}
	#kf .skin li.s5 a{background:#e65a22;}
	#kf .skin li.s6 a{background:#78cf1b;}
	#kf .skin li.s7 a{background:#3c96fc;}

	.skin li a .pure{font-size:16px;}
	.skin li.hover{}
	.skin li.hover a{}
	.skin li.hover a span{display:block;}

	.skin li.on{background:#eee;}
	.skin li.on a{text-align:center;}
	.skin li.on a span{display:block;}
	.mobile{margin-top:15px;}
	.switch h4{font-weight:bold;background:#eee;height:30px;line-height:30px;padding-left:15px;}
	#kf {margin-top: 20px;}
</style>
</head>
<body>
<div class="main-wrap">
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>样式切换</p></div>
  <div class="main-cont">
    <h3 class="title">样式管理</h3>
    <div class="switch mobile">
    	<h4>手机站点样式切换</h4>
    	<ul class="skin clear">
    		<li class="s1" rel="style1"><a><span>当前选择</span></a></li>
    		<li class="s2" rel="style2"><a><span>当前选择</span></a></li>
    		<li class="s3" rel="style3"><a><span>当前选择</span></a></li>
    		<li class="s4" rel="style4"><a><span>当前选择</span></a></li>
    		<li class="s5" rel="style5"><a><span>当前选择</span></a></li>    		
    		<li class="s6" rel="style6"><a><span>当前选择</span></a></li>
    	</ul>
    </div>
      <div id='kf' class="switch">
    	<h4>在线客服样式切换</h4>
    	<ul class="skin clear">
    		<li class="s1" rel="1"><a><span>当前选择</span></a></li>
    		<li class="s2" rel="2"><a><span>当前选择</span></a></li>
    		<li class="s3" rel="3"><a><span>当前选择</span></a></li>
    		<li class="s4" rel="4"><a><span>当前选择</span></a></li>
    		<li class="s5" rel="5"><a><span>当前选择</span></a></li>    		
    		<li class="s6" rel="6"><a><span>当前选择</span></a></li>
    		<li class="s7" rel="7"><a><span>当前选择</span></a></li>
    	</ul>
    </div>
  </div>
</div>
<script>
$(function(){
	var current_style = '<!--{$current_style}-->';
	var mobile_style  = '<!--{$mobile_style}-->';
	var contact_style =  '<!--{$contact_style}-->'
	$(".admin > .skin > li[rel='"+ current_style +"']").addClass('on');
	$(".mobile > .skin > li[rel='"+ mobile_style +"']").addClass('on');
	$("#kf > .skin > li[rel='"+ contact_style +"']").addClass('on');

	$('.skin > li').hover(function(){
		$(this).addClass('hover');
	},function(){
		$(this).removeClass('hover');
	});

	//后台样式切换
	$('.admin > .skin > li').click(function(){
		$(this).addClass('on').siblings().removeClass('on');
		var style = $(this).attr('rel');
		var top_obj = $('#styleswitch', window.parent.document);
		var style_href = top_obj.attr('href');
		var new_style = style_href.replace(style_href.substr(style_href.indexOf('style')), style + '.css');
		top_obj.attr('href', new_style);
		$.ajax({
	    	type: "POST",
	    	url: "styleupdate.php",
	    	dataType: 'text',
	    	data: "style=" + style,
	    	success: function(data){}
		});
	});

	//手机站点样式切换
	$('.mobile > .skin > li').click(function(){
		$(this).addClass('on').siblings().removeClass('on');
		var style = $(this).attr('rel');
		$.ajax({
	    	type: "POST",
	    	url: "styleupdate.php",
	    	dataType: 'text',
	    	data: "mobile_style=" + style,
	    	success: function(data){}
		});
	});

		$('#kf > .skin > li').click(function(){
		$(this).addClass('on').siblings().removeClass('on');
		var style = $(this).attr('rel');
		$.ajax({
	    	type: "POST",
	    	url: "styleupdate.php",
	    	dataType: 'text',
	    	data: "contact_style=" + style,
	    	success: function(data){}
		});
	});

});
</script>

</body>
</html>
