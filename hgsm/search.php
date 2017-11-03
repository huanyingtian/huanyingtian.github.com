<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         搜索页面
**/
define('ALLOWGUEST',true);
require './source/core/run.php';
$tplfile = INDEX_TEMPLATE.'search.'.$tplext;
$widgetfile = './source/widget/search.php';
if(!Core_Fun::fileexists($tplfile)){
	header("Content-type:text/html;charset=utf-8");
	die('模板文件不存在!');
}
if(!Core_Fun::fileexists($widgetfile)){
	header("Content-type:text/html;charset=utf-8");
	die('缺少核心文件!');
}
require './source/module/app.php';
require $widgetfile;
$tpl->assign("LANVAR",$LANVAR);
$tpl->display($tplfile);

?>