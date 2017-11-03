<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
**/
if(!defined('ALLOWGUEST')) {
	exit('Access Denied');
}
//ini_set("display_errors","On");
/* 首页显示询盘条数 */
$sql = "SELECT COUNT(id) FROM .".DB_PREFIX."guestbook WHERE `isread`='0'";
$count = $db->fetch_count($sql);

$region_all = $region->allRegion();
foreach($region_all as $key=>$val){
	$region_all[$key]['url'] = PATH_URL."{$val['en']}.html";
}
//echo("<pre>");
//print_r($region_all);
//print_r($city_one);
//echo("</pre>");
/* 标题 */
if(!$config['sitetitle']){
	$page_title = $config['sitename'];
}else{
	$page_title = $config['sitetitle'];
}

if(is_array($city_one)){
	if(!empty($config['sitetitle'])){
		if(($pos = strpos($config['sitetitle'], '_')) !==false){
				$start = strrpos($config['sitetitle'],'-');
				$title = substr($config['sitetitle'],0,$start);
				$title_arr = explode('_',$title);
				function region_filter($region, &$arr){
					if(!empty($region) && !empty($arr)){
						foreach ($arr as $key=>$val){
							foreach($region as $id=>$city){
								if(($pos = strpos($val, $city['name'])) !== false){
									$arr[$key] = str_replace($city['name'], '', $val);
									break;
								}
							}
						}
					}
				}
				region_filter($region_all, $title_arr);
				foreach($title_arr as $key=>$val){
					$title_arr[$key] = $city_one['name'].$val;
				}
				$title = implode('_',$title_arr);
				$page_title = $title.substr($config['sitetitle'],$start);
		}elseif (($pos = strpos($config['sitetitle'], ',')) !==false) {
				$start = strrpos($config['sitetitle'],',');
				$title = substr($config['sitetitle'],0,$start);
				$title_arr = explode(',',$title);

				function region_filter($region, &$arr){
					if(!empty($region) && !empty($arr)){
						foreach ($arr as $key=>$val){
							foreach($region as $id=>$city){
								if(($pos = strpos($val, $city['name'])) !== false){
									$arr[$key] = str_replace($city['name'], '', $val);
									break;
								}
							}
						}
					}
				}
				region_filter($region_all, $title_arr);
				
				foreach($title_arr as $key=>$val){
					$title_arr[$key] = $city_one['name'].$val;
				}
				$title = implode(',',$title_arr);
				$page_title = $title.substr($config['sitetitle'],$start);
		}

	}

	$keywordArray = explode(',',$config['metakeyword']);
	region_filter($region_all, $keywordArray);
	
	if(!empty($keywordArray))
	{
		foreach($keywordArray as $key=>$val)
		{
			$keywordArray[$key] = $city_one['name'].$val;
		}
	}
	$keyword = implode(',',$keywordArray);

}
$keyword = (isset($keyword) && $keyword) ? $keyword :$config['metakeyword'];
$keyword =$keyword.','.$config['sitename'];
// $tpl->assign('regions',$region_all);
$tpl->assign("count",$count);
$tpl->assign("page_title",$page_title);
$tpl->assign("page_description",$config['metadescription']);
$tpl->assign("page_keyword",$keyword);
?>