<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>排名效果</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<link type="text/css" rel="stylesheet" href="xycms/css/other.css" media="screen" />
<link href="xycms/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<script type="text/javascript" src='../data/editor/kindeditor.js'></script>
<script src="js/datepicker/WdatePicker.js"></script>
</head>
<body>
<!--{if $action == ''}-->
	<div class="main-wrap">
	  <div class="path"><p>当前位置：排名效果</p></div>
	  <div class="main-cont">
	  	<!--{if $ranking eq 1}-->
		<iframe id="iframepage" name="right" src="<!--{$iframUrl}-->" onload="changeFrameHeight()" frameborder="false" scrolling="auto" style="border: none;" height="auto" width="100%" allowtransparency="true"></iframe> 
		<!--{else}-->
		<div class="ranking-notice"><img src="xycms/images/noticeman.jpg" />网站还没有上线无法参与排名哦!</div>
		<!--{/if}-->
	  </div>
	</div>
	<script type="text/javascript">
		function changeFrameHeight(){
		    var ifm    = document.getElementById("iframepage"); 
		    ifm.height = document.documentElement.clientHeight-130;
		}
		window.onresize = function(){  
		     changeFrameHeight();
		} 
	</script>	
<!--{else}-->
暂无信息
<!--{/if}-->
</body>
</html>
