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
	Core_Auth::checkauth("jobvolist");
	global $db,$tpl,$page,$scateid,$sname;
    $pagesize	= 30;
	$searchsql	= " WHERE 1=1";
	if($scateid>0){
		$searchsql .= " AND j.cid=$scateid";
	}
	if(Core_Fun::ischar($sname)){
		$searchsql .= " AND j.title LIKE '%".$sname."%'";
	}
	$countsql	= "SELECT COUNT(j.id) FROM ".DB_PREFIX."job AS j".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT j.*,c.cname".
		          " FROM ".DB_PREFIX."job AS j".
		          " LEFT JOIN ".DB_PREFIX."jobcate AS c ON j.cid=c.cid".
		          $searchsql." ORDER BY j.id DESC LIMIT $start, $pagesize";
	$job		= $db->getall($sql);
	$url		= $_SERVER['PHP_SELF'];
	$urlitem	= "scateid=$scateid&sname=".urlencode($sname)."";
	$url	   .= "?".$urlitem;
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("job",$job);
	$tpl->assign("urlitem",$urlitem);
	$tpl->assign("cate_search",Core_Mod::db_select($scateid,"scateid","jobcate"));
	$tpl->assign("sname",$sname);
}

function add(){
	Core_Auth::checkauth("jobadd");
	global $tpl;
	$tpl->assign("flag_checkbox",Core_Mod::checkbox("1","flag","审核"));
	$tpl->assign("cate_select",Core_Mod::db_select("","cid","jobcate"));
}

function edit(){
	Core_Auth::checkauth("jobedit");
	global $db,$tpl;
    $id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		msg::msge('ID丢失');
	}
	$sql	= "SELECT * FROM ".DB_PREFIX."job WHERE id=$id";
	$job	= $db->fetch_first($sql);
	// print_r($job);exit;
	if(!$job){
		msg::msge('数据不存在');
	}else{
		$tpl->assign("flag_checkbox",Core_Mod::checkbox($job['flag'],"flag","审核"));
		$tpl->assign("cate_select",Core_Mod::db_select($job['cid'],"cid","jobcate"));
		$tpl->assign("id",$id);
		$tpl->assign("comeurl",$GLOBALS['comeurl']);
	    $tpl->assign("job",$job);
	}
}

function saveadd(){
	Core_Auth::checkauth("jobadd");
	global $db;
	$cid			= Core_Fun::detect_number(Core_Fun::rec_post('cid',1));
	$title			= Core_Fun::rec_post('title',1);
	$workarea		= Core_Fun::strip_post('workarea',1);
	$thumbfiles		= Core_Fun::strip_post('thumbfiles',1);
	$uploadfiles	= Core_Fun::strip_post('uploadfiles',1);
	$number			= Core_Fun::detect_number(Core_Fun::rec_post('number',1));
	$jobdescription	= Core_Fun::strip_post('jobdescription',1);
	$jobrequest		= Core_Fun::strip_post('jobrequest',1);
	$jobotherrequest= Core_Fun::strip_post('jobotherrequest',1);
	$jobcontact		= Core_Fun::strip_post('jobcontact',1);
	$flag			= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$jtitle		    = Core_Fun::rec_post('jtitle',1);
	$jkeywords	    = Core_Fun::rec_post('jkeywords',1);
	$jdescription	= Core_Fun::rec_post('jdescription',1);
	$founderr		= false;
	if($cid<1){
	    $founderr	= true;
		$errmsg	   .="请选择招聘分类.";
	}
	if(!Core_Fun::ischar($title)){
	    $founderr	= true;
		$errmsg	   .="招聘职位不能为空.";
	}
	if(!Core_Fun::ischar($jobdescription)){
	    $founderr	= true;
		$errmsg	   .="岗位职责不能为空.";
	}
	if(!Core_Fun::ischar($jobrequest)){
	    $founderr	= true;
		$errmsg	   .="职位要求不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$array	= array(
		'cid'=>$cid,
		'title'=>$title,
		'workarea'=>$workarea,
		'thumbfiles'=>$thumbfiles,
		'uploadfiles'=>$uploadfiles,
		'number'=>$number,
		'jobdescription'=>$jobdescription,
		'jobrequest'=>$jobrequest,
		'jobotherrequest'=>$jobotherrequest,
		'jobcontact'=>$jobcontact,
		'flag'=>$flag,
		'jtitle' => $jtitle,
		'jkeywords' => $jkeywords,
		'jdescription' => $jdescription,
		'timeline'=>time(),
	);
	$result = $db->insert(DB_PREFIX.'job',$array);
	if($result){
		msg::msge('保存成功','xycms_job.php');
	}else{
		msg::msge('保存失败');
	}
}

function saveedit(){
	Core_Auth::checkauth("jobedit");
	global $db;
	$id				= Core_Fun::rec_post('id',1);
	$cid			= Core_Fun::detect_number(Core_Fun::rec_post('cid',1));
	$title			= Core_Fun::rec_post('title',1);
	$workarea		= Core_Fun::strip_post('workarea',1);
	$thumbfiles		= Core_Fun::strip_post('thumbfiles',1);
	$uploadfiles	= Core_Fun::strip_post('uploadfiles',1);
	$number			= Core_Fun::detect_number(Core_Fun::rec_post('number',1));
	$jobdescription	= Core_Fun::strip_post('jobdescription',1);
	$jobrequest		= Core_Fun::strip_post('jobrequest',1);
	$jobotherrequest= Core_Fun::strip_post('jobotherrequest',1);
	$jobcontact		= Core_Fun::strip_post('jobcontact',1);
	$flag			= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$jtitle		    = Core_Fun::rec_post('jtitle',1);
	$jkeywords	    = Core_Fun::rec_post('jkeywords',1);
	$jdescription	= Core_Fun::rec_post('jdescription',1);
	$founderr	= false;
	if(!Core_Fun::isnumber($id)){
	    $founderr	= true;
		$errmsg	   .= "ID丢失.";
	}
	if($cid<1){
	    $founderr	= true;
		$errmsg	   .="请选择招聘分类.";
	}
	if(!Core_Fun::ischar($title)){
	    $founderr	= true;
		$errmsg	   .="招聘职位不能为空.";
	}
	if(!Core_Fun::ischar($jobdescription)){
	    $founderr	= true;
		$errmsg	   .="岗位职责不能为空.";
	}
	if(!Core_Fun::ischar($jobrequest)){
	    $founderr	= true;
		$errmsg	   .="职位要求不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$array = array(
		'cid'=>$cid,
		'title'=>$title,
		'workarea'=>$workarea,
		'thumbfiles'=>$thumbfiles,
		'uploadfiles'=>$uploadfiles,
		'number'=>$number,
		'jobdescription'=>$jobdescription,
		'jobrequest'=>$jobrequest,
		'jobotherrequest'=>$jobotherrequest,
		'jobcontact'=>$jobcontact,
		'jtitle' => $jtitle,
		'jkeywords' => $jkeywords,
		'jdescription' => $jdescription,
		'flag'=>$flag,
	);
	$result = $db->update(DB_PREFIX."job",$array,"id=$id");
	if($result){
		Core_Command::runlog("","编辑招聘信息成功[id=$id]");
		msg::msge('编辑成功','xycms_job.php?'.$GLOBALS['comeurl']);
	}else{
		msg::msge('编辑失败');
	}
}

function del(){
	Core_Auth::checkauth("jobdel");
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('编请选择要删除的数据');
	}
	global $db;
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){
			$db->query("DELETE FROM ".DB_PREFIX."job WHERE id=$id");
		}
	}
	Core_Command::runlog("","删除招聘信息成功[id=$arrid]");
	msg::msge('删除成功','xycms_job.php');
}

function updateajax($_id,$_action){
	Core_Auth::checkauth("jobedit");
    if(Core_Fun::isnumber($_id)){
		global $db;
		switch($_action){
			case 'flagopen':
			   $db->query("UPDATE ".DB_PREFIX."job SET flag=1 WHERE id=$_id");
			   break;
			case 'flagclose':
			   $db->query("UPDATE ".DB_PREFIX."job SET flag=0 WHERE id=$_id");
			   break;
			default:
			   break;
		}
	}
}

$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."job.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>