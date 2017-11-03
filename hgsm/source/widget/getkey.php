<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.01
 * @Id         案例列表
**/
if(!defined('ALLOWGUEST')) {
	exit('Access Denied');
}
/* params */
$word		= Core_Fun::rec_post("word",2);
$page		= Core_Fun::detect_number(Core_Fun::rec_post("page"),1);
$pagesize	= $config['casepagesize'];

if ($page<1)
{
	$page=1;
}

if(empty($word)){
	$countsql	 = "SELECT COUNT(id) FROM ".DB_PREFIX."keywords where flag=1";
	$total		 = $db->fetch_count($countsql);
	$pagecount	 = ceil($total/$pagesize);
	$nextpage	 = $page + 1;
	$prepage	 = $page - 1;
	$start		 = ($page-1)*$pagesize;
	$sql		 = "SELECT * FROM ".DB_PREFIX."keywords where flag=1 ORDER BY id DESC LIMIT $start, $pagesize";			 		 
	$getkey_list = $db->getall($sql);
	Mod_Url::content_change($getkey_list,"getkey");
	/* page */
	$showpage	= Core_Page::volistpage("getkey",$word,$total,$pagesize,$page,10);
	/* category */
	$page_title   = $LANVAR['getkey'];
	$navcatname	  = $LANVAR['getkey'];
	$page_keyword = $LANVAR['getkey'];
	$page_description = '';
	$keywords   = $config['metakeyword'];
	$arry_words = explode(',', $keywords);
	if(isset($arry_words[2])){
		$sitetitle  = "_".$arry_words[2].'-'.$config['sitename'];
	}else{
		$sitetitle  = "-".$config['sitename'];
	}
	$page_title .= $sitetitle;
	$page_description = $config['pdetail_d'];
	$page_description = str_replace('{1}', $LANVAR['getkey'], $page_description);
	$page_description = str_replace('{2}', $config['sitename'], $page_description);
	if($page>1){
		$page_title .= "_第".$page."页";
	}
	$tpl->assign("showpage",$showpage);
	$tpl->assign("total",$total);
	$tpl->assign("page",$page);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("pagesize",$config['casepagesize']);
	$tpl->assign("getkey",$getkey_list);
	$tpl->assign("navcatname",$navcatname);
	$tpl->assign("page_title",$page_title);
	$tpl->assign("page_keyword",$page_keyword);
	$tpl->assign("page_description",$page_description);
}else{
	$sql    = "SELECT * FROM ".DB_PREFIX."keywords where flag=1 and word='{$word}' LIMIT 1";
	$getkey = $db->fetch_first($sql);
	if(!$getkey){
		header('Content-type:text/html;charset=utf-8');
		die(对不起，信息不存在或已删除！);
	}else{
		$navigation  = '<a href="'.PATH_URL.'getkey/">'.$LANVAR['getkey'].'</a>'.$LANVAR['arrow'];
		$navigation .= '<a href="'.PATH_URL.'getkey/'.$getkey['word'].'/">'.$getkey['wname'].'</a>';
	 	if(!Core_Fun::ischar($getkey['uploadfiles'])){
			$getkey['uploadfiles'] = PATH_URL.'/template/static/images/nopic.jpg';
		}else{
			$getkey['uploadfiles'] = PATH_URL.$getkey['uploadfiles'];
		}
		if(!Core_Fun::ischar($getkey['thumbfiles'])){
		    $getkey['thumbfiles'] = PATH_URL.'/template/static/images/nopic.jpg';
		}else{
			$getkey['thumbfiles'] = PATH_URL.$getkey['thumbfiles'];
		}
		if(!empty($getkey['wtitle'])){
			$page_title = $getkey['wtitle'];
		}else{
			$page_title	= $getkey['wname'].'-'.$config['sitename'];
		}
		$getkey['content']  = Core_Command::command_replacetag($getkey['content']);
		/*给热推产品详细介绍添加分页*/
		$getkey['content'] = Core_Command::paging_num($getkey['content']);
		/*--TAGS标签输出--*/
		$tag_content = Mod_Product::v_tag($getkey['tag']);
	}
	/*--相关产品和案例（通过TAG相似度判断）--*/
	$relatedproduct = Mod_Product::relate($getkey['tag'],5,"product");
	$relatednew 	= Mod_Product::relate($getkey['tag'],10,"info",$getkey['id']);
	if(!empty($getkey['wkeywords'])){
		$page_keyword = $getkey['wkeywords'];
	}else{
		$page_keyword   = $getkey['wname'];
	}
	$page_description = $config['pdetail_page'];
	$page_description = str_replace('{1}', $getkey['wname'], $page_description);
	$page_description = str_replace('{2}', $config['sitename'], $page_description);
	if(!empty($getkey['wdescription'])){
		$page_description = $getkey['wdescription'];
	}
	// print_r($getkey);exit;
	$tpl->assign("relatedproduct",$relatedproduct);
	$tpl->assign("relatednew",$relatednew);
	$tpl->assign("tag",$tag_content);
	$tpl->assign("id",$getkey['id']);
	$tpl->assign("getkey",$getkey);
	$tpl->assign("source",$config['siteurl']);
	$tpl->assign("navigation",$navigation);
	$tpl->assign("navcatname",$getkey['wname']);
	$tpl->assign("previous_item",Mod_Case::previousitem_getkey($getkey['id']));
	$tpl->assign("next_item",Mod_Case::nextitem_getkey($getkey['id']));
	$tpl->assign("page_title",$page_title);
	$tpl->assign("page_description",$page_description);
	$tpl->assign("page_keyword",$page_keyword);
}

$tpl->assign("word",$word);
?>