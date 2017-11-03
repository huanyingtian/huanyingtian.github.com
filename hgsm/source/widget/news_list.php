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
$word		= Core_Fun::rec_post("word",2);
$page		= Core_Fun::detect_number(Core_Fun::rec_post("page"),1);
$pagesize	= $config['newspagesize'];

if ($page<1)
{
	$page=1;
}

/*volist*/
$searchsql	= " WHERE v.flag=1";
$sql = "select cid from ".DB_PREFIX."infocate where word='".$word."'";
$data = $db->fetch_first($sql);
$cid = $data['cid'];


if (intval($cid)>0)
{
	$childs_sql = Core_Mod::build_childsql("infocate", "v", intval($cid), "");
	if (Core_Fun::ischar($childs_sql))
	{
		$searchsql .= " AND (v.cid='".intval($cid)."'".$childs_sql.")";
	}
	else
	{
		$searchsql .= " AND v.cid='".intval($cid)."'";
	}
}
$countsql	= "SELECT COUNT(v.id) FROM ".DB_PREFIX."info AS v".$searchsql;
$total		= $db->fetch_count($countsql);
$pagecount	= ceil($total/$pagesize);
$nextpage	= $page + 1;
$prepage	= $page - 1;
$start		= ($page-1)*$pagesize;
$sql		= "SELECT v.*,c.cname,c.word,c.img,c.target,c.linktype,c.linkurl FROM ".DB_PREFIX."info AS v".
			 " LEFT JOIN ".DB_PREFIX."infocate AS c ON v.cid=c.cid".
	         $searchsql." ORDER BY v.timeline DESC LIMIT $start, $pagesize";
			 
//echo $sql;
			 
$news_list	= $db->getall($sql);

foreach ($news_list AS $key => $value)
{
	$text = $value['content'];
	$text = strip_tags($text);
	$text = mb_substr($text, 0, 120, 'utf-8');
	$text = str_replace(array('\n', '\r', '\t', ' ', '&nbsp;'), '', $text);
	$news_list[$key]['abstract'] = $text;
}

Mod_Url::content_change($news_list,"news",$word);
/* page */
$showpage	= Core_Page::volistpage("news",$word,$total,$pagesize,$page,10);
/* category */
$page_title       = $LANVAR['news'];
$navigation = '<a href="'.PATH_URL.'news/">'.$LANVAR['news'].'</a>';
$navcatname	= $LANVAR['news'];
$navurl     = NULL;
$page_keyword = $LANVAR['news'];
$page_description = '';
// $page_keyword = $page_description = 2;
$keywords   = $config['metakeyword'];
$arry_words = explode(',', $keywords);
if(isset($arry_words[2])){
	$sitetitle  = "_".$arry_words[2].'-'.$config['sitename'];
}else{
	$sitetitle  = "-".$config['sitename'];
}
if($cid>0){
	$cate = $db->fetch_first("SELECT * FROM ".DB_PREFIX."infocate WHERE `cid`='".intval($cid)."'");
	if($cate){
		if(!empty($cate['title'])){
			$page_title = $cate['title'];
		}else{
			$page_title = $cate['cname'].$sitetitle;
		}
		if(!empty($cate['keywords'])){
			$page_keyword = $cate['keywords'];
		}else{
			$page_keyword = $cate['cname'];
		}
		$page_description = $config['pdetail_d'];
		$page_description = str_replace('{1}', $cate['cname'], $page_description);
		$page_description = str_replace('{2}', $config['sitename'], $page_description);
		if(!empty($cate['description'])){
			$page_description = $cate['description'];
		}
		if(intval($cate['target'])==2){
			$target = "_blank";
		}
		if(intval($cate['linktype'])==2){
			$navurl = "<a href=\"".$cate['linkurl']."\" target='".$target."'>".$cate['cname']."</a>";
		}else{
		    $navurl = '<a href="'.PATH_URL.'news/'.$cate['word'].'/">'.$cate['cname'].'</a>';
		}
		$navigation .= $LANVAR['arrow'].$navurl;
		$navcatname = $cate['cname'];
	}
}else{
	$page_title .= $sitetitle;
	$page_description = $config['pdetail_d'];
	$page_description = str_replace('{1}', $LANVAR['news'], $page_description);
	$page_description = str_replace('{2}', $config['sitename'], $page_description);	
}
if($page>1){
	$page_title .= "_第".$page."页";
}

$cate = isset($cate) ? $cate : '';
$tpl->assign("cid",$cid);
$tpl->assign("cate",$cate);
$tpl->assign("showpage",$showpage);
$tpl->assign("total",$total);
$tpl->assign("page",$page);
$tpl->assign("pagecount",$pagecount);
$tpl->assign("pagesize",$config['newspagesize']);
$tpl->assign("news",$news_list);
$tpl->assign("navurl",$navurl);
$tpl->assign("navigation",$navigation);
$tpl->assign("navcatname",$navcatname);
$tpl->assign("page_title",$page_title);
$tpl->assign("page_keyword",$page_keyword);
$tpl->assign("page_description",$page_description);
?>