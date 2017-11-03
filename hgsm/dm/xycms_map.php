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

/**
 * 将数组转换为json字符串
 */
function array2json($data) 
{
	transcode($data);
	if($data == '' || !is_array($data)) return '';	
	return urldecode(json_encode($data));
}

/**
 * 将json字符串转换为数组
 */
function json2array($data) 
{
	if($data == '' || !is_string($data)) return array();
	$data = str_replace("\\", '\\\\', $data);
	$data = str_replace("\r\n", '\n', $data);
	$data = str_replace("\n", '\n', $data);
	$data = json_decode($data, true);
	return $data;
}


/**
 * 中文编码,防止中文json后被过滤
 * str 字符串或者数组
 */
function transcode(&$str) {
	if(!empty($str)){
		if(is_array($str)){
			foreach ($str as $key => $val) {
				transcode($str[$key]);
			}
		}else{
			$str = urlencode($str);
		}
	}
}

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
	$countsql	= "SELECT COUNT(p.id) FROM ".DB_PREFIX."map AS p".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$sql		= "SELECT p.*,c.cname,c.catdir".
		          " FROM ".DB_PREFIX."map AS p".
		          " LEFT JOIN ".DB_PREFIX."mapcate AS c ON p.cid=c.cid".
		          $searchsql." ORDER BY p.orders ASC";
	$volpage	= $db->getall($sql);
	foreach ($volpage as $kes => &$value) {
		$value['center'] = json2array($value['center']);
		$value['center_text'] = 'X：'.$value['center']['x'].'， Y：'.$value['center']['y'].'， 地图等级：'.$value['center']['zoom'];
	}
	// print_r($volpage);exit;
	require CHENCY_ROOT.'source/module/mod.map.php';
	$page_category = Mod_Page::category('',"ORDER BY `orders` ASC");

	$data = array();
	if(!empty($volpage)){
		foreach($page_category aS $key=>$val){
			$f = 0;
			foreach ($volpage as $k=>$v){
				if($v['cid'] == $val['cid']){
					$data[$val['cid']][] = $v;
					$f = 1;
				}
				$data[$val['cid']] = $f ? $data[$val['cid']] : array();
			}
		}
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
	$id = Core_Fun::rec_post('id');
	if(Core_Fun::isnumber($id)){
		$sql		= "SELECT * FROM ".DB_PREFIX."map WHERE id=$id";
	    $volmap	= $db->fetch_first($sql);
	    // print_r($volpage);die();
		if(!$volmap){
			msg::msge('数据不存在');
		}else{
			$center_arr = json2array($volmap['center']);
			foreach ($center_arr as $key => $value) {
				$center_arr['container'] = "map";
			}
			$centerjosn = array2json($center_arr);
			$center = json2array($volmap['center']);
			$mark = json2array($volmap['mark']);
			$mark_coord = $mark['mark-coord'];
			$mark_coordarr = explode('|', $mark_coord);
			$mark['x'] = $mark_coordarr[0];
			$mark['y'] = $mark_coordarr[1];
			$allmarker = array2json($mark);
			// exit($centerjosn);
			$tpl->assign("cate_select",Core_Mod::db_select($volmap['cid'],"cid","mapcate"));
			$tpl->assign("id",$id);
			$tpl->assign("orders",$volmap['orders']);
			$tpl->assign("center",$center);
			$tpl->assign("mark",$mark);
			$tpl->assign("centerjosn",$centerjosn);
			$tpl->assign("allmarker",$allmarker);
		    $tpl->assign("map",$volmap);
		}
	}else{
		    $id = '';
		    $orders = $db->fetch_newid("SELECT MAX(orders) FROM ".DB_PREFIX."map",1);
			$tpl->assign("flag_checkbox",Core_Mod::checkbox("1","flag","审核"));
			$tpl->assign("cate_select",Core_Mod::db_select("","cid","mapcate"));
			$tpl->assign("id",$id);
			$tpl->assign("orders",$orders);
	}
	
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
		$tpl->assign("flag_checkbox",Core_Mod::checkbox($volpage['flag'],"flag","审核"));
		$tpl->assign("cate_select",Core_Mod::db_select($volpage['cid'],"cid","pagecate"));
		$tpl->assign("id",$id);
		$tpl->assign("comeurl",$GLOBALS['comeurl']);
	    $tpl->assign("volpage",$volpage);
	}
}

function saveadd(){
	Core_Auth::checkauth("pageadd");
	global $db;
	$cid			= Core_Fun::detect_number(Core_Fun::rec_post('cid',1));
	$orders		    = Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$name			= Core_Fun::rec_post('name',1);
	$word			= Core_Fun::rec_post('word',1);
	$mark           = $_POST['mark'];
	foreach ($mark as $key => &$value) {	
		$value = str_replace(" ", "", $value);
		$value = str_replace("\n", "<br/>", $value);
		$value = str_replace("\r", "", $value);
		// $value = Core_Fun::replacebadchar(preg_replace("'([rn])[s]+'", "", $value));
	}
	// var_dump($mark);exit;
	$mark		    = array2json($mark);
	$center		    = array2json($_POST['center']);	
	$flag = 1;
	// exit($mark);
	$founderr		= false;
	if($cid<1){
	    $founderr	= true;
		$errmsg	   .="请选择所在分类 ";
	}
	if(!Core_Fun::ischar($word)){
		$founderr	= true;
		$errmsg	   .="自定义目录不能为空 ";
	}
	if(!Core_Fun::ischar($name)){
	    $founderr	= true;
		$errmsg	   .="地图名称不能为空";
	}
	if($founderr == true){
		msg::msge($errmsg);
	}
	$array	= array(
		'cid'=>$cid,
		'center'=>$center,
		'name'=>$name,
		'word'=>$word,
		'mark'=>$mark,
		'flag'=>$flag,
		'orders'=>$orders,
		'timeline'=>time(),
	);
	$sql    = "SELECT `word` From ".DB_PREFIX."map Where `word`='".$word."' Limit 1";
	$reslut = $db->fetch_first($sql);
	if($reslut){
		$result = $db->update(DB_PREFIX."map",$array,"word='{$word}'");
		if($result){
			Core_Command::runlog("","编辑单页成功[word='$word]'");
			msg::msge('编辑成功!','xycms_map.php');
		}else{
			msg::msge('编辑失败!');
		}
	}else{
		$result = $db->insert(DB_PREFIX."map",$array);
		if($result){
			Core_Command::runlog("","添加单页成功[$name]",1);
			msg::msge('保存成功','xycms_map.php');
		}else{
			msg::msge('保存失败');
		}
	}
	


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
			$db->query("DELETE FROM ".DB_PREFIX."map WHERE id=$id");
		}
	}
	Core_Command::runlog("","删除单页成功[id=$arrid]");
	msg::msge('删除成功','xycms_map.php');
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
$tpl->display(ADMIN_TEMPLATE."map.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>