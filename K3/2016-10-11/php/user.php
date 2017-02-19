<?php
$act = $_GET["act"];
$user = $_GET["user"];
$pass = $_GET["pass"];
switch($act){
	case "login":
		/*
			1.查看是否有此用户
			2.比较密码
		*/
		mysql_connect("localhost","root","");
		mysql_select_db("20161011");
		$SQL = "SELECT * FROM tab_user WHERE username='".$user."'";
		$result = mysql_query($SQL);
		$row = mysql_fetch_row($result);
		if($row){
			if($row[1]==$pass){
				echo "{\"err\":0,\"msg\":\"登录成功\"}";
			}else{
				echo "{\"err\":1,\"msg\":\"用户名或密码有误\"}";
			}
		}else{
			echo "{\"err\":1,\"msg\":\"此用户未注册\"}";
		}
		break;
	case "add":
		/*
			1.查找数据库有没有此用户
			2.插入
		*/
		mysql_connect("localhost","root","");
		mysql_select_db("20161011");
		$SQL = "SELECT * FROM tab_user WHERE username='".$user."'";
		$result = mysql_query($SQL);
		$row = mysql_fetch_row($result);
		if($row){
			echo "{\"err\":1,\"msg\":\"此用户名已被占用\"}";
		}else{
			$SQL2 = "INSERT INTO tab_user VALUES('".$user."','".$pass."')";
			mysql_query($SQL2);
			echo "{\"err\":0,\"msg\":\"注册成功\"}";
		}
		break;
	default:
		break;
}
?>













