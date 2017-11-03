<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.01
 * Id          网站地图
**/
if(!defined('ALLOWGUEST')) {
	exit('Access Denied');
}
$sql = "SELECT * FROM ".DB_PREFIX."tag";
$tag = $db->getall($sql);
$page_title = $LANVAR['sitemap'];
$metakeyword = $config['metakeyword'];
$metakeyword = str_replace(',', '_', $metakeyword);
$tpl->assign('tag',$tag);
$tpl->assign("page_title",$page_title."-".$metakeyword.'-'.$config['sitename']);
$tpl->assign("cagoy_title","-".$metakeyword.'-'.$config['sitename']);
$tpl->assign("page_description",$page_title);
$tpl->assign("page_keyword",$page_title);
?>