<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         下载内容
**/
if(!defined('ALLOWGUEST')) {
	exit('Access Denied');
}
$id = Core_Fun::detect_number(Core_Fun::rec_post("id"));
if($id<1){
	header('Location: HTTP/1.0 404 Not Found');
	die();
}
$sql	= "SELECT v.*,c.cname,c.img FROM ".DB_PREFIX."download AS v".
         " LEFT JOIN ".DB_PREFIX."downloadcate AS c ON v.cid=c.cid".
	     " WHERE v.flag=1 AND v.id='".intval($id)."'";
$download= $db->fetch_first($sql);
if(!$download){
	echo '对不起，信息不存在或已删除！';
	die();
}else{
    
	/* url和导航 */
	//$download['url'] = PATH_URL.'download/'.$download['id'].'.html';
	$download['caturl'] = PATH_URL.'download/'.$download['cid'].'/';

	$navigation  = '<a href="'.PATH_URL.'download/">'.$LANVAR['download'].'</a>'.$LANVAR['arrow'];
	$navigation .= '<a href="'.PATH_URL.'download/'.$download['cid'].'/">'.$download['cname'].'</a>'.$LANVAR['arrow'];
	$navigation .= '<a href="'.PATH_URL.'download/'.$id.'.html">'.$download['title'].'</a>';
	
	$download['downurl'] = PATH_URL.'filedown.php?id='.$id;
	$download['exten'] = strtolower(strrchr($download['uploadfiles'],"."));
	if(!empty($download['dtitle'])){
		$page_title = $download['dtitle'];
	}else{
		$page_title	= $download['title'].'-'.$config['sitename'];
	}
	if(!empty($download['dkeywords'])){
		$page_keyword = $download['dkeywords'];
	}else{
		$page_keyword = $download['title'];
	}
	$page_description = $config['pdetail_page'];
	$page_description = str_replace('{1}', $download['title'], $page_description);
	$page_description = str_replace('{2}', $config['sitename'], $page_description);
	if(!empty($download['ddescription'])){
		$page_description = $download['ddescription'];
	}
}


$tpl->assign("id",$id);
$tpl->assign("download",$download);
$tpl->assign("navigation",$navigation);
$tpl->assign("previous_item",Mod_Down::previousitem($id));
$tpl->assign("next_item",Mod_Down::nextitem($id));
$tpl->assign("page_title",$page_title);
$tpl->assign("page_description",$page_description);
$tpl->assign("page_keyword",$page_keyword);
?>