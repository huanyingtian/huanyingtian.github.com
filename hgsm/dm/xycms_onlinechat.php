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
	Core_Auth::checkauth("onlinechatvolist");
	global $db,$tpl,$page;
    $pagesize	= 30;
	$searchsql	= " WHERE 1=1";
	$countsql	= "SELECT COUNT(onid) FROM ".DB_PREFIX."onlinechat{$searchsql}";
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT * FROM ".DB_PREFIX."onlinechat".
		         $searchsql." ORDER BY `orders` ASC LIMIT $start, $pagesize";
	$onlinechat	= $db->getall($sql);
	$url		= $_SERVER['PHP_SELF'];
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("onlinechat",$onlinechat);
}

function add(){
	Core_Auth::checkauth("onlinechatadd");
	global $tpl,$db;
	$orders = $db->fetch_newid("SELECT MAX(orders) FROM ".DB_PREFIX."onlinechat",1);
	$tpl->assign("flag_checkbox",Core_Mod::checkbox("1","flag","审核"));
	$tpl->assign("orders",$orders);
}

function edit(){
	Core_Auth::checkauth("onlinechatedit");
	global $db,$tpl;
    $id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		msg::msge('ID丢失!');
	}
	$sql		= "SELECT * FROM ".DB_PREFIX."onlinechat WHERE onid=$id";
	$onlinechat = $db->fetch_first($sql);
	if(!$onlinechat){
		msg::msge('数据不存在!');
	}else{
		$tpl->assign("flag_checkbox",Core_Mod::checkbox($onlinechat['flag'],"flag","审核"));
		$tpl->assign("id",$id);
		$tpl->assign("comeurl",$GLOBALS['comeurl']);
	    $tpl->assign("onlinechat",$onlinechat);
	}
}

function saveadd(){
	Core_Auth::checkauth("onlinechatadd");
	global $db;
	$ontype		= Core_Fun::detect_number(Core_Fun::rec_post('ontype',1));
	$title		= Core_Fun::rec_post('title',1);
	$number		= Core_Fun::rec_post('number',1);
	$orders		= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$flag		= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$founderr	= false;
	if(intval($ontype)<1){
		$founderr	= true;
		$errmsg	   .="请选择类型.";
	}
	if(!Core_Fun::ischar($number)){
	    $founderr	= true;
		$errmsg	   .="号码不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$array	= array(
		'ontype'=>$ontype,
		'title'=>$title,
		'number'=>$number,
		'timeline'=>time(),
		'flag'=>$flag,
		'orders'=>$orders,
	);
	$result = $db->insert(DB_PREFIX."onlinechat",$array);
	if($result){
		Core_Command::runlog("","添加客服信息成功",1);
		msg::msge('保存成功','xycms_onlinechat.php');
	}else{
		msg::msge('保存失败');
	}
}

function saveedit(){
	Core_Auth::checkauth("onlinechatedit");
	global $db;
	$id			= Core_Fun::rec_post('id',1);
	$ontype		= Core_Fun::detect_number(Core_Fun::rec_post('ontype',1));
	$title		= Core_Fun::rec_post('title',1);
	$number		= Core_Fun::rec_post('number',1);
	$orders		= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$flag		= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$founderr	= false;
	if(!Core_Fun::isnumber($id)){
	    $founderr	= true;
		$errmsg	   .= "ID丢失.";
	}
	if(intval($ontype)<1){
		$founderr	= true;
		$errmsg	   .="请选择类型.";
	}
	if(!Core_Fun::ischar($number)){
	    $founderr	= true;
		$errmsg	   .="号码不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$array = array(
		'ontype'=>$ontype,
		'title'=>$title,
		'number'=>$number,
		'flag'=>$flag,
		'orders'=>$orders,
	);
	$result = $db->update(DB_PREFIX."onlinechat",$array,"onid={$id}");
	if($result){
		Core_Command::runlog("","编辑客服信息成功[id={$id}]");
		msg::msge('编辑成功',"xycms_onlinechat.php?{$GLOBALS['comeurl']}");
	}else{
		msg::msge('编辑失败');
	}
}

function del(){
	Core_Auth::checkauth("onlinechatdel");
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('请选择要删除的数据!');
	}
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){
			$GLOBALS['db']->query("DELETE FROM ".DB_PREFIX."onlinechat WHERE onid=$id");
		}
	}
	Core_Command::runlog("","删除客服信息成功[id=$arrid]");
	msg::msge('删除成功','xycms_onlinechat.php');
}

function updateajax($_id,$_action){
	Core_Auth::checkauth("onlinechatedit");
    if(Core_Fun::isnumber($_id)){
		global $db;
		switch($_action){
			case 'flagopen':
				$db->query("UPDATE ".DB_PREFIX."onlinechat SET flag=1 WHERE onid=$_id");
				break;
			case 'flagclose':
				$db->query("UPDATE ".DB_PREFIX."onlinechat SET flag=0 WHERE onid=$_id");
				break;
			default:
				break;
		}
	}
}

$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."onlinechat.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>