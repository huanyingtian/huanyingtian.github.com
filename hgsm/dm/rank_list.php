<?php
//关键词默认显示
header("Content-type:text/html;charset=utf-8");
require_once '../source/core/run.php';
$sql = "select tag from ".DB_PREFIX."tag ORDER BY `tagid` DESC";
$arr = $db->getall($sql);
$keywords = '';
$fileName  = 'rank.html';
foreach($arr as $data){
	$keywords .= $data['tag'].',';
}
if(file_exists($fileName)){
	$lastChangeTime = date("Y-m-d H:i:s",filemtime($fileName));
}
$keywords = rtrim($keywords,',');
$tpl->assign("keywords",$keywords);
$tpl->assign("count",count($arr));
$tpl->assign("lastChangeTime",$lastChangeTime);
$tpl->assign("url",$config["siteurl"]);
$tpl->display(ADMIN_TEMPLATE."rank.tpl");
?>