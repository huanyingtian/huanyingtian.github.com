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
	Core_Auth::checkauth("pagecatevolist");
	global $db,$tpl,$page;
    $pagesize	= 30;
	$searchsql	= " WHERE 1=1";
	$countsql	= "SELECT COUNT(cid) FROM ".DB_PREFIX."pagecate".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT * FROM ".DB_PREFIX."pagecate".
		          $searchsql." ORDER BY orders ASC LIMIT $start, $pagesize";
	$cate		= $db->getall($sql);
	foreach($cate as $key=>$value){
		$cate[$key]['pagecount'] = $db->fetch_count("SELECT COUNT(id) FROM ".DB_PREFIX."page WHERE cid=".$value['cid']."");
	}
	$url		= $_SERVER['PHP_SELF'];
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("cate",$cate);
}

function add(){
	Core_Auth::checkauth("pagecateadd");
	global $tpl,$db;
	$orders  = $db->fetch_newid("SELECT MAX(orders) FROM ".DB_PREFIX."pagecate",1);
	$tpl->assign("flag_checkbox",Core_Mod::checkbox("1","flag","审核"));
	$tpl->assign("elite_checkbox",Core_Mod::checkbox("1","elite","推荐"));
	$tpl->assign("orders",$orders);
}

function edit(){
	Core_Auth::checkauth("pagecateedit");
	global $db,$tpl;
    $id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		msg::msge('ID丢失');
	}
	$sql	= "SELECT * FROM ".DB_PREFIX."pagecate WHERE cid=$id";
	$cate	= $db->fetch_first($sql);
	if(!$cate){
		msg::msge('数据不存在');
	}else{
		$cate['imgname'] = Core_Mod::getpicname($cate['logoimg']);
		$tpl->assign("flag_checkbox",Core_Mod::checkbox($cate['flag'],"flag","审核"));
		$tpl->assign("elite_checkbox",Core_Mod::checkbox($cate['elite'],"elite","推荐"));
		$tpl->assign("id",$id);
		$tpl->assign("comeurl",$GLOBALS['comeurl']);
	    $tpl->assign("cate",$cate);
	}
}

function saveadd(){
	Core_Auth::checkauth("pagecateadd");
	global $db;
	$cname			= Core_Fun::rec_post('cname',1);
	$catdir			= Core_Fun::rec_post('catdir',1);
	$intro			= Core_Fun::strip_post('intro',1);
	$orders			= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$flag			= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$elite			= Core_Fun::detect_number(Core_Fun::rec_post('elite',1));
	$state			= Core_Fun::detect_number(Core_Fun::rec_post('state',1));
	$founderr		= false;
    if (preg_match("/[\x7f-\xff]/", $catdir)) {
       msg::msge("英文目录不能含有中文字符！");
    }
	if(!Core_Fun::ischar($cname)){
	    $founderr	= true;
		$errmsg	   .="分类名称不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$array	= array(
		'cname'=>$cname,
		'catdir' => $catdir,
		'orders'=>$orders,
		'flag'=>$flag,
		'intro'=>$intro,
		'timeline'=>time(),
		'elite'=>$elite,
		'state'=>$state,
	);
	$result = $db->insert(DB_PREFIX."pagecate",$array);
	if($result){
		Core_Command::runlog("","添加单页分类成功[$cname]",1);
		msg::msge('保存成功','xycms_pagecate.php');
	}else{
		Core_Fun::halt("保存失败","",1);
	}
}

function saveedit(){
	Core_Auth::checkauth("pagecateedit");
	global $db;
	$id				= Core_Fun::rec_post('id',1);
	$cname			= Core_Fun::rec_post('cname',1);
	$catdir			= Core_Fun::rec_post('catdir',1);
	$intro			= Core_Fun::strip_post('intro',1);
	$orders			= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$flag			= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$elite			= Core_Fun::detect_number(Core_Fun::rec_post('elite',1));
	$state			= Core_Fun::detect_number(Core_Fun::rec_post('state',1));
	$founderr	= false;
    if (preg_match("/[\x7f-\xff]/", $catdir)) {
       msg::msge("英文目录不能含有中文字符！");
    }
	if(!Core_Fun::isnumber($id)){
	    $founderr	= true;
		$errmsg	   .= "ID丢失.";
	}
	if(!Core_Fun::ischar($cname)){
	    $founderr	= true;
		$errmsg	   .="分类名称不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$array = array(
		'cname'=>$cname,
		'catdir' => $catdir,
		'orders'=>$orders,
		'flag'=>$flag,
		'intro'=>$intro,
		'elite'=>$elite,
		'state'=>$state,
	);
	$result = $db->update(DB_PREFIX."pagecate",$array,"cid=$id");
	if($result){
		Core_Command::runlog("","编辑单页分类成功[id=$id]");
		msg::msge('编辑成功',"xycms_pagecate.php?".$GLOBALS['comeurl']);
	}else{
		msg::msge('编辑失败');
	}
}

function del(){
	Core_Auth::checkauth("pagecatedel");
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('请选择要删除的数据');
	}
	global $db;
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));

		if(Core_Fun::exist_child($id,'page')){
			msg::msge('对不起，所删分类下含有子类，不能删除！');
		}else{
			$db->query("DELETE FROM ".DB_PREFIX."pagecate WHERE cid=$id");
		}
	}
	Core_Command::runlog("","删除单页分类成功[id=$arrid]");
	msg::msge('删除成功', 'xycms_pagecate.php');
}

function updateajax($_id,$_action){
	Core_Auth::checkauth("pagecateedit");
    if(Core_Fun::isnumber($_id)){
		global $db;
		switch($_action){
			case 'flagopen':
				$db->query("UPDATE ".DB_PREFIX."pagecate SET flag=1 WHERE cid=$_id");
				break;
			case 'flagclose':
				$db->query("UPDATE ".DB_PREFIX."pagecate SET flag=0 WHERE cid=$_id");
				break;
			case 'eliteopen':
				$db->query("UPDATE ".DB_PREFIX."pagecate SET elite=1 WHERE cid=$_id");
				break;
			case 'eliteclose':
				$db->query("UPDATE ".DB_PREFIX."pagecate SET elite=0 WHERE cid=$_id");
				break;
			default:
				break;
		}
	}
}

$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."pagecate.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>