<?php
header("Content-type:text/html;charset=utf-8");
require_once '../source/core/run.php';
require_once '../source/conf/tail.php';
global $config;
//查询所有tags
$sql = 'SELECT `tag` FROM '.DB_PREFIX."tag WHERE enabled=1 ORDER BY `tagid` DESC";
$result = $db->getall($sql);
if(empty($result)){
	echo '';
	exit;
}

//查询关键词
$sql = 'SELECT `metakeyword` FROM '.DB_PREFIX."config LIMIT 1";
$keyword = $db->get_one($sql);
if(empty($keyword)){
	echo '';
	exit;
}
$keyword = explode(',', $keyword['metakeyword']);
//$main_key = array_slice($keyword, 0, 3);
if(empty($keyword)){
	echo '';
	exit;
}

$keyword = implode(',', $keyword).',';

foreach($result as $key => $val)
{
	$keyword .= $val['tag'].',';
}

$keyword = explode(',', $keyword);

//查询所有区域名称
$sql = 'SELECT `name` FROM '.DB_PREFIX.'region';
$region = $db->getall($sql);

if(!empty($region))
{
	foreach($keyword as $key=>$val)
	{
		foreach($region as $id=>$city)
		{
			if(($pos = strpos($val, $city['name'])) !== false)
			{
				$keyword[$key] = str_replace($city['name'], '', $val);
				break;
			}
		}
	}
}

//查询长尾词
if(!empty($tailWords))
{
	foreach($keyword as $key=>$valKwd)
	{
		foreach($tailWords as $tailkey=>$tailvalue)
		{
			if(($pos = strpos($valKwd, $tailvalue)) !== false)
			{
				$keyword[$key] = str_replace($tailvalue, '', $valKwd);
				break;
			}
		}
	}
}	

$keyword = array_unique($keyword); //去重

$str = '';
$region_str = '';
$tail_str = '';
$multi_str = '';

foreach($result as $key => $val)
{
	$str .= $val['tag'].',';
}

//区域扩展

if(!empty($region))
{
	foreach($keyword as $key=>$val)
	{
		foreach($region as $name)
		{
			$region_str .= $name['name'] . $val . ',';
		}
	}
}

//长尾词扩展


if(!empty($tailWords))
{
	foreach($tailWords as $tailkey=>$tailvalue)
	{
		foreach($keyword as $key=>$valKwd)
		{
			$tail_str .= $valKwd . $tailvalue . ',';
		}
	}
}

//双重扩展

if (!(empty($region) || empty($tailWords)))
{
	foreach($keyword as $key=>$val)
	{
		foreach($tailWords as $tailkey=>$tailvalue)
		{
			foreach($region as $name)
			{
				$multi_str .= $name['name'] . $val . $tailvalue . ',';
			}
		}
	}
}




$str = rtrim($str.$region_str.$tail_str.$multi_str, ',');
$keyword = explode(',', $str);
$keyword = array_unique($keyword);
$str = implode(",", $keyword);
echo $str;


