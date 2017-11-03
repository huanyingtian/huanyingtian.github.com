<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XiangYun v1.0
 * @Update     2012.07.07
**/
require '../source/core/run.php';
require 'admin.inc.php';
$action		= Core_Fun::rec_post("action");
$page		= Core_Fun::detect_number(Core_Fun::rec_post("page"),1);
$szoneid    = Core_Fun::detect_number(Core_Fun::rec_post("szoneid"));
if($page<1){$page=1;}
$comeurl	= "page={$page}&szoneid={$szoneid}";

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
	Core_Auth::checkauth("adsvolist");
	global $db,$tpl,$page,$szoneid,$sname;
    $pagesize	= 30;
	$searchsql	= " WHERE 1=1";
	if($szoneid <= 0){
		$sql = 'SELECT min(zoneid) as `zoneid` FROM '.DB_PREFIX.'adsfigure';
		$result = $db->fetch_first($sql);
		$szoneid = $result['zoneid'];
	}
	$szoneid = $szoneid ? $szoneid : 1;
	$searchsql .= " AND a.zoneid=$szoneid";
	$countsql	= "SELECT COUNT(a.adsid) FROM ".DB_PREFIX."adsfigure AS a".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT a.*,z.zonename,z.zonelabel,z.width,z.height,z.slide".
		          " FROM ".DB_PREFIX."adsfigure AS a".
		          " LEFT JOIN ".DB_PREFIX."adszone AS z ON a.zoneid=z.zoneid".
		          $searchsql." ORDER BY z.zoneid ASC,a.orders ASC LIMIT $start, $pagesize";
	$ads		= $db->getall($sql);
	$url		= $_SERVER['PHP_SELF'];
	$urlitem	= "szoneid=$szoneid&sname=".urlencode($sname)."";
	$url	   .= "?".$urlitem;
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign("szoneid",$szoneid);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("ads",$ads);
	$tpl->assign("urlitem",$urlitem);
	$tpl->assign("category",Core_Mod::getcategory("zoneid","adszone"));
	$tpl->assign("sname",$sname);
}

function add(){
	Core_Auth::checkauth("adsadd");
	global $tpl,$db;
	$tpl->assign("category",Core_Mod::getcategory("zoneid","adszone"));
	$orders = $db->fetch_newid("SELECT MAX(orders) FROM ".DB_PREFIX."adsfigure",1);
	$tpl->assign("flag_checkbox",Core_Mod::checkbox("1","flag","审核"));
	$tpl->assign("adszone_select",Core_Mod::db_select("","zoneid","adszone"));
	$tpl->assign("orders",$orders);
}

function edit(){
	Core_Auth::checkauth("adsedit");
	global $db,$tpl;
    $id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		Core_Fun::halt("ID丢失","",2);
		msg::msge('ID丢失');
	}
	$sql	= "SELECT * FROM ".DB_PREFIX."adsfigure WHERE adsid=$id";
	$ads	= $db->fetch_first($sql);
	if(!$ads){
		msg::msge('数据不存在');
	}else{
		$ads["uploadpicname"] = Core_Mod::getpicname($ads['uploadfiles']);
		$tpl->assign("flag_checkbox",Core_Mod::checkbox($ads['flag'],"flag","审核"));
		$tpl->assign("adszone_select",Core_Mod::db_select($ads['zoneid'],"zoneid","adszone"));
		$tpl->assign("id",$id);
		$tpl->assign("comeurl",$GLOBALS['comeurl']);
	    $tpl->assign("ads",$ads);
	}
}

function saveadd(){
	Core_Auth::checkauth("adsadd");
	global $db;
	$zoneid			= Core_Fun::detect_number(Core_Fun::rec_post('zoneid',1));
	$adsname		= Core_Fun::rec_post('adsname',1);
	$uploadfiles	= Core_Fun::strip_post('uploadfiles',1);
	$url			= Core_Fun::strip_post('url',1);
	$flag			= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$orders			= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$width			= Core_Fun::detect_number(Core_Fun::rec_post('width',1));
	$height			= Core_Fun::detect_number(Core_Fun::rec_post('height',1));
	$content		= Core_Fun::strip_post('content',1);
	$founderr		= false;
	if($zoneid<1){
	    $founderr	= true;
		$errmsg	   .="请选择所属广告标签.";
	}
	if(!Core_Fun::ischar($uploadfiles)){
	    $founderr	= true;
		$errmsg	   .="图片附件不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$array	= array(
		'adsname'=>$adsname,
		'zoneid'=>$zoneid,
		'uploadfiles'=>$uploadfiles,
		'url'=>$url,
		'width'=>$width,
		'height'=>$height,
		'orders'=>$orders,
		'flag'=>$flag,
		'content'=>$content,
		'timeline'=>time(),
	);
	$result = $db->insert(DB_PREFIX."adsfigure",$array);
	if($result){
		Core_Command::runlog("","添加广告图片成功[$adsname]",1);
		msg::msge('保存成功',"xycms_ads.php?szoneid={$zoneid}");
	}else{
		msg::msge('保存失败');
	}
}

function saveedit(){
	Core_Auth::checkauth("adsedit");
	global $db;
	$id				= Core_Fun::rec_post('id',1);
	$zoneid			= Core_Fun::detect_number(Core_Fun::rec_post('zoneid',1));
	$adsname		= Core_Fun::rec_post('adsname',1);
	$uploadfiles	= Core_Fun::strip_post('uploadfiles',1);
	$url			= Core_Fun::strip_post('url',1);
	$flag			= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$orders			= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$width			= Core_Fun::detect_number(Core_Fun::rec_post('width',1));
	$height			= Core_Fun::detect_number(Core_Fun::rec_post('height',1));
	$content		= Core_Fun::strip_post('content',1);
	$founderr	= false;
	if(!Core_Fun::isnumber($id)){
	    $founderr	= true;
		$errmsg	   .= "ID丢失.";
	}
	if($zoneid<1){
	    $founderr	= true;
		$errmsg	   .="请选择所属广告标签.";
	}
	if(!Core_Fun::ischar($uploadfiles)){
	    $founderr	= true;
		$errmsg	   .="图片附件不能为空.";
	}
	if($founderr == true){
		msg::msge($errmsg);
	}
	$array = array(
		'adsname'=>$adsname,
		'zoneid'=>$zoneid,
		'uploadfiles'=>$uploadfiles,
		'url'=>$url,
		'width'=>$width,
		'height'=>$height,
		'orders'=>$orders,
		'flag'=>$flag,
		'content'=>$content,
	);
	$result = $db->update(DB_PREFIX."adsfigure",$array,"adsid=$id");
	if($result){
		Core_Command::runlog("","编辑广告图成功[id=$id]");
		msg::msge('编辑成功',"xycms_ads.php?szoneid={$zoneid}");
	}else{
		msg::msge('编辑失败');
	}
}

function del(){
	Core_Auth::checkauth("adsdel");
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('请选择要删除的数据');
	}
	global $db;
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){

			$sql	= "SELECT uploadfiles FROM ".DB_PREFIX."adsfigure WHERE adsid=$id";
			$rows	= $GLOBALS['db']->fetch_first($sql);
			if($rows){
				if(Core_Fun::ischar($rows['uploadfiles'])){
					Core_Fun::deletefile("../".$rows['uploadfiles']);
				}
				$GLOBALS['db']->query("DELETE FROM ".DB_PREFIX."adsfigure WHERE adsid=$id");
			}
		}
	}
	Core_Command::runlog("","删除广告图片成功[id=$arrid]");
	msg::msge('删除成功','xycms_ads.php');
}

function updateajax($_id,$_action){
	Core_Auth::checkauth("adsedit");
    if(Core_Fun::isnumber($_id)){
		global $db;
		switch($_action){
			case 'flagopen':
				$db->query("UPDATE ".DB_PREFIX."adsfigure SET flag=1 WHERE adsid=$_id");
				break;
			case 'flagclose':
				$db->query("UPDATE ".DB_PREFIX."adsfigure SET flag=0 WHERE adsid=$_id");
				break;
			default:
				break;
		}
	}
}

$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."adsfigure.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>