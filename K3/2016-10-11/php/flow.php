<?php
$page = $_GET["page"];
$PAGE_SIZE = 10;

mysql_connect("localhost","root","");
mysql_select_db("20161011");
$SQL = "SELECT * FROM tab_flow LIMIT ".$page*$PAGE_SIZE.",".$PAGE_SIZE;
$result = mysql_query($SQL);

$first = true;
$res = "[";
while($row = mysql_fetch_row($result)){
	if($first){
		$res .= "'".$row[0]."'";
	}else{
		$res .= ",'".$row[0]."'";
	}
	$first = false;
}
$res .= "]";
echo $res;
?>










