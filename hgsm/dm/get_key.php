<?php
header("Content-type:text/html;charset=utf-8");
require_once '../source/core/run.php';
$city = require CHENCY_ROOT.'./source/conf/city.php';
global $config;

//查询所有tags
$field = "SHOW FULL FIELDS FROM ".DB_PREFIX."tag";
$resul_fiedl = $db->getall($field);
$feilds  = array();
$tag_sql = '';
foreach ($resul_fiedl as $key => $fiel) {
	$feilds[] = $fiel['Field'];
}
if(in_array("enabled", $feilds)){
	$tag_sql="SELECT `tag` FROM ".DB_PREFIX."tag WHERE enabled=1 ORDER BY `tagid` DESC";
}else{
	$tag_sql="SELECT `tag` FROM ".DB_PREFIX."tag ORDER BY `tagid` DESC";
}
$tag_result=$db->getall($tag_sql);
$tags = '';
foreach ($tag_result as $key => $val) {
	$tags.=$val['tag'].',';
}
$keyword  = rtrim($tags, ',');
$keyarray = explode(',', $keyword);
//查找所有区域名称
$sql = "SELECT `name` FROM ".DB_PREFIX."region";
$region = $db->getall($sql);
$reg = '';
//区域分站
function array_multi2single($array)
{
    //首先定义一个静态数组常量用来保存结果
    static $result_array = array();
    //对多维数组进行循环
    foreach ($array as $value) {
        //判断是否是数组，如果是递归调用方法
        if (is_array($value)) {
            array_multi2single($value);
        } else  {//如果不是，将结果放入静态数组常量
            $result_array [] = $value;
        }    
    }
    //返回结果（静态数组常量）
    return $result_array;
}
$cityAll = array_multi2single($city);
foreach ($cityAll as $nums => &$cit) {
	if(($pos = strpos($cit, '地区')) !== false) {
		unset($cityAll[$nums]);
	}
}

//把tags里面的区域去重，并让后台区域与tags匹配
$metakeyword = explode(',', $config['metakeyword']);

if(!empty($region))
{
	foreach ($metakeyword as $key => $value) 
	{
		foreach ($region as $id => $cityn)
		{
			if(($pos = strpos($value,$cityn['name'])) !== false)
			{
				$metakeyword[$key] = str_replace($cityn['name'], '', $value);
				break;
			}
		}
	}
	foreach (array_unique($metakeyword) as $key => $vals) 
	{
		foreach ($cityAll as $keys => $regs) 
		{
			$reg.=$regs.$vals.',';
		}
	}
}
$reg = rtrim($reg, ',');
$regArr = explode(',', $reg);
$strArr = array_unique(array_merge($keyarray,$regArr));
foreach ($strArr as $keys => &$vas) {
	$vas = str_replace(' ', '', $vas);
}
$strone = implode(',', $strArr);
// $keyarray = array_unique($keyarray);
//把tags中开启了关键词的匹配后置关键词
$postwords = $keyarray;
$post_word = $config['tailword'];
if(!empty($post_word)){
  $postarray = explode(',', $post_word);
	$posts = '';
	foreach ($postwords as $key => $val) 
	{
		foreach ($postarray as $post => $postword) 
		{
			if(($postsd = strpos($val, $postword)) !== false)
			{
				$postwords[$key] = str_replace($postword, '', $val);
				break;
			}
		}

	}
	foreach (array_unique($postwords) as $key => $value) 
	{
			foreach ($postarray as $pos => $valpos) 
			{
				$posts.= $value.$valpos.',';
			}
	}
}


//匹配区域与tags匹配
// $matsql  = "SELECT `name` FROM ".DB_PREFIX."matchregion where flag=1";
// $subtion = $db->getall($matsql);
$str='';
$strold='';
// if(!empty($subtion))
// {
// 	foreach ($subtion as $key => $val) 
// 	{
// 		foreach($keyarray as $word => $cit)
// 		{
// 			$strold.= $val['name'].$cit.',';
// 		}
// 	}
// }
$strold    = rtrim($strone.','.$posts, ',');
$str_array = array_unique(explode(',', $strold));
$keywords  = $db->getall("SELECT * FROM ".DB_PREFIX."keywords where flag=1 ORDER BY id DESC");
if($config['w_automatic'] == 1){
	foreach ($str_array as $key => $value) {
		$str.=$value.',';
	}
	foreach ($keywords as $ke_s => $words) {
		$str.=$words['wname'].',';
	}
}elseif ($config['w_automatic'] == 2) {
	foreach ($tag_result as $key => $value) {
		$str.=$value['tag'].',';
	}
	foreach ($keywords as $ke_s => $words) {
		$str.=$words['wname'].',';
	}
}


$arr = '';
$arr_a = Core_Fun::keyword('page','pkeywords');
$arr_b = Core_Fun::keyword('product','pkeywords');
$arr_c = Core_Fun::keyword('productcate','keywords');
$arr_d = Core_Fun::keyword('case','ckeywords');
$arr_e = Core_Fun::keyword('casecate','keywords');
$arr_f = Core_Fun::keyword('download','dkeywords');
$arr_g = Core_Fun::keyword('downloadcate','keywords');
$arr_h = Core_Fun::keyword('info','nkeywords');
$arr_i = Core_Fun::keyword('infocate','keywords');
$arr_j = Core_Fun::keyword('job','jkeywords');
$arr_k = Core_Fun::keyword('jobcate','keywords');

$arr = $arr_a.$arr_b.$arr_c.$arr_d.$arr_e.$arr_f.$arr_g.$arr_h.$arr_i.$arr_j.$arr_k;
$str .= $arr;
$str = rtrim($str, ',');

$str = explode(',', $str);
$str = array_unique($str);
$str = implode(',', $str);

echo $str;


