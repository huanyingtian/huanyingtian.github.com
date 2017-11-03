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
if($page<1){$page=1;}
$comeurl	= "page=$page";

if(Core_Fun::rec_post('act')=='update'){
    updateajax(Core_Fun::rec_post('id'),Core_Fun::rec_post('action'));
}
switch($action){
    case 'add':
	    add();
		break;
	case 'saveadd':
	    saveadd();
		break;
	case 'edit':
	    edit();
		break;
	case 'saveedit':
	    saveedit();
		break;
	case 'del':
	    del();
		break;
	case 'isread':
		isread();
		break;
	default:
	    volist();
		break;
}

function volist(){
	Core_Auth::checkauth("guestbookvolist");
	global $db,$tpl,$page;
    $pagesize	= 30;
	$searchsql	= " WHERE 1=1";
	$countsql	= "SELECT COUNT(id) FROM ".DB_PREFIX."guestbook".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT * FROM ".DB_PREFIX."guestbook".
		          $searchsql." ORDER BY id DESC LIMIT $start, $pagesize";
	$book		= $db->getall($sql);
	$url		= $_SERVER['PHP_SELF'];
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("book",$book);
}
function del(){
	Core_Auth::checkauth("guestbookdel");
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('请选择要删除的数据!');
	}
	global $db;
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){
			$db->query("DELETE FROM ".DB_PREFIX."guestbook WHERE `id`=$id");
		}
	}
	Core_Command::runlog("","删除留言成功[id=$arrid]");
	msg::msge('删除成功','xycms_guestbook.php');
}
//设为已读和未读
function  isread(){
	global $db;
	$read = intval($_GET['read']);
	$id   = $_GET['id'];
	if(!is_numeric($id)){
		echo 3;
	}
	if(!in_array($read, array(1,2))){
		echo 2;
		exit;
	}		
	$db->query("UPDATE ".DB_PREFIX."guestbook set `isread`='".($read-1)."' WHERE `id`='".$id."'");
	echo 1;
	exit;
	
	
}


function updateajax($_id,$_action){
	Core_Auth::checkauth("guestbookedit");
    if(Core_Fun::isnumber($_id)){
		global $db;
		switch($_action){
			case 'flagopen':
				$db->query("UPDATE ".DB_PREFIX."guestbook SET flag=1 WHERE bookid=$_id");
				break;
			case 'flagclose':
				$db->query("UPDATE ".DB_PREFIX."guestbook SET flag=0 WHERE bookid=$_id");
				break;
			default:
				break;
		}
	}
}

$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."guestbook.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>