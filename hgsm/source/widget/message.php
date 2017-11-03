<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.01
 * @Id         在线留言
**/
if(!defined('ALLOWGUEST')) {
	exit('Access Denied');
}
$action = Core_Fun::rec_post("action");
if($action == "saveadd"){
	$name      = Core_Fun::rec_post("name",1);
	$contact   = Core_Fun::rec_post("contact",1);
	$email     = Core_Fun::rec_post("email",1);
	$address   = Core_Fun::rec_post("address",1);
	$content   = Core_Fun::rec_post("content",1);
	$checkcode =strtolower($_POST['checkcode']);
	if(!preg_match( "/^[A-Za-z0-9]{4}$/i",$checkcode)){
		msg::msge('验证码格式错误');
	}
	if($checkcode != $_SESSION['verifycode']){
		msg::msge('验证码错误！');
	}

	if(!preg_match( "/^[0-9\-]{8,}$/i ",$contact)){
		msg::msge('联系方式格式错误');
	}
	
	$founderr = false;
	$errmsg   = '';

	$pattern  = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
	if(!preg_match( $pattern, $email )) {
		msg::msge('邮箱格式错误！');
	}
	
	if(!Core_Fun::ischar($name)){
		$founderr = true;
		$errmsg  .= "姓名不能为空！";
	}
	if(!Core_Fun::ischar($content)){
		$founderr = true;
		$errmsg  .= "内容不能为空！";
	}
	if($founderr==true){
		msg::msge($errmsg);
	}
	$array  = array(
		'name'=>$name,
		'contact'=>$contact,
		'email'=>$email,
		'address'=>$address,
		'content'=>$content,
		'timeline'=>time(),
		'ip'=>ip(),
	);
	if(isset($_COOKIE['count']) && intval($_COOKIE['count']) > 5){
		msg::msge('请不要重复提交留言！');
	}
	$db->insert(DB_PREFIX."guestbook",$array);
	if(mb_strlen($content) > 40) {
		$content = mb_substr($content,0,38,'utf-8').'...';
	}
	if($config['message_tel'] == 1){
		require './source/core/sms.php';
		$tel1 = $config['tel'];
		$msg  = "联系人：".$name."， 电话：".$contact."， 留言内容：".$content." -- 您的官方网站！";
		$sms  = new sms($tel1,$msg);
		$sms->send();
	}	

	if(isset($_COOKIE['count'])){
		setcookie("count", intval($_COOKIE['count'])+1, time()+3600,'/');
	}else{
		setcookie("count", 1, time()+3600,'/');
	}
    $url = PATH_URL."message/";
	msg::msge('留言成功，我们将会尽快给您联系，感谢您的支持！',$url);

}else{
	$page_title = $LANVAR['message'];
	$keywords   = $config['metakeyword'];
	$arry_words = explode(',', $keywords);
	if(isset($arry_words[5])){
		$sitetitle  = "_".$arry_words[5].'-'.$config['sitename'];
	}else{
		$sitetitle  = "-".$config['sitename'];
	}
	$tpl->assign("page_title",$page_title.$sitetitle);
	$tpl->assign("page_description",$page_title);
	$tpl->assign("page_keyword",$page_title);
	$tpl->assign('current','message');
}
?>