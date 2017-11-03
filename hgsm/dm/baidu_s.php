<?php
require_once '../source/core/keyword.php';
require_once '../source/core/run.php';
require_once 'admin.inc.php';
global $config;
$url = $config['siteurl'];
$seo     = seo();
$product = product();
$k       = array_merge($seo,$product);
$keyword = new keyword($k,$url);
$result  = $keyword->display();


function seo(){
	global $config;
	$metakeyword = explode(',',$config['metakeyword']);
	return $metakeyword;
}
function product(){
    global $db;
    $sql   = "select catename from ".DB_PREFIX."productcate where flag = 1 order by parentid";
    $rows1 = $db->getall($sql);
    $product = array();
    foreach($rows1 as $data){
      $product[] = $data['catename'];
    }
    $sql2  = "select productname from ".DB_PREFIX."product where flag = 1";
    $rows2 = $db->getall($sql2);
    foreach($rows2 as $data){
      $product[] = $data['productname'];
    }
    return $product;
}

$tpl->assign("baidu",$result);
$tpl->display(ADMIN_TEMPLATE."baidu_s.tpl");
?>
