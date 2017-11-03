<?php
// ob_start();
// $keyword = array('环氧管','绝缘管','耐温绝缘管','环氧纤维管','高分子DMC','耐高温绝缘管','耐温环氧管');
// $url = 'www.szhqblg.com';
// foreach($keyword as $word){
// 	search_rank($word,$url);
// }
$url 	  = $_GET['url'];
$keywords = $_GET['keywords'];
search_rank($keywords,$url);

function search_rank($keyword,$url,$page = 1){
	$rsState = false;
	$endkeyword = urlencode($keyword);
	$firstRow = ($page - 1) * 10;
	if($page > 10){
		die('10页之内没有该网站排名..end');
	}
	$contents = curl_rank("http://www.baidu.com/s?wd=$endkeyword&&pn=$firstRow");
	preg_match_all('/<table[^>]*?class=("result"|"result-op")[^>]*>[\s\S]*?<\/table>/i',$contents,$rs);
	
	foreach($rs[0] as $k=>$v){
		if(strstr($v,$url)){
			$rsState = true;
			$rank_json = '{"page":"'.$page.'","rank":"'.++$k.'","keywords":"'.$keyword.'"}';
			echo $rank_json;
			break;
		}
	}
// 	unset($contents);
	if($rsState === false){
		search_rank($keyword, $url,++$page);
	}
}

function curl_rank($url,$timeout=10){
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($curl);
	//$info = curl_getinfo($curl);
	return $data;
}