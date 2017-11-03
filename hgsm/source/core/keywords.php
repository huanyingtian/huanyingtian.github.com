<?php

$title = $_REQUEST['title'];


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

//获取Config里的关键词
require_once("./run.php");
$sql = 'SELECT `metakeyword` FROM '.DB_PREFIX."config LIMIT 1";
$dbresult = $db->get_one($sql);
if (empty($dbresult['metakeyword'])) //如果没有填写关键词
{
	$answer['result'] = "！请注意，关键词未配置！";
	echo json_encode($answer);
	exit;
}
$keywords = explode(',', rtrim($dbresult['metakeyword'], ',')); //到这里已经有了$keywords数组，每一项对应个关键词
$rank = array();//打分
$sort = array();
foreach($keywords AS $index=>$keyword)
{
	$score = Calc($keyword, $title) / strlen($keyword);
	$rank[] = array
	(
		'word' => $keyword,
		'score' => $score
	);
	$sort[] = $score;
}

array_multisort($sort, SORT_DESC, $rank);

$answer['result'] = $rank[0]['word'];
echo json_encode($answer);
exit;






































