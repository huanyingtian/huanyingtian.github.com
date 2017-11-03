<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.01
 * @Id         自定义单页
**/
if(!defined('IN_PHPOE')) {
	exit('Access Denied');
}
class Mod_Page{
	private static $obj = NULL;
	private static $tpl = NUll;
	private static $urlpath	= NULL;
	private static $config = array();

	/* 显示分类标签 */
	public static function display(){
		self::$obj = $GLOBALS['db'];
		self::$tpl = $GLOBALS['tpl'];
		$query = "SELECT cid FROM ".DB_PREFIX."pagecate WHERE flag=1 ORDER BY orders ASC";
		$array  = self::$obj->getall($query);
		foreach($array as $key=>$value){
			self::$tpl->assign("page_block".$value['cid'],self::volistblock($value['cid']));
		}
	}
	public static function volistblock($cid){
		self::$obj = $GLOBALS['db'];
		self::$config = $GLOBALS['config'];
		self::$urlpath = PATH_URL;
		$query =  "SELECT v.*,c.cname".
			     " FROM ".DB_PREFIX."page AS v".
			     " LEFT JOIN ".DB_PREFIX."pagecate AS c ON v.cid=c.cid".
			     " WHERE v.cid=".intval($cid)." AND v.flag=1 ORDER BY v.orders ASC";
		$array  = self::$obj->getall($query);
		foreach($array as $key=>$value){
			if(intval($value['linktype'])==2){
				$array[$key]['url'] = $value['linkurl'];
			}else{
				$array[$key]['url'] = self::$urlpath."about".$value['word']."/";
			}
		}
		return $array;
	}

	/*
	  @$Id 列表
	  @params $where    -- 查询条件
	  @params $orderby  -- 排序
	  @params $limitnum -- 显示数量
	*/
	public static function volist($where="",$orderby="",$limitnum=0){
		self::$obj = $GLOBALS['db'];
		self::$tpl = $GLOBALS['tpl'];
		self::$urlpath = PATH_URL;
		self::$config = $GLOBALS['config'];
		$where = Core_Fun::forbidchar($where);
		$orderby = Core_Fun::forbidchar($orderby);
		$query  = "SELECT v.*,c.cname,c.catdir".
			     " FROM ".DB_PREFIX."page AS v".
			     " LEFT JOIN ".DB_PREFIX."pagecate AS c ON v.cid=c.cid".
		         " WHERE v.flag=1";
		if(Core_Fun::ischar($where)){
			// $query .= " ".$where." AND v.depth=1";
			$query .= " ".$where;
		}
		if(Core_Fun::ischar($orderby)){
			$query .= " ".$orderby;
		}else{
			$query .= " ORDER BY v.orders ASC";
		}
		if(intval($limitnum)>0){
			$query .= " LIMIT ".intval($limitnum)."";
		}
		$array = self::$obj->getall($query);
		// print_r($array);die();
		foreach($array as $key=>$value){
		  if($value['img'] == ''){
				$array[$key]['img'] = PATH_URL."static/images/nopic.jpg";
			}else{
				$array[$key]['img'] = PATH_URL.$value['img'];
		  }
		  if($value['linktype'] == 2 && $value['linkurl'] != '')
		  {
		  	$array[$key][url] = $value['linkurl'];
		  }else{
		  	if($value['catdir'] == 'about'){
		  		$array[$key]['url'] = self::$urlpath.'about/'.$value['word'].'.html';
		  	}else{
		  		$array[$key]['url'] = self::$urlpath."about_{$value['catdir']}/{$value['word']}.html";
		  	}
		  	
		  }
		  if($value['target'] == 2){
		  	$array[$key]['target'] = '_blank';
		  }
		}
		// print_r($array);die();
		$array_new_a = array();
		$array_new_b = array();
		$array_new   = array();
		foreach ($array as $k => $val) {
			if($val['depth'] == 1){
				$array_new_a[$k] = $val;

			}
		}
		foreach ($array as $k => $val) {
			if($val['depth'] == 2){
				$array_new_b[$k] = $val;

			}
		}
		foreach ($array_new_a as $key => $value) 
		{
			$array_new[$key] = $value;
			if(!empty($array_new_b))
			{
				foreach ($array_new_b as $ke => $va) 
				{
					if($value['id'] == $va['parentid'])
					{
						$array_new[$key]['chil_cate'][] = $va;
					}
				}
			}
		}
		// print_r($array);exit;
		return $array_new;
	}
	
	public static function page_list(){
		$sql  = "SELECT v.*,c.cname,c.catdir FROM ".DB_PREFIX."page AS v LEFT JOIN ".DB_PREFIX."pagecate AS c ON v.cid=c.cid WHERE v.flag=1 ORDER BY v.orders ASC";
		$array = self::$obj->getall($sql);
		foreach($array as $key=>$value){
			if($value['img'] == ''){
				$array[$key]['img'] = PATH_URL."static/images/nopic.jpg";
			}else{
				$array[$key]['img'] = PATH_URL.$value['img'];
		    }
			if($value['linktype'] == 2 && $value['linkurl'] != ''){
				$array[$key][url] = $value['linkurl'];
			}else{
				if($value['catdir'] == 'about'){
					$array[$key]['url'] = self::$urlpath.'about/'.$value['word'].'.html';
				}else{
					$array[$key]['url'] = self::$urlpath."about_{$value['catdir']}/{$value['word']}.html";
				}
			}
		}
	
		$data = array();
		if(!empty($array)){
			foreach($array as $key=>$val){
				if($val['depth'] == 1){
					$data[$val['catdir']][] = $val;
				}
			}
			foreach ($data as $k => &$val) {
				foreach ($val as $ke => $va) {
				  foreach ($array as $ks => $v) {
					if($v['depth'] ==2){
						if($va['id'] == $v['parentid']){
							$val[$ke]['chil_cate'][] = $v;
						}
					}
				  }
				}
			}
		}
		// print_r($data);die();
		return $data;
	}

	/*
	  @$Id 分类
	  @params $where    -- 查询条件
	  @params $orderby  -- 排序
	  @params $limitnum -- 显示数量
	*/
	public static function category($where="",$orderby="",$limitnum=0){
		self::$obj = $GLOBALS['db'];
		self::$config = $GLOBALS['config'];
		$where = Core_Fun::forbidchar($where);
		$orderby = Core_Fun::forbidchar($orderby);
		$query = "SELECT c.* FROM ".DB_PREFIX."pagecate AS c".
			     " WHERE c.flag=1";
		if(Core_Fun::ischar($where)){
			$query .= " ".$where;
		}
		if(Core_Fun::ischar($orderby)){
			$query .= " ".$orderby;
		}else{
			$query .= " ORDER BY c.orders ASC";
		}
		if(intval($limitnum)>0){
			$query .= " LIMIT ".intval($limitnum)."";
		}
		$array = self::$obj->getall($query);
		return $array;
	}

}
?>