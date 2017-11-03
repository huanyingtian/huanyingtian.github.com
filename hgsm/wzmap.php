<?php
//head
header("Content-type:text/xml;charset=utf-8");

function _Compose($addr, $utime, $prior)
{
	echo("<url>");
	echo("<loc>");
	echo($addr);
	echo("</loc>");
	echo("<lastmod>");
	echo(date("Y-m-j G:i:s", $utime));
	echo("</lastmod>");
	echo("<priority>");
	echo($prior);
	echo("</priority>");
	echo("</url>");
}

echo('<?xml version="1.0" encoding="UTF-8"?>');
echo('<urlset'.
		' xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"'.
		' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'.
		' xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">');
//main
define('IN_PHPOE', TRUE);
require './source/conf/db.inc.php';
require './source/conf/config.inc.php';
require './source/core/class.mysql.php';
$db = new chency_mysql;
$db->connect(DB_HOST, DB_USER, DB_PASS, DB_DATA, DB_CHARSET, DB_PCONNECT, true);

$config		= array();
$config_sql = "SELECT * FROM ".DB_PREFIX."config LIMIT 1";
$config     = $db->fetch_first($config_sql);
if(!$config){
	echo "Config Error！";
	die();
}
define('PATH_URL','http://'.$config['siteurl'].PHPOE_ROOT);


$sqlCommand = "SELECT id, timeline FROM ".DB_PREFIX."product WHERE flag=1 ORDER BY timeline DESC LIMIT 500";
$sqlResult = $db->getall($sqlCommand);
$productLastUpdateTime = 0;
$productArray = array();
if (count($sqlResult) > 0)
{
	$productLastUpdateTime = $sqlResult[0]['timeline'];
	$productArray = $sqlResult;
}

$sqlCommand = "SELECT id, timeline FROM ".DB_PREFIX."info WHERE flag=1 ORDER BY timeline DESC LIMIT 500";
$sqlResult = $db->getall($sqlCommand);
$newsLastUpdateTime = 0;
$newsArray = array();
if (count($sqlResult) > 0)
{
	$newsLastUpdateTime = $sqlResult[0]['timeline'];
	$newsArray = $sqlResult;
}

$indexLastUpdateTime = ($productLastUpdateTime > $newsLastUpdateTime) ? $productLastUpdateTime : $newsLastUpdateTime;

///index
_Compose(PATH_URL, $indexLastUpdateTime, '1.0');

///about
_Compose(PATH_URL.'about/', $indexLastUpdateTime, '0.8');

///product
_Compose(PATH_URL.'product/', $productLastUpdateTime, '0.8');

//news
_Compose(PATH_URL.'news/', $newsLastUpdateTime, '0.8');


//50 pro
foreach($productArray AS $key => $product)
{
	_Compose(PATH_URL.'product/'.$product['id'].'.html', $product['timeline'], '0.64');
}

//50 news
foreach($newsArray AS $key => $news)
{
	_Compose(PATH_URL.'news/'.$news['id'].'.html', $news['timeline'], '0.64');
}


//end
echo("</urlset>");