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
require 'get_keycont.php';


$auth_check = Core_Auth::auth_checkbox("","auth");
$tpl->display(ADMIN_TEMPLATE."frm_main.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>