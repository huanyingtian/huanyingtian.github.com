<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XiangYun v1.0
 * @Update     2012.07.07
**/
require_once '../source/core/run.php';
require_once 'admin.inc.php';

// $content = file_get_contents('http://cha.cn86.cn/cha.php?url=ccc');
// echo $content;

$action		= Core_Fun::rec_post("action");
$page		= Core_Fun::detect_number(Core_Fun::rec_post("page"),1);
$spaceid    = $_GET['spaceid'];
if($page<1){$page=1;}
$comeurl	= "page=$page&sname=".urlencode($sname)."";

if(Core_Fun::rec_post('act')=='update')
{
    updateajax(Core_Fun::rec_post('id'),Core_Fun::rec_post('action'));
    die();
}

switch($action)
{
	case 'update':
	    update();
	    break;
	default:
	    volist();
		break;
}

function volist()
{
	Core_Auth::checkauth("tagvolist");
	global $db, $tpl, $page, $sname, $config, $spaceid;
	$ranking  = 0;
	$iframUrl = CAH_URL."cha.php?domain=".$config['siteurl'];
	if(($pos = strpos($config['siteurl'], 'www.')) !== false) {
		$ranking  = 1;
	}
	$tpl->assign("sname", '');
	$tpl->assign("ranking", $ranking);
	$tpl->assign("iframUrl", $iframUrl);
}

$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."cha.tpl");
$tpl->assign("copyright",$libadmin->copyright());



?>
