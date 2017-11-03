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
	Core_Auth::checkauth("adszonevolist");
	global $db,$tpl,$page;
    $pagesize	= 30;
	$searchsql	= " WHERE 1=1";
	$countsql	= "SELECT COUNT(zoneid) FROM ".DB_PREFIX."adszone".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT * FROM ".DB_PREFIX."adszone".
		          $searchsql." ORDER BY orders ASC LIMIT $start, $pagesize";
	$adszone	= $db->getall($sql);
	foreach($adszone as $key=>$value){
		$adszone[$key]['adscount'] = $db->fetch_count("SELECT COUNT(adsid) FROM ".DB_PREFIX."adsfigure WHERE zoneid=".$value['zoneid']."");
	}
	$url		= $_SERVER['PHP_SELF'];
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("adszone",$adszone);
}

function add(){
	Core_Auth::checkauth("adszoneadd");
	global $tpl,$db;
	$orders  = $db->fetch_newid("SELECT MAX(orders) FROM ".DB_PREFIX."adszone",1);
	$tpl->assign("flag_checkbox",Core_Mod::checkbox("1","flag","审核"));
	$tpl->assign("orders",$orders);
	$tpl->assign("skin_select",Core_Mod::db_select($GLOBALS['core_skin']['skinid'],"skinid","skin"));
}

function edit(){
	Core_Auth::checkauth("adszoneedit");
	global $db,$tpl;
    $id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		Core_Fun::halt("ID丢失","",2);
	}
	$sql		= "SELECT * FROM ".DB_PREFIX."adszone WHERE zoneid=$id";
	$adszone	= $db->fetch_first($sql);
	if(!$adszone){
		msg::msge('数据不存在');
	}else{
		$tpl->assign("flag_checkbox",Core_Mod::checkbox($adszone['flag'],"flag","审核"));
		$tpl->assign("skin_select",Core_Mod::db_select($adszone['skinid'],"skinid","skin"));
		$tpl->assign("id",$id);
		$tpl->assign("comeurl",$GLOBALS['comeurl']);
	    $tpl->assign("adszone",$adszone);
	}
}

function saveadd(){
	Core_Auth::checkauth("adszoneadd");
	global $db;
	$skinid			= Core_Fun::detect_number(Core_Fun::rec_post('skinid',1));
	$zonename		= Core_Fun::rec_post('zonename',1);
	$zonelabel		= Core_Fun::rec_post('zonelabel',1);
	$orders			= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$flag			= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$intro			= Core_Fun::strip_post('intro',1);
	$width			= Core_Fun::detect_number(Core_Fun::rec_post('width',1));
	$height			= Core_Fun::detect_number(Core_Fun::rec_post('height',1));
	$zonetype		= Core_Fun::detect_number(Core_Fun::rec_post('zonetype',1));
	$founderr		= false;
	if(!Core_Fun::ischar($zonename)){
	    $founderr	= true;
		$errmsg	   .="广告标签描述不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$array	= array(
		'zonename'=>$zonename,
		'zonelabel'=>$zonelabel,
		'skinid'=>$skinid,
		'orders'=>$orders,
		'flag'=>$flag,
		'intro'=>$intro,
		'width'=>$width,
		'height'=>$height,
		'slide'=>1,
		'zonetype'=>$zonetype,
		'timeline'=>time(),
	);
	$result = $db->insert(DB_PREFIX."adszone",$array);
	if($result){
		Core_Command::runlog("","添加广告标签成功[$zonename]",1);
		msg::msge('保存成功','xycms_adszone.php');
	}else{
		msg::msge('保存失败');
	}
}

function saveedit(){
	Core_Auth::checkauth("adszoneedit");
	global $db;
	$id				= Core_Fun::rec_post('id',1);
	$skinid			= Core_Fun::detect_number(Core_Fun::rec_post('skinid',1));
	$zonename		= Core_Fun::rec_post('zonename',1);
	$zonelabel		= Core_Fun::rec_post('zonelabel',1);
	$orders			= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$flag			= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$intro			= Core_Fun::strip_post('intro',1);
	$width			= Core_Fun::detect_number(Core_Fun::rec_post('width',1));
	$height			= Core_Fun::detect_number(Core_Fun::rec_post('height',1));
	$zonetype		= Core_Fun::detect_number(Core_Fun::rec_post('zonetype',1));
	$founderr	= false;
	if(!Core_Fun::isnumber($id)){
	    $founderr	= true;
		$errmsg	   .= "ID丢失.";
	}
	if(!Core_Fun::ischar($zonename)){
	    $founderr	= true;
		$errmsg	   .="广告标签描述不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$array = array(
		'zonename'=>$zonename,
		'zonelabel'=>$zonelabel,
		'skinid'=>$skinid,
		'orders'=>$orders,
		'flag'=>$flag,
		'intro'=>$intro,
		'width'=>$width,
		'height'=>$height,
		'zonetype'=>$zonetype,
	);
	$result = $db->update(DB_PREFIX."adszone",$array,"zoneid=$id");
	if($result){
		Core_Command::runlog("","编辑广告标签成功[id=$id]");
		msg::msge('编辑成功',"xycms_adszone.php?".$GLOBALS['comeurl']);
	}else{
		msg::msge('编辑失败');
	}
}

function del(){
	Core_Auth::checkauth("adszonedel");
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('请选择要删除的数据');
	}
	global $db;
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){
			$GLOBALS['db']->query("DELETE FROM ".DB_PREFIX."adszone WHERE zoneid=$id");
			$GLOBALS['db']->query("DELETE FROM ".DB_PREFIX."adsfigure WHERE zoneid=$id");
		}
	}
	Core_Command::runlog("","删除广告标签成功[id=$arrid]");
	msg::msge("删除成功",'xycms_adszone.php');
}

function updateajax($_id,$_action){
	Core_Auth::checkauth("adszoneedit");
    if(Core_Fun::isnumber($_id)){
		global $db;
		switch($_action){
			case 'flagopen':
				$db->query("UPDATE ".DB_PREFIX."adszone SET flag=1 WHERE zoneid=$_id");
				break;
			case 'flagclose':
				$db->query("UPDATE ".DB_PREFIX."adszone SET flag=0 WHERE zoneid=$_id");
				break;
			case 'slideopen':
				$db->query("UPDATE ".DB_PREFIX."adszone SET slide=1 WHERE zoneid=$_id");
				break;
			case 'slideclose':
				$db->query("UPDATE ".DB_PREFIX."adszone SET slide=0 WHERE zoneid=$_id");
				break;
			default:
				break;
		}
	}
}

$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."adszone.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>