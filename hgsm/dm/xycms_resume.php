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
$action		= Core_Fun::rec_post("action");
$page		= Core_Fun::detect_number(Core_Fun::rec_post("page"),1);
$scateid    = Core_Fun::detect_number(Core_Fun::rec_post("scateid"));
$sname      = Core_Fun::rec_post("sname",1);
if($page<1){$page=1;}
$comeurl	= "page=$page&scateid=$scateid";

if(Core_Fun::rec_post('act')=='update'){
    updateajax(Core_Fun::rec_post('id'),Core_Fun::rec_post('action'));
}
switch($action){
	case 'del':
	    del();
		break;
    default:
	    volist();
	    break;
}

function volist(){
	global $db,$tpl,$page,$scateid,$sname;
    $pagesize	= 30;
	$countsql	= "SELECT COUNT(id) FROM ".DB_PREFIX."resume";
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql        = "SELECT * FROM ".DB_PREFIX."resume order by id DESC LIMIT $start, $pagesize";
	$resume		= $db->getall($sql);
	$url		= $_SERVER['PHP_SELF'];
	$urlitem	= "scateid=$scateid";
	$url	   .= "?".$urlitem;
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	foreach ($resume as $key => $value) {
		$resume[$key]['downjob'] = PATH_URL.ltrim($value['uploadfile'],"./");
	}
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("resume",$resume);
	$tpl->assign("urlitem",$urlitem);
}

function del(){
	global $db;
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('编请选择要删除的数据');
	}
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){
			$db->query("DELETE FROM ".DB_PREFIX."resume WHERE id=$id");
		}
	}
	Core_Command::runlog("","删除简历成功[id=$arrid]");
	msg::msge('删除成功','xycms_resume.php');
}


$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."resume.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
