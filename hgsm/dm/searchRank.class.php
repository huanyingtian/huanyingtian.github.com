<?php

class searchRank
{
	public $keyword;
	public $domain;
	public $rankMap;
	
	public function __construct()
	{
		$this->keyword="";
		$this->domain="";
		$this->rankMap = array();
	}
	
	public function addRankResult($engine, $rank, $page)
	{
		$key = $engine;
		$value = $this->getRankPage($rank, $page);
		$this->rankMap[$key] = $value;
	}
	
	private function getRankPage($rank, $page)
	{
		//return $rank.":".$page;
		$rankpage = array('rank'=>$rank, 'page'=>$page);
		return $rankpage;
	}
}

?>
