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
$comeurl	= "page=$page&scateid=$scateid&sname=".urlencode($sname)."";

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
	Core_Auth::checkauth("downloadvolist");
	global $db,$tpl,$page,$scateid,$sname;
    $pagesize	= 30;
	$searchsql	= " WHERE 1=1";
	if($scateid>0){
		$searchsql .= " AND d.cid=$scateid";
	}
	if(Core_Fun::ischar($sname)){
		$searchsql .= " AND d.title LIKE '%".$sname."%'";
	}
	$countsql	= "SELECT COUNT(d.id) FROM ".DB_PREFIX."download AS d".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT d.*,c.cname".
		          " FROM ".DB_PREFIX."download AS d".
		          " LEFT JOIN ".DB_PREFIX."downloadcate AS c ON d.cid=c.cid".
		          $searchsql." ORDER BY d.id DESC LIMIT $start, $pagesize";
	$download	= $db->getall($sql);
	$url		= $_SERVER['PHP_SELF'];
	$urlitem	= "scateid=$scateid&sname=".urlencode($sname)."";
	$url	   .= "?".$urlitem;
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("download",$download);
	$tpl->assign("urlitem",$urlitem);
	$tpl->assign("cate_search",Core_Mod::db_select($scateid,"scateid","downloadcate"));
	$tpl->assign("sname",$sname);
}

function setting(){
	Core_Auth::checkauth("downloadedit");
	global $db,$tpl,$page;
    $pagesize	= 30;
	$searchsql	= " WHERE 1=1";
	$countsql	= "SELECT COUNT(downid) FROM ".DB_PREFIX."download".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT * FROM ".DB_PREFIX."download".
		          $searchsql." ORDER BY downid DESC LIMIT $start, $pagesize";
	$download	= $db->getall($sql);
	$url		= $_SERVER['PHP_SELF'];
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("download",$download);
}

function add(){
	Core_Auth::checkauth("downloadadd");
	global $tpl;
	$tpl->assign("flag_checkbox",Core_Mod::checkbox("1","flag","审核"));
	$tpl->assign("elite_checkbox",Core_Mod::checkbox("","elite","推荐"));
	$tpl->assign("cate_select",Core_Mod::db_select("","cid","downloadcate"));
	$tpl->assign("time",time());
}

function edit(){
	Core_Auth::checkauth("downloadedit");
	global $db,$tpl;
    $id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		msg::msge('ID丢失');
	}
	$sql		= "SELECT * FROM ".DB_PREFIX."download WHERE id=$id";
	$download	= $db->fetch_first($sql);
	// print_r($download);
	if(!$download){
		msg::msge('数据不存在');
	}else{
		$download['uploadname'] = Core_Mod::getpicname($download['uploadfiles']);
		$tpl->assign("flag_checkbox",Core_Mod::checkbox($download['flag'],"flag","审核"));
		$tpl->assign("elite_checkbox",Core_Mod::checkbox($download['elite'],"elite","推荐"));
		$tpl->assign("cate_select",Core_Mod::db_select($download['cid'],"cid","downloadcate"));
		$tpl->assign("id",$id);
		$tpl->assign("comeurl",$GLOBALS['comeurl']);
	    $tpl->assign("download",$download);
	}
}

function saveadd(){
	Core_Auth::checkauth("downloadadd");
	global $db;
	$cid			= Core_Fun::detect_number(Core_Fun::rec_post('cid',1));
	$title			= Core_Fun::rec_post('title',1);
	$uploadfiles	= Core_Fun::strip_post('uploadfiles',1);
	$realname	    = Core_Fun::strip_post('realname',1);
	$content		= Core_Fun::strip_post('content',1);
	$img	        = Core_Fun::strip_post('img',1);
	$dtitle		    = Core_Fun::rec_post('dtitle',1);
	$dkeywords	    = Core_Fun::rec_post('dkeywords',1);
	$ddescription	= Core_Fun::rec_post('ddescription',1);
	$downs			= Core_Fun::detect_number(Core_Fun::rec_post('downs',1));
	$flag			= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$elite			= Core_Fun::detect_number(Core_Fun::rec_post('elite',1));
    $file = '../'.$uploadfiles;
    if(!file_exists($file)){
    	msg::msge('你上传的文件不存在！');
    	die();
    }
    $filesize = filesize($file);
    $filesize = Core_Fun::format_size($filesize);
	$founderr		= false;
	if($cid<1){
	    $founderr	= true;
		$errmsg	   .="请选择分类.";
	}
	if(!Core_Fun::ischar($title)){
	    $founderr	= true;
		$errmsg	   .="下载标题不能为空.";
	}
	if(!Core_Fun::ischar($uploadfiles)){
	    $founderr	= true;
		$errmsg	   .="下载地址不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$dateline = strtotime($dateline);

	$array	= array(
		'cid'=>$cid,
		'title'=>$title,
		'filesize'=>$filesize,
		'uploadfiles'=>$uploadfiles,
		'img'=>$img,
		'realname'=>$realname,
		'content'=>$content,
		'dtitle' => $dtitle,
		'dkeywords' => $dkeywords,
		'ddescription' => $ddescription,
		'timeline'=>time(),
		'elite'=>$elite,
		'flag'=>$flag,
		'downs'=>$downs,
	);
	$result = $db->insert(DB_PREFIX."download",$array);
	if($result){
		Core_Command::runlog("","发布下载成功[$title]",1);
		msg::msge('保存成功','xycms_download.php');
	}else{
		msg::msge('保存失败');
	}
}

function saveedit(){
	Core_Auth::checkauth("downloadedit");
	global $db;
	$id				= Core_Fun::rec_post('id',1);
	$cid			= Core_Fun::detect_number(Core_Fun::rec_post('cid',1));
	$title			= Core_Fun::rec_post('title',1);
	$uploadfiles	= Core_Fun::strip_post('uploadfiles',1);
	$realname	    = Core_Fun::strip_post('realname',1);
	$content		= Core_Fun::strip_post('content',1);
	$img	        = Core_Fun::strip_post('img',1);
	$dtitle		    = Core_Fun::rec_post('dtitle',1);
	$dkeywords	    = Core_Fun::rec_post('dkeywords',1);
	$ddescription	= Core_Fun::rec_post('ddescription',1);
	$downs			= Core_Fun::detect_number(Core_Fun::rec_post('downs',1));
	$flag			= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$elite			= Core_Fun::detect_number(Core_Fun::rec_post('elite',1));
	$file = '../'.$uploadfiles;
	if(!file_exists($file)){
	  msg::msge('你上传的文件不存在！');	
	}
	$filesize = filesize($file);
	$filesize = Core_Fun::format_size($filesize);
	$founderr	= false;
	if(!Core_Fun::isnumber($id)){
	    $founderr	= true;
		$errmsg	   .= "ID丢失.";
	}
	if($cid<1){
	    $founderr	= true;
		$errmsg	   .="请选择分类.";
	}
	if(!Core_Fun::ischar($title)){
	    $founderr	= true;
		$errmsg	   .="下载标题不能为空.";
	}
	if(!Core_Fun::ischar($uploadfiles)){
	    $founderr	= true;
		$errmsg	   .="下载地址不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$dateline = strtotime($dateline);

	$array = array(
		'cid'=>$cid,
		'title'=>$title,
		'filesize'=>$filesize,
		'uploadfiles'=>$uploadfiles,
		'img'=>$img,
		'realname'=>$realname,
		'content'=>$content,
		'dtitle' => $dtitle,
		'dkeywords' => $dkeywords,
		'ddescription' => $ddescription,
		'elite'=>$elite,
		'flag'=>$flag,
		'downs'=>$downs,
		'timeline'=>time(),
	);
	$result = $db->update(DB_PREFIX."download",$array,"id=$id");
	if($result){
		Core_Command::runlog("","编辑下载成功[id=$id]");
		msg::msge('编辑成功','xycms_download.php?'.$GLOBALS['comeurl']);
	}else{
		msg::msge('编辑失败');
	}
}

function del(){
	Core_Auth::checkauth("downloaddel");
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('请选择要删除的数据!');
	}
	global $db;
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){
			$sql	= "SELECT uploadfiles FROM ".DB_PREFIX."download WHERE id=$id";
			$rows	= $db->fetch_first($sql);
			$db->query("DELETE FROM ".DB_PREFIX."download WHERE id=$id");
		}
	}
	Core_Command::runlog("","删除下载成功[id=$arrid]");
	msg::msge('删除成功','xycms_download.php');
}

function updateajax($_id,$_action){
	Core_Auth::checkauth("downloadedit");
    if(Core_Fun::isnumber($_id)){
		global $db;
		switch($_action){
			case 'flagopen':
				$db->query("UPDATE ".DB_PREFIX."download SET flag=1 WHERE id=$_id");
				break;
			case 'flagclose':
				$db->query("UPDATE ".DB_PREFIX."download SET flag=0 WHERE id=$_id");
				break;
			case 'eliteopen':
				$db->query("UPDATE ".DB_PREFIX."download SET elite=1 WHERE id=$_id");
				break;
			case 'eliteclose':
				$db->query("UPDATE ".DB_PREFIX."download SET elite=0 WHERE id=$_id");
				break;
			default;
				break;
		}
	}
}
$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."download.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>