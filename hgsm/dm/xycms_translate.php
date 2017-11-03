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

switch($action)
{
	case 'saveedit':
	    saveedit();
		break;
	default:
	    volist();
		break;
}

function volist(){
	Core_Auth::checkauth("translate");
	global $db,$tpl;
	$translate  = require CHENCY_ROOT.'./source/conf/translate.php';
	$tran_arr   = array();
	$i = 0;
	foreach ($translate as $key => $val) {
		$tran_arr[$i]['en'] = $key;
		$tran_arr[$i]['cn'] = $val;
		$i++;
	}
	$sql	 = "SELECT * FROM ".DB_PREFIX."translate ";
    $rels	 = $db->fetch_first($sql);
    $namearr = json2array($rels['name']);
    if($rels){
    	foreach ($tran_arr as $key => $val) {
    		foreach ($namearr as $kes => $value) {
    			if($tran_arr[$key]['en'] == $value){
    				$tran_arr[$key]['check'] = 1;
    			}
    		}
    	}
    }
    // print_r($tran_arr);exit;
	$tpl->assign("tran_arr",$tran_arr);
}

function saveedit(){
	Core_Auth::checkauth("productedit");
	global $db;
	$name	= $_POST['name'];
	$name   = array2json($name);
	$array = array(
		'name'=>$name,
		'flag'=>1,
	);
	// print_r($array);exit;
	$result = $db->update(DB_PREFIX."translate",$array,"");
	if($result){
		Core_Command::runlog("","编辑语言成功[id=$id]");
		msg::msge("编辑成功","xycms_translate.php");
	}else{
		msg::msge('编辑失败');
	}
}

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


$tpl->assign("action",$action);
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
$tpl->display(ADMIN_TEMPLATE."translate.tpl");

?>