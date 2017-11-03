<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>站点设置</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<script type="text/javascript" src='../data/editor/kindeditor.js'></script>
<script type="text/javascript">
$(function() { 
$(".login-btn").hover(
  function () {
    $(this).addClass("login-btn2");
  },function () {
    $(this).removeClass("login-btn2");
  }
)
}); 
</script>
</head>
<body>

<div class="main-wrap">
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>推广中心</p></div>
  <div class="main-cont">
	<h3 class="title">推广中心</h3>
    <div class="seo">
    <div class="login">网站统计</div>
    <div class="main">
      <div class="seo_m"><a target="_blank" id="tj_a" href="<!--{$config.tj_url}-->">点击查看统计详细</a></div>
    </div>
    </div>
  </div>
  <div style="clear:both;"></div>
</div>

</body>
</html>
