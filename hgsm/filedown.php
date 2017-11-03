<?php
require './source/core/run.php';
$id = intval($_GET['id']);
if(is_numeric($id) && $id >0) {
	$sql	= "SELECT * FROM ".DB_PREFIX."download WHERE id='".intval($id)."' LIMIT 1";
	$download= $db->fetch_first($sql);
	if($download){
		$filename       = basename($download['uploadfiles']);
		$file_extension = strtolower(substr(strrchr($filename,"."),1));
		if(in_array($file_extension,array('php','html','htm','asp','aspx','shtml','jsp','js','exe','jsp','css'))){
			msg::msge('对不起,你无权下载'.$file_extension.'格式的文件！');
		}
		$file = $download['uploadfiles'];
		if(file_exists($file)){
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Cache-Control: no-cache");
			header("Pragma: no-cache");
			Header("Content-type: application/octet-stream");
			Header("Accept-Ranges: bytes");
			Header("Accept-Length: ".filesize($file));
			Header("Content-Disposition: attachment; filename=".urlencode($download['realname']));	
			ob_clean();
			flush();
			readfile($file);
			$db->update(DB_PREFIX."download",array('downs'=>$download['downs']+1),"id=$id");
			exit;
		}else{
			header("Content-type: text/html; charset=utf-8");
			die('文件不存在');		
		}	
		
	}else{
		header("Content-type:text/html;charset=utf-8");
		die('对不起，信息不存在或已删除！');
	}	
}else{
	header('Location: HTTP/1.0 404 Not Found');  //404错误
	header('Status: 404 Not Found');
	die();
}



?>