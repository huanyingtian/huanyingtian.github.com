<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XiangYun v1.0
 * @Update     2012.07.07
**/
session_start();
require_once '../source/core/run.php';
$action	= Core_Fun::rec_post("action",1);
if($action=="loginpost"){
	$username	= Core_Fun::rec_post("username",1);
	$password	= Core_Fun::rec_post("password",1);
	$founderr   = false;
	if(!Core_Fun::ischar($username)){
		$founderr	= true;
		$errmsg	   .= "管理员帐号不能为空.<br />";
	}else{
		if(!Core_Fun::check_userstr($username)){
			$founderr	= true;
			$errmsg	   .= "帐号格式不正确！.<br />";
		}
	}
	if(!Core_Fun::ischar($password)){
		$founderr	= true;
		$errmsg	   .= "密码不能为空.<br />";
	}
	if($founderr == true){
		Core_Fun::halt($errmsg,"",1);
	}else{
		$flag = $libadmin->login($username,$password,1);
		if($flag){
		  $name   = $config["sitename"];
		  $tj_url = $config['tj_url']; 
		  echo "result=true\n";
	      echo "name=$name\n";
	      echo "tj_url=$tj_url\n";
		}else{
		  echo "result=false\n";
		}
	}
}else{
	$tpl->display(ADMIN_TEMPLATE."login2.tpl");
}
?>