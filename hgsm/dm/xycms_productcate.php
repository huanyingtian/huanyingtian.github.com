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

function volist()
{
	Core_Auth::checkauth("productcatevolist");
	global $db,$tpl;
	$cat_id = 0;
	$sql	= "SELECT c.*,COUNT(s.cid) AS has_children,COUNT(a.id) AS content_count".
		  " FROM ".DB_PREFIX."productcate AS c".
		  " LEFT JOIN ".DB_PREFIX."productcate AS s ON c.cid=s.parentid".
		  " LEFT JOIN ".DB_PREFIX."product AS a ON a.cid=c.cid".
		  " GROUP BY c.cid ORDER BY parentid,orders ASC";
	$rows	= $db->getall($sql);
	$cate	= Core_Mod::orders_cate_array($cat_id,$rows);
	foreach($cate as $key => $value)
	{
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
	$total = count($cate);
	$tpl->assign("cate",$cate);
	$tpl->assign("total",$total);
}

function setting()
{
	Core_Auth::checkauth("productcateedit");
	global $db,$tpl;
	$cat_id = 0;
	$sql	= "SELECT c.*,COUNT(s.cateid) AS has_children,COUNT(a.productid) AS content_count".
		  " FROM ".DB_PREFIX."productcate AS c".
		  " LEFT JOIN ".DB_PREFIX."productcate AS s ON c.cateid=s.parentid".
		  " LEFT JOIN ".DB_PREFIX."product AS a ON a.cateid=c.cateid".
		  " GROUP BY c.cateid ORDER BY parentid,orders ASC";
	$rows	= $db->getall($sql);
	$cate	= Core_Mod::orders_cate_array($cat_id,$rows);
	foreach($cate as $key => $value){
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
	$tpl->assign("cate",$cate);
}

function add(){
	Core_Auth::checkauth("productcateadd");
	global $db,$tpl,$config;
	$orders		= $db->fetch_newid("SELECT MAX(orders) FROM ".DB_PREFIX."productcate",1);
	$cid = isset($_GET['cid']) && !empty($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) : '';
	$sql_c= "SELECT `name` FROM ".DB_PREFIX."region ORDER BY id ASC LIMIT 3";
	$city=$db->getall($sql_c);
	$citynew='';
	foreach ($city as $key => $zhi) {
		foreach ($zhi as $key => $value) {
			$citynew.=$value.',';
		}
	}
	$cityword = trim($citynew,',');
	$tailword = $config["tailword"];
	// echo($tailword);
	$tpl->assign("orders",$orders);
	$tpl->assign("flag_checkbox",Core_Mod::checkbox("1","flag","审核"));
	$tpl->assign("elite_checkbox",Core_Mod::checkbox("","elite","推荐"));
	$tpl->assign("cate_select",Core_Mod::tree_select("productcate", $cid, "rootid"));
	$tpl->assign("cityword",$cityword);
	$tpl->assign("tailword",$tailword);
}

function edit(){
	Core_Auth::checkauth("productcateedit");
	global $db,$tpl,$config;
    $id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		msg::msge('ID丢失');
	}
	$sql	= "SELECT * FROM ".DB_PREFIX."productcate WHERE cid=$id";
	$cate	= $db->fetch_first($sql);
	if(!$cate){
		msg::msge('数据不存在');
	}else{
		$sql_c= "SELECT `name` FROM ".DB_PREFIX."region ORDER BY id ASC LIMIT 3";
		$city=$db->getall($sql_c);
		$citynew='';
		foreach ($city as $key => $zhi) {
			foreach ($zhi as $key => $value) {
				$citynew.=$value.',';
			}
		}
		$cityword = trim($citynew,',');
		$tailword = $config["tailword"];
		$tpl->assign("flag_checkbox",Core_Mod::checkbox($cate['flag'],"flag","审核"));
		$tpl->assign("elite_checkbox",Core_Mod::checkbox($cate['elite'],"elite","推荐"));
		$tpl->assign("id",$id);
		$tpl->assign("comeurl",$GLOBALS['comeurl']);
		//$tpl->assign("cate_select",Core_Mod::tree_select("productcate",$cate['parentid'],"rootid"));
	    $tpl->assign("cate",$cate);
	    $tpl->assign("post",$cate['post']);
		$tpl->assign("cityword",$cityword);
		$tpl->assign("tailword",$tailword);
	}
}

function saveadd(){
	Core_Auth::checkauth("productcateadd");
	global $db;
	$rootid				= Core_Fun::detect_number(Core_Fun::rec_post('rootid',1));
	$cname			    = Core_Fun::rec_post('cname',1);
	$word    			= Core_Fun::rec_post('word',1);
	$intro				= Core_Fun::strip_post('intro',1);
	$content		    = Core_Fun::strip_post('content',1);
	$title			    = Core_Fun::rec_post('title',1);
	$keywords			= Core_Fun::rec_post('keywords',1);
	$description		= Core_Fun::rec_post('description',1);
	$orders				= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$flag				= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$elite				= Core_Fun::detect_number(Core_Fun::rec_post('elite',1));
	$post				= Core_Fun::detect_number(Core_Fun::rec_post('post',1));
	$img				= Core_Fun::rec_post('uploadfiles',1);
	$banner				= Core_Fun::rec_post('banner',1);
	$nagao    			= Core_Fun::rec_post('nagao',1);
	$custom				= Core_Fun::detect_number(Core_Fun::rec_post('custom',1));
	$target				= Core_Fun::detect_number(Core_Fun::rec_post('target',1),1);
	$linktype			= Core_Fun::detect_number(Core_Fun::rec_post('linktype',1),1);
	$linkurl			= Core_Fun::strip_post('linkurl',1);
	$founderr			= false;
    if (preg_match("/[\x7f-\xff]/", $word)) {
       msg::msge("自定义分类目录不能含有中文字符！");
    }
	if(!Core_Fun::ischar($cname))
	{
	    $founderr	= true;
		$errmsg	   .="分类名称不能为空.";
	}
	if(!Core_Fun::ischar($word))
	{
		$founderr	= true;
		$errmsg	   .="自定义目录不能为空.";
	}
	if($founderr == true)
	{
	    msg::msge($errmsg);
	}
	if($rootid==0)
	{
		$rootid	= 0;
		$depth	= 0;
	}
	else
	{
		$root_sql = "SELECT depth FROM ".DB_PREFIX."productcate WHERE cid=$rootid";
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
	$cid	= $db->fetch_newid("SELECT MAX(cid) FROM ".DB_PREFIX."productcate",1);
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
		'title'=>$title,
		'keywords'=>$keywords,
		'description'=>$description,
		'post'=>$post,
		'nagao'=>$nagao,
		'timeline'=>time(),
		'elite'=>$elite,
		'img'=>$img,
		'banner'=>$banner,
		'custom'=>$custom,
		'target'=>$target,
		'linktype'=>$linktype,
		'linkurl'=>$linkurl,
	);
	$result = $db->insert(DB_PREFIX."productcate",$array);
	if($result){
		Core_Command::runlog("","添加产品分类成功[$cname]",1);
		msg::msge('保存成功',"xycms_productcate.php?action=add&cid={$rootid}");
	}else{
		msg::msge('保存失败');
	}
}

function saveedit(){
	Core_Auth::checkauth("productcateedit");
	global $db;
	$id					= Core_Fun::rec_post('id',1);
	$cname			    = Core_Fun::rec_post('cname',1);
	$word               = Core_Fun::rec_post('word',1);
	$intro				= Core_Fun::strip_post('intro',1);
	$content			= Core_Fun::strip_post('content',1);
	$title			    = Core_Fun::rec_post('title',1);
	$keywords			= Core_Fun::rec_post('keywords',1);
	$description		= Core_Fun::rec_post('description',1);
	$orders				= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$flag				= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$elite				= Core_Fun::detect_number(Core_Fun::rec_post('elite',1));
	$post				= Core_Fun::detect_number(Core_Fun::rec_post('post',1));
	$img				= Core_Fun::rec_post('uploadfiles',1);
	$banner				= Core_Fun::rec_post('banner',1);
	$nagao    			= Core_Fun::rec_post('nagao',1);
	$target				= Core_Fun::detect_number(Core_Fun::rec_post('target',1),1);
	$linktype			= Core_Fun::detect_number(Core_Fun::rec_post('linktype',1),1);
	$linkurl			= Core_Fun::strip_post('linkurl',1);
	$founderr        = false;
    if (preg_match("/[\x7f-\xff]/", $word)) {
       msg::msge("自定义分类目录不能含有中文字符！");
    }
	if(!Core_Fun::isnumber($id)){
	    $founderr   = true;
		$errmsg    .= "ID丢失.";
	}
	if(!Core_Fun::ischar($cname)){
	    $founderr	= true;
		$errmsg	   .="分类名称不能为空.";
	}
	if(!Core_Fun::ischar($word)){
		$founderr	= true;
		$errmsg	   .="自定义目录不能为空.";
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
        'title'=>$title,
		'keywords'=>$keywords,
		'description'=>$description,
		'post'=>$post,
		'nagao'=>$nagao,
		'elite'=>$elite,
		'img'=>$img,
		'banner'=>$banner,
		'target'=>$target,
		'linktype'=>$linktype,
		'linkurl'=>$linkurl,
	);
	$result = $db->update(DB_PREFIX."productcate",$array,"cid=$id");
	if($result){
		Core_Mod::update_child_depth($id,$depth,"productcate");
		Core_Command::runlog("","编辑产品分类成功[$cname]",1);
		msg::msge('编辑成功','xycms_productcate.php');

	}else{
		msg::msge('编辑失败');
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
			if(Core_Mod::exist_child($id,"productcate")){
				msg::msge('对不起，所删分类下含有子类，不能删除！');
			}else{
				$db->query("DELETE FROM ".DB_PREFIX."productcate WHERE cid=$id");
			}
		}
	}
	Core_Command::runlog("","删除产品分类成功[cid=$arrid]");
	msg::msge('删除成功','xycms_productcate.php');
}

function del(){
	Core_Auth::checkauth("productcatedel");
	$id	= Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id))
	{
		msg::msge('请选择要删除的数据');
	}
	else
	{
		if(Core_Mod::exist_child($id,"productcate"))
		{
			msg::msge('对不起，该分类下含有子类，不能删除！');
		}
		else
		{
			$GLOBALS['db']->query("DELETE FROM ".DB_PREFIX."productcate WHERE cid=$id");
			Core_Command::runlog("","删除产品分类分类成功[id=$id]",1);
			msg::msge('删除成功','xycms_productcate.php');
		}
	}
}

function updateajax($_id,$_action){
	Core_Auth::checkauth("productcateedit");
    if(Core_Fun::isnumber($_id)){
		global $db;
		switch($_action){
			case 'customopen':
			    $db->query("UPDATE ".DB_PREFIX."productcate SET custom=1 WHERE cid=$_id");
			    break;
			case 'customclose':
			    $db->query("UPDATE ".DB_PREFIX."productcate SET custom=0 WHERE cid=$_id");
			    break;
			case 'flagopen':
			    $db->query("UPDATE ".DB_PREFIX."productcate SET flag=1 WHERE cid=$_id");
			    break;
			case 'flagclose':
			    $db->query("UPDATE ".DB_PREFIX."productcate SET flag=0 WHERE cid=$_id");
			    break;
			case 'eliteopen':
			    $db->query("UPDATE ".DB_PREFIX."productcate SET elite=1 WHERE cid=$_id");
			    break;
			case 'eliteclose':
			    $db->query("UPDATE ".DB_PREFIX."productcate SET elite=0 WHERE cid=$_id");
			    break;
			case 'frontopen':
			   $db->query("UPDATE ".DB_PREFIX."productcate SET front=1 WHERE cid=$_id");
			   break;
			case 'frontclose':
			   $db->query("UPDATE ".DB_PREFIX."productcate SET front=0 WHERE cid=$_id");
			   break;
			default:
			    break;
		}
	}
}

$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."productcate.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>