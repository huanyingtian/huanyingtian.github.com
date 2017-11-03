<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.01
**/
if (!defined('IN_PHPOE')){
    die('Hacking attempt');
}

$libadmin->checklogin();

$tpl->assign("uc_adminname",$libadmin->uc_adminname);
$tpl->assign("uc_super",$libadmin->uc_super);
$tpl->assign("uc_groupname",$libadmin->uc_groupname);
$tpl->assign("logintimeline",$libadmin->logintimeline);
$tpl->assign("loginip",$libadmin->loginip);

$tpl->assign("info_count",Core_Mod::infoCount());
$tpl->assign("product_count",Core_Mod::productCount());
$tpl->assign("download_count",Core_Mod::downloadCount());
$tpl->assign("guestbook_count",Core_Mod::guestbookCount());
$tpl->assign("copyright",$libadmin->copyright());

function runtime()
{}
?>