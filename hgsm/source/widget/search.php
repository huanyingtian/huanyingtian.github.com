<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * 搜索核心处理程序
**/
if(!defined('ALLOWGUEST')) 
{exit('Access Denied');}
$wd = Core_Fun::rec_post("wd",2);
$wd = htmlentities($wd, ENT_QUOTES, "utf-8");
$wd = addslashes($wd);
$p_count = 0;
$n_count = 0;
$var = $GLOBALS['LANVAR'];
if($wd)
{
  $where_p          = " and (a.title like '%$wd%' or productnum like '%$wd%')";
  $where_n          = " and a.title like '%$wd%'"; 
  $sql_p            = 'select a.*,b.word,b.cname from '.DB_PREFIX.'product as a
  		            LEFT JOIN '.DB_PREFIX.'productcate as b on a.cid=b.cid where a.flag=1'.$where_p;
  $sql_n            = 'select a.*,b.word,b.cname from '.DB_PREFIX.'info as a
  		            LEFT JOIN '.DB_PREFIX.'infocate as b on a.cid=b.cid where a.flag=1'.$where_n;
  $product = $db->getall($sql_p); 
  $info    = $db->getall($sql_n); 
  $p_count = count($product);
  $n_count = count($info);
}
else
{
	msg::msge($var['words']);
}
foreach($product as $key=>$data){
$product[$key]['url']    = PATH_URL.'product/'.$data['id'].'.html';	
$product[$key]['caturl'] = PATH_URL.'product/'.$data['word'].'/';
$product[$key]['thumbfiles'] = PATH_URL.$data['thumbfiles'];
}
foreach($info as $key=>$data){
	$info[$key]['url']    = PATH_URL.'news/'.$data['id'].'.html';
	$info[$key]['caturl'] = PATH_URL.'news/'.$data['word'].'/';
	$text = $data['content'];
	$text = strip_tags($text);
	$text = mb_substr($text, 0, 120, 'utf-8');
	$text = str_replace(array('\n', '\r', '\t', ' ', '&nbsp;'), '', $text);
	$info[$key]['abstract'] = $text;
}

$page_title       = ''.$var['serch'].'_'.$wd;
$page_description = $wd;
$page_keyword     = $wd;

$myurl = str_replace('http://', '', PATH_URL);
$tpl->assign("myurl", $myurl);

$tpl->assign('wd',$wd);
$tpl->assign('p_count',$p_count);
$tpl->assign('n_count',$n_count);
$tpl->assign("productlist",$product);
$tpl->assign("infolist",$info);
$tpl->assign('page_title',$page_title);
$tpl->assign('page_keyword',$page_keyword);
$tpl->assign('page_description',$page_description);

?>