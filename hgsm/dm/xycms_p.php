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
$pstyle = require_once '../source/conf/arrays.php';
$action		= Core_Fun::rec_post("action");

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
	global $db,$tpl,$pstyle;
	$sql  = "SELECT * FROM ".DB_PREFIX."p ORDER BY cid ASC";
    $result = $db->getall($sql);
    foreach ($result as $key => $value) {
       $result[$key]['url'] = PATH_URL.'p/'.$value['cid'].'.html';
       $result[$key]['pstyle'] = $value['types'].'.tpl';
    } 
    $tpl->assign("cont_p",$result);
}


function add(){
   global $tpl,$pstyle;
   $tpl->assign("pstyle",$pstyle[1]);
}

function edit(){
	global $db,$tpl,$pstyle;
    $id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		msg::msge('ID丢失');
	}

	$sql	= "SELECT * FROM ".DB_PREFIX."p WHERE cid=$id";
	$cate	= $db->fetch_first($sql);
	if(!$cate){
		msg::msge('数据不存在');
	}else{
		$tpl->assign("id",$id);
	    $tpl->assign("cate",$cate);
	}
}

function saveadd(){
	global $db;
	$cname			    = Core_Fun::rec_post('cname',1);
	$types              = Core_Fun::rec_post('types');
	$content		    = Core_Fun::strip_post('content',1);
	$title			    = Core_Fun::rec_post('title',1);
	$keywords			= Core_Fun::rec_post('keywords',1);
	$description		= Core_Fun::rec_post('description',1);
	$img				= Core_Fun::rec_post('uploadfiles',1);
	$cid	            = $db->fetch_newid("SELECT MAX(cid) FROM ".DB_PREFIX."p",1);
	$founderr			= false;
	if(!Core_Fun::ischar($cname))
	{
	    $founderr	= true;
		$errmsg	   .="分类名称不能为空.";
	}

	if(!Core_Fun::dir_word($cid))
	{
		$founderr	= true;
		$errmsg	   .="自定义目录已经存在.";
	}

	if($founderr == true)
	{
	    msg::msge($errmsg);
	}

	$file_url = CHENCY_ROOT.'template/default/p/'.$cid.'.tpl';
    $file = fopen($file_url, "w+") or die('[$cname]无法创建');

    $filedemo = CHENCY_ROOT.'template/default/tpl/'.$types.'.tpl';
    $text = file_get_contents($filedemo);
    fwrite($file,$text);
    fclose($file);

	$array	= array(
		'cid'=>$cid,
		'types'=>$types,
		'cname'=>$cname,
		'content'=>$content,
		'title'=>$title,
		'keywords'=>$keywords,
		'description'=>$description,
		'img'=>$img,
	);

	$result = $db->insert(DB_PREFIX."p",$array);
	if($result){
		Core_Command::runlog("","添加单页成功[$cname]",1);
		msg::msge('保存成功',"xycms_p.php");
	}else{
		msg::msge('保存失败');
	}
}

function saveedit(){
	global $db;
	$id					= Core_Fun::rec_post('id',1);
	$cname			    = Core_Fun::rec_post('cname',1);
	$content			= Core_Fun::strip_post('content',1);
	$title			    = Core_Fun::rec_post('title',1);
	$keywords			= Core_Fun::rec_post('keywords',1);
	$description		= Core_Fun::rec_post('description',1);
	$img				= Core_Fun::rec_post('uploadfiles',1);
	$founderr        = false;

	if(!Core_Fun::isnumber($id)){
	    $founderr   = true;
		$errmsg    .= "ID丢失.";
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
		'content'=>$content,
        'title'=>$title,
		'keywords'=>$keywords,
		'description'=>$description,
		'img'=>$img,
	);
	$result = $db->update(DB_PREFIX."p",$array,"cid=$id");
	if($result){
		Core_Command::runlog("","修改单页成功[$cname]",1);
		msg::msge('编辑成功','xycms_p.php');

	}else{
		msg::msge('编辑失败');
	}
}

function del(){
	$id	= Core_Fun::rec_post('id');

	if(!Core_Fun::isnumber($id)){
		msg::msge('请选择要删除的数据');
	}else{
		$file = CHENCY_ROOT.'template/default/p/'.$id.'.tpl';
        $result = @unlink($file); 
		$GLOBALS['db']->query("DELETE FROM ".DB_PREFIX."p WHERE cid=$id");
	    Core_Command::runlog("","删除页面成功[id=$id]",1);
		msg::msge('删除成功','xycms_p.php');
	}
}


$tpl->assign("rand",time().rand(10,1000));
$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."p.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
