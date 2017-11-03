<?php
header("Content-type:text/html;charset=utf-8");
require_once '../source/core/run.php';
require CHENCY_ROOT.'./source/conf/city.php';
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
	$tag_sql = "SELECT `tag` FROM ".DB_PREFIX."tag WHERE enabled=1 ORDER BY `tagid` DESC";
}else{
	$tag_sql = "SELECT `tag` FROM ".DB_PREFIX."tag ORDER BY `tagid` DESC";
}
$tag_result  = $db->getall($tag_sql);
$tags = '';
foreach ($tag_result as $key => $val) {
	$tags.=$val['tag'].',';
}
$keyword  = rtrim($tags, ',');
$keyarray = explode(',', $keyword);
//600分站
$cityAll = array_merge($city['hot'], $city['list']);

function array_multi2single($array)
{
    //首先定义一个静态数组常量用来保存结果
    static $result_array = array();
    //对多维数组进行循环
    foreach ($array as $value) {
        //判断是否是数组，如果是递归调用方法
        if (is_array($value)) {
            array_multi2single($value);
        } else  //如果不是，将结果放入静态数组常量
            $result_array [] = $value;
    }
    //返回结果（静态数组常量）
    return $result_array;
}
$cityAll = array_multi2single($cityAll);

//查找所有区域名称
$sql    = "SELECT `name` FROM ".DB_PREFIX."region";
$region = $db->getall($sql);
$reg    = '';
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
$str = implode(',', $strArr);


echo $str;


