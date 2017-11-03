<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         案例内容
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
$sql	= "SELECT v.*,c.cname,c.word,c.img,c.target,c.linktype,c.linkurl FROM ".DB_PREFIX."case AS v".
         " LEFT JOIN ".DB_PREFIX."casecate AS c ON v.cid=c.cid".
	     " WHERE v.flag=1 AND v.id='".intval($id)."' LIMIT 1";
$case= $db->fetch_first($sql);
if(!$case){
	header('Content-type:text/html;charset=utf-8');
	die(对不起，信息不存在或已删除！);
}else{
	$cid  = $case['cid'];
	if(intval($case['target'])==2){
		$target = "_blank";
	}
	/* url和导航 */
	$navigation  = '<a href="'.PATH_URL.'case/">'.$LANVAR['case'].'</a>'.$LANVAR['arrow'];
	if(intval($case['linktype'])==2){
		$navigation .= '<a href="'.$case['linkurl'].'">'.$case['cname'].'</a>'.$LANVAR['arrow'];
	}else{
		$navigation .= '<a href="'.PATH_URL.'case/'.$case['word'].'/">'.$case['cname'].'</a>';
	}
			
 	if(!Core_Fun::ischar($case['uploadfiles'])){
		$case['uploadfiles'] = PATH_URL.'/template/static/images/nopic.jpg';
	}else{
		$case['uploadfiles'] = PATH_URL.$case['uploadfiles'];
	}
 	if(!Core_Fun::ischar($case['thumbfiles'])){
		$case['thumbfiles'] = PATH_URL.'/template/static/images/nopic.jpg';
	}else{
		$case['thumbfiles'] = PATH_URL.$case['thumbfiles'];
	}
	if(!empty($case['ctitle'])){
		$page_title = $case['ctitle'];
	}else{
		$page_title	= $case['title'].'-'.$config['sitename'];
	}
	$case['content']  = Core_Command::command_replacetag($case['content']);
	/*给案例详细介绍添加分页*/
	$case['content'] = Core_Command::paging_num($case['content']);
}

/*--TAGS标签输出--*/
$tag_content = Mod_Product::v_tag($case['tag']);

/*--相关产品和案例（通过TAG相似度判断）--*/
$relatedproduct = Mod_Product::relate($case['tag'],5,"product");
$relatednew 	= Mod_Product::relate($case['tag'],10,"info",$id);
if(!empty($case['ckeywords'])){
	$page_keyword = $case['ckeywords'];
}else{
	$page_keyword   = $case['title'];
}
$page_description = $config['pdetail_page'];
$page_description = str_replace('{1}', $case['title'], $page_description);
$page_description = str_replace('{2}', $config['sitename'], $page_description);
if(!empty($case['cdescription'])){
	$page_description = $case['cdescription'];
}

$tpl->assign("relatedproduct",$relatedproduct);
$tpl->assign("relatednew",$relatednew);
$tpl->assign("tag",$tag_content);
$tpl->assign("id",$id);
$tpl->assign("case",$case);
$tpl->assign("source",$config['siteurl']);
$tpl->assign("navigation",$navigation);
$tpl->assign("previous_item",Mod_Case::previousitem($id,$case['cid']));
$tpl->assign("next_item",Mod_Case::nextitem($id,$case['cid']));
$tpl->assign("page_title",$page_title);
$tpl->assign("page_description",$page_description);
$tpl->assign("page_keyword",$page_keyword);
?>