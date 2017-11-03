<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XiangYun v1.0
 * @Update     2012.07.07
**/
require '../source/core/run.php';
require 'admin.inc.php';

require 'config.php';
$tpl->assign('version', $version);
if(!empty($config['version'])){
   $tpl->assign('web_version', '产品版本：'.$config['version']);
}
$webtime = '';  
if(!empty($config['timestart'])){
    $webtime .= '服务起止时间：'.$config['timestart'];
}
if(!empty($config['timeend'])){
    $webtime .= ' ~ '.$config['timeend'];
}
$tpl->assign('webtime', $webtime);

$style_config = require CHENCY_ROOT.'data/cache/style_config.php';
if(!empty($style_config))
{
	$tpl->assign('current_style', $style_config['current_style']);
}

$mod	= Core_Fun::rec_get("mod");

if($mod == "drag")
{
	$tpl->display(ADMIN_TEMPLATE."frm_drag.tpl");
}
elseif($mod == "left")
{
	$tpl->display(ADMIN_TEMPLATE."frm_left.tpl");
}
elseif($mod == "top")
{
	$tpl->display(ADMIN_TEMPLATE."frm_top.tpl");
}
elseif($mod == "footer")
{
	$tpl->display(ADMIN_TEMPLATE."frm_footer.tpl");
}
elseif($mod == "main")
{
	require 'get_keycont.php';
	require CHENCY_ROOT.'source/module/mod.part.php';
	$city = require CHENCY_ROOT.'./source/conf/city.php';

	if($str != '') {
		$keywordCount = count(explode(',', $str));
	}else {
		$keywordCount = 0;
	}

	function array_multi2singles($array)
	{
	    //首先定义一个静态数组常量用来保存结果
	    static $result_arrays = array();
	    //对多维数组进行循环
	    foreach ($array as $value) {
	        //判断是否是数组，如果是递归调用方法
	        if (is_array($value)) {
	            array_multi2singles($value);
	        } else  {//如果不是，将结果放入静态数组常量
	            $result_arrays [] = $value;
	        }    
	    }
	    //返回结果（静态数组常量）
	    return $result_arrays;
	}
	$citys = array_multi2singles($city);
	foreach ($citys as $nums => &$cit) {
		if(($pos = strpos($cit, '地区')) !== false) {
			unset($citys[$nums]);
		}
	}
	$region       = "SELECT COUNT(id) FROM ".DB_PREFIX."region where flag=1";
	$regionCount  = count($cityAll) + $db->fetch_count($region);

	$linkCount    = count(Mod_Part::volist_fontlink());

	$product      = "SELECT COUNT(id) FROM ".DB_PREFIX."product where flag=1";
	$productCount = $db->fetch_count($product);

	$info         = "SELECT COUNT(id) FROM ".DB_PREFIX."info where flag=1";
	$infoCount    = $db->fetch_count($info);

	$case         = "SELECT COUNT(id) FROM ".DB_PREFIX."case where flag=1";
	$caseCount    = $db->fetch_count($case);

	$guestbook    = "SELECT COUNT(id) FROM ".DB_PREFIX."guestbook where flag=1";
	$messageCount = $db->fetch_count($guestbook);

	$inquiry      = "SELECT COUNT(linkid) FROM ".DB_PREFIX."link where flag=1";
	$inquiryCount = $db->fetch_count($inquiry);

	$tpl->assign("keywordCount",$keywordCount);
	$tpl->assign("regionCount",$regionCount);
	$tpl->assign("linkCount",$linkCount);
	$tpl->assign("productCount",$productCount);
	$tpl->assign("infoCount",$infoCount);
	$tpl->assign("caseCount",$caseCount);
	$tpl->assign("messageCount",$messageCount);
	$tpl->assign("inquiryCount",$inquiryCount);
	$tpl->display(ADMIN_TEMPLATE."frm_main.tpl");
}
else
{
	$tpl->display(ADMIN_TEMPLATE."admincp.tpl");
}
?>