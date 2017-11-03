<?php

$region = new region();
if(isset($_GET['city']))
{
	$city_one = $region->regionEnSearch(strtolower(trim($_GET['city'])));
	$city_one || exit('This region is not found! ');
}

//推荐、新闻或者某一分类的产品和新闻调用（产品或者新闻单独模块的调用，具体内容需要后台添加）
$sql_tag  ="SELECT `tag` FROM ".DB_PREFIX."tag WHERE char_length(tag) < 10 and enabled=1 order by rand() limit 12";
$results = $db->getall($sql_tag);
foreach ($results as $key => $val) {
	$results[$key]['url']= PATH_URL.'search.php?wd='.$val['tag'];
}
$sql    = "Select * From ".DB_PREFIX."sp";
$result = $db->getall($sql);
$sp = array();
// $xin=array();
foreach($result as $list){
	$np        = $list['np'];
	$recommend = $list['recommend'];
	$isnew     = $list['isnew'];
	$num       = $list['num'];
	$cateid    = $list['cateid'];
	$splabel   = $list['splabel'];
	$orders    = $list['orders'];
	$sql = '';
	$where = " v.flag = '1'";
	$sort = 'DESC';
	if($orders == 1){
		$sort = 'ASC';
	}
	$c_table ='product';  //主要是为了适应content_change方法
	$orders = " ORDER BY v.orders ".$sort;
	if($np == 2){
		$orders = " ORDER BY v.timeline ".$sort;
	}
	if($np == 1){
		$table     = 'product';
		$catetable = 'productcate';
	}elseif($np == 2){
		$table     = 'info';
		$catetable = 'infocate';
		$c_table   = 'news';  //主要是为了适应content_change方法，后期统一为news;
	}
	else if ($np == 3)
	{
		$table     = 'case';
		$catetable = 'casecate';
		$c_table   = 'case';  //主要是为了适应content_change方法，后期统一为case;
	}
	else{
		die('碎片参数错误！');
	}
	$sql = "Select v.*,c.cname,c.word From ".DB_PREFIX.$table." As v Left Join ".DB_PREFIX.$catetable." As c On v.cid=c.cid Where ";
	if(($recommend==1) && ($isnew == 1)){
		die('碎片参数错误！');
	}
	if($recommend == 1){
		$where .= " AND v.elite='1'";
		if($np == 1){
			$orders = "ORDER BY v.elite_orders ".$sort;
		}elseif($np == 3)
		{
			$orders = "ORDER BY v.orders ".$sort;
		}
	}elseif($isnew == 1){
		$where .= " AND v.isnew='1'";
		if($np ==1){
			$orders = "ORDER BY v.isnew_orders ".$sort;
		}
	}else{
		if($np == 3){
			$orders = "ORDER BY v.orders ".$sort;
		}
	}
	if($cateid > 0)
	{
		$childs_sql = Core_Mod::build_childsql($catetable, "v", intval($cateid), "");
		if (Core_Fun::ischar($childs_sql))
		{
			$where .= " AND (v.cid='".intval($cateid)."'".$childs_sql.")";
		}
		else
		{
			$where .= " AND v.cid='".intval($cateid)."'";
		}
		//$where .= " AND v.cid='".$cateid."'";
	}
	$where .=' '.$orders;
	if($num > 0){
		$where .= " LIMIT ".intval($num);
	}
	$sql .= $where;
	$sp[$splabel] = $db->getall($sql);

	// if($c_table=='product'){

	// 	foreach($sp[$splabel] as $key=>$value)
	// 	{
	// 		if(is_array($GLOBALS['city_one']))
	// 		{   echo("sdfsd");
	// 			$sp[$splabel][$key]['title'] = $GLOBALS['city_one']['name'].$value['title'];
	// 			$sp[$splabel][$key]['url'] = PATH_URL."product/{$GLOBALS['city_one']['en']}_{$value['id']}.html";
	// 			$sp[$splabel][$key]['caturl'] = PATH_URL."product/{$GLOBALS['city_one']['en']}_{$value['word']}/";
	// 		}
	// 		else
	// 		{
	// 			$sp[$splabel][$key]['url'] = PATH_URL."product/{$value['id']}.html";
	// 			$sp[$splabel][$key]['caturl'] = PATH_URL."product/{$value['word']}/";
	// 		}
	// 	}
	// }
	Mod_Url::content_change($sp[$splabel],$c_table);
}
// Mod_Url::content_change($sp['recommend_product'],'product');
// print_r($sp['recommend_product']);die();
// echo($GLOBALS['city_one']);die();
if($config['translate'] == 1){
	$translate  = require CHENCY_ROOT.'./source/conf/translate.php';
	$sqls = "SELECT * FROM ".DB_PREFIX."translate";
	$rels = $db->fetch_first($sqls);
	$name = json2array($rels['name']);
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $i = 0;
    $tran_arr = array();
    foreach ($name as $kn => &$vln) {
    	foreach ($translate as $kc => $vlc) {
    		if($vln == $kc){
    			$tran_arr[$i]['en']  = $vln;
    			$tran_arr[$i]['cn']  = $vlc;
    			$tran_arr[$i]['url'] = "http://fanyi.baidu.com/transpage?query=".$url."&from=auto&to=".$vln."&source=url&render=1";
    		}
    	}
    	$i++;
    }
    $tpl->assign('tran_arr',$tran_arr);
}




/**
 * 将数组转换为json字符串
 */
function array2json($data) 
{
	transcode($data);
	if($data == '' || !is_array($data)) return '';	
	return urldecode(json_encode($data));
}

/**
 * 将json字符串转换为数组
 */
function json2array($data) 
{
	if($data == '' || !is_string($data)) return array();
	$data = str_replace("\\", '\\\\', $data);
	$data = str_replace("\r\n", '\n', $data);
	$data = str_replace("\n", '\n', $data);
	$data = json_decode($data, true);
	return $data;
}


/**
 * 中文编码,防止中文json后被过滤
 * str 字符串或者数组
 */
function transcode(&$str) {
	if(!empty($str)){
		if(is_array($str)){
			foreach ($str as $key => $val) {
				transcode($str[$key]);
			}
		}else{
			$str = urlencode($str);
		}
	}
}

$region_all = $region->allRegion();
foreach($region_all as $key=>$val){
	$region_all[$key]['url'] = PATH_URL."{$val['en']}.html";
}
$region_all = array_slice($region_all, 0, 10);
// print_r($region_all);exit;
$tpl->assign('regions',$region_all);
$tpl->assign('results',$results);
$tpl->assign('sp',$sp);