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
	case 'edit';
	    edit();
		break;
	case 'saveedit':
	    saveedit();
		break;
	case 'del':
	    del();
		break;
	case 'update':
	    update();
		break;
	default:
	    volist();
		break;
}

function volist(){
	Core_Auth::checkauth("skinvolist");
	global $db,$tpl,$page;
    $pagesize	= 30;
	$searchsql	= " WHERE 1=1";
	$countsql	= "SELECT COUNT(skinid) FROM ".DB_PREFIX."skin".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT * FROM ".DB_PREFIX."skin".
		         $searchsql." ORDER BY skinid ASC LIMIT $start, $pagesize";
	$skin		= $db->getall($sql);
	$url		= $_SERVER['PHP_SELF'];
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$img = '../template/'.SKIN.'.jpg';
	if(file_exists($img)){
	  $tpl->assign('skin_img',$img);
	}else{
	  $tpl->assign('skin_img','');
	}
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("skin",$skin);
}

function add(){
	Core_Auth::checkauth("skinadd");
	global $tpl;
	$tpl->assign("flag_checkbox",Core_Mod::checkbox("1","flag","设为当前风格"));
}

function edit(){
	Core_Auth::checkauth("skinedit");
	global $db,$tpl;
    $id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		msg::msge('ID丢失!');
	}
	$sql		= "SELECT * FROM ".DB_PREFIX."skin WHERE skinid=$id";
	$skin		= $db->fetch_first($sql);
	if(!$skin){
		msg::msge('数据不存在!');
	}else{
		$skin['thumbfilename'] = Core_Mod::getpicname($skin['thumbfiles']);
		$tpl->assign("flag_checkbox",Core_Mod::checkbox($skin['flag'],"flag","设为当前风格"));
		$tpl->assign("id",$id);
		$tpl->assign("comeurl",$GLOBALS['comeurl']);
	    $tpl->assign("skin",$skin);
	}
}

function saveadd(){
	Core_Auth::checkauth("skinadd");
	global $db;
	$skinname	= Core_Fun::rec_post('skinname',1);
	$skindir	= Core_Fun::rec_post('skindir',1);
	$skinext	= Core_Fun::rec_post('skinext',1);
	$thumbfiles	= Core_Fun::rec_post('thumbfiles',1);
	$flag		= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$remark		= Core_Fun::strip_post('remark',1);
	$founderr	= false;
	if(!Core_Fun::ischar($skinname)){
	    $founderr	= true;
		$errmsg	   .="风格名称不能为空.";
	}
	if(!Core_Fun::ischar($skindir)){
	    $founderr	= true;
		$errmsg	   .="模版目录不能为空.";
	}
	if(!Core_Fun::ischar($skinext)){
	    $founderr	= true;
		$errmsg	   .="文件名后缀不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	if($flag==1){
		$db->query("UPDATE ".DB_PREFIX."skin SET flag=0");
	}
	$skinid	= $db->fetch_newid("SELECT MAX(skinid) FROM ".DB_PREFIX."skin",1);
	$array	= array(
		'skinid'=>$skinid,
		'skinname'=>$skinname,
		'skindir'=>$skindir,
		'skinext'=>$skinext,
		'thumbfiles'=>$thumbfiles,
		'flag'=>$flag,
		'timeline'=>time(),
		'remark'=>$remark,
	);
	$result = $db->insert(DB_PREFIX."skin",$array);
	if($result){
		Core_Command::runlog("","添加风格成功[$skinname]",1);
		msg::msge('保存成功','xycms_skin.php');
	}else{
		msg::msge('保存失败!');
	}

}

function saveedit(){
	Core_Auth::checkauth("skinedit");
	global $db;
	$id			= Core_Fun::rec_post('id',1);
	$skinname	= Core_Fun::rec_post('skinname',1);
	$skindir	= Core_Fun::rec_post('skindir',1);
	$skinext	= Core_Fun::rec_post('skinext',1);
	$thumbfiles	= Core_Fun::rec_post('thumbfiles',1);
	$flag		= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$remark		= Core_Fun::strip_post('remark',1);
	$founderr	= false;
	if(!Core_Fun::isnumber($id)){
	    $founderr	= true;
		$errmsg	   .= "ID丢失.";
	}
	if(!Core_Fun::ischar($skinname)){
	    $founderr	= true;
		$errmsg	   .="风格名称不能为空.";
	}
	if(!Core_Fun::ischar($skindir)){
	    $founderr	= true;
		$errmsg	   .="模版目录不能为空.";
	}
	if(!Core_Fun::ischar($skinext)){
	    $founderr	= true;
		$errmsg	   .="文件名后缀不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	if($flag==1){
		$db->query("UPDATE ".DB_PREFIX."skin SET flag=0");
	}
	$array = array(
		'skinname'=>$skinname,
		'skindir'=>$skindir,
		'skinext'=>$skinext,
		'thumbfiles'=>$thumbfiles,
		'flag'=>$flag,
		'remark'=>$remark,
	);
	$result = $db->update(DB_PREFIX."skin",$array,"skinid=$id");
	if($result){
		Core_Command::runlog("","编辑风格成功[id=$id]");
		msg::msge('编辑成功','xycms_skin.php?'.$GLOBALS['comeurl']);
	}else{
		msg::msge('编辑失败!');
	}
}

function del(){
	Core_Auth::checkauth("skindel");
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('请选择要删除的数据!');
	}
	global $db;
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){
			$sql	= "SELECT thumbfiles FROM ".DB_PREFIX."skin WHERE skinid=$id";
			$rows	= $db->fetch_first($sql);
			if($rows){
				if(Core_Fun::ischar($rows['thumbfiles'])){
					Core_Fun::deletefile("../".$rows['thumbfiles']);
				}
				$db->query("DELETE FROM ".DB_PREFIX."skin WHERE skinid=$id");
			}
		}
	}
	Core_Command::runlog("","删除风格成功[id=$arrid]");
	msg::msge('删除成功!','xycms_skin.php');
}

function update(){
	Core_Auth::checkauth("skinedit");
	global $db;
	$id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		msg::msge('ID丢失!');
	}
	$db->query("UPDATE ".DB_PREFIX."skin SET flag=0");
	$db->update(DB_PREFIX."skin",array('flag'=>1),"skinid=$id");
	Core_Command::runlog("","设置风格成功[id=$id]");
	msg::msge('设置成功!','xycms_skin.php');
}
$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."skin.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>