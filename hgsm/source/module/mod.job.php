<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         人才招聘
**/
if(!defined('IN_PHPOE')) {
	exit('Access Denied');
}
class Mod_Job{
	private static $obj = NULL;
	private static $tpl = NUll;
	private static $urlpath = NULL;
	private static $config = array();

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
		$query  = "SELECT v.*,c.cname,c.target,c.linktype,c.linkurl".
			     " FROM ".DB_PREFIX."job AS v".
			     " LEFT JOIN ".DB_PREFIX."jobcate AS c ON v.cid=c.cid".
		         " WHERE v.flag=1";
		if(Core_Fun::ischar($where)){
			$query .= " ".$where;
		}
		if(Core_Fun::ischar($orderby)){
			$query .= " ".$orderby;
		}else{
			$query .= " ORDER BY v.id DESC";
		}
		if(intval($limitnum)>0){
			$query .= " LIMIT ".intval($limitnum)."";
		}else{
			$query .= " LIMIT 8";
		}
		$array = self::$obj->getall($query);
		foreach($array as $key=>$value){
			$array[$key]['url'] = self::$urlpath."job/".$value['id'].".html";
			$array[$key]['caturl'] = self::$urlpath."job/".$value['cid'].'/';
			if(intval($value['linktype'])==2){
				$array[$key]['caturl'] = $value['linkurl'];
			}
			if(intval($value['target'])==2){
				$array[$key]['target'] = "_blank";
			}else{
				$array[$key]['target'] = "_self";
			}
		}
		return $array;
	}

	/*
	  @$Id 一级分类
	  @params $where    -- 查询条件
	  @params $orderby  -- 排序
	  @params $limitnum -- 显示数量
	*/
	public static function category($where="",$orderby="",$limitnum=0){
		self::$obj = $GLOBALS['db'];
		self::$config = $GLOBALS['config'];
		self::$urlpath = PATH_URL;
		$where = Core_Fun::forbidchar($where);
		$orderby = Core_Fun::forbidchar($orderby);
		$query = "SELECT c.* FROM ".DB_PREFIX."jobcate AS c".
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
		foreach($array as $key=>$value){
			if(intval($value['linktype'])==2){
				$array[$key]['url'] = $value['linkurl'];
			}else{
				$array[$key]['url'] = self::$urlpath."job/".$value['cid']."/";
			}
			if(intval($value['target'])==2){
				$array[$key]['target'] = "_blank";
			}
		}
		return $array;
	}

	/* 上一个 */
	public static function previousitem($id){
		self::$obj = $GLOBALS['db'];
		self::$config = $GLOBALS['config'];
		self::$urlpath = PATH_URL;
		$var = $GLOBALS['LANVAR'];
		$temp  = "";
		if(Core_Fun::isnumber($id)){
			$id = intval($id);
			$query = "SELECT id,title FROM ".DB_PREFIX."job WHERE id<$id".
					 " ORDER BY id DESC LIMIT 1";
			$rows  = self::$obj->fetch_first($query);
			if($rows){
				$temp= '<a href="'.self::$urlpath.'job/'.$rows['id'].'.html">'.$rows['title'].'</a>';
			}else{
				$temp = $var['no'];
			}
		}
		return $temp;
	}

	/* 下一个 */
	public static function nextitem($id){
		self::$obj = $GLOBALS['db'];
		self::$config = $GLOBALS['config'];
		self::$urlpath = PATH_URL;
		$var = $GLOBALS['LANVAR'];
		$temp  = "";
		if(Core_Fun::isnumber($id)){
			$id = intval($id);
			$query = "SELECT id,title FROM ".DB_PREFIX."job WHERE id>$id".
					 " ORDER BY id ASC LIMIT 1";
			$rows  = self::$obj->fetch_first($query);
			if($rows){
				$temp = '<a href="'.self::$urlpath.'job/'.$rows['id'].'.html">'.$rows['title'].'</a>';
			}else{
				$temp = $var['no'];
			}
		}
		return $temp;
	}

}
?>