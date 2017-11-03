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
$action	= Core_Fun::rec_post("action");
if($page<1){$page=1;}
$page	= Core_Fun::detect_number(Core_Fun::rec_post("page"),1);

switch($action){
	case 'del':
	    del();
		break;
	case 'clearlog':
	    clearlog();
		break;
	default:
	    volist();
		break;
}

function volist(){
	Core_Auth::checkauth("logvolist");
	global $db,$tpl,$page;
    $pagesize	= 30;
	$searchsql	= " WHERE 1=1";
	$countsql	= "SELECT COUNT(logid) FROM ".DB_PREFIX."log".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT * FROM ".DB_PREFIX."log".
		         $searchsql." ORDER BY logid DESC LIMIT $start, $pagesize";
	$log		= $db->getall($sql);
	$url		= $_SERVER['PHP_SELF'];
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("log",$log);
}

function del(){
	Core_Auth::checkauth("logdel");
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('请选择要删除的数据');
	}
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){
			$GLOBALS['db']->query("DELETE FROM ".DB_PREFIX."log WHERE logid=$id");
		}
	}
	Core_Command::runlog("","删除操作日志成功[id=$arrid]");
	msg::msge('删除成功','xycms_log.php');
}

//清空日志
function clearlog(){
	Core_Auth::checkauth("logdel");
	if($GLOBALS['db']->query("truncate table ".DB_PREFIX."log")){
		msg::msge('清空日志成功！','xycms_log.php');
	}else{
		msg::msge('清空日志失败！','xycms_log.php');
	}	
}

$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."log.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>