<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn3000.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         首页
**/
define('ALLOWGUEST',true);
require './source/core/run.php';
$tplfile = INDEX_TEMPLATE."index.".$tplext;
$widgetfile = "./source/widget/index.php";
if(! file_exists($tplfile)){
	header("Content-type:text/html;charset=utf-8");	
	die('模板文件不存在!');
}
if(! file_exists($widgetfile)){
	header("Content-type:text/html;charset=utf-8");
	die('缺少核心文件');
}
/* 缓存,模板处理 */
if($config['cachstatus']==1){
	$cache_seconds = $config['cachtime']*60;
	$tpl->caching = true;
	$tpl->cache_lifetime = $cache_seconds;
}
$cacheid = md5($_SERVER["REQUEST_URI"]);
// define('PATH_URL','http://'.$_SERVER['HTTP_HOST'].PHPOE_ROOT);
// echo(PATH_URL);exit;
if(!$tpl->isCached($tplfile,$cacheid)){
	require './source/module/app.php';
	require $widgetfile;
}
// $md5password = md5(KEY.md5('xyxx2013'.KEY));
// echo($md5password);die();
$tpl->assign("runtime",Core_Fun::runtime());
$tpl->display($tplfile,$cacheid);
?>