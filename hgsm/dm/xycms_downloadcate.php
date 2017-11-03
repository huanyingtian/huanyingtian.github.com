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
	Core_Auth::checkauth("downloadcatevolist");
	global $db,$tpl,$page;
    $pagesize	= 30;
	$searchsql	= " WHERE 1=1";
	$countsql	= "SELECT COUNT(cid) FROM ".DB_PREFIX."downloadcate".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT * FROM ".DB_PREFIX."downloadcate".
		          $searchsql." ORDER BY orders ASC LIMIT $start, $pagesize";
	$cate		= $db->getall($sql);
	foreach($cate as $key=>$value){
		$cate[$key]['downloadcount'] = $db->fetch_count("SELECT COUNT(id) FROM ".DB_PREFIX."download WHERE cid=".$value['cid']."");
	}
	$url		= $_SERVER['PHP_SELF'];
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("cate",$cate);
}

function setting(){
	Core_Auth::checkauth("downloadcateedit");
	global $db,$tpl,$page;
    $pagesize	= 30;
	$searchsql	= " WHERE 1=1";
	$countsql	= "SELECT COUNT(cateid) FROM ".DB_PREFIX."downloadcate".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT * FROM ".DB_PREFIX."downloadcate".
		          $searchsql." ORDER BY orders ASC LIMIT $start, $pagesize";
	$cate		= $db->getall($sql);
	$url		= $_SERVER['PHP_SELF'];
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("cate",$cate);
}

function add(){
	Core_Auth::checkauth("downloadcateadd");
	global $tpl,$db;
	$orders  = $db->fetch_newid("SELECT MAX(orders) FROM ".DB_PREFIX."downloadcate",1);
	$tpl->assign("flag_checkbox",Core_Mod::checkbox("1","flag","审核"));
	$tpl->assign("elite_checkbox",Core_Mod::checkbox("1","elite","推荐"));
	$tpl->assign("orders",$orders);
}

function edit(){
	Core_Auth::checkauth("downloadcateedit");
	global $db,$tpl;
    $id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		msg::msge('ID丢失');
	}
	$sql	= "SELECT * FROM ".DB_PREFIX."downloadcate WHERE cid=$id";
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
	Core_Auth::checkauth("downloadcateadd");
	global $db;
	$cname				= Core_Fun::rec_post('cname',1);
	$intro				= Core_Fun::strip_post('intro',1);
	$orders				= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$flag				= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$elite				= Core_Fun::detect_number(Core_Fun::rec_post('elite',1));
	$img				= Core_Fun::rec_post('uploadfiles',1);
	$title		        = Core_Fun::rec_post('title',1);
	$keywords	        = Core_Fun::rec_post('keywords',1);
	$description	    = Core_Fun::rec_post('description',1);
	$target				= Core_Fun::detect_number(Core_Fun::rec_post('target',1),1);
	$linktype			= Core_Fun::detect_number(Core_Fun::rec_post('linktype',1),1);
	$linkurl			= Core_Fun::strip_post('linkurl',1);
	$founderr			= false;
	if(!Core_Fun::ischar($cname)){
	    $founderr	= true;
		$errmsg	   .="分类名称不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$array	= array(
		'cname'=>$cname,
		'orders'=>$orders,
		'flag'=>$flag,
		'intro'=>$intro,
		'timeline'=>time(),
		'elite'=>$elite,
		'img'=>$img,
		'title' => $title,
		'keywords' => $keywords,
		'description' => $description,
		'target'=>$target,
		'linktype'=>$linktype,
		'linkurl'=>$linkurl,
	);
	$result = $db->insert(DB_PREFIX."downloadcate",$array);
	if($result){
		Core_Command::runlog("","添加下载分类成功[$cname]",1);
		msg::msge('保存成功','xycms_downloadcate.php');
	}else{
		msg::msge('保存成功');
	}
}

function saveedit(){
	Core_Auth::checkauth("downloadcateedit");
	global $db;
	$id					= Core_Fun::rec_post('id',1);
	$cname			    = Core_Fun::rec_post('cname',1);
	$intro				= Core_Fun::strip_post('intro',1);
	$orders				= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$flag				= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$elite				= Core_Fun::detect_number(Core_Fun::rec_post('elite',1));
	$img				= Core_Fun::rec_post('uploadfiles',1);
	$title		        = Core_Fun::rec_post('title',1);
	$keywords	        = Core_Fun::rec_post('keywords',1);
	$description	    = Core_Fun::rec_post('description',1);
	$target				= Core_Fun::detect_number(Core_Fun::rec_post('target',1),1);
	$linktype			= Core_Fun::detect_number(Core_Fun::rec_post('linktype',1),1);
	$linkurl			= Core_Fun::strip_post('linkurl',1);
	$founderr	= false;
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
		'orders'=>$orders,
		'flag'=>$flag,
		'intro'=>$intro,
		'elite'=>$elite,
		'img'=>$img,
		'title' => $title,
		'keywords' => $keywords,
		'description' => $description,
		'target'=>$target,
		'linktype'=>$linktype,
		'linkurl'=>$linkurl,
	);
	$result = $db->update(DB_PREFIX."downloadcate",$array,"cid=$id");
	if($result){
		Core_Command::runlog("","编辑下载分类成功[id=$id]");
		msg::msge('编辑成功','xycms_downloadcate.php?'.$GLOBALS['comeurl']);
	}else{
		msg::msge('编辑失败');
	}
}

function del(){
	Core_Auth::checkauth("downloadcatedel");
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('请选择要删除的数据');
	}
	global $db;
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){
			$sql	= "SELECT img FROM ".DB_PREFIX."downloadcate WHERE cid=$id";
			$rows	= $db->fetch_first($sql);
			if($rows){
				if(Core_Fun::ischar($rows['img'])){
					Core_Fun::deletefile("../".$rows['img']);
				}
				$db->query("DELETE FROM ".DB_PREFIX."downloadcate WHERE cid=$id");
			}
		}
	}
	Core_Command::runlog("","删除下载分类成功[id=$arrid]");
	msg::msge('删除成功','xycms_downloadcate.php');
}

function updateajax($_id,$_action){
	Core_Auth::checkauth("downloadcateedit");
    if(Core_Fun::isnumber($_id)){
		global $db;
		switch($_action){
			case 'flagopen':
				$db->query("UPDATE ".DB_PREFIX."downloadcate SET flag=1 WHERE cid=$_id");
				break;
			case 'flagclose':
				$db->query("UPDATE ".DB_PREFIX."downloadcate SET flag=0 WHERE cid=$_id");
				break;
			case 'eliteopen':
				$db->query("UPDATE ".DB_PREFIX."downloadcate SET elite=1 WHERE cid=$_id");
				break;
			case 'eliteclose':
				$db->query("UPDATE ".DB_PREFIX."downloadcate SET elite=0 WHERE cid=$_id");
				break;
			default:
				break;
		}
	}
}

$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."downloadcate.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>