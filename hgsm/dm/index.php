<?php
require '../source/core/run.php';
$name = Core_Fun::get_cookie(PHPOE_COOKIENAME."_ADMINNAME");
$pwd  = Core_Fun::get_cookie(PHPOE_COOKIENAME."_ADMINPASSWORD");
if($name !='' && $pwd !=''){
	Header("Location:admincp.php");
	exit;
}
header("Location:login.php");
?>