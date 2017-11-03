<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         人才招聘列表
**/
if(!defined('ALLOWGUEST')) {
	exit('Access Denied');
}

/* params */
$cid		= Core_Fun::detect_number(Core_Fun::rec_post("cid"));
$page		= Core_Fun::detect_number(Core_Fun::rec_post("page"),1);
$pagesize	= $config['jobpagesize'];
if($page<1){$page=1;}

/* volist */
$searchsql	= " WHERE v.flag=1";
if(intval($cid)>0){
	$searchsql .= " AND v.cid='".intval($cid)."'";
}
$countsql	= "SELECT COUNT(v.id) FROM ".DB_PREFIX."job AS v".$searchsql;
$total		= $db->fetch_count($countsql);
$pagecount	= ceil($total/$pagesize);
$nextpage	= $page+1;
$prepage	= $page-1;
$start		= ($page-1)*$pagesize;
$sql		= "SELECT v.*,c.cname,c.img,c.target,c.linktype,c.linkurl FROM ".DB_PREFIX."job AS v".
			 " LEFT JOIN ".DB_PREFIX."jobcate AS c ON v.cid=c.cid".
	         $searchsql." ORDER BY v.id DESC LIMIT $start, $pagesize";
$job		= $db->getall($sql);
foreach($job as $key=>$value){
	$job[$key]['url'] = PATH_URL."job/".$value['id'].".html";
	$job[$key]['caturl'] = PATH_URL."job/".$value['cid']."/";
	if(intval($value['linktype'])==2){
		$job[$key]['caturl'] = $value['linkurl'];
	}
	if(intval($value['target'])==2){
		$job[$key]['target'] = "_blank";
	}
}
/* page */
$showpage	= Core_Page::volistpage("job",$cid,$total,$pagesize,$page,10);

/* category */
$page_title       = $LANVAR['job'];
$page_keyword     = $LANVAR['job'];
$page_description = "";
$navigation = "<a href=\"".PATH_URL."job/\">".$LANVAR['job']."</a>";
$navcatname	= $LANVAR['job'];
$navurl     = NULL;
$cate = NULL;
$keywords   = $config['metakeyword'];
$arry_words = explode(',', $keywords);
if(isset($arry_words[3])){
	$sitetitle  = "_".$arry_words[3].'-'.$config['sitename'];
}else{
	$sitetitle  = "-".$config['sitename'];
}
if($cid>0){
	$cate = $db->fetch_first("SELECT * FROM ".DB_PREFIX."jobcate WHERE cid='".intval($cid)."'");
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
		}else{
			$target  = "_self";
		}
		if(intval($cate['linktype'])==2){
			$navurl = "<a href=\"".$cate['linkurl']."\" target='".$target."'>".$cate['catename']."</a>";
		}else{
			$navurl = '<a href="'.PATH_URL.'job/'.$cate['cid'].'/">'.$cate['cname'].'</a>';
		}
		$navigation .= $LANVAR['arrow'].$navurl;
		$navcatname = $cate['cname'];
	}
}else{
	$page_title .= $sitetitle;
	$page_keyword     = $LANVAR['job'];
	$page_description = $config['pdetail_d'];
	$page_description = str_replace('{1}', $LANVAR['job'], $page_description);
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
$tpl->assign("pagecount",$pagecount);
$tpl->assign("pagesize",$config['jobpagesize']);
$tpl->assign("job",$job);
$tpl->assign("navurl",$navurl);
$tpl->assign("navigation",$navigation);
$tpl->assign("navcatname",$navcatname);
$tpl->assign("page_title",$page_title);
$tpl->assign("page_keyword",$page_keyword);
$tpl->assign("page_description",$page_description);
?>