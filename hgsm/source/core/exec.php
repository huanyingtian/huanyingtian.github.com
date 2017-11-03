<?php
require '../model/api.class.php';
$api = new api();
if (isset($_POST['exec']) && !empty($_POST['exec']))
{
	echo $api->delCache($_POST['exec']);
}
else
{
	echo 0;
}