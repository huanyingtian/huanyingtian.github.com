<?php
//信息的异步获取
$type = ''; //信息的类型
$id = '';	//信息的ID
$type = isset($_GET['type']) ? $_GET['type'] : '';
if(empty($type)){
	exit('');
}
$id = isset($_GET['id']) ? intval($_GET['id']) : '';
require '../../source/core/run.php';
require '../config/config.php';
require M_ROOT.'library/ajaxInfo.class.php';
$ajavLoad = new ajaxInfo();
echo json_encode($ajavLoad->$type());
