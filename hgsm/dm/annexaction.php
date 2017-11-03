<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XiangYun v1.0
 * @Update     2012.07.07
**/
require_once '../source/core/run.php';
require_once 'admin.inc.php';
echo"<meta http-equiv='Content-Type' content='text/html;charset=".PHPOE_CHARSET."' />";
$forbidtype		= "asp|aspx|asax|asa|jsp|cer|cdx|asa|htr|php|php3|cgi|html|htm|shtml|sql|exe|chm";
$max_file_size	= 2097152;
$comeform		= Core_Fun::rec_post('comeform');
$inputname		= Core_Fun::rec_post('inputname');

$attachmentdir = "data/download/";
if(!file_exists("../".$attachmentdir.$yfolder)){
	mkdir("../".$attachmentdir.$yfolder);
}
$filepath = $attachmentdir;
if(!file_exists("../".$filepath)){
	mkdir("../".$filepath);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (!is_uploaded_file($_FILES["upfile"]['tmp_name'])){
		echo "<font color='red'>文件不存在！</font>";
		exit;
	}
    $file		= $_FILES["upfile"];
	$file_size	= $file["size"];
    if($max_file_size < $file_size){
		echo "<font color='red'>文件太大了！超过了2M.</font>";
		exit;
	}
    $tmpname		= $file["tmp_name"];
    $image_size		= getimagesize($tmpname); 
    $pinfo			= pathinfo($file["name"]);
    $file_type		= $pinfo['extension'];
	if(Core_Fun::foundinarr($forbidtype,strtolower($file_type),"|")){
		echo "<font color='red'>禁止上传".$forbidtype."类型文件.</font>";
		die();
	}
	$time	      = date('YmdHis');
	$rndnum		  = Core_Fun::get_rndchar(4);
	$newfilename  = $time.$rndnum.".".$file_type;
	$uploadfiles  = $filepath.$newfilename;
    $fulluploadfiles	= "../".$uploadfiles;
	if (file_exists($fulluploadfiles)){
		echo "<font color='red'>同名文件已经存在了！</font>";
		exit;
	}
	if(!move_uploaded_file ($tmpname, $fulluploadfiles)){
		echo "<font color='red'>文件上传失败！</a>";
		exit;
	}
	
	$realname = $_FILES["upfile"]["name"];
	// exit($comeform);
	
	
    if($comeform!=""){
		echo("<script language='javascript'>window.opener.document.".$comeform.".".$inputname.".value='".$uploadfiles."';</script>");
		echo("<script language='javascript'>window.opener.document.".$comeform."."."realname".".value='".$realname."';</script>");
		echo("<script language=\"javascript\">window.close();</script>");
	}else{
		openner("");
	}
}
?>