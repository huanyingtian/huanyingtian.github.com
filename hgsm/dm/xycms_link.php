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
	case 'config':
	    config();
		break;
	case 'del_cache':
		del_cache();
		break;
	case 'del':
	    del();
		break;
	default:
	    volist();
		break;
}

function volist(){
	Core_Auth::checkauth("linkvolist");
	global $db,$tpl,$page;
    $pagesize	= 30;
	$searchsql	= " WHERE 1=1";
	$countsql	= "SELECT COUNT(linkid) FROM ".DB_PREFIX."link".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT * FROM ".DB_PREFIX."link".
		          $searchsql." ORDER BY linktype ASC,orders ASC LIMIT $start, $pagesize";
	$link		= $db->getall($sql);
	$url		= $_SERVER['PHP_SELF'];
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("link",$link);
}

function add(){
	Core_Auth::checkauth("linkadd");
	global $tpl,$db;
	$orders = $db->fetch_newid("SELECT MAX(orders) FROM ".DB_PREFIX."link",1);
	$tpl->assign("flag_checkbox",Core_Mod::checkbox("1","flag","审核"));
	$tpl->assign("orders",$orders);
}

function edit(){
	Core_Auth::checkauth("linkedit");
	global $db,$tpl;
    $id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		msg::msge('ID丢失');
	}
	$sql	= "SELECT * FROM ".DB_PREFIX."link WHERE linkid=$id";
	$link	= $db->fetch_first($sql);
	if(!$link){
		msg::msge('数据不存在');
	}else{
		$link['logopicname'] = Core_Mod::getpicname($link['logoimg']);
		$tpl->assign("flag_checkbox",Core_Mod::checkbox($link['flag'],"flag","审核"));
		$tpl->assign("id",$id);
		$tpl->assign("comeurl",$GLOBALS['comeurl']);
	    $tpl->assign("link",$link);
	}
}

function saveadd(){
	Core_Auth::checkauth("linkadd");
	global $db;
	$linktitle	= Core_Fun::rec_post('linktitle',1);
	$fontcolor	= Core_Fun::strip_post('fontcolor',1);
	$linkurl	= Core_Fun::strip_post('linkurl',1);
	$linktype	= Core_Fun::detect_number(Core_Fun::rec_post('linktype',1),1);
	$logoimg	= Core_Fun::strip_post('uploadfiles',1);
	$flag		= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$nofollow	= Core_Fun::detect_number(Core_Fun::rec_post('nofollow',1));
	$orders		= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$intro		= Core_Fun::rec_post('intro',1);
	$founderr	= false;
	if(!Core_Fun::ischar($linktitle)){
	    $founderr	= true;
		$errmsg	   .="网站名称不能为空.";
	}
	if(!Core_Fun::ischar($linkurl)){
	    $founderr	= true;
		$errmsg	   .="网站URL链接不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$array	= array(
		'linktitle'=>$linktitle,
		'fontcolor'=>$fontcolor,
		'linkurl'=>$linkurl,
		'linktype'=>$linktype,
		'logoimg'=>$logoimg,
		'flag'=>$flag,
		'nofollow'=>$nofollow,
		'intro'=>$intro,
		'orders'=>$orders,
		'timeline'=>time(),
	);
	$result = $db->insert(DB_PREFIX.'link',$array);
	if($result){
		Core_Command::runlog("","添加友情链接成功[$linktitle]",1);
		msg::msge('保存成功','xycms_link.php');
	}else{
		msg::msge('保存失败');
	}
}

function saveedit(){
	Core_Auth::checkauth("linkedit");
	global $db;
	$id			= Core_Fun::rec_post('id',1);
	$linktitle	= Core_Fun::rec_post('linktitle',1);
	$fontcolor	= Core_Fun::strip_post('fontcolor',1);
	$linkurl	= Core_Fun::strip_post('linkurl',1);
	$linktype	= Core_Fun::detect_number(Core_Fun::rec_post('linktype',1),1);
	$logoimg	= Core_Fun::strip_post('uploadfiles',1);
	$flag		= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$nofollow	= Core_Fun::detect_number(Core_Fun::rec_post('nofollow',1));
	$orders		= Core_Fun::detect_number(Core_Fun::rec_post('orders',1));
	$intro		= Core_Fun::rec_post('intro',1);
	$founderr	= false;
	if(!Core_Fun::isnumber($id)){
	    $founderr	= true;
		$errmsg	   .= "ID丢失.";
	}
	if(!Core_Fun::ischar($linktitle)){
	    $founderr	= true;
		$errmsg	   .="网站名称不能为空.";
	}
	if(!Core_Fun::ischar($linkurl)){
	    $founderr	= true;
		$errmsg	   .="网站URL链接不能为空.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$array = array(
		'linktitle'=>$linktitle,
		'fontcolor'=>$fontcolor,
		'linkurl'=>$linkurl,
		'linktype'=>$linktype,
		'logoimg'=>$logoimg,
		'flag'=>$flag,
		'nofollow'=>$nofollow,
		'intro'=>$intro,
		'orders'=>$orders,
	);
	$result = $db->update(DB_PREFIX."link",$array,"linkid=$id");
	if($result){
		Core_Command::runlog("","编辑友情链接成功[id=$id]");
		msg::msge('编辑成功',"xycms_link.php?".$GLOBALS['comeurl']);
	}else{
		msg::msge('编辑失败');
	}
}

function del(){
	Core_Auth::checkauth("linkdel");
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('请选择要删除的数据');
	}
	global $db;
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){

			$sql	= "SELECT logoimg FROM ".DB_PREFIX."link WHERE linkid=$id";
			$rows	= $GLOBALS['db']->fetch_first($sql);
			if($rows){
				if(Core_Fun::ischar($rows['logoimg'])){
					Core_Fun::deletefile("../".$rows['logoimg']);
				}
				$GLOBALS['db']->query("DELETE FROM ".DB_PREFIX."link WHERE linkid=$id");
			}
		}
	}
	Core_Command::runlog("","删除友情链接成功[id=$arrid]");
	msg::msge('删除成功','xycms_link.php');
}

//友情链接库参数配置
function config(){
	global $db,$tpl;
	$config_file = '../source/conf/api.inc.php';
	$cfg = require $config_file;
	if(isset($_POST['dosubmit'])){
		$api_url = Core_Fun::replacebadchar($_POST['api_url']);
		$token   = trim($_POST['token']);
		$closeLink = isset($_POST['closeLink']) && $_POST['closeLink'] == 1 ? 1 : 0;
		if(empty($api_url)){
			$api_url = $cfg['api_url'];
		}
		if(empty($token)){
			$token = $cfg['token'];
		}
		if(!preg_match( "/^[A-Z]{8}[0-9]{24}$/ ",$token)){
			msg::msge('令牌格式错误');
		}
		$cfg['api_url']   =  $api_url;
		$cfg['token']     = $token;
		$cfg['closeLink'] = $closeLink;
		$str = "<?php\nreturn ".var_export($cfg, true).';';
		if(file_put_contents($config_file, $str)){
			msg::msge('保存成功');
		}
	}else{
		$tpl->assign('api',$cfg);
	}
}

//删除友情链接库缓存
function del_cache(){
	$api = load::load_class('api','source/model');
	$api->delLinkCache();
}

function updateajax($_id,$_action){
	Core_Auth::checkauth("linkedit");
    if(Core_Fun::isnumber($_id)){
		global $db;
		switch($_action){
			case 'flagopen':
				$db->query("UPDATE ".DB_PREFIX."link SET flag=1 WHERE linkid=$_id");
				break;
			case 'flagclose':
				$db->query("UPDATE ".DB_PREFIX."link SET flag=0 WHERE linkid=$_id");
				break;
			default:
				break;
		}
	}
}

$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."link.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>