<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.01
 * Tags列表处理程序
**/
if(!defined('ALLOWGUEST')) {
	exit('Access Denied');
}
/* params */
header("Content-Type:text/html;charset=UTF-8"); 
$tag = urldecode($_GET["tag"]);
$code = mb_detect_encoding($tag, 'UTF-8', true) ? true : FALSE;
if(!$code){
	$tag = iconv("gbk","utf-8//IGNORE",$tag);
}
$tag = Core_Fun::replacebadchar($tag);

/* volist */
$searchsql	= " WHERE v.flag=1";
if(!empty($tag)){
	$searchsql .= " AND v.tag like '%".$tag."%'";
}
$countsql	= "SELECT COUNT(v.id) FROM ".DB_PREFIX."info AS v".$searchsql;
$countsql2	= "SELECT COUNT(v.id) FROM ".DB_PREFIX."product AS v".$searchsql;
$total_info	   = $db->fetch_count($countsql);
$total_product = $db->fetch_count($countsql2);
$sql		= "SELECT v.*,c.cname,c.word FROM ".DB_PREFIX."info AS v".
			 " LEFT JOIN ".DB_PREFIX."infocate AS c ON v.cid=c.cid".
	         $searchsql." ORDER BY v.id DESC";
$sql2       = "SELECT v.id,v.timeline,v.title,v.thumbfiles,c.cname,c.word FROM ".DB_PREFIX."product AS v".
			 " LEFT JOIN ".DB_PREFIX."productcate AS c ON v.cid=c.cid".
	         $searchsql." ORDER BY v.id DESC";
$info	= $db->getall($sql);
$product =$db->getall($sql2);


foreach ($info AS $key => $value)
{
	$info[$key]['url'] = PATH_URL."news/".$value['id'].".html";
    $info[$key]['caturl'] = PATH_URL.'news/'.$value['word'].'/';
	$text = $value['content'];
	$text = strip_tags($text);
	$text = mb_substr($text, 0, 120, 'utf-8');
	$text = str_replace(array('\n', '\r', '\t', ' ', '&nbsp;'), '', $text);
	$info[$key]['abstract'] = $text;
}

/*--新闻列表结束--*/
/*--------------------------------------------------------------------------*/

/*--产品列表开始--*/

foreach($product as $key=>$value){
	$product[$key]['url'] = PATH_URL."product/".$value['id'].".html";
	$product[$key]['caturl'] = PATH_URL.'product/'.$value['word'].'/';
	if($value['thumbfiles'] == ''){
		$product[$key]['thumbfiles'] = PATH_URL."template/static/images/nopic.jpg";
	}else{
		$product[$key]['thumbfiles'] = PATH_URL.$value['thumbfiles'];
	}
}

$myurl = str_replace('http://', '', PATH_URL);

/*--产品列表结束--*/
$page_title = $config['sitename'];
$page_keyword     = $page_description = $navname = $tag;
//$taglist = array_merge($product,$info);
//$tpl->assign("taglist",$taglist);
$tpl->assign("myurl", $myurl);
$tpl->assign("productlist",$product);
$tpl->assign("infolist",$info);
$tpl->assign("info_cout",$total_info);
$tpl->assign("product_count",$total_product);
$tpl->assign("navname",$navname);
$tpl->assign("page_title",$tag."_".$page_title);
$tpl->assign("page_keyword",$page_keyword);
$tpl->assign("page_description",$page_description);
?>