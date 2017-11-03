<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
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
	case 'savepassword':
	    savepassword();
		break;
	default:
	    volist();
		break;
}

function volist(){
	Core_Auth::checkauth("adminvolist");
	global $db,$tpl,$page;
    $pagesize	= 30;
	$searchsql	= " WHERE 1=1";
	$countsql	= "SELECT COUNT(a.adminid) FROM ".DB_PREFIX."admin AS a".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT a.*,g.groupname AS groupname".
	             " FROM ".DB_PREFIX."admin AS a".
		         " LEFT JOIN ".DB_PREFIX."authgroup AS g ON a.groupid=g.groupid".
		         $searchsql." ORDER BY a.adminid ASC LIMIT $start, $pagesize";
	$admin		= $db->getall($sql);
	$url		= $_SERVER['PHP_SELF'];
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("admin",$admin);
}

function add(){
	Core_Auth::checkauth("adminadd");
	global $tpl;
	$tpl->assign("flag_checkbox",Core_Mod::checkbox("1","flag","审核"));
	$tpl->assign("super_checkbox",Core_Mod::checkbox("0","super","系统管理员"));
	$tpl->assign("groupid_select",Core_Mod::db_select("","groupid","authgroup"));
}

function edit(){
	Core_Auth::checkauth("adminedit");
	global $db,$tpl;
    $id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		Core_Fun::halt("ID丢失","",2);
	}
	$sql   = "SELECT * FROM ".DB_PREFIX."admin WHERE adminid=$id";
	$admin = $db->fetch_first($sql);
	if(!$admin){
		msg::msge('数据不存在!');
	}else{
		$tpl->assign("flag_checkbox",Core_Mod::checkbox($admin['flag'],"flag","审核"));
		$tpl->assign("super_checkbox",Core_Mod::checkbox($admin['super'],"super","系统管理员"));
		$tpl->assign("groupid_select",Core_Mod::db_select($admin['groupid'],"groupid","authgroup"));
		$tpl->assign("id",$id);
		$tpl->assign("comeurl",$GLOBALS['comeurl']);
	    $tpl->assign("admin",$admin);
	}
}

function saveadd(){
	Core_Auth::checkauth("adminadd");
	global $db;
	$adminname	= Core_Fun::rec_post('adminname',1);
	$password	= Core_Fun::rec_post('password',1);
	$groupid	= Core_Fun::detect_number(Core_Fun::rec_post('groupid',1));
	$flag		= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$super		= Core_Fun::detect_number(Core_Fun::rec_post('super',1));
	$memo		= Core_Fun::strip_post('memo',1);
	$founderr	= false;
	if(!Core_Fun::ischar($adminname)){
	    $founderr	= true;
		$errmsg	   .="登录帐号不能为空.";
	}else{
		if(!Core_Fun::check_userstr($adminname)){
			$founderr	= true;
			$errmsg	   .="帐号格式不正确，只能由中文，字母、数字和下横下组成.";
		}
	}
	if(!Core_Fun::ischar($password)){
		$founderr	= true;
		$errmsg	   .= "登录密码不能为空.";	
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	if(!($db->checkdata("SELECT adminid FROM ".DB_PREFIX."admin WHERE lower(adminname)='".strtolower($adminname)."'"))){
		$adminid	= $db->fetch_newid("SELECT MAX(adminid) FROM ".DB_PREFIX."admin",1);
		$password	= md5(KEY.md5($password.KEY));
		$array	= array(
			'adminid'=>$adminid,
			'adminname'=>$adminname,
			'password'=>$password,
			'groupid'=>$groupid,
			'super'=>$super,
			'timeline'=>time(),
			'flag'=>$flag,
			'memo'=>$memo,
	    );
		$result = $db->insert(DB_PREFIX."admin",$array);
		if($result){
			Core_Command::runlog("","添加管理员成功[$adminname]",1);
			msg::msge('保存成功!','xycms_admin.php');
		}else{
			Core_Fun::halt("保存失败","",1);
		}
	}else{
		msg::msge('该帐号已存在，请填写另外一个。');
	}
}

function saveedit(){
	Core_Auth::checkauth("adminedit");
	global $db;
	$id			= Core_Fun::rec_post('id',1);
	$password	= Core_Fun::rec_post('password',1);
	$groupid	= Core_Fun::detect_number(Core_Fun::rec_post('groupid',1));
	$flag		= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$super		= Core_Fun::detect_number(Core_Fun::rec_post('super',1));
	$memo		= Core_Fun::strip_post('memo',1);
	$founderr	= false;
	if(!Core_Fun::isnumber($id)){
	    $founderr	= true;
		$errmsg	   .= "ID丢失.";
	}
	if($founderr == true){
    	msg::msge('ID丢失!');
	}
	$array = array(
		'groupid'=>$groupid,
		'flag'=>$flag,
		'super'=>$super,
		'memo'=>$memo,
	);
	if($password != ''){
		$array = $array + array('password'=>md5(KEY.md5($password.KEY)));
	}
	$result = $db->update(DB_PREFIX."admin",$array,"adminid=$id");
	if($result){
		Core_Command::runlog("","编辑管理员帐号成功[id=$id]");
		msg::msge('编辑成功',"xycms_admin.php?".$GLOBALS['comeurl']);
	}else{
		msg::msge('编辑失败');
	}
}

function del(){
	Core_Auth::checkauth("admindel");
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('请选择要删除的数据!');
	}
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){
			$GLOBALS['db']->query("DELETE FROM ".DB_PREFIX."admin WHERE adminid=$id");
		}
	}
	Core_Command::runlog("","删除管理员成功[id=$arrid]");
	msg::msge('删除成功!','xycms_admin.php');
}

function updateajax($_id,$_action){
	Core_Auth::checkauth("adminedit");
    if(Core_Fun::isnumber($_id)){
		global $db;
		switch($_action){
			case 'flagopen':
				$db->query("UPDATE ".DB_PREFIX."admin SET flag=1 WHERE adminid=$_id");
				break;
			case 'flagclose':
				$db->query("UPDATE ".DB_PREFIX."admin SET flag=0 WHERE adminid=$_id");
				break;
			default:
				break;
		}
	}
}

function savepassword(){
	Core_Auth::checkauth("editpass");
	$oldpassword		= Core_Fun::rec_post('oldpassword',1);
	$newpassword		= Core_Fun::rec_post('newpassword',1);
	$confirmpassword	= Core_Fun::rec_post('confirmpassword',1);
	$founderr			= false;
	if(!Core_Fun::ischar($oldpassword)){
	    $founderr	= true;
		$errmsg	   .= "原密码不能为空.";
	}
	if(!Core_Fun::ischar($newpassword)){
	    $founderr	= true;
		$errmsg    .= "新密码不能为空.";
	}else{
		if(strlen($newpassword)<4 || strlen($newpassword)>16){
			$founderr	= true;
			$errmsg	   .= "密码长度不正确.";
		}
	}
	if($confirmpassword!=$newpassword){
	    $founderr	= true;
		$errmsg    .= "确认密码不正确.";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	if(md5(KEY.md5($oldpassword.KEY))!= $GLOBALS['libadmin']->uc_password){
		msg::msge('原始密码不正确');
	}
	$array = array(
	    'password'=>md5(KEY.md5($newpassword.KEY)),
	);
	$result = $GLOBALS['db']->update(DB_PREFIX."admin",$array,"lower(adminname)='".strtolower($GLOBALS['libadmin']->uc_adminname."'"));
	if($result){
		Core_Fun::set_cookie(PHPOE_COOKIENAME."_ADMINPASSWORD",md5(KEY.md5($newpassword.KEY)),10);
		Core_Command::runlog("","修改登录密码成功");
		msg::msge('密码修改成功，请记住新密码。',"xycms_admin.php?action=changepassword");
	}else{
		msg::msge('密码修改失败');
	}
}
$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."admin.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>