<?php
set_time_limit(50);
$url 	  = $_GET['url'];
$keywords = $_GET['keywords'];
$type	  = $_GET['type'];
if($url != '' && $keywords != '' && $type != ''){
	search_rank($keywords,$url,$type);
}

//单关键词排名查询
function search_rank($keyword,$url,$type,$page = 1){
	$type_allow = array('baidu','360','soso','bing');
	if(in_array($type, $type_allow)){
		$rsState = false;
		$endkeyword = urlencode($keyword);
		$firstRow = $page;
		$url_target = '';
		if($page > 10){//10页内无结果
			echo '{"page":"-1","rank":"-1","keywords":"'.$keyword.'"}';
			return false;
		}
		switch(true){
			case $type == 'baidu':
				$firstRow   = ($page - 1) * 10;
				$url_target = "http://www.baidu.com/s?wd=$endkeyword&&pn=$firstRow";
				$pattern    = '/<table[^>]*?class=("result"|"result-op")[^>]*>[\s\S]*?<\/table>/i';
				break;
			case $type == '360':
				$url_target = "http://www.so.com/s?q=$endkeyword&pn=$firstRow";
				$pattern 	= '/<li[^>]*?class="res-list">[\s\S]*?<\/li>/i';
				break;
			case $type == 'soso':
				$url_target = "http://www.soso.com/q?w=$endkeyword&pg=$firstRow";
				$pattern 	= '/<li[^>]*?loc="[\d]{1,2}">[\s\S]*?<\/li>/i';
				break;
			case $type == 'bing':
				$firstRow   = $page*10-9;
				$url_target = "http://cn.bing.com/search?q=$endkeyword&first=$firstRow";
				$pattern    = '/<li[^>]*?class="sa_wr">[\s\S]*?<\/li>/i';
				break;
			default:
				break;
		}
		
		$contents = @curl_rank($url_target);
		if(!$contents){//无响应，超时
			echo '{"page":"-1","rank":"0","keywords":"'.$keyword.'"}';
			return false;
		}
		preg_match_all($pattern,$contents,$rs);		
		foreach($rs[0] as $k=>$v){
			if(strstr($v,$url)){
				$rsState = true;
				$rank_json = '{"page":"'.$page.'","rank":"'.++$k.'","keywords":"'.$keyword.'"}';
				echo $rank_json;
				break;
			}
		}
		if($rsState === false){
			search_rank($keyword,$url,$type,++$page);
		}		
	}else{
		die('Not Allow This!');
	}
}

//页面抓取-curl
function curl_rank($url,$timeout=5){
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);//超时处理
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($curl);
	curl_close($curl);
	return $data;
}