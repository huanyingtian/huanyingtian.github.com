<?php
//缓存管理
require '../source/core/run.php';
require 'admin.inc.php';
$action	= Core_Fun::rec_post("action");
Core_Auth::checkauth("config");
switch($action){
	case 'clearcache':
		clearcache();
		break;
	case 'savecache':
		savecache();
	default:
		break;
}

//保存缓存设置
function savecache(){
	$cachstatus	= Core_Fun::detect_number(Core_Fun::rec_post("cachstatus",1),0);
	$cachtime	= Core_Fun::detect_number(Core_Fun::rec_post("cachtime",1),0);
	$array	= array(
		'cachstatus'=>$cachstatus,
		'cachtime'=>$cachtime,
	);
	$result = $GLOBALS['db']->update(DB_PREFIX."config",$array,"");
	if(!$result){
		msg::msge('更新失败');
	}else{
		Core_Command::runlog("","设置站点缓存优化成功");
		msg::msge('更新成功','cache.php');
	}
}

//清理缓存
function clearcache(){
	global $tpl;
	$tpl->clearAllCache();
	$tpl->clearCompiledTemplate();
	Core_Command::runlog("","清除网站缓存成功");
	msg::msge('网站缓存清除成功');
}


$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."cache.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());















