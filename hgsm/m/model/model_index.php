<?php
class mode_lndex extends model{
	public function __construct(){
		parent::__construct();
	}
	
	public function sp(){
		$sql    = "Select * From ".DB_PREFIX."sp";
		$result = $this->obj->getall($sql);
		$sp = array();
		foreach($result as $list){
			$np        = $list['np'];
			$recommend = $list['recommend'];
			$isnew     = $list['isnew'];
			$num       = $list['num'];
			$cateid    = $list['cateid'];
			$splabel   = $list['splabel'];
			$orders    = $list['orders'];
			$sql = '';
			$where = " a.flag = '1'";
			$sort = 'DESC';
			if($orders == 1){
				$sort = 'ASC';
			}
			$c_table ='product';  //主要是为了适应content_change方法
			$orders = " ORDER BY a.timeline ".$sort;
			if($np == 1){
				$table     = 'product';
				$catetable = 'productcate';
			}elseif($np == 2){
				$table     = 'info';
				$catetable = 'infocate';
				$c_table   = 'news';  //主要是为了适应content_change方法，后期统一为news;
			}elseif($np == 3){
				$table     = 'case';
				$catetable = 'casecate';
				$c_table   = 'case';  //主要是为了适应content_change方法，后期统一为news;
			}else{
				die('碎片参数错误！');
			}
			$sql = "Select a.*,b.cname,b.word From ".DB_PREFIX.$table." As a Left Join ".DB_PREFIX.$catetable." As b On a.cid=b.cid Where ";
			if(($recommend==1) && ($isnew == 1)){
				die('碎片参数错误！');
			}
			if($recommend == 1){
				$where .= " AND a.elite='1'";
				if($np == 1){
					$orders = "ORDER BY a.elite_orders ".$sort;
				}
			}elseif($isnew == 1){
				$where .= " AND a.isnew='1'";
				if($np ==1){
					$orders = "ORDER BY a.isnew_orders ".$sort;
				}
			}
			if($cateid > 0){
				$where .= " AND a.cid='".$cateid."'";
			}
			$where .=' '.$orders;
			if($num > 0){
				$where .= " LIMIT ".intval($num);
			}
			$sql .= $where;
			$sp[$splabel] = $this->obj->getall($sql);
			$this->table = $c_table;
			$this->content_change($sp[$splabel]);
		}
	return $sp;
  }
  

  
  
} 
















































