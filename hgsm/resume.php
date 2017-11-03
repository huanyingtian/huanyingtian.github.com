·<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         简历提交
**/
define('ALLOWGUEST',true);
session_start();
require './source/core/run.php';

/*简历提交*/
$action = Core_Fun::rec_post("action");
if($action == "saveadd"){
    $title     = Core_Fun::rec_post("title",1);
	$cname     = Core_Fun::rec_post("cname",1);
	$tel       = Core_Fun::rec_post("tel",1);
    $sex       = Core_Fun::rec_post("sex",1);
    $education = Core_Fun::rec_post("education",1);
    $experience= Core_Fun::rec_post("experience",1);
 	$joburl    = Core_Fun::rec_post("joburl",1);
    $checkcode =strtolower($_POST['checkcode']);
    if(!preg_match( "/^[A-Za-z0-9]{4}$/i",$checkcode)){
        msg::msge('验证码格式错误');
    }
    if($checkcode != $_SESSION['verifycode']){
        msg::msge('验证码错误！');
    }
    $founderr   = false;
    if(!Core_Fun::ischar($cname)){
        $founderr = true;
        $errmsg    .="姓名不能为空.";
    }
    if(!Core_Fun::ischar($tel)){
        $founderr = true;
        $errmsg    .="电话不能为空.";
    }
    if($founderr == true){
        msg::msge($errmsg);
    }
    if(!preg_match( "/^[0-9\-]{8,}$/i ",$tel)){
        msg::msge('联系方式格式错误');
    }
    //设置文件保存目录
    $uploaddir = "./data/download/";    
    //设置允许上传文件的类型
    $type = array("xls","doc","txt","pdf","rar","docx","zip");
    //获取文件后缀名函数 
    function fileext($filename)   {   
        return substr(strrchr($filename, '.'), 1);   
    }  
    if(!empty($_FILES['file']['name'])){
        if(!in_array(strtolower(fileext($_FILES['file']['name'])),$type)){   
            $text=implode(",",$type);   
            msg::msge('请重新上传文件,您只能上传以下类型文件'.$text,$joburl);
        }else{   
            $filename = explode(".",$_FILES['file']['name']);   
            do{   
                $filename[0]= time().mt_rand(0,10000); //生成目标文件的文件名 
                $name = implode(".",$filename);    
                $file_upload = $uploaddir.$name; 
            }   
            while(file_exists($file_upload)); 
            if(is_uploaded_file($_FILES["file"]["tmp_name"])){
                if (move_uploaded_file($_FILES["file"]["tmp_name"],$file_upload)){ 
                    $uploadfile = $file_upload;
                }
            }
        }
    } 
    $array = array(
        'title'=>$title,
        'cname'=>$cname,
        'tel'=>$tel,
        'sex'=>$sex,
        'education'=>$education,
        'experience'=>$experience,
        'uploadfile'=>$uploadfile,
        'timeline'=>time(),
    );
    $result = db()->insert(DB_PREFIX."resume",$array);
    if($result){
	   	msg::msge('信息提交成功，我们将会尽快给您联系，感谢您的支持！',$joburl);
	}else{
	   	msg::msge('信息提交失败，请您重新提交！',$joburl);
	}
}
