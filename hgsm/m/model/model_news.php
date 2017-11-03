<?php
class model_news extends model{
	public function __construct(){
		parent::__construct();
		$this->table = 'info';
	}
	
	//新闻列表
	public function news_list(){
		global $tpl;
		$cid = isset($_GET['cid']) ? intval($_GET['cid']) : '';
		$where = '';
		if($cid){
			$total	= $this->obj->fetch_count('SELECT COUNT(*) FROM '.DB_PREFIX."{$this->table} WHERE `cid`='{$cid}'");
			$where .= "AND `cid`='{$cid}' ";
		}else{
			$total	= $this->obj->fetch_count('SELECT COUNT(*) FROM '.DB_PREFIX."{$this->table}");
		}
		require M_ROOT.'library/page.php';
		$page = new Page($total,5);
		$limit = $page->limit;
		$page->setPrefix($cid ? "news/$cid/" : 'news/');
		$sql		= 'SELECT `id`,`title`,`content`,`timeline`,`flag` FROM '.DB_PREFIX."{$this->table} WHERE `flag` = 1 " . $where .
					  "ORDER BY id DESC {$limit}";
		$news   	= $this->obj->getall($sql);
		$this->content_change($news);
		return $news;	
	}
	
	//新闻详细
	public function news_detail($param){
		extract($param);
		$navigation = '';
		$id < 1 && die('parameter error!');
		$sql = 'SELECT `id`,`title`,`timeline`,`flag`,`content` FROM '.DB_PREFIX."{$this->table} WHERE `flag`= 1 AND ".
				"`id` = '{$id}' LIMIT 1";
		$news = $this->obj->fetch_first($sql);
		return $news;
	}
	
}