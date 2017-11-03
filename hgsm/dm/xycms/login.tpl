<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>管理员登录-[<!--{$config.sitename}-->]</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link href="xycms/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="xycms/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="xycms/css/component.css" rel="stylesheet" type="text/css" />
<link href="xycms/css/login.css" rel="stylesheet" type="text/css" />
<link href="xycms/css/<!--{$style}-->.css" rel="stylesheet" type="text/css" />
<link href="xycms/css/animate.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type='text/javascript' src='js/jump.js'></script>
<script type='text/javascript' src='js/vue.js'></script>
</head> 
<body id="login-view">
<div class="login-error"><img src="<!--{$urlpath}-->dm/xycms/images/notice.png" />密码连续累计出错超过5次，90秒后才能重新登陆！</div>
<div class="logo-home">
    <div class="login-logo">
        <img src="<!--{$urlpath}-->dm/xycms/images/login.png" >
        <!--{if $version == 'fuxing'}-->
        <span>福星后台管理系统</span>
        <!--{else}-->
        <span>祥云平台管理系统</span>
        <!--{/if}-->
    </div>
</div>
<div id="stage">
    <div id="login">
    <form id="loginFrm" action="login.php" method="post" onsubmit="return checkform();">
    <input type="hidden" name="action" value="loginpost" />
        <div id="content">
            <div class="login-username">
                <span></span>
                <input type="text" name="username" autocomplete="off" class="form-control" placeholder="账号" required autofocus >
            </div>
            <div class="login-username">
                <span class="b"></span>
                <input type="password" name="password" autocomplete="off" class="form-control password" placeholder="密码" required >
            </div>
            <div class="login-remenber">
				<input class="form-control wyy" id="checkcode" name="checkcode" type="text" autocomplete="off" placeholder="验证码" required />
				<img id="checkCodeImg" onclick="refreshCc()" src="../data/include/imagecode.php?act=verifycode" width="100" height="36" />	
            </div>
            <button class="btn btn-lg btn-warning btn-block" type="submit">登录</button>
        </div>
        </form>
        <div class="copyright">Copyright &copy;2017  版本：<!--{$vsion}-->  <a href="../" target="_blank">返回首页</a></div>
    </div>
</div>

<script type='text/javascript' src='js/command.js'></script>
<script language="javascript" type="text/javascript">
var notice = '<!--{$notice}-->';
if(notice == 'error'){
	$(".login-error").css('display','block');
	$(".login-error").addClass('animated fadeInDownBig');
	setTimeout(function(){
		$(".login-error").removeClass('animated fadeInDownBig').addClass('animated bounceOutLeft');
	},4000);
}
function refreshCc() {
	var ccImg = document.getElementById("checkCodeImg");
	if(ccImg){
		ccImg.src = '../data/include/imagecode.php?act=verifycode&random='+Math.random();
	}
}

</script>

</body>
</html>

