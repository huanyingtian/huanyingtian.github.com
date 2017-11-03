<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2016.09.06  模板树形文件
**/
header("Content-type: application/json");
require '../source/core/run.php';
require_once 'admin.inc.php';
function readFileFromDir($dir) {
    if (!is_dir($dir)){
        return false;
    }
    $array = array();
    $arrayname = array();
    $handle = opendir($dir);
    while(($file = readdir($handle)) !== false) {
        if($file == "." || $file == "..") {
            continue;
        }
        $file = $dir.'/'.$file;
        if(is_dir($file)) {
	        $array[] = array(
               'text'=>basename($file),
           	   'isFolder' =>true,
	           'children'=> readFileFromDir($file),
	        );
        }elseif(is_file($file)) {
           $file_url = str_replace('../template/default/','',$file);
           $arrayname[] = array(
	          'text'=>basename($file),
	          'href'=>PATH_URL.'dm/edits.php?files='.$file_url,
	          'hrefTarget'=>'filemain'
	        );
        }
    }
    return array_merge($array,$arrayname);
}

$arr = readFileFromDir('../template/default');
$tpl->assign("array",json_encode($arr));
$tpl->display(ADMIN_TEMPLATE."ace.tpl");
$tpl->assign("copyright",$libadmin->copyright());
