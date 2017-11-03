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
	case 'delcates':
	    delcates();
		break;	
	default:
	    volist();
		break;
}

function volist(){
	Core_Auth::checkauth("pagevolist");
	global $db,$tpl,$page,$scateid,$sname;
    $pagesize	= 30;
	$searchsql	= " WHERE 1=1";
	if($scateid>0){
		$searchsql .= " AND p.cid=$scateid";
	}
	if(Core_Fun::ischar($sname)){
		$searchsql .= " AND p.title LIKE '%".$sname."%'";
	}
	$countsql	= "SELECT COUNT(p.id) FROM ".DB_PREFIX."page AS p".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$sql		= "SELECT p.*,c.cname,c.catdir".
		          " FROM ".DB_PREFIX."page AS p".
		          " LEFT JOIN ".DB_PREFIX."pagecate AS c ON p.cid=c.cid".
		          $searchsql." ORDER BY p.orders ASC";
	$volpage	= $db->getall($sql);
	require CHENCY_ROOT.'source/module/mod.page.php';
	$page_category = Mod_Page::category('',"ORDER BY `orders` ASC");
	// print_r($page_category);die();
	$data = array();
	$chil = array();
	if(!empty($volpage)){
		foreach($page_category as $key=>$val){
			$f = 0;
			foreach ($volpage as $k=>$v)
			{
				if($v['cid'] == $val['cid'] && $v['depth'] ==1)
				{
					$data[$val['cid']][$k] = $v;
					$f = 1;
					$chil_sql = "SELECT p.*,c.cname,c.catdir FROM ".DB_PREFIX.
					"page AS p LEFT JOIN ".DB_PREFIX."pagecate AS c ON p.cid=c.cid where p.parentid=".$v['id']." and p.flag=1 ORDER BY p.orders ASC";
					$chil_val  = $db->getall($chil_sql);
					$sql_count = "SELECT COUNT(cid) FROM ".DB_PREFIX."page where flag=1 and cid=".$val['cid'];
					$counts    = $db->fetch_count($sql_count);
					$data[$val['cid']][$k]['chil_cate'] = $chil_val;
					$data[$val['cid']][$k]['total']     = $counts;
	  			}
				// if($v['depth'] == 1)
				// {
				// 	// $chil[$k] = $v;
				// 	$chil_sql = "SELECT * FROM ".DB_PREFIX."page where parentid=".$v['id']." and flag=1 ORDER BY orders ASC";
				// 	// $data[$key][$k]['chil_cate'] = $v;
				// 	$chil_val = $db->getall($chil_sql);
				// 	$data[$val['cid']]['chil_cate'][]= $chil_val;
				// }
				$data[$val['cid']] = $f ? $data[$val['cid']] : array();
			}
		}
	}
	foreach ($data as $ke => &$vas) {
		$vas = array_values($vas);
	}
	$url		= $_SERVER['PHP_SELF'];
	$urlitem	= "scateid=$scateid&sname=".urlencode($sname)."";
	$url	   .= "?".$urlitem;
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign('page_category',$page_category);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("data",$data);
	$tpl->assign("urlitem",$urlitem);
	$tpl->assign("cate_search",Core_Mod::db_select($scateid,"scateid","pagecate"));
	$tpl->assign("sname",$sname);
}

function add(){
	Core_Auth::checkauth("pageadd");
	global $tpl,$db;
	$temp  = "<select name='cid' id='cid'>";
	$temp .= "<option value=''>==请选择==</option>";
	$sql = "SELECT cid,cname FROM ".DB_PREFIX."pagecate WHERE flag=1 ORDER BY orders ASC";
	$result = $db->getall($sql);
	foreach ($result as $k => $val) {
		$temp .= "<option value='".$val['cid']."'>".$val['cname']."</option>";
		$str   = "├&nbsp;";
		$sql_chir = "SELECT * FROM ".DB_PREFIX."page WHERE cid=".$val['cid']." and flag=1 ORDER BY orders ASC";
		$rel_val  = $db->getall($sql_chir);
		foreach ($rel_val as $key => $value) {
			if($value['depth'] == 1){
				$temp .= "<option value='+".$value['id']."'>".$str.$value['title']."</option>";
			}
		}
	}
	$temp .= "</select>";
	$orders = $db->fetch_newid("SELECT MAX(orders) FROM ".DB_PREFIX."page",1);
	$tpl->assign("flag_checkbox",Core_Mod::checkbox("1","flag","审核"));
	$tpl->assign("cate_select",$temp);
	// $tpl->assign("cate_select",Core_Mod::db_select("","cid","pagecate"));
	$tpl->assign("orders",$orders);
}

function edit(){
	Core_Auth::checkauth("pageedit");
	global $db,$tpl;
    $id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		msg::msge('ID丢失');
	}
	$sql		= "SELECT * FROM ".DB_PREFIX."page WHERE id=$id";
	$volpage	= $db->fetch_first($sql);
	if(!$volpage){
		msg::msge('数据不存在');
	}else{
		$temp  = "<select name='cid' id='cid'>";
		$temp .= "<option value=''>==请选择==</option>";
		$sql = "SELECT cid,cname FROM ".DB_PREFIX."pagecate WHERE flag=1 ORDER BY orders ASC";
		$result = $db->getall($sql);
		foreach ($result as $k => $val) {
			// $temp .= "<option value='".$val['cid']."'>".$val['cname']."</option>";
			$sql_chir = "SELECT * FROM ".DB_PREFIX."page WHERE cid=".$val['cid']." and flag=1 ORDER BY orders ASC";
			$rel_val  = $db->getall($sql_chir);
			$temp .= "<option value='".$val['cid']."'";
			if($volpage['depth'] == 1){
				if($volpage['cid'] == $val['cid']){
					$temp .= " selected";
				}
			}
			$temp .= ">".$val['cname']."</option>";
			$str   = "├&nbsp;";
			foreach ($rel_val as $key => $value) {
				if($value['depth'] == 1){
					// $temp .= "<option value='+".$value['id']."'>".$str.$value['title']."</option>";
					$temp .= "<option value='+".$value['id']."'";
					if($volpage['depth'] == 2){
						if($volpage['parentid'] == $value['id']){
							$temp .= " selected";
						}
					}
					$temp .= ">".$str.$value['title']."</option>";
				}
			}
		}
		$temp .= "</select>";
		$tpl->assign("flag_checkbox",Core_Mod::checkbox($volpage['flag'],"flag","审核"));
		$tpl->assign("cate_select",$temp);
		// $tpl->assign("cate_select",Core_Mod::db_select($volpage['cid'],"cid","pagecate"));
		$tpl->assign("id",$id);
		$tpl->assign("comeurl",$GLOBALS['comeurl']);
	    $tpl->assign("volpage",$volpage);
	}
}

function saveadd(){
	Core_Auth::checkauth("pageadd");
	global $db;
	$cid			= Core_Fun::rec_post('cid',1);
	$linktype		= Core_Fun::detect_number(Core_Fun::rec_post('linktype',1));
	$linkurl		= Core_Fun::strip_post('linkurl',1);
	$target			= Core_Fun::detect_number(Core_Fun::rec_post('target',1));
	$title			= Core_Fun::rec_post('title',1);
	$word			= Core_Fun::rec_post('word',1);
	$content		= Core_Fun::strip_post('content',1);
	$img		    = Core_Fun::rec_post('uploadfiles',1);
	$ptitle		    = Core_Fun::rec_post('ptitle',1);
	$pkeywords	    = Core_Fun::rec_post('pkeywords',1);
	$pdescription	= Core_Fun::rec_post('pdescription',1);
	$flag			= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$orders			= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$depth =1;
	$parentid =0;
	if(($pos = strpos($cid, "+")) !== false){
		$parentid = str_replace("+", "", $cid);
		$sql = "SELECT cid FROM ".DB_PREFIX."page where id=".$parentid;
		$rel = $db->fetch_first($sql);
		$cid = $rel['cid'];
		$depth =2;
	}
	$founderr		= false;
	if($cid<1){
	    $founderr	= true;
		$errmsg	   .="请选择所在分类 ";
	}
	if(!Core_Fun::ischar($word)){
		$founderr	= true;
		$errmsg	   .="自定义目录不能为空 ";
	}
	if(!Core_Fun::ischar($title)){
	    $founderr	= true;
		$errmsg	   .="单页名称不能为空";
	}
	if($founderr == true){
		msg::msge($errmsg);
	}
	$sql    = "SELECT `word` From ".DB_PREFIX."page Where `word`='".$word."' Limit 1";
	$reslut = $db->fetch_first($sql);
	if($reslut){
		msg::msge('您输入的自定义目录已经存在！');
	}
	
	$array	= array(
		'cid'=>$cid,
		'linktype'=>$linktype,
		'linkurl'=>$linkurl,
		'target'=>$target,
		'title'=>$title,
		'word'=>$word,
		'content'=>$content,
		'ptitle' => $ptitle,
		'pkeywords' => $pkeywords,
		'pdescription' => $pdescription,
		'flag'=>$flag,
		'orders'=>$orders,
		'parentid'=>$parentid,
		'depth'=>$depth,
		'timeline'=>time(),
		'img'=>$img,
	);
	$result = $db->insert(DB_PREFIX."page",$array);
	if($result){
		Core_Command::runlog("","添加单页成功[$title]",1);
		msg::msge('保存成功','xycms_page.php');
	}else{
		msg::msge('保存失败');
	}
}

function saveedit(){
	Core_Auth::checkauth("pageedit");
	global $db;
	$id				= Core_Fun::rec_post('id',1);
	$cid			= Core_Fun::rec_post('cid',1);
	$linktype		= Core_Fun::detect_number(Core_Fun::rec_post('linktype',1));
	$linkurl		= Core_Fun::strip_post('linkurl',1);
	$target			= Core_Fun::detect_number(Core_Fun::rec_post('target',1));
	$title			= Core_Fun::rec_post('title',1);
	$word			= Core_Fun::rec_post('word',1);
	$content		= Core_Fun::strip_post('content',1);
	$img		    = Core_Fun::rec_post('uploadfiles',1);
	$ptitle		    = Core_Fun::rec_post('ptitle',1);
	$pkeywords	    = Core_Fun::rec_post('pkeywords',1);
	$pdescription	= Core_Fun::rec_post('pdescription',1);
	$flag			= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$orders			= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$founderr	= false;
	$depth =1;
	$parentid =0;
	if(($pos = strpos($cid, "+")) !== false)
	{
		$parentid = str_replace("+", "", $cid);
		$sql = "SELECT cid FROM ".DB_PREFIX."page where id=".$parentid;
		$rel = $db->fetch_first($sql);
		$cid = $rel['cid'];
		$depth =2;
	}
	if(!Core_Fun::isnumber($id)){
	    $founderr	= true;
		$errmsg	   .= "ID丢失";
	}
	if(!Core_Fun::ischar($word)){
		$founderr	= true;
		$errmsg	   .="自定义目录不能为空";
	}
	if($cid<1){
	    $founderr	= true;
		$errmsg	   .="请选择所在分类.";
	}
	if(!Core_Fun::ischar($title)){
	    $founderr	= true;
		$errmsg	   .="单页名称不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$array = array(
		'cid'=>$cid,
		'linktype'=>$linktype,
		'linkurl'=>$linkurl,
		'target'=>$target,
		'title'=>$title,
		'word'=>$word,
		'content'=>$content,
		'ptitle' => $ptitle,
		'pkeywords' => $pkeywords,
		'pdescription' => $pdescription,
		'flag'=>$flag,
		'parentid'=>$parentid,
		'depth'=>$depth,
		'orders'=>$orders,
		'img'=>$img,
	);
	$result = $db->update(DB_PREFIX."page",$array,"id=$id");
	if($result){
		Core_Command::runlog("","编辑单页成功[id=$id]");
		msg::msge('编辑成功!','xycms_page.php?'.$GLOBALS['comeurl']);
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
			$db->query("DELETE FROM ".DB_PREFIX."page WHERE id=$id");
		}
	}
	Core_Command::runlog("","删除概况分类成功[id=$arrid]");
	msg::msge('删除成功','xycms_page.php');
}

function del(){
	Core_Auth::checkauth("pagedel");
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('请选择要删除的数据');
	}
	global $db;
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){
			$db->query("DELETE FROM ".DB_PREFIX."page WHERE id=$id");
		}
	}
	Core_Command::runlog("","删除单页成功[id=$arrid]");
	msg::msge('删除成功','xycms_page.php');
}

function updateajax($_id,$_action){
	Core_Auth::checkauth("pageedit");
    if(Core_Fun::isnumber($_id)){
		global $db;
		switch($_action){
			case 'flagopen':
				$db->query("UPDATE ".DB_PREFIX."page SET flag=1 WHERE id=$_id");
				break;
			case 'flagclose':
				$db->query("UPDATE ".DB_PREFIX."page SET flag=0 WHERE id=$_id");
				break;
			default:
				break;
		}
	}
}

$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."page.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>