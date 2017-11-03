<?php
define('M_ROOT', CHENCY_ROOT."m/");
define('M_TEMPLATE', CHENCY_ROOT."m/template/");
define('M_URL',PHPOE_ROOT."m/");
define('M_PATH',PATH_URL."m/template/");
$host = strtolower(rtrim(str_replace('http://', '', $_SERVER['HTTP_HOST']), '/'));
if ($config['murl'] == $host) {
	define('M_PATH_URL','http://'.$host.'/');
} else {
	define('M_PATH_URL',PATH_URL.'m/');
}
if (!empty($config['murl']) && $config['murl'] != $host) {
	header("Location: http://".$config['murl']."/");
}