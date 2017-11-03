<?php
require '../source/core/run.php';
require 'water/water.class.php';
require 'admin.inc.php';

$path = 'water/';
$img = new Image($path);
$img->fontfamily = $_POST['fontfamily'];
$img->fontsize = $_POST['fontsize'];
$img->fonttext = $_POST['fonttext'];
$img->fontpot = $_POST['fontpot'];
$img->fontopa = $_POST['fontopa'];
$img->fontcolor = $_POST['fontcolor'];
$imgname = $img->waterMark('20161012.jpg');

echo "<img src='".$path.$imgname.'?a='.mt_rand(10,100)."' />";




















