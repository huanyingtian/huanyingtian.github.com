<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
**/
require_once '../source/core/run.php';
require_once 'admin.inc.php';
$action	= Core_Fun::rec_post("action");
$dir	= Core_Fun::strip_post('dir');
switch($action){
	case 'edit':
	    edit();
		break;
	case 'saveedit':
	    saveedit();
		break;
	case 'del':
	    del();
		break;
	default:
	    volist();
		break;
}

function volist(){
	Core_Auth::checkauth("templatevolist");
	global $dir,$tpl;
	if(!Core_Fun::ischar($dir)){
		$dir = SKIN;
	}
	if(substr($dir,0,strlen(SKIN))!="default"){
		msg::msge('对不起，模板管理只允许读取对应模板目录下的文件！');
	}
	$dirpath = "../template/".$dir;
	/* 判断是否存在目录 */
	if(!is_dir($dirpath)){
		msg::msge('对不起，模板目录不存在！');
	}else{
		if(!file_exists($dirpath)){
			msg::msge('对不起，模板目录不存在！');
		}
	}
	$handle= opendir($dirpath);
	$template = array();
	$i = 0;
	$ii = 1;
	if($handle){
		while(false !== ($files=readdir($handle))){
			if($files != '.' && $files != '..'){
				$url_strs = $dir."/".$files;

				if(is_dir($dirpath."/".$files)){
					/* 文件夹 */
					$template = $template + array(
						$i=>array(
						    'i'=>$ii,
						    'type'=>'1',
							'filename'=>$files,
							'size'=>get_filesize($dirpath."/".$files),
							'timeline'=>get_filetime($dirpath."/".$files),
						    'filepath'=>$url_strs,
						)
					);
				}else {
					/* 文件名 */
					$template = $template + array(
						$i=>array(
						    'i'=>$ii,
						    'type'=>'2',
							'filename'=>$files,
							'size'=>get_filesize($dirpath."/".$files),
							'timeline'=>get_filetime($dirpath."/".$files),
						    'filepath'=>$url_strs,
						)
					);
				}
			}
			$i = $i+1;
			$ii = ($ii+1);
		}
	}
	closedir($handle);
	$tpl->assign("dirpath",$dirpath);
	$tpl->assign("dir",$dir);
	$tpl->assign("template",$template);
}

function edit(){
	Core_Auth::checkauth("templateedit");
	global $tpl;
    $urlstrs = Core_Fun::strip_post('file');
	if(!Core_Fun::ischar($urlstrs)){
		msg::msge('对不起，请指点要修改的模板文件');
	}
	/* 限制目录 */
	
	if(substr($urlstrs,0,strlen(SKIN))!=SKIN){		
		msg::msge('对不起，只能修改'.SKIN.'目录下的文件！');
	}
	if(!Core_Fun::fileexists("../template/".$urlstrs)){
		msg::msge('对不起，模板文件不存在！');
	}

	/* 扩展名 */
	$allow_exts = "tpl|html|htm|js|css";
	$array_file = explode(".",$urlstrs);
	$array_count = count($array_file);
	$file_ext = $array_file[$array_count-1];
	if(!Core_Fun::foundinarr($allow_exts,strtolower($file_ext),"|")){
		msg::msge('对不起，只允许修改后缀为.tpl,.html,.htm,.js和.css的文件！');
	}

	/* 文件名和目录名 */
	$arrays = explode("/",$urlstrs);
	$counts = count($arrays);
	$filename = $arrays[$counts-1];
	$filepath = str_replace($filename,"",$urlstrs);

	/* 读取文件信息 */
	$content = "";
	$handle = @fopen("../template/".$urlstrs,"r");
	if(!$handle){
		msg::msge('对不起，读取文件内容失败！');
	}else{
		while(!feof($handle)){
			$content = $content.tpl_encode(fgets($handle));
		}
		fclose($handle);
	}
	$tpl->assign("content",$content);
	$tpl->assign("dir",substr($filepath,0,(strlen($filepath)-1)));
	$tpl->assign("urlstrs",$urlstrs);
}

function saveedit(){
	Core_Auth::checkauth("templateedit");
    $urlstrs = Core_Fun::strip_post('file',1);
	$content = Core_Fun::strip_post("content",1);
	if(!Core_Fun::ischar($urlstrs)){
		msg::msge('文件不存在或者丢失！');
	}
	if(!Core_Fun::ischar($content)){
		msg::msge('文件内容不能为空');
	}
    
	if(!Core_Fun::fileexists("../template/".$urlstrs)){
		msg::msge('对不起，模板文件不存在！');
	}
	/* 限制目录 */
	if(substr($urlstrs,0,strlen(SKIN))!=SKIN){
		msg::msge('对不起，只能修改'.SKIN.'目录下的文件！');
	}

	/* 扩展名 */
	$allow_exts = "tpl|html|htm|js|css";
	$array_file = explode(".",$urlstrs);
	$array_count = count($array_file);
	$file_ext = $array_file[$array_count-1];
	if(!Core_Fun::foundinarr($allow_exts,strtolower($file_ext),"|")){
		msg::msge('对不起，只允许修改后缀为.tpl,.html,.htm,.js和.css的文件！');
	}

	/* 文件名和目录名 */
	$arrays = explode("/",$urlstrs);
	$counts = count($arrays);
	$filename = $arrays[$counts-1];
	$filepath = str_replace($filename,"",$urlstrs);

	$content = tpl_decode($content);

	/* 检测文件 */
	if(!is_writeable("../template/".$urlstrs)){
		msg::msge('对不起，该文件没有修改的权限！请设置tpl目录权限后再试！');
	}else{
		$handle = fopen("../template/".$urlstrs,"wb");
		if(!$handle){
			msg::msge('对不起，不能打开该文件！');
		}else{
			if(@fwrite($handle,$content)===FALSE){
				msg::msge('对不起，文件修改失败，请检查该文件是否使用中！');
			}else{
				Core_Command::runlog("","编辑文件成功[".$urlstrs."]",1);
				msg::msge("模板文件修改成功","xycms_template.php?dir=".urlencode(substr($filepath,0,(strlen($filepath)-1)))."");
			}
		}
		fclose($handle);
	}
}

function del(){
	Core_Auth::checkauth("templatedel");
    $urlstrs = Core_Fun::strip_post('file');

	if(!Core_Fun::ischar($urlstrs)){
		msg::msge('请选择要删除的文件！');
	}
	if(!Core_Fun::fileexists("../template/".$urlstrs)){
		msg::msge('对不起，模板文件不存在！');
	}
	if(substr($urlstrs,0,strlen(SKIN))!=SKIN){
		msg::msge('对不起，只能修改'.SKIN.'目录下的文件！');
	}
	/* 文件名和目录名 */
	$arrays = explode("/",$urlstrs);
	$counts = count($arrays);
	$filename = $arrays[$counts-1];
	$filepath = str_replace($filename,"",$urlstrs);
	Core_Fun::deletefile("../template/".$urlstrs);
	Core_Command::runlog("","删除文件成功[".$urlstrs."]",1);
	msg::msge("文件删除成功","xycms_template.php?dir=".urlencode(substr($filepath,0,(strlen($filepath)-1)))."");
}

/* 获取文件大小 */
function get_filesize($a){
	if(file_exists($a)){
		return Core_Fun::format_size(fileSize($a));
	}
}

/* 获取修改时间 */
function get_filetime($a){
	if(file_exists($a)){
		return filemTime($a);
	}
}

function tpl_encode($str){
	$str=str_replace("<","&lt;",$str);
	$str=str_replace(">","&gt;",$str);
	return $str;
}

function tpl_decode($str){
	$str=str_replace("&lt;","<",$str);
	$str=str_replace("&gt;",">",$str);
	return $str;
}

$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."template.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>