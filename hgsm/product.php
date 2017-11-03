<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         产品页面
**/
$mod = isset($_GET['mod']) ? $_GET['mod'] : "list";
define('ALLOWGUEST',true);
require './source/core/run.php';
/* 指定允许访问的模块 */
$allowmod = array('list','detail');
if(!in_array($mod,$allowmod)) {
	header('Location: HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	exit;
}
/* 判断是否存在文件 */
$tplfile = INDEX_TEMPLATE."product_".$mod.".".$tplext;
$widgetfile = "./source/widget/product_".$mod.".php";
if(!Core_Fun::fileexists($tplfile)){
	header("Content-type:text/html;charset=utf-8");
	die('模板文件不存在!');
}
if(!Core_Fun::fileexists($widgetfile)){
	header("Content-type:text/html;charset=utf-8");
	die('缺少核心文件！');
}
/* 缓存,模板处理 */
	if($config['cachstatus'] == 1){
		$cache_seconds = $config['cachtime']*60;
		$tpl->caching = true;
		$tpl->cache_lifetime = $cache_seconds;
	}
	$cacheid = md5($_SERVER["REQUEST_URI"]);
	if(!$tpl->isCached($tplfile,$cacheid)){
		require './source/module/app.php';
		require $widgetfile;
	}
	$parent_title = $LANVAR['product'];
	$word = '';
	if(isset($cid) && $cid != '' && is_numeric($cid)){
		$arr = Mod_Url::firstcid($cid,'productcate');
		$category_son = Mod_Product::CategorySon($arr['cid']);
		$tpl->assign("first_cname",$arr['cname']);
	}else{
		$category_son = Mod_Product::treecategory();
		$tpl->assign("first_cname",$LANVAR['product']);
	}
	if($cid > 0){
       $tpl->assign('cate_banner',$commons->banners($cid,'productcate'));
    }

	$tpl->assign("first_cid",$arr['cid']);
	$tpl->assign("category_son",$category_son);

	$tpl->assign('parent_title',$parent_title);
	$tpl->assign('word',$word);
	$tpl->assign("runtime",Core_Fun::runtime());
	$tpl->assign("LANVAR",$LANVAR);
	$tpl->display($tplfile,$cacheid);
