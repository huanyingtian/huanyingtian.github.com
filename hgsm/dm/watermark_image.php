<?php
require '../source/core/run.php';
require '../source/core/image.class.php';
require 'admin.inc.php';

$action	= $_POST['processing'];

switch($action){
	case 'increase':
	    increase();
		break;
	case 'cancel':
	    cancel();
		break;
	default:
		die();
		break;
}

function increase(){
	$patharr = "../data/images/product/";
	$source  = "../data/images/source/";
	$img = new Image($source);
	$list = scandir($patharr);// 得到该文件下的所有文件和文件夹
	$error = array();
	foreach ($list as $file) 
	{
		if($file!="." && $file!="..")
		{
			$str = "thumb";
			if(substr_count($file,$str) > 0)
			{
				$file  =str_replace("thumb_","", $file);
				$error_prompt = $img->waterMark($file,$patharr);
				if($error_prompt == '处理失败'){
					$error[] .= $patharr.$file.'----需要加水印的图片不存在！'; 
				}
			}
		}
	}
	$arr = array('success'=>'处理成功。','error' =>$error);
    die(json_encode($arr));
}

function cancel(){
	$patharr = "../data/images/product/";
	$source  = "../data/images/source/";
	$list = scandir($patharr);// 得到该文件下的所有文件和文件夹
	foreach ($list as $file) 
	{
		if($file!="." && $file!="..")
		{
			$str = "thumb";
			if(substr_count($file,$str) > 0)
			{
				$file  =str_replace("thumb_","", $file);
				@unlink($patharr.$file);
				$error_prompt = @copy($source.$file,$patharr.$file); 
				if($error_prompt == ''){
					$error[] .= $patharr.$file.'----图片原文件不存在！'; 
				}
			}
		}
	}
	$arr = array('success'=>'处理成功。','error' =>$error);
    die(json_encode($arr));

}





















