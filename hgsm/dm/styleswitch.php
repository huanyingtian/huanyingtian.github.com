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
require '../source/module/contact.php';
$style_config = require CHENCY_ROOT.'data/cache/style_config.php';
if(!empty($style_config)){
	$tpl->assign('current_style', $style_config['current_style']);
	$tpl->assign('mobile_style', $style_config['mobile_style']);
	$tpl->assign('contact_style',$contactid);
}
$action	= Core_Fun::rec_post("action");
$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."styleswitch.tpl");