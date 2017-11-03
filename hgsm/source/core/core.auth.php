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
class Core_Auth{
	protected static $obj = NULL;
	public static function auth_checkbox($inputvalue,$checkname,$trnum=5,$width="98%",$css="hback"){
		$temp = $loop = "";
		$vars	= array();
		$vars   = $GLOBALS['AuthVars'];
		$i      =0;
		foreach($vars as $key=>$value){
			$loop = $loop ." <td class='".$css."' width='20%'>";
			$loop = $loop ." <input type='checkbox' name='".$checkname."[]' id='".$checkname."[]' value='".trim($key)."'";
			if(Core_Fun::ischar($inputvalue)){
				if(Core_Fun::foundinarr($inputvalue,trim($key),",")){
					$loop .= " checked";
				}
			}
			$loop .= " /> ".trim($value)."";
			$loop .= " </td>";
			if(($i+1)%($trnum)==0){
				$loop .= "</tr><tr>";
			}
			$i = $i+1;
		}
		$temp  = "<table width=$width border='0' align='left' cellpadding='0' cellspacing='0'>";
		$temp .= "  <tr>";
		$temp .= $loop;
		$temp .= "  </tr>";
		$temp .= "</table>";
		return $temp;
	}
	public static function checkauth($auth){
		self::$obj = $GLOBALS['libadmin'];
		self::$obj->checkauth($auth);
	}
}
?>