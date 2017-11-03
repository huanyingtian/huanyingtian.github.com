<?php
session_start();
$act  = isset($_GET['act']) ? trim($_GET['act']) : "";
if($act=="verifycode")
{
	require './validationcode.php';
	$code = new Validationcode(100, 36, 4);
	$code->showImage();
	setcookie('verifycode',strtolower($code->getCheckCode()),time()+3600*24,'/'); 
}