<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XiangYun v1.0
 * @Update     2012.07.07
**/
require '../source/core/rss.class.php';
require '../source/core/run.php';
require 'admin.inc.php';
$summary = item();
$product = volist("product");
$info = volist("info");
$rss = new rss($summary,$product,$info);
$rss->Display();
function volist($table){
	global $config,$db;
    $sql = "select v.*,c.cname from ".DB_PREFIX.$table." as v left join ".DB_PREFIX.$table."cate as c on v.cid=c.cid order by v.id desc";
    $content = $db->getall($sql);
    foreach($content as $key=>$value){
     //产品
    if($table =="product"){
    $content[$key]['name'] = $value['title'];
	$content[$key]['url'] = PATH_URL."product/".$value['id'].".html";
    }
    //新闻
    else{
    	$content[$key]['name'] = $value['title'];
		$content[$key]['url'] = PATH_URL."news/".$value['id'].".html";
    }
   }
  return $content;
}
function item(){
    global $config;
    $s = array();
    $s['title']       = $config['sitename'];
    $s['link']        = "http://".$config['siteurl'];
    $s['description'] = $config['metadescription'];
    return $s;
}

?>