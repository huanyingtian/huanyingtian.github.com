<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2016.09.06  模板编辑
**/
header("Content-type: application/json");
require '../source/core/run.php';

$save     = Core_Fun::rec_post("save");
$files  = Core_Fun::rec_post("files");
if($save){
   $openurl = fopen("../template/default/".$save,"wb");
    if($openurl){
      @fwrite($openurl,$_POST['content']);
    }
    fclose($openurl);
    $arr = array('success'=>'模板保存成功。');
    die(json_encode($arr));
}

if($files){
   $file_url = CHENCY_ROOT.'template/default/'.$files;
   $content = file_get_contents($file_url);
}
$ajax_url = PATH_URL.'dm/edits.php?save='.$files;
$tpl->assign("ajax_url",$ajax_url);
$tpl->assign("filepath",$files);
$tpl->assign("content",htmlspecialchars($content));
$tpl->display(ADMIN_TEMPLATE."edits.tpl");