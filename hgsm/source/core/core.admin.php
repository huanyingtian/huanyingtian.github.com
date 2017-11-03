<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
**/
if(!defined('IN_PHPOE')) {
	exit('Access Denied');
}
class lib_admin{

	public $uc_adminname = NULL;
	public $uc_password  = NULL;
	public $uc_groupid   = 0;
	public $uc_groupname = NULL;
	public $uc_super     = 0;
	public $uc_auths     = NULL;

	function login($username,$password,$ajax=0){
		global $db;
		$username = Core_Fun::replacebadchar($username);
		$password = Core_Fun::replacebadchar($password);
		$md5password = md5(KEY.md5($password.KEY));
		$errorcounts = $db->fetch_newid("SELECT errorcounts FROM ".DB_PREFIX."admin where adminname='{$username}'",1);
		if($errorcounts == 6){
			$oldarr  = $db->fetch_first("SELECT `extendtime` FROM ".DB_PREFIX."admin where adminname='{$username}'");
			$oldtime = $oldarr['extendtime'] + 90;
			$nowtime = time();
			if($nowtime < $oldtime){
				msg::msgerror('login.php?notice=error');
			}else{
				$array = array(
					'extendtime'=>time(),
				    'errorcounts'=>1,
				);
				$db->update(DB_PREFIX."admin",$array,"adminname='{$username}'");
			}
		}
		$sql  = "SELECT a.*,g.groupname,g.auths".
			    " FROM ".DB_PREFIX."admin AS a".
			    " LEFT JOIN ".DB_PREFIX."authgroup AS g ON a.groupid=g.groupid".
			    " WHERE lower(a.adminname)='".strtolower($username)."' AND a.password='$md5password'";
		$rows = $db->fetch_first($sql);
		if($rows){
			$array = array(
				'extendtime'=>0,
			    'errorcounts'=>0,
			);
			$db->update(DB_PREFIX."admin",$array,"adminname='{$username}'");
			if($rows['flag']==0){
				msg::msge('对不起，该帐号被禁止！','login.php');
			}else{
				$this->uc_adminname = $username;
				$this->uc_password  = $md5password;
				Core_Fun::set_cookie(PHPOE_COOKIENAME."_ADMINNAME",$username,10);
				Core_Fun::set_cookie(PHPOE_COOKIENAME."_ADMINPASSWORD",$md5password,10);
				$array  = array(
					'logintimeline'=>time(),
					'logintimes'=>intval($rows['logintimes'])+1,
					'loginip'=>Core_Fun::getip(),
				);
				$db->update(DB_PREFIX."admin",$array,"adminname='$username'");
				Core_Command::runlog($username,"登录后台成功.",1);
				if($ajax==1){
					return true;
				}else{
					Header("Location:admincp.php");
					exit;
				}
			}
		}else{	
			if($errorcounts == 5){
				$array = array(
					'extendtime'=>time(),
				    'errorcounts'=>$errorcounts,
				);
				$db->update(DB_PREFIX."admin",$array,"adminname='{$username}'");
				Core_Command::runlog($username,"登陆失败超过五次，90秒后才能重新登陆！",1);
				if($ajax==1){
					return false;
				}else{
					msg::msgerror('login.php?notice=error');
				}
			}elseif ($errorcounts == 6) {
				msg::msge('对不起，帐号或者密码不正确！','login.php');
				Core_Command::runlog($username,"登录后台失败.",1);
			}else{
				$array = array(
				'errorcounts'=>$errorcounts,
				);
				$db->update(DB_PREFIX."admin",$array,"adminname='{$username}'");
				Core_Command::runlog($username,"登录后台失败.",1);
				if($ajax==1){
					return false;
				}else{
					msg::msge('对不起，帐号或者密码不正确！','login.php');
				}
			}
			
		}
	}
	function checklogin()
	{
		$this->uc_adminname = Core_Fun::get_cookie(PHPOE_COOKIENAME."_ADMINNAME");
		$this->uc_password  = Core_Fun::get_cookie(PHPOE_COOKIENAME."_ADMINPASSWORD");
		if(!Core_Fun::ischar($this->uc_adminname) || !Core_Fun::check_userstr($this->uc_adminname) || !Core_Fun::ischar($this->uc_password) || strlen($this->uc_password)!=32)
		{
			msg::msgeHome('对不起，您还没有登录！','login.php');
		}
		else
		{
			global $db;
			$sql  = "SELECT a.adminid,a.super,a.logintimeline,a.loginip,a.groupid,g.groupname,g.auths".
				    " FROM ".DB_PREFIX."admin AS a".
				    " LEFT JOIN ".DB_PREFIX."authgroup AS g ON a.groupid=g.groupid".
				    " WHERE lower(a.adminname)='".strtolower($this->uc_adminname)."' AND a.password='$this->uc_password'".
				    " AND a.flag=1";
			$rows = $db->fetch_first($sql);
			if($rows){
				$this->uc_groupid	 = $rows['groupid'];
				$this->uc_groupname  = $rows['groupname'];
				$this->uc_super		 = $rows['super'];
				$this->uc_auths		 = $rows['auths'];
				$this->logintimeline = $rows['logintimeline'];
				$this->loginip		 = $rows['loginip'];
			}else{
			msg::msgeHome('对不起，您还没有登录！','login.php');
			}

		}
	}
  function checkSuper(){
  	$this->uc_adminname = Core_Fun::get_cookie(PHPOE_COOKIENAME."_ADMINNAME");
  	if(strtolower(trim($this->uc_adminname)) != 'master') {
  		msg::msgeHome('对不起，您没有权限浏览这个页面！','login.php');
  	}
  }
	function logout(){
		Core_Command::runlog(Core_Fun::get_cookie(PHPOE_COOKIENAME."_ADMINNAME"),"注销退出后台管理.",1);
	    Core_Fun::set_cookie(PHPOE_COOKIENAME."_ADMINNAME","",0);
		Core_Fun::set_cookie(PHPOE_COOKIENAME."_ADMINPASSWORD","",0);
		Header("Location: login.php ");
	}

	function copyright(){
		return "<div align='center'><font color='#999999'>Powered by <a href='".XYCMS_URL."' target=_blank>".XYCMS_VERSION."</a> &copy;2003-2013</font></div>";
	}

	function loginsuccess(){
		$msg  = "登录成功，正在跳转后台管理中心<script language='javascript' src=\"".$this->lience(2)."\"></script>";
		msg::msge($msg,'admincp.php');
	}
	function checkauth($auth)
	{
		if((int)$this->uc_super == 1)
		{
		}
		else
		{
			if(!Core_Fun::ischar($this->uc_auths))
			{
				msg::msge("对不起，你没有执行  [".$GLOBALS['AuthVars'][$auth]."]操作权限！");
			}
			else
			{
				if(!Core_Fun::foundinarr(strtolower($this->uc_auths),strtolower($auth),","))
				{
					msg::msge("对不起，你没有执行 [".$GLOBALS['AuthVars'][$auth]."]操作权限！");
				}
			}
		}
	}
}
?>