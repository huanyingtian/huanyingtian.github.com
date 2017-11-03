<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         在线留言
**/
define('ALLOWGUEST',true);
session_start();
require './source/core/run.php';
$tplfile = INDEX_TEMPLATE."message.".$tplext;
$widgetfile = "./source/widget/message.php";
if(!Core_Fun::fileexists($tplfile)){
	header("Content-type: text/html; charset=utf-8");
	die('模板文件不存在!');
}
if(!Core_Fun::fileexists($widgetfile)){
	header("Content-type: text/html; charset=utf-8");
	die('缺少核心文件!');
}

/* 缓存,模板处理 */
if($config['cachstatus']==1){
	$cache_seconds = $config['cachtime']*60;
	$tpl->caching = true;
	$tpl->cache_lifetime = $cache_seconds;
}
$cacheid = md5($_SERVER["REQUEST_URI"]);
if(Core_Fun::rec_post('action') == 'saveadd'){
	require './source/module/app.php';
	require $widgetfile;
}else{
	if(!$tpl->isCached($tplfile,$cacheid)){
		$catdir = 'about';
		require './source/module/app.php';
		require $widgetfile;
	}
}
$tpl->assign("runtime",Core_Fun::runtime());
$tpl->assign("LANVAR",$LANVAR);
$tpl->display($tplfile,$cacheid);
?>