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
$sskinid    = Core_Fun::detect_number(Core_Fun::rec_post("sskinid"));
$sname      = Core_Fun::rec_post("sname",1);
if($page<1){$page=1;}
$comeurl	= "page=$page&sskinid=$sskinid&sname=".urlencode($sname)."";

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
	Core_Auth::checkauth("delimitvolist");
	global $db,$tpl,$page,$sskinid,$sname;
    $pagesize	= 30;
	$searchsql	= " WHERE 1=1";
	if($sskinid>0){
		$searchsql .= " AND l.skinid=$sskinid";
	}
	if(Core_Fun::ischar($sname)){
		$searchsql .= " AND l.labelname LIKE '%".$sname."%'";
	}
	$countsql	= "SELECT COUNT(l.labelid) FROM ".DB_PREFIX."delimitlabel AS l".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT l.*,s.skinname".
		          " FROM ".DB_PREFIX."delimitlabel AS l".
		          " LEFT JOIN ".DB_PREFIX."skin AS s ON l.skinid=s.skinid".
		          $searchsql." ORDER BY l.labelid DESC LIMIT $start, $pagesize";
	$delimitlabel	= $db->getall($sql);
	$url		= $_SERVER['PHP_SELF'];
	$urlitem	= "sskinid=$sskinid&sname=".urlencode($sname)."";
	$url	   .= "?".$urlitem;
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("delimitlabel",$delimitlabel);
	$tpl->assign("skin_search",Core_Mod::db_select($sskinid,"skinid","skin"));
	$tpl->assign("sname",$sname);
}

function add(){
	Core_Auth::checkauth("delimitadd");
	global $tpl;
	$tpl->assign("flag_checkbox",Core_Mod::checkbox("1","flag","审核"));
	$tpl->assign("skin_select",Core_Mod::db_select($GLOBALS['core_skin']['skinid'],"skinid","skin"));
}

function edit(){
	Core_Auth::checkauth("delimitedit");
	global $db,$tpl;
    $id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		msg::msge('ID丢失!');
	}
	$sql		= "SELECT * FROM ".DB_PREFIX."delimitlabel WHERE labelid=$id";
	$delimitlabel	= $db->fetch_first($sql);
	if(!$delimitlabel){
		msg::msge('数据不存在!');
	}else{
		$tpl->assign("flag_checkbox",Core_Mod::checkbox($delimitlabel['flag'],"flag","审核"));
		$tpl->assign("skin_select",Core_Mod::db_select($delimitlabel['skinid'],"skinid","skin"));
		$tpl->assign("id",$id);
		$tpl->assign("comeurl",$GLOBALS['comeurl']);
	    $tpl->assign("delimitlabel",$delimitlabel);
	}
}

function saveadd(){
	Core_Auth::checkauth("delimitadd");
	global $db;
	$skinid			= Core_Fun::detect_number(Core_Fun::rec_post('skinid',1));
	$labelname		= Core_Fun::rec_post('labelname',1);
	$labeltitle		= Core_Fun::rec_post('labeltitle',1);
	$labelcontent	= Core_Fun::strip_post('labelcontent',1);
	$flag			= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$labelcontent	= Core_Fun::strip_post('labelcontent',1);
	$founderr		= false;
	if(!Core_Fun::ischar($labelname)){
	    $founderr	= true;
		$errmsg	   .="标签名称不能为空.";
	}
	if(!Core_Fun::ischar($labeltitle)){
	    $founderr	= true;
		$errmsg	   .="标签描述不能为空.";
	}
	if($founderr == true){
	    Core_Fun::halt($errmsg,"",1);
	    msg::msge($errmsg);
	}
	$array	= array(
		'skinid'=>$skinid,
		'labeltitle'=>$labeltitle,
		'labelname'=>$labelname,
		'labelcontent'=>$labelcontent,
		'flag'=>$flag,
		'timeline'=>time(),
		'labelcontent'=>$labelcontent,
	);
	$result = $db->insert(DB_PREFIX."delimitlabel",$array);
	if($result){
		Core_Command::runlog("","添加标签成功[$labelname]",1);
		msg::msge('保存成功!','xycms_delimitlabel.php');
	}else{
		msg::msge('保存失败!');
	}
}

function saveedit(){
	Core_Auth::checkauth("delimitedit");
	global $db;
	$id				= Core_Fun::rec_post('id',1);
	$skinid			= Core_Fun::detect_number(Core_Fun::rec_post('skinid',1));
	$labelname		= Core_Fun::rec_post('labelname',1);
	$labeltitle		= Core_Fun::rec_post('labeltitle',1);
	$labelcontent	= Core_Fun::strip_post('labelcontent',1);
	$flag			= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$labelcontent	= Core_Fun::strip_post('labelcontent',1);
	$founderr	= false;
	if(!Core_Fun::isnumber($id)){
	    $founderr	= true;
		$errmsg	   .= "ID丢失.";
	}
	if(!Core_Fun::ischar($labelname)){
	    $founderr	= true;
		$errmsg	   .="标签名称不能为空.";
	}
	if(!Core_Fun::ischar($labeltitle)){
	    $founderr	= true;
		$errmsg	   .="标签描述不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$array = array(
		'skinid'=>$skinid,
		'labeltitle'=>$labeltitle,
		'labelname'=>$labelname,
		'labelcontent'=>$labelcontent,
		'flag'=>$flag,
		'labelcontent'=>$labelcontent,
	);
	$result = $db->update(DB_PREFIX."delimitlabel",$array,"labelid=$id");
	if($result){
		Core_Command::runlog("","编辑标签成功[id=$id]");
		msg::msge('编辑成功!','xycms_delimitlabel.php?'.$GLOBALS['comeurl']);
	}else{
		msg::msge('编辑失败!');
	}
}

function del(){
	Core_Auth::checkauth("delimitdel");
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('请选择要删除的数据!');
	}
	global $db;
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){
			$GLOBALS['db']->query("DELETE FROM ".DB_PREFIX."delimitlabel WHERE labelid=$id");
		}
	}
	Core_Command::runlog("","删除标签成功[id=$arrid]");
	msg::msge('删除成功!','xycms_delimitlabel.php');
}

function updateajax($_id,$_action){
	Core_Auth::checkauth("delimitedit");
    if(Core_Fun::isnumber($_id)){
		global $db;
		switch($_action){
			case 'flagopen':
				$db->query("UPDATE ".DB_PREFIX."delimitlabel SET flag=1 WHERE labelid=$_id");
				break;
			case 'flagclose':
				$db->query("UPDATE ".DB_PREFIX."delimitlabel SET flag=0 WHERE labelid=$_id");
				break;
			default:
				break;
		}
	}
}

$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."delimitlabel.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>