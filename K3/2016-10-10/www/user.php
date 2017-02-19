<?php
$user = $_GET["user"];
$pass = $_GET["pass"];

if($user=="admin"&&$pass=="123"){
	echo "登录成功";
}else if($user=="eric"&&$pass=="123"){
	echo "登陆成功";
}else{
	echo "用户名或密码错误";
}
?>