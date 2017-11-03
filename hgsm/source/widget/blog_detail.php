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
if($id<1){
	header('Location: HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
}
$sql	= "SELECT v.*,c.cname,c.word,c.img,c.target,c.linktype,c.linkurl FROM ".DB_PREFIX."info AS v".
         " LEFT JOIN ".DB_PREFIX."infocate AS c ON v.cid=c.cid".
	     " WHERE v.flag=1 AND v.id='".intval($id)."'";
$sql = "SELECT * FROM ".DB_PREFIX."blog WHERE `flag`='1' AND id='".$id."' LIMIT 1";
$blog = $db->fetch_first($sql);
if(!$blog){
	header("Content-type:text/html;charset=utf-8");
	die('对不起，信息不存在或已删除！');
}else{
	/* url和导航 */
	$navigation  = '<a href="'.PATH_URL.'blog/">'.$LANVAR['blog'].'</a>';
			
 	if(!Core_Fun::ischar($blog['thumbfiles'])){
		$into['uploadfiles'] = PATH_URL.'/template/static/images/nopic.jpg';
	}else{
		$into['uploadfiles'] = PATH_URL.$blog['uploadfiles'];
	}
    $page_title      = $blog['title'];
	$blog['content'] = Core_Command::command_replacetag($blog['content']);
}
/* 上一个 */
function previousitem($id){
	$temp  = "";
	global $db;
	if(Core_Fun::isnumber($id)){
		$id = intval($id);
		$query = "SELECT id,title FROM ".DB_PREFIX."blog WHERE id<$id".
				" ORDER BY id DESC LIMIT 1";
		$rows  = $db->fetch_first($query);
		if($rows){
			$temp = '<a href="'.PATH_URL.'blog/'.$rows['id'].'.html">'.$rows['title'].'</a>';
		}else{
			$temp = "没有了";
		}
	}
	return $temp;
}

/* 下一个 */
function nextitem($id){
	$temp  = "";
	global $db;
	if(Core_Fun::isnumber($id)){
		$id = intval($id);
		$query = "SELECT id,title FROM ".DB_PREFIX."blog WHERE id>$id".
				" ORDER BY id ASC LIMIT 1";
		$rows  = $db->fetch_first($query);
		if($rows){
			$temp = '<a href="'.PATH_URL.'blog/'.$rows['id'].'.html">'.$rows['title'].'</a>';
		}else{
			$temp = "没有了";
		}
	}
	return $temp;
}

/*--TAGS标签输出--*/
$tag_content = Mod_Product::v_tag($blog['tag']);

/*--相关产品和新闻（通过TAG相似度判断）--*/
$relatedproduct = Mod_Product::relate($blog['tag'],5,"product");
$relatednew 	= Mod_Product::relate($blog['tag'],10,"info",$id);
$page_title	    = $blog['title'].'_'.$LANVAR['blog']."_".$config['sitename'];
$page_description = $blog['title'];
$page_keyword     = $blog['title'];
$tpl->assign("relatedproduct",$relatedproduct);
$tpl->assign("relatednew",$relatednew);
$tpl->assign("tag",$tag_content);
$tpl->assign("id",$id);
$tpl->assign("blog",$blog);
$tpl->assign("source",$config['siteurl']);
$tpl->assign("navigation",$navigation);
$tpl->assign("previous_item",previousitem($id));
$tpl->assign("next_item",nextitem($id));
$tpl->assign("page_title",$page_title);
$tpl->assign("page_description",$page_description);
$tpl->assign("page_keyword",$page_keyword);
?>