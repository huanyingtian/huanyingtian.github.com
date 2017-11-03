<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.01
 * Id          通用内容页面
**/
if(!defined('ALLOWGUEST')) {
	exit('Access Denied');
}
$word = Core_Fun::rec_post("word");
$pagenum = Core_Fun::rec_post("pagenum");

if (!is_numeric($pagenum))
{
	$pagenum = 1;
}
////!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!仍然不安全
$prev_page_num = $pagenum-1;
$next_page_num = $pagenum+1;

if($word == '')
{
	$sql = 'SELECT `word` FROM '.DB_PREFIX."page AS a LEFT JOIN " . DB_PREFIX."pagecate AS b ON a.cid = b.cid WHERE `catdir`='{$catdir}' ORDER BY a.`orders` ASC LIMIT 1";
	$w = $db->fetch_first($sql);
	if($w == '' || empty($w))
	{
		header('Content-type:text/html;charset=utf-8');
		die('栏目内容为空，请添加栏目内容！');
	}
	$word = $w['word'];
}
// echo $word;
$sql	= "SELECT a.*,b.cname,b.catdir FROM ".DB_PREFIX."page AS a LEFT JOIN ".DB_PREFIX."pagecate as b ON a.cid=b.cid WHERE a.flag=1 AND a.word='".$word."' LIMIT 1";
$page	= $db->fetch_first($sql);
if ($page)
{
	$keywords   = $config['metakeyword'];
	$arry_words = explode(',', $keywords);
	// $page_word = array_rand($arry_words);
	if(!empty($page['pkeywords'])){
		$page_keyword = $page['pkeywords'];
	}else{
		$page_keyword = $page['title'];
	}
	if(Core_Fun::ischar($page['img'])){
		$page['img'] = PATH_URL.$page['img'];
	}
	if(!empty($page['pdescription'])){
		$page_description = $page['pdescription'];
	}else{
		$page_description = Core_Fun::de_cut($page['content'], 120,'...');
		$page_description = str_replace(" ", "", $page_description);
	}
	if(!empty($page['ptitle'])){
		$page_title = $page['ptitle'];
	}else{
		$page_title = $page['title']."_".$arry_words[0]."-".$config['sitename'];
	}
	if($page['catdir'] == 'about')
	{
		$page['caturl'] = PATH_URL."about/";
	}
	else
	{
		$page['caturl'] = PATH_URL."about_{$page['catdir']}/";
	}
	$page['url'] = PATH_URL.'about/'.$page['word'].'.html';
	$paging_contents = explode("_ueditor_page_break_tag_", Core_Command::command_replacetag($page['content']));
	$page['content'] = $paging_contents[$pagenum-1];
	$paging_count = count($paging_contents);
	if ($paging_count > 1)
	{
		$tpl->assign("ispaging", "true");
	}
	if ($pagenum == 1)
	{
		$tpl->assign("prev_page", "null");
		$tpl->assign("next_page", PATH_URL.'about/'.$page['word'].'_'.$next_page_num.'.html');
	}
	else if ($pagenum == $paging_count)
	{
		$tpl->assign("prev_page", PATH_URL.'about/'.$page['word'].'_'.$prev_page_num.'.html');
		$tpl->assign("next_page", "null");
	}
	else
	{
		$tpl->assign("prev_page", PATH_URL.'about/'.$page['word'].'_'.$prev_page_num.'.html');
		$tpl->assign("next_page", PATH_URL.'about/'.$page['word'].'_'.$next_page_num.'.html');
	}
}
else
{
	header('Content-type:text/html;charset=utf-8');
	die('对不起，页面不存在或已删除！');
}
$tpl->assign("about_cid",$page['cid']);
$tpl->assign("page",$page);
$tpl->assign("word",$word);
$tpl->assign("page_title",$page_title);
$tpl->assign("page_keyword",$page_keyword);
$tpl->assign("page_description",$page_description);
?>