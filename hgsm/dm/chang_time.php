<?php
header("Content-type:text/html;charset=utf-8");
require '../source/core/run.php';
$type = isset($_GET['type']) ? $_GET['type'] : "product";
$allowtype = array('product','news');
if(!in_array($type,$allowtype)){
   echo "result=false\n";
   die();
}
switch($type)
{
	case 'product':
		product();
		break;
	case 'news':
		news();
		break;
	default:
		break;
}
//计算产品的修改时间
function product(){
	global $db;
	$sql  = "Select MAX(`timeline`) as last_time From ".DB_PREFIX."product Where `flag`=1";
	$lasttime = $db->fetch_first($sql);
	$day      = diff($lasttime['last_time'],time()); 
	echo "result=true\n";
	echo "day=$day\n";
}
//计算新闻的修改时间
function news(){
	global $db;
	$sql  = "Select MAX(`timeline`) as last_time From ".DB_PREFIX."info Where `flag`=1";
	$lasttime = $db->fetch_first($sql);
	$day      = diff($lasttime['last_time'],time()); 
	echo "result=true\n";
	echo "day=$day\n";
}
//计算两个时间相差的天数
function diff($start_time,$end_time){
$timediff = intval($end_time)-intval($start_time);
$timediff = intval($timediff/86400);
return $timediff;
}
?>
