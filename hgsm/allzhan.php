<?php

function escapeJsonString($value) { 
    $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
}

// 递归转化
function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            arrayRecursive($array[$key], $function, $apply_to_keys_also);
        } else {
            $array[$key] = $function(escapeJsonString($value));
        }
 
        if ($apply_to_keys_also && is_string($key)) {
            $new_key = $function($key);
            if ($new_key != $key) {
                $array[$new_key] = $array[$key];
                unset($array[$key]);
            }
        }
    }
}
 
function JSON($array) 
{
    arrayRecursive($array, 'urlencode', true);
    $json = json_encode($array);
    return urldecode($json);
}


header("Content-type:text/html;charset=utf-8");
define('IN_PHPOE', TRUE);
require './source/conf/db.inc.php';
require './source/conf/config.inc.php';
require './source/core/class.mysql.php';
$db = new chency_mysql;
$db->connect(DB_HOST, DB_USER, DB_PASS, DB_DATA, DB_CHARSET, DB_PCONNECT, true);

$config		= array();
$config_sql = "SELECT * FROM ".DB_PREFIX."config LIMIT 1";
$config     = $db->fetch_first($config_sql);

if(!$config)
{
	echo JSON(array('result' => "配置错误"));
	exit();
}
define('PATH_URL','http://'.$config['siteurl'].PHPOE_ROOT);
$key = $_REQUEST['key'];
if ($key != md5(PATH_URL))
{
	echo JSON(array('result' => "认证错误"));
	exit();
}
//整理要输出的数组$arr
$arr = array();
$arr['result'] = "OK";
$arr['company'] = array();

$sql = "SELECT labelcontent FROM ".DB_PREFIX."delimitlabel WHERE labelname='about'";
$data = $db->getall($sql);
$arr['company']['intro'] = $data[0]['labelcontent'];

$sql = "SELECT labelcontent FROM ".DB_PREFIX."delimitlabel WHERE labelname='contact'";
$data = $db->getall($sql);
$arr['company']['contact'] = $data[0]['labelcontent'];

$sql = "SELECT sitetitle, metadescription, metakeyword FROM ".DB_PREFIX."config";
$data = $db->getall($sql);
$arr['company']['work'] = $data[0]['sitetitle']."#".$data[0]['metadescription']."#".$data[0]['metakeyword'];

$sql = "Describe ".DB_PREFIX."product img_input";
$rels =$db->getall($sql);
if(empty($rels)){
    $sql = "SELECT title, uploadfiles, content, timeline FROM ".DB_PREFIX."product WHERE flag=1 ORDER BY timeline DESC LIMIT 10";
    $arr['products'] = $db->getall($sql);

    foreach ($arr['products'] AS $index => $value)
    {
        $arr['products'][$index]['uploadfiles'] = PATH_URL.$value['uploadfiles'];
        $arr['products'][$index]['content'] = str_replace("\"/data/", "\"".PATH_URL."data/", $value['content']);
    }
}else{
    $sql = "SELECT title, img_input, content, timeline FROM ".DB_PREFIX."product WHERE flag=1 ORDER BY timeline DESC LIMIT 10";
    $arr['products'] = $db->getall($sql);

    foreach ($arr['products'] AS $index => $value)
    {
        $array = explode("#", $value['img_input']);
        $value['uploadfiles'] = $array[0];
        $arr['products'][$index]['uploadfiles'] = PATH_URL."data/images/product/".$value['uploadfiles'];
        $arr['products'][$index]['content'] = str_replace("\"/data/", "\"".PATH_URL."data/", $value['content']);
    }
}

echo JSON($arr);
exit;
