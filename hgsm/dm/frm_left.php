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

$mod = Core_Fun::rec_post("mod");
$tpl->assign('version', $version);
$tpl->assign('message_num',Core_Fun::counts('guestbook'));
$tpl->assign("mod",$mod);
$tpl->assign("siteurl",$config['siteurl']);
$tpl->display(ADMIN_TEMPLATE."frm_left.tpl");
?>