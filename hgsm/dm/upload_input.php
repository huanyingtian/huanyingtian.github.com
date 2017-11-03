<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>图片上传</title>
<link type="text/css" rel="stylesheet" href="xycms/css/upload.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.4.4.min.js'></script>
</head>
<style type="text/css">
html{margin:0;padding:0;border:0;}
body,div,span,object,iframe,h1,h2,h3,h4,p,blockquote,pre,a,address,code,b,em,img,
dl,dt,dd,ol,ul,li,fieldset,form,label,footer,
header,hgroup,nav,section
{
margin:0;padding:0;border:0;font-size:100%;font:12px/1.5 宋体,arial,sans-serif;vertical-align:baseline
}
input{height:22px;line-height:20px;padding-left:2px;}
#inputupload{background:#ddd;border:none;border-bottom:1px solid #666;border-right:1px solid #666;}
</style>
<body>
<?php 
$filepath = $_GET['filepath'];
$is_thumb = @$_GET['is_thumb'] ? $_GET['is_thumb'] : 1;
$index    = isset($_GET['index']) ? $_GET['index'] : 1;
if(!is_numeric($is_thumb)){
	msg::msge('请确认是否生成缩略图！');
}
?>
<form action="upload.php" method="post" enctype="multipart/form-data" name="uploadform" id="uploadform">
   <input name="filepath" type="hidden" value="<?php echo $filepath ?>" />
   <input name="is_thumb" type="hidden" value="<?php echo $is_thumb ?>" />   
   <input name="index" type="hidden" value="<?php echo $index ?>" />
   <input name="uploadfile" type="file"  class="border" id="uploadfile" />
   <input type="submit" name="inputupload" id="inputupload" value="上 传" />       
</form>	
</body>
</html>