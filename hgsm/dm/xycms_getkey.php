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

switch($action){
    case 'show':
	    show();
		break;
	case 'configure':
	    configure();
		break;
	case 'saveconfig':
	    saveconfig();
		break;
	case 'lists':
	    lists();
		break;
	case 'add':
	    add();
		break;
	case 'saveadd':
	    saveadd();
		break;
	case 'del':
	    del();
		break;
	case 'edit':
	    edit();
		break;
	case 'saveedit':
	    saveedit();
		break;
	default:
	    volist();
		break;
}

function configure(){
	global $tpl,$config;
	$tpl->assign('w_automatic',$config['w_automatic']);
	$tpl->assign('w_manual',$config['w_manual']);
}

function saveconfig(){
	global $db;
	$w_automatic	= Core_Fun::detect_number(Core_Fun::rec_post("w_automatic",1));
	$array = array(
		'w_automatic'=>$w_automatic,
		);
	$result = $db->update(DB_PREFIX."config",$array,"");
	if(!$result){
		msg::msge('更新失败');
	}else{
		Core_Command::runlog("","更新关键词库配置成功");
		msg::msge('更新成功');
	}
}

function lists(){
	global $tpl,$db;
	$sql   = "SELECT * FROM ".DB_PREFIX."keywords where flag=1 ORDER BY id desc";
	$lists = $db->getall($sql);
	foreach ($lists as $key => &$value) {
		$value['url'] = PATH_URL.'getkey/'.$value['word'].'/';
	}
	$total = count($lists);
	$tpl->assign('lists',$lists);
	$tpl->assign('total',$total);
}

function add(){
	global $tpl,$db;
}

function saveadd(){
	global $db;
	$wname        = Core_Fun::rec_post('wname',1);
	$word         = Core_Fun::rec_post('word',1);
	$thumbfiles   = Core_Fun::rec_post('thumbfiles',1);
	$uploadfiles  = Core_Fun::rec_post('uploadfiles',1);
	$flag	      = Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$tag	      = Core_Fun::rec_post('tag',1);
	$content      = Core_Fun::strip_post('content',1);
	$wtitle		  = Core_Fun::rec_post('wtitle',1);
	$wkeywords	  = Core_Fun::rec_post('wkeywords',1);
	$wdescription = Core_Fun::rec_post('wdescription',1);
	$wname    = str_replace(' ', '', $wname);
	$founderr = false;
	if(!Core_Fun::ischar($wname)){
	    $founderr	= true;
		$errmsg	   .="关键词名称不能为空！";
	}
	if(!Core_Fun::ischar($word)){
	    $founderr	= true;
		$errmsg	   .="自定义目录不能为空！";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$array = array(
		'wname'=>$wname,
		'word'=>$word,
		'thumbfiles'=>$thumbfiles,
		'uploadfiles'=>$uploadfiles,
		'flag'=>$flag,
		'tag'=>$tag,
		'content'=>$content,
		'wtitle'=>$wtitle,
		'wkeywords'=>$wkeywords,
		'wdescription'=>$wdescription,
		'timeline'=>time(),
		);
	$result = $db->insert(DB_PREFIX."keywords",$array);
	if($result){
		Core_Command::runlog("","发布关键词成功[$wname]",1);
		msg::msge('保存成功',"xycms_getkey.php?action=lists");
	}else{
		msg::msge('保存失败');
	}
}

function saveedit(){
	global $db;
	$wname        = Core_Fun::rec_post('wname',1);
	$id 	      = Core_Fun::detect_number(Core_Fun::rec_post('id',1));
	$word         = Core_Fun::rec_post('word',1);
	$thumbfiles   = Core_Fun::rec_post('thumbfiles',1);
	$uploadfiles  = Core_Fun::rec_post('uploadfiles',1);
	$flag	      = Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$tag	      = Core_Fun::rec_post('tag',1);
	$content      = Core_Fun::strip_post('content',1);
	$wtitle		  = Core_Fun::rec_post('wtitle',1);
	$wkeywords	  = Core_Fun::rec_post('wkeywords',1);
	$wdescription = Core_Fun::rec_post('wdescription',1);
	$wname        = str_replace(' ', '', $wname);
	$founderr     = false;
	if(!Core_Fun::ischar($wname)){
	    $founderr	= true;
		$errmsg	   .="关键词名称不能为空！";
	}
	if(!Core_Fun::ischar($word)){
	    $founderr	= true;
		$errmsg	   .="自定义目录不能为空！";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	$array = array(
		'wname'=>$wname,
		'word'=>$word,
		'thumbfiles'=>$thumbfiles,
		'uploadfiles'=>$uploadfiles,
		'flag'=>$flag,
		'tag'=>$tag,
		'content'=>$content,
		'wtitle'=>$wtitle,
		'wkeywords'=>$wkeywords,
		'wdescription'=>$wdescription,
	);
	$result = $db->update(DB_PREFIX."keywords",$array,"id=$id");
	if($result){
		Core_Command::runlog("","修改关键词成功[$wname]",1);
		msg::msge('保存成功',"xycms_getkey.php?action=lists");
	}else{
		msg::msge('保存失败');
	}
}


function edit(){
	global $tpl,$db;
	$id  = Core_Fun::rec_post('id');
	$rel = $db->fetch_first("SELECT * FROM ".DB_PREFIX."keywords where id={$id}");
	$tpl->assign('id',$id);
	$tpl->assign('keywords',$rel);
}

function del(){
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('请选择要删除的数据');
	}
	global $db;
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){
			$db->query("DELETE FROM ".DB_PREFIX."keywords WHERE id=$id");
		}
	}
	Core_Command::runlog("","删除关键词成功[id=$arrid]");
	msg::msge('删除成功','xycms_getkey.php?action=lists');
}

function show(){
	Core_Auth::checkauth("linkedit");
	global $tpl;
	require 'get_keycont.php';
	$pagesize   = 30;
	$keyarry    = explode(',', $str);
	$total      = count($keyarry);
	$tpl->assign("total",$total);
	$tpl->assign("keyarry",$keyarry);
}
$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."getkey.tpl");
?>