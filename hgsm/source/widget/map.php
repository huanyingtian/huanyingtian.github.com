<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.01
 * @Id         在线留言
**/
if(!defined('ALLOWGUEST')) {
	exit('Access Denied');
}
$action = Core_Fun::rec_post("action");
switch ($action) {
	case 'edital':
		edital();
		break;	
	default:
		volist();
		break;
}
$manu = $_GET['manus'];
if($manu){
	$sql      = "SELECT * FROM ".DB_PREFIX."mapcate WHERE cname='$manu' LIMIT 1";
	$valarry  = $db->fetch_first($sql);
	$cid      = $valarry['cid'];
	$val_sql  = "SELECT * FROM ".DB_PREFIX."map WHERE cid=$cid order by orders ASC";
	$value_db = $db->getall($val_sql);
	$select   = array();
	foreach ($value_db as $key => $value) {
		$select[]=array("mo_id"=>$value['id'],"mo_name"=>urlencode($value['name']));
	}
    echo urldecode(json_encode($select)); 
    exit;
}

$sqls = "SELECT * FROM ".DB_PREFIX."mapcate where flag=1 ORDER BY orders ASC";
$seachpro = $db->getall($sqls);


function volist(){
	global $db,$tpl;
	$sql = "SELECT v.*,c.cname,c.catdir FROM ".DB_PREFIX."map AS v"." LEFT JOIN ".DB_PREFIX."mapcate AS c ON v.cid=c.cid  ORDER BY v.orders ASC";
	$result = $db->getall($sql);
	$text = array();
	$maparry = array();
	foreach ($result as $key => &$value) {
		$text[$key]['center'] = json2array($value['center']);
		$text[$key]['mark']   = json2array($value['mark']);
		$value['mark'] = json2array($value['mark']);
		$xyarr = explode('|', $value['mark']['mark-coord']);
		$value['mark']['x'] = $xyarr[0];
		$value['mark']['y'] = $xyarr[1];
		$maparry[$key] = $value['mark'];
	}
	$mapjosn = array2json($maparry);

	$tpl->assign('text',$text);
	$tpl->assign('mapjosn',$mapjosn);
}

function edital(){
	global $db,$tpl,$sdsdffd;
	$cname      = Core_Fun::rec_post("manu",2);
	$id         = Core_Fun::rec_post("model",2);
	$founderr = false;
	$errmsg   = '';
	if(!Core_Fun::ischar($cname)){
		$founderr = true;
		$errmsg  .= "省/直辖市不能为空！";
	}
	if($founderr==true){
		msg::msge($errmsg);
	}
	$sql      = "SELECT * FROM ".DB_PREFIX."mapcate WHERE cname='$cname' LIMIT 1";
	$valarry  = $db->fetch_first($sql);
	$cid      = $valarry['cid'];
	$val_sql  = "SELECT * FROM ".DB_PREFIX."map WHERE cid=$cid order by orders ASC";
	$value_db = $db->getall($val_sql);
	$select   = array();
	foreach ($value_db as $key => $value) {
		$select[] = array("id"=>$value['id'],"name"=>$value['name']);
	}
	$text = array();
	if(!empty($id)){
		$sql = "SELECT * FROM ".DB_PREFIX."map where flag=1 and id={$id} ORDER BY orders ASC";
		$result = $db->fetch_first($sql);
		$mark = json2array($result['mark']);
		$mark_xy = explode('|', $mark['mark-coord']);
		$mark['x'] = $mark_xy[0];
		$mark['y'] = $mark_xy[1];
		$mark_new[0] = $mark;
		$data_info = array2json($mark_new);
		$text = $mark_new;
		$tpl->assign('data_info',$data_info);
		$tpl->assign('text',$text);
		$tpl->assign('center',$result['center']);
	}else{
		$sql = "SELECT * FROM ".DB_PREFIX."mapcate where flag=1 and cname='{$cname}'";
		$rel = $db->fetch_first($sql);
		$cid = $rel['cid'];
		$sql_ct = "SELECT * FROM ".DB_PREFIX."map where flag=1 and cid={$cid} ORDER BY orders ASC";
		$result = $db->getall($sql_ct);
		$text   = array();
		$maparry = array();
		foreach ($result as $key => &$value) {
			$text[$key]    = json2array($value['mark']);
			$value['mark'] = json2array($value['mark']);
			$xyarr = explode('|', $value['mark']['mark-coord']);
			$value['mark']['x'] = $xyarr[0];
			$value['mark']['y'] = $xyarr[1];
			$maparry[$key] = $value['mark'];
		}
		$data_info = array2json($maparry);
		$center = array("x"=>"116.404","y"=>"39.915","zoom"=>"5");
		$center = array2json($center);
		$tpl->assign('center',$center);
		$tpl->assign('text',$text);
		$tpl->assign('data_info',$data_info);
	}
	$tpl->assign('id',$id);
	$tpl->assign('cname',$cname);
	$tpl->assign('select',$select);
}


$tpl->assign('action',$action);
$tpl->assign('seachpro',$seachpro);

?>