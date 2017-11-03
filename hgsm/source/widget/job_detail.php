<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.01
 * @Id         人才招聘内容
**/
if(!defined('ALLOWGUEST')) {
	exit('Access Denied');
}
$id = Core_Fun::detect_number(Core_Fun::rec_post("id"));
if($id<1){
	header('Location: HTTP/1.0 404 Not Found');
	die();
}
$sql	= "SELECT v.*,c.cname,c.img,c.target,c.linktype,c.linkurl FROM ".DB_PREFIX."job AS v".
         " LEFT JOIN ".DB_PREFIX."jobcate AS c ON v.cid=c.cid".
	     " WHERE v.flag=1 AND v.id='".intval($id)."' LIMIT 1";
$job= $db->fetch_first($sql);
if(!$job){
	echo '对不起，信息不存在或已删除！';
	die();
}else{
	if(intval($job['target'])==2){
		$target = "_blank";
	}
	/* url和导航 */
	$job['url'] = PATH_URL.'job/'.$job['id'].'.html';
	if(intval($job['linktype'])==2){
		$job['caturl'] = $job['linkurl'];
	}else{
		$job['caturl'] = PATH_URL.'job/'.$job['cid'].'/';
	}
	$navigation = '<a href="'.PATH_URL.'job/">'.$LANVAR['job'].'</a>'.$LANVAR['arrow'];
	if(intval($job['linktype'])==2){
		$navigation .= "<a href=\"".$job['linkurl']."\">".$job['cname']."</a>".$LANVAR['arrow'];
	}else{
		$navigation .= '<a href="'.PATH_URL.'job/'.$job['cid'].'/">'.$job['cname'].'</a>';
	}
	if(!empty($job['jtitle'])){
		$page_title = $job['jtitle'];
	}else{
		$page_title	= $job['title'].'-'.$config['sitename'];
	}
	if(!empty($job['jkeywords'])){
		$page_keyword = $job['jkeywords'];
	}else{
		$page_keyword = $job['title'];
	}
	$page_description = $config['pdetail_page'];
	$page_description = str_replace('{1}', $job['title'], $page_description);
	$page_description = str_replace('{2}', $config['sitename'], $page_description);
	if(!empty($job['jdescription'])){
		$page_description = $job['jdescription'];
	}
}

$tpl->assign("id",$id);
$tpl->assign("job",$job);
$tpl->assign("navigation",$navigation);
$tpl->assign("previous_item",Mod_Job::previousitem($id));
$tpl->assign("next_item",Mod_Job::nextitem($id));
$tpl->assign("page_title",$page_title);
$tpl->assign("page_description",$page_description);
$tpl->assign("page_keyword",$page_keyword);
?>