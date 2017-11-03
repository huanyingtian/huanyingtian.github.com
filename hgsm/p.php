<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn3000.cn
 * @Author     XiangYun
 * @Brief      XYCMS N1.0
 * @Update     2016.7.15
 * @Id         单页
**/
define('ALLOWGUEST',true);
require './source/core/run.php';
$p = $_GET['p'];
$tplfile = INDEX_TEMPLATE."p/".$p.'.'.$tplext;
$widgetfile = "./source/widget/p.php";
if(!file_exists($tplfile)){
	header("Content-type:text/html;charset=utf-8");	
	die('模板文件不存在!');
}
if(! file_exists($widgetfile)){
	header("Content-type:text/html;charset=utf-8");
	die('缺少核心文件');
}

/* 缓存,模板处理 */
$cacheid = md5($_SERVER["REQUEST_URI"]);
if(!$tpl->isCached($tplfile,$cacheid)){
	require './source/module/app.php';
	require $widgetfile;
}

$tpl->assign("LANVAR",$LANVAR);
$tpl->assign("runtime",Core_Fun::runtime());
$tpl->display($tplfile,$cacheid);
