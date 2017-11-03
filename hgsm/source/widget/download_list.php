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
$cid		= Core_Fun::detect_number(Core_Fun::rec_post("cid"));
$page		= Core_Fun::detect_number(Core_Fun::rec_post("page"),1);
$pagesize	= $config['downpagesize'];
if($page<1){$page=1;}

/* volist */
$searchsql	= " WHERE v.flag=1";
if(intval($cid)>0){
	$searchsql .= " AND v.cid='".intval($cid)."'";
}
$countsql	= "SELECT COUNT(v.id) FROM ".DB_PREFIX."download AS v".$searchsql;
$total		= $db->fetch_count($countsql);
$pagecount	= ceil($total/$pagesize);
$nextpage	= $page+1;
$prepage	= $page-1;
$start		= ($page-1)*$pagesize;
$sql		= "SELECT v.*,c.cname,c.img FROM ".DB_PREFIX."download AS v".
			 " LEFT JOIN ".DB_PREFIX."downloadcate AS c ON v.cid=c.cid".
	         $searchsql." ORDER BY v.id DESC LIMIT $start, $pagesize";
$download	= $db->getall($sql);
foreach($download as $key=>$value){
	$download[$key]['url'] = PATH_URL."download/".$value['id'].".html";
	$download[$key]['downurl'] = PATH_URL.'filedown.php?id='.$id;   //直接下载，无需进入详细页面
	$download[$key]['caturl'] = PATH_URL."download/".$value['cid']."/";
}

/* page */
$channel	= "download";
$showpage	= Core_Page::volistpage($channel,$cid,$total,$pagesize,$page,10);

/* category */
$page_title       = $LANVAR['download'];
$page_keyword     = $LANVAR['download'];
$page_description = "";

$navigation = "<a href=\"".PATH_URL."download.html\">".$LANVAR['download']."</a>";
$navigation = '<a href="'.PATH_URL.'download/">'.$LANVAR['download'].'</a>';

$navcatname	= $LANVAR['download'];
$navurl     = NULL;
$cate		= NULL;
$keywords   = $config['metakeyword'];
$arry_words = explode(',', $keywords);
if(isset($arry_words[4])){
	$sitetitle  = "_".$arry_words[4].'-'.$config['sitename'];
}else{
	$sitetitle  = "-".$config['sitename'];
}
if($cid>0){
	$cate = $db->fetch_first("SELECT * FROM ".DB_PREFIX."downloadcate WHERE cid='".intval($cid)."' LIMIT 1");
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
		$navurl = '<a href="'.PATH_URL.'download/'.$cate['cid'].'/">'.$cate['cname'].'</a>';
		$navigation .= $LANVAR['arrow'].$navurl;
		$navcatname = $cate['cname'];
	}
}else{
	$page_title .= $sitetitle;
	$page_description = $config['pdetail_d'];
	$page_description = str_replace('{1}', $LANVAR['download'], $page_description);
	$page_description = str_replace('{2}', $config['sitename'], $page_description);
}
if($page>1){
	$page_title .= "-第".$page."页";
}

$tpl->assign("cid",$cid);
$tpl->assign("cate",$cate);
$tpl->assign("showpage",$showpage);
$tpl->assign("total",$total);
$tpl->assign("page",$page);
$tpl->assign("pagesize",$config['newspagesize']);
$tpl->assign("download",$download);
$tpl->assign("navurl",$navurl);
$tpl->assign("navigation",$navigation);
$tpl->assign("navcatname",$navcatname);
$tpl->assign("page_title",$page_title);
$tpl->assign("page_keyword",$page_keyword);
$tpl->assign("page_description",$page_description);
?>