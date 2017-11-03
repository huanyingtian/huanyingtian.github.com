<?php
header("Content-type:text/html;charset=utf-8");
require_once '../source/core/run.php';
global $config;
$url = $config['siteurl'];
$metakeyword = explode(',', $config['metakeyword']);
$keyword     = array_slice($metakeyword,0,3);
$key = '';
if($url !='') {
	foreach($keyword as $data){
		$a     = explode('：',midu($url,$data));
		$midu .= $a[1].',';	
		$key  .= $data.',';
	}
	$midu = substr($midu,0,-1); 
	$key  = substr($key,0,-1);
	echo "result=true\n";
	echo "key=$key\nmidu=$midu";
}else{
	echo "result=url_error\n";
}
function midu($url,$key='') {
	$key = urlencode($key);
	$a = file_get_contents("http://tool.chinaz.com/Tools/Density.aspx?kw=$key&url=$url");
	$pattern = '/<div[^>]*?id="Result"[^>]*>[\s\S]*?<\/div>/i';
	preg_match($pattern,$a,$matches);
	if($matches == '' || !$matches){
	 return false;	
	}else{
	 $a = explode('<br/>',$matches[0]);
	 return $a[4];
	}
}
?>
