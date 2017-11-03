<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         自定义HTML标签
**/
if(!defined('IN_PHPOE')) {
	exit('Access Denied');
}
class Mod_Delimit{
	private static $obj = NULL;
	private static $tpl = NULL;
	private static $skinid = NULL;
	/* 显示HTML标签 */
	public static function display(){
		self::$obj = $GLOBALS['db'];
		self::$tpl = $GLOBALS['tpl'];
		self::$skinid = $GLOBALS['core_skin']['skinid'];
		if(!Core_Fun::isnumber(self::$skinid)){
			self::$skinid = 1;
		}
		$query = "SELECT labelid,labelname,labelcontent FROM ".DB_PREFIX."delimitlabel".
			    " WHERE flag=1 AND skinid=".self::$skinid." ORDER BY labelid ASC";
		$array  = self::$obj->getall($query);
		foreach($array as $key=>$value){
			self::$tpl->assign("delimit_".$value['labelname'],$value['labelcontent']);
		}
	}
}
?>