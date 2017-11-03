<?php
/*
Author: Xu Jin [http://xyu-future.github.io]
*/
//////////////////////////////////////////function definition/////////////////////////////////////////////////////////////
function wzDebug($var)
{
	echo("<pre>");
	print_r($var);
	echo("</pre>");
	exit();
}

//algorithms
function LCS(&$memo, &$stra, &$strb, $idxa, $idxb) //理论上php是支持COW的
{
	if (($idxa==0) || ($idxb==0))
	{
		$memo[$idxa][$idxb] = 0;
		return 0;
	}
	else if (isset($memo[$idxa][$idxb]))
	{
		return $memo[$idxa][$idxb];
	}
	else if ($stra[$idxa-1] == $strb[$idxb-1])
	{
		 $memo[$idxa][$idxb] = LCS($memo, $stra, $strb, $idxa-1, $idxb-1) + 1;
		 return $memo[$idxa][$idxb];
	}
	else
	{
		 $memo[$idxa][$idxb] = max(LCS($memo, $stra, $strb, $idxa, $idxb-1), LCS($memo, $stra, $strb, $idxa-1, $idxb));
		 return $memo[$idxa][$idxb];
	}
}

function Calc($s1, $s2)
{
	$memo = array();
	$ret = LCS($memo, $s1, $s2, strlen($s1), strlen($s2));
	return $ret;
}
//end algorithms
/**********************************************************************************************************************/

//////////////////////////////////////////////main program//////////////////////////////////////////////////////////////
require '../source/core/run.php';

$sql = 'SELECT metakeyword FROM '.DB_PREFIX."config LIMIT 1";
$dbResult = $db->get_one($sql);
if (empty($dbResult['metakeyword']))
{
	$keywords = array();
}
else
{
	$keywords = explode(',', $dbResult['metakeyword']);
}

$sql = 'SELECT cname FROM '.DB_PREFIX."productcate WHERE flag=1 AND taggu=1";
$dbResult = $db->getall($sql);

foreach ($dbResult as $key => $value)
{
	$keywords[] = $value['cname'];
}

$sql = 'SELECT id,title,tag FROM '.DB_PREFIX."product";
$dbResult = $db->getall($sql);

foreach ($dbResult as $key => $value)
{
	$maxScore = 0;
	$maxKey = '';
	foreach($keywords AS $index=>$keyword)
	{
		$score = Calc($keyword, $value['title']) / strlen($keyword);
		if ($score > $maxScore)
		{
			$maxScore = $score;
			$maxKey = $keyword;
		}
	}
	if(empty($value['tag']))
	{
	    $sql = 'UPDATE '.DB_PREFIX.'product SET tag='."'".$maxKey."'".' WHERE id='.$value['id'];
	    $db->query($sql);
	}

}

$sql = 'SELECT id, title, tag FROM '.DB_PREFIX."info";
$dbResult = $db->getall($sql);
foreach ($dbResult as $key => $value)
{
	$maxScore = 0;
	$maxKey = '';
	if(empty($value['tag'])){
		foreach($keywords AS $index=>$keyword)
		{
			$score = Calc($keyword, $value['title']) / strlen($keyword);
			if ($score > $maxScore)
			{
				$maxScore = $score;
				$maxKey   = $keyword;
			}
		}
		$sql = 'UPDATE '.DB_PREFIX.'info SET tag='."'".$maxKey."'".' WHERE id='.$value['id'];
		$db->query($sql);
	}
}

$sql = 'SELECT id, title FROM '.DB_PREFIX."case";
$dbResult = $db->getall($sql);

foreach ($dbResult as $key => $value)
{
	$maxScore = 0;
	$maxKey = '';
	foreach($keywords AS $index=>$keyword)
	{
		$score = Calc($keyword, $value['title']) / strlen($keyword);
		if ($score > $maxScore)
		{
			$maxScore = $score;
			$maxKey = $keyword;
		}
	}
	$sql = 'UPDATE '.DB_PREFIX.'case SET tag='."'".$maxKey."'".' WHERE id='.$value['id'];
	$db->query($sql);
}

msg::msge("标签生成完成！");


exit;

