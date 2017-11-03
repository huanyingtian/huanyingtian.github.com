<?php
//关键词默认显示
//error_reporting(E_ERROR);
require_once '../source/core/run.php';
header("Content-type: text/html; charset=utf-8");
header("Content-type:text/html");
 $html = $_POST['html'] ? $_POST['html']:'';
 $type = $_GET['type'];
 $fileName 		= 'rank.html';
 $fileLastName  = 'rank_last.html';
 $modelName 	= 'rank_model.html';
if(isset($type) && $type == 'download') {
	header('Content-type:text/html');
	header("Content-Disposition:attachment;filename=rank.html");
	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	readfile($fileName);
}else{
	if($html != '' && !empty($html)){
		$name = $config['sitename'];
		$url  = $config['siteurl'];
		$date = date('Y-m-d H:i:s');
 		$model_text   = file_get_contents($modelName);
		$html = str_replace(array('style="display: none;"','style="display: none; "','style="DISPLAY: none"'),'', $html);
		$html_content = str_replace('<%{rank_content}%>', $html, $model_text);
		$html_content = str_replace('<%{rank_name}%>',$name,$html_content);
		$html_content = str_replace('<%{rank_url}%>',$url, $html_content);
		$html_content = str_replace('<%{rank_date}%>',$date,$html_content);
		if(!file_put_contents($fileName,$html_content)){
			die('导出排名失败');
		}
		copy($fileName,$fileLastName);
		echo 0;
	}else{
		echo "导出内容为空";
	}
}
?>