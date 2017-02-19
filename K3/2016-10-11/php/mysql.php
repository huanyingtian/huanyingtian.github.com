<?php
//1.建立连接
//mysql_connect(数据库地址,用户名,密码);
mysql_connect("localhost","root","");
//2.选择数据库
//mysql_select_db(数据库名);
mysql_select_db("20161011");
//3.执行SQL语句
$SQL = "SELECT * FROM tab_user";
$result = mysql_query($SQL);
//4.遍历数据
$row = mysql_fetch_row($result);
echo $row[0].','.$row[1].'<br />';
$row = mysql_fetch_row($result);
echo $row[0].','.$row[1];
?>












