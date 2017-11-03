<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         首页
 * wap站点
**/
define('ALLOWGUEST',true);
header("Content-type:text/html;charset=utf-8");
require '../source/core/run.php';
require './config/config.php';
require './config/m_app.php';
require './source/assign.php';
$style_config = require CHENCY_ROOT.'data/cache/style_config.php';
$m_tpl = M_TEMPLATE."/news_detail.tpl";
if(! file_exists($m_tpl)){
	header("Content-type:text/html;charset=utf-8");	
	die('模板文件不存在!');
}
/* 缓存,模板处理 */
if($config['cachstatus'] == 1){
	$cache_seconds = $config['cachtime']*60;
	$tpl->caching = true;
	$tpl->cache_lifetime = $cache_seconds;
}

$single_news = $ajavLoad->news_detail($_GET['id']);
$tpl->assign('single_news',$single_news);
$tpl->assign('page_title',$single_news['title']);

$tpl->display($m_tpl);
?>