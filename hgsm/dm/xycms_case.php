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
	case 'orders':
	    orders();
		break;
	case 'saveedit':
	    saveedit();
		break;
	case 'setting':
	    setting();
		break;
	case 'savesetting':
	    savesetting();
		break;
	case 'del':
	    del();
		break;
	default:
	    volist();
		break;
}

function volist(){
	Core_Auth::checkauth("casevolist");
	global $db,$tpl,$page,$scateid,$sname;
    $pagesize	= 30;
	$searchsql	= " WHERE 1=1";

	if (intval($scateid)>0)
	{
		$childs_sql = Core_Mod::build_childsql("casecate", "i", intval($scateid), "");
		if (Core_Fun::ischar($childs_sql))
		{
			$searchsql .= " AND (i.cid='".intval($scateid)."'".$childs_sql.")";
		}
		else
		{
			$searchsql .= " AND i.cid='".intval($scateid)."'";
		}
	}
	if(Core_Fun::ischar($sname)){
		$searchsql .= " AND i.title LIKE '%".$sname."%'";
	}
	$countsql	= "SELECT COUNT(i.id) FROM ".DB_PREFIX."case AS i".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT i.*,c.cname".
		          " FROM ".DB_PREFIX."case AS i".
		          " LEFT JOIN ".DB_PREFIX."casecate AS c ON i.cid=c.cid".
		          $searchsql." ORDER BY i.orders DESC LIMIT $start, $pagesize";
	$case		= $db->getall($sql);
	$url		= $_SERVER['PHP_SELF'];
	$urlitem	= "scateid=$scateid&sname=".urlencode($sname)."";
	$url	   .= "?".$urlitem;
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$taskConfigFile = CHENCY_ROOT.'data/cache/task_config.php';
	$taskName = '';
	if(file_exists($taskConfigFile)){
		$taskConfig = require $taskConfigFile;
		if($taskConfig['flag'] == 1){
			if(!empty($taskConfig['cid'])){
				$cid = implode(',', $taskConfig['cid']);
				$sql  = 'SELECT `cname` FROM '.DB_PREFIX."casecate WHERE `cid` IN({$cid})";
				$taskCate = $db->getall($sql);
				$taskName = '';
				if(!empty($taskCate)){
					foreach($taskCate as $key=>$val){
						$taskName .= $val['cname'].',';
					}
					$taskName = substr($taskName, 0, -1);
				}
			}
		}
	}
	$tpl->assign("taskName",$taskName);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("case",$case);
	$tpl->assign("urlitem",$urlitem);
	//$tpl->assign("cate_search",Core_Mod::db_select($scateid,"scateid","casecate"));
	$tpl->assign("cate_search", Core_Mod::tree_select("casecate", $scateid, "scateid"));
	$tpl->assign("sname",$sname);
}

function add(){
	Core_Auth::checkauth("caseadd");
	$cid = (is_numeric($_GET['cid']) && isset($_GET['cid'])) ? intval($_GET['cid']): '';
	global $tpl,$config;
	$tags = explode(',',$config['metakeyword']);
	$size="(图片大小：".$config['uploadwidth']."*".$config['uploadheight'].")";
	$tpl->assign("size",$size);
	$tpl->assign("tags",$tags);
	$tpl->assign("flag_checkbox",Core_Mod::checkbox("1","flag","审核"));
	$tpl->assign("elite_checkbox",Core_Mod::checkbox("","elite","推荐"));
	//$tpl->assign("cate_select",Core_Mod::db_select($cid,"cid","casecate"));
	$tpl->assign("cate_select",Core_Mod::tree_select("casecate",$cid,"cid"));
}

function edit(){
	Core_Auth::checkauth("caseedit");
	global $db,$tpl,$config,$page;
    $id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		msg::msge('ID丢失');
	}
	$sql	= "SELECT * FROM ".DB_PREFIX."case WHERE id=$id LIMIT 1";
	$case	= $db->fetch_first($sql);
	if(!$case){
		msg::msge('数据不存在');
	}else{
		$tags  = array();
		$f_tag = explode(',',$config['metakeyword']);
		$p     = explode(',',$case['tag']);
		foreach($f_tag as $key => $f){
          $tags[$key]['name'] = $f;
          $tags[$key]['mark'] = 0;
          foreach($p as $pp){
            if($f == $pp){
             $tags[$key]['mark'] = 1;
             }
          }
		}
		$size="(图片大小：".$config['uploadwidth']."*".$config['uploadheight'].")";
	    $tpl->assign("tags",$tags);
		$case['uploadpicname'] = Core_Mod::getpicname($case['uploadfiles']);
		$case['thumbpicname'] = Core_Mod::getpicname($case['thumbfiles']);
		$tpl->assign("size",$size);
		$tpl->assign("flag_checkbox",Core_Mod::checkbox($case['flag'],"flag","审核"));
		$tpl->assign("elite_checkbox",Core_Mod::checkbox($case['elite'],"elite","推荐"));
		$tpl->assign("cate_select",Core_Mod::tree_select("casecate",$case['cid'],"cid"));
		$tpl->assign("page",$page);
		$tpl->assign("id",$id);
		$tpl->assign("comeurl",$GLOBALS['comeurl']);
	    $tpl->assign("case",$case);
	}
}

function saveadd(){
	Core_Auth::checkauth("caseadd");
	global $db;
	$cid			= Core_Fun::detect_number(Core_Fun::rec_post('cid',1));
	$title			= Core_Fun::rec_post('title',1);
	$thumbfiles		= Core_Fun::strip_post('thumbfiles',1);
	$uploadfiles	= Core_Fun::strip_post('uploadfiles',1);
	$hits			= Core_Fun::detect_number(Core_Fun::rec_post('hits',1));
	$content		= Core_Fun::strip_post('content',1);
	$flag			= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$elite			= Core_Fun::detect_number(Core_Fun::rec_post('elite',1));
	$ctitle		    = Core_Fun::rec_post('ctitle',1);
	$ckeywords	    = Core_Fun::rec_post('ckeywords',1);
	$cdescription	= Core_Fun::rec_post('cdescription',1);
	$timeline		= isset($_POST['timeline']) && strlen(strtotime($_POST['timeline'])) == 10 ? intval(strtotime($_POST['timeline'])) : $_SERVER['REQUEST_TIME'];
	$tag			= Core_Fun::rec_post('tag',1);
	$tag = str_replace('，', ',', $tag);
	$tag = str_replace(' ', '', $tag);
	$tag_array = explode(',', $tag);
	$tag_array = array_unique($tag_array);
	$tag = implode(',',$tag_array);
	
	$taskConfigFile = CHENCY_ROOT.'data/cache/task_config.php';
	if(file_exists($taskConfigFile)){
		$taskConfig = require $taskConfigFile;
		if(!empty($taskConfig['cid'])){
			if($taskConfig['flag'] == 1 && in_array($cid, $taskConfig['cid'])){
				$flag = 0;
			}
		}
	}
	$founderr		= false;
	if($cid<1){
	    $founderr	= true;
		$errmsg	   .="请选择分类.";
	}
	if(!Core_Fun::ischar($title)){
	    $founderr	= true;
		$errmsg	   .="标题不能为空.";
	}
	if(!Core_Fun::ischar($content)){
	    $founderr	= true;
		$errmsg	   .="内容不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	if(Core_Fun::ischar($thumbfiles)){
		if(!file_exists("../".$thumbfiles)){
			$thumbfiles = $uploadfiles;
		}
	}
	$orders	= $db->fetch_newid("SELECT MAX(orders) FROM ".DB_PREFIX."case",1);
	$array	= array(
		'cid'=>$cid,
		'title'=>$title,
		'thumbfiles'=>$thumbfiles,
		'uploadfiles'=>$uploadfiles,
		'content'=>$content,
		'timeline'=>$timeline,
		'elite'=>$elite,
		'ctitle' => $ctitle,
		'ckeywords' => $ckeywords,
		'cdescription' => $cdescription,
		'flag'=>$flag,
		'orders'=>$orders,
		'tag'=>$tag,
		'hits'=>$hits,
	);
	$result = $db->insert(DB_PREFIX."case",$array);
	if($result){
		Core_Command::runlog("","发布信息成功[$title]",1);
		msg::msge('保存成功',"xycms_case.php?action=add&cid={$cid}");
	}else{
		msg::msge('保存失败');
	}
}

function orders()
{
	global $db;
	$arrid = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	$forwardurl="xycms_case.php";
	if($arrid=="" || is_null($arrid)){
        header("Content-type:text/html;charset=utf-8");
		echo "<script>alert('请选择要更新的案例')</script>";
		echo("<meta http-equiv='refresh' content='0;url='.$forwardurl>");
		die();
	}
	$arrorders=isset($_REQUEST['orders']) ? $_REQUEST['orders'] : "";
	// print_r($arrorders);die();
	$count = count($arrid);
	for($i=0;$i<$count;$i++){
   	 $array = array(
       'orders' => $arrorders[$i],
   	 );
   	 $result = $db->update(DB_PREFIX."case",$array,"id=$arrid[$i]");
	}
   	header("Content-type:text/html;charset=utf-8");
   	echo "<script>alert('更新排序成功！')</script>";
   	echo("<meta http-equiv='refresh' content='0;url='.$forwardurl>");
   	exit;

}

function saveedit(){
	Core_Auth::checkauth("caseedit");
	global $db;
	$id				= Core_Fun::rec_post('id',1);
	$cid			= Core_Fun::detect_number(Core_Fun::rec_post('cid',1));
	$title			= Core_Fun::rec_post('title',1);
	$thumbfiles		= Core_Fun::strip_post('thumbfiles',1);
	$uploadfiles	= Core_Fun::strip_post('uploadfiles',1);
	$hits			= Core_Fun::detect_number(Core_Fun::rec_post('hits',1));
	$content		= Core_Fun::strip_post('content',1);
	$flag			= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$elite			= Core_Fun::detect_number(Core_Fun::rec_post('elite',1));
	$ctitle		    = Core_Fun::rec_post('ctitle',1);
	$ckeywords	    = Core_Fun::rec_post('ckeywords',1);
	$cdescription	= Core_Fun::rec_post('cdescription',1);
	$timeline		= isset($_POST['timeline']) && strlen(strtotime($_POST['timeline'])) == 10 ? intval(strtotime($_POST['timeline'])) : $_SERVER['REQUEST_TIME'];
	$tag			= Core_Fun::rec_post('tag',1);
	$tag = str_replace('，', ',', $tag);
	$tag = str_replace(' ', '', $tag);
	$tag_array = explode(',', $tag);
	$tag_array = array_unique($tag_array);
	$tag = implode(',',$tag_array);
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
		$errmsg	   .="标题不能为空.";
	}
	if(!Core_Fun::ischar($content)){
	    $founderr	= true;
		$errmsg	   .="内容不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	if(Core_Fun::ischar($thumbfiles)){
		if(!file_exists("../".$thumbfiles)){
			$thumbfiles = $uploadfiles;
		}
	}
	$array = array(
		'cid'		  =>$cid,
		'title'		  =>$title,
		'thumbfiles'  => $thumbfiles,
		'uploadfiles' => $uploadfiles,
		'content'     => $content,
		'elite'       => $elite,
		'ctitle' => $ctitle,
		'ckeywords' => $ckeywords,
		'cdescription' => $cdescription,
		'flag'        => $flag,
		'tag'         => $tag,
		'hits'        => $hits,
		'timeline'    => $timeline,
	);
	$result = $db->update(DB_PREFIX."case",$array,"id=$id");
	if($result){
		Core_Command::runlog("","编辑信息成功[id=$id]");
		msg::msge('编辑成功',"xycms_case.php?{$GLOBALS['comeurl']}");
	}else{
		msg::msge('编辑失败');
	}
}

function del(){
	Core_Auth::checkauth("casedel");
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('请选择要删除的数据');
	}
	global $db;
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){
			$db->query("DELETE FROM ".DB_PREFIX."case WHERE id=$id");
		}
	}
	Core_Command::runlog("","删除新闻成功[id=$arrid]");
	msg::msge('删除成功','xycms_case.php');
}

function updateajax($_id,$_action){
	Core_Auth::checkauth("caseedit");
    if(Core_Fun::isnumber($_id)){
		global $db;
		switch($_action){
			case 'flagopen':
				$db->query("UPDATE ".DB_PREFIX."case SET flag=1 WHERE id=$_id");
				break;
			case 'flagclose':
				$db->query("UPDATE ".DB_PREFIX."case SET flag=0 WHERE id=$_id");
				break;
			case 'eliteopen':
				$db->query("UPDATE ".DB_PREFIX."case SET elite=1 WHERE id=$_id");
				break;
			case 'eliteclose':
				$db->query("UPDATE ".DB_PREFIX."case SET elite=0 WHERE id=$_id");
				break;
			default:
				break;
		}
	}
}
$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."case.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
