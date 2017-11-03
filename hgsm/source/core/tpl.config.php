<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XiangYun v1.0
 * @Update     2012.07.07
**/
if(!defined('IN_PHPOE')) {
	exit('Access Denied');
}
if (! file_exists(CHENCY_ROOT . 'template/_caches')){
	@mkdir(CHENCY_ROOT . 'template/_caches', 0777);
	@chmod(CHENCY_ROOT . 'template/_caches', 0777);
}
if (! file_exists(CHENCY_ROOT . 'template/_compiled')){
	@mkdir(CHENCY_ROOT . 'template/_compiled', 0777);
	@chmod(CHENCY_ROOT . 'template/_compiled', 0777);
}
clearstatcache();
require CHENCY_ROOT.'./source/core/tpl.class.php';
$tpl = new Smarty;
$tpl->setTemplateDir(CHENCY_ROOT);
$tpl->setCacheDir(CHENCY_ROOT . 'template/_caches');
$tpl->setCompileDir(CHENCY_ROOT . 'template/_compiled');
$tpl->left_delimiter = "<!--{";
$tpl->right_delimiter = "}-->";
$tpl->caching = false;
$tpl->allow_php_templates = false;
$tpl->compile_check = true;
$tpl->force_compile = false;
$tpl->debugging = false;
?>