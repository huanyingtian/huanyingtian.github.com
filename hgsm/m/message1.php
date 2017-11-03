<?php
define('ALLOWGUEST',true);
require '../source/core/run.php';
require './config/config.php';
require './config/m_app.php';

$name      = Core_Fun::rec_post("name",1);
$contact   = Core_Fun::rec_post("contact",1);
$content   = Core_Fun::rec_post("content",1);
$checkcode = $_POST['verifycode'];
 
if(strtolower($checkcode) != strtolower($_COOKIE['verifycode'])){
	msg::msge('验证码错误！');
}

$founderr = false;
$errmsg   = '';

if(!Core_Fun::ischar($name)){
	$founderr = true;
	$errmsg  .= "姓名不能为空.";
}
if(!Core_Fun::ischar($content)){
	$founderr = true;
	$errmsg  .= "内容不能为空.";
}

 

if($founderr==true){
	msg::msge($errmsg);
}
$array  = array(
		'name'=>$name,
		'contact'=>$contact,
		'content'=>$content,
		'timeline'=>time(),
		'ip'=>ip(),
);
if(isset($_COOKIE['count']) && intval($_COOKIE['count']) > 5){
	msg::msge('请不要重复提交留言！');
}
$db->insert(DB_PREFIX."guestbook",$array);
if($config['message_tel'] == 1){
	require '../source/core/sms.php';
	$tel1 = $config['tel'];
	$msg = "联系人：".$name."， 电话：".$contact."， 留言内容：".$content." -- 您的官方网站！[祥云平台]";
	$sms = new sms($tel1,$msg);
	$sms->send();
}

if(isset($_COOKIE['count'])){
	setcookie("count", intval($_COOKIE['count'])+1, time()+3600,'/');
}else{
	setcookie("count", 1, time()+3600,'/');
}
$url = PATH_URL."message/";
msg::msge('留言成功，我们将会尽快给您联系，感谢您的支持！');
