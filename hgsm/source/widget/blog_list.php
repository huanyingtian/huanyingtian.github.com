<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.01
 * @Id         新闻资讯列表
**/
if(!defined('ALLOWGUEST')) {
	exit('Access Denied');
}
/* params */
$word		= '';
$page		= Core_Fun::detect_number(Core_Fun::rec_post("page"),1);
$pagesize	= 10;
if($page<1){$page=1;}
$searchsql	= " WHERE flag=1";
$countsql	= "SELECT COUNT(id) FROM ".DB_PREFIX."blog ".$searchsql;
$total		= $db->fetch_count($countsql);
$pagecount	= ceil($total/$pagesize);
$nextpage	= $page+1;
$prepage	= $page-1;
$start		= ($page-1)*$pagesize;
$sql        = "SELECT * FROM ".DB_PREFIX."blog ".$searchsql." ORDER BY `id` LIMIT ".$start.", ".$pagesize;
$blog_list	= $db->getall($sql);
Mod_Url::content_change($blog_list,"blog");
/* page */
$showpage	= Core_Page::volistpage("blog",$word,$total,$pagesize,$page,10);
/* category */
$page_title       = $LANVAR['blog'];
$navigation = '<a href="'.PATH_URL.'blog/">'.$LANVAR['blog'].'</a>';
$navcatname	= $LANVAR['blog'];
$navurl     = NULL;
if($page>1)
{
	$page_title .= "第".$page."页";
}
// header("Content-type:text/html;charset=utf-8");
// print_r($blog_list);
// exit;
$page_keyword     = $LANVAR['blog'];
$page_description = $LANVAR['blog'];
$tpl->assign("showpage",$showpage);
$tpl->assign("total",$total);
$tpl->assign("page",$page);
$tpl->assign("pagecount",$pagecount);
$tpl->assign("pagesize",$pagesize);
$tpl->assign("blog",$blog_list);
$tpl->assign("navigation",$navigation);
$tpl->assign("navcatname",$navcatname);
$tpl->assign("page_title",$page_title."_".$config['sitetitle']);
$tpl->assign("page_keyword",$config['metakeyword']);
$tpl->assign("page_description",$page_description.','.$config['sitename']);
?>