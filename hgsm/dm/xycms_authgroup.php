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
	default:
	    volist();
		break;
}

function volist(){
	Core_Auth::checkauth("groupvolist");
	global $db,$tpl,$page;
    $pagesize	= 30;
	$searchsql	= " WHERE 1=1";
	$countsql	= "SELECT COUNT(groupid) FROM ".DB_PREFIX."authgroup".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT * FROM ".DB_PREFIX."authgroup".
		         $searchsql." ORDER BY orders ASC LIMIT $start, $pagesize";
	$authgroup	= $db->getall($sql);
	$url		= $_SERVER['PHP_SELF'];
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("authgroup",$authgroup);
}

function add(){
	Core_Auth::checkauth("groupadd");
	global $tpl;
	$orders	= $GLOBALS['db']->fetch_newid("SELECT MAX(groupid) FROM ".DB_PREFIX."authgroup",1);
	$tpl->assign("orders",$orders);
	$tpl->assign("flag_checkbox",Core_Mod::checkbox("1","flag","审核"));
	$tpl->assign("auth_checkbox",Core_Auth::auth_checkbox("","auth"));
}

function edit(){
	Core_Auth::checkauth("groupedit");
	global $db,$tpl;
    $id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		Core_Fun::halt("ID丢失","",2);
	}
	$sql		= "SELECT * FROM ".DB_PREFIX."authgroup WHERE groupid=$id";
	$authgroup	= $db->fetch_first($sql);
	if(!$authgroup){
		Core_Fun::halt("数据不存在","",2);
	}else{
		$tpl->assign("flag_checkbox",Core_Mod::checkbox($authgroup['flag'],"flag","审核"));
		$tpl->assign("auth_checkbox",Core_Auth::auth_checkbox($authgroup['auths'],"auth"));
		$tpl->assign("id",$id);
		$tpl->assign("comeurl",$GLOBALS['comeurl']);
	    $tpl->assign("authgroup",$authgroup);
	}
}

function saveadd(){
	Core_Auth::checkauth("groupadd");
	global $db;
	$groupname	= Core_Fun::rec_post('groupname',1);
	$flag		= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$orders		= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$intro		= Core_Fun::strip_post('intro',1);
	$arrauth    = isset($_POST['auth']) ? $_POST['auth'] : "";
	$founderr	= false;
	if(!Core_Fun::ischar($groupname)){
	    $founderr	= true;
		$errmsg	   .="管理组名不能为空.<br />";
	}
	if($founderr == true){
	    Core_Fun::halt($errmsg,"",1);
	}
    
	$auths = "";
	if(Core_Fun::ischar($arrauth)){
		if(count($arrauth)>0){
			if(count($arrauth)==1){
				$auths = trim($arrauth[0]);
			}else{
				for($ii=0;$ii<count($arrauth);$ii++){
					$auths .= trim($arrauth[$ii]).",";
				}
				$auths = substr($auths,0,(strlen($auths)-1));
			}
		}
	}
	$groupid	= $db->fetch_newid("SELECT MAX(groupid) FROM ".DB_PREFIX."authgroup",1);
	$array	= array(
		'groupid'=>$groupid,
		'groupname'=>$groupname,
		'auths'=>$auths,
		'flag'=>$flag,
		'timeline'=>time(),
		'orders'=>$orders,
		'intro'=>$intro,
	);
	$result = $db->insert(DB_PREFIX."authgroup",$array);
	if($result){
		Core_Command::runlog("","添加管理组成功[$groupname]",1);
		Core_Fun::halt("保存成功","xycms_authgroup.php",0);
	}else{
		Core_Fun::halt("保存失败","",1);
	}

}

function saveedit(){
	Core_Auth::checkauth("groupedit");
	global $db;
	$id			= Core_Fun::rec_post('id',1);
	$groupname	= Core_Fun::rec_post('groupname',1);
	$flag		= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$orders		= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$intro		= Core_Fun::strip_post('intro',1);
	$arrauth    = isset($_POST['auth']) ? $_POST['auth'] : "";
	$founderr	= false;
	if(!Core_Fun::isnumber($id)){
	    $founderr	= true;
		$errmsg	   .= "ID丢失.<br />";
	}
	if(!Core_Fun::ischar($groupname)){
	    $founderr	= true;
		$errmsg	   .="管理组名不能为空.<br />";
	}
	if($founderr == true){
	    Core_Fun::halt($errmsg,"",1);
	}
	$auths = "";
	if(Core_Fun::ischar($arrauth)){
		if(count($arrauth)>0){
			if(count($arrauth)==1){
				$auths = trim($arrauth[0]);
			}else{
				for($ii=0;$ii<count($arrauth);$ii++){
					$auths .= trim($arrauth[$ii]).",";
				}
				$auths = substr($auths,0,(strlen($auths)-1));
			}
		}
	}
	$array = array(
		'groupname'=>$groupname,
		'auths'=>$auths,
		'flag'=>$flag,
		'orders'=>$orders,
		'intro'=>$intro,
	);
	$result = $db->update(DB_PREFIX."authgroup",$array,"groupid=$id");
	if($result){
		Core_Command::runlog("","编辑管理组成功[id=$id]");
		Core_Fun::halt("编辑成功","xycms_authgroup.php?".$GLOBALS['comeurl']."",0);
	}else{
		Core_Fun::halt("编辑失败","",2);
	}
}

function del(){
	Core_Auth::checkauth("groupdel");
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		Core_Fun::halt("请选择要删除的数据","",1);
	}
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){
			$GLOBALS['db']->query("DELETE FROM ".DB_PREFIX."authgroup WHERE groupid=$id");
		}
	}
	Core_Command::runlog("","删除管理组成功[id=$arrid]");
	Core_Fun::halt("删除成功","xycms_authgroup.php",0);
}

function updateajax($_id,$_action){
	Core_Auth::checkauth("groupedit");
    if(Core_Fun::isnumber($_id)){
		global $db;
		switch($_action){
			case 'flagopen';
			$db->query("UPDATE ".DB_PREFIX."authgroup SET flag=1 WHERE groupid=$_id");
			break;
			case 'flagclose';
			$db->query("UPDATE ".DB_PREFIX."authgroup SET flag=0 WHERE groupid=$_id");
			break;
			default;
			break;
		}
	}
}
$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."authgroup.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>