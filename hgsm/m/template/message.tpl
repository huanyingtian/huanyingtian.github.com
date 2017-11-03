<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0" name="viewport" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="telephone=no" name="format-detection" />
<link rel="apple-touch-icon-precomposed" href="<!--{$murl_index}-->icon.png"/>
<title><!--{$config.mtitle}-->_<!--{$config.sitetitle}--></title>
<meta name="keywords" content="<!--{$metakeyword}-->" />
<meta name="description" content="<!--{$metadescription}-->" />
<link rel="stylesheet" type="text/css" href="<!--{$m_path}-->style/<!--{$csspath}-->/reset.css" />
<link rel="stylesheet" type="text/css" href="<!--{$m_path}-->style/<!--{$csspath}-->/ui.css" />
<link rel="stylesheet" type="text/css" href="<!--{$m_path}-->style/<!--{$csspath}-->/app.css" />  
 

<script type="text/javascript" src="<!--{$m_path}-->js/zepto.js"></script>
<script type="text/javascript" src="<!--{$m_path}-->js/iscroll.js"></script>
<script type="text/javascript" src="<!--{$m_path}-->js/jquery-1.8.3.min.js"></script>

<script type="text/javascript">
	var HOME_URL = '<!--{$murl_index}-->';
	var ajax_url = '<!--{$murl_index}-->library/ajax_load.php';
	var title = '<!--{$config.sitename}-->';
</script>

</head>
<body>
   <!--{include file="$pathtpl/template/model/header.tpl"}-->
   <!--{include file="$pathtpl/template/model/nav.tpl"}-->
   <div class="message_div">
   <form action="<!--{$url_index}-->message1.php" id="message" method="post">
        <div class="item"><input placeholder="联系人" name="name" /></div>
        <div class="item"><input placeholder="座机/手机号码" name="contact" /></div>
        <div class="item"><textarea class="content" placeholder="留言内容" name="content"></textarea></div>
        <div class="item code">
		<input placeholder="验证码" name="verifycode" /><img id="checkcode" src="<!--{$pat}-->m/imagecode.php?act=verifycode" width="100" height="36" />
	    </div>
        <div class="btn"><input type="submit" class="submit" value="提交留言" /></div>
   </form>
   </div>
 
 <div class="distraction">
 </div>
<!--{include file="$pathtpl/template/model/footer.tpl"}-->
 <!--{include file="$pathtpl/template/model/plug.tpl"}-->
 <script>
     $('body').css('background','#e7ebe9');
	 var code_src = $('#checkcode').attr('src');
	 $('.item').on('click', '#checkcode', function(){
		$('#checkcode').attr('src', code_src + '&rand=' + Math.random());
	});
	 
 </script>
</body>
</html>