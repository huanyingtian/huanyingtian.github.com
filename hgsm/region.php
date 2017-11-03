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
require CHENCY_ROOT.'./source/module/mod.delimit.php';//说明页标签生成
Mod_Delimit::display();
$region = require CHENCY_ROOT.'./source/conf/city.php';
require CHENCY_ROOT.'./source/module/mod.url.php';
Mod_Url::display_menurl();
/* 判断是否存在文件 */
$tplfile = INDEX_TEMPLATE."region.".$tplext;
if(!Core_Fun::fileexists($tplfile)){
	header("Content-type:text/html;charset=utf-8");
	die('模板文件不存在!');
}
if($config['cachstatus'] == 1){
	$cache_seconds = $config['cachtime']*60;
	$tpl->caching = true;
	$tpl->cache_lifetime = $cache_seconds;
}
$cacheid = md5($_SERVER["REQUEST_URI"]);

$region_sql = 'SELECT * FROM '.DB_PREFIX."region WHERE flag=1 ORDER BY id ASC";
$region_arr = $db->getall($region_sql);


if (!empty($region_arr)) {
	$arr = array();
	foreach ($region_arr as $key => $value) {
		$arr[] .= $value['name'];
	}
	foreach ($region as $key => &$value) {
		if (!empty($value['list'])) {
			foreach ($value['list'] as $k => $val) {
				if (in_array($val, $arr)) {
					unset($value['list'][$k]);
				} 
			}
		}
	}
}

$tpl->assign('keyword',"地区分站 - {$config['sitetitle']}");
$tpl->assign('region_arr',$region_arr);
$tpl->assign('region',$region);
$tpl->display($tplfile,$cacheid);
?>