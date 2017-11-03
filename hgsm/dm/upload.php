<?php
// 图片上传和添加水印
require '../source/core/run.php';
require '../source/core/FileUpload.class.php';
require '../source/core/image.class.php';
require 'admin.inc.php';

//上传文件到指定目录
$upload_path = array('product','download','link','news','p','banner','other','about','job','case','m','ico');
// echo($_POST['filepath']);exit;
if(($f_path = $_POST['filepath']) == true)
{
	if(!in_array($f_path, $upload_path) )
	{
		msg::msge('请指定正确的上传目录');
	}
}
else
{
	msg::msge('请指定上传目录');
}
$path='';
if($_POST['filepath']=="m")
{
	$filepath ='m/';
	$path = '../m/';
	if (!file_exists($path)) {
		mkdir($path);
	}
	$newname="icon.png";
	// $_FILES["uploadfile"]["name"]=$newname;
	if($_FILES["uploadfile"]["type"] !== "image/png" && $_FILES["uploadfile"]["type"] !== "image/x-png")
	{
		msg::msge("请上传png图片！");
	}else{
		if(file_exists($path.$newname)){
			unlink($path.$newname);
			move_uploaded_file($_FILES["uploadfile"]["tmp_name"],$path.$newname);
			$filename=$newname;
			$index    = intval($_POST['index'])-1;
			$uploadfiles = $filepath.$filename;
			$mt=mt_rand();
			// echo($mt);die();
			echo '<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>';
			echo '<script>$(".upload_img",parent.document.body).eq('.$index.').attr("src","'.'../'.$uploadfiles.'?'.$mt.'");';
			echo '$(".upload_img",parent.document.body).eq('.$index.').css({"display":"block"});';
			echo '$(".pic_remove",parent.document.body).eq('.$index.').css("display","block");';
			echo '$("#iframe_t",parent.document.body).eq('.$index.').css("display","none");';
			echo '$("#uploadfiles",parent.document.body).eq('.$index.').val("'.$uploadfiles.'?'.$mt.'");';
			echo '</script>';	
		}else{
			move_uploaded_file($_FILES["uploadfile"]["tmp_name"],$path.$newname);
			$filename=$newname;
			$index    = intval($_POST['index'])-1;
			$uploadfiles = $filepath.$filename;
			$mt=mt_rand();
			echo '<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>';
			echo '<script>$(".upload_img",parent.document.body).eq('.$index.').attr("src","'.'../'.$uploadfiles.'?'.$mt.'");';
			echo '$(".upload_img",parent.document.body).eq('.$index.').css({"display":"block"});';
			echo '$(".pic_remove",parent.document.body).eq('.$index.').css("display","block");';
			echo '$("#iframe_t",parent.document.body).eq('.$index.').css("display","none");';
			echo '$("#uploadfiles",parent.document.body).eq('.$index.').val("'.$uploadfiles.'?'.$mt.'");';
			echo '</script>';	
		}
	}
}elseif($_POST['filepath']=="ico")
{
	$filepath ='ico/';
	$path = '../ico/';
	if (!file_exists($path)) {
		mkdir($path);
	}
	$newname="favicon.ico";
	// $_FILES["uploadfile"]["name"]=$newname;
	// print_r($_FILES["uploadfile"]);die();
	if($_FILES["uploadfile"]["type"] !== "image/icon" && $_FILES["uploadfile"]["type"] !== "image/x-icon")
	{
		msg::msge("请上传ico图片！");
	}else{
		if(file_exists($path.$newname)){
			unlink($path.$newname);
			move_uploaded_file($_FILES["uploadfile"]["tmp_name"],$path.$newname);
			$filename=$newname;
			$index    = intval($_POST['index'])-1;
			$uploadfiles = $filepath.$filename;
			$mt=mt_rand();
			// echo($mt);die();
			echo '<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>';
			echo '<script>$(".upload_img",parent.document.body).eq('.$index.').attr("src","'.'../'.$uploadfiles.'?'.$mt.'");';
			echo '$(".upload_img",parent.document.body).eq('.$index.').css({"display":"block"});';
			echo '$(".pic_remove",parent.document.body).eq('.$index.').css("display","block");';
			echo '$("#iframe_t",parent.document.body).eq('.$index.').css("display","none");';
			echo '$("#uploadfiles",parent.document.body).eq('.$index.').val("'.$uploadfiles.'?'.$mt.'");';
			echo '</script>';	
		}else{
			move_uploaded_file($_FILES["uploadfile"]["tmp_name"],$path.$newname);
			$filename=$newname;
			$index    = intval($_POST['index'])-1;
			$uploadfiles = $filepath.$filename;
			$mt=mt_rand();
			echo '<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>';
			echo '<script>$(".upload_img",parent.document.body).eq('.$index.').attr("src","'.'../'.$uploadfiles.'?'.$mt.'");';
			echo '$(".upload_img",parent.document.body).eq('.$index.').css({"display":"block"});';
			echo '$(".pic_remove",parent.document.body).eq('.$index.').css("display","block");';
			echo '$("#iframe_t",parent.document.body).eq('.$index.').css("display","none");';
			echo '$("#uploadfiles",parent.document.body).eq('.$index.').val("'.$uploadfiles.'?'.$mt.'");';
			echo '</script>';	
		}
	}
}else
{
		$filepath = 'data/images/'.str_replace('/', '', $_POST['filepath']).'/';
		$filepath = $filepath ? $filepath : 'data/images/other/'; //上传目录
		$path = '../'.$filepath;
	if (!file_exists($path)) {
		mkdir($path);
	}
	$up=new FileUpload(array("filepath"=>$path, "allowtype"=>array("gif", "jpg", "png"), "root" => CHENCY_ROOT));
	if($up->uploadFile("uploadfile")){
		$filename=$up->getNewFileName();
		$img=new Image($path);
		$width  = $config['thumbwidth'];
		$height = $config['thumbheight'];
		$watermarkflag = $config['watermarkflag'];
		$is_thumb = $_POST['is_thumb'];
		$index    = intval($_POST['index'])-1;

	/**
	 * $is_thumb = 1  //产生缩略图
	 * $is_thumb = 2  //不产生缩略图
	 */	
		if($is_thumb == 1){
		   $th_filename=$img->thumb($filename, $width, $height);
		    if($_POST['filepath'] == 'product'){
		    	@copy($path.$filename,'../data/images/source/'.$filename); 
		    	if($config['watermarkflag'] == 1){
		    		$img->waterMark($filename);
		    	}
		    }
		   if(!empty($filename) || !empty($th_filename)){
		   	$uploadfiles = $filepath.$filename;
		   	$thumbfiles  = $filepath.$th_filename;
		   	echo '<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>';
		   	echo '<script>$(".upload_img",parent.document.body).eq('.$index.').attr("src","'.'../'.$thumbfiles.'");';
		   	echo '$(".upload_img",parent.document.body).eq('.$index.').css({"display":"block"});';
		   	echo '$(".pic_remove",parent.document.body).eq('.$index.').css("display","block");';
		   	echo '$("#iframe_t",parent.document.body).eq('.$index.').css("display","none");';
		   	echo '$("#uploadfiles",parent.document.body).eq('.$index.').val("'.$uploadfiles.'");';
		   	echo '$("#thumbfiles",parent.document.body).eq('.$index.').val("'.$thumbfiles.'");';
		   	echo 'window.location.href="upload_input.php?filepath='.$f_path.'is_thumb='.$is_thumb.'";';
		   	echo '</script>';
		   }	   
		}else{
			if($is_thumb == 2){
			if(!empty($filename)){
				$uploadfiles = $filepath.$filename;	
				echo '<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>';
				echo '<script>$(".upload_img",parent.document.body).eq('.$index.').attr("src","'.'../'.$uploadfiles.'");';
				echo '$(".upload_img",parent.document.body).eq('.$index.').css({"display":"block"});';
				echo '$(".pic_remove",parent.document.body).eq('.$index.').css("display","block");';
				echo '$("#iframe_t",parent.document.body).eq('.$index.').css("display","none");';
				echo '$("#uploadfiles",parent.document.body).eq('.$index.').val("'.$uploadfiles.'");';
				echo '</script>';					
			}	
		  }					
		}	
		//$img->waterMark($th_filename, "gaolf.gif", 5, "wa_");	//缩略图加水印
	}else{
		//echo $up->getErrorMsg();
		msg::msge($up->getErrorMsg());
	}
}

























?>
