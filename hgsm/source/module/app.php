<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.07
**/
if(!defined('ALLOWGUEST')) {
	exit('Access Denied');
}
require CHENCY_ROOT.'source/module/mod.url.php';  //菜单栏目URL处理
require CHENCY_ROOT.'source/module/mod.page.php';
require CHENCY_ROOT.'source/module/mod.ads.php';
require CHENCY_ROOT.'source/module/mod.delimit.php';//说明页标签生成
require CHENCY_ROOT.'source/module/mod.info.php';
require CHENCY_ROOT.'source/module/mod.case.php';
require CHENCY_ROOT.'source/module/mod.down.php';
require CHENCY_ROOT.'source/module/mod.product.php';
require CHENCY_ROOT.'source/module/mod.job.php';
require CHENCY_ROOT.'source/module/mod.part.php';
require CHENCY_ROOT.'source/module/contact.php';
require CHENCY_ROOT.'source/model/region.class.php';
require CHENCY_ROOT.'source/core/sp.php';
require CHENCY_ROOT.'source/module/mod.common.php';

$tail_one = $_REQUEST['svc'];
// print_r($city_one);die();
$metakeyword = $config['metakeyword'];
$metarray = explode(',', $metakeyword);
foreach ($metarray as $key => $val) 
{
	$tpl->assign('metakeyword_'.$key,$val);
}

$sql = "SELECT `id`,`title` FROM ".DB_PREFIX."product where flag=1 order by orders DESC";
$result_pro = $db->getall($sql);
foreach ($result_pro as $key => $vals) {
	$result_pro[$key]['url'] = PATH_URL.'product/'.$vals['id'].'.html';
}


$host = strtolower(rtrim(str_replace('http://', '', $_SERVER['HTTP_HOST']), '/'));
if (!empty($config['murl'])) {
	$tpl->assign('m_path_url','http://'.$config['murl'].'/');
} else {
	$tpl->assign('m_path_url',PATH_URL.'m/');
}

/* 系统默认全局变量函数 */
$commons = new Mod_Common;
$tpl->assign('commons',$commons);

/* 初始化 */
Mod_Url::display_menurl();
Mod_Page::display();
Mod_Ads::display();
Mod_Delimit::display();

/* 系统默认函数标签 */
$product_category = Mod_Product::category();
$tpl->assign('resultpro',$result_pro);
$tpl->assign("volist_onlinechat",Mod_Part::volist_onlinechat());
$tpl->assign("volist_fontlink",Mod_Part::volist_fontlink());
$tpl->assign("volist_logolink",Mod_Part::volist_logolink());
$tpl->assign("about_sort",Mod_Page::volist("AND `catdir`='{$catdir}'",'ORDER BY c.cid,v.orders'));
$tpl->assign("page_sort_all",Mod_Page::volist("AND `catdir` != 'mobile'",'ORDER BY c.cid,v.orders'));
$tpl->assign('page_list', Mod_Page::page_list());
$tpl->assign("down_elite",Mod_Down::volist());
$tpl->assign("news_sort",Mod_Info::category());
$tpl->assign("case_sort",Mod_Case::category());
$tpl->assign("download_sort",Mod_Down::category());
$tpl->assign("job_sort",Mod_Job::category());
$tpl->assign("job_index",Mod_Job::volist());
$tpl->assign("productCate", $product_category);
$tpl->assign("productTreeCate",Mod_Product::treecategory());
$tpl->assign("copyright",Core_Command::copyright());
$tpl->assign('h1',Core_Command::Key_H1());
$tpl->assign('currentid',$contactid);
$tpl->assign("source_url",'http://'.$config['siteurl']);

?>