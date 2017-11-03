<?php
require_once '../source/core/run.php';
global $config;
$url = $config['siteurl'];
if($url=='') {
echo "result=url_error\n";
}else{
	if(($r = getKuaiZhao($url)) == true) {
		echo "result=true\n";
		echo "snapshot=$r\n";
	}else {
		echo "result=false\n";
	}
}
function getKuaiZhao($text) {
	$url = 'http://www.baidu.com/s?word='.$text;
	$html = file_get_contents($url);
	$text = str_replace('.','\.',addslashes($text));
	$search = '/<b>'.$text.'<\/b>[^<]*((?:19|20)[0-9]{2}-(?:1[012]|[1-9])-(?:[12][0-9]|3[01]|[1-9]))/';
	preg_match($search, $html, $r);
	//highlight_string($search);
	return $r[1];
}
?>
