<?php
/**
 * @CopyRight  (C)2000-2016 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2016.08.18
 * @Id         自定义页面
**/
if(!defined('ALLOWGUEST')) {exit('Access Denied');}

if(is_numeric($p)){
   $_sql   = "select * from ".DB_PREFIX."p where cid=".$p;
   $result = $db->fetch_first($_sql);
}


if(!Core_Fun::ischar($result['img'])){
	$result['img'] = PATH_URL.'/template/static/images/nopic.jpg';
  }else{
	$result['img'] = PATH_URL.$result['img'];
}

if(empty($result['title'])){
   $page_title = $result['cname'].'_'.$config['sitename'];
}else{
   $page_title = $result['title'];
}
if(empty($result['keywords'])){
   $page_keyword = $result['cname'];
}else{
   $page_keyword = $result['keywords'];
}
if(empty($result['description'])){
   $page_description = $config['metadescription'];
}else{
   $page_description = $result['description'];
}

$types = $result['types'];
$tpl->assign("p",$result);
$tpl->assign("page_title",$page_title);
$tpl->assign("page_keyword",$page_keyword);
$tpl->assign("page_description",$page_description);
