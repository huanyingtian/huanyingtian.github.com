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
	case 'delcates':
	    delcates();
		break;
	default:
	    volist();
		break;
}

function volist(){
	Core_Auth::checkauth("infocatevolist");
	global $db,$tpl,$page;
    //$pagesize	= 30;
	$searchsql	= " WHERE 1=1";
	$countsql	= "SELECT COUNT(cid) FROM ".DB_PREFIX."infocate".$searchsql;
    $total		= $db->fetch_count($countsql);
    //$pagecount	= ceil($total/$pagesize);
	//$nextpage	= $page+1;
	//$prepage	= $page-1;
	//$start		= ($page-1)*$pagesize;
	$sql		= "SELECT * FROM ".DB_PREFIX."infocate".
		          $searchsql." ORDER BY orders ASC";
	
	$cate = Core_Mod::layer_sort($db->getall($sql));
	
	foreach($cate as $key=>$value)
	{
		$cate[$key]['infocount'] = $db->fetch_count("SELECT COUNT(id) FROM ".DB_PREFIX."info WHERE cid=".$value['cid']."");
		
		switch ($value['depth'])
		{
		case 0:
			$tree = "";
			break;
		case 1:
			$tree = "&nbsp;├&nbsp;&nbsp;";
			break;
		case 2:
			$tree = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├&nbsp;&nbsp;";
			break;
		default:
			die('something was wrong');
			break;
		}
		$cate[$key]['tree_catename'] = $tree.$value['cname'];
	}
	$url		= $_SERVER['PHP_SELF'];
	//$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",1);
	$tpl->assign("page",$page);
	//$tpl->assign("showpage",$showpage);
	$tpl->assign("cate",$cate);
	
}

function add(){
	Core_Auth::checkauth("infocateadd");
	global $tpl,$db;
	$orders  = $db->fetch_newid("SELECT MAX(orders) FROM ".DB_PREFIX."infocate",1);
	$cid = isset($_GET['cid']) && !empty($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) : '';
	$tpl->assign("cate_select", Core_Mod::tree_select("infocate", $cid, "rootid"));
	$tpl->assign("flag_checkbox",Core_Mod::checkbox("1","flag","审核"));
	$tpl->assign("elite_checkbox",Core_Mod::checkbox("1","elite","推荐"));
	$tpl->assign("orders",$orders);
}

function edit(){
	Core_Auth::checkauth("infocateedit");
	global $db,$tpl;
    $id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		msg::msge('ID丢失!');
	}
	$sql	= "SELECT * FROM ".DB_PREFIX."infocate WHERE cid=$id";
	$cate	= $db->fetch_first($sql);
	if(!$cate){
		msg::msge('数据不存在!');
	}else{
		//$tpl->assign("cate_select", Core_Mod::tree_select("infocate", $id, "id"));
		$cate['imgname'] = Core_Mod::getpicname($cate['logoimg']);
		$tpl->assign("flag_checkbox",Core_Mod::checkbox($cate['flag'],"flag","审核"));
		$tpl->assign("elite_checkbox",Core_Mod::checkbox($cate['elite'],"elite","推荐"));
		$tpl->assign("id",$id);
		$tpl->assign("comeurl",$GLOBALS['comeurl']);
	    $tpl->assign("cate",$cate);
	}
}

function saveadd(){
	Core_Auth::checkauth("infocateadd");
	global $db;
	$cname			= Core_Fun::rec_post('cname',1);
	$word    			= Core_Fun::rec_post('word',1);
	$intro				= Core_Fun::strip_post('intro',1);
	$content			= Core_Fun::strip_post('content',1);
	$orders				= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$flag				= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$elite				= Core_Fun::detect_number(Core_Fun::rec_post('elite',1));
	$img				= Core_Fun::rec_post('uploadfiles',1);
	$banner				= Core_Fun::rec_post('banner',1);
	$title		        = Core_Fun::rec_post('title',1);
	$keywords	        = Core_Fun::rec_post('keywords',1);
	$description	    = Core_Fun::rec_post('description',1);
	$target				= Core_Fun::detect_number(Core_Fun::rec_post('target',1),1);
	$linktype			= Core_Fun::detect_number(Core_Fun::rec_post('linktype',1),1);
	$linkurl			= Core_Fun::strip_post('linkurl',1);
	$rootid			    = Core_Fun::rec_post('rootid',1);
	$founderr			= false;
    if (preg_match("/[\x7f-\xff]/", $word)) {
       msg::msge("自定义分类目录不能含有中文字符！");
    }
	if($rootid == 0)
	{
		$rootid	= 0;
		$depth	= 0;
	}
	else
	{
		$root_sql = "SELECT depth FROM ".DB_PREFIX."infocate WHERE cid=$rootid";
		$root_rows = $db->fetch_first($root_sql);
		if($root_rows)
		{
			$depth = (intval($root_rows['depth'])+1);
		}
		else
		{
			$depth = 0;
		}
	}
	if($depth>2)
	{
		msg::msge('对不起，只支持3级分类！');
	}
	
	$cid	= $db->fetch_newid("SELECT MAX(cid) FROM ".DB_PREFIX."infocate",1);
	
	if(!Core_Fun::ischar($cname)){
	    $founderr	= true;
		$errmsg	   .="分类名称不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$array	= array(
		'cid'=>$cid,
		'cname'=>$cname,
		'word'=>$word,
		'parentid'=>$rootid,
		'depth'=>$depth,
		'orders'=>$orders,
		'flag'=>$flag,
		'intro'=>$intro,
		'content'=>$content,
		'timeline'=>time(),
		'elite'=>$elite,
		'img'=>$img,
		'banner'=>$banner,
		'title' => $title,
		'keywords' => $keywords,
		'description' => $description,
		'target'=>$target,
		'linktype'=>$linktype,
		'linkurl'=>$linkurl,
	);
	$result = $db->insert(DB_PREFIX."infocate",$array);
	if($result){
		Core_Command::runlog("","添加资讯分类成功[$cname]",1);
		msg::msge('保存成功','xycms_infocate.php');
	}else{
		msg::msge('保存失败');
	}
}

function saveedit(){
	Core_Auth::checkauth("infocateedit");
	global $db;
	$id					= Core_Fun::rec_post('id',1);
	$cname			    = Core_Fun::rec_post('cname',1);
	$word			    = Core_Fun::rec_post('word',1);
	$intro				= Core_Fun::strip_post('intro',1);
	$content			= Core_Fun::strip_post('content',1);
	$orders				= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$flag				= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$elite				= Core_Fun::detect_number(Core_Fun::rec_post('elite',1));
	$img				= Core_Fun::rec_post('uploadfiles',1);
	$banner				= Core_Fun::rec_post('banner',1);
	$title		        = Core_Fun::rec_post('title',1);
	$keywords	        = Core_Fun::rec_post('keywords',1);
	$description	    = Core_Fun::rec_post('description',1);
	$target				= Core_Fun::detect_number(Core_Fun::rec_post('target',1),1);
	$linktype			= Core_Fun::detect_number(Core_Fun::rec_post('linktype',1),1);
	$linkurl			= Core_Fun::strip_post('linkurl',1);
	$founderr	= false;
    if (preg_match("/[\x7f-\xff]/", $word)) {
       msg::msge("自定义分类目录不能含有中文字符！");
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
		'word'=>$word,
		'orders'=>$orders,
		'flag'=>$flag,
		'intro'=>$intro,
		'content'=>$content,
		'elite'=>$elite,
		'img'=>$img,
		'banner'=>$banner,
		'title' => $title,
		'keywords' => $keywords,
		'description' => $description,
		'target'=>$target,
		'linktype'=>$linktype,
		'linkurl'=>$linkurl,
	);
	$result = $db->update(DB_PREFIX."infocate",$array,"cid=$id");
	if($result){
		Core_Command::runlog("","编辑资讯分类成功[id=$id]");
		msg::msge('编辑成功','xycms_infocate.php?'.$GLOBALS['comeurl']);
	}else{
		msg::msge('编辑失败!');
	}
}

function delcates(){
	Core_Auth::checkauth("productdel");
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('请选择要删除的数据');
	}
	global $db;
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){
			if(Core_Mod::exist_child($id,"infocate")){
				msg::msge('对不起，所删分类下含有子类，不能删除！');
			}else{
				$db->query("DELETE FROM ".DB_PREFIX."infocate WHERE cid=$id");
			}
			
		}
	}
	Core_Command::runlog("","删除新闻分类成功[cid=$arrid]");
	msg::msge('删除成功','xycms_infocate.php');
}

function del(){
	Core_Auth::checkauth("infocatedel");
	/*
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid))
	{
		msg::msge('请选择要删除的数据!');
	}
	global $db;
	for($ii=0;$ii<count($arrid);$ii++)
	{
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id))
		{
			$sql	= "SELECT img FROM ".DB_PREFIX."infocate WHERE cid=$id";
			$rows	= $db->fetch_first($sql);
			if($rows)
			{
				if(Core_Fun::ischar($rows['img']))
				{
					Core_Fun::deletefile("../".$rows['img']);
				}
				$db->query("DELETE FROM ".DB_PREFIX."infocate WHERE cid=$id");
			}
		}
	}
	Core_Command::runlog("","删除资讯分类成功[id=$arrid]");
	msg::msge('删除成功!','xycms_infocate.php');
	*/
	
	Core_Auth::checkauth("infocatedel");
	$id	= Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id))
	{
		msg::msge('请选择要删除的数据');
	}
	else
	{
		if(Core_Mod::exist_child($id,"infocate"))
		{
			msg::msge('对不起，该分类下含有子类，不能删除！');
		}
		else
		{
			$GLOBALS['db']->query("DELETE FROM ".DB_PREFIX."infocate WHERE cid=$id");
			Core_Command::runlog("","删除产品分类分类成功[id=$id]",1);
			msg::msge('删除成功','xycms_infocate.php');
		}
	}
}

function updateajax($_id,$_action){
	Core_Auth::checkauth("infocateedit");
    if(Core_Fun::isnumber($_id)){
		global $db;
		switch($_action){
			case 'flagopen':
				$db->query("UPDATE ".DB_PREFIX."infocate SET flag=1 WHERE cid=$_id");
				break;
			case 'flagclose':
				$db->query("UPDATE ".DB_PREFIX."infocate SET flag=0 WHERE cid=$_id");
				break;
			case 'eliteopen':
				$db->query("UPDATE ".DB_PREFIX."infocate SET elite=1 WHERE cid=$_id");
				break;
			case 'eliteclose':
				$db->query("UPDATE ".DB_PREFIX."infocate SET elite=0 WHERE cid=$_id");
				break;
			default:
				break;
		}
	}
}

$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."infocate.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>