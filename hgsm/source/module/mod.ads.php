<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         广告图片
**/
if(!defined('IN_PHPOE')) {
	exit('Access Denied');
}
class Mod_Ads{
	private static $obj  = NULL;
	private static $tpl  = NUll;
	private static $urlpath = NULL;

	/* 显示广告版位标签 */
	public static function display(){
		self::$obj = $GLOBALS['db'];
		self::$tpl = $GLOBALS['tpl'];

		$query = "SELECT `zoneid`,`slide`,`width`,`height` FROM ".DB_PREFIX."adszone WHERE flag=1 ORDER BY orders ASC";
		$array  = self::$obj->getall($query);
		foreach($array as $key=>$value){
			self::$tpl->assign("zone_silde".$value['zoneid'],$value['slide']);
			self::$tpl->assign("zone_width".$value['zoneid'],$value['width']);
			self::$tpl->assign("zone_height".$value['zoneid'],$value['height']);
			self::$tpl->assign("ads_zone".$value['zoneid'],self::volistblock($value['zoneid']));
		}
	}
	public static function volistblock($cid){
		self::$obj = $GLOBALS['db'];
		self::$urlpath = PATH_URL;
		$query =  "SELECT a.*,z.zonename,z.width,z.height".
			     " FROM ".DB_PREFIX."adsfigure AS a".
			     " LEFT JOIN ".DB_PREFIX."adszone AS z ON a.zoneid=z.zoneid".
			     " WHERE a.zoneid='".intval($cid)."' AND a.flag=1 ORDER BY a.orders ASC";
		$array  = self::$obj->getall($query);
		foreach($array as $key=>$value){
			$array[$key]['uploadfiles'] = self::$urlpath.$value['uploadfiles'];
		}
		return $array;
	}
}
?>