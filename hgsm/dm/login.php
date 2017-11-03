<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XiangYun v1.0
 * @Update     2012.07.07
**/
session_start();
require '../source/core/run.php';
$action	   = Core_Fun::rec_post("action",1);
$notice    = Core_Fun::rec_post("notice",2);
$name 	   = mysql_real_escape_string(Core_Fun::get_cookie(PHPOE_COOKIENAME."_ADMINNAME"));
$password  = Core_Fun::get_cookie(PHPOE_COOKIENAME."_ADMINPASSWORD");
if(Core_Fun::ischar($name) && Core_Fun::check_userstr($password) && Core_Fun::ischar($password) && strlen($password) == 32){
	$sql = 'SELECT `adminid` FROM '.DB_PREFIX."admin WHERE `adminname`='{$name}' AND `password`='{$password}' AND `flag`='1' LIMIT 1";
	$state = $db->fetch_first($sql);
	if($state){
		Header("Location:admincp.php");
		exit;
	}	
}
$tpl->assign('notice',$notice);
if($action=="loginpost"){
	$username	= Core_Fun::rec_post("username",1);
	$password	= Core_Fun::rec_post("password",1);
	$checkcode	= strtolower(Core_Fun::rec_post("checkcode",1));
	$founderr   = false;
	if(!Core_Fun::ischar($username)){
		$founderr	= true;
		$errmsg	   .= "管理员帐号不能为空.";
	}else{
		if(!Core_Fun::check_userstr($username)){
			$founderr	= true;
			$errmsg	   .= "帐号格式不正确！.";
		}
	}
	if(!Core_Fun::ischar($password)){
		$founderr	= true;
		$errmsg	   .= "密码不能为空.";
	}
	if(!Core_Fun::ischar($checkcode)){
		$founderr	= true;
		$errmsg	   .= "验证码不能为空.";
	}else{
		if($checkcode != $_SESSION["verifycode"]){
			$founderr	= true;
			$errmsg	   .= "验证码不正确.";
		}
	}
	if($founderr == true){
		msg::msge($errmsg);
	}else{
		$libadmin->login($username,$password);
	}	
}else{
	$style_config = require CHENCY_ROOT.'data/cache/style_config.php';
	if(!empty($style_config)){
		$tpl->assign('style', $style_config['current_style']);
	}
	
	require 'config.php';
    $tpl->assign('version', $version);
    $tpl->assign('vsion', XYCMS_VSION);
	
	$tpl->display(ADMIN_TEMPLATE."login.tpl");
}
?>