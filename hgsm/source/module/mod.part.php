<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.01
 * @Id         其他部分
**/
if(!defined('IN_PHPOE')) {
	exit('Access Denied');
}
class Mod_Part{
	private static $obj = NULL;
	private static $tpl = NUll;
	private static $urlpath	= NULL;
	private static $config = array();

	/*
	  @$Id 在线客服列表
	  @params $where    -- 查询条件
	  @params $orderby  -- 排序
	  @params $limitnum -- 显示数量
	*/
	public static function volist_onlinechat($where="",$orderby="",$limitnum=0){
		self::$obj = $GLOBALS['db'];
		self::$tpl = $GLOBALS['tpl'];
		self::$urlpath = PATH_URL;
		self::$config = $GLOBALS['config'];
		$where = Core_Fun::forbidchar($where);
		$orderby = Core_Fun::forbidchar($orderby);
		$query  = "SELECT v.*".
			     " FROM ".DB_PREFIX."onlinechat AS v".
		         " WHERE v.flag=1";
		if(Core_Fun::ischar($where)){
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
		return $array;
	}

	/*
	  @$Id 文字友情链接
	  @params $where    -- 查询条件
	  @params $orderby  -- 排序
	  @params $limitnum -- 显示数量
	*/
	public static function volist_fontlink($where="",$orderby="",$limitnum=0){
		self::$obj = $GLOBALS['db'];
		self::$tpl = $GLOBALS['tpl'];
		self::$config = $GLOBALS['config'];
		$where   = Core_Fun::forbidchar($where);
		$orderby = Core_Fun::forbidchar($orderby);
		$query  = "SELECT v.*".
			     " FROM ".DB_PREFIX."link AS v".
		         " WHERE v.flag=1 AND linktype=1";
		if(Core_Fun::ischar($where)){
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
		$api      = load::load_class('api','source/model');
		$ssh_data = $api->get_link();
		if ($ssh_data == null)
			$ssh_data = array();
		$data = !empty($ssh_data) ? array_merge($array,$ssh_data) : $array;
		if(!empty($data)){
			foreach($data as $key => $val){
				$data[$key]['linkurl'] = 'http://'.str_replace('http://','',$val['linkurl']);
			}
		}
		return $data;
	}

	/*
	  @$Id LOGO友情链接
	  @params $where    -- 查询条件
	  @params $orderby  -- 排序
	  @params $limitnum -- 显示数量
	*/
	public static function volist_logolink($where="",$orderby="",$limitnum=0){
		self::$obj = $GLOBALS['db'];
		self::$tpl = $GLOBALS['tpl'];
		self::$config = $GLOBALS['config'];
		$where = Core_Fun::forbidchar($where);
		$orderby = Core_Fun::forbidchar($orderby);
		$query  = "SELECT v.*".
			     " FROM ".DB_PREFIX."link AS v".
		         " WHERE v.flag=1 AND linktype=2";
		if(Core_Fun::ischar($where)){
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
		if($array){
			foreach($array as $key=>$val){
				$array[$key]['logoimg'] = PATH_URL.$val['logoimg'];
			}
		}
		return $array;
	}
}
?>