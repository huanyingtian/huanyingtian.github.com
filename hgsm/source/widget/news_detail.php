<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         新闻资讯内容
**/
if(!defined('ALLOWGUEST')) {
	exit('Access Denied');
}
$id = Core_Fun::detect_number(Core_Fun::rec_post("id"));

//TempNum 显示临时记录数
$TempNum=10;  
//RecentlyNews 最近商品RecentlyNews临时变量
if (isset($_COOKIE['RecentlyNews'])) 
{
	$RecentlyNews=$_COOKIE['RecentlyNews']; 
	$RecentlyGoodsArray=explode(",", $RecentlyNews);
	$RecentlyGoodsNum=count($RecentlyGoodsArray); //RecentlyGoodsNum 当前存储的变量个数
}
if($_GET['id']!="")
{
	$Id=$_GET['id']; //ID 为得到请求的字符
	//如果存在了，则将之前的删除，用最新的在尾部追加
	if (strstr($RecentlyNews, $Id)) 
	{
	  $tpl->assign('browse',$GLOBALS['LANVAR']['brnews']);
	}
	else
	{
		if($RecentlyGoodsNum<$TempNum) //如果COOKIES中的元素小于指定的大小，则直接进行输入COOKIES
		{
			if($RecentlyNews=="")
			{
			    setcookie("RecentlyNews",$Id,time()+86400);
			}
			else
			{
				$RecentlyGoodsNew=$RecentlyNews.",".$Id;
				setcookie("RecentlyNews", $RecentlyGoodsNew,time()+86400); 
			}
		}
		else //如果大于了指定的大小后，将第一个给删去，在尾部再加入最新的记录。
		{
			$pos=strpos($RecentlyNews,",")+1; //第一个参数的起始位置
			$FirstString=substr($RecentlyNews,0,$pos); //取出第一个参数
			$RecentlyNews=str_replace($FirstString,"",$RecentlyNews); //将第一个参数删除
			$RecentlyGoodsNew=$RecentlyNews.",".$Id; //在尾部加入最新的记录
			setcookie("RecentlyNews", $RecentlyGoodsNew,time()+86400); 
		}
	}
}
$dir=$_COOKIE["RecentlyNews"];
if(isset($dir)){
	$sql_b="SELECT v.*,c.cname,c.word,c.img,c.target,c.linktype,c.linkurl FROM ".DB_PREFIX."info AS v LEFT JOIN ".DB_PREFIX."infocate AS c ON v.cid=c.cid".
	       " WHERE v.flag=1 AND v.id in ($dir) ORDER BY v.orders DESC";
	$newprow = $db->getall($sql_b);
	foreach ($newprow as $key =>&$value) {
		$value['url']  = PATH_URL."news/{$value['id']}.html";
		$value['thumbfiles']=PATH_URL.$value['img'];
	}
	$tpl->assign("newprow",$newprow);
}

if($id<1){
	header('Location: HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
}
$sql	= "SELECT v.*,c.cname,c.word,c.img,c.target,c.linktype,c.linkurl FROM ".DB_PREFIX."info AS v".
         " LEFT JOIN ".DB_PREFIX."infocate AS c ON v.cid=c.cid".
	     " WHERE v.flag=1 AND v.id='".intval($id)."' LIMIT 1";
$info= $db->fetch_first($sql);
if(!$info){
	header('Content-type:text/html;charset=utf-8');
	die(对不起，信息不存在或已删除！);
}else{
	$cid  = $info['cid'];
	if(intval($info['target'])==2){
		$target = "_blank";
	}
	/* url和导航 */
	$navigation  = '<a href="'.PATH_URL.'news/">'.$LANVAR['news'].'</a>'.$LANVAR['arrow'];
	if(intval($info['linktype'])==2){
		$navigation .= '<a href="'.$info['linkurl'].'">'.$info['cname'].'</a>'.$LANVAR['arrow'];
	}else{
		$navigation .= '<a href="'.PATH_URL.'news/'.$info['word'].'/">'.$info['cname'].'</a>';
	}
			
 	if(!Core_Fun::ischar($info['thumbfiles'])){
		$into['uploadfiles'] = PATH_URL.'/template/static/images/nopic.jpg';
	}else{
		$into['uploadfiles'] = PATH_URL.$info['thumbfiles'];
	}
	if(!empty($info['ntitle'])){
		$page_title = $info['ntitle'];
	}else{
		$page_title	= $info['title'].'-'.$config['sitename'];
	}
	$info['content']  = Core_Command::command_replacetag($info['content']);
	$info['content']  = Core_Command::paging_num($info['content']);
	$info['url']      = PATH_URL.'news/'.$info['id'].'.html';

}

/*--TAGS标签输出--*/
$tag_content = Mod_Product::v_tag($info['tag']);

/*--相关产品和新闻（通过TAG相似度判断）--*/
$relatedproduct = Mod_Product::relate($info['tag'],5,"product");
$relatednew 	= Mod_Product::relate($info['tag'],10,"info",$id);
// $page_description = $page_keyword = $info['title'];
if(!empty($info['nkeywords'])){
	$page_keyword = $info['nkeywords'];
}else{
	$page_keyword = $info['tag'];
}

$page_description = Core_Fun::de_cut($info['content'], 120,'...');
$page_description = str_replace(" ", "", $page_description);
if(!empty($info['ndescription'])){
	$page_description = $info['ndescription'];
}
$tpl->assign("relatedproduct",$relatedproduct);
$tpl->assign("relatednew",$relatednew);
$tpl->assign("tag",$tag_content);
$tpl->assign("id",$id);
$tpl->assign("news",$info);
$tpl->assign("source",$config['siteurl']);
$tpl->assign("navigation",$navigation);
$tpl->assign("previous_item",Mod_Info::previousitem($id,$info['cid']));
$tpl->assign("next_item",Mod_Info::nextitem($id,$info['cid']));
$tpl->assign("page_title",$page_title);
$tpl->assign("page_description",$page_description);
$tpl->assign("page_keyword",$page_keyword);
?>