<?php
class model_product extends model{
	public function __construct(){
		parent::__construct();
		$this->table = 'product';
	}
	
	//新闻列表
	public function product_list($param = ''){
		global $tpl;
		$total	    = $this->obj->fetch_count('SELECT COUNT(*) FROM '.DB_PREFIX."{$this->table}");
		require M_ROOT.'library/page.php';
		$page = new Page($total,6);
		$where = '';
		if(isset($_GET['cid'])){
			$where = "AND `cid`='{$_GET['cid']}' ";
		}
		$limit = $page->limit;
		$sql		= 'SELECT `id`,`title`,`content`,`thumbfiles`,`timeline`,`flag` FROM '.DB_PREFIX."{$this->table} WHERE `flag` = 1 ".$where.
					  "ORDER BY `orders` DESC , `id` DESC {$limit}";
		$product   	= $this->obj->getall($sql);
		$this->content_change($product);
		return $product;	
	}
	
	//新闻详细
	public function product_detail($param){
		extract($param);
		$navigation = '';
		$id < 1 && die('parameter error!');
		$sql = 'SELECT `id`,`title`,`timeline`,`hits`,`flag`,`content`,`uploadfiles` FROM '.DB_PREFIX."{$this->table} WHERE `flag`= 1 AND ".
				"`id` = '{$id}' LIMIT 1";
		$product = $this->obj->fetch_first($sql);
		if(! $product['uploadfiles']){
			$product['uploadfiles'] = M_URL.'template/images/nopic.jpg';
		}else{
			$product['uploadfiles'] = PATH_URL.$product['uploadfiles'];
		}
		return $product;
	}
	
}