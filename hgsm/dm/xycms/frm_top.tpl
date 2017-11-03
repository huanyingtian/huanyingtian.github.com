<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>top</title>
<link rel="stylesheet" type="text/css" href="xycms/css/top.css" />
<link rel="stylesheet" type="text/css" href="xycms/css/style1.css" id="styleswitch" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/top.js"></script>
</head>
<body>
<div id="top">
  <div class="top1">
  <div class="logo">祥云网站管理系统</div>
  <div class="right">
    <p>您好！<span class="username"><!--{$uc_adminname}--></span>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="xycms_admin.php?action=changepassword" target="main">修改密码</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="../" target="_blank">网站首页</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="logout.php" target="_top">退出登录</a></p>
  </div>
  <div class="clearboth"></div>
  </div>
  <div class="top2">
    <div id="navs">
	<ul>
    <li class="nav_left"></li>
	  <li><a href="frm_left.php?mod=index">首页</a></li>
    <li><a href="frm_left.php?mod=content">内容中心</a></li>
	  <li><a href="frm_left.php?mod=product">产品管理</a></li>
	  <li><a href="frm_left.php?mod=info">新闻管理</a></li>
	  <li><a href="frm_left.php?mod=other">营销中心</a></li>
    <li><a href="frm_left.php?mod=system">系统设置</a></li>
    <!--{if $uc_adminname == 'master'}-->
    <li><a href="frm_left.php?mod=super">高级设置</a></li>
    <!--{/if}-->
    <li class="nav_right"></li>
	</ul>  
  </div>
  </div>
</div>
</body>
</html>