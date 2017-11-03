<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>管理员登录-[<!--{$config.sitename}-->]</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link href="xycms/css/admin.css" rel="stylesheet" type="text/css" />
<style type="text/css">
html{ background:#F2F5F8;}
body{ background:#F2F5F8;}
</style>
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<!--[if lte IE 6]>
<script type='text/javascript' src='js/DD_belatedPNG-min.js'></script>
<script language="javascript">DD_belatedPNG.fix('.login-tit,.admin-logo,.tit');</script>
<![endif]-->
</head>
<body>
<div id="login-wrap">
  <div class="login-main">
	<div class="login-cont">
	  <form id="loginFrm" action="login2.php" method="post" onsubmit="return checkform();">
	  <input type="hidden" name="action" value="loginpost" />
	  <div class="account1">
	    <label>登录帐号：</label>
		<input class="input-txt w180" id="username" name="username" type="text" />
	  </div>
	  <div class="account1">
	    <label for="">登录密码：</label>
		<input class="input-txt w180" id="password" name="password" type="password" />
	  </div>	  
	  <!--<input class="admin-btn" onfocus="this.blur()" name="" type="submit" value="登 录" />-->
	  <input class="admin-btn-no" name=""  type="submit" value="登 录" />
	  </form>
	</div>
  	<div class="copyright">
		Powered by <a href="http://www.cn86.cn">祥云平台</a> Copyright &copy;2010-2012   技术支持: <span style="color:#106bb3">0512-36869916</span>
	</div>
  </div>
</div>
</body>
</html>
<script language="javascript" type="text/javascript">
function refreshCc() {
	var ccImg = document.getElementById("checkCodeImg");
	if (ccImg) {
		ccImg.src= ccImg.src + '&' +Math.random();
	}
}
function checkform(){
    if($("#username").val()==""){
	    alert("登录帐号不能为空");
		$("#username").focus();
		return false;
	}
    if($("#password").val()==""){
	    alert("登录密码不能为空");
		$("#password").focus();
		return false;
	}
	return true;
}
</script>
