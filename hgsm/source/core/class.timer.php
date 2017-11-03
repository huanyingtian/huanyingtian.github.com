<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XiangYun v1.0
 * @Update     2012.07.07
**/
if(!defined('IN_PHPOE')) {
	exit('Access Denied');
}
class Core_Timer{ 
    public static $_starttime;
    public static $_stoptime;
    public static $_spendtime;

    public static function getmicrotime()
	{
        list($usec,$sec)=explode(" ",microtime());
        return ((float)$usec + (float)$sec);
	}

	public static function start()
	{
		self::$_starttime = self::getmicrotime();
	}

    public static function display(){
		self::$_stoptime = self::getmicrotime();
		self::$_spendtime = self::$_stoptime-self::$_starttime;
        return round(self::$_spendtime,4);
	}
}
?>